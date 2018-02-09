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
<!-- saved from url=(0054)#?WT.mc_id=c03-BDPP-101&WT.srch=1 -->
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<title><?php echo $service_title; ?></title>
<meta name="keywords" content="<?php echo $service_keyword.'-'.$service_title; ?>" />
<meta name="description" content="<?php echo $service_description.'-'.$service_title; ?>" />
<META http-equiv=content-type content="text/html; charset=utf-8">
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico"><script language="javascript">
function fsxx()
{
var myreg =/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(document.getElementById("title").value=="")
	{
	document.getElementById("title").focus();
	alert("请输入标题");
	return false;
	}
	if(document.getElementById("content").value=="")
	{
	document.getElementById("content").focus();
	alert("请输入内容");
	return false;
	}
	return true;
}

</script>
</HEAD>
<BODY>
<?php 
$act=$_GET["act"];
if(!empty($act) && $act == 'yes')
{
        if($bw->insert('bw_zxwd', $_POST))
		{
			$bw->msg('信息发送成功!', 'user_fsxx.php');
		}else{
			$bw->msg('信息发送失败!', '', true);	
		}
}
?>
<?php include("top.php");?>
<!-- header end-->
<div class="user_c">
<div class="user_left">
<?php include("user_left.php");?>
</div>
<div class="user_sjx_c">
<div class="user_sjx_t">
  <table width="748" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="93" height="25" align="center" valign="middle" style="border-right:1px solid #D3D3D3; background:#FFF; border-bottom:1px solid #FFF;"><a href="user_fsxx.php"><strong>发送信息</strong></a></td>
      <td width="85" align="center" valign="middle" style="border-right:1px solid #D3D3D3;border-bottom:1px solid #D3D3D3;"><a href="user_sjx.php"><strong>收件箱</strong></a></td>
      <td width="81" align="center" valign="middle" style="border-right:1px solid #D3D3D3;border-bottom:1px solid #D3D3D3;"><a href="user_yfxx.php"><strong>已发信息</strong></a></td>
      <td width="398" style="border-bottom:1px solid #D3D3D3;">&nbsp;</td>
    </tr>
  </table>
</div>
<div class="user_sjx_nr"><br>
  <br>
  <form action="?act=yes" method="post">
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="40" align="right" valign="middle">会员号：</td>
      <td align="left" valign="middle">
	  <?php
      echo $_SESSION["hyusername"];
	  ?>
	  <input type="hidden" name="username" id="username" value="<?php echo $_SESSION["hyusername"];?>">
	  <input type="hidden" name="uid" id="uid" value="<?php echo $_SESSION["userid"];?>">
	  <input type="hidden" name="lang" id="lang" value="<?php echo $_COOKIE["cookie_lang"];?>">
	  </td>
    </tr>
    <tr>
      <td height="40" align="right" valign="middle">发送至：</td>
      <td align="left" valign="middle">管理员</td>
    </tr>
    <tr>
      <td width="66" height="40" align="right" valign="middle">标&nbsp; 题：</td>
      <td width="334" align="left" valign="middle"><input type="text" name="title" id="title" style="line-height:25px;"></td>
      </tr>
    <tr>
      <td height="96" align="right" valign="middle">内容：</td>
      <td align="left" valign="middle"><textarea name="content" id="content" cols="45" rows="5"></textarea></td>
      </tr>
    <tr>
      <td height="50">&nbsp;</td>
      <td align="left">
	    <input type="submit" value="提   交" style="width:80px; height:25px; border:1px solid #CCC; background:#FFF;" onClick="return fsxx();">
        &nbsp; &nbsp;
        <input type="reset"  value="重   置" style="width:80px; height:25px; border:1px solid #CCC; background:#FFF;"></td>
      </tr>
</table>
  </form>
</div>
</div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
