<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['whereusernewslist']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目信息列表</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="usernewslist.php?page="+thisPage.val();
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
	if($bw->delete('bw_usernews', 'id = '.$_GET['id']))
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
	
	//deleteSelect shsyBtn qxshBtn
	if(!empty($_POST['deleteSelect']))
	{
		if($bw->delete('bw_usernews', "id IN (".$id.")"))
		{
			$bw->msg('删除成功!');	
		}else{
			$bw->msg('删除失败!');	
		}
	}
	
	if(!empty($_POST['shsyBtn']))
	{
		$sql = "UPDATE bw_usernews SET isshow = 1 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('审核成功!');	
		}else{
			$bw->msg('审核失败!');	
		}
	}
	
	if(!empty($_POST['qxshBtn']))
	{
		$sql = "UPDATE bw_usernews SET isshow = 2 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('取消审核成功!');	
		}else{
			$bw->msg('取消审核失败!');	
		}
	}
}

//处理
if($action == 'chuli')
{
	//print_r($_POST);
	if($_GET['isshow'] == 1)
	{
		$sql = "UPDATE bw_usernews SET isshow = 2 WHERE id = ".$_GET['id'];
	}else{
		$sql = "UPDATE bw_usernews SET isshow = 1 WHERE id = ".$_GET['id'];
	}
	if($bw->query($sql))
	{
		$bw->msg('处理成功!', 'usernewslist.php');	
	}else{
		$bw->msg('处理失败!', 'usernewslist.php');	
	}
}
?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>关键字:<input name="keyword" id="keyword" />&nbsp;
  <select name="isshow" id="isshow">
  <option value="">是否处理</option>
    <option value="1">是</option>
    <option value="2">否</option>
  </select>
  &nbsp;<input type="submit" value="搜索" /></td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trTitle">
    <td width="51" align="center"><strong>ID</strong></td>
    <td width="331" align="center"><strong>标题</strong></td>
    <td width="331" align="center"><strong>发布人用户名</strong></td>
    <td width="187" align="center"><strong>加入时间</strong></td>
    <td width="276" align="center"><strong>是否处理</strong></td>
    <td width="105" align="center"><strong>操作</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_usernews";
  $where    = '';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['keyword']) && !empty($_POST['isshow']))
	  {
		$where = "title LIKE '%".$_POST['keyword']."%' AND isshow = ".$_POST['isshow'];
		$_SESSION['whereusernewslist'] = $where;
	  }else if(!empty($_POST['isshow'])){
		$where = "isshow = ".$_POST['isshow'];
		$_SESSION['whereusernewslist'] = $where;
	  }else{
		$where = "title LIKE '%".$_POST['keyword']."%'";  
		$_SESSION['whereusernewslist'] = $where;
	  }
  }
  $list = $bw->selectPage("*",$tbName,$_SESSION['whereusernewslist'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['whereusernewslist'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
 <tr class="showtr">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
    <td align="center"><?php echo $list[$i]['title']; ?></td>
    <td align="center"><?php echo $list[$i]['username']; ?></td>
    <td align="center"><?php echo $list[$i]['subTime']; ?></td>
    <td align="center"><?php if($list[$i]['isshow'] == 1){echo '是'; }else{ echo "<span style='color:red'>否</span>";} ?></td>
    <td align="center"><a href="?action=chuli&id=<?php echo $list[$i]['id']?>&isshow=<?php echo $list[$i]['isshow']; ?>"><img src="images/pen.gif" /></a>&nbsp;&nbsp;<a href="?action=delete&id=<?php echo $list[$i]['id']; ?>"><img src="images/delete.gif" /></a></td>
  </tr>
  <tr class="hidetr">
  <td colspan="9" style="padding-left:50px;">
  <?php if(!empty($list[$i]['content'])){ echo '<span style=color:red>动态内容:</span>'.$list[$i]['content'].'<br />';} ?>
  </td>
  </tr>
<?php
	}//end loop
?>
  <tr>
  	<td colspan="6" align="center">
    	<div class="pageDiv">
        	<div class="pageLeft"><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;<input type="submit" value="删除所选" name="deleteSelect" id="deleteSelect" />&nbsp;<input type="submit" value="审核所选" name="shsyBtn" id="shsyBtn" />&nbsp;<input type="submit" value="取消审核" name="qxshBtn" id="qxshBtn" /></div>
            <div class="pageRight">
            	共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp;
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
			  </select>
          </div>
        </div>
    </td>
  </tr>
</form>
</table>

</body>
</html>