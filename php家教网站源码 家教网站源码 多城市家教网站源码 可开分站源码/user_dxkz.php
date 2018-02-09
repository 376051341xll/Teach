<?php  session_start();
if(!empty($_GET["lang"])){
setcookie("cookie_lang",base64_decode(iconv("gb2312","utf-8",$_GET["lang"])), time()+2592000);
echo "<script language='javascript'>	window.location.href='index.php';  </script>";
}
if($_COOKIE["cookie_lang"]=="")
{
setcookie("cookie_lang","宁波站", time()+2592000);
echo "<script language='javascript'>	window.location.href='index.php';  </script>";
}
include 'inc/config.php';
$classData = $bw->selectOnly('*' ,'bw_member', 'id = '.$_SESSION["userid"]);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<title><?php echo $service_title; ?></title>
<meta name="keywords" content="<?php echo $service_keyword.'-'.$service_title; ?>" />
<meta name="description" content="<?php echo $service_description.'-'.$service_title; ?>" />
<META http-equiv=content-type content="text/html; charset=utf-8">
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico"><script language="javascript">
function yes()
{
var myreg =/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(document.getElementById("telphone").value=="")
	{
	document.getElementById("telphone").focus();
	alert("请输入新号码");
	return false;
	}
	return true;
}
</script>
<script language="JavaScript">
function qxdx(del){
if(confirm("你确定取消接收短信吗?")){
window.location.href="?act=qx"
}
}
function jsdx(del){
if(confirm("你确定接收短信吗?")){
window.location.href="?act=js"
}
}
</script>
</HEAD>
<BODY>
<?php 
$act=$_GET["act"];
if(!empty($act) && $act == 'yes')
{
			$sql = "UPDATE bw_member SET telphone = {$_POST['telphone']} WHERE id = {$_SESSION['userid']}";
			$bw->query($sql);
			$bw->msg('号码更新成功!');
}
if(!empty($act) && $act == 'qx')
{
			$sql = "UPDATE bw_member SET dxjs = 2 WHERE id = {$_SESSION['userid']}";
			$bw->query($sql);
			$bw->msg('设置取消短信接收成功!');
}
if(!empty($act) && $act == 'js')
{
			$sql = "UPDATE bw_member SET dxjs = 1 WHERE id = {$_SESSION['userid']}";
			$bw->query($sql);
			$bw->msg('设置接收短信成功!');
}
?>
<?php include("top.php");?>
<!-- header end-->
<div class="user_c">
<div class="user_left">
<?php include("user_left.php");?>
</div>
<div class="user_right">
     <div id="xcrz_tltle">短信控制</div>
     <div id="xcrz_nr">
	 <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="line-height:25px;">
	  <tr>
		<td colspan="3">注释：<br>
		  为了方便您随时随地在第一时间内了解到家教信息，您可以在此设定短接收功能，一旦设定成功，我们会将学员的家教请求在第一<br>
		  时间内发送到您的手机，您亦可以设定关闭此功能。</td>
	  </tr>
	  <tr>
		<td colspan="3">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="3"><strong style="font-size:14px;">您当前设定的号码是：<span style="font-size:14px; color:#FF0000"><?php echo $classData["telphone"];?></span></strong></td>
	  </tr>
	  <tr>
		<td colspan="3">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="3">短信接收状态：<span style="color:#FF0000"><?php if($classData["dxjs"]==1){echo "接收短信";}else{echo "不接收短信";}?></span></td>
	    </tr>
	  <tr>
	    <td colspan="3">&nbsp;</td>
	    </tr>
	  <tr>
		<td colspan="3">如需设定新号码，请在此填写新号码，手机短讯以新号码为准 如需取消手机短信接收功能请点击取消短讯接收！ </td>
	  </tr>
	  <tr>
		<td colspan="3">&nbsp;</td>
	  </tr>
	  <form name="form1" method="post" action="?act=yes">
	  <tr>
		<td width="70" valign="middle">
		
		<strong>手机号码：</strong>
		<label></label>			</td>
	    <td width="300" valign="middle"><input name="telphone" type="text" id="telphone" style="width:300px; height:20px; line-height:20px;"></td>
	    <td width="300" valign="middle"><label>
	      <input type="image" src="images/user_dxkz_tj.jpg" onClick="return yes();">&nbsp;
	      <?php if($classData["dxjs"]==1)
		  {
		  ?>
		  <img src="images/user_dxkz_qx.jpg" style="cursor:hand" onClick="qxdx(<?php echo $classData["id"]; ?>)" width="92" height="24" border="0">
		  <?php 
		  }else{
		  ?>
		  <img src="images/user_dxkz_js.jpg" style="cursor:hand" onClick="jsdx(<?php echo $classData["id"]; ?>)" width="92" height="24" border="0">
		  <?php
		  }
		  ?>
	    </label></td>
	  </tr>
	  </form>	
	</table>
	 </div>
</div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
