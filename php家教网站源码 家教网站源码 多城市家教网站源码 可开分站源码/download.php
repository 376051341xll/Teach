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
<title>学习资料下载-<?php echo $service_title; ?></title>
<meta name="keywords" content="<?php echo $service_keyword.'-'.$service_title; ?>" />
<meta name="description" content="<?php echo $service_description.'-'.$service_title; ?>" />
<META http-equiv=content-type content="text/html; charset=utf-8">
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico"><script type="text/JavaScript">
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
		location.href="download.php?page="+thisPage.val()+"&sid="+<?php echo $sid; ?>;
		});//end page_SEL 		
	});
</script>
<?php include("top.php");?>
<!-- header end-->
<div id="all_main_all">
     <div id="download_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div id="all_main_all_box">
	      <div id="all_main_all_box_left">
		       <div id="all_main_all_box_left_top">当前位置：资料下载</div>
			   <div id="all_main_all_box_left_mid">
			        <div id="dowmload_box">
					     <div id="title">
						      <div class="tltle_box" style="padding-left:20px; margin-right:160px;">资料名称</div>
							  <div class="tltle_box tltle_box_center">资料格式</div>
							  <div class="tltle_box tltle_box_center">上传时间</div>
							  <div class="tltle_box tltle_box_center">快速下载</div>
						 </div>
						 <div class="clear"></div>
						 <div id="dowmload_box_center">
						 <table width="672" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
			   <?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_article';
				  $sid=4;
				  if(!empty($sid))
				  {  
				 	 $where    = 'classId = '.$sid;
				  }else{
					  $where    = '';
				  }
				  $hyzxlist = $bw->selectPage("id,title,subTime,wjgs,pic", $tbName, $where, "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
			  ?>
						  <tr>
							<td width="300">&nbsp;&nbsp;<a href="downshow.php?id=<?php echo $hyzxlist[$hyzxi]['id'] ;?>" target="_blank"><?php echo $hyzxlist[$hyzxi]['title'] ;?></a></td>
							<td width="122" align="center" style="color:#e85505"><?php echo $hyzxlist[$hyzxi]['wjgs'] ;?></td>
							<td width="122" align="center">[<?php echo date("Y-m-d",strtotime($hyzxlist[$hyzxi]['subTime']));?>]</td>
							<td width="122" align="center" valign="middle">
							<a href="<?php echo $hyzxlist[$hyzxi]['pic'] ;?>"><img src="images/download_list.jpg" width="61" height="19"></a>
							</td>
						  </tr>
				<?php
                  }//end loop
                ?>		  
						 </table>
						 </div>
						 <div id="dowmload_box_page">
						 共:<?php echo $pageArray['totalRow']; ?>条信息&nbsp;&nbsp;&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>&nbsp;页&nbsp;&nbsp;&nbsp;
				<a href="?cid=<?php echo $sid; ?>&page=1">首页</a>&nbsp;&nbsp;
				<a href="?cid=<?php echo $sid; ?>&page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?cid=<?php echo $sid; ?>&page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?cid=<?php echo $sid; ?>&page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
				转到
						<select name="page_SEL" onChange="MM_jumpMenu('parent',this,0)">
                   	<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="download.php?page=<?php echo $goPage; ?>&sid=<?php echo $sid; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
                  </select>
						 </div>
					</div>
			   </div>
		  </div>
		  <div id="all_main_all_box_right">
		       <div id="all_main_all_box_right_menu">
			        <div id="top"><img src="images/about_right_top_01.jpg"></div>
					<div id="mid">
					     <div id="nav"><img src="images/about_right_top_07.jpg"></div>
						 <div id="dh">
						      <div class="list">
							       <div class="left"></div>
								   <div class="center"><a href="download.php">资料下载</a></div>
								   <div class="right"></div>
							  </div>
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
