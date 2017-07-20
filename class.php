<?php 
class index{
	public $m='';
	public $v='';
	public $a='';
	public function __construct()
	{
		//分别加载APP_PATH下的.php文件和.html,然后执行的.php中方法
		session_start();			
		if(isset($_GET['m']))
		{		
		$this->m=(isset($_GET['m'])?$_GET['m']:'');		
		unset($_GET['m']);	
		if(!empty($this->m)) include_once APP_PATH.$this->m.'.php';
		}
		if(isset($_GET['v']))
		{		
		$this->v=(isset($_GET['v'])?$_GET['v']:'');	
		unset($_GET['v']);		
		if(!empty($this->v)) include_once APP_PATH.$this->v.'.html';		
		}
		if(isset($_GET['a']))
		{		
		$this->a=(isset($_GET['a'])?$_GET['a']:'');	
		unset($_GET['a']);
		if(!empty($this->m) && !empty($this->a)) call_user_func($this->a);	
		}
		//当index.php后没有参数时,直接加载index首页
		if(empty($this->m) && empty($this->v)){
			include_once APP_PATH.'index.php';
			include_once APP_PATH.'index.html';			
		}
	}
}
