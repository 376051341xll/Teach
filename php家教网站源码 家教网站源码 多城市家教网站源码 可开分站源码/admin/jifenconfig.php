<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
	$configData = $bw->selectOnly('*', 'bw_config', 'id = 1', '');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站基本配置</title>
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
//		foreach ($_POST as $key => $value) { 
//   echo $key . "=>".$value."<br>";
// 
//} 
//exit;
$xinz="update `bw_config` set jifen=".$_POST["jifen"].",newjf=".$_POST["newjf"].",newts=".$_POST["newts"].",projf=".$_POST["projf"].",prots=".$_POST["prots"].",bbsft=".$_POST["bbsft"].",bbsftts=".$_POST["bbsftts"].",bbshf=".$_POST["bbshf"].",bbshfts=".$_POST["bbshfts"].",htwt=".$_POST["htwt"].",hdwtts=".$_POST["hdwtts"].",jifenshow='".$_POST["jifenshow"]."' where id=1";
//die($xinz);
    $bw->query($xinz);
			echo "<script>alert('更新成功!'); history.go(-1); </script>";	
	}
?>
<form name="webConfigFrom" action="?action=update" enctype="multipart/form-data" method="post">
<table width="1062" height="317" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="415" align="right">注册会员获得积分：</td>
    <td width="10">&nbsp;</td>
    <td width="641"><input type="text" name="jifen" id="jifen" value="<?php echo $configData['jifen']; ?>" style="height:25px; line-height:25px; width:80px;" /></td>
  </tr>
  <tr>
    <td align="right">添加新闻：</td>
    <td>&nbsp;</td>
    <td>积分
      <input type="text" name="newjf" id="newjf" value="<?php echo $configData['newjf']; ?>" style="height:25px; line-height:25px; width:80px;" />
      &nbsp; &nbsp;当天多少条数内
      <input type="text" name="newts" id="newts" value="<?php echo $configData['newts']; ?>" style="height:25px; line-height:25px; width:80px;" /></td>
  </tr>
  <tr>
    <td align="right">添加产品：</td>
    <td>&nbsp;</td>
    <td>积分
      <input type="text" name="projf" id="projf" value="<?php echo $configData['projf']; ?>" style="height:25px; line-height:25px; width:80px;" />
&nbsp; &nbsp;当天多少条数内
<input type="text" name="prots" id="prots" value="<?php echo $configData['prots']; ?>" style="height:25px; line-height:25px; width:80px;" /></td>
  </tr>
  <tr>
    <td align="right">论坛发帖：</td>
    <td>&nbsp;</td>
    <td>积分
      <input type="text" name="bbsft" id="bbsft" value="<?php echo $configData['bbsft']; ?>" style="height:25px; line-height:25px; width:80px;" />
&nbsp; &nbsp;当天多少条数内
<input type="text" name="bbsftts" id="bbsftts" value="<?php echo $configData['bbsftts']; ?>" style="height:25px; line-height:25px; width:80px;" /></td>
  </tr>
  <tr>
    <td align="right">论坛回帖：</td>
    <td>&nbsp;</td>
    <td>积分
      <input type="text" name="bbshf" id="bbshf" value="<?php echo $configData['bbshf']; ?>" style="height:25px; line-height:25px; width:80px;" />
  &nbsp; &nbsp;当天多少条数内
  <input type="text" name="bbshfts" id="bbshfts" value="<?php echo $configData['bbshfts']; ?>" style="height:25px; line-height:25px; width:80px;" /></td>
  </tr>
  <tr>
    <td align="right">回答问题：</td>
    <td>&nbsp;</td>
    <td>积分
      <input type="text" name="htwt" id="htwt" value="<?php echo $configData['htwt']; ?>" style="height:25px; line-height:25px; width:80px;" />
      &nbsp; &nbsp;当天多少条数内
      <input type="text" name="hdwtts" id="hdwtts" value="<?php echo $configData['hdwtts']; ?>" style="height:25px; line-height:25px; width:80px;" /></td>
  </tr>
  <tr>
    <td align="right">积分说明:</td>
    <td>&nbsp;</td>
    <td><textarea name="jifenshow" cols="50" rows="15"  class="xheditor {skin:'default',tools:'full'}" id="jifenshow"><?php echo $configData['jifenshow']; ?></textarea></td>
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