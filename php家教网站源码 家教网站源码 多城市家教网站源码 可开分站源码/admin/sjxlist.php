<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	htqx("13_1");
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
		location.href="baselist.php?page="+thisPage.val();
		});//end page_SEL 		
	});
</script>
<script type="text/javascript">
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
</head>

<body>
<?php
//删除数据
$action = $_GET['action'];
//删除单条数据
if($action == 'delete')
{
htqx("13_4");
	if($bw->delete('bw_zxwd', 'id = '.$_GET['id']))
	{
		$bw->msg('删除成功!');	
	}else{
		$bw->msg('删除失败!');	
	}
}
//删除多条数据
if($action == 'deleteFrom')
{
htqx("13_4");
	//print_r($_POST);
	$id = implode(',', $_POST['id']);
	if($bw->delete('bw_zxwd', "id IN (".$id.")"))
	{
		$bw->msg('删除成功!');	
	}else{
		$bw->msg('删除失败!');	
	}
}
?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>关键字:<input name="keyword" id="keyword" />&nbsp;
&nbsp;<input type="submit" value="搜索" /></td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trTitle">
    <td width="51" align="center"><strong>ID</strong></td>
    <td width="250" align="center"><strong>发件人</strong></td>
    <td width="200" align="center"><strong>信息类型</strong></td>
    <td width="300" align="center"><strong>标题</strong></td>
    <td width="300" align="center"><strong>时间</strong></td>
    <td width="105" align="center"><strong>操作</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_zxwd";
  $where    = 'lang="'.$Lang.'" ';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['keyword']) && !empty($_POST['classId']))
	  {
		$where = " and title LIKE '%".$_POST['keyword']."%' AND classId = ".$_POST['classId'];
		$_SESSION['wheresjx'] = $where;
	  }else if(!empty($_POST['classId'])){
		$where = " and classId = ".$_POST['classId'];
		$_SESSION['wheresjx'] = $where;
	  }else{
		$where = " and title LIKE '%".$_POST['keyword']."%'";  
		$_SESSION['wheresjx'] = $where;
	  }
  }
  $_SESSION['wheresjx'] = $where;
  $list = $bw->selectPage("*",$tbName,$_SESSION['wheresjx'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wheresjx'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
  <tr>
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
    <td align="center"><a href="#" onclick="yinc('a<?php echo $list[$i]['id'];?>')"><?php echo $list[$i]['username']; ?></a></td>
    <td align="center"><a href="#" onclick="yinc('a<?php echo $list[$i]['id'];?>')"><?php if($list[$i]['xxlx']==1){echo "单条信息";}else{echo "群发信息";} ?></a></td>
    <td align="center"><a href="#" onclick="yinc('a<?php echo $list[$i]['id'];?>')"><?php echo $list[$i]['title']; ?></a></td>
    <td align="center"><?php echo $list[$i]['addtime']; ?></td>
    <td align="center"><a href="fxadd.php?id=<?php echo $list[$i]['id']; ?>"><img src="images/pen.gif" /></a>&nbsp;&nbsp;<a href="?action=delete&id=<?php echo $list[$i]['id']; ?>"><img src="images/delete.gif" /></a></td>
  </tr>
  <tr id="a<?php echo $list[$i]['id'];?>" style="display:none;" class="trTitle">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
    <td align="center"><strong>内容</strong></td>
    <td colspan="4" align="left"><?php echo $list[$i]['content']; ?></td>
    </tr>
<?php
	}//end loop
?>
  <tr>
  	<td colspan="6" align="center">
    	<div class="pageDiv">
        	<div class="pageLeft"><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;<input type="submit" value="删除所选" id="deleteSelect" /></div>
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
        </div>    </td>
  </tr>
</form>
</table>

</body>
</html>