<?php 
include_once  dirname(__FILE__)."/../mysql.php";
function getip(){
	session_start();
	if(!isset($_SESSION['ip']))
	{
	$data=getipcity();
	$ip=isset($data["ip"])?$data["ip"]:"0";
	$city=isset($data["city"])?$data["city"]:"未知城市";
	$city=iconv("gb2312","UTF-8",trim($city)); 
	$arrycity=explode('：',$city);
	if(count($arrycity)>1){
		$city=$arrycity[1];
	}
	$result = InsertIP($ip,$city);
	echo $result;
	}
}
function InsertIP($ip,$city){
	$mLink=new mysql;
	$sql="insert into ipinfo(ip,city,addtime) values('$ip','$city',NOW())";
	$res=$mLink->insert($sql);
	$mLink->closelink();
	$_SESSION['ip']=$ip;
	return $res;
}
//var_dump(getipcity());
function getipcity()
{
$url = "http://ip.chemdrug.com";
$file=file_get_contents($url);
$preg2='/.*font/';
$data=array();
$preg='/\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3} /';
if(preg_match($preg,$file,$match))
{
	$data['ip']=$match[0];
}
if(preg_match_all($preg2,$file,$match2))
{
	$data['city']=strip_tags($match2[0][3]) ;  
}
return $data;
}
?>