<?php
	session_start();
	require '../inc/config.php';
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
	if($_GET["lang"]!="")
	{
	$_SESSION["Lang_session"]=base64_decode(iconv("gb2312","utf-8",$_GET["lang"]));
	echo "<script>window.parent.location.reload();</script>";
	}
	$langData = $bw->selectOnly('*', 'bw_lang', 'id = 1', '');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>顶部</title>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<link href="css/frame.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="top">
	 <div class="topLeft"></div>
     <div class="topMain">
     当前版本为：&nbsp;
     
     <select name="" onchange="window.location.href=(this.value);">
	 <?php
	 $quanx = $bw->selectOnly('lang','bw_user',"username='".$_SESSION['username']."'", '');
	   if($_SESSION['username']!="admin"&&$quanx['lang']!="全站"){
	 ?>
	 <option value="<?php echo $_SESSION['Lang_session'];?>" ><?php echo $_SESSION['Lang_session'];?></option>
	 <?php 
	   }else{
	 ?>
			<?php
			  $dir=$langData["lang"];
			  $split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
			  for($i=0;$i<count($split_dir);$i++)
			  { 
			?>
            <option <?php 
			if($split_dir[$i]==$_SESSION["Lang_session"]){
				echo "selected='selected'";
				}
			?> value="?lang=<?php echo base64_encode($split_dir[$i]);?>" ><?php echo $split_dir[$i];?></option>
            <?php
              }
            ?>
	<?php
	  }
	?>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<marquee onmouseover="this.stop()" onmouseout="this.start()" scrollamount=4 style="width:350px;">
<font color="#FF0000">新注册教员编号：</font>
<?php
	//selectMany($param,$tbname,$where,$order,$limit)
	$jynewList = $bw->selectMany("*","bw_member","ifnew=1 and lang='".$_SESSION["Lang_session"]."'","`id` desc","500");
	//var_dump($classList);
	//exit;
	$menu_sumjy = count($jynewList);
	if($menu_sumjy>0){
	for($i = 0; $i<$menu_sumjy; $i++)
	{
?>
<a href="membermod.php?id=<?php echo $jynewList[$i]['id'];?>" class="a" target="main"><?php echo $jynewList[$i]['id'];?></a>&nbsp;
<?php
}
}else{
echo "暂无相关信息！";
	}//end loop
?>
&nbsp;&nbsp;&nbsp;
<font color="#FF0000">学员自填订单编号：</font>
<?php
	//selectMany($param,$tbname,$where,$order,$limit)
	$xynewList = $bw->selectMany("*","bw_qjj","ifnew=1 and lang='".$_SESSION["Lang_session"]."'","`id` desc","500");
	//var_dump($classList);
	//exit;
	$menu_sumjy = count($xynewList);
	if($menu_sumjy>0){
	for($i = 0; $i<$menu_sumjy; $i++)
	{
?>
<a href="xyadd.php?id=<?php echo $xynewList[$i]['id'];?>" class="a" target="main"><?php echo $xynewList[$i]['id'];?></a>&nbsp;
<?php
}
}else{
echo "暂无相关信息！";
	}//end loop
?>
&nbsp;&nbsp;&nbsp;
<font color="#FF0000">教员预约学员订单编号：</font>
<?php
	//selectMany($param,$tbname,$where,$order,$limit)
	$ordernewList = $bw->selectMany("*","bw_order","ifdd=1 and yylx=1 and ifnew=1 and lang='".$_SESSION["Lang_session"]."'","`id` desc","500");
	//var_dump($classList);
	//exit;
	$menu_sumjy = count($ordernewList);
	if($menu_sumjy>0){
	for($i = 0; $i<$menu_sumjy; $i++)
	{
?>
<a href="jyorderlist2.php?ifnew=<?php echo $ordernewList[$i]['id'];?>" class="a" target="main"><?php echo $ordernewList[$i]['xyid'];?></a>&nbsp;
<?php
}
}else{
echo "暂无相关信息！";
	}//end loop
?>
</marquee>

     </div>
     <div class="topRight"><a href="main.php" target="main"><img src="images/t1.jpg" /></a><!--<a href="fkxxlist.php" target="main"><img src="images/t2.jpg" /></a>--><a href="newsadd.php" target="main"><img src="images/t4.jpg" /></a><a href="?action=out"><img src="images/t5.jpg" /></a></div>
   
</div>
</body>
</html>