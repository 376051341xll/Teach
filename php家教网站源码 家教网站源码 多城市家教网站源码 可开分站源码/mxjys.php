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
$_SESSION['wheremxjys']="";
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
<link rel="Bookmark" href="favicon.ico"><script language=Javascript>      
      var proMaxWidth = 77;   
      var proMaxHeight = 77;   
 
    function proDownImage(ImgD){    
      var image=new Image();    
       image.src=ImgD.src;    
        if(image.width>0 && image.height>0){    
         var rate = (proMaxWidth/image.width < proMaxHeight/image.height) ? proMaxWidth/image.width:proMaxHeight/image.height;    
        if(rate <= 1){    
           ImgD.width = image.width*rate;    
           ImgD.height =image.height*rate;    
        } else {    
           ImgD.width = image.width;    
            ImgD.height =image.height;    
        }    
        }    
     }   
</script>
<script type="text/javascript" src="js/jquery.js"></script>
</HEAD>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="mxjys.php?page="+thisPage.val();
		});//end page_SEL 		
	});
</script>
<BODY>
<a name="top"></a>
<?php include("top.php");?>
<!-- header end-->
<div id="all_main_all">
     <div id="mxjy_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div id="students_main_mid">
	      <div id="students_main_mid_top">综合检索</div>
		  <div id="students_main_mid_bots">
		    <form name="form1" method="post" action="?action=search">
		      <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
					&nbsp;区域：
					<select name="qy" id="qy">
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
                </select>				</td>
			   <td width="110" align="left">
		        <input type="image" name="Submit" src="images/mxjy_01.jpg"></td>
			  </tr>
			</table>
			</form>
	      </div>
	 </div>
	 <div id="mxjy_box">
		  <div id="mxjy_box_top"><b style="font-size:16px; color:#fe5009;">明星教员</b>&nbsp;&nbsp;&nbsp;当前位置：明星教员</div>
	   <div id="mxjy_box_mid">
	        <div id="mxjy_box_mid_dh">
			<a href="mxjy.php?act=k" class="mxjy_box_mid_dh_memus">明星教员</a>
            <a href="mxjys.php?act=k" class="mxjy_box_mid_dh_memu" >明星大学生</a>
			</div>
			<div id="mxjy_box_mid_nr">
	        <table width="100%" id="mxjys" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td>
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_member";
  $where    = '1=1 and iffb=2 and ifxj>=3 and ifxj<6 and levels=1 and lang="'.$_COOKIE["cookie_lang"].'" ';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	 if(!empty($_POST['bh'])){
		$where =$where . " and id LIKE '%".$_POST['bh']."%'"; 
		$_SESSION['wheremxjys'] = $where;
	  }
	 if(!empty($_POST['km'])){
		$where =$where . " and kjskm LIKE '%".$_POST['km']."%'"; 
		$_SESSION['wheremxjys'] = $where;
	  }
	  if(!empty($_POST['byxx'])){
		$where =$where . " and xuexiao LIKE '%".$_POST['byxx']."%'";  
		$_SESSION['wheremxjys'] = $where;
	  }
	  if(!empty($_POST['sex'])){
		$where =$where . " and sex LIKE '%".$_POST['sex']."%'";  
		$_SESSION['wheremxjys'] = $where;
	  }
	  if(!empty($_POST['qy'])){
		$where =$where . " and quyu LIKE '%".$_POST['qy']."%'";  
		$_SESSION['wheremxjys'] = $where;
	  }
	  if(!empty($_POST['lx'])){
		$where =$where . " and levels LIKE '%".$_POST['lx']."%'";  
		$_SESSION['wheremxjys'] = $where;
	  }
  }
  if($_SESSION['wheremxjys']=="")
  {
	$_SESSION['wheremxjys'] = $where;  
  }
   //die($_SESSION['wherenews']);
  $list = $bw->selectPage("*",$tbName,$_SESSION['wheremxjys'],"zjtime desc, id DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wheremxjys'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
				<div class="mxjy_box_mid_nr_box">
                  <table width="100%" height="124" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="10" rowspan="3" align="center" valign="middle">&nbsp;</td>
                      <td width="90" rowspan="3" align="left" valign="top">
					   <?php
					  if($list[$i]['tupic']==""){
					   ?>
					  <img src="images/moren.jpg" onload="proDownImage(this)" width="77" height="77" style="margin-bottom:5px;">
					  <?php
					  }else{
					  ?>
					  <img src="<?php $list[$i]['tupic'];?>" onload="proDownImage(this)" width="77" height="77" style="margin-bottom:5px;">
					  <?php
					  }
					  ?>
					  <a href="teachershow.php?id=<?php echo $list[$i]['id']; ?>" target="_blank"><img src="images/mxjy_05.jpg" width="46" height="13"></a></td>
                      <td width="15" rowspan="3" align="left" valign="top"><img src="images/mxjy_06.jpg" width="6" height="116"></td>
                      <td height="25" valign="top"><a href="teachershow.php?id=<?php echo $list[$i]['id']; ?>" target="_blank"><b><?php echo chgtitles($list[$i]['truename'],1); ?>教员</b></a></td>
                    </tr>
                    <tr>
                      <td height="25" valign="top">任教学科：<?php echo chgtitle(phphtml($list[$i]['kjskm']),30); ?></td>
                    </tr>
                    <tr>
                      <td height="74" valign="top">教师简介：<?php echo chgtitle(phphtml($list[$i]['zwms']),30); ?></td>
                    </tr>
                  </table>
                </div>
<?php
  }//end loop
?>
				
				</td>
              </tr>
			  <tr>
			    <td>
				<div id="mxjy_box_mid_nr_box_page">
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
				</td>
			  </tr>
            </table>
            </div>
	   </div>
     </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>