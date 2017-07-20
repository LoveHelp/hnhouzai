<?php
include_once dirname(__FILE__).'/log.php';
class mysql
{
    // pdo link
    protected $link = null;
    //pdo statement
    protected $stmt = null;
    //log
    public $log = null;

    /**
	初始化pdo连接
	*/
    public function __construct()
    {
		/*
        $host         ='rm-bp1pf2xe0mcxy591m.mysql.rds.aliyuncs.com';
        $port         = '3306';
        $user         = 'r0ecx12s4k';
        $password     = 'Houzai123!@#';
        $dbname       = 'r0ecx12s4k';
        $charset      = 'utf8';
		*/
        $host         ='192.168.16.99';
        $port         = '3306';
        $user         = 'admin';
        $password     = 'CrZQV7Q48aDuca4F';
        $dbname       = 'hnhouzai';
        $charset      = 'utf8';
        $this->log = Log::getInstance();
        $dns = "mysql:host=$host:$port; dbname=$dbname";
        try {
            $this->link = new PDO($dns, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$this->link->setAttribute(PDO::ATTR_PERSISTENT, true);//长连接
            $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果，达到防止注入目的
            $this->link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			} catch (PDOException $e) {
            $this->log->msg($e->getMessage());
            return null;
        }
    }

    /**
     * 关闭连接
     */
    public function closelink()
    {
        $this->stmt = null;
        $this->link = null;
    }

    /**
     * execute sql statement
     * @param  $sql    sql statement
     * @param  $param  parameter list
     * @return $result if success, return resources; if failed, return error message and exit
     */
    public function query($sql, $param = array())
    {
        // write sql statement into log
        $this->log->sql($sql, $param);
        $this->stmt = null;
        try {
            $this->stmt = $this->link->prepare($sql);
            if (empty($param)) {
                $res = $this->stmt->execute();
            } else {
                $res = $this->stmt->execute($param);
            }

            if (!$res) {
            	$errCode = $this->stmt->errorCode();
            	$errInfo = $this->stmt->errorInfo();
            	$this->log->err($errorCode, $errorInfo);
            }

            return $res;
        } catch (Exception $e) {
            $this->log->msg($e->getMessage());
            return false;
        }
    }

    /**
     * 插入
     */
    public function insert($sql, $param=array())
    {
        try{
            $this->log->sql($sql, $param);
            $this->stmt = $this->link->prepare($sql);
            $res = $this->stmt->execute($param);
            if (!$res) {
                $errCode = $this->stmt->errorCode();
                $errInfo = $this->stmt->errorInfo();
                $this->log->err($errorCode, $errorInfo);
                return 0;
            } else {
                $lasInsertId = $this->link->lastInsertId();
                $this->log->msg('last insert id: '. $lasInsertId);
                return $lasInsertId;//返回插入数据的ID
            }
        } catch (Exception $e){
            $this->log->msg($e->getMessage());
            return 0;
        }
    }

    /**
     * 更新
     */
    public function update($sql, $param=array())
    {
        try{
            $this->log->sql($sql, $param);
            $this->stmt = $this->link->prepare($sql);
            $res = $this->stmt->execute($param);
            if (!$res) {
                $errCode = $this->stmt->errorCode();
                $errInfo = $this->stmt->errorInfo();
                $this->log->err($errorCode, $errorInfo);
                return 0;
            } else {
                $rowCount = $this->stmt->rowCount();
                $this->log->msg('effect rows: '. $rowCount);
                return $rowCount; //返回更新影响的行数
            }
        } catch (Exception $e){
            $this->log->msg($e->getMessage());
            return 0;
        } 
    }

    /**
     * 查询多条记录,返回查询结果
     */
    public function getAll($sql, $param = array())
    {
        $count=0;
        $res = $this->query($sql, $param);
        if ($res) {
            $data=array();
            while ($row = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
                $count = $count + 1;
            } 
            $this->log->msg("select count: " . $count);
            return $data;
        } 
        return 0;
    }

    /**
	 * 查询并返回首条记录的首列,返回查询结果
	 */
    public function getFirst($sql, $param = array())
    {
        $res = $this->query($sql, $param);
        if ($res) {
            if ($row = $this->stmt->fetch(PDO::FETCH_NUM)) {
                return $row[0];
            }
        }
        return 0;
    }

    /**
     * 查询一条记录,返回查询结果
     */
    public function getRow($sql, $param = array())
    {
        $res = $this->query($sql, $param);
        if ($res) {
            $row = $this->stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        return 0;
    }

    /**
     * transaction begin
     */
    public function beginTransaction(){
        $this->link->beginTransaction();
    }

    /**
     * transaction commit
     */
    public function commit(){
        $this->link->commit();
    }

    /**
     * transaction rollback
     */
    public function rollback(){
        $this->link->rollBack();
    }

    
}