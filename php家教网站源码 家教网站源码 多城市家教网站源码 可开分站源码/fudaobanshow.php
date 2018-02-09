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
	//selectOnly($param,$tbname,$where,$order='')
	$id = $_GET['id'];
	if(empty($id))
	{
		echo "<script>location.href='index.php'; </script>";	
	}else{
		$newsData = $bw->selectOnly('*', 'bw_article', 'id = '.$id);
		$bw->query('UPDATE bw_article SET hits = hits+1 WHERE id = '.$id);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<title><?php echo $newsData['title']; ?>_<?php echo $service_title; ?></title>
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
     <div id="fudaoban_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div id="about_main_all_box">
	      <div id="about_main_all_box_left">
		       <div id="about_main_all_box_left_top">当前位置：辅导班信息</div>
			   <div id="about_main_all_box_left_mid">
			   <div style="margin:0 auto; text-align:center; border-bottom:1px #CCCCCC dashed; height:40px;">
			   <h3 style="font-size:16px; color:#000000"><?php echo $newsData['title']; ?></h3>
			   点击（<?php echo $newsData['hits']; ?>）&nbsp;&nbsp;发布时间:<?php echo $newsData['subTime']; ?>
			   </div>
			   <br>
			    <?php echo $newsData['content'];?>
			   <br>
			   <span style="float:right;"><a href="###" onClick="javacript:window.close()">[关闭]</a></span>
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
								$classList = $bw->selectMany("id,className","bw_articleclass"," id='12'","`id` ASC");
								//var_dump($classList);
								//exit;
								$menu_sum = count($classList);
								for($i = 0; $i<$menu_sum; $i++)
								{
							?>
						      <div class="list">
							   <div class="left"></div>
							   <div class="center"><a href="fudaoban.php?sid=<?php echo $classList[$i]['id'];?>"><?php echo $classList[$i]['className'];?></a></div>
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
