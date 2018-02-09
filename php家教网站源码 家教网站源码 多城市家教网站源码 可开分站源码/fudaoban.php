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
	$sid = $_GET['sid'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<title>
<?php 
if(!empty($sid)){
     $newsTitle = $bw->selectOnly('className', 'bw_articleclass', 'id = '.$sid); echo $newsTitle['className'];
}else{
     echo "辅导班";
}
?>_<?php echo $service_title; ?></title>
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
		location.href="news.php?page="+thisPage.val()+"&sid="+<?php echo $sid; ?>;
		});//end page_SEL 		
	});
</script>
<?php include("top.php");?>
<!-- header end-->
<div id="all_main_all">
     <div id="fudaoban_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div id="all_main_all_box">
	      <div id="all_main_all_box_left">
		       <div id="all_main_all_box_left_top">当前位置：辅导班<?php echo "&nbsp;&nbsp;".$newsTitle['className'];?></div>
			   <div id="all_main_all_box_left_mid">
			        <div id="dowmload_box">
					     <div id="title">
						  <div class="tltle_box" style="padding-left:20px; margin-right:160px;">辅导班名称</div>
						  <div style="width:130px; height:38px; line-height:38px; text-align:center; float:right; color:#ff510a; font-weight:bold">发布时间</div> 
						 </div>
						 <div class="clear"></div>
						 <div id="dowmload_box_center">
						 <table width="100%" border="0" cellpadding="0" cellspacing="0">
			 <?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_article';
				  
				  if(!empty($sid))
				  {
				 	 $where    = 'classId = '.$sid;
				  }else{
					  $where    = 'classId not in(4)';
				  }
				  $hyzxlist = $bw->selectPage("id, title, subTime", $tbName,"classId=12", "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,"classId=12",$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
			  ?>
						  <tr>
							<td width="80%" style="border-bottom:1px dashed #CCCCCC;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="fudaobanshow.php?id=<?php echo $hyzxlist[$hyzxi]['id'] ;?>" target="_blank"><?php echo $hyzxlist[$hyzxi]['title'] ;?></a></td>
							<td width="20%" align="center" style="border-bottom:1px dashed #CCCCCC;">
							[<?php echo date("Y-m-d",strtotime($hyzxlist[$hyzxi]['subTime']));?>]</td>
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
						<option value="news.php?page=<?php echo $goPage; ?>&sid=<?php echo $sid; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
                  </select>
						 </div>
					</div>
			   </div>
		  </div>
		  <div id="all_main_all_box_right">
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
			   <?php include("fudaobanright.php");?>
		  </div>
	 </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
