<?php 
$data=getipcity();
var_dump($data);
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
	$data['city']=$match2[0][3];  
}
return $data;
}