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
					       <div style="width:635px; height:36px; background:#f4f4f4; padding-left:35px;"> <strong>新教员注册第一步:</strong><font color="#fe5d08">1</font>阅读教员注册协议</div>
					  </div>
					  <div id="tutor_box_center">
					    <form action="tutor_reg.php" method="post">
						<div style="width:603px; height:auto; margin:0 auto">
						<?php
						$classData = $bw->selectOnly('content,title' ,'bw_base', 'id = 6');
						?>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="100" align="center"><b style="font-size:16px;"><?php echo $classData['title'];?></b></td>
                          </tr>
                          <tr>
                            <td style="line-height:30px;"><?php echo $classData['content'];?></td>
                          </tr>
                          <tr>
                            <td height="100" align="center"> <label>
                              <input name="jiesou" type="checkbox" id="jieshou" value="1" checked>
                            </label>
                            我接受《宁波家教网教员注册协议》（接受此项是成为宁波家教中心教员的前提！）</td>
                          </tr>
                          <tr>
                            <td height="75" align="center"><label>
                              <input type="image" name="Submit" src="images/zjj_05.jpg" onClick="javascript:if(document.getElementById('jieshou').checked==false){alert('请点击接受《宁波家教中心教员服务协议》');return false;}">
                            </label>&nbsp;
                              <label>
                              <input type="image" name="Submit2" src="images/zjj_06.jpg" onClick="javascript:location.href='index.php'">
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
