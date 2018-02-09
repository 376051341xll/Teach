<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	$diaoquData = $bw->selectOnly('*', 'bw_config', "lang='".$_SESSION["Lang_session"]."'", '');
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']);
		if( $_GET['act']=="k")
	{
		$_SESSION['whereorderlist3']="";
		} 
	htqx("7.1");
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
		location.href="jyorderlist3.php?page="+thisPage.val();
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
htqx("7.4");
	if($bw->delete('bw_order', 'id = '.$_GET['id']))
	{
		$bw->msg('删除成功!');	
	}else{
		$bw->msg('删除失败!');	
	}
}
//删除多条数据
if(!empty($_POST['deleteSelect']))
{
htqx("7.4");
	//print_r($_POST);
	if(isset($_POST['id']))
	{
		$id = implode(',', $_POST['id']);
		
		//deleteSelect shsyBtn qxshBtn
		if(!empty($_POST['deleteSelect']))
		{
			if($bw->delete('bw_order', "id IN (".$id.")"))
			{
				$bw->msg('删除成功!');	
			}else{
				$bw->msg('删除失败!');	
			}
		}
	}
}	

if(!empty($_POST['shsyBtn']))
	{
	htqx("7.3");
		unset($_POST['shsyBtn']);
		unset($_POST['page_SEL']);
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
				$sql = "UPDATE bw_order SET yyqk = {$_POST['yyqk'][$i]} WHERE id = {$_POST['id'][$i]}";
				$bw->query($sql);
			//echo $sql."<br>";
			}
		}
		//die();
			$bw->msg('预约情况修改成功!');
	}

if(!empty($_POST['shsyBtns']))
	{
	htqx("7.3");
		unset($_POST['shsyBtns']);
		unset($_POST['page_SEL']);
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
			//die($_POST['xxf'][$i]);
				$sql = "UPDATE bw_order SET ddzt = {$_POST['ddzt'][$i]} WHERE id = {$_POST['id'][$i]}";
				$bw->query($sql);
			//echo $sql."<br>";
			}
		}
		
			$bw->msg('设置成功!');
	}
?>	
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>学员编号:<input name="ddbh" id="ddbh" size="10" />&nbsp;学员电话:<input name="tel" id="tel" size="10" />&nbsp;
订单状态:<select name="ddzt">
	<option selected="selected" value="">--所有--</option>
	<option value="2">成功</option>
	<option value="3">失败</option>
</select>
&nbsp;<input type="submit" value="搜索" />
</td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trusername">
    <td width="5%" align="center"><strong>ID</strong></td>
    <td width="10%" align="center"><strong>学员编号</strong></td>
    <td width="10%" align="center"><strong>联系人</strong></td>
    <td width="10%" align="center"><strong>学员性别</strong></td>
    <td width="10%" align="center"><strong>求教学科</strong></td>
    <td width="10%" align="center"><strong>教员编号</strong></td>
	<td width="10%" align="center"><strong>教员姓名</strong></td>
	<td width="10%" align="center"><strong>授课科目</strong></td>
    <td width="10%" align="center"><strong>状态</strong></td>
    <td width="10%" align="center"><strong>订单处理时间</strong></td>
    <td width="5%" align="center"><strong>操作</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_order";
  $where    = '(ddzt=2 or ddzt=3)  and lang="'.$Lang.'" ';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['ddbh']))
	  {
		$where =$where." and xyid LIKE '%".$_POST['ddbh']."%'";
		$_SESSION['whereorderlist3'] = $where;
	  }
	  if(!empty($_POST['tel']))
	  {
		$where =$where." and xyid in( select id from bw_qjj where tel LIKE '%".$_POST['tel']."%')";
		$_SESSION['whereorderlist3'] = $where;
	  }
//	  if(!empty($_POST['qjkm']))
//	  {
//		$where =$where." and qjkm LIKE '%".$_POST['qjkm']."%'";
//		$_SESSION['whereorderlist3'] = $where;
//	  }
//	  if(!empty($_POST['szqy']))
//	  {
//		$where =$where." and szqy LIKE '%".$_POST['szqy']."%'";
//		$_SESSION['whereorderlist3'] = $where;
//	  }
//	  if(!empty($_POST['xynj']))
//	  {
//		$where =$where." and xynj LIKE '%".$_POST['xynj']."%'";
//		$_SESSION['whereorderlist3'] = $where;
//	  }
	  if(!empty($_POST['ddzt']))
	  {
		$where =$where." and ddzt = '".$_POST['ddzt']."'";
		$_SESSION['whereorderlist3'] = $where;
	  }
  }
  if($_SESSION['whereorderlist3']==""){
	    $_SESSION['whereorderlist3']=$where;
  }
  //die($_SESSION['whereorderlist3']);
  $list = $bw->selectPage("*",$tbName, $_SESSION['whereorderlist3'],"`cltime` DESC, id desc",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['whereorderlist3'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
  $xyData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$list[$i]['xyid']);
  $jyData = $bw->selectOnly('*' ,'bw_member', 'id = '.$list[$i]['jyid']);
?>
 <tr class="showtr">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
    <td align="center"><a href="xyadd.php?id=<?php echo $xyData['id'];?>"><?php echo $xyData['id']; ?></a></td>
    <td align="center"><a href="xyadd.php?id=<?php echo $xyData['id'];?>"><?php echo $xyData['name']; ?></a></td>
    <td align="center"><?php echo $xyData['xysex']; ?></td>
    <td align="center"><a href="#" title="<?php echo $xyData['qjkm']; ?>">【<?php echo $xyData['qjkm']; ?>】</a></td>
    <td align="center"><a href="membermod.php?id=<?php echo $jyData['id'];?>"><?php echo $jyData['id']; ?></a></td>
    <td align="center"><a href="membermod.php?id=<?php echo $jyData['id'];?>"><?php echo $jyData['truename']; ?></a></td>
	<td align="center"><a href="#" title="<?php echo $jyData['kjskm']; ?>">【<?php echo $jyData['kjskm']; ?>】</a></td>
    <td align="center">
	<?php if($list[$i]['ddzt']==2){echo "<font color='#0066CC'>订单成功</font>";}?>
	<?php if($list[$i]['ddzt']==3){echo "<font color='#333333'>订单失败</font>";}?>
	</td>
    <td align="center"><?php echo date("Y-m-d",strtotime($list[$i]['cltime']));?></td>
    <td align="center"><a href="jyorderlist3show.php?id=<?php echo $list[$i]['id']?>"><img src="images/pen.gif" alt="查看信息" title="查看信息" /></a>&nbsp;&nbsp;<a href="###" onclick="javascript:if(confirm('是否删除')){window.location.href='?action=delete&id=<?php echo $list[$i]['id']; ?>'}"><img src="images/delete.gif" /></a></td>
  </tr>
<?php
	}//end loop
?>
  <tr>
  	<td colspan="11" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    	  <tr>
    	    <td><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;<input type="submit" value="删除所选" name="deleteSelect" id="deleteSelect" />&nbsp;<input type="submit" value="更改预约情况" name="shsyBtn" id="shsyBtn" />&nbsp;<input type="submit" value="更改订单状态" name="shsyBtns" id="shsyBtns" /></td>
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