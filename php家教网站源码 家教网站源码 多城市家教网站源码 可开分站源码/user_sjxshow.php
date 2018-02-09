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
<!-- saved from url=(0054)#?WT.mc_id=c03-BDPP-101&WT.srch=1 -->
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<title><?php echo $service_title; ?></title>
<meta name="keywords" content="<?php echo $service_keyword.'-'.$service_title; ?>" />
<meta name="description" content="<?php echo $service_description.'-'.$service_title; ?>" />
<META http-equiv=content-type content="text/html; charset=utf-8">
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico">
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</HEAD>
<BODY>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="user_sjx.php?page="+thisPage.val();
		});//end page_SEL 		
	});

</script>
 <script>
		function delconfirm(dlid){
		if(confirm("你确定删除吗?")){
		window.location.href="?act=yes&dlid="+dlid
		}
		}
</script> 
<script>
			function yinc(id)
{
	if(document.getElementById(id).style.display=="")
	{
		document.getElementById(id).style.display='none';
	}else{
		document.getElementById(id).style.display='';
		}
}
</script>
<?php
	//查找一条数
	$id=$_GET["id"];
	$classData = $bw->selectOnly('*' ,'bw_zxwdhf', 'id = '.$id);
	$sql = "UPDATE bw_zxwdhf SET ifyd = 0 WHERE id = ".$id;
	$bw->query($sql);
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
      <td width="93" height="25" align="center" valign="middle" style="border-right:1px solid #D3D3D3;border-bottom:1px solid #D3D3D3;"><a href="user_fsxx.php"><strong>发送信息</strong></a></td>
      <td width="85" align="center" valign="middle" style="border-right:1px solid #D3D3D3; background:#FFF; border-bottom:1px solid #FFF;"><a href="###"><strong>收件箱</strong></a></td>
      <td width="81" align="center" valign="middle" style="border-right:1px solid #D3D3D3;border-bottom:1px solid #D3D3D3;"><a href="user_yfxx.php"><strong>已发信息</strong></a></td>
      <td width="398" style="border-bottom:1px solid #D3D3D3;">&nbsp;</td>
    </tr>
  </table>
</div>
<div class="user_sjx_nr">
<table width="724" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9">
    <tr>
      <td height="34" align="center" valign="middle" background="images/user_sjx_bt_bg.jpg"><?php echo $classData['title'] ;?></td>
      </tr>
    <tr>
      <td height="34" align="center" valign="middle" bgcolor="#FFFFFF">
	  类型：<?php
	  if($classData['xxlx']==1)
	  { 
	  echo "单条信息";
	  }else{
	  echo "群发信息";
	  }
	  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;收件人：<?php if($classData['username']==""){echo $_SESSION["hyusername"];}else{echo $classData['username'];} ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;留言时间：<?php echo $classData['addtime'];?></td>
      </tr>
	<tr>
      <td height="32" align="center" valign="middle" bgcolor="#FFFFFF" style="color:#003399">&nbsp;<?php echo $classData['content'] ;?></td>
      </tr>
	  <tr>
      <td height="32" align="center" valign="middle" bgcolor="#FFFFFF" style="color:#003399"><a href="javascript:history.go(-1);">返回</a></td>
      </tr>
  </table>
</div>
</div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
