<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['whereuserprolist']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>产品信息列表</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="userprolist.php?page="+thisPage.val();
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
	if($bw->delete('bw_userproduct', 'id = '.$_GET['id']))
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
		if($bw->delete('bw_userproduct', "id IN (".$id.")"))
		{
			$bw->msg('删除成功!');	
		}else{
			$bw->msg('删除失败!');	
		}
	}
	
	if(!empty($_POST['shsyBtn']))
	{
		$sql = "UPDATE bw_userproduct SET isshow = 1 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('审核成功!');	
		}else{
			$bw->msg('审核失败!');	
		}
	}
	if(!empty($_POST['qxshBtn']))
	{
		$sql = "UPDATE bw_userproduct SET isshow = 2 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('取消审核成功!');	
		}else{
			$bw->msg('取消审核失败!');	
		}
	}
	
	if(!empty($_POST['xpBtn']))
	{
		$sql = "UPDATE bw_userproduct SET isnew = 2 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('新品推荐成功!');	
		}else{
			$bw->msg('新品推荐失败!');	
		}
	}
	if(!empty($_POST['qxxpBtn']))
	{
		$sql = "UPDATE bw_userproduct SET isnew = 1 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('取消新品成功!');	
		}else{
			$bw->msg('取消新品失败!');	
		}
	}
	//qxjptjBtn  jptjBtn
	if(!empty($_POST['jptjBtn']))
	{
		$sql = "UPDATE bw_userproduct SET isindex = 1 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('加入精品推荐成功!');	
		}else{
			$bw->msg('加入精品推荐失败!');	
		}
	}
	
	if(!empty($_POST['qxjptjBtn']))
	{
		$sql = "UPDATE bw_userproduct SET isindex = 2 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('取消精品推荐成功!');	
		}else{
			$bw->msg('取消精品推荐失败!');	
		}
	}
}

//处理
if($action == 'chuli')
{
	//print_r($_POST);
	if($_GET['isshow'] == 1)
	{
		$sql = "UPDATE bw_userproduct SET isshow = 2 WHERE id = ".$_GET['id'];
	}else{
		$sql = "UPDATE bw_userproduct SET isshow = 1 WHERE id = ".$_GET['id'];
	}
	if($bw->query($sql))
	{
		$bw->msg('处理成功!', 'userprolist.php');	
	}else{
		$bw->msg('处理失败!', 'userprolist.php');	
	}
}
?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>用户名/产品名称:<input name="keyword" id="keyword" />&nbsp;
  <select name="isshow" id="isshow">
  <option value="">是否处理</option>
    <option value="1">是</option>
    <option value="2">否</option>
  </select>
  &nbsp;
  <select name="isindex" id="isindex">
    <option value="1">已推荐</option>
    <option value="2">未推荐</option>
  </select>
  <select name="isnew" id="isnew">
    <option value="">是否新品</option>
    <option value="2">是</option>
    <option value="1">否</option>
  </select>
  &nbsp;
  <input type="submit" value="搜索" /></td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trTitle">
    <td width="51" align="center"><strong>ID</strong></td>
    <td width="193" align="center"><strong>产品名称</strong></td>
    <td width="371" align="center"><strong>产品图片</strong></td>
    <td width="192" align="center"><strong>发布人用户名</strong></td>
    <td width="174" align="center"><strong>加入时间</strong></td>
    <td width="97" align="center"><strong>是否处理</strong></td>
    <td width="98" align="center"><strong>是否新品</strong></td>
    <td width="98" align="center"><strong>推荐到首页</strong></td>
    <td width="105" align="center"><strong>操作</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_userproduct";
  $where    = '';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
		$where = "1=1";
	  if(!empty($_POST['keyword']))
	  {
		$where = " and (name LIKE '%".$_POST['keyword']."%' OR username LIKE '%".$_POST['keyword']."%')";
	  }
	  if(!empty($_POST['isshow']))
	  {
		$where .= " and isshow = ".$_POST['isshow'];
	  }
	  if(!empty($_POST['isindex']))
	  {
		$where .= " and isindex = ".$_POST['isindex'];
	  }
	  if(!empty($_POST['isnew']))
	  {
		$where .= " and isnew = ".$_POST['isnew'];
	  }
	 // die($where);
		$_SESSION['whereuserprolist'] = $where;
  }
  $list = $bw->selectPage("*",$tbName,$_SESSION['whereuserprolist'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['whereuserprolist'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
 <tr class="showtr">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
    <td align="center"><?php echo $list[$i]['name']; ?></td>
    <td align="center"><img src="<?php echo '../'.$list[$i]['pic']; ?>" width="110" height="70" /></td>
    <td align="center"><?php echo $list[$i]['username']; ?></td>
    <td align="center"><?php echo $list[$i]['subTime']; ?></td>
    <td align="center"><?php if($list[$i]['isshow'] == 1){echo '是'; }else{ echo "<span style='color:red'>否</span>";} ?></td>
    <td align="center"><?php if($list[$i]['isnew'] == 2){echo '是'; }else{ echo "<span style='color:red'>否</span>";} ?></td>
    <td align="center"><?php if($list[$i]['isindex'] == 1){echo "<span style='color:green;'>已推荐</span>"; }else{ echo "<span style='color:red'>未推荐</span>";} ?></td>
    <td align="center"><a href="?action=chuli&id=<?php echo $list[$i]['id']?>&isshow=<?php echo $list[$i]['isshow']; ?>"><img src="images/pen.gif" /></a>&nbsp;&nbsp;<a href="?action=delete&id=<?php echo $list[$i]['id']; ?>"><img src="images/delete.gif" /></a></td>
  </tr>
  <tr class="hidetr">
  <td colspan="12" style="padding-left:50px;">
  <?php if(!empty($list[$i]['information'])){ echo '<span style=color:red>产品描述:</span>'.$list[$i]['information'].'<br />';} ?>
  </td>
  </tr>
<?php
	}//end loop
?>
  <tr>
  	<td colspan="9" align="center">
    	<div class="pageDiv">
        	<div class="pageLeft" style="width:590px; padding:0px;"><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;<input type="submit" value="审核所选" name="shsyBtn" id="shsyBtn" />&nbsp;<input type="submit" value="取消审核" name="qxshBtn" id="qxshBtn" />&nbsp;<input type="submit" value="新品" name="xpBtn" id="xpBtn" />&nbsp;<input type="submit" value="取消新品" name="qxxpBtn" id="qxxpBtn" />&nbsp;<input type="submit" value="首页推荐" name="jptjBtn" id="jptjBtn" />&nbsp;<input type="submit" value="取消推荐" name="qxjptjBtn" id="qxjptjBtn" />&nbsp;<input type="submit" value="删除所选" name="deleteSelect" id="deleteSelect" /></div>
            <div class="pageRight" style="width:460px; padding:0px; margin:0;">
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