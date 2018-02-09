<?php session_start();
if(!empty($_GET["lang"])){
setcookie("cookie_lang",base64_decode(iconv("gb2312","utf-8",$_GET["lang"])), time()+2592000);
//die(base64_decode(iconv("gb2312","utf-8",$_GET["lang"])));
echo "<script language='javascript'>window.location.href='qjj.php';  </script>";
}
if($_COOKIE["cookie_lang"]=="")
{
setcookie("cookie_lang","宁波站", time()+2592000);
echo "<script language='javascript'>window.location.href='index.php';  </script>";
}
include 'Code.php';
include 'inc/config.php';
$diaoquData = $bw->selectOnly('*', 'bw_config', 'lang = "'.$_COOKIE["cookie_lang"].'"', '')
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
<?php
$action = $_GET['action'];
if(!empty($action) && $action == 'add')
{
	$code=$_POST['codetext'];
	$code = strtolower($code);
	
	if (!empty($_SESSION['captcha_word']))
	{
		include_once('inc/cls_captcha.php');

		/* 检查验证码是否正确 */
		$validator = new captcha();
		
		if (!$validator->check_word($code))
		{
		   echo "<script>alert('验证码不正确!'); </script>";
		}else{
		    unset($_POST['codetext']);
		    unset($_POST['x']);
		    unset($_POST['y']);
			if(empty($_POST["uid"]))
			{
		    unset($_POST['uid']);
				}
				else
				{
					$uid=$_POST['uid'];
		           unset($_POST['uid']);
				}
			if(empty($uid))
			{
			  //insert($tbName, $post) 
				   if($bw->insert('bw_qjj', $_POST))
				{
					$bw->msg('请家教下单成功!', 'qjj.php');
				}else{
					$bw->msg('请家教下单失败!', '', true);	
				}
			}else{
			$bw->insert('bw_qjj', $_POST);
			$xyData = $bw->selectOnly('id' ,'bw_qjj', '','id desc');
			$sqlstr="INSERT INTO bw_order (xyid,jyid,yylx,subtime,ifnew,lang) VALUES ({$xyData['id']},{$uid},2,'".date('Y-m-d H:i:s')."',1,'".$_COOKIE["cookie_lang"]."')";
	//die($sqlstr);
	$bw->query($sqlstr);
	$bw->msg('预约成功，请您等待后台审核!',"teachers.php");
			}
		   
		}
	}
}
?>
<script language="javascript">
function qjj()
{
var myreg =/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(document.getElementById("name").value=="")
	{
	document.getElementById("name").focus();
	alert("请输入联系人");
	return false;
	}
	if(document.getElementById("tel").value=="")
	{
	document.getElementById("tel").focus();
	alert("请输入联系电话");
	return false;
	}
	if(document.getElementById("xynj").value=="")
	{
	document.getElementById("xynj").focus();
	alert("请选择学员年级");
	return false;
	}
	if(document.getElementById("qjkm").value=="")
	{
	document.getElementById("qjkm").focus();
	alert("请输入您想求教的科目");
	return false;
	}
	if(document.getElementById("bcs").value=="")
	{
	document.getElementById("bcs").focus();
	alert("请输入您想付的报酬数额");
	return false;
	}
	return true;
}

</script>
<!-- header end-->
<div class="qjj_main_all">
     <div class="qjj_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div class="qjj_main_all_box">
	      <div id="top">当前位置：请家教</div>
		  <div id="bot">
               <div id="left">
			        <div class="box">
					     <div class="pic"><img src="images/qjj_left_01.jpg"></div>
						 <div class="nr">
						      <div class="top"><img src="images/qjj_left_04.jpg"></div>
							  <div class="bot">
							  直接拨打客热线：<?php echo $service_qjjphone; ?>
							  <br>
                              客服人员将会根据您的要求挑选合适的教员。
							  </div>
						 </div>
					</div>
					<div class="box">
					     <div class="pic"><img src="images/qjj_left_02.jpg"></div>
						 <div class="nr">
						      <div class="top"><img src="images/qjj_left_05.jpg"></div>
							  <div class="bot">
							  自主填写订单：把您的需求填写清楚，客服人员将会根据您的要求挑选适合的教员。
							  </div>
						 </div>
					</div>
				    <div class="box">
					     <div class="pic"><a href="teachers.php"><img src="images/qjj_left_03.jpg"></a></div>
						 <div class="nr">
						      <div class="top"><img src="images/qjj_left_06.jpg"></div>
							  <div class="bot">
							  在线预约：您可以直接进入<a href="teachers.php" style="color:#F90; font-size:14px;">教员库</a>找到你中意的教员后，请在线预约此教员。
							  </div>
						 </div>
					</div>
			   </div>
			   <div id="right">
			        <div id="pic"></div>
					<div id="bd">
					  <form name="form1" method="post" action="?action=add">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="80" colspan="3">备注：如果您晚上9点以后，或者白天不方便打电话，您可以填写如下信
                              息，我们将尽快与您确定家教信息 </td>
                          </tr>
                          <tr>
                            <td width="25%" height="30" align="right">联系人：</td>
                            <td colspan="2"><label>
                              <input name="name" type="text" class="input" id="name">
                            </label></td>
                          </tr>
                          <tr>
                            <td height="30" align="right">联系电话：</td>
                            <td colspan="2"><label>
                            <input name="tel" type="text" class="input" id="tel">
                            </label></td>
                          </tr>
                          <tr>
                            <td height="30" align="right">学员年级：</td>
                            <td colspan="2"><label>
							<select name="xynj" id="xynj">
                              <option value="">--请选择--</option>
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
                            </label></td>
                          </tr>
                          <tr>
                            <td height="30" align="right" valign="top">求教学科：</td>
                            <td colspan="2"><input name="qjkm" type="text" class="input" id="qjkm" style="width:250px;"></td>
                          </tr>
                          <tr>
                            <td height="80" align="right" valign="top">其他要求：</td>
                            <td colspan="2"><label>
                              <textarea name="qtyq" rows="5" id="qtyq" style="width:248px; border:1px #CCCCCC solid; color:#666666;"></textarea>
                            </label></td>
                          </tr>
                          <tr>
                            <td height="30" align="right">报酬：</td>
                            <td colspan="2"><input name="bcs" type="text" class="input" id="bcs" size="10">
                              元/小时</td>
                          </tr>
                          <tr>
                            <td height="30" align="right">验证码：</td>
                            <td width="90" valign="middle"><input name="codetext" type="text" class="input" id="codetext" size="10"></td>
                            <td width="240" align="left" valign="middle"><img src="Code.php?act=captcha&amp;<?php echo mt_rand(); ?>" width="50" height="20" alt="CAPTCHA" border="1" onClick= "this.src=&quot;Code.php?act=captcha&amp;&quot;+Math.random()" style="cursor: pointer;" title="看不清，点击更换另一个验证码" /></td>
                          </tr>
                          <tr>
                            <td height="50" colspan="3" align="center"><label>
                              <input type="image" src="images/qjj_right_02.jpg" onClick="return qjj();">
                              <input type="hidden" name="uid" id="uid" value="<?php echo $_POST["uid"];?>">
                              <input type="hidden" name="lang" id="lang" value="<?php echo $_COOKIE["cookie_lang"];?>">
							  <input type="hidden" name="addtime" id="addtime" value="<?php echo date("Y-m-d H:i:s", mktime()); ?>" />
							  <input type="hidden" name="ifnew" id="ifnew" value="1" />
                            </label></td>
                          </tr>
                        </table>
                      </form>
				    </div>
			   </div>
		  </div>
	 </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
