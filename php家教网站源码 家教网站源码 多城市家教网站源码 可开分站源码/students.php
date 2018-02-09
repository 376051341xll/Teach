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
$diaoquData = $bw->selectOnly('*', 'bw_config', ' lang="'.$_COOKIE["cookie_lang"].'" ', '');
if( $_GET['act']=="k")
{
$_SESSION['wherestudents']="";
}
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
<link rel="Bookmark" href="favicon.ico"><script type="text/javascript" src="js/jquery.js"></script>
</HEAD>
<BODY>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="students.php?page="+thisPage.val();
		});//end page_SEL 		
	});
</script>
<?php include("top.php");?>
<!-- header end-->
<div id="students_main">
     <div id="students_main_header">
	      <div id="top">
		       <div id="left">学员库</div>
			   <div id="right">
			   <span style="float:left; margin-left:270px; margin-top:2px; color:#90805c; font-size:20px"><?php echo $service_bphone; ?></span>
			   </div>
		  </div>
		   <div id="bot">
		        <div id="lcone"></div>
				<div class="lctwos">
				     <div class="lctwo_tops"><!--<img src="images/xyk_04.jpg">--></div>
					 <div class="lctwo_mids">
					      <div class="lctwo_mid_titles">结单</div>
						  <div class="lctwo_mid_nrs">①试教成功,本站核实扣款②试教失败,本站核实后,您可以申请退款,或用作下次预约使用</div>
					 </div>
					 <div class="lctwo_bots"></div>
				</div>
				<div class="lcthree"></div>
				<div class="lctwo">
				     <div class="lctwo_top"><!--<img src="images/xyk_04.jpg">--></div>
					 <div class="lctwo_mid">
					      <div class="lctwo_mid_title">试教</div>
						  <div class="lctwo_mid_nr">确定试教时间,并反馈试教情况</div>
					 </div>
					 <div class="lctwo_bot"></div>
				</div>
				<div class="lcthree"></div>
				<div class="lctwo">
				     <div class="lctwo_top"><!--<img src="images/xyk_04.jpg">--></div>
					 <div class="lctwo_mid">
					      <div class="lctwo_mid_title">预存信息费</div>
						  <div class="lctwo_mid_nr">说明：<a href="newsshow.php?id=550" target="_blank"><font color="#fd7933">含代收学员会员费</font></a></div>
					 </div>
					 <div class="lctwo_bot"></div>
				</div>
				<div class="lcthrees"></div>
				<div class="lctwo">
				     <div class="lctwo_top"><!--<img src="images/xyk_04.jpg">--></div>
					 <div class="lctwo_mid">
					      <div class="lctwo_mid_title">在线申请</div>
						  <div class="lctwo_mid_nr">①在线申请订单②本站推荐订单</div>
					 </div>
					 <div class="lctwo_bot"></div>
				</div>
				<div class="lcthree"></div>
				<div class="lctwo">
				     <div class="lctwo_top"><!--<img src="images/xyk_04.jpg">--></div>
					 <div class="lctwo_mid">
					      <div class="lctwo_mid_title">立即认证</div>
						  <div class="lctwo_mid_nr">①上传相关证件②缴纳认证费</div>
					 </div>
					 <div class="lctwo_bot"></div>
				</div>
				<div class="lcthree"></div>
				<div class="lctwo">
				     <div class="lctwo_top"><!--<img src="images/xyk_04.jpg">--></div>
					 <div class="lctwo_mid">
					      <div class="lctwo_mid_title">在线注册</div>
						  <div class="lctwo_mid_nr">如果您还没成为教员,请点击<a href="tutor.php"><font color="#fd7933">注册</font></a></div>
					 </div>
					 <div class="lctwo_bot"></div>
				</div>
		   </div>
	 </div>
	 <div id="students_main_mid">
	      <div id="students_main_mid_top">综合检索</div>
		  <div id="students_main_mid_bots">
		    <form name="form1" method="post" action="?action=search">
		      <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="780" align="left">
				    &nbsp;订单编号：
				    <input name="ddbh" type="text" id="ddbh" size="12">
				    &nbsp;科目：<input name="qjkm" type="text" id="qjkm" size="12">
					&nbsp;性别：<select name="xysex" id="xysex">
					                    <option selected="selected" value="">--请选择--</option>
										<option value="男">男</option>
										<option value="女">女</option>
				               </select>
					&nbsp;区域：<select name="szqy" id="szqy">
                              <option selected="selected" value="">--请选择--</option>
									  <?php
							$dir=$diaoquData["quyu"];
							$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
							for($i=0;$i<count($split_dir);$i++)
							
							{  ?>
									  <option value="<?php echo $split_dir[$i];?>" ><?php echo $split_dir[$i];?></option>
										  <?php
							}
										  ?>
								  </select>
					&nbsp;年级：<select name="xynj" id="xynj">
                              <option selected="selected" value="">--请选择--</option>
									  <?php
							$dir=$diaoquData["nianji"];
							$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
							for($i=0;$i<count($split_dir);$i++)
							
							{  ?>
									  <option value="<?php echo $split_dir[$i];?>" ><?php echo $split_dir[$i];?></option>
										  <?php
							}
										  ?>
								  </select>
					&nbsp;类型：
					<select name="xylx" id="xylx">
										<option selected="selected" value="">选择类型</option>
										<option value="零基础">零基础</option>
										<option value="补差型">补差型</option>
										<option value="提高型">提高型</option>
										<option value="拔尖型">拔尖型</option>
                </select></td>
			   <td width="80" align="left">
		        <input type="image" name="Submit" src="images/xyk_07.jpg"></td>
			   <td width="80" align="left"><a href="students.php?act=k"><img src="images/xyk_10.jpg"></a></td>
			  </tr>
			</table>
			</form>
	      </div>
	 </div>
	 <div id="students_main_box">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td width="12%" bgcolor="#f97a44" class="students_td">学员编号</td>
		   <td width="8%" bgcolor="#f97a44" class="students_td">学员姓名</td>
           <td width="10%" align="center" bgcolor="#f97a44" class="students_td">求教学科</td>
           <td width="10%" align="center" bgcolor="#f97a44" class="students_td">学员年级</td>
           <td width="10%" bgcolor="#f97a44" class="students_td">性别</td>
           <td width="8%" bgcolor="#f97a44" class="students_td"><STRONG>学习情况</STRONG></td>
           <td width="10%" bgcolor="#f97a44" class="students_td">所在区域</td>
           <td width="10%" bgcolor="#f97a44" class="students_td"><STRONG>状态</STRONG></td>
           <td width="12%" bgcolor="#f97a44" class="students_td">发布时间</td>
           <td width="10%" align="center" bgcolor="#f97a44"><span style="color:#FFFFFF; font-weight:bold;">详情</span></td>
         </tr>
		<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_qjj";
  $where    = "1=1 and isshow=2  and lang='".$_COOKIE["cookie_lang"]."'";
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	 if(!empty($_POST['ddbh'])){
		$where =$where . " and id LIKE '%".$_POST['ddbh']."%'"; 
		$_SESSION['wherestudents'] = $where;
	  }
	 if(!empty($_POST['qjkm'])){
		$where =$where . " and qjkm LIKE '%".$_POST['qjkm']."%'"; 
		$_SESSION['wherestudents'] = $where;
	  }
	  if(!empty($_POST['xysex'])){
		$where =$where . " and xysex = '".$_POST['xysex']."'";  
		$_SESSION['wherestudents'] = $where;
	  }
	  if(!empty($_POST['szqy'])){
		$where =$where . " and szqy LIKE '%".$_POST['szqy']."%'";  
		$_SESSION['wherestudents'] = $where;
	  }
	  if(!empty($_POST['xynj'])){
		$where =$where . " and xynj LIKE '%".$_POST['xynj']."%'";  
		$_SESSION['wherestudents'] = $where;
	  }
	  if(!empty($_POST['xylx'])){
		$where =$where . " and xylx LIKE '%".$_POST['xylx']."%'";  
		$_SESSION['wherestudents'] = $where;
	  }
  }
  if($_SESSION['wherestudents']=="")
  {
	$_SESSION['wherestudents'] = $where;  
  }
   //die($_SESSION['wherestudents']);
  $list = $bw->selectPage("*",$tbName,$_SESSION['wherestudents'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wherestudents'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
         <tr>
           <td height="50" align="center" bgcolor="#fff7f0" class="students_td2"><?php echo $list[$i]['id'];?></td>
		   <td align="center" class="students_td2"><span><?php echo chgtitles($list[$i]['name'],1); ?>同学</span></td>
           <td align="center" class="students_td2">&nbsp;&nbsp;<?php echo $list[$i]['qjkm']; ?></td>
           <td align="center" class="students_td2"><?php echo $list[$i]['xynj']; ?></td>
           <td align="center" class="students_td2"><span><?php echo $list[$i]['xysex']; ?></span></td>
           <td align="center" class="students_td2"><?php echo $list[$i]['xylx']; ?></td>
           <td align="center" class="students_td2"><span><?php echo $list[$i]['szqy']; ?></span></td>
           <td align="center" class="students_td2"><?php if($list[$i]['zt']=="正在试教"){echo "<font color='#FF0000'>".$list[$i]['zt']."</font>";}elseif($list[$i]['zt']=="未安排"){echo $list[$i]['zt'];}elseif($list[$i]['zt']=="已安排"){echo $list[$i]['zt'];}elseif($list[$i]['zt']=="成功"){echo "<font color='#0000FF'>".$list[$i]['zt']."</font>";} ?></td>
           <td align="center" class="students_td2"><?php echo date("Y-m-d",strtotime($list[$i]['addtime']));?></td>
           <td align="center" class="students_td2"><a href="studentshow.php?id=<?php echo $list[$i]['id'];?>" target="_blank"><span>[查看]</span></a></td>
         </tr>
	      <?php
			  }//end loop
		  ?>
       </table>
	   <div id="students_main_box_page">
	   共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="?page=1">第一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
				跳到
				<select name="page_SEL" id="page_SEL">
						<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="<?php echo $goPage; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
			  </select>
	   </div>
	 </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
