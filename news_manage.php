<?php
include_once "../mysql.php";
header("Content-type:text/html;charset=utf-8");
$mLink=new mysql;

$msg="";
if(isset($_GET['flag']) && $_GET['flag']=="del"){//删除
	$id=$_GET['id'];
	$sql="delete from news where id = ".$id;
	$result = $mLink->update($sql);
	if($result = 1){
			$msg = "<script>alert('删除成功！');window.location.href='news_list.php';</script>";
	}
}else{//修改或添加
	$destination="";
	if(is_uploaded_file($_FILES['upfile']['tmp_name'])){ 
		$upfile=$_FILES["upfile"]; 
		$name=$upfile["name"];//上传文件的文件名
		//获取数组里面的值
		$extension=end(explode('.', $name));
		$newname=time().".".$extension; 
		$type=$upfile["type"];//上传文件的类型 
		$size=$upfile["size"];//上传文件的大小 
		$tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径 
		//判断是否为png图片，并且大小在1M内 
		if(($type == "image/png" || $type == "image/jpeg" || $type == "image/gif")){
			$error=$upfile["error"];//上传后系统返回的值 
			
			// echo "开始移动上传文件<br/>"; 
			//把上传的临时文件移动到指定目录下面 
			$destination="upload/".$newname; 
            move_uploaded_file($tmp_name, iconv("UTF-8", "gb2312", "../".$destination));
		}
		else{
			echo "<script>alert('请上传png/jpg/gif格式的图片');window.history.back(-1);</script>";
			exit;
		}
	}


	$title = trim($_POST['title']);
	$content = str_replace('\"', '"', trim($_POST['content']));
	$coverpic = isset($_POST['coverpic'])?$_POST['coverpic']:"";
	if($destination!=""){
		$coverpic=$destination;
	}

	if(empty($_POST['hd_id'])){//添加
		$sql="insert into news(title,content,coverpic,addtime)";
		$sql.=" values(?,?,?,now())";
		$param=array(
			$title,
			$content,
			$coverpic
		);
		$result = $mLink->insert($sql,$param);
		if($result>0){
			$msg = "<script>alert('发布成功！');window.location.href='news_list.php';</script>";
		}else{
			$msg = "<script>alert('发布失败！');</script>";
		}
	}else{//修改
		$id = $_POST['hd_id'];
		$sql="update news set title=?,content=?,coverpic=? where id=?";
		$param=array(
			$title,
			$content,
			$coverpic,
			$id
		);
		$result = $mLink->update($sql,$param);
		if($result = 1){
			$msg = "<script>alert('修改成功！');window.location.href='news_list.php';</script>";
		}
	}
}

$mLink->closelink();
echo $msg;

?>