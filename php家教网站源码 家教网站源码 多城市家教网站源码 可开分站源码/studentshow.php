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
<link rel="Bookmark" href="favicon.ico"><script language=Javascript>      
      var proMaxWidth = 170;   
      var proMaxHeight = 180;   
 
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
</HEAD>
<BODY>
<?php
	//查找一条数
	$id=$_GET["id"];
	if(empty($id)){
	echo "<script>location.href='index.php'; </script>";
	}
	$classData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$id);
?>
<?php include("top.php");?>
<!-- header end-->
<div id="all_main_all">
     <div id="xykshow_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div id="studentshow_box">
		  <div id="studentshow_box_top"><b style="color:#ff621a; font-size:16px">·学员信息</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="students.php">< 返回学员库</a></font></div>
	   <div id="studentshow_box_mid">
		    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
              <tr>
                <td width="13%" height="40" align="center" bgcolor="#f9f9f9"><b>订单编号：</b></td>
                <td width="13%" align="center" bgcolor="#FFFFFF"><?php echo $classData['id'];?></td>
                <td width="13%" align="center" bgcolor="#f9f9f9"><b>姓名：</b></td>
                <td width="13%" align="center" bgcolor="#FFFFFF"><?php echo chgtitles($classData['name'],1); ?>同学</td>
                <td width="13%" align="center" bgcolor="#f9f9f9"><b>发布时间：</b></td>
                <td width="13%" align="center" bgcolor="#FFFFFF"><?php echo $classData['addtime'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>学员性别：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['xysex'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>所在区域：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['szqy'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>详细地址：</b></td>
                <td align="center" bgcolor="#FFFFFF"><a href="http://www.8684.cn/" target="_blank"><?php echo $classData['adds'];?></a></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>学员年级：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['xynj'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>求教科目：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['qjkm'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>学员类型：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['xylx'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>报酬：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['bcs'];?>元/小时</td>
                <td align="center" bgcolor="#f9f9f9"><b>会员费：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['hyf'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>信息费<a href="info.php?id=27" target="_blank"><img src="images/teachershow_01.jpg" width="14" height="14"></a>：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['xxf'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>授课安排：</b></td>
                <td colspan="5" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['skap'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>学员状况：</b></td>
                <td colspan="5" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['xyzk'];?></td>
              </tr>
              <tr>
                <td height="40" colspan="6" align="center" bgcolor="#ffffff"><b style="color:#ff621a">教员要求</b></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>性别要求：</b></td>
                <td align="center" bgcolor="#FFFFFF">&nbsp;&nbsp;<?php echo $classData['jysex'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>资格要求：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php 
				if($classData['zgyq']==1)
				{
				      echo "大学生";
				}elseif($classData['zgyq']==2){
				      echo "职业教师";
				}elseif($classData['zgyq']==3){
				      echo "留学、海归";
				}elseif($classData['zgyq']==5){
				      echo "明星在职教师";
				}elseif($classData['zgyq']==6){
				      echo "明星大学生";
				}elseif($classData['zgyq']==4){
				      echo "其他";
				}else{
				      echo "未填写"; 
				}		
				?></td>
                <td align="center" bgcolor="#f9f9f9"><strong style="color:#F00;">教员预约人数：</strong></td>
                <td align="center" bgcolor="#FFFFFF"><strong><?php
				$zongData = $bw->selectOnly('count(*) as zong' ,'bw_order', 'yylx=1 and xyid = '.$id);
				echo "<span style='color:#F00;'>已有".$zongData["zong"]."人预约</span>";
				?></strong></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>其他要求：</b></td>
                <td colspan="5" bgcolor="#FFFFFF"> &nbsp;<?php echo $classData['qtyq'];?></td>
              </tr>
			  <tr>
                <td height="40" colspan="6" align="center" bgcolor="#FFFFFF"><form name="form1" method="post" action="user_order.php">
                  <label>
                    <input type="hidden" name="xyid" id="xyid" value="<?php echo $_GET["id"];?>">
                    <input type="image" name="Submit" src="images/xysqdd.jpg">
                  </label>
                </form></td>
              </tr>
         </table>
	   </div>
     </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>