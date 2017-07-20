<?php 
function gettitle(){
$title='业务动态详情页';
return $title;
}

include_once "mysql.php";
//绑定业务动态详情
function GetNewsDetails($id){
	$sql="SELECT * FROM news where id = ".$id;
	$mLink=new mysql;
	$result=$mLink->getRow($sql);
	$mLink->closelink();
	return $result;
}
function AddClickCount($id){
	$sql="update news set clickcount = clickcount + 1 where id = ".$id;
	$mLink=new mysql;
	$result=$mLink->update($sql);
	$mLink->closelink();
}

?>