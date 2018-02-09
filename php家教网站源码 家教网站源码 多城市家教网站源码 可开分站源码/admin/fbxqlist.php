<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherefbxq']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>需求信息列表</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="fbxqlist.php?page="+thisPage.val();
		});//end page_SEL 		
	});
</script>
<style type="text/css">
.ab{color:red;}
</style>
</head>

<body>
<?php
//删除数据
$action = $_GET['action'];
//删除单条数据
if($action == 'delete')
{
	if($bw->delete('bw_yhxq', 'id = '.$_GET['id']))
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
	$id = implode(',', $_POST['id']);
	if($bw->delete('bw_yhxq', "id IN (".$id.")"))
	{
		$bw->msg('删除成功!');	
	}else{
		$bw->msg('删除失败!');	
	}
}

//处理显示隐藏
if($action == 'isshow')
{
	//update($tbName, $post, $where)
	$post = array();
	if($_GET['isshow']==1)
	{
	 	$post['isshow'] = 2;
	}else{
		$post['isshow'] = 1;	
	}
	if($bw->update('bw_yhxq', $post, 'id = '.$_GET['id']))
	{
		$bw->msg('操作成功!', 'fbxqlist.php');	
	}else{
		$bw->msg('操作失败!', 'fbxqlist.php');	
	}	
}
?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>关键字:<input name="keyword" id="keyword" />&nbsp;<select name="isshow" id="isshow"><option value="">是否处理</option><option value="1">是</option><option value="2">否</option></select>&nbsp;<input type="submit" value="搜索" /></td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trTitle">
    <td width="51" align="center"><strong>ID</strong></td>
    <td width="112" align="center"><strong>发布人姓名</strong></td>
    <td width="103" align="center"><strong>会员用户名</strong></td>
    <td width="193" align="center"><strong>联系QQ</strong></td>
    <td width="161" align="center"><strong>个人联系电话</strong></td>
    <td width="180" align="center"><strong>邮件地址</strong></td>
    <td width="187" align="center"><strong>提交时间</strong></td>
    <td width="189" align="center"><strong>是否处理</strong></td>
    <td width="105" align="center"><strong>操作</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_yhxq";
  $where    = '';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['keyword']) && !empty($_POST['isshow']))
	  {
		$where = "name LIKE '%".$_POST['keyword']."%' OR necheng LIKE '%".$_POST['keyword']."%' AND isshow = ".$_POST['isshow'];
		$_SESSION['wherefbxq'] = $where;
	  }else if(!empty($_POST['isshow'])){
		$where = "isshow = ".$_POST['isshow'];
		$_SESSION['wherefbxq'] = $where;
	  }else if(!empty($_POST['keyword'])){
		$where = "name LIKE '%".$_POST['keyword']."%' OR necheng LIKE '%".$_POST['keyword']."%'";  
		$_SESSION['wherefbxq'] = $where;
	  }
  }
  //echo $_SESSION['wherefbxq'];
  $list = $bw->selectPage("*",$tbName,$_SESSION['wherefbxq'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wherefbxq'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
  <tr class="showtr">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
    <td align="center"><?php echo $list[$i]['necheng']; ?></td>
    <td align="center"><?php echo $list[$i]['username']; ?></td>
    <td align="center"><?php echo $list[$i]['qq']; ?></td>
    <td align="center"><?php echo $list[$i]['telphone']; ?></td>
    <td align="center"><?php echo $list[$i]['email'];?></td>
    <td align="center"><?php echo $list[$i]['subTime'];?></td>
    <td align="center"><?php if($list[$i]['isshow'] == 1){echo '是'; }else{echo "<span style='color:red'>否</span>";} ?></td>
    <td align="center"><a href="?id=<?php echo $list[$i]['id']; ?>&action=isshow&isshow=<?php echo $list[$i]['isshow']; ?>"><img src="images/pen.gif" alt="点击显示或隐藏" /></a>&nbsp;&nbsp;<a href="?action=delete&id=<?php echo $list[$i]['id']; ?>"><img src="images/delete.gif" /></a></td>
  </tr>
  <tr class="hidetr">
  <td colspan="9" style="padding-left:50px;">
  <?php if(!empty($list[$i]['address'])){ echo '<span class=ab>联系地址:</span>'.$list[$i]['address'].'<br />';} ?>
  <?php if(!empty($list[$i]['title'])){ echo '<span class=ab>需求标题:</span>'.$list[$i]['title'].'<br />';} ?>
  <?php if(!empty($list[$i]['information'])){ echo '<span class=ab>需求内容:</span>'.$list[$i]['information'].'<br />';} ?>
  </td>
  </tr>
<?php
	}//end loop
?>
  <tr>
  	<td colspan="9" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;<input type="submit" value="删除所选" id="deleteSelect" /></td>
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
</table>

    </td>
  </tr>
</form>
</table>

</body>
</html>