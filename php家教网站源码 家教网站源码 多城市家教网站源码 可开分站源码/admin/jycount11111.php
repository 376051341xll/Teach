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
<?php
//删除数据
$action = $_GET['action'];
//删除单条数据
if($action == 'delete')
{
	if($bw->delete('bw_jifen', 'id = '.$_GET['id']))
	{
		$bw->msg('删除成功!');	
	}else{
		$bw->msg('删除失败!');	
	}
}
//删除多条数据
if($action == 'deleteFrom')
{
	//print_r($_POST);
	if(isset($_POST['id']))
	{
		$id = implode(',', $_POST['id']);
		
		//deleteSelect shsyBtn qxshBtn
		if(!empty($_POST['deleteSelect']))
		{
			if($bw->delete('bw_moneyrecord', "id IN (".$id.")"))
			{
				$bw->msg('删除成功!');	
			}else{
				$bw->msg('删除失败!');	
			}
		}
	}
	
	
	
}

?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>时间:
  <input name="stime" type=text id=text1 style="width:80px;" onfocus="showCalendar(this)" readonly> 
  <input name="etime" type=text id=text1 style="width:80px;" onfocus="showCalendar(this)" readonly>
  <input type="submit" value="搜索" /></td>
</form>
</tr>
</table>
<table width="96%" border="0" cellspacing="0" cellpadding="0">
  <tr class="showtr">
    <td width="10%" height="25" align="right">注册教员数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = "lang='".$Lang."'";
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'lang="'.$Lang.'"';
	}
	//die($where);
	$zcData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $zcData["zong"];
	?></td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">认证教员数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'ifrz=2 and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'ifrz=2 and lang="'.$Lang.'"';
	}
	$rzData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $rzData["zong"];
	?>
	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">发布教员数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'iffb=2 and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'iffb=2 and lang="'.$Lang.'"';
	}
	$fbData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $fbData["zong"];
	?>
	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">审核教员数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'shqk=1 and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'shqk=1 and lang="'.$Lang.'"';
	}
	$shData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $shData["zong"];
	?>
	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">审核大学生数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'levels=1 and shqk=1 and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'levels=1 and shqk=1 and lang="'.$Lang.'"';
	}
	$shdxsData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $shdxsData["zong"];
	?>
	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">审核教师数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'levels=2 and shqk=1 and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'levels=2 and shqk=1 and lang="'.$Lang.'"';
	}
	$shjsData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $shjsData["zong"];
	?>
	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">审核留学生数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'levels=3 and shqk=1 and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'levels=3 and shqk=1 and lang="'.$Lang.'"';
	}
	$shlxsData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $shlxsData["zong"];
	?>
	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right">审核其他数：</td>
    <td>
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'levels=3 and shqk=1 and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'levels=4 and shqk=1 and lang="'.$Lang.'"';
	}
	$shqtData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $shqtData["zong"];
	?>
	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right"> 教员信息来路：</td>
    <td>
	百度：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="百度" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="百度" and lang="'.$Lang.'"';
	}
	$bdData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $bdData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;其他搜索引擎：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="其他搜索引擎" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="其他搜索引擎" and lang="'.$Lang.'"';
	}
	$qtssData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $qtssData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;友情链接：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="友情链接" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="友情链接" and lang="'.$Lang.'"';
	}
	$yqljData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $yqljData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;朋友介绍：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="朋友介绍" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="朋友介绍" and lang="'.$Lang.'"';
	}
	$pyjsData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $pyjsData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;论坛：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="论坛" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="论坛" and lang="'.$Lang.'"';
	}
	$ltData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $ltData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;短信：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="短信" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="短信" and lang="'.$Lang.'"';
	}
	$dxData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $dxData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮件：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="邮件" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="邮件" and lang="'.$Lang.'"';
	}
	$yjData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $yjData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;兼职网：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="兼职网" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="兼职网" and lang="'.$Lang.'"';
	}
	$jzwData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $jzwData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人才网：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="人才网" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="人才网" and lang="'.$Lang.'"';
	}
	$rcwData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $rcwData["zong"];
	?>
	</td>
  </tr>
  <tr class="showtr">
    <td height="25" align="right"> </td>
    <td>
	传单：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="传单" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="传单" and lang="'.$Lang.'"';
	}
	$cdData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $cdData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;厦门百姓网：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="厦门百姓网" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="厦门百姓网" and lang="'.$Lang.'"';
	}
	$bxwData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $bxwData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;其他：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="其他" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="其他" and lang="'.$Lang.'"';
	}
	$qtData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $qtData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;小鱼网：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="小鱼网" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="小鱼网" and lang="'.$Lang.'"';
	}
	$xywData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $xywData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;宣传单：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="宣传单" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="宣传单" and lang="'.$Lang.'"';
	}
	$xcdData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $xcdData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;面试：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="面试" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="面试" and lang="'.$Lang.'"';
	}
	$msData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $msData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学院勤工：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="学院勤工" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="学院勤工" and lang="'.$Lang.'"';
	}
	$xyqgData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $xyqgData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;网站维护：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="网站维护" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="网站维护" and lang="'.$Lang.'"';
	}
	$wzwhData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $wzwhData["zong"];
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;58同城：
	<?php
	if(!empty($_GET['action']) && $_GET['action'] == 'search')
    {
	  $where = 'xxly="58同城" and lang="'.$Lang.'"';
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and reg_time >'".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." reg_time >='".$_POST['stime']."' and reg_time <='".$_POST['etime']."'";
	  }
	  }
    }else{
	$where = 'xxly="58同城" and lang="'.$Lang.'"';
	}
	$tcData = $bw->selectOnly('count(id) as zong' ,'bw_member',$where);
    echo $tcData["zong"];
	?>
	</td>
  </tr>
</table>
</body>
</html>