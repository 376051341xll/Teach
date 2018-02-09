<?php 
session_start(); 
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
$diaoquData = $bw->selectOnly('*', 'bw_config', ' lang="'.$_COOKIE["cookie_lang"].'" ', '');
if( $_GET['act']=="k")
{
$_SESSION['whereyyzc']="";
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
		location.href="yszc.php?page="+thisPage.val();
		});//end page_SEL 		
	});
</script>
<?php include("top.php");?>
<!-- header end-->
<div id="students_main">
     <div id="students_main_header" style="height:25px">
	      <div id="top">
		       <div id="left">艺术专才</div>
			   <div id="right">
			   <span style="float:left; margin-left:270px; margin-top:2px; color:#90805c; font-size:20px"><?php echo $service_bphone; ?></span>
			   </div>
		  </div>
     </div>
	 <div id="students_main_mid">
	      <div id="students_main_mid_top">综合检索</div>
		  <div id="students_main_mid_bots">
		      <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <form name="form1" method="post" action="yszc.php?action=search_zcjs">
			  <tr>
				<td width="820" align="left">
                    &nbsp;编号：
                    <input name="bh" type="text" id="bh" size="10">
					&nbsp;科目：
                    <input name="km" type="text" id="km" size="10">
					&nbsp;毕业学校：<input name="byxx" type="text" id="byxx" size="15">	
					&nbsp;性别：<select name="sex" id="sex">
					                    <option selected="selected" value="">--请选择--</option>
										<option value="1">男</option>
										<option value="2">女</option>
				               </select>
					&nbsp;区域：<select name="qy" id="qy">
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
					&nbsp;类型：
					<select name="lx" id="lx">
							<option selected="selected" value="">选择类型</option>
							<option value="1">大学生</option>
							<option value="2">职业教师</option>
							<option value="3">留学、海归</option>
							<option value="4">其他</option>
                  </select>
			   </td>
			   <td width="70" align="left">
		        <input type="image" name="Submit" src="images/xyk_07.jpg"></td>
			   <td width="70" align="left"><a href="yszc.php?act=k"><img src="images/xyk_10.jpg"></a></td>
			  </tr>
			  </form>
			</table>
	      </div>
	 </div>
	 <div id="students_main_box">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td width="7%" bgcolor="#f97a44" class="students_td">教员编号</td>
           <td width="7%" bgcolor="#f97a44" class="students_td">教员类型</td>
           <td width="8%" bgcolor="#f97a44" class="students_td">姓名</td>
           <td width="8%" bgcolor="#f97a44" class="students_td">性别</td>
           <td width="8%" bgcolor="#f97a44" class="students_td">目前身份</td>
           <td width="8%" bgcolor="#f97a44" class="students_td">教员类型</td>
           <td width="16%" bgcolor="#f97a44" class="students_td">毕业学校</td>
           <td width="16%" bgcolor="#f97a44" class="students_td"><STRONG>可教授科目</STRONG></td>
           <td width="8%" bgcolor="#f97a44" class="students_td">登入时间</td>
           <td width="8%" align="center" bgcolor="#f97a44"><span style="color:#FFFFFF; font-weight:bold;">详情</span></td>
         </tr>
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_member";
  $where    = "1=1 and iffb=2 and (sklx<>'普通' or ifzc=2) and lang='".$_COOKIE["cookie_lang"]."' ";
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search_zcjs')
  {
     if(!empty($_GET['seachkey'])){
		$where =$where . " and kjskm LIKE '%".$_GET['seachkey']."%'"; 
		$_SESSION['whereyyzc'] = $where;
	  }
	 if(!empty($_POST['bh'])){
		$where =$where . " and id LIKE '%".$_POST['bh']."%'"; 
		$_SESSION['whereyyzc'] = $where;
	  }
	 if(!empty($_POST['km'])){
		$where =$where . " and kjskm LIKE '%".$_POST['km']."%'"; 
		$_SESSION['whereyyzc'] = $where;
	  }
	  if(!empty($_POST['byxx'])){
		$where =$where . " and xuexiao LIKE '%".$_POST['byxx']."%'";  
		$_SESSION['whereyyzc'] = $where;
	  }
	  if(!empty($_POST['sex'])){
		$where =$where . " and sex LIKE '%".$_POST['sex']."%'";  
		$_SESSION['whereyyzc'] = $where;
	  }
	  if(!empty($_POST['qy'])){
		$where =$where . " and quyu LIKE '%".$_POST['qy']."%'";  
		$_SESSION['whereyyzc'] = $where;
	  }
	  if(!empty($_POST['lx'])){
		$where =$where . " and levels LIKE '%".$_POST['lx']."%'";  
		$_SESSION['whereyyzc'] = $where;
	  }
  }elseif(!empty($_GET['seachkey'])){
		$where =$where . " and kjskm LIKE '%".iconv('GB2312', 'UTF-8', $_GET['seachkey'])."%'"; 
		$_SESSION['whereyyzc'] = $where; 
  }
  if($_SESSION['whereyyzc']=="")
  {
	$_SESSION['whereyyzc'] = $where;  
  }
   //die($_SESSION['wherenews']);
  $list = $bw->selectPage("*",$tbName,$_SESSION['whereyyzc'],"zjtime desc, id DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['whereyyzc'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
         <tr>
           <td height="70" align="center" bgcolor="#fff7f0" class="students_td2"><?php echo $list[$i]['id']; ?></td>
           <td align="center" valign="middle" class="students_td2">
		   <?php 
		   if($list[$i]['ifxj']>=3 && $list[$i]['ifxj']<6){
		   ?>
		   <img src="images/yszc_03.jpg" width="51" height="53">
		   <?php 
		   }
		   else
		   { 
		   if($list[$i]['ifrz']==1 && ($list[$i]['ifxj']<3 || $list[$i]['ifxj']=6))
		   		{
		   ?>	  
		   <img src="images/yszc_02.jpg" width="39" height="49"> 
		   <?php
				  }
				   else
				   {
				   ?>
				   <img src="images/yszc_01.jpg" width="39" height="41">
				   <?php
				   }
		   }
		   ?>
		   </td>
           <td align="center" class="students_td2"><?php echo chgtitles($list[$i]['truename'],1); ?>教员</td>
           <td align="center" class="students_td2"><?php if($list[$i]['sex']==2){echo "女";}else{echo "男";} ?></td>
           <td align="center" class="students_td2"><?php echo $list[$i]['mqsf']; ?></td>
           <td align="center" class="students_td2">
		   <?php if($list[$i]['levels']==1){echo "大学生";}elseif($list[$i]['levels']==2){echo "职业教师";}elseif($list[$i]['levels']==2){echo "留学,海归";}else{echo "其他";} ?></td>
           <td align="center" class="students_td2"><?php echo $list[$i]['xuexiao']; ?></td>
           <td align="left" class="students_td2"><?php echo chgtitle($list[$i]['kjskm'],25); ?></td>
           <td align="center" class="students_td2"><?php echo date("Y-m-d",strtotime($list[$i]['zjtime']));?></td>
           <td align="center" class="students_td2"><a href="teachershow.php?id=<?php echo $list[$i]['id']; ?>" target="_blank"><span>[查看]</span></a></td>
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
