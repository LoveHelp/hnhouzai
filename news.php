<?php 
function gettitle(){
$title='业务动态';
return $title;
}

include_once "mysql.php";
//绑定业务动态列表
function GetNewsList(){
	$mLink=new mysql;
	$where = " order by id desc";
	$res=$mLink->getAll("select * from news ".$where);
	$mLink->closelink();
	return $res;
}

?>