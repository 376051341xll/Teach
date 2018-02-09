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
include("mail.php");
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
<!-- header end-->
<div class="zhifu_content">
     <div class="zhifu_benner"><img src="images/mmzh.jpg" width="943" height="79" border="0"></div>
	 <div class="zhifu_c_box" style=" text-align:center; width:500px; margin:0 auto;margin-bottom:30px; margin-top:30px; border:1px solid #999; font-size:14px;"><?php
     if($_GET["act"]=="name")
	 {
		 if(empty($_POST["username"]))
		 {
			 $bw->msg("账号不能为空","user_getpwd.php");
		 }
		if($bw->selectOnly("*","bw_member","username='".$_POST["username"]."'"))
		{
			$a=1;
		}else{
			$bw->msg("没有找到您所输入的账号","user_getpwd.php");
			}
	 }
     if($_GET["act"]=="email")
	 {
		 if(empty($_POST["uname"]))
		 {
			 $bw->msg("账号不能为空","user_getpwd.php");
		 }
		if($umember=$bw->selectOnly("*","bw_member","username='".$_POST["uname"]."'"))
		{
			$a=1;
		  	//die($umember["email"]);
			if($umember["email"]==$_POST["email"])
			{
		$smtpserver = "smtp.163.com";    //你选择的SMTP服务器
		$smtpserverport =25;    //SMTP服务器端口
		$smtpusermail = "xcjyedu_ko@163.com";    //SMTP服务器的用户邮箱
		$smtpemailto = $_POST["email"];    //收件箱
		$smtpuser = "xcjyedu_ko@163.com";    //SMTP服务器的用户帐号
		$smtppass = "5835515";    //SMTP服务器的用户密码
		$MailBody="姓名：";//邮件内容(如你提交的表单姓名为Name)
		$mailsubject=@iconv("UTF-8", "gb2312", "欢迎使用宁波家教网");//如果你页面为UTF-8，这里还要转码一下
		$mima=rand(10000000,99999999);
		$pwd=md5($mima);
		$mailbody = "尊敬的会员,欢迎您注册师资最雄厚的宁波家教网(<a href='http://www.bandit6.com' target='_blank'>www.bandit6.com</a>)<br>请妥善保留这封电子邮件. 您的帐号资料如下<br><br>登陆帐号:&nbsp;<span style='color:#ff0000'>".$_POST["uname"]."</span><br>您登陆的新密码:&nbsp;<span style='color:#ff0000'>".$mima."</span><br><br>请妥善保管.";    //邮件内容
		$mailtype = "HTML";    //邮件格式（HTML/TXT）,TXT为文本邮件
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//true表示使用身份验证,否则不使用身份验证.
		$smtp->debug = false; //是否显示发送的调试信息 TRUE发送 FALSE不发送
		$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
		$xgsql="update bw_member set password='".$pwd."' where username='".$_POST["uname"]."'";
	    $bw->query($xgsql);
			$bw->msg("新的密码已经发送到您的邮箱里面，请您注意查收","index.php");
			}else{
			$bw->msg("E-mail账号不对！");
			}
		}else{
			$bw->msg("没有找到您所输入的账号","user_getpwd.php");
			}
	 }
	 
	 if($a==1)
	 {
	 ?>
	   <table width="500" border="0" cellspacing="0" cellpadding="0" style=" height:100px; line-height:100px;">
       <form action="?act=email" method="post">
	     <tr>
	       <td width="180" align="right"><span style="color:#F30; font-size:14px;">2.请输入您的E-mail：</span></td>
	       <td width="145"> <input type="text" name="email" id="email" style="height:22px; line-height:22px; width:200px;"></td>
	       <td width="175" align="left"><input type="hidden" name="uname" id="uname" value="<?php echo $_POST["username"]?>">	         <input type="submit" name="button" id="button" value="发送E-mail" style="width:100px; height:30px; margin-left:5px;"></td>
         </tr>
         </form>
       </table>
       <?php
	 }else{
	   ?>
	   <table width="500" border="0" cellspacing="0" cellpadding="0" style=" height:100px; line-height:100px;">
       <form action="?act=name" method="post">
	     <tr>
	       <td width="180" align="right"><span style="color:#F30; font-size:14px;">1 . 请输入账号：</span></td>
	       <td width="145"> <input type="text" name="username" id="username" style="height:22px; line-height:22px; width:200px;"></td>
	       <td width="175" align="left"><input type="submit" name="button" id="button" value="下一步" style="width:100px; height:30px; margin-left:5px;"></td>
         </tr>
       </form></table><?php
         }
		 ?>
  </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
