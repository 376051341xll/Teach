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
		location.href="user_yfxx.php?page="+thisPage.val();
		});//end page_SEL 		
	});

</script>
 <script>
		function delconfirm(dlid){
		if(confirm("你确定删除吗?")){
		window.location.href="?act=yes&dlid="+dlid
		}
		}
</script> 
<script>
			function yinc(id)
{
	if(document.getElementById(id).style.display=="")
	{
		document.getElementById(id).style.display='none';
	}else{
		document.getElementById(id).style.display='';
		}
}
</script>
<?php
if(!empty($_GET["act"]))
{
        $sql = "UPDATE bw_zxwd SET ifdl = 2 WHERE id = {$_GET['dlid']}";
		$bw->query($sql);
		$bw->msg('删除成功!');
}		
?>
<?php include("top.php");?>
<!-- header end-->
<div class="user_c">
<div class="user_left">
<?php include("user_left.php");?>
</div>
<div class="user_sjx_c">
<div class="user_sjx_t">
  <table width="748" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="93" height="25" align="center" valign="middle" style="border-right:1px solid #D3D3D3;border-bottom:1px solid #D3D3D3;"><a href="user_fsxx.php"><strong>发送信息</strong></a></td>
      <td width="85" align="center" valign="middle" style="border-right:1px solid #D3D3D3;border-bottom:1px solid #D3D3D3;"><a href="user_sjx.php"><strong>收件箱</strong></a></td>
      <td width="81" align="center" valign="middle" style="border-right:1px solid #D3D3D3; background:#FFF; border-bottom:1px solid #FFF;"><a href="user_yfxx.php"><strong>已发信息</strong></a></td>
      <td width="398" style="border-bottom:1px solid #D3D3D3;">&nbsp;</td>
    </tr>
  </table>
</div>
<div class="user_sjx_nr"><table width="724" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9">
    <tr>
      <td width="99" height="34" align="center" valign="middle" background="images/user_sjx_bt_bg.jpg">类型</td>
      <td width="102" align="center" valign="middle" background="images/user_sjx_bt_bg.jpg">收件人</td>
      <td width="333" align="center" valign="middle" background="images/user_sjx_bt_bg.jpg">消息主题</td>
      <td width="96" align="center" valign="middle" background="images/user_sjx_bt_bg.jpg">留言时间</td>
      <td width="94" align="center" valign="middle" background="images/user_sjx_bt_bg.jpg">管理</td>
    </tr>
    <?php
	  //selectPage($param,$tbname,$where,$order,$limit)
	  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
	  $pageSize = 15;
	  $tbName   = 'bw_zxwd';
	  $where    = 'ifdl = 1 and uid='.$_SESSION["userid"];
	  $hyzxlist = $bw->selectPage("id,title,content,xxlx,addtime", $tbName, $where, "id DESC", $pageSize);
	  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
	  $hyzxsum = count($hyzxlist);
	  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
	  {
    ?>
    <tr>
      <td height="32" align="center" valign="middle" bgcolor="#FFFFFF">单条信息<?php echo $hyzxlist[$hyzxi]['xxlx'] ;?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF">管理员</td>
      <td align="center" valign="middle" bgcolor="#FFFFFF">
	  <a href="#" onClick="yinc('cc<?php echo $hyzxlist[$hyzxi]['id'];?>')"><?php echo $hyzxlist[$hyzxi]['title'] ;?></a></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo date("Y-m-d",strtotime($hyzxlist[$hyzxi]['addtime']));?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF"><a href="#" onClick="delconfirm(<?php echo $hyzxlist[$hyzxi]['id']; ?>)">删除</a></td>
    </tr>
	<tr id="cc<?php echo $hyzxlist[$hyzxi]['id'];?>" style="display:none;">
      <td height="32" align="center" valign="middle" bgcolor="#FFFFFF" style="color:#003399">内容</td>
      <td colspan="4" align="left" valign="middle" bgcolor="#FFFFFF" style="color:#003399">&nbsp;&nbsp;<?php echo $hyzxlist[$hyzxi]['content'] ;?></td>
      </tr>
    <?php
	}
	?>
	<tr>
      <td height="30" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF">
	   共:<?php echo $pageArray['totalRow']; ?>条信息&nbsp;&nbsp;&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>&nbsp;页&nbsp;&nbsp;&nbsp;
				<a href="?page=1">首页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
				转到
						<select name="page_SEL" onChange="MM_jumpMenu('parent',this,0)">
                   	<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="user_yfxx.php?page=<?php echo $goPage; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
                  </select>	  </td>
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
