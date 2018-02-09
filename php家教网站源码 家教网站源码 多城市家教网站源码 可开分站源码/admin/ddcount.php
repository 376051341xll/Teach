<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']);
	if( $_GET['s']==0)
	{
		$_SESSION['wherejflists']="";
	}
	htqx("8.1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员信息列表</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script language=javascript src="js/wpCalendar.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="memberRechargelist.php?page="+thisPage.val();
		});//end page_SEL 		
	});
</script>
</head>

<body>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>时间:
  <input name="stime" type=text id=text1 style="width:80px;" onfocus="showCalendar(this)" readonly> 
  <input name="etime" type=text id=text1 style="width:80px;" onfocus="showCalendar(this)" readonly>
  <?php 
  if($_SESSION['username']=="admin")
  {
  ?>
  <label>
  选择业务员：
  <select name="ywname">
    <option value="">全部业务员</option>
	<option value="admin">admin</option>
	<?php
		//selectMany($param,$tbname,$where,$order,$limit)
		$ywList = $bw->selectMany("username","bw_user","lang = '".$Lang."' and id<>1 ","`id` ASC");
		$menu_sum = count($ywList);
		for($i = 0; $i<$menu_sum; $i++)
		{
	?>
	<option value="<?php echo $ywList[$i]['username'];?>"><?php echo $ywList[$i]['username'];?></option>
	<?php
		}
	?>
  </select>
  </label>
  <?php 
  }
  ?>
  &nbsp;&nbsp;
  <input type="submit" value="搜索" /></td>
</form>
</tr>
</table>
<table width="96%" border="0" cellspacing="0" cellpadding="0">
  <tr class="showtr">
    <td height="25" align="right">业务员：</td>
    <td><?php if(!empty($_POST['ywname'])){echo $_POST['ywname'];}elseif($_SESSION['username']=="admin"){echo "全部业务员";}else{echo $_SESSION['username'];}?></td>
  </tr>
  <tr class="showtr">
    <td width="10%" height="25" align="right">发布学员数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	//die($_POST['stime']);
	  $where = "isshow=2 and lang='".$Lang."'";
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'isshow=1 and lang="'.$Lang.'"';
	}
	//die($where);
	$zcData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $zcData["zong"];
	?>	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">成功家教数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'ddzt=2 and lang="'.$Lang.'"';
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 //$etime=$_POST['etime']."&nbsp;23:59:59";
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (cltime >='".$stime."' and cltime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (cltime >='".$_POST['stime']."' and cltime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and cltime >='".$_POST['stime']."' and cltime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'ddzt=2 and lang="'.$Lang.'"';
	}
	//echo $where;
	$rzData = $bw->selectOnly('count(id) as zong' ,'bw_order',$where);
    echo $rzData["zong"];
	//$ssData = $bw->selectOnly('*' ,'bw_order','id=5733');
	//echo $ssData["addtime"]
	?>	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">失败家教数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'ddzt=3 and lang="'.$Lang.'"';
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 //$etime=$_POST['etime']."&nbsp;23:59:59";
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (cltime >='".$stime."' and cltime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (cltime >='".$_POST['stime']."' and cltime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and cltime >='".$_POST['stime']."' and cltime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'ddzt=3 and lang="'.$Lang.'"';
	}
	$fbData = $bw->selectOnly('count(id) as zong' ,'bw_order',$where);
    echo $fbData["zong"];
	?>	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">信息费收入：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'acontent=4 and lang="'.$Lang.'"';
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'acontent=4 and lang="'.$Lang.'"';
	}
	$shData = $bw->selectOnly('sum(amount) as zong' ,'bw_moneyrecord',$where);
    echo $shData["zong"]*"-1";
	?>	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">会员费收入：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'acontent=6 and lang="'.$Lang.'"';
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'acontent=6 and lang="'.$Lang.'"';
	}
	$shdxsData = $bw->selectOnly('sum(amount) as zong' ,'bw_moneyrecord',$where);
    echo $shdxsData["zong"]*"-1";
	?>	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">认证费收入：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'acontent=2 and lang="'.$Lang.'"';
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'acontent=2 and lang="'.$Lang.'"';
	}
	$shjsData = $bw->selectOnly('sum(amount) as zong' ,'bw_moneyrecord',$where);
    echo intval($shjsData["zong"]);
	?>	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">违约款收入：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'acontent=3 and lang="'.$Lang.'"';
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'acontent=3 and lang="'.$Lang.'"';
	}
	$shlxsData = $bw->selectOnly('sum(amount) as zong' ,'bw_moneyrecord',$where." and amount>0");
    echo $shlxsData["zong"];
	?>	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">总退款金额：</td>
    <td><?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'acontent=5 and lang="'.$Lang.'"';
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'acontent=5 and lang="'.$Lang.'"';
	}
	$shjsData = $bw->selectOnly('sum(amount) as zong' ,'bw_moneyrecord',$where." and amount<0");
    echo intval($shjsData["zong"]);
	?></td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">银行统计：</td>
    <td>&nbsp; 建设银行：
      <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "yinhang=1 and lang='".$Lang."'";
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	  $where = "yinhang=1 and lang='".$Lang."'";
	}
	$yjData = $bw->selectOnly('sum(amount) as zong' ,'bw_moneyrecord',$where." and amount>0");
    echo $yjData["zong"];
	?>
      &nbsp; &nbsp;&nbsp; &nbsp;中国银行：
      <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "yinhang=2 and lang='".$Lang."'";
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	  $where = "yinhang=2 and lang='".$Lang."'";
	}
	$yjData = $bw->selectOnly('sum(amount) as zong' ,'bw_moneyrecord',$where." and amount>0");
    echo $yjData["zong"];
	?>
      &nbsp;&nbsp; &nbsp;工商银行：
      <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "yinhang=3 and lang='".$Lang."'";
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	  $where = "yinhang=3 and lang='".$Lang."'";
	}
	$yjData = $bw->selectOnly('sum(amount) as zong','bw_moneyrecord',$where." and amount>0");
    echo $yjData["zong"];
	?>
      &nbsp; &nbsp;&nbsp; &nbsp;招商银行：
      <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "yinhang=4 and lang='".$Lang."'";
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	  $where = "yinhang=4 and lang='".$Lang."'";
	}
	$yjData = $bw->selectOnly('sum(amount) as zong','bw_moneyrecord',$where." and amount>0");
    echo $yjData["zong"];
	?>
      &nbsp; &nbsp;&nbsp; &nbsp;邮政银行：
      <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "yinhang=5 and lang='".$Lang."'";
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	  $where = "yinhang=5 and lang='".$Lang."'";
	}
	$yjData = $bw->selectOnly('sum(amount) as zong','bw_moneyrecord',$where." and amount>0");
    echo $yjData["zong"];
	?>
      &nbsp; &nbsp;&nbsp; &nbsp;交通银行：
      <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "yinhang=6 and lang='".$Lang."'";
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	  $where = "yinhang=6 and lang='".$Lang."'";
	}
	$yjData = $bw->selectOnly('sum(amount) as zong','bw_moneyrecord',$where." and amount>0");
    echo $yjData["zong"];
	?>
      &nbsp; &nbsp;&nbsp; &nbsp;农业银行：
      <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "yinhang=10 and lang='".$Lang."'";
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	  $where = "yinhang=10 and lang='".$Lang."'";
	}
	$yjData = $bw->selectOnly('sum(amount) as zong','bw_moneyrecord',$where." and amount>0");
    echo $yjData["zong"];
	?>&nbsp; &nbsp;&nbsp; &nbsp;信用社：
      <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "yinhang=7 and lang='".$Lang."'";
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	  $where = "yinhang=7 and lang='".$Lang."'";
	}
	$yjData = $bw->selectOnly('sum(amount) as zong','bw_moneyrecord', $where." and amount>0");
    echo $yjData["zong"];
	?>
      &nbsp; &nbsp;&nbsp; &nbsp;其他：
    <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "yinhang=8 and lang='".$Lang."'";
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	  $where = "yinhang=8 and lang='".$Lang."'";
	}
	$yjData = $bw->selectOnly('sum(amount) as zong' ,'bw_moneyrecord',$where." and amount>0");
    echo $yjData["zong"];
	?></td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right"> 学员信息来路：</td>
    <td>
	老学员：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="老学员" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="老学员" and lang="'.$Lang.'"';
	}
	$bdData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $bdData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;会员：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="其他搜索引擎" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="会员" and lang="'.$Lang.'"';
	}
	$qtssData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $qtssData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;报纸：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="报纸" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="报纸" and lang="'.$Lang.'"';
	}
	$yqljData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $yqljData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;假订单：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="假订单" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="假订单" and lang="'.$Lang.'"';
	}
	$pyjsData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $pyjsData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;百度：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="百度" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="百度" and lang="'.$Lang.'"';
	}
	$ltData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $ltData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;其他搜索引擎：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="其他搜索引擎" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="其他搜索引擎" and lang="'.$Lang.'"';
	}
	$dxData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $dxData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;传单：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="传单" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="传单" and lang="'.$Lang.'"';
	}
	$yjData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $yjData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;朋友介绍：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="朋友介绍" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="朋友介绍" and lang="'.$Lang.'"';
	}
	$jzwData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $jzwData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;论坛：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="论坛" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="论坛" and lang="'.$Lang.'"';
	}
	$rcwData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $rcwData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;短信：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xyxxly="短信" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xyxxly="短信" and lang="'.$Lang.'"';
	}
	$cdData = $bw->selectOnly('count(id) as zong' ,'bw_qjj',$where);
    echo $cdData["zong"];
	?>
&nbsp;</td>
  </tr>
</table>
<br>
<table width="96%" border="0" cellspacing="0" cellpadding="0">
  <tr class="showtr">
    <td width="10%" align="right"><font color="#FF0000">总收入：</font></td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'amount<0 and acontent<>5 and acontent<>1 and lang="'.$Lang.'"';
	  if($_SESSION['username']=="admin")
  	  {
		  if(!empty($_POST['ywname']))
		  {
			$where = $where . " and username= '".$_POST['ywname']."' ";
		  }
	  }else{
	        $where = $where . " and username= '".$_SESSION['username']."' ";
	  }
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	     if($_POST['stime']==$_POST['etime'])
		 {
		 $stime=$_POST['stime'];
		 $tri=substr($_POST['stime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['stime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$stime."' and addtime <='".$etime."')";
		 }else{
		 $etime=$_POST['etime'];
		 $tri=substr($_POST['etime'],-1);
		 $tri=$tri+1;
		 $etime=substr($_POST['etime'],0,-1).$tri;
		    $where = $where . " and (addtime >='".$_POST['stime']."' and addtime <='".$etime."')";
		 }
	  }else{
	  $where =  $where." and addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'amount<0 and acontent<>5 and acontent<>1 and lang="'.$Lang.'"';
	}
	$sumData = $bw->selectOnly('sum(amount) as zong' ,'bw_moneyrecord',$where);
    echo $sumData["zong"]*"-1";
	?>
	</td>
  </tr>
</table>
</body>
</html>