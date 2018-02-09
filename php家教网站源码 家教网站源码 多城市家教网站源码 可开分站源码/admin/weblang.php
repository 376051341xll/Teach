<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	 $Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	$langData = $bw->selectOnly('*', 'bw_lang', 'id = 1', '');
	htqx("2.1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分站配置</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="editor/xheditor-zh-cn.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $('#information').xheditor({tools:'Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,Align,List,Outdent,Indent,|,Link,Unlink,Img,|,Source',skin:'o2007silver',upBtnText:"上传",html5Upload:"true",upMultiple:"99",upLinkUrl:"{editorRoot}uploadTxt.php",upLinkExt:"zip,rar,txt,pdf",upImgUrl:"{editorRoot}uploadImg.php",upImgExt:"jpg,jpeg,gif,png"});
	});
</script>
</head>

<body>
<?php
	//update
	$action = $_GET['action'];
	if(!empty($action) && $action == 'update')
	{
	htqx("2.3");
		$_POST["lang"]=str_replace(",,",",",$_POST["lang"]);
		$_POST["lang"]=str_replace("，",",",$_POST["lang"]);
		if(substr($_POST["lang"],0,1)==",")
		{
		$_POST["lang"]=substr($_POST["lang"],1);
		}
		if(substr($_POST["lang"],-1)==",")
		{
		$_POST["lang"]=substr($_POST["lang"],0,-1);
		}
		if($bw->update('bw_lang', $_POST, 'id = 1'))
		{
			if(is_array($elem))
			{
				$bw->update('bw_lang', $elem, 'id = 1');
			}
			echo "<script>alert('更新成功!'); location.href='weblang.php'; </script>";
		}else{
			echo "<script>alert('更新失败!'); history.go(-1); </script>";	
		}
	}
?>
<form name="webConfigFrom" action="?action=update" enctype="multipart/form-data" method="post">
<table width="1062" height="317" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right">分站设置：</td>
    <td>&nbsp;</td>
    <td><textarea name="lang" id="lang" cols="45" rows="5"><?php echo $langData['lang']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" class="subBtn" value=" 提 交 " /></td>
  </tr>
</table>
</form>
</body>
</html>