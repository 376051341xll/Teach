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
include("inc/config.php");
if(!empty($_POST["jiesou"]))
{
$_SESSION["jiesou"]=$_POST["jiesou"];
	}
	if($_SESSION["jiesou"]!=1)
	{
		echo "<script>location.href='tutor.php'</script>";
		exit;
		}
 ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<title><?php echo $service_title; ?></title>
<meta name="keywords" content="<?php echo $service_keyword.'-'.$service_title; ?>" />
<meta name="description" content="<?php echo $service_description.'-'.$service_title; ?>" />
<META http-equiv=content-type content="text/html; charset=utf-8">
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico"></HEAD>
<BODY>
<?php include("top.php");?>
<script language="javascript">
function openwin(Url)
  {
  msgwin=window.open(Url,"","left=450,top=300,width=100,height=50,resizable=no,scrollbars=no,status=no,toolbar=no,menubar=no,location=no");
  }

function zhuce()
{
var myreg =/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(document.getElementById("username").value=="")
	{
	document.getElementById("username").focus();
	alert("请输入您的会员账号");
	return false;
	}
	if(document.getElementById("username").value.length<=2)
	{
	document.getElementById("username").focus();
	alert("您输入的账号长度不够");
	return false;
	}
	if(document.getElementById("password").value=="")
	{
	document.getElementById("password").focus();
	alert("请输入密码");
	return false;
	}
	if(document.getElementById("password").value.length<6)
	{
	document.getElementById("password").focus();
	alert("您输入的密码长度不够");
	return false;
	}
	if(document.getElementById("password2").value=="")
	{
	document.getElementById("password2").focus();
	alert("请再次输入密码");
	return false;
	}
	if(document.getElementById("password2").value!=document.getElementById("password").value)
	{
	document.getElementById("password2").focus();
	alert("您两次输入的密码不一致");
	return false;
	}
	if(document.getElementById("email").value=="")
	{
	document.getElementById("email").focus();
	alert("请输入您的邮箱");
	return false;
	}
	if(document.getElementById("levels").value=="")
	{
	alert("请选择您的注册身份");
	return false;
	}
	return true;
}

</script>
<!-- header end-->
<div id="all_main_all">
     <div id="zjj_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div id="all_main_all_box">
	      <div id="all_main_all_box_left">
		       <div id="all_main_all_box_left_top"><b style="font-size:16px; color:#fe5009;">做家教</b>&nbsp;&nbsp;&nbsp;当前位置：做家教</div>
			   <div id="all_main_all_box_left_mid">
			        <div id="tutor_box">
				      <div id="title" style="width:670px; height:36px; padding:1px;">
					       <div style="width:655px; height:36px; background:#f4f4f4; padding-left:15px;"> <strong>新教员注册第二步:</strong><font color="#fe5d08">1</font>请务必填写真实姓名，与证件不符者将不能通过认证。<font color="#fe5d08">2</font>为保护您的隐私，本网不会公开显示您的姓名</div>
					  </div>
					  <div id="tutor_box_center" style="width:668px; padding:1px; border:1px #f4f4f4 solid;">
					    <form action="tutor_info1.php" onSubmit="return zhuce();" method="post" id="reg_from">
						<div style="width:668px; height:auto; margin:0 auto;  background:#f4f4f4;">
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="80" colspan="2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="100" height="30" align="right">用户名：</td>
                            <td><label>
                              <input name="username" type="text" class="tutor_input" id="username">
                              <input type="button" name="button" id="button" value="用户名检测" onClick="javascript:openwin('jiance.php?uname='+document.getElementById('username').value)">
                            请输入您的账号，长度大于3位 </label></td>
                          </tr>
                          <tr>
                            <td height="30" align="right">密码：</td>
                            <td><input name="password" type="password" class="tutor_input" id="password">
                            密码只能使用字母/数字/下划线，长度大于6位</td>
                          </tr>
                          <tr>
                            <td height="30" align="right">重复密码：</td>
                            <td><input name="password2" type="password" class="tutor_input" id="password2">
                            同上，请保持密码输入一致</td>
                          </tr>
                          <tr>
                            <td height="30" align="right">邮箱：</td>
                            <td><input name="email" type="text" class="tutor_input" id="email">
                              请准确填写您的Email地址，您注册的账号，密码将发送到邮箱</td>
                          </tr>
                          <tr>
                            <td height="25" colspan="2" style="border-bottom:1px solid #CCCCCC">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="25" colspan="2">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="right"> <label>选择身份：</label></td>
                            <td><label>
                              <input name="levels" type="radio" id="levels" value="1" checked onClick="javascript:this.form.action='tutor_info1.php'">
                            在校大学生(研究生)，不含留学生<br>
                            <input type="radio" name="levels" value="2" onClick="javascript:this.form.action='tutor_info.php'">
                            教师(在职/进修/离职/退休)
                            <br>
                            <input type="radio" name="levels" value="3" onClick="javascript:this.form.action='tutor_info2.php'">
                            外籍人士(含留学生、外教)，海外归国人员<br>
                            <input type="radio" name="levels" value="4" onClick="javascript:this.form.action='tutor_info3.php'">
                            其他(已经毕业离校的人员)</label></td>
                          </tr>
                          <tr>
                            <td height="100" colspan="2" align="center"><label>
                              <input type="image" name="Submit" src="images/zjj_05.jpg">
                            </label>&nbsp;
                              <label>
                              <input type="image" name="Submit2" src="images/zjj_06.jpg">
                            </label></td>
                          </tr>
                        </table>
						</div>
						</form>
					  </div>
				    </div>
			   </div>
		  </div>
	   <div id="all_main_all_box_right">
	        <div class="tutor_right_pic"><img src="images/zjj_01.jpg"></div>
			<div class="tutor_right_pic"><img src="images/zjj_02.jpg"></div>
			<div class="tutor_right_pic"><img src="images/zjj_03.jpg"></div>
			<div class="tutor_right_pic"><img src="images/zjj_04.jpg"></div>
	   </div>
	 </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
