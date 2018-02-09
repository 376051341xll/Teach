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
function check()
{
	if(document.all.password.value != document.all.password2.value)
	{
	document.all.password.focus();
	alert("两次输入的密码不一致，请重新输入！");
	return false;
	}
	return true;
}
</script>
</HEAD>
<BODY>
<?php 
$act=$_GET["action"];
if(!empty($act) && $act == 'xg')
{        
   if($_POST["password"]==$_POST["password2"])
            {
            $pwd=md5($_POST["password"]);
			$sql = "UPDATE bw_member SET password = '{$pwd}' WHERE id = ".$_SESSION["userid"];
 //die($sql);
			$bw->query($sql);
			$bw->msg('密码更新成功!');
			}else{
			echo "<script>alert('两次密码输入的不一样，请重新输入!');window.history.go(-1);</script>";
			exit();
			}
}
?>
<?php include("top.php");?>
<!-- header end-->
<div class="user_c">
<div class="user_left">
<?php include("user_left.php");?>
</div>
<div class="user_right">
     <div id="xcrz_tltle">密码修改</div>
    <div id="xcrz_nr"><form id="registerForm" name="registerForm" method="post" action="?action=xg" onSubmit="check();">
              <table width="673" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="274" height="40" align="right"><strong>用户名:</strong></td>
                  <td width="10">&nbsp;</td>
                  <td width="387"><?php echo $_SESSION['hyusername'];?></td>
                </tr>
                <tr>
                  <td height="40" align="right"><strong>密码:</strong></td>
                  <td>&nbsp;</td>
                  <td><input name="password" type="password" class="textBox" id="password" style="width:200px; height:20px; line-height:20px;"/>
                  <span style="color:#F00;">（如果不修改请留空）</span></td>
                </tr>
                <tr>
                  <td height="40" align="right"><strong>重复密码:</strong></td>
                  <td>&nbsp;</td>
                  <td><input name="password2" type="password" class="textBox" id="password2"  style="width:200px; height:20px; line-height:20px;"/>
                  <span style="color:#F00;">（如果不修改请留空）</span></td>
                </tr>
				<tr>
                  <td height="40" align="right"></td>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="Submit" value="修改密码"></td>
                </tr>
				</table></form></div>
</div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
