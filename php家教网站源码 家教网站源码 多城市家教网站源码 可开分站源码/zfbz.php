<?php 
session_start();
if(!empty($_GET["lang"])){
setcookie("cookie_lang",base64_decode(iconv("gb2312","utf-8",$_GET["lang"])), time()+2592000);
echo "<script language='javascript'>	window.location.href='zfbz.php';  </script>";
}
if($_COOKIE["cookie_lang"]=="")
{
setcookie("cookie_lang","宁波站", time()+2592000);
echo "<script language='javascript'>	window.location.href='index.php';  </script>";
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
$classData = $bw->selectOnly('content,title' ,'bw_zfbz', 'lang ="'.$_COOKIE["cookie_lang"].'"',"id asc","1");
}else{
$classData = $bw->selectOnly('content,title' ,'bw_zfbz', 'lang ="'.$_COOKIE["cookie_lang"].'" and id = '.$id);
}
?>
<!-- header end-->
<div id="zfbz_main_all">
	 <div id="zfbz_main_all_box">
	      <div id="zfbz_main_all_box_left">
		       <div id="zfbz_main_all_box_left_top">
			   <b style="font-size:16px; color:#fe5009;">资费标准</b> 当前位置：资费标准><?php echo $classData['title'];?>
			   </div>
			   <div id="zfbz_main_all_box_left_mid">
			   <div style="border:1px #ececec solid; padding:1px;">
			   <div style="margin:0 auto; text-align:center; height:40px; background:#f6f6f6; line-height:40px;">
			   <h3 style="font-size:16px; color:#000000"><?php echo $classData['title'];?></h3>
			   </div>
			   </div>
			   <br>
			   <?php echo $classData['content'];?>
			   </div>
		  </div>
		  <div id="zfbz_main_all_box_right">
		       <div id="zfbz_main_all_box_right_menu">
			        <div id="top"><img src="images/about_right_top_01.jpg"></div>
					<div id="mid">
					     <div id="nav"><img src="images/about_right_top_07.jpg"></div>
						 <div id="dh">
						     <?php
								//selectMany($param,$tbname,$where,$order,$limit)
								$classList = $bw->selectMany("id,title","bw_zfbz","lang='".$_COOKIE["cookie_lang"]."'","`id` ASC");
								//var_dump($classList);
								//exit;
								$menu_sum = count($classList);
								for($i = 0; $i<$menu_sum; $i++)
								{
							?>
						      <div class="list">
							       <div class="left"></div>
								   <div class="center"><a href="zfbz.php?id=<?php echo $classList[$i]['id'];?>"><?php echo $classList[$i]['title'];?></a></div>
								   <div class="right"></div>
							  </div>
							<?php
								}//end loop
							?>
						 </div>
					</div>
					<div id="bot"></div>
			   </div>
			   <?php include("right.php");?>
		  </div>
	 </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
