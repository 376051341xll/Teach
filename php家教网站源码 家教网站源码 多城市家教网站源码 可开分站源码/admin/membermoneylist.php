<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']);
		if( $_GET['act']=="k")
	{
		$_SESSION['wherejflist']="";
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
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="membermoneylist.php?page="+thisPage.val();
		});//end page_SEL 		
	});
</script></head>

<body>
<?php
//删除数据
$action = $_GET['action'];
//删除单条数据
if($action == 'delete')
{
htqx("8.4");
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
htqx("8.4");
	//print_r($_POST);
	if(isset($_POST['id']))
	{
		$id = implode(',', $_POST['id']);
		
		//deleteSelect shsyBtn qxshBtn
		if(!empty($_POST['deleteSelect']))
		{
			if($bw->delete('bw_jifen', "id IN (".$id.")"))
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
<td>关键字:<input name="keyword" id="keyword" />&nbsp;
    <select name="leixing" id="leixing">
     <option value="uid" >教员编号</option>
      <option value="username" >用户名</option>
      <option value="xingming">姓名</option>
    </select> 
  &nbsp;<input type="submit" value="搜索" /></td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trusername">
    <td width="164" align="center"><strong>ID</strong></td>
    <td width="177" align="center"><strong>教员编号</strong></td>
    <td width="200" align="center"><strong>用户名</strong></td>
    <td width="200" align="center"><strong>教员姓名</strong></td>
    <td width="300" align="center"><strong>帐号余额</strong></td>
    <td width="150" align="center"><strong>操作</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_member";
  $where    = 'lang="'.$Lang.'" ';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['keyword']) && !empty($_POST['leixing']))
	  {
		if($_POST['leixing']=="username")
		{
		$where = $where." and username LIKE '%".$_POST['keyword']."%'";
		}
		if($_POST['leixing']=="xingming")
		{
		$where = $where." and truename LIKE '%".$_POST['keyword']."%'";
		}
		if($_POST['leixing']=="uid")
		{
		$where = $where." and id ='".$_POST['keyword']."'";
		}
		$_SESSION['wherejflist'] = $where;
	  }
  }
  if($_SESSION['wherejflist']=="")
  {
	  $_SESSION['wherejflist'] = $where;
  }
  //die($_SESSION['wherejflist']);
  $list = $bw->selectPage("*",$tbName,$_SESSION['wherejflist'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wherejflist'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
 <tr class="showtr">
   <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
   <td align="center"><?php echo $list[$i]['id']; ?></td>
   <td align="center"><?php echo $list[$i]['username']; ?></td>
   <td align="center"><?php echo $list[$i]['truename']; ?></td>
   <td align="center"><?php echo $list[$i]['Money']; ?></td>
   <td align="center">&nbsp;&nbsp;<a href="memberRechargelist.php?act=show&id=<?php echo $list[$i]['id']; ?>">查看所有财务清单</a></td>
   </tr>
  <?php
	}//end loop
?>
  <tr>
  	<td colspan="6" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    	  <tr>
    	    <td align="left"><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;&nbsp;<input type="submit" value="删除所选" name="deleteSelect" id="deleteSelect" /></td>
    	    <td align="right">共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp;
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
  	  </table></td>
  </tr>
</form>
</table>

</body>
</html>