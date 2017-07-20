<?php
header("Content-type: text/html; charset=utf8");
@session_start();  
//检测是否登录，若没登录则转向登录界面  
if(!isset($_SESSION['ewema=997720527'])){ 
    header("Location:login.html");  
    exit();  
}

$id="";
$title="";
$coverpic="";
$content="内容必填";
include_once '../mysql.php';
if(!empty($_GET["id"])){

	$id=$_GET["id"];
	$sql="SELECT * FROM news where id = ".$id;
	$mLink=new mysql;
	$result=$mLink->getRow($sql);
	$mLink->closelink();
	if(is_array($result)){
	    $title=$result["title"];
	    $coverpic=$result["coverpic"];
	    $content=$result["content"];
	}

}


?>

<!doctype html>
<html xmlns=http://www.w3.org/1999/xhtml>
<head> 
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>后台管理-业务动态管理</title>
<link rel="stylesheet" href="../css/admin.css" type="text/css" />
<link rel="stylesheet" href="../css/editor-min.css" type="text/css" />
    <script type="text/javascript" src="../js/jquery.1.9.1.min.js"></script>

</head>

<body>

<div class="main">
			<div id="zhuxiao">注销</div>
<form action='news_manage.php' enctype="multipart/form-data" method='post'>
        <div class="main_content">
				<input type="hidden" name="hd_id" value="<?php echo $id;?>"/>
            <p>
                <span class="content_sptitle">标题</span>
                <span class="content_spcontent">
					<input type="text" name="title" class="sptitle" value="<?php echo $title;?>"/>
							<font style='color:red;font-size:16px; font-weight:bold;'>*</font>
				</span>
            </p>
            <p>
                <span class="content_sptitle">封面图片</span>
                <span class="content_spcontent">
					<input type="file" style="width:300px; border:0;" name="upfile" id="upfile"/>
				<input type="text" name="coverpic" value="<?php echo $coverpic;?>" style="width:240px;display:<?php if(!empty($coverpic)){echo "display";}else{echo "none";}?>;"/>
				<strong class="red">*（请上传缩略图图片）</strong>
				</span>
            </p>
            <p>
                <span class="content_sptitle">内容</span>
                <span class="content_spcontent">
					<div id="bdeditor" style="padding:5px;height:700px;">
		                        <script type="text/javascript" charset="utf-8" src="../js/ueditor/ueditor.config.js"></script>
		                        <script type="text/javascript" charset="utf-8" src="../js/ueditor/ueditor.all.min.js"> </script>
		                        <script type="text/javascript" charset="utf-8" src="../js/ueditor/lang/zh-cn/zh-cn.js"></script>
		                        <script id="editor" name="content" type="text/plain" style="width:98%;height:600px;"></script>
								<script type="text/javascript">  
								    //UE.getEditor('editor'); 
								    var ue = UE.getEditor("editor",{topOffset:0,autoFloatEnabled:false,autoHeightEnabled:false,autotypeset:{removeEmptyline:true},toolbars:[['fullscreen','source','undo','redo','bold','italic','underline','fontborder','strikethrough','removeformat','autotypeset','blockquote','pasteplain','forecolor','backcolor','insertorderedlist','insertunorderedlist','selectall','cleardoc','rowspacingtop','rowspacingbottom','lineheight','indent','justifyleft','justifycenter','justifyright','fontfamily','fontsize','justifyjustify','touppercase','tolowercase','simpleupload','emotion','insertvideo','map','date','time','spechars','preview','searchreplace'],['con','title','fork','guide','division','other','mystyle']],autoHeightEnabled:false,allowDivTransToP:false,autoFloatEnabled:true,enableAutoSave:false}); 
									
									ue.ready(function() {
										ue.setContent('<?=$content;?>');
									});
								</script>  
		              		</div>
				</span>
            </p>
            <p style="line-height:60px;">
				<span class="content_sptitle">&nbsp;</span>
				<span class="content_spcontent">
				<?php if(!empty($_GET["flag"])){?>
					<input type="submit" value=" 保 存 " class="btn" onclick="return hch.check();" />
				<?php }?>
					<input type="button" value=" 返 回 " class="btn btnGray" onclick="hch.goback();" />
				</span>
            </p>
        </div>
</form>
    </div>

</body>
</html>

<script src="../js/layer/layer.js"></script>
<script type="text/javascript">
	var hch = {
		goback: function () {
			//history.go(-1);
			window.location.href="news_list.php";
		},
    	check: function () {
		    var $title = $("input[name='title']").val();
		    //var $content = $("input[name='content']").val();
			if(!$title){
				layer.msg("标题不能为空！");
				return false;
			}
			var filename='<?php echo $coverpic;?>';
			var file=document.getElementById("upfile").value;
			if(filename=="" && file.length<1){
				layer.msg("请选择封面图片！");
				return false;
			}
    	}
  	}
	$("#zhuxiao").on('click',function(){
		window.location.href='logincheck.php?do=logout';
	});
</script>
