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
	$classData = $bw->selectOnly('*' ,'bw_member', 'id = '.$id);
	if(!empty($id)){
	$sql = "UPDATE bw_member SET hits = hits+1 WHERE id = ".$id;
	//die($sql);
	$bw->query($sql);
	}
?>
<a name="top"></a>
<?php include("top.php");?>
<!-- header end-->
<div id="all_main_all">
     <div id="teachershow_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div id="studentshow_box">
		  <div id="studentshow_box_top"><b style="color:#ff621a; font-size:16px">·教员信息</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="teachers.php">< 返回教员库</a></div>
		  <div id="studentshow_box_mid">
		  <?php 
		  if($classData["levels"]!=1)
		  {
		  ?>
		    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
              <tr>
                <td width="13%" height="40" align="center" bgcolor="#f9f9f9"><b>教员编号：</b></td>
                <td width="13%" align="center" bgcolor="#FFFFFF"><?php echo $classData['id'];?></td>
                <td width="13%" align="center" bgcolor="#f9f9f9"><b>姓名：</b></td>
                <td width="13%" align="center" bgcolor="#FFFFFF"><?php echo chgtitles($classData['truename'],1); ?>教员</td>
                <td width="13%" align="center" bgcolor="#f9f9f9"><b>教龄：</b></td>
                <td width="13%" align="center" bgcolor="#FFFFFF"><?php echo $classData['jiaolin'];?></td>
                <td width="20%" rowspan="5" align="center" valign="middle" bgcolor="#FFFFFF">
				  <?php
				  if($classData['tupic']==""){
				   ?>
				  <img src="images/moren.jpg" onload="proDownImage(this)" width="170" height="180" style="margin-bottom:5px;">
				  <?php
				  }else{
				  ?>
				  <img src="<?php echo $classData['tupic'];?>" onload="proDownImage(this)" width="170" height="180" />
				  <?php
				  }
				  ?>
				</td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>性别：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php
				if($classData['sex']==1)
				{
					echo "男";
					}else{
						echo "女";
						}
				
				?></td>
                <td align="center" bgcolor="#f9f9f9"><b>认证情况：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php if($list[$i]['ifrz']==1){echo "未认证";}else{echo "已认证";}?></td>
                <td align="center" bgcolor="#f9f9f9"><b>星级<img src="images/teachershow_01.jpg" width="14" height="14"></b></td>
                <td align="center" bgcolor="#FFFFFF">
				<?php if($classData['ifxj']==1)
				{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				}elseif($classData['ifxj']==2){
						for($i=1;$i<=2;$i++)
						{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				        }
				?>
				<?php 
				}elseif($classData['ifxj']==3){
						for($i=1;$i<=3;$i++)
						{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				        }
				?>
				<?php 
				}elseif($classData['ifxj']==4){
						for($i=1;$i<=4;$i++)
						{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				        }
				?>
				<?php 
				}elseif($classData['ifxj']==5){
						for($i=1;$i<=5;$i++)
						{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				        }
				}else{
				     echo "普通会员";
				}
				?>
				
				</td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>出生地省份：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['csd'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>出生年份：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['birthday'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>毕业学校：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['xuexiao'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>最后学历：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['xueli'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>专业：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['zhuanye'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>目前身份：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['mqsf'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>区域：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['quyu'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>职称等级：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['zhicheng'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>任职学校类别</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['rzxxlb'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>任教学科：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['rjxk'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>地址：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['address'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>可教授课目：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['kjskm'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>自我描述：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['zwms'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>可授课区域：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['kskqy'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>可辅导方式：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['kfdfs'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>可授课时间：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['ksksj'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>薪水要求：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['xsyq'];?></td>
              </tr>
              <tr>
                <td height="40" colspan="7" align="center" bgcolor="#FFFFFF"><form name="form1" method="post" action="qjj.php">
                  <label>
                    <input type="hidden" name="uid" id="uid" value="<?php echo $_GET["id"];?>">
                    <input type="image" name="Submit" src="images/jyzxyy.jpg">
                  </label>
                </form></td>
              </tr>
            </table>
		  <?php 
		  }else{
		  ?>
		    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
              <tr>
                <td width="13%" height="40" align="center" bgcolor="#f9f9f9"><b>教员编号：</b></td>
                <td width="13%" align="center" bgcolor="#FFFFFF"><?php echo $classData['id'];?></td>
                <td width="13%" align="center" bgcolor="#f9f9f9"><b>姓名：</b></td>
                <td width="13%" align="center" bgcolor="#FFFFFF"><?php echo chgtitles($classData['truename'],1); ?>教员</td>
                <td width="13%" align="center" bgcolor="#f9f9f9"><b>区域：</b></td>
                <td width="13%" align="center" bgcolor="#FFFFFF"><?php echo $classData['quyu'];?></td>
                <td width="20%" rowspan="4" align="center" valign="middle" bgcolor="#FFFFFF">
				  <?php
				  if($classData['tupic']==""){
				   ?>
				  <img src="images/moren.jpg" onload="proDownImage(this)" width="170" height="180" style="margin-bottom:5px;">
				  <?php
				  }else{
				  ?>
				  <img src="<?php echo $classData['tupic'];?>" onload="proDownImage(this)" width="170" height="180" />
				  <?php
				  }
				  ?>				</td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>性别：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php
				if($classData['sex']==1)
				{
					echo "男";
					}else{
						echo "女";
						}
				
				?></td>
                <td align="center" bgcolor="#f9f9f9"><b>认证情况：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php if($list[$i]['ifrz']==1){echo "未认证";}else{echo "已认证";}?></td>
                <td align="center" bgcolor="#f9f9f9"><b>星级<img src="images/teachershow_01.jpg" width="14" height="14"></b></td>
                <td align="center" bgcolor="#FFFFFF">
				<?php if($classData['ifxj']==1)
				{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				}elseif($classData['ifxj']==2){
						for($i=1;$i<=2;$i++)
						{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				        }
				?>
				<?php 
				}elseif($classData['ifxj']==3){
						for($i=1;$i<=3;$i++)
						{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				        }
				?>
				<?php 
				}elseif($classData['ifxj']==4){
						for($i=1;$i<=4;$i++)
						{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				        }
				?>
				<?php 
				}elseif($classData['ifxj']==5){
						for($i=1;$i<=5;$i++)
						{
				?>
				<img src="images/teachershow_xj.jpg">
				<?php 
				        }
				}else{
				     echo "普通会员";
				}
				?>				</td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>出生地省份：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['csd'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>出生年份：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['birthday'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>毕业学校：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['xuexiao'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>最后学历：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['xueli'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>专业：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['zhuanye'];?></td>
                <td align="center" bgcolor="#f9f9f9"><b>目前身份：</b></td>
                <td align="center" bgcolor="#FFFFFF"><?php echo $classData['mqsf'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>地址：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['address'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>可教授课目：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['kjskm'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>自我描述：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['zwms'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>可授课区域：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['kskqy'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>可辅导方式：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['kfdfs'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>可授课时间：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['ksksj'];?></td>
              </tr>
              <tr>
                <td height="40" align="center" bgcolor="#f9f9f9"><b>薪水要求：</b></td>
                <td colspan="6" bgcolor="#FFFFFF">&nbsp;<?php echo $classData['xsyq'];?></td>
              </tr>
              <tr>
                <td height="40" colspan="7" align="center" bgcolor="#FFFFFF"><form name="form1" method="post" action="qjj.php">
                  <label>
                    <input type="hidden" name="uid" id="uid" value="<?php echo $_GET["id"];?>">
                    <input type="image" name="Submit" src="images/jyzxyy.jpg">
                  </label>
                </form></td>
              </tr>
            </table>
		  <?php
		  }
		  ?>
		  </div>
     </div>
	 <div id="studentshow_box">
		  <div id="studentshow_box_top"><span class="span1"><b style="color:#ff621a; font-size:16px">· 教学记录</b></span>
          <span class="span2"><a href="#top">TOP↑</a></span></div>
		  <div class="clear"></div>
		  <div id="studentshow_box_mid">
		    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
              <tr>
                <td width="30%" height="40" align="center" bgcolor="#FFFFFF"><b style="color:#000">订单</b></td>
                <td width="50%" align="center" bgcolor="#FFFFFF"><b style="color:#000">科目</b></td>
                <td align="center" bgcolor="#FFFFFF"><b style="color:#000">时间</b></td>
              </tr>
  
<?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_order';
				  $where    = 'jyid = '.$id;
				  $hyzxlist = $bw->selectPage("*", $tbName, $where, "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
				  $xyData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$hyzxlist[$hyzxi]['xyid']);
			  ?>
              <tr>
                <td height="40" align="center" bgcolor="#FFFFFF"><?php echo $hyzxlist[$hyzxi]['id'] ;?></td>
                <td  align="center" bgcolor="#FFFFFF"><?php echo $xyData["qjkm"];?></td>
                <td  align="center" bgcolor="#FFFFFF"><?php echo $hyzxlist[$hyzxi]['addtime'] ;?></td>
              </tr>
               <?php
                  }//end loop
              ?>
              <tr>
                <td height="40" colspan="3" align="center" bgcolor="#FFFFFF">
                共:<?php echo $pageArray['totalRow']; ?>条信息&nbsp;&nbsp;&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>&nbsp;页&nbsp;&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=1">首页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
                </td>
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