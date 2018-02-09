<?php session_start();
if(!empty($_GET["lang"])){
setcookie("cookie_lang",base64_decode(iconv("gb2312","utf-8",$_GET["lang"])), time()+2592000);
echo "<script language='javascript'>	window.location.href='index.php';  </script>";
}
if($_COOKIE["cookie_lang"]=="")
{
setcookie("cookie_lang","宁波站", time()+2592000);
echo "<script language='javascript'>	window.location.href='index.php';  </script>";
}
include("inc/config.php");
	if($_SESSION["jiesou"]!=1)
	{
		echo "<script>location.href='tutor.php'</script>";
		exit;
		}
	if($bw->selectOnly('username' ,'bw_member', "username = '".$_POST["username"]."'"))
	{
		$bw->msg("会员号已经存在");
		echo "<script>history.back();</script>";
		exit;
		}
$diaoquData = $bw->selectOnly('*', 'bw_config', "lang='".$_COOKIE["cookie_lang"]."'", '');
 ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0054)#?WT.mc_id=c03-BDPP-101&WT.srch=1 -->
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<title><?php echo $service_title; ?></title>
<meta name="keywords" content="<?php echo $service_keyword.'-'.$service_title; ?>" />
<meta name="description" content="<?php echo $service_description.'-'.$service_title; ?>" />
<META http-equiv=content-type content="text/html; charset=utf-8">
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico"><script language="javascript">
function yanz()
{
	if(document.getElementById("truename").value=="")
	{	
	document.getElementById("truename").focus();
	alert("请输入您的姓名");
	return false;
	}
	if(document.getElementById("truename").value.length<2)
	{	
	document.getElementById("truename").focus();
	alert("请正确的输入您的姓名");
	return false;
	}		
	if(document.getElementById("truename").value.length>6)
	{	
	document.getElementById("truename").focus();
	alert("请正确的输入您的姓名");
	return false;
	}	
	if(document.getElementById("sex").value=="")
	{	
	document.getElementById("sex").focus();
	alert("请选择您的性别");
	return false;
	}	
	if(document.getElementById("birthday").value=="")
	{	
	document.getElementById("birthday").focus();
	alert("请选择您的出生年份");
	return false;
	}
	if(document.getElementById("birthday").value=="")
	{	
	document.getElementById("birthday").focus();
	alert("请选择您的出生年份");
	return false;
	}
	if(document.getElementById("xueli").value=="")
	{	
	document.getElementById("xueli").focus();
	alert("请选择您的目前学历");
	return false;
	}
	if(document.getElementById("csd").value=="")
	{	
	document.getElementById("csd").focus();
	alert("请选择您的出生地省份");
	return false;
	}
	if(document.getElementById("mqsf").value=="")
	{	
	document.getElementById("mqsf").focus();
	alert("请选择您的目前身份");
	return false;
	}
	if(document.getElementById("quyu").value=="")
	{	
	document.getElementById("quyu").focus();
	alert("请选择您的所在区域");
	return false;
	}
	if(document.getElementById("guojia").value=="")
	{	
	document.getElementById("guojia").focus();
	alert("请填写您留学的国家或国籍");
	return false;
	}
	if(document.getElementById("zhuanye").value=="")
	{	
	document.getElementById("zhuanye").focus();
	alert("请填写您的专业");
	return false;
	}
	if(document.getElementById("idcode").value=="")
	{	
	document.getElementById("idcode").focus();
	alert("请填写您的身份证或者护照");
	return false;
	}
	if(document.getElementById("xuexiao").value=="")
	{	
	document.getElementById("xuexiao").focus();
	alert("请填写您毕业或者就读的学校");
	return false;
	}
	if(document.getElementById("telphone").value=="")
	{	
	document.getElementById("telphone").focus();
	alert("请输入您的联系电话，方便我们与您取得联系");
	return false;
	}
	if(document.getElementById("address").value=="")
	{	
	document.getElementById("address").focus();
	alert("请输入您的地址");
	return false;
	}
	return true;
} 
</script>
</HEAD>
<BODY>
<?php include("top.php");?>
<!-- header end-->
<div id="all_main_all">
     <div id="allmain_all_benner"><img src="images/zjj_benner.jpg" width="960" height="68" border="0"></div>
	 <div id="all_main_all_box">
	      <div id="all_main_all_box_left">
		       <div id="all_main_all_box_left_top"><b style="font-size:16px; color:#fe5009;">做家教</b>&nbsp;&nbsp;&nbsp;当前位置：做家教</div>
			   <div id="all_main_all_box_left_mid">
			        <div id="tutor_box">
				      <div id="title" style="width:670px; height:36px; padding:1px;">
					       <div style="width:635px; height:36px; background:#f4f4f4; padding-left:35px;"> <strong>新教员注册第二步: </strong><font color="#fe5d08">2</font>填写详细个人信息</div>
					  </div>
					  <div id="tutor_box_center" style="width:668px; padding:1px; border:1px #f4f4f4 solid;">
					    <form action="tutor_infoto.php" method="post">
						<div style="width:668px; height:auto; margin:0 auto;  background:#f4f4f4;">
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="50" colspan="6">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="120" height="35" align="right">真实姓名：</td>
                            <td colspan="5"><label>
                              <input name="truename" type="text" class="tutor_input" id="truename">
                              <span style="color:#F00">*请与证件上的姓名相符合，否则将不能通过认证</span>
                            </label></td>
                          </tr>
                          <tr>
                            <td height="35" align="right">性&nbsp;&nbsp;&nbsp;别：</td>
                            <td><label>
                              <select name="sex" id="sex">
                                <option>--请选择--</option>
                                <option value="1">男</option>
                                <option value="2">女</option>
                              </select>
                            </label><span style="color:#F00">&nbsp;*</span></td>
                            <td align="right">出生年份：</td>
                            <td><select name="birthday" id="birthday">
                              <option>--请选择--</option>
                              <?php
							  $nian1="20".date("y");
							  $xiao=$nian1-70;
							//  echo $nian1;
                             for($nian=$xiao;$nian<$nian1;$nian++)
							  {
							  ?>
                              <option><?php echo $nian;?></option>
                              <?php
                              }
							  ?>
                            </select><span style="color:#F00">&nbsp;*</span></td>
                            <td align="right">目前学历：</td>
                            <td><select name="xueli" id="xueli">
                              <option>--请选择--</option>
                             <?php
$dir=$diaoquData["xueli"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
              <option value="<?php echo $split_dir[$i];?>"><?php echo $split_dir[$i];?></option>
              <?php
}
			  ?>
                            </select><span style="color:#F00">&nbsp;*</span></td>
                          </tr>
                          <tr>
                            <td height="35" align="right">出生地省份：</td>
                            <td><select name="csd" id="csd">
                              <option>--请选择--</option>
                              <option value="北京">北京</option>
                                <option value="天津">天津</option>
                                <option value="厦门">厦门</option>
                                <option value="重庆">重庆</option>
                                <option value="安徽">安徽</option>
                                <option value="江苏">江苏</option>
                                <option value="浙江">浙江</option>
                                <option value="福建">福建</option>
                                <option value="甘肃">甘肃</option>
                                <option value="广东">广东</option>
                                <option value="广西">广西</option>
                                <option value="贵州">贵州</option>
                                <option value="海南">海南</option>
                                <option value="河北">河北</option>
                                <option value="河南">河南</option>
                                <option value="黑龙江">黑龙江</option>
                                <option value="湖北">湖北</option>
                                <option value="湖南">湖南</option>
                                <option value="吉林">吉林</option>
                                <option value="江西">江西</option>
                                <option value="辽宁">辽宁</option>
                                <option value="内蒙">内蒙</option>
                                <option value="宁厦">宁厦</option>
                                <option value="青海">青海</option>
                                <option value="山东">山东</option>
                                <option value="山西">山西</option>
                                <option value="陕西">陕西</option>
                                <option value="四川">四川</option>
                                <option value="西藏">西藏</option>
                                <option value="香港">香港</option>
                                <option value="新疆">新疆</option>
                            </select><span style="color:#F00">&nbsp;*</span></td>
                            <td align="right">目前身份：</td>
                            <td><select name="mqsf" id="mqsf">
                              <option>----请选择----</option>
                      <?php
$dir=$diaoquData["shenfen"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
              <option value="<?php echo $split_dir[$i];?>"><?php echo $split_dir[$i];?></option>
              <?php
}
			  ?>
                            </select><span style="color:#F00">&nbsp;*</span></td>
                            <td align="right">区&nbsp;&nbsp; 域：</td>
                            <td><select name="quyu" id="quyu">
                              <option>--请选择--</option>
                                      <option>--请选择--</option>   <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
              <option value="<?php echo $split_dir[$i];?>"><?php echo $split_dir[$i];?></option>
              <?php
}
			  ?>
                            </select>
                            <span style="color:#F00">&nbsp;*</span></td>
                          </tr>
                          <tr>
                            <td height="35" align="right">国籍 / 留学国家：</td>
                            <td height="25" colspan="5"><input name="guojia" type="text" class="tutor_input" id="guojia">
                            <span style="color:#F00">&nbsp;*</span></td>
                          </tr>
                          <tr>
                            <td height="35" align="right">专&nbsp;&nbsp;&nbsp;业：</td>
                            <td height="25" colspan="5"><input name="zhuanye" type="text" class="tutor_input" id="zhuanye"><span style="color:#F00">&nbsp;*</span></td>
                          </tr>
                          <tr>
                            <td height="35" align="right">身份证 / 护照：</td>
                            <td height="25" colspan="5"><input name="idcode" type="text" class="tutor_input" id="idcode"><span style="color:#F00">&nbsp;*(此项将严格保密，不对外公开)</span>
                           </td>
                          </tr>
                          <tr>
                            <td height="35" align="right">毕业 / 就读高校：</td>
                            <td height="25" colspan="5"><input name="xuexiao" type="text" class="tutor_inputs" id="xuexiao"><span style="color:#F00">&nbsp;*</span></td>
                          </tr>
                          <tr>
                            <td height="35" align="right">联系电话：</td>
                            <td height="25" colspan="5"><input name="telphone" type="text" class="tutor_input" id="telphone"><span style="color:#F00">&nbsp;*本站可以在第一时间通知您相关合适的家教信息</span>
                            </td>
                          </tr>
                          <tr>
                            <td height="35" align="right">Q&nbsp;&nbsp;&nbsp;&nbsp;Q：</td>
                            <td height="25" colspan="5"><input name="qq" type="text" class="tutor_input" id="qq">
                              <input type="hidden" name="username" id="username" value="<?php echo $_POST["username"];?>">
                              <input type="hidden" name="password" id="password" value="<?php echo $_POST["password"];?>">
                              <input type="hidden" name="email" id="email" value="<?php echo $_POST["email"];?>">
                            <input type="hidden" name="levels" id="levels" value="<?php echo $_POST["levels"];?>"></td>
                          </tr>
                          <tr>
                            <td height="35" align="right"> <label>地&nbsp;&nbsp;&nbsp;址：</label></td>
                            <td colspan="5"><label>
                              <input name="address" type="text" class="tutor_inputs" id="address">
                            </label><span style="color:#F00">&nbsp;*</span></td>
                          </tr>
                          <tr>
                            <td height="100" colspan="6" align="center"><label>
                              <input type="image" name="Submit" src="images/zjj_07.jpg">
                            </label>&nbsp;
                              <label>
                              <input type="image" name="Submit2" src="images/zjj_06.jpg">
                            </label></td>
                          </tr>
                        </table>
						</div>
						</form>
					  </div>
				    </div>
			   </div>
		  </div>
	   <div id="all_main_all_box_right">
	        <div class="tutor_right_pic"><img src="images/zjj_01.jpg"></div>
			<div class="tutor_right_pic"><img src="images/zjj_02.jpg"></div>
			<div class="tutor_right_pic"><img src="images/zjj_03.jpg"></div>
			<div class="tutor_right_pic"><img src="images/zjj_04.jpg"></div>
	   </div>
	 </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
