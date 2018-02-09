<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加新闻信息</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="editor/xheditor-zh-cn.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $('#content').xheditor({tools:'Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,Align,List,Outdent,Indent,|,Link,Unlink,Img,|,Source',skin:'o2007silver',upBtnText:"上传",html5Upload:"true",upMultiple:"99",upLinkUrl:"{editorRoot}uploadTxt.php",upLinkExt:"zip,rar,txt,pdf",upImgUrl:"{editorRoot}uploadImg.php",upImgExt:"jpg,jpeg,gif,png"});
	});
</script>
</head>

<body>
<?php
$action = $_GET['action'];
if($action == 'insert')
{
	if($userData = $bw->selectOnly('id', 'bw_member', "username = '{$_POST['username']}'"))
	{
			$bw->jifen($userData["id"],$_POST["jflog"],$_POST["jifen"],"操作成功");
	}
	else
	{
		$bw->msg('没有您输入的会员号!');
	}
}
?>
<form action="?action=insert" method="post" enctype="multipart/form-data">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="152" align="right">会员号：</td>
    <td width="10">&nbsp;</td>
    <td width="630"><input name="username" class="textBox" id="username" value="" />
      &nbsp; </td>
  </tr>
  <tr>
    <td align="right">增加或减少的积分：</td>
    <td>&nbsp;</td>
    <td>
      <input name="jifen" class="textBox" id="jifen" value="" />
      <span style="color:#F00;">增加或减少积分请切换到半角用+号&nbsp; 例：+20，-20</span></td>
  </tr>
  <tr>
    <td align="right">积分原因：</td>
    <td>&nbsp;</td>
    <td><input name="jflog" class="textBox" id="jflog" value="" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" class="subBtn" value=" 提 交 " />&nbsp;<input type="reset" class="subBtn" value=" 重 置 " /></td>
  </tr>
</table>
</form>
</body>
</html>