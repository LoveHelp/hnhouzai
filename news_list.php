<?php
@session_start();  
//检测是否登录，若没登录则转向登录界面  
if(!isset($_SESSION['ewema=997720527'])){ 
    header("Location:login.html");  
    exit();  
} 

$title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
$addtime_start = isset($_POST["addtime_start"]) ? $_POST["addtime_start"] : "";
$addtime_end = isset($_POST["addtime_end"]) ? $_POST["addtime_end"] : "";

include_once "../mysql.php";
?>

<!doctype html>
<html xmlns=http://www.w3.org/1999/xhtml>
<head> 
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>业务动态管理</title>
<link rel="stylesheet" href="../css/admin.css" type="text/css" />

</head>

<body>


<div class="main">
			<div id="zhuxiao">注销</div>
            <div style="width: 100%" class="search">
				<form action="news_list.php" method="POST">
					<table class="search_table">
						<tr>                    	
							<td>
								标题:
							<input type="text" id="title" name="title" style="width:400px;" placeholder="标题" value="<?=$title?>" class="input" />
							</td>
							<td>
								发布时间：
								<input type="text" id="addtime_atart" name="addtime_start" onclick="laydate();" value="<?=$addtime_start?>" class="input" /> - 
								<input type="text" id="addtime_end" name="addtime_end" onclick="laydate();" value="<?=$addtime_start?>" class="input" />
							</td>
							<td align="right">
								<input type="submit" class="btn"  value="查 询" />
								<input type="button" class="btn pub" onclick="window.location='news_add.php?flag=add'"  value="新 增" />
							</td>                       
						</tr>
					</table>
				</form>
            </div>
			
	<div class="list">
                <ul class="title">
                    <li class="li1">序号</li>
                    <li class="li2">标题</li>
                    <li class="li3">浏览量</li>
                    <li class="li4">添加时间</li>
                    <li class="li3">操作</li>
                </ul>
	<?php 
	$list = get_newsList($title,$addtime_start,$addtime_end);
					  if(!empty($list)){
						foreach ($list as $info){
				?>

                        <ul class="content">
                            <li class="li1"><?php echo $info['id']?></li>
                            <li class="li2">
                                <a title="<?php echo $info['title']?>" href="news_add.php?id=<?php echo $info['id']?>">
                                    <?php echo $info['title']?>
                                </a>
                            </li>
                            <li class="li3"><?php echo $info['clickcount']?></li>
                            <li class="li4"><?php echo $info['addtime']?></li>
                            <li class="li3">
                                <a href="news_add.php?id=<?php echo $info['id']?>&flag=upd">修改</a>
                                | <a onclick="hch.delByInfoId(<?php echo $info['id']?>);" href="javascript:void(0);">删除</a>
                            </li>
                        </ul>
                    
					<?php          
					  }}
					?>

	</div>

</div>

</body>
</html>

	<script type="text/javascript" src="../js/laydate/layDate.js"></script>
    <script type="text/javascript" src="../js/jquery.1.9.1.min.js"></script>
    <script type="text/javascript">
    var hch = {
        delByInfoId:function(id){
        	if(confirm('确定删除改记录？')){
        		location.href="news_manage.php?id="+id+"&flag=del";
        	}
        }
    }
	
	$("#zhuxiao").on('click',function(){
		window.location.href='logincheck.php?do=logout';
	});
</script>

<?php
//绑定业务动态列表
function get_newsList($title,$addtime_start,$addtime_end){
	$mLink=new mysql;
	$where=" where 1 = 1";
	if($title != ""){
		$where.=" and title like '%".$title."%'";
	}
	if($addtime_start != ""){
		$where.=" and addtime >= '".$addtime_start."'";
	}
	if($addtime_end){
		$where.=" and addtime <= '".$addtime_end."'";
	}
	$where .= " order by id desc";
	$res=$mLink->getAll("select * from news ".$where);
	$mLink->closelink();
	return $res;
}

?>