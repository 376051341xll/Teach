<?php  session_start();
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
include("checkuser.php"); 
$classData = $bw->selectOnly('*' ,'bw_member', 'id = '.$_SESSION["userid"]);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<title><?php echo $service_title; ?></title>
<meta name="keywords" content="<?php echo $service_keyword.'-'.$service_title; ?>" />
<meta name="description" content="<?php echo $service_description.'-'.$service_title; ?>" />
<META http-equiv=content-type content="text/html; charset=utf-8">
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico">
<style>
#hyym tr td{padding:5px;}
</style>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="user_main.php?page="+thisPage.val()+"&id="+<?php echo $_SESSION["userid"]; ?>;
		});//end page_SEL 		
	});
</script>
</HEAD>
<BODY>
<?php include("top.php");?>
<!-- header end-->
<div class="user_c">
<div class="user_left">
<?php include("user_left.php");?>
</div>
<div class="user_right">
     <div id="xcrz_tltle">欢迎页面</div>
     <div id="xcrz_nr">
	 <table id="hyym" width="90%" border="0" align="center" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td width="30%" height="25" bgcolor="#FFFFFF">尊敬的教员：<?php echo $classData['truename'];?></td>
    <td width="30%" bgcolor="#FFFFFF">您的教员编号：<?php echo $classData['id'];?></td>
    <td width="30%" bgcolor="#FFFFFF">教员类型：
	            <?php if($classData['ifxj']>=3 && $classData['ifxj']<6)
				{
				     echo "明星教员";
				}else{
				     echo "普通会员";
				}
				?>	</td>
  </tr>
  <tr>
    <td height="25" bgcolor="#FFFFFF">您的简历被浏览：<?php echo $classData['hits'];?>次</td>
    <td bgcolor="#FFFFFF">已登录：<?php echo $classData['dlcs'];?>次</td>
    <td bgcolor="#FFFFFF">最近登录时间：<?php echo $classData['zjtime'];?></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#FFFFFF">账户余额：<b style="color:#FF0000"><?php echo $classData['Money'];?></b>元
	   <a href="zxzf_zfb.php?acontent=1" target="_blank"><font color="#FF6600">马上充值？</font></a></td>
    <td bgcolor="#FFFFFF">最新公告：<a href="news.php?sid=3" target="_blank"><font color="#FF6600">点击查看</font></a></td>
    <td bgcolor="#FFFFFF">您有未读消息: <a href="user_sjx.php"><font color="#FF6600"><?php
								$classList = $bw->selectMany("*","bw_zxwdhf","ifyd=1 and uid='".$_SESSION["userid"]."'","`id` ASC");
								$menu_sum = count($classList);
								if($menu_sum==0)
								{
								   echo $menu_sum."条";
								}else
								{
								   echo $menu_sum."条(点击查看)";
								}
							?></font></a></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#FFFFFF">简历审核情况？：
	<?php if($classData['shqk']==1)
	{
	echo "<span style='color:green'>通过审核</span>";
	}elseif($classData['shqk']==0)
	{
	echo "<span style='color:red'>未通过审核</span>";
	}else
	{
	echo "<span style='color:#0000FF'>待审核</span>";
	}
	?>	</td>
    <td bgcolor="#FFFFFF">简历显示情况？：
	<?php 
	if($classData['iffb']==2)
	{
	echo "<span style='color:green'>已发布</span>";
	}
	else{
	echo "<span style='color:red'>未发布</span>";
	}?>	</td>
    <td bgcolor="#FFFFFF">认证情况？：<?php if($classData['ifrz'] == 1){ 
	echo "<span style='color:red'>未认证</span>";
	 }
	 if($classData['ifrz'] == 2)
	 {
		 echo "<span style='color:green'>已认证</span>";
	}
	if($classData['ifrz'] == 3)
	{
		echo "<span style='color:#0000FF'>已过期</span>";
		} ?></td>
  </tr>
  <tr>
    <td height="25" colspan="3" bgcolor="#FFFFFF">
	<br>
	常见注意事项：</td>
    </tr>
  <tr>
    <td height="25" colspan="3" bgcolor="#FFFFFF">
	<?php
			$classData = $bw->selectOnly('content,title' ,'bw_base', 'id = 21');
            echo $classData['content'];
	 ?>	 </td>
    </tr>
	<tr>
    <td height="25" colspan="3" bgcolor="#FFFFFF">
	<br>
	<p>最新订单：</p></td>
    </tr>
  <tr>
    <td height="25" colspan="3" bgcolor="#FFFFFF">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%" height="25" align="center" bgcolor="#eeeeee"><strong>学员编号</strong></td>
    <td width="15%" align="center" bgcolor="#eeeeee"><strong>学员姓名</strong></td>
    <td width="20%" align="center" bgcolor="#eeeeee"><strong>求教学科</strong></td>
    <td width="20%" align="center" bgcolor="#eeeeee"><strong>订单状态</strong></td>
    <td width="20%" align="center" bgcolor="#eeeeee"><strong>时间</strong></td>
	<td width="20%" align="center" bgcolor="#eeeeee"><strong>查看</strong></td>
  </tr>
  
<?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_qjj';
				  $where    = "1=1 and isshow=2 and zt='未安排' and lang='".$_COOKIE["cookie_lang"]."'";
				  $hyzxlist = $bw->selectPage("*", $tbName, $where, "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
			  ?>
  <tr>
    <td height="25" align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $hyzxlist[$hyzxi]['id'] ;?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $hyzxlist[$hyzxi]['name'] ;?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $hyzxlist[$hyzxi]['qjkm']; ?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $hyzxlist[$hyzxi]['zt']; ?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC">&nbsp;<?php echo date("Y-m-d",strtotime($hyzxlist[$hyzxi]['addtime']));?></td>
	<td align="center" style="border-bottom:1px dashed #CCCCCC"><a href="studentshow.php?id=<?php echo $hyzxlist[$hyzxi]['id'];?>" target="_blank"><span>[查看]</span></a></td>
  </tr>
  <?php
                  }//end loop
              ?>
  <tr>
    <td height="30" colspan="6" align="center">
	共:<?php echo $pageArray['totalRow']; ?>条信息&nbsp;&nbsp;&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>&nbsp;页&nbsp;&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=1">首页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
				转到
						<select name="page_SEL" onChange="MM_jumpMenu('parent',this,0)">
                   	<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="user_main.php?page=<?php echo $goPage; ?>&id=<?php echo $_SESSION["userid"]; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
                  </select>	</td>
  </tr>
</table>	</td>
    </tr>
  <tr>
    <td height="25" colspan="3" bgcolor="#FFFFFF">
	<br>
	<p>已申请的订单：</p></td>
    </tr>
  <tr>
    <td height="25" colspan="3" bgcolor="#FFFFFF">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%" height="25" align="center" bgcolor="#eeeeee"><strong>订单ID</strong></td>
    <td width="15%" align="center" bgcolor="#eeeeee"><strong>学员编号</strong></td>
    <td width="20%" align="center" bgcolor="#eeeeee"><strong>学员姓名</strong></td>
    <td width="20%" align="center" bgcolor="#eeeeee"><strong>订单状态</strong></td>
    <td width="20%" align="center" bgcolor="#eeeeee"><strong>时间</strong></td>
  </tr>
  
<?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_order';
				  $where    = 'ddzt=1 and jyid = '.$_SESSION["userid"];
				  $hyzxlist = $bw->selectPage("*", $tbName, $where, "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
				  $xyData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$hyzxlist[$hyzxi]['xyid']);
			  ?>
  <tr>
    <td height="25" align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $hyzxlist[$hyzxi]['id'] ;?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $hyzxlist[$hyzxi]['xyid'] ;?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $xyData['name']; ?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC">
					<?php if($hyzxlist[$hyzxi]['ddzt']==1 && $hyzxlist[$hyzxi]['ifdd']==2){echo "试教中";}else{echo "未安排";}?> 
	</td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC">&nbsp;<?php echo $hyzxlist[$hyzxi]['addtime'] ;?></td>
  </tr>
  <?php
                  }//end loop
              ?>
  <tr>
    <td height="30" colspan="5" align="center">
	共:<?php echo $pageArray['totalRow']; ?>条信息&nbsp;&nbsp;&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>&nbsp;页&nbsp;&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=1">首页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
				转到
						<select name="page_SEL" onChange="MM_jumpMenu('parent',this,0)">
                   	<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="user_main.php?page=<?php echo $goPage; ?>&id=<?php echo $_SESSION["userid"]; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
                  </select>	</td>
  </tr>
</table>	</td>
    </tr>
	<tr>
    <td height="25" colspan="3" bgcolor="#FFFFFF">
	<br>
	<p>家教记录：</p></td>
    </tr>
  <tr>
    <td height="25" colspan="3" bgcolor="#FFFFFF">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%" height="25" align="center" bgcolor="#eeeeee"><strong>订单ID</strong></td>
    <td width="15%" align="center" bgcolor="#eeeeee"><strong>学员编号</strong></td>
    <td width="20%" align="center" bgcolor="#eeeeee"><strong>学员姓名</strong></td>
    <td width="20%" align="center" bgcolor="#eeeeee"><strong>订单状态</strong></td>
    <td width="20%" align="center" bgcolor="#eeeeee"><strong>时间</strong></td>
  </tr>
  
<?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_order';
				  $where    = 'ddzt<>1 and jyid = '.$_SESSION["userid"];
				  $hyzxlist = $bw->selectPage("*", $tbName, $where, "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
				  $xyData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$hyzxlist[$hyzxi]['xyid']);
			  ?>
  <tr>
    <td height="25" align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $hyzxlist[$hyzxi]['id'] ;?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $hyzxlist[$hyzxi]['xyid'] ;?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC"><?php echo $xyData['name']; ?></td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC">
					<?php if($hyzxlist[$hyzxi]['ddzt']==1){echo "试教中";}?> 
					<?php if($hyzxlist[$hyzxi]['ddzt']==2){echo "订单成功";}?>
					<?php if($hyzxlist[$hyzxi]['ddzt']==3){echo "订单失败";}?>	</td>
    <td align="center" style="border-bottom:1px dashed #CCCCCC">&nbsp;<?php echo $hyzxlist[$hyzxi]['addtime'] ;?></td>
  </tr>
  <?php
                  }//end loop
              ?>
  <tr>
    <td height="30" colspan="5" align="center">
	共:<?php echo $pageArray['totalRow']; ?>条信息&nbsp;&nbsp;&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>&nbsp;页&nbsp;&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=1">首页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $_SESSION["userid"]; ?>&page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
				转到
						<select name="page_SEL" onChange="MM_jumpMenu('parent',this,0)">
                   	<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="user_main.php?page=<?php echo $goPage; ?>&id=<?php echo $_SESSION["userid"]; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
                  </select>	</td>
  </tr>
</table>	</td>
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
