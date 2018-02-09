<?php
	session_start();
	if($_SESSION['shell'] < 1)
	{
		$_SESSION['shell'] = '';
		echo "<script>window.parent.location.href='login.php'; </script>";
	}
	$action = $_GET['action'];
	if($action == 'out')
	{
		session_destroy();
		echo "<script>parent.location.href='login.php';</script>";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/frame.css" rel="stylesheet" type="text/css" />
<title>左部导航</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		  var leftMenuOption = $(".fatherA");
		  var sonBoxDiv = $(".sonBox");
		  sonBoxDiv.eq(0).show();
		  leftMenuOption.each(function(e){
			  leftMenuOption.eq(e).click(function(){
					var sonBoxDiv = $(".sonBox");
					if(!sonBoxDiv.is(":animated"))
					{
						sonBoxDiv.slideUp(200);
						sonBoxDiv.eq(e).slideDown(300);
					}
				});					   
		  });
	});
</script>
</head>
<style type="text/css">
<!--
BODY {
	scrollbar-face-color: #e9e9e9;
	scrollbar-shadow-color: #cecece;
	scrollbar-3dlight-color: #e9e9e9;
	scrollbar-arrow-color: #000000;
	scrollbar-track-color: #e9e9e9;
	scrollbar-darkshadow-color: #ffffff;
	scrollbar-highligh-color: #f6f6f6;
}
-->
</style>
<body>
<ul class="leftMenu">
    <?php
         if(strlen(strstr($_SESSION['quanxian'],"1.1"))>0||$_SESSION['username']=="admin")
		 {
	?>
	<li>
    	<a href="###" class="fatherA">管理员管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
            	<li><a href="adminlist.php?act=k" target="main">管理员列表</a></li>
                <?php
         if(strlen(strstr($_SESSION['quanxian'],"1.2"))>0||$_SESSION['username']=="admin")
		 {
                
				?>
            	<li><a href="adadmin.php" target="main">管理员增加</a></li>
                <?php
		 }
				?>
            </ul>
        </div>
    </li>
    <?php
		 }
	?>
	<li>
    	<a href="###" class="fatherA">网站基本配置</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
	<?php
         if(strlen(strstr($_SESSION['quanxian'],"2.1"))>0||$_SESSION['username']=="admin")
		 {
	?>
            	<li><a href="webConfig.php" target="main">网站基本配置</a></li>
	<?php
		 }
         if($_SESSION['username']=="admin")
		 {
	?>
				 <li><a href="weblang.php" target="main">分站配置</a></li>
                <li><a href="userproclass.php" target="main">学科分类</a></li>
				<li><a href="databack/index.php" target="main">数据备份</a></li>
	<?php
		 }
	?>
                <li><a href="changepwd.php" target="main">修改密码</a></li>
                <li><a href="?action=out">退出登录</a></li>
            </ul>
        </div>
    </li>
	<?php
         if(strlen(strstr($_SESSION['quanxian'],"3.1"))>0||$_SESSION['username']=="admin")
		 {
	?>
	<li>
    	<a href="###" class="fatherA">网站信息栏目</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
				<li><a href="baselist.php?act=k" target="main">信息栏目列表</a></li>
				<li><a href="baseadd.php" target="main">新增信息栏目</a></li>
            </ul>
        </div>
    </li>
	<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"4.1"))>0||$_SESSION['username']=="admin")
		 {
    ?>
	<li>
    	<a href="###" class="fatherA">资费标准栏目</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
				<li><a href="zfbzlist.php?act=k" target="main">信息栏目列表</a></li>
				<li><a href="zfbzadd.php" target="main">新增信息栏目</a></li>
            </ul>
        </div>
    </li>
	<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"5.1"))>0||$_SESSION['username']=="admin")
		 {
  ?>
    <li>
    <a href="###" class="fatherA">教员管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
                <li><a href="memberlist.php?sou=k" target="main">教员管理</a></li>
                <li><a href="memberadd.php" target="main">增加教员</a></li>
            </ul>
        </div>
    </li>
	<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"6.1"))>0||$_SESSION['username']=="admin")
		 {
  ?>
	<li>
    <a href="###" class="fatherA">学员管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
                <li><a href="xylist.php?act=k" target="main">普通学员列表</a></li>
				<li><a href="xyhylist.php?act=k" target="main">会员学员列表</a></li>
			    <li><a href="xyadd.php" target="main">新增学员</a></li>
            </ul>
        </div>
    </li>
	<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"7.1"))>0||$_SESSION['username']=="admin")
		 {
    ?>
    <li>
    <a href="###" class="fatherA">订单管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
				<li><a href="orderwap.php?act=k" target="main">未安排的订单</a></li>
                <li><a href="jyorderlist.php?act=k" target="main">订单列表</a></li>
				<li><a href="jyorderlist1.php?act=k" target="main">学员预约教员</a></li>
				<li><a href="jyorderlist2.php?act=k" target="main">教员预约学员</a></li>	
                <li><a href="jyorderlist3.php?act=k" target="main">家教记录</a></li>
            </ul>
        </div>
    </li>
	<?php
		 }
    ?>
	<li>
    <a href="###" class="fatherA">财务管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
			<?php
				if(strlen(strstr($_SESSION['quanxian'],"8.1"))>0||$_SESSION['username']=="admin")
		 		{
			?>
               <li><a href="membermoneylist.php?act=k" target="main">会员资金查询</a></li>
                <li><a href="memberRechargelist.php?s=0" target="main">资金来往记录</a></li>
                <li><a href="memberwithdrawlist.php?act=k" target="main">退款申请记录</a></li>
				<li><a href="zhuanzhangadd.php" target="main">资金手动操作</a></li>
				<li><a href="jycount.php" target="main">教员数据统计</a></li>
			<?
				}
			?>
				<li><a href="ddcount.php" target="main">订单数据统计</a></li>
			<?php
				if(strlen(strstr($_SESSION['quanxian'],"8.1"))>0||$_SESSION['username']=="admin")
		 		{
			?>
				<li><a href="memberlisttongji.php?sou=k" target="main">预存款统计</a></li>
			<?
				}
			?>
            </ul>
        </div>
    </li>
	<?php
         if(strlen(strstr($_SESSION['quanxian'],"9.1"))>0||$_SESSION['username']=="admin")
		 {
    ?>
    <li>
    	<a href="###" class="fatherA">广告信息管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
                <li><a href="adlist.php" target="main">广告管理</a></li>
                <li><a href="adadd.php" target="main">新增广告</a></li>
            </ul>
        </div>
    </li>
	<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"10.1"))>0||$_SESSION['username']=="admin")
		 {
    ?>
	<li>
    	<a href="###" class="fatherA">文章管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
            	<li><a href="articlelist.php?act=k" target="main">文章列表</a></li>
                <li><a href="articleadd.php" target="main">添加文章</a></li>
                <li><a href="articleclass.php" target="main">分类管理</a></li>
            </ul>
        </div>    
    </li>
	<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"11_1"))>0||$_SESSION['username']=="admin")
		 {
    ?>
	 <li>
	 <li>
    	<a href="###" class="fatherA">辅导班管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
            	<li><a href="fudaobanlist.php?act=k" target="main">辅导班列表</a></li>
                <li><a href="fudaobanadd.php" target="main">新增辅导班</a></li>
            </ul>
        </div>    
    </li>
	<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"11_1"))>0||$_SESSION['username']=="admin")
		 {
    ?>
	 <li>
    	<a href="###" class="fatherA">资料下载管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
            	<li><a href="downloadlist.php" target="main">资料下载列表</a></li>
                <li><a href="downloadadd.php" target="main">新增资料下载</a></li>
            </ul>
        </div>    
    </li>
	<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"12_1"))>0||$_SESSION['username']=="admin")
		 {
    ?>
    <li>
    	<a href="###" class="fatherA">友情链接管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
            	<li><a href="linklist.php" target="main">友情链接列表</a></li>
                <li><a href="linkadd.php" target="main">新增友情链接</a></li>
            </ul>
        </div>    
    </li>
	<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"13_1"))>0||$_SESSION['username']=="admin")
		 {
    ?>
     <li>
    	<a href="###" class="fatherA">站内信箱管理</a>
    	<div class="sonBox">
        	<ul class="sonMenu">
                <li><a href="sjxlist.php?act=k" target="main">收件箱列表</a></li>
                <li><a href="fjxlist.php?act=k" target="main">发件箱列表</a></li>
                <li><a href="fjxadds.php?act=k" target="main">发送站内信</a></li>
            </ul>
        </div>
    </li>
	<?php
		 }
	?>
</ul>
</body>
</html>