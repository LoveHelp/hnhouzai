<?php
	include_once  dirname(__FILE__)."/../mysql.php";
	
	function getTitle()
	{
		$title = "产品体验";
		return $title;
	}
	
	//试用申请
	function sqsy(){
		$name = empty($_POST['name']) ? trim('') : $_POST['name'];
		$email = empty($_POST['email']) ? trim('') : $_POST['email'];
		$company = empty($_POST['company']) ? trim('') : $_POST['company'];
		$mobile = empty($_POST['mobile']) ? trim('') : $_POST['mobile'];
		$desc = empty($_POST['desc']) ? trim('') : $_POST['desc'];
		
		if(empty($mobile) && empty($email)){
			echo '0';
			return;
		}
		
		$link = new mysql();
		$sql = "select id from apply where mobile='{$mobile}';";
		$res = $link->getRow($sql);
		if(!empty($res['id'])){
			echo '2';
			return;
		}
		
		$sql = "insert into apply(name, mobile, company, email, description, apply_time) values('{$name}', '{$mobile}', '{$company}', '{$email}', '{$desc}', now());";
		$res = $link->insert($sql, array());
		if($res === 0){
			echo '0';
			return;
		}
		
		echo '1';	
	}
	
?>
