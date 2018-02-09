<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><?php
include("inc/config.php");
 include("mail.php"); ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>宁波家教网</title>
</head>

<body><?php


$smtpserver = "smtp.163.com";    //你选择的SMTP服务器
$smtpserverport =25;    //SMTP服务器端口
$smtpusermail = "xcjyedu_ko@163.com";    //SMTP服务器的用户邮箱
$smtpemailto = "981790775@qq.com";    //收件箱
$smtpuser = "xcjyedu_ko@163.com";    //SMTP服务器的用户帐号
$smtppass = "5835515";    //SMTP服务器的用户密码
$MailBody="姓名：";//邮件内容(如你提交的表单姓名为Name)
$mailsubject=@iconv("UTF-8", "gb2312", "测试测试");//如果你页面为UTF-8，这里还要转码一下
$mailbody = "<a href='http://baidu.com'>dsafds</a>";    //邮件内容
$mailtype = "HTML";    //邮件格式（HTML/TXT）,TXT为文本邮件
$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//true表示使用身份验证,否则不使用身份验证.
$smtp->debug = false; //是否显示发送的调试信息 TRUE发送 FALSE不发送
$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
echo "<script>alert('发送成功');location.href='http://baidu.com'</script>";

?>
</body>
</html>