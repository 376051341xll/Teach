<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	$diaoquData = $bw->selectOnly('*', 'bw_config', "lang='".$_SESSION["Lang_session"]."'", '');
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']); 
	if( $_GET['act']=="k")
	{
		$_SESSION['whereorderlist2']="";
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
		location.href="jyorderlist2.php?page="+thisPage.val();
		});//end page_SEL 		
	});
	function yinc(id)
	{
		if(document.getElementById(id).style.display=="")
		{
			document.getElementById(id).style.display='none';
		}else{
			document.getElementById(id).style.display='';
			}
	}
</script></head>

<body>
<?php
//删除数据
	if(!empty($_GET["xyid"]))
	{
	htqx("7.3"); 
	$sql = "UPDATE bw_order SET ifnew = 0 WHERE id = '".$_GET["ifnew"]."' ";
	$bw->query($sql);
	$sql5 = "UPDATE bw_order SET ifnew = 0 WHERE xyid=".$_GET["xyid"]." and jyid<>".$_GET["jyid"];
	$bw->query($sql5);
	$sql2 = "UPDATE bw_order SET ifdd=2,ddzt=1,addtime='".date("y-m-d H:i:s")."' where xyid=".$_GET["xyid"]." and jyid=".$_GET["jyid"];
	$bw->query($sql2);
	$sql3 = "UPDATE bw_order SET ifdd=0,ddzt=1,addtime='".date("y-m-d H:i:s")."' where xyid=".$_GET["xyid"]." and jyid<>".$_GET["jyid"];
	$bw->query($sql3);
	$sql4 = "UPDATE bw_qjj SET zt='正在试教' where id=".$_GET["xyid"];
	$bw->query($sql4);
	$bw->msg("安排成功");
	}
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
			$yuyueData = $bw->selectOnly('*', 'bw_order', "id=".$_POST['id'][$i], '');
				$sql = "UPDATE bw_qjj SET xxf = ".$_POST['xxf'.$_POST['id'][$i]]." WHERE id = {$yuyueData['xyid']}";
				$bw->query($sql);
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
<td>学员编号:<input name="ddbh" id="ddbh" size="10" />&nbsp;&nbsp;<input type="submit" value="搜索" />
</td>
</form>
</tr>
</table>
<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trusername">
    <td width="5%" align="center"><strong>ID</strong></td>
    <td width="8%" align="center"><strong>学员编号</strong></td>
    <td width="10%" align="center"><strong>联系人</strong></td>
    <td width="10%" align="center"><strong>学员类型</strong></td>
    <td width="10%" align="center"><strong>求教学科</strong></td>
    <td width="10%" align="center"><strong>所在区域</strong></td>
    <td width="10%" align="center"><strong>订单状态</strong></td>
    <td width="10%" align="center"><strong>发布时间</strong></td>
    <td width="10%" align="center"><strong>是否会员</strong></td>
    <td width="10%" align="center"><strong>信息费</strong></td>
    <td width="10%" align="center"><strong>操作</strong></td>
  </tr>
  <form name="listForm" action="?action=deleteFrom" method="post">
    <?php
  //查询
//$_SESSION['whereorderlist2']="";
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_order";
  $where    = "ifdd=1 and yylx=1 and lang='".$Lang."' ";
 // die($where);
  //搜索
//  if(!empty($_GET['action']) && $_GET['action'] == 'search')
//  {
//	  if(!empty($_POST['ddbh']))
//	  {
//		$where =$where." and ddbh LIKE '%".$_POST['ddbh']."%'";
//		$_SESSION['whereorderlist'] = $where;
//	  }
//	  if(!empty($_POST['qjkm']))
//	  {
//		$where =$where." and qjkm LIKE '%".$_POST['qjkm']."%'";
//		$_SESSION['whereorderlist'] = $where;
//	  }
//	  if(!empty($_POST['szqy']))
//	  {
//		$where =$where." and szqy LIKE '%".$_POST['szqy']."%'";
//		$_SESSION['whereorderlist'] = $where;
//	  }
//	  if(!empty($_POST['xynj']))
//	  {
//		$where =$where." and xynj LIKE '%".$_POST['xynj']."%'";
//		$_SESSION['whereorderlist'] = $where;
//	  }
//	  if(!empty($_POST['xylx']))
//	  {
//		$where =$where." and xylx LIKE '%".$_POST['xylx']."%'";
//		$_SESSION['whereorderlist'] = $where;
//	  }
//  }else{
//	    $_SESSION['whereorderlist']=$where;
//  }
  if($_SESSION['whereorderlist2']=="")
  {
	    $_SESSION['whereorderlist2']=$where;
  }
  //die($_SESSION['whereorderlist2']);
  $list = $bw->selectPage110("*",$tbName, $_SESSION['whereorderlist2'],"group by xyid  order by id desc",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['whereorderlist2'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
//	  echo $list[$i]['xyid'];
//	  exit;
	$xynrData = $bw->selectOnly('*', 'bw_qjj', "id=".$list[$i]['xyid'], '');
?>
    <tr class="showtr">
      <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
      <td align="center"><?php if($list[$i]['ifnew']==1){echo "<font color='#FF0000'>[新]</font>";}?><a href="xyadd.php?id=<?php echo $xynrData['id']?>"><?php echo $xynrData['id']; ?></a></td>
      <td align="center"><a href="xyadd.php?id=<?php echo $xynrData['id']?>"><?php echo $xynrData['name']; ?></a></td>
      <td align="center"><?php echo $xynrData['xylx']; ?></td>
      <td align="center"><?php echo $xynrData['qjkm']; ?></td>
      <td align="center"><?php echo $xynrData['szqy']; ?></td>
      <td align="center"><?php if($xynrData['zt']=="正在试教" && $list[$i]['ifdd']==2){echo "<font color='#FF0000'>".$xynrData['zt']."</font>";}if($xynrData['zt']=="正在试教" && $list[$i]['ifdd']==1){echo "未安排";}else{echo $xynrData['zt'];} ?></td>
      <td align="center"><?php echo date("Y-m-d",strtotime($xynrData['addtime']));?></td>
      <td align="center"><?php if($xynrData['sfhy']==1){echo "<font color='#FF0000'>是</font>";}else{echo "不是";} ?></td>
      <td align="center"><input name="xxf<?php echo $list[$i]['id']; ?>" type="text" id="xxf" value="<?php echo $xynrData['xxf']; ?>" size="10"/></td>
      <td align="center"><a href="#" onclick="yinc('a<?php echo $list[$i]['id'];?>')">查看教员</a>&nbsp;&nbsp;<a href="###" onclick="javascript:if(confirm('是否删除')){window.location.href='?action=delete&id=<?php echo $list[$i]['id']; ?>'}"><img src="images/delete.gif" /></a></td>
    </tr>
    <tr id="a<?php echo $list[$i]['id'];?>" style="display:none;">
      <td colspan="11" align="right" style="background:#f8f8f8;"><table width="98%" height="27" border="0" align="right" cellpadding="0" cellspacing="0" id="jyk1">
        <?php
		//selectMany($param,$tbname,$where,$order,$limit)
		$classList = $bw->selectMany("*","bw_order","xyid =".$list[$i]['xyid']."","`id` DESC","");
		$menu_sum = count($classList);
		for($ii = 0; $ii<$menu_sum; $ii++)
		{		
       $jynrData = $bw->selectOnly('*', 'bw_member', "id=".$classList[$ii]['jyid'], '');
  ?>
        <tr>
          <td width="14%" align="center"><?php echo $jynrData['id'];?></td>
          <td width="9%" height="25" align="center" valign="middle"><?php echo $jynrData['username']; ?></td>
          <td width="9%" align="center" valign="middle"><a href="membermod.php?id=<?php echo $jynrData['id'];?>"><?php echo $jynrData['truename']; ?></a></td>
          <td width="10%" align="center"><?php if($jynrData['sex'] == 1){echo '男';} if($jynrData['sex'] == 2){echo '女';}?></td>
          <td width="14%" align="center"><?php
	 if($jynrData['levels']==1)
	 {
		 echo "大学生";
		 } 
	 if($jynrData['levels']==2)
	 {
		 echo "职业教师";
		 } 
	 if($jynrData['levels']==3)
	 {
		 echo "留学、海归";
		 } 
	 ?></td>
          <td width="15%" align="center"><a href="#" title="<?php echo $jynrData['kjskm']; ?>">[可教授科目]</a></td>
          <td width="16%" align="center">预存款：<?php echo $jynrData['Money']; ?></td>
          <td width="13%" align="center"><?php if($list[$i]['jyid']==$jynrData['id'] && $list[$i]['ifdd']==2){ echo "<font color='#0000FF'>已安排此教员</font>";}else{?><a href="?xyid=<?php echo $list[$i]['xyid'];?>&jyid=<?php echo $jynrData['id']; ?>&ifnew=<?php echo $list[$i]['id']; ?>" style="color:#F00;">安排此教员</a><?php }?></td>
        </tr>

        <?php
  }
  ?>
      </table></td>
    </tr>
    <?php
	}//end loop
?>
    <tr>
      <td colspan="12" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><input type="button" value="全选" id="selectAll" />
          &nbsp;
          <input type="button" value="反选" id="orderSelect" />
          &nbsp;
          <input type="submit" value="删除所选" name="deleteSelect" id="deleteSelect" />
          &nbsp;
          <input type="submit" value="更改信息费" name="shsyBtn" id="shsyBtn" /></td>
            <td align="right">共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp; <a href="?page=1">第一页</a>&nbsp;&nbsp; <a href="?page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp; <a href="?page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp; <a href="?page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
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