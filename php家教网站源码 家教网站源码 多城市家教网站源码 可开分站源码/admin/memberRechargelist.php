<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']);
		if( $_GET['s']==0)
	{
		$_SESSION['wherejflists']="";
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
<script language=javascript src="js/wpCalendar.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="memberRechargelist.php?page="+thisPage.val();
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
			if($bw->delete('bw_moneyrecord', "id IN (".$id.")"))
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
<td>关键字:<input name="keyword" id="keyword" value="支持编号、用户名搜索" onclick="this.value='';" />
&nbsp;时间:
  <input name="stime" type=text id=text1 style="width:80px;" onfocus="showCalendar(this)" readonly> 
  <input name="etime" type=text id=text1 style="width:80px;" onfocus="showCalendar(this)" readonly>
  <select name="acontent" id="acontent">
    <option value="">费用类型</option>
    <option value="1">预存款</option>
    <option value="2">认证费</option>
    <option value="3">违约款</option>
    <option value="4">信息费</option>
    <option value="5">退款</option>
	<option value="6">会员费</option>
    <option value="7">其他</option>
  </select>
  <input type="submit" value="搜索" /></td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trusername">
    <td width="60" align="center"><strong>ID</strong></td>
    <td width="120" align="center"><strong>记录编号</strong></td>
    <td width="100" align="center"><strong>教员ID</strong></td>
    <td width="100" align="center"><strong>用户名</strong></td>
    <td width="68" align="center"><strong>教员姓名</strong></td>
    <td width="119" align="center"><strong>费用类型</strong></td>
    <td width="120" align="center"><strong>金额</strong></td>
    <td width="180" align="center"><strong>支付方式</strong></td>
    <td width="120" align="center"><strong>操作时间</strong></td>
    <td width="80" align="center"><strong>结果</strong></td>
    <td width="80" align="center"><strong>业务员</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = 15;
  $tbName   = "bw_moneyrecord";
  $where    = 'lang="'.$Lang.'"';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	 // die($_POST['keyword']);
  	  if(!empty($_POST['keyword']) && $_POST['keyword']!= '支持编号、用户名搜索' )
	  {
	    $userData1 = $bw->selectOnly('id,username', 'bw_member', "username = '".$_POST['keyword']."' or id = '".$_POST['keyword']."'");
		//die($userData1['id']);
        if(!empty($userData1['id'])){
		$where = $where." and id in ( select id from bw_moneyrecord where memberid = ".$userData1['id'].")";
		}else{
		$where = $where." and id in ( select id from bw_moneyrecord where recordno LIKE '%".$_POST['keyword']."%')";
		}
	  }
	  else
	  {
	  $where = "lang='".$Lang."'";
	  }
	  
	  if(!empty($_POST['stime']) && !empty($_POST['etime']))
	  {
	  if(!empty($where)){
	  $where = $where . " and addtime >'".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }else{
	  $where =  $where." addtime >='".$_POST['stime']."' and addtime <='".$_POST['etime']."'";
	  }
	  }
	  
	  
	  
	  if(!empty($_POST['acontent']) && !empty($_POST['acontent']))
	  {
	  if(!empty($where)){
	  $where = $where . " and acontent =".$_POST['acontent'];
	  }else{
	  $where =  $where." acontent =".$_POST['acontent'];
	  }
	  }
	  $_SESSION['wherejflists'] = $where;
  }
 if(!empty($_GET['act']) && $_GET['act'] == 'show')
  {
	  $userData2 = $bw->selectOnly('id', 'bw_member', "id = '".$_GET['id']."'"); 
	  $where =  $where." and id in ( select id from bw_moneyrecord where memberid = ".$userData2['id'].")";
	   $_SESSION['wherejflists'] = $where;
  }
  if($_SESSION['wherejflists']==''){
  $_SESSION['wherejflists']=$where;
  }
 // die($_SESSION['wherejflists']);
  $list = $bw->selectPage("*",$tbName,$_SESSION['wherejflists'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wherejflists'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
   $jyData = $bw->selectOnly('*' ,'bw_member', 'id = '.$list[$i]['memberid']);
?>
 <tr class="showtr">
   <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
   <td align="center">&nbsp; <?php echo $list[$i]['recordno']; ?></td>
   <td align="center"><?php echo $list[$i]['memberid']; ?></td>
   <td align="center"><?php
   $userData = $bw->selectOnly('username', 'bw_member', "id = ".$list[$i]['memberid']);
   echo $userData['username'];
    ?>&nbsp; </td>
   <td align="center"><?php echo $jyData['truename']; ?></td>
   <td align="center"><?php  switch ($list[$i]['acontent'])
		{
		case 1: echo "预存款";break;
		case 2: echo "认证费";break;
		case 3: echo "违约款";break;
		case 4: echo "信息费";break;
		case 5: echo "退款";break;
		case 6: echo "会员费";break;
		case 7: echo "其他";break;
		}?>&nbsp; </td>
   <td align="center"><?php echo $list[$i]['amount']; ?>&nbsp; </td>
   <td align="center"><?php echo $list[$i]['away']; ?>&nbsp; </td>
   <td align="center"><?php echo $list[$i]['addtime']; ?></td>
   <td align="center">&nbsp;&nbsp;
     <?php  switch ($list[$i]['atype'])
		{
		case 1: echo "转账成功";break;
		case 0: echo "<font color='#ff0000'>未成功转账</font>";break;
		}?>   </td>
   <td align="center"><?php echo $list[$i]['username']; ?></td>
 </tr>
  <?php
	}//end loop
?>
  <tr>
  	<td colspan="12" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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