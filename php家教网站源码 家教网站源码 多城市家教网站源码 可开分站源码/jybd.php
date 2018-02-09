<?php 
session_start();
if(!empty($_GET["lang"])){
setcookie("cookie_lang",base64_decode(iconv("gb2312","utf-8",$_GET["lang"])), time()+2592000);
echo "<script language='javascript'>window.location.href='index.php';  </script>";
}
if($_COOKIE["cookie_lang"]=="")
{
setcookie("cookie_lang","宁波站", time()+2592000);
echo "<script language='javascript'>window.location.href='index.php';  </script>";
}
include 'inc/config.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
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
<?php
//查找一条数
$id=$_GET["id"];
if(empty($id)){
$id=6;
}
$classData = $bw->selectOnly('content,title' ,'bw_base', 'id = '.$id);
?>
<!-- header end-->
<div id="about_main_all">
     <div id="about_main_all_benner"><img src="images/jybd_benner.jpg" width="960" height="68" border="0"></div>
	 <div id="about_main_all_box">
	      <div id="about_main_all_box_left">
		       <div id="about_main_all_box_left_top">当前位置：教员必读</div>
			   <div id="about_main_all_box_left_mid">
			   <div style="margin:0 auto; text-align:center; border-bottom:1px #CCCCCC dashed; height:40px;">
			   <h3 style="font-size:16px; color:#000000"><?php echo $classData['title'];?></h3>
			   </div>
			   <br>
			    <?php echo $classData['content'];?>
			   </div>
		  </div>
		  <div id="about_main_all_box_right">
		       <div id="about_main_all_box_right_menu">
			        <div id="top"><img src="images/about_right_top_01.jpg"></div>
					<div id="mid">
					     <div id="nav"><img src="images/about_right_top_07.jpg"></div>
						 <div id="dh">
						      <?php
								//selectMany($param,$tbname,$where,$order,$limit)
								$classList = $bw->selectMany("id,title","bw_base","classId=4","`id` ASC");
								//var_dump($classList);
								//exit;
								$menu_sum = count($classList);
								for($i = 0; $i<$menu_sum; $i++)
								{
							?>
						      <div class="list">
							       <div class="left"></div>
								   <div class="center"><a href="jybd.php?id=<?php echo $classList[$i]['id'];?>"><?php echo $classList[$i]['title'];?></a></div>
								   <div class="right"></div>
							  </div>
							<?php
								}//end loop
							?>
						 </div>
					</div>
					<div id="bot"></div>
			   </div>
			   <div id="about_main_all_box_right_lx">
			        <div id="top"></div>
				    <div id="mid">
					     <div id="box1"></div>
						 <div class="box2">
						 <span style="font-size:14px; font-weight:bold;">0592-5835515 0592-5531812</span>
						 <br>
						 <a href="###"><span style="font-size:14px; font-weight:bold; color:#fe620c; letter-spacing:2px;">24小时提交家教需求>></span></a>
						 </div>
						 <div id="box3"></div>
						 <div class="box2">
						 <span style="font-size:14px; font-weight:bold;">0592-5531812</span>
						 <br>
						 <span style="font-size:14px; font-weight:bold; color:#fe620c;">工作时间：8:30-22:00</span>
						 <br>
						 <span style="font-size:14px; font-weight:bold; color:#fe620c;">节假无休，服务全市</span>
						 </div>
					</div>
				    <div id="bot"></div>
			   </div>
		  </div>
	 </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
