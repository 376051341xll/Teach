<?php   session_start();
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
<div class="zhifu_bz">
<div class="zhifu_bz_l"><img src="images/zfbz_gndh.jpg" width="166" height="23" id="daohang">
<ul>

<li><a href="zxzf_zfb.php">支付宝</a></li>
<li><a href="zxzf_cft.php">财付通</a></li>
<li><a href="zxzf_yhkzz.php">银行卡转账</a></li>
</ul>
<img src="images/zfbz_zflianxi.jpg" width="157" height="134" border="0" usemap="#lianxiMap" id="lianxi">
<map name="lianxiMap">
  <area shape="rect" coords="12,76,138,107" href="zxzf_bz.php">
</map>
</div>
<div class="zhifu_bz_r">
<div class="zhifu_bz_banner"><img src="images/index_zfbz_banner.jpg" width="772" height="91"></div>
<div class="zhifu_bz_zxzfjs"><img src="images/zxzf_js.jpg" width="761" height="25"></div>
<div class="zxzfjs">
	<?php
	$classData = $bw->selectOnly('content' ,'bw_base', 'id = 17');
	echo $classData['content'];
	?>
</div>
<div class="zhifu_bz_zxzfjs"><img src="images/zxzf_cjwt.jpg" width="761" height="25"></div>
<div class="zxzfjs">
    <?php
	$classData = $bw->selectOnly('content' ,'bw_base', 'id = 18');
	echo $classData['content'];
	?>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
