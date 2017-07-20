<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include_once "../mysql.php";
$do = $_GET["do"];
@session_start();
if($do=="logout")
{ 
unset($_SESSION['ewema=997720527']); 
//echo '<script>if(confirm("确认退出?")){alert("退出成功!");window.location.href="login.html";} </script>';
echo '<script>window.location.href="login.html";</script>';
}
if($do=="login")
{
			$adminname1 = $_POST["adminname"]; 
			$adminpassword1 = $_POST["adminpassword"];
			if ($adminname1=="" and $adminpassword1==""){
				echo "<script>alert('请输入用户名和密码！');window.location.href='login.html';</script>";
            }else{ 
	            $sql="select * from admin where adminname='".$adminname1."' and adminpassword='".$adminpassword1."'";
				$mLink=new mysql;
				$result=$mLink->getRow($sql);
	            if(is_array($result) && count($result) > 0){
					$_SESSION['ewema=997720527'] = $adminname1;  
				    echo "<script>window.location.href='news_list.php?do=login';</script>";
	            }else{
                    echo "<script>alert('用户名或密码错误！');window.location.href='login.html';</script>";
	            }
				$mLink->closelink();
			}

}else{
echo "";
exit;
}
?>