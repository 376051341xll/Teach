<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['whereadmin']);
	if( $_GET['act']=="k")
	{
		$_SESSION['whereadmin']="";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告信息列表</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="adlist.php?page="+thisPage.val();
		});//end page_SEL
	});
</script>
</head>

<body>
<?php
//删除数据
htqx("1.1");
$action = $_GET['action'];
//删除单条数据
if($action == 'delete')
{
htqx("1.5");
$unameData = $bw->selectOnly('username', 'bw_user', 'id = '.$_GET['id'], '');
	if($unameData["username"]==$_SESSION['username'])
	{
		echo "<script>alert('请勿非法操作！');history.go(-1);</script>";
		exit;
	}
	if($bw->delete('bw_user', 'id = '.$_GET['id']))
	{
		$bw->msg('删除成功!');	
	}else{
		$bw->msg('删除失败!');	
	}
}
//删除多条数据
?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>用户名:
  <input name="keyword" id="keyword" />&nbsp;&nbsp;<input type="submit" value="搜索" /></td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trTitle">
    <td width="5%" align="center"><strong>ID</strong></td>
    <td width="25%" align="center"><strong>账号</strong></td>
    <td width="25%" align="center"><strong>部门</strong></td>
    <td width="12%" align="center"><strong>上级管理员</strong></td>
    <td width="13%" align="center"><strong>所属站点</strong></td>
    <td width="10%" align="center"><strong>操作</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_user";
  $where    = 'id not in(1)';
  //搜索
	  if($_SESSION['username']!="admin")
	  {
	$parentname = $bw->selectOnly('bumen', 'bw_user',"username='".$_SESSION['username']."'", '');
		$where =$where. " and bumen='".$parentname["bumen"]."'";  
		$_SESSION['whereadmin'] = $where;  
	  }
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['keyword']))
	  {
		$where =$where. " and username LIKE '%".$_POST['keyword']."%'";  
		$_SESSION['whereadmin'] = $where;
	  }
  }
  $list = $bw->selectPage("*",$tbName,$_SESSION['whereadmin'],"`id` ASC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['whereadmin'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
  <tr>
    <td align="center"><!--<input type="checkbox" name="id[]" id="id[]" value="< ?php echo $list[$i]['id']; ?>" />--><?php echo $list[$i]['id']; ?></td>
    <td align="center"><?php echo $list[$i]['username']; ?></td>
    <td align="center"><?php echo $list[$i]['bumen']; ?></td>
    <td align="center"><?php
	if(!empty($list[$i]['parentid']))
	{
	 $parentname = $bw->selectOnly('username', 'bw_user',"id=".$list[$i]['parentid'], '');
	 echo $parentname["username"];
	}else{
	 echo "超级管理员";
	}
	?></td>
    <td align="center"><?php if($list[$i]['username']=="admin"){echo "全站";}else{echo $list[$i]['lang'];} ?></td>
    <td align="center"><a href="adminsq.php?id=<?php echo $list[$i]['id']; ?>"><img src="Images/qx.png" alt="授权" width="22" height="16" border="0"></a>&nbsp;&nbsp;<a href="adadmin.php?id=<?php echo $list[$i]['id']; ?>"><img src="images/pen.gif" /></a>&nbsp;&nbsp;<?php
    if($list[$i]['id']!=1)
	{
	?><a href="javascript:if(confirm('确定要删除？')){window.location.href='?action=delete&id=<?php echo $list[$i]['id']; ?>'}"><img src="images/delete.gif" /></a><?php
	}
	?></td>
  </tr>
<?php
	}//end loop
?>
  <tr>
  	<td colspan="6" align="center">   <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="?page=1">第一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
				跳到
				<select name="page_SEL" id="page_SEL">
						<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="<?php echo $goPage; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
			  </select></td>
  </tr>
</table>
</td>
  </tr>
</form>
</table>

</body>
</html>