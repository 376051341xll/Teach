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
     <div class="zhifu_benner"><img src="images/zhifu_banner.jpg" width="941" height="91" border="0"></div>
	 <div class="zhifu_c_box">
     <div class="zhifu_c_box_l"><span id="title">&nbsp;&nbsp;&nbsp;会员登录&nbsp;</span><span id="title1">如您还不是会员，请点击<a href="tutor.php">注册账号</a></span><br>
       <br>
       <table width="314" border="0" align="center" cellpadding="0" cellspacing="0" style="color:#000;">
       <form action="?act=dl" method="post" name="zxzf_from" id="zxzf_from">
       <tr>
    <td width="74" height="40" align="right">教员号：</td>
    <td width="240"><input type="text" name="username" id="username"></td>
  </tr>
  <tr>
    <td height="40" align="right">密&nbsp;&nbsp; 码：</td>
    <td><input type="password" name="password" id="password"></td>
  </tr>
  <tr>
    <td height="33" align="right">验证码：</td>
    <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
          <td width="25%"><span class="index_dl_lie">
            <input id="yzm" name="yzm" type="text" / style="height:20px; line-height:20px;">
          </span></td>
          <td width="75%"><img  src="Code.php?act=captcha&amp;<?php echo mt_rand(); ?>" width="50" height="20" alt="CAPTCHA" border="1" onClick= "this.src=&quot;Code.php?act=captcha&amp;&quot;+Math.random()" style="cursor: pointer; " title="看不清，点击更换另一个验证码" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50" align="right">&nbsp;</td>
    <td align="left"><img src="images/denglu.jpg" width="87" height="26" style=" cursor:pointer;" onClick="return document.zxzf_from.submit();"></td>
  </tr></form>
 </table>
       <br>
       <br>
       <br>
       <br>
     </div>
     <div class="zhifu_c_box_r">
     <ul>
     <li>提示：</li>
     <!--<li>如果您已经是会员，可以登录进行充值</li>
     <li>如果您还没开通会员请拨打服务电话&nbsp;<span>0592-5531812</span></li>
     <li><a href="zxzf_bz.php"><img src="images/zxzf_zfbz.jpg" width="125" height="26"></a></li>-->
	 <li>想更快速的登录中国宁波家教网？</li>
     <li> <a onClick="AddFavorite(window.location,document.title)" href="###">请点击收藏此页面</a></li>
     </ul>
     </div>
     </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
