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
<?php
if($_GET["act"]=="pic")
{
	$xwData = $bw->selectOnly('sfzpic,byzpic,zgzspic','bw_member',"username = '".$_SESSION["hyusername"]."'");
	if(!empty($_FILES['sfzpic']['name']))
		{
            if(!empty($xwData["sfzpic"]))
			{
				unlink($xwData["sfzpic"]);
				}
			$fileName = $bw->upload('pic/',2048000000000000000000,'sfzpic');
			if($fileName)
			{
				$_POST['sfzpic'] = $fileName;
			}
		}
		else
		{
			$_POST['sfzpic']=$xwData["sfzpic"];
		}
	if(!empty($_FILES['byzpic']['name']))
		{
            if(!empty($xwData["byzpic"]))
			{
				unlink($xwData["byzpic"]);
				}
			$fileName = $bw->upload('pic/',2048000000000000000000,'byzpic');
			if($fileName)
			{
				$_POST['byzpic'] = $fileName;
			}
		}
		else
		{
			$_POST['byzpic']=$xwData["byzpic"];
		}
	if(!empty($_FILES['zgzspic']['name']))
		{
            if(!empty($xwData["zgzspic"]))
			{
				unlink($xwData["zgzspic"]);
				}
			$fileName = $bw->upload('pic/',2048000000000000000000,'zgzspic');
			if($fileName)
			{
				$_POST['zgzspic'] = $fileName;
			}
		}
		else
		{
			$_POST['zgzspic']=$xwData["zgzspic"];
		}
		unset($_POST["x"]);
		unset($_POST["y"]);
		if($bw->update('bw_member', $_POST, "username = '".$_SESSION["hyusername"]."'"))
		{
			$bw->msg('提交成功!');
		}else{
			$bw->msg('提交失败!', '', true);
		}
}
?>
<BODY>
<?php include("top.php");?>
<!-- header end-->
<div class="user_c">
<div class="user_left">
<?php include("user_left.php");?>
</div>
<div class="user_right">
     <div id="xcrz_tltle">
	      <div class="xcrz_tltle_l">上传证件</div>
		  <div class="xcrz_tltle_r">网上认证第一步</div>
	 </div>
     <div id="wsrz_nr">
       <form action="?act=pic" method="post" enctype="multipart/form-data" name="pic" id="pic">
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="color:#333333">
           <tr>
             <td width="10%" height="30">&nbsp;</td>
             <td colspan="2">1.身份证(必须上传)：</td>
             <td width="44%">【提示】上传认证图片说明</td>
           </tr>
           <tr>
             <td height="30"><label></label></td>
             <td height="30" colspan="2"><input name="sfzpic" type="file" class="wsrz_input" id="sfzpic" size="40"></td>
             <td>1.单张图片文件大小在<b style="color:#ff0000">5M以内</b></td>
           </tr>
           <tr>
             <td height="30">&nbsp;</td>
             <td height="30" colspan="2">2.学生证或毕业证(大学生必须上传)：</td>
             <td>2.支持的图片格式：<b style="color:#ff0000">JPG/GIF/PNG</b></td>
           </tr>
           <tr>
             <td height="30">&nbsp;</td>
             <td height="30" colspan="2"><input name="byzpic" type="file" class="wsrz_input" id="byzpic" size="40"></td>
             <td>3.证件上姓名、号码必须清晰</td>
           </tr>
           <tr>
             <td height="30">&nbsp;</td>
             <td height="30" colspan="2">3.教师资格证书(离职进修老师必须上传)：</td>
             <td>4.本站承诺对您个人认证资料进行保密</td>
           </tr>
           <tr>
             <td height="30">&nbsp;</td>
             <td height="30" colspan="2"><input name="zgzspic" type="file" class="wsrz_input" id="zgzspic" size="40"></td>
             <td>5.可用数码相机或手机将证件正面拍照上传</td>
           </tr>
           <tr>
             <td height="30" colspan="4">&nbsp;</td>
           </tr>
           <tr>
             <td height="40" colspan="4" align="center" valign="top">
			 <table width="80%" border="0" align="left" cellpadding="0" cellspacing="0">
               <tr>
                 <td height="30" align="right"><input type="image" src="images/wsrz_input.jpg" onClick="pic.submit()"></td>
                 <td align="left">&nbsp;&nbsp;(请勿上传与证件无关的照片) </td>
               </tr>
             </table>             </td>
           </tr>
         </table>
       </form>
    </div>
	<div id="xcrz_tltle">
	      <div class="xcrz_tltle_l">认证付费</div>
		  <div class="xcrz_tltle_r">网上认证第二步</div>
    </div>
    <div id="wsrz_nr">
      <?php
			$classData = $bw->selectOnly('content,title' ,'bw_base', 'id = 7');
            echo $classData['content'];
	  ?>
    </div>
</div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
