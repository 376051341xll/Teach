<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$diaoquData = $bw->selectOnly('*', 'bw_config', 'id = 1', '')
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']); 
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
		location.href="xylist.php?page="+thisPage.val();
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
	if($bw->delete('bw_member', 'id = '.$_GET['id']))
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
			if($bw->delete('bw_member', "id IN (".$id.")"))
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
		unset($_POST['shsyBtn']);
		unset($_POST['page_SEL']);
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
				$sql = "UPDATE bw_qjj SET xxf = {$_POST['xxf'][$i]} WHERE id = {$_POST['id'][$i]}";
				$bw->query($sql);
			//echo $sql."<br>";
			}
		}
		//die();
			$bw->msg('设置成功!');
	}
if(!empty($_POST['fenpei']))
	{
		unset($_POST['fenpei']);
		unset($_POST['page_SEL']);
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
				$sql = "insert into bw_order(jyid,xyid,ifdd,ddzt,addtime) values({$_POST['jyid'][$i]},{$_POST['id'][$i]},2,1,'".date("y-m-d H:i:s")."')";
				die($sql);
				$sql1 = "update bw_qjj set zt='正在试教' where id={$_POST['id'][$i]}";
				$bw->query($sql);
				$bw->query($sql1);
			//echo $sql."<br>";
			}
		}
		//die();
			$bw->msg('设置成功!');
	}
?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>学员编号:<input name="ddbh" id="ddbh" size="10" />&nbsp;求教科目:<input name="qjkm" id="qjkm" size="10" />
&nbsp;所在区域:
<select name="szqy" id="szqy">
	  <option value="">--请选择--</option>
			  <?php
	$dir=$diaoquData["quyu"];
	$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
	for($i=0;$i<count($split_dir);$i++)
	
	{  ?>
	  <option value="<?php echo $split_dir[$i];?>" ><?php echo $split_dir[$i];?></option>
	<?php
	}
	?>
</select>
&nbsp;学员年级:
<select name="xynj" id="xynj">
	  <option value="">--请选择--</option>
			  <?php
	$dir=$diaoquData["nianji"];
	$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
	for($i=0;$i<count($split_dir);$i++)
	
	{  ?>
	  <option value="<?php echo $split_dir[$i];?>" ><?php echo $split_dir[$i];?></option>
	<?php
	}
	?>
</select>
&nbsp;学员类型:
<select name="xylx">
	<option selected="selected" value="">--请选择--</option>
	<option value="零基础">零基础</option>
	<option value="补差型">补差型</option>
	<option value="提高型">提高型</option>
	<option value="拔尖型">拔尖型</option>
</select>&nbsp;状态：&nbsp;<select name="xylx">
	<option selected="selected" value="">--请选择--</option>
	<option value="零基础">零基础</option>
	<option value="补差型">补差型</option>
	<option value="提高型">提高型</option>
	<option value="拔尖型">拔尖型</option>
</select>
&nbsp;<input type="submit" value="搜索" />
</td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trusername">
    <td width="50" align="center"><strong>ID</strong></td>
    <td width="87" align="center"><strong>学员编号</strong></td>
    <td width="88" align="center"><strong>联系人</strong></td>
    <td width="100" align="center"><strong>学员年级</strong></td>
    <td width="98" align="center"><strong>学员类型</strong></td>
    <td width="100" align="center"><strong>求教学科</strong></td>
    <td width="100" align="center"><strong>所在区域</strong></td>
	<td width="90" align="center"><strong>状态</strong></td>
    <td width="100" align="center"><strong>教员id</strong></td>
    <td width="100" align="center"><strong>信息费</strong></td>
    <td width="80" align="center"><strong>发布时间</strong></td>
    <td width="114" align="center"><strong>操作</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_qjj";
  $where    = "1=1 and sfhy = 1 and zt='正在试教'";
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['ddbh']))
	  {
		$where =$where." and id LIKE '%".$_POST['ddbh']."%'";
		$_SESSION['wherexylist'] = $where;
	  }
	  if(!empty($_POST['qjkm']))
	  {
		$where =$where." and qjkm LIKE '%".$_POST['qjkm']."%'";
		$_SESSION['wherexylist'] = $where;
	  }
	  if(!empty($_POST['szqy']))
	  {
		$where =$where." and szqy LIKE '%".$_POST['szqy']."%'";
		$_SESSION['wherexylist'] = $where;
	  }
	  if(!empty($_POST['xynj']))
	  {
		$where =$where." and xynj LIKE '%".$_POST['xynj']."%'";
		$_SESSION['wherexylist'] = $where;
	  }
	  if(!empty($_POST['xylx']))
	  {
		$where =$where." and xylx LIKE '%".$_POST['xylx']."%'";
		$_SESSION['wherexylist'] = $where;
	  }
  }else{
	    $_SESSION['wherexylist']=$where;
  }
  //die($_SESSION['wherexylist']);
  $list = $bw->selectPage("*",$tbName, $_SESSION['wherexylist'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wherexylist'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
 <tr class="showtr">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
    <td align="center"><a href="xyadd.php?id=<?php echo $list[$i]['id']?>"><?php echo $list[$i]['id']; ?></a></td>
    <td align="center"><a href="xyadd.php?id=<?php echo $list[$i]['id']?>"><?php echo $list[$i]['name']; ?></a></td>
    <td align="center"><?php echo $list[$i]['xynj']; ?></td>
    <td align="center"><?php echo $list[$i]['xylx']; ?></td>
    <td align="center"><?php echo $list[$i]['qjkm']; ?></td>
    <td align="center"><?php echo $list[$i]['szqy']; ?></td>
	<td align="center"><?php if($list[$i]['zt']=="正在试教"){echo "<font color='#FF0000'>".$list[$i]['zt']."</font>";}else{echo $list[$i]['zt'];} ?></td>
    <td align="center"><input name="jyid[]" type="text" id="jyid" value="<?php
     if($list[$i]['zt']=="正在试教"){
	 	$jyorder = $bw->selectOnly('jyid', 'bw_order', 'xyid = '.$list[$i]['id'], '');
		echo $jyorder["jyid"];
	 }
	?>" size="10"/></td>
    <td align="center"><input name="xxf[]" type="text" id="xxf" value="<?php echo $list[$i]['xxf']; ?>" size="10"/></td>
    <td align="center">
      <?php echo date("Y-m-d",strtotime($list[$i]['addtime']));?></td>
    <td align="center"><a href="xyadd.php?id=<?php echo $list[$i]['id']?>"><img src="images/pen.gif" alt="修改信息" title="修改信息" /></a>&nbsp;&nbsp;<a href="###" onclick="javascript:if(confirm('是否删除')){window.location.href='?action=delete&id=<?php echo $list[$i]['id']; ?>'}"><img src="images/delete.gif" /></a></td>
  </tr>
<?php
	}//end loop
?>
  <tr>
  	<td colspan="12" align="center">
    	<div class="pageDiv">
        	<div class="pageLeft" style="width:450px;"><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;<input type="submit" value="删除所选" name="deleteSelect" id="deleteSelect" />&nbsp; <input type="submit" value="分配教员" name="fenpei" id="fenpei" />&nbsp;<input type="submit" value="更改信息费" name="shsyBtn" id="shsyBtn" /></div>
            <div class="pageRight" style="width:600px;">
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