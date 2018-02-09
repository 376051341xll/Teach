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
<!-- header end-->
<div id="about_main_all">
     <div id="link_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div id="about_main_all_box">
	      <div id="about_main_all_box_left">
		       <div id="about_main_all_box_left_top">当前位置：友情链接</div>
			   <div id="about_main_all_box_left_mid">
			   <h3>文字连接</h3>
			   <ul class="linkUl">
				<?php
					//selectMany($param,$tbname,$where,$order,$limit)
					$linkeData = $bw->selectMany("id, url, title", 'bw_friendlink', "isshow = 1 AND type = 1", "`id` DESC", '');
					$linksum = count($linkeData);
					for($linki = 0; $linki<$linksum; $linki++)
					{
				?>
					<li><a href="<?php echo $linkeData[$linki]['url']; ?>" title="<?php echo $linkeData[$linki]['title']; ?>" target="_blank"><?php echo mb_substr($linkeData[$linki]['title'],0,6,'utf-8'); ?></a></li>
				<?php
					}//end loop
				?>
			   </ul>
			   <br>
			   <br>
			   <h3>图片连接</h3>
			   <ul class="linkUl">
			   <?php
					//selectMany($param,$tbname,$where,$order,$limit)
					$linkeData = $bw->selectMany("id, url, title,pic", 'bw_friendlink', "isshow = 1 AND type = 2", "`id` DESC", '');
					$linksum = count($linkeData);
					for($linki = 0; $linki<$linksum; $linki++)
					{
				?>
					<li><a href="<?php echo $linkeData[$linki]['url']; ?>" title="<?php echo $linkeData[$linki]['title']; ?>" target="_blank"><img src="<?php echo $linkeData[$linki]['pic']; ?>" width="173" height="58" style="border:1px #CCC solid;"></a></li>
				<?php
					}//end loop
				?>
				</ul>
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
								$classList = $bw->selectMany("id,title","bw_base","classId=1","`id` ASC");
								//var_dump($classList);
								//exit;
								$menu_sum = count($classList);
								for($i = 0; $i<$menu_sum; $i++)
								{
							?>
						      <div class="list">
							       <div class="left"></div>
								   <div class="center"><a href="about.php?id=<?php echo $classList[$i]['id'];?>"><?php echo $classList[$i]['title'];?></a></div>
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
