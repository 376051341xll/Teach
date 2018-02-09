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
include("mail.php");
	if($_SESSION["jiesou"]!=1)
	{
		echo "<script>location.href='tutor.php'</script>";
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
<link rel="Bookmark" href="favicon.ico"><?php

	if($_GET["act"]=="hy")
	{
		$mima=$_POST["password"];
		$_POST["password"]=md5($_POST["password"]);
			unset($_POST["x"]);
			unset($_POST["y"]);
		if(!empty($_POST["kskqy"]))
		{
		foreach ($_POST["kskqy"] as &$value) {
    	$abc = $abc.$value.",";
			}
			$_POST["kskqy"]=$abc;
		}
		//die($_POST["kskqy"]);
		if(!empty($_POST["kfdfs"]))
		{
		foreach ($_POST["kfdfs"] as &$value) {
    	$abcd = $abcd.$value.",";
			}
			$_POST["kfdfs"]=$abcd;
		}
		if(substr($_POST["kjskm"],0,1)==",")
		{
		$_POST["kjskm"]=substr($_POST["kjskm"],1);
		}
		if(substr($_POST["kjskm"],-1)==",")
		{
		$_POST["kjskm"]=substr($_POST["kjskm"],0,-1);
		}
		if($bw->insert('bw_member', $_POST))
		{
		$smtpserver = "smtp.qq.com";    //你选择的SMTP服务器
		$smtpserverport =25;    //SMTP服务器端口
		$smtpusermail = "529757231@qq.com";    //SMTP服务器的用户邮箱
		$smtpemailto = $_POST["email"];    //收件箱
		$smtpuser = "529757231@qq.com";    //SMTP服务器的用户帐号
		$smtppass = "RUI15083791098";    //SMTP服务器的用户密码
		$MailBody="姓名：";//邮件内容(如你提交的表单姓名为Name)
		$mailsubject=@iconv("UTF-8", "gb2312", "欢迎注册宁波家教网");//如果你页面为UTF-8，这里还要转码一下
		$mailbody = "尊敬的会员,欢迎您注册南康师资最雄厚的前锦家教网(<a href='http://www.nkqjjj.com' target='_blank'>www.nkqjjj.com</a>)<br>请妥善保留这封电子邮件. 您的帐号资料如下<br><br>登陆帐号:&nbsp;<span style='color:#ff0000'>".$_POST["username"]."</span><br>登陆密码:&nbsp;<span style='color:#ff0000'>".$mima."</span><br><br>请妥善保管.";    //邮件内容
		$mailtype = "HTML";    //邮件格式（HTML/TXT）,TXT为文本邮件
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//true表示使用身份验证,否则不使用身份验证.
		$smtp->debug = false; //是否显示发送的调试信息 TRUE发送 FALSE不发送
		$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
		echo "发送成功";
		    $hydata=$bw->selectOnly('username,id,password' ,'bw_member', "username = '".$_POST["username"]."' and password='".md5($mima)."' and lang='".$_COOKIE["cookie_lang"]."'");
			$_SESSION["hyusername"]=$_POST["username"];
			$_SESSION["hypassword"]=md5($mima);
			$_SESSION["userid"]=$hydata["id"];
			$sql = "UPDATE bw_member SET dlcs = dlcs+1,zjtime='".date("y-m-d H:i:s")."' WHERE id = ".$_SESSION["userid"];//登录次数,登录时间
			$bw->query($sql);
				
			$bw->msg('您已注册成功，点击进入教员后台预约订单请到\n\n密码管理，请注意查收您的邮件!', 'user_wsrz.php');
			//$bw->msg('您已注册成功，请重新登陆进入教员后台预约订单请到\n\n密码管理，请注意查收您的邮件!', 'zxzf.php');
		}else{
			$bw->msg('申请失败!', '', true);	
		}
		}
?>
<script language="javascript">
function yanz()
{
	a=0;
	myCheckbox=document.getElementsByName("kskqy[]");
for(var i=0;i<myCheckbox.length;i++){
  if(myCheckbox[i].checked){
	  a=1
	  }
	 }
	if(document.getElementById("kjskm").value=="")
	{
		alert("请选择授课科目");
	document.getElementById("list2").focus();
	return false;
	}
	if(a==0)
	{
		alert("请选择可授课区域");
	return false;
		}
	if(document.getElementById("zwms").value=="")
	{
		alert("请填写自我描述");
	document.getElementById("zwms").focus();
	return false;
	}
	if(document.getElementById("xsyq").value=="")
	{
		alert("请填写薪水要求");
	document.getElementById("xsyq").focus();
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
     <div id="zjj_main_all_benner">
	 <span style="float:left; margin-left:760px; margin-top:20px; color:#997e53; font-size:20px"><?php echo $service_bphone; ?></span>
	 </div>
	 <div id="all_main_all_box">
	      <div id="all_main_all_box_left">
		       <div id="all_main_all_box_left_top"><b style="font-size:16px; color:#fe5009;">做家教</b>&nbsp;&nbsp;&nbsp;当前位置：做家教</div>
			   <div id="all_main_all_box_left_mid">
			        <div id="tutor_box">
				      <div id="title" style="width:670px; height:36px; padding:1px;">
					       <div style="width:635px; height:36px; background:#f4f4f4; padding-left:35px;">新教员注册第二步:<font color="#fe5d08">3</font> 填写详细个人信息</div>
					  </div>
					  <div id="tutor_box_center" style="width:668px; padding:1px; border:1px #f4f4f4 solid;">
					    <form action="tutor_infoto.php?act=hy" onSubmit="return yanz()" method="post">
						<div style="width:668px; height:auto; margin:0 auto;  background:#f4f4f4;">
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="50" colspan="6">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="120" height="30" align="right">授课类型：</td>
                            <td colspan="5"><label>
                              <select name="sklx" id="select">
                              <?php
                              $fourList = $bw->selectMany('id, className', 'bw_userproclass', "parentId = 0", 'paixu DESC');
			$fourSum = count($fourList);
			for($fouri = 0; $fouri<$fourSum; $fouri++)
			{
							  ?>
                              <option value="<?php echo $fourList[$fouri]['className']; ?>"><?php echo $fourList[$fouri]['className']; ?></option>
                              <?php
			}
							  ?>
                              </select><span style="color:#F00">
                            *</span>
                            </label></td>
                          </tr>
                          <tr>
                            <td height="30" align="right"><span style="color:#F00">&nbsp;*</span>授课科目：</td>
                            <td height="25" colspan="5"><table width="548" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="200" height="200"><select size="30" id="list1" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list2)">
 <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_userproclass', "parentId=0", 'paixu DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
        <option value="">------<?php echo $list[$i]['className']; ?>--------</option>
 <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list2 = $bw->selectMany('id, className', 'bw_userproclass', "parentId=".$list[$i]['id'], 'id DESC', '');
			$sum2 = count($list2);
			for($i1 = 0; $i1<$sum2; $i1++)
			{
		?>
        <option value="<?php echo $list2[$i1]['className']; ?>"><?php echo $list2[$i1]['className']; ?></option>
        <?php
			}
			}
		?>

                                </select></td>
                                <td width="136" align="center"><input type="button" id="button" value=" 增加 &gt;&gt; " onClick="moveOption(this.form.list1, this.form.list2);inputs('list2','kjskm')">
                                  <br>
                                  <span style="color:#F00; text-align:left;">(选中左侧项目点"选取"即可添加；选中右侧项目点 "删除"即可删除)
                                  <input type="hidden" name="kjskm" id="kjskm">
                                  </span>
                                  <br>
                                <input type="button" id="button2" value=" &lt;&lt; 删除 " onClick="sc(this.form.list2);inputs('list2','kjskm')"></td>
                                <td width="212" align="left"><select size="30" id="list2" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list1)">
                                </select></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td height="30" align="right">授课时间：</td>
                            <td height="25" colspan="5"><input name="ksksj" type="text" class="tutor_inputs" id="ksksj">
                              <span style="color:#F00">&nbsp;如：周一、周三晚上</span></td>
                          </tr>
                          <tr>
                            <td height="30" align="right">可授课区域：</td>
                            <td height="25" colspan="5"> <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><input name="kskqy[]" type="checkbox" id="kskqy" value="<?php echo $split_dir[$i];?>">
<?php echo $split_dir[$i];?>
              <?php
}
			  ?>  <span style="color:#F00">&nbsp;*</span></td>
                          </tr>
                          <tr>
                            <td height="30" align="right">可辅导方式：</td>
                            <td height="25" colspan="5"><input name="kfdfs[]" type="checkbox" id="kfdfs" value="本人上门" checked>
                              本人上门
                                <input name="kfdfs[]" type="checkbox" id="kfdfs" value="学生上门">
学生上门<span style="color:#F00">&nbsp;</span></td>
                          </tr>
                          <tr>
                            <td height="149" align="right">自我描述：</td>
                            <td height="149" colspan="5"><table width="540" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="274"><textarea name="zwms" class="tutor_inputs" id="zwms" style="width:320px; height:120px; line-height:20px;"></textarea></td>
                                <td width="274"><span style="color:#F00">&nbsp;*展示实力，增加你的魅力！比如你竞赛中获得过什么奖项，取得过什么出色的成绩，有哪些过硬的证书之类。【请不要使用空格，尽量使用逗号来代替("，")请控制在600字以内，超过文字被自动删除.】 </span></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td height="159" align="right"><span style="color:#F00">&nbsp;*</span>薪水要求：</td>
                            <td height="159" colspan="5"><textarea name="xsyq" id="xsyq" cols="45" rows="5" style="width:500px; line-height:20px;">执行宁波家教网薪水标准。</textarea>
                            <br><span style="color:#F00;">默认为接受本站的薪水标准(查看详细的报酬标准)，如果你不原接受本站的默认标准，请详细的写出你自己的薪水要求，比如："小学**元每小时；初一初二**元每小时；初中奥数**元每小时；高中奥数**元每小时；成人**元每小时；钢琴**元每小时"。【请不要使用空格，尽量使用逗号来代替("，")】</span> </td>
                          </tr>
                          <tr>
                            <td height="30" align="right">信息来源：</td>
                            <td height="25" colspan="5"><span style="color:#F00">&nbsp;
                              <select name="xxly" id="xxly">
                              <option value="google">google</option>
		<option value="百度">百度</option>
		<option value="其他搜索引擎">其他搜索引擎</option>
		<option value="友情链接">友情链接</option>
		<option value="朋友介绍">朋友介绍</option>
		<option value="论坛">论坛</option>
		<option value="短信">短信</option>
		<option value="邮件">邮件</option>
		<option value="兼职网">兼职网</option>
		<option value="人才网">人才网</option>
		<option value="传单">传单</option>
		<option value="厦门百姓网">厦门百姓网</option>
		<option value="其他">其他</option>
		<option value="小鱼网">小鱼网</option>
		<option value="宣传单">宣传单</option>
		<option value="面试">面试</option>
		<option value="学院勤工">学院勤工</option>
		<option value="网站维护">网站维护</option>
		<option value="58同城">58同城</option>

                              </select>
                            *</span>
                           &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                           <input type="hidden" name="username" id="username" value="<?php echo $_POST["username"];?>">
                           <input type="hidden" name="password" id="password" value="<?php echo $_POST["password"];?>">
                           <input type="hidden" name="email" id="email" value="<?php echo $_POST["email"];?>">
                           <input type="hidden" name="levels" id="levels" value="<?php echo $_POST["levels"];?>">                
                            <input type="hidden" name="truename" id="truename" value="<?php echo $_POST["truename"];?>">                   <input type="hidden" name="sex" id="sex" value="<?php echo $_POST["sex"];?>">
                            <input type="hidden" name="birthday" id="birthday" value="<?php echo $_POST["birthday"];?>">                    <input type="hidden" name="xueli" id="xueli" value="<?php echo $_POST["xueli"];?>">                    <input type="hidden" name="csd" id="csd" value="<?php echo $_POST["csd"];?>">                    <input type="hidden" name="mqsf" id="mqsf" value="<?php echo $_POST["mqsf"];?>">                    <input type="hidden" name="quyu" id="quyu" value="<?php echo $_POST["quyu"];?>"> <input type="hidden" name="zhuanye" id="zhuanye" value="<?php echo $_POST["zhuanye"];?>"> <input type="hidden" name="idcode" id="idcode" value="<?php echo $_POST["idcode"];?>"><input type="hidden" name="xuexiao" id="xuexiao" value="<?php echo $_POST["xuexiao"];?>"><input type="hidden" name="telphone" id="telphone" value="<?php echo $_POST["telphone"];?>"><input type="hidden" name="qq" id="qq" value="<?php echo $_POST["qq"];?>"><input type="hidden" name="address" id="address" value="<?php echo $_POST["address"];?>"><input type="hidden" name="zhicheng" id="zhicheng" value="<?php echo $_POST["zhicheng"];?>">
                            <input type="hidden" name="jiaolin" id="jiaolin" value="<?php echo $_POST["jiaolin"];?>">
                            <input type="hidden" name="rzxxlb" id="rzxxlb" value="<?php echo $_POST["rzxxlb"];?>"><input type="hidden" name="guojia" id="guojia" value="<?php echo $_POST["guojia"];?>">
                            <input type="hidden" name="rjxk" id="rjxk" value="<?php echo $_POST["rjxk"];?>">
                            <input type="hidden" name="zhrzxx" id="zhrzxx" value="<?php echo $_POST["zhrzxx"];?>"><input type="hidden" name="reg_time" id="reg_time" value="<?php echo date("Y-m-d H:i:s", mktime());?>"><input type="hidden" name="lang" id="lang" value="<?php echo $_COOKIE["cookie_lang"];?>"><input type="hidden" name="ifnew" id="ifnew" value="1"></td>
                          </tr>
                          <tr>
                            <td height="100" colspan="6" align="center"><label>
                              <input type="image" src="images/zjj_07.jpg">
                            </label>&nbsp;
                              <label>
                              <input type="image" src="images/zjj_06.jpg">
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
<script language="JavaScript"><!--
function moveOption(e1, e2){
		 a=1;
     try{
         var e = e1.options[e1.selectedIndex];
		  for (i=0;i<e2.length;i++) {
			if(e2.options[i].value==e.value)
			{
				a=2
				}  
		  }
		  if (a==1&&e.value.length!=0)
		  {
			// alert(e.value.length)
         e2.options.add(new Option(e.text, e.value));
		  }
     }    catch(e){}
}
     function sc(e1)
	 {
         var e = e1.options[e1.selectedIndex];
		 e1.options.remove(e1.selectedIndex);
		 }	 function inputs(a,b){
    var aa,bb;
    aa=document.getElementById(a);
     document.getElementById(b).value="";
    for (i=0;i<aa.length;i++) {
	 bb=document.getElementById(b).value+",";
     document.getElementById(b).value=bb+aa.options[i].value;
     //alert(aa.options[i].value);
    }
   }
//--></script>
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
