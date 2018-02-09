<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']);
		if( $_GET['act']=="k")
	{
		$_SESSION['wherejflistz']="";
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
		location.href="memberlist.php?page="+thisPage.val();
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
			if($bw->delete('bw_withdraw', "id IN (".$id.")"))
			{
				$bw->msg('删除成功!');	
			}else{
				$bw->msg('删除失败!');	
			}
		}
		
		//处理情况
	//	if(!empty($_POST['ispass']))
//	    {
//		$sql = "UPDATE bw_withdraw SET ispass = ".$_POST['ispass']." WHERE id IN (".$id.")";
//		if($bw->query($sql))
//		{
//			$bw->msg('设置成功!');	
//		}else{
//			$bw->msg('取消失败!');	
//		}
	}

    if(!empty($_POST['shsyBtns']))
	{
	htqx("8.3");
		unset($_POST['shsyBtns']);
		unset($_POST['page_SEL']);
		$ii= count($_POST['id']);
		
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
//			print_r($_POST['ispass']);
//			exit;
			$aa='ispass'.$_POST['id'][$i];
			//die($_POST[$aa]);
				$sql = "UPDATE bw_withdraw SET ispass = ".$_POST[$aa]." WHERE id = {$_POST['id'][$i]}";
				$bw->query($sql);
			//echo $sql."<br>";
			}
		}
		//die();
			$bw->msg('情况修改成功!');
	}

}
?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>关键字:<input name="keyword" id="keyword" />&nbsp;
   <select name="leixing" id="leixing">
     <option value="uid" >教员编号</option>
      <option value="xingming">姓名</option>
    </select> <select name="sqzt" id="sqzt">
	  <option value="" >申请状态</option>
	  <option value="0" >申请中</option>
	  <option value="1">已受理申请</option>
	  <option value="2">退款成功</option>
	  <option value="3">申请未通过</option>
   </select>
  &nbsp;<input type="submit" value="搜索" /></td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trusername">
    <td width="113" align="center"><strong>ID</strong></td>
    <td width="156" align="center"><strong>教员ID</strong></td>
    <td width="143" align="center"><strong>教员姓名</strong></td>
    <td width="120" align="center"><strong>退款银行</strong></td>
    <td width="148" align="center"><strong>银行账号</strong></td>
    <td width="158" align="center"><strong>申请退款原因</strong></td>
    <td width="72" align="center"><strong>金额</strong></td>
    <td width="105" align="center"><strong>申请时间</strong></td>
    <td width="119" align="center"><strong>处理情况</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_withdraw";
  $where    = 'lang="'.$Lang.'" ';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['keyword']) && !empty($_POST['leixing']))
	  {
		if($_POST['leixing']=="uid")
		{
		$where = $where." and mid ='".$_POST['keyword']."'";
		}
		if($_POST['leixing']=="xingming")
		{
		$where = $where." and huming LIKE '%".$_POST['keyword']."%'";
		}
		if(!empty($_POST['sqzt']))
		{
		$where = $where." and ispass = ".$_POST['sqzt'];
		}
		$_SESSION['wherejflistz'] = $where;
	  }
  }
   if($_SESSION['wherejflistz']=="")
  {
	  $_SESSION['wherejflistz'] = $where;
  }
  //die($_SESSION['wherejflistz']);
  $list = $bw->selectPage("*",$tbName,$_SESSION['wherejflistz'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wherejflistz'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
 <tr class="showtr">
   <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
   <td align="center"><?php  echo $list[$i]['mid'];?></td>
   <td align="center"><?php echo $list[$i]['huming']; ?></td>
   <td align="center"><?php echo $list[$i]['yinh']; ?></td>
   <td align="center"><?php echo $list[$i]['zhanghao']; ?></td>
   <td align="center"><input type="button" value="隐藏或者显示" onclick="javascript:if(getElementById('tk<?php echo $list[$i]['id'];?>').style.display==''){getElementById('tk<?php echo $list[$i]['id'];?>').style.display='none';}else{getElementById('tk<?php echo $list[$i]['id'];?>').style.display=''}" /><div id="tk<?php echo $list[$i]['id'];?>" style="display:none;"><?php echo $list[$i]['reason']; ?></div></td>
   <td align="center"><?php echo $list[$i]['amount']; ?></td>
   <td align="center"><?php echo $list[$i]['addtime']; ?></td>
   <td align="center">&nbsp;&nbsp;
   <?php 
//      switch ($list[$i]['ispass'])
//		{
//		case 0: echo "<a href='?action=edit&id=".$list[$i]['id']."&i=1'>申请中</a>";break;
//		case 1: echo "<a href='?action=edit&id=".$list[$i]['id']."&i=1'>已受理申请</a>";break;
//		case 2: echo "<a href='?action=edit&id=".$list[$i]['id']."&i=1'>退款成功</a>";break;
//		case 3: echo "<a href='?action=edit&id=".$list[$i]['id']."&i=1'>申请未通过</a>";break;
//		}
   ?>
   <select name="ispass<?php echo $list[$i]['id']; ?>" id="ispass">
	  <option value="0" <?php if($list[$i]['ispass']==0){echo "selected='selected'";}?>>申请中</option>
	  <option value="1" <?php if($list[$i]['ispass']==1){echo "selected='selected'";}?>>已受理申请</option>
	  <option value="2" <?php if($list[$i]['ispass']==2){echo "selected='selected'";}?>>退款成功</option>
	  <option value="3" <?php if($list[$i]['ispass']==3){echo "selected='selected'";}?>>申请未通过</option>
   </select>
</td>
 </tr>
  <?php
	}//end loop
?>
  <tr>
  	<td colspan="9" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    	  <tr>
    	    <td><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;&nbsp;<input type="submit" value="删除所选" name="deleteSelect" id="deleteSelect" />&nbsp;<input type="submit" value="更改情况" name="shsyBtns" id="shsyBtns" />
			</td>
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