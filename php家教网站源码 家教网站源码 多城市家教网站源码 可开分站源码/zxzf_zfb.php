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
//die($_SESSION["hyusername"]);
include 'inc/config.php';
include("checkuser.php");
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
<div class="zhifu_bz">
<div class="zhifu_bz_l"><img src="images/zfbz_gndh.jpg" width="166" height="23" id="daohang">
<ul>

<li id="youd"><a href="zxzf_zfb.php?acontent=<?php echo $_GET["acontent"]?>">支付宝</a></li>
<li><a href="zxzf_cft.php?acontent=<?php echo $_GET["acontent"]?>">财付通</a></li>
<li><a href="zxzf_yhkzz.php?acontent=<?php echo $_GET["acontent"]?>">银行卡转账</a></li>
</ul>
<img src="images/zfbz_zflianxi.jpg" width="157" height="134" border="0" usemap="#lianxiMap" id="lianxi">
<map name="lianxiMap">
  <area shape="rect" coords="12,76,138,107" href="zxzf_bz.php">
</map>
</div>
<div class="zhifu_bz_r">
<div class="lijizf">
  <form name="zfb" method="post" action="pay/alipayto.php" target="_blank">
    <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="40" colspan="2" align="center" valign="middle"><div align="left"><strong><?php 
		
		switch ($_GET["acontent"])
		{
		case 1: echo "预存款";break;
		case 2: echo "认证费";break;
		case 3: echo "违约款";break;
		case 4: echo "信息费";break;
		case 5: echo "退款";break;
		case 6: echo "其他";break;
		}
		
		?> 支付宝在线付款</strong></div></td>
      </tr>
      <tr>
        <td width="62" height="40" align="center" valign="middle">充入账户：</td>
        <td width="338" height="40" align="left" valign="middle" id="zhanghu"><?php echo $_SESSION["hyusername"];?></td>
      </tr>
      <tr>
        <td height="40" align="center" valign="middle">充值金额：</td>
        <td align="left" valign="middle"><input type="text" name="amount" id="amount">
          元
          <input name="away" type="hidden" id="away" value="支付宝付款">
        <input name="memberid" type="hidden" id="memberid" value="<?php echo $_SESSION["userid"];?>">
        <input name="acontent" type="hidden" id="acontent" value="<?php echo $_GET["acontent"]?>"></td>
      </tr>
      <tr>
        <td height="80" colspan="2" align="center" valign="middle"><img src="images/ljzf.jpg" width="150" height="41" onClick="zfb.submit();" style="cursor:pointer;"></td>
      </tr>
    </table>
  </form>
  <div class="zxzf_xx"></div>
  <div class="zxzf_wxts">
  <br>
    <?php
	$classData = $bw->selectOnly('content' ,'bw_base', 'id = 20');
	echo $classData['content'];
	?>
<br>
<br>
<br>
<br>
<br>
<br>


  </div>
</div>
</div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
