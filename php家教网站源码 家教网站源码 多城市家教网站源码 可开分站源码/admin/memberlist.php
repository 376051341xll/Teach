<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']);
	$sqlstr="update bw_member set ifrz=3 where daoqi<'".date("Y-m-d")."'";
	$bw->query($sqlstr);
	if($_GET["sou"]=="k")
	{
		$_SESSION['wherememberlist']="";
		}
	$diaoquData = $bw->selectOnly('*', 'bw_config', 'lang="'.$Lang.'"', '');
	htqx("5.1");
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
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<?php
//删除数据
$action = $_GET['action'];
if(!empty($_POST['id']))
{
$id = implode(',', $_POST['id']);
}
//删除单条数据
$pages = $_POST['pages'];//翻页用的
unset($_POST['pages']);//翻页用的
if($action == 'delete')
{
htqx("5.4");
	if($bw->delete('bw_member', 'id = '.$_GET['id']))
	{
		$bw->msg('删除成功!', 'memberlist.php?page='.$pages.'');	
	}else{
		$bw->msg('删除失败!', 'memberlist.php?page='.$pages.'');	
	}
}
//删除多条数据
	if(!empty($_POST['deleteSelect']))
	{
	htqx("5.4");
	//print_r($_POST);
	if(isset($_POST['id']))
	{
		//deleteSelect shsyBtn qxshBtn
		if(!empty($_POST['deleteSelect']))
		{
			if($bw->delete('bw_member', "id IN (".$id.")"))
			{
				$bw->msg('删除成功!', 'memberlist.php?page='.$pages.'');	
			}else{
				$bw->msg('删除失败!', 'memberlist.php?page='.$pages.'');	
			}
		}
	}
	}
	
	//等级设置
	if(!empty($_POST['shsyBtn']))
	{
	htqx("5.3");
		unset($_POST['shsyBtn']);
		unset($_POST['page_SEL']);
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
				$sql = "UPDATE bw_member SET ifxj = {$_POST['ifxj'][$i]} WHERE id = {$_POST['id'][$i]}";
				$bw->query($sql);
			//echo $sql."<br>";
			}
		}
		//die();
			$bw->msg('设置等级成功!', 'memberlist.php?page='.$pages.'');
	}
	
	
	//qxtjBtn sztjBtn  认证设置
	if(!empty($_POST['sztjBtn']))
	{
	htqx("5.3");
		$sql = "UPDATE bw_member SET ifrz = 2 WHERE id IN (".$id.")";
		//die($sql);
		if($bw->query($sql))
		{  
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
		    //资金往来记录中写入 自动扣除认证费20元
		    $sqlstr="INSERT INTO bw_moneyrecord (memberid,atype,recordno,addtime,acontent,away,amemo,amount,lang,username) VALUES (".$_POST['id'][$i].",1,'"."Y".date(Ymdhms)."','".date('Y-m-d H:i:s')."',2,'认证费','认证费','-20','".$Lang."','".$_SESSION['username']."')";
			$bw->query($sqlstr);
			$nian=date('Y')."";
			$nian=$nian+1;
			$daoq=$nian."-".date('m')."-".date('d'); 
			
			//从教员存款中扣除认证费20元
			$sqlrzf = "UPDATE bw_member SET Money = Money-20,daoqi='".$daoq."' WHERE id = '".$_POST['id'][$i]."'";
			$bw->query($sqlrzf);
			
			}
		}
			$bw->msg('设置认证成功!', 'memberlist.php?page='.$pages.'');	
		}else{
			$bw->msg('设置失败!', 'memberlist.php?page='.$pages.'');	
		}
	}
	
	if(!empty($_POST['qxtjBtn']))
	{
	htqx("5.3");
	$id = implode(',', $_POST['id']);
		$sql = "UPDATE bw_member SET ifrz = 1 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('取消认证成功!', 'memberlist.php?page='.$pages.'');	
		}else{
			$bw->msg('取消失败!', 'memberlist.php?page='.$pages.'');	
		}
	}
	
	//发布设置
	if(!empty($_POST['fabu']))
	{
	htqx("5.3");
		$sql = "UPDATE bw_member SET iffb = 2 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('设置发布成功!', 'memberlist.php?page='.$pages.'');	
		}else{
			$bw->msg('发布失败!', 'memberlist.php?page='.$pages.'');	
		}
	}
	if(!empty($_POST['qxfabu']))
	{
	htqx("5.3");
		$sql = "UPDATE bw_member SET iffb = 1 WHERE id IN ({$id})";
		if($bw->query($sql))
		{
			$bw->msg('取消发布成功!', 'memberlist.php?page='.$pages.'');	
		}else{
			$bw->msg('取消失败!', 'memberlist.php?page='.$pages.'');	
		}
	}
	
	//审核设置
		//die("fdsa");
if(!empty($_POST['shenhe']))
	{
	htqx("5.3");
		unset($_POST['shenhe']);
		unset($_POST['page_SEL']);
		$ii= count($_POST['id']);
		if($ii > 0)
		{
			for($i = 0; $i < $ii; $i++)
			{
			$shqk='shqk'.$_POST['id'][$i];
			
			    if($_POST[$shqk]!="")
				{
				$sql = "update bw_member set shqk=".$_POST[$shqk]."  where id={$_POST['id'][$i]}";
				//die($sql);
				$bw->query($sql);
			    }
			}
		}
		//die();
			$bw->msg('设置审核状态成功!', 'memberlist.php?page='.$pages.'');
	}	
	
	

//处理默认密码
if($action == 'changepwd')
{
htqx("5.3");
	//print_r($_POST);
	$sql = "UPDATE bw_member SET password = '".md5(123456)."' WHERE id = ".$_GET['id'];
	if($bw->query($sql))
	{
		$bw->msg('处理成功!', 'memberlist.php');	
	}else{
		$bw->msg('处理失败!', 'memberlist.php');	
	}
}
?>
<table width="96%" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td>关键字:
  <select name="guanjianlei" id="guanjianlei">
      <option value="">关键字类型</option>
      <option value="id">教员编号</option>
      <option value="kjskm">授课科目</option>
      <option value="telphone">电话</option>
      <option value="truename">姓名</option>
      <option value="zhuanye">专业</option>
  </select>
  <input name="keyword" id="keyword" style="width:100px;" />&nbsp;
  高校：<input name="xuexiao" id="xuexiao" style="width:100px;" />&nbsp;
  专业：<input name="zhuanye" id="zhuanye" style="width:100px;" />
  <select name="sex" id="sex">
      <option value="">性别</option>
      <option value="1">男</option>
      <option value="2">女</option>
  </select>
  <select name="diqu" id="diqu">
      <option value="">选择区域</option><?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>"><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
  </select>
  <select name="leixing" id="leixing">
    <option value="">选择类型</option>
    <option value="1">大学生</option>
    <option value="2">职业教师</option>
    <option value="3">留学、海归</option>
    <option value="4">其他人员</option>
  </select>
  <select name="mqsf" id="mqsf">
      <option value="">----目前分身----</option>
      <?php
$dir=$diaoquData["shenfen"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php
              if($newsData['mqsf']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
    </select>
    <select name="zhicheng" id="zhicheng">
      <option value="">————职称等级————</option>
      <?php
$dir=$diaoquData["zhicheng"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php
              if($newsData['zhicheng']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?>><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
      </select>
  <select name="xiang" id="xiang">
    <option value="">所有教员</option>
    <option value="1">待认证</option>
    <option value="2">已认证</option>
    <option value="3">未发布</option>
  </select>
  &nbsp;  <input type="submit" value="搜索" /></td>
</form>
</tr>
</table>

<table width="96%" cellpadding="0" cellspacing="0">
  <tr class="trusername">
    <td align="center"><strong>ID</strong></td>
     <td align="center"><strong>注册时间</strong></td>
    <td align="center"><strong>编号</strong></td>
    <td align="center"><strong>用户名</strong></td>
    <td align="center"><strong>教员类型</strong></td>
    <td align="center"><strong>性别</strong></td>
    <td align="center"><strong>姓名</strong></td>
    <td align="center"><strong>可授科目</strong></td>
    <td align="center"><strong>账户余额</strong></td>
    <td align="center"><strong>是否发布</strong></td>
    <td align="center"><strong>会员等级</strong></td>
    <td align="center"><strong>简历审核</strong></td>
    <td align="center"><strong>是否认证</strong></td>
    <td align="center"><strong>操作</strong></td>
  </tr>
<form name="listForm" action="?action=deleteFrom" method="post">
<?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $pagestart=PAGESIZE * $_GET["page"];
  //$tbName   = "bw_member a,(select id from bw_member limit ".$pagestart.",20) b";
  $tbName   = "bw_member";
  $where    = '1=1 and lang="'.$Lang.'" ';
  //搜索
  if(!empty($_GET['action']) && $_GET['action'] == 'search')
  {
	  if(!empty($_POST['keyword']) && !empty($_POST['guanjianlei']))
	  {
		$where = $where." and ".$_POST['guanjianlei']." LIKE '%".$_POST['keyword']."%'";
		$_SESSION['wherememberlist'] = $where;
	  }
	  if(!empty($_POST['xuexiao']))
	  {
		$where = $where." and xuexiao LIKE '%".$_POST['xuexiao']."%'";
		$_SESSION['wherememberlist'] = $where;
	  }
	  if(!empty($_POST['zhuanye']))
	  {
		$where = $where." and zhuanye LIKE '%".$_POST['zhuanye']."%'";
		$_SESSION['wherememberlist'] = $where;
	  }
	  if(!empty($_POST['sex']))
	  {
		$where = $where." and sex= '".$_POST['sex']."'";
		$_SESSION['wherememberlist'] = $where;
	  }
	  if(!empty($_POST['mqsf']))
	  {
		$where = $where." and mqsf= '".$_POST['mqsf']."'";
		$_SESSION['wherememberlist'] = $where;
	  }
	   if(!empty($_POST['zhicheng']))
	  {
		$where = $where." and (zhicheng= '".$_POST['zhicheng']."' or  mqsf='".$_POST['zhicheng']."')";
		$_SESSION['wherememberlist'] = $where;
	  }
	  if(!empty($_POST['diqu']))
	  {
		$where = $where." and quyu like '%".$_POST['diqu']."%'";
		$_SESSION['wherememberlist'] = $where;
	  }
	  if(!empty($_POST['leixing']))
	  {
		$where = $where." and levels =".$_POST['leixing'];
		$_SESSION['wherememberlist'] = $where;
	  }
	  if($_POST['xiang']==1)
	  {
		$where = $where." and ifrz =1";
		$_SESSION['wherememberlist'] = $where;
	  }
	  if($_POST['xiang']==2)
	  {
		$where = $where." and ifrz =2";
		$_SESSION['wherememberlist'] = $where;
	  }
	  if($_POST['xiang']==3)
	  {
		$where = $where." and iffb =1";
		$_SESSION['wherememberlist'] = $where;
	  }
  }
  if($_SESSION['wherememberlist']=="")
  {
	  $_SESSION['wherememberlist'] = $where;
  }
   
  // die($_SESSION['wherememberlist']);
  $list = $bw->selectPage("*",$tbName,$_SESSION['wherememberlist'],"id DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wherememberlist'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
	  
?>
 <tr class="showtr">
    <td align="center"><input type="checkbox" name="id[]" id="id[]" value="<?php echo $list[$i]['id']; ?>" /></td>
    <td align="center"><?php if($list[$i]['ifnew']==1){echo "<font color='#FF0000'>[新]</font>";}?><a href="membermod.php?id=<?php echo $list[$i]['id'];?>&page=<?php echo $pageArray['page']; ?>"><?php echo $list[$i]['reg_time']; ?></a></td>
    <td align="center"><a href="membermod.php?id=<?php echo $list[$i]['id'];?>&page=<?php echo $pageArray['page']; ?>"><?php echo $list[$i]['id']; ?></a></td>
    <td align="center"><a href="membermod.php?id=<?php echo $list[$i]['id'];?>&page=<?php echo $pageArray['page']; ?>"><?php echo $list[$i]['username']; ?></a></td>
    <td align="center"><?php
	 if($list[$i]['levels']==1)
	 {
		 echo "大学生";
		 } 
	 if($list[$i]['levels']==2)
	 {
		 echo "职业教师";
		 } 
	 if($list[$i]['levels']==3)
	 {
		 echo "留学、海归";
		 } if($list[$i]['levels']==4){
			  echo "其他人员";
			 } 
	 ?></td>
    <td align="center"><?php if($list[$i]['sex'] == 1){echo '男';} if($list[$i]['sex'] == 2){echo '女';}?></td>
    <td align="center"><?php echo $list[$i]['truename']; ?></td>
    <td align="center"><a href="#" title="<?php echo $list[$i]['kjskm']; ?>"><?php echo chgtitle(phphtml($list[$i]['kjskm']),8); ?></a></td>
    <td align="center"><?php echo $list[$i]['Money']; ?></td>
    <td align="center"><?php 
	if($list[$i]['iffb']==2)
	{
		echo "<span style='color:#0000ff'>已发布</span>";
		}else{
		echo "<span style='color:#ff0000'>未发布</span>";
			} 
	?></td>
    <td align="center">
   		<select name="ifxj[]" id="ifxj">
            <option value="6" <?php if($list[$i]['ifxj'] ==6){echo "selected=selected";}?>>普通会员</option>
            <option value="1" <?php if($list[$i]['ifxj'] ==1){echo "selected=selected";}?>>一星级</option>
            <option value="2" <?php if($list[$i]['ifxj'] ==2){echo "selected=selected";}?>>二星级</option>
            <option value="3" <?php if($list[$i]['ifxj'] ==3){echo "selected=selected";}?>>三星级</option>
            <option value="4" <?php if($list[$i]['ifxj'] ==4){echo "selected=selected";}?>>四星级</option>
            <option value="5" <?php if($list[$i]['ifxj'] ==5){echo "selected=selected";}?>>五星级</option>
        </select>   </td>
    <td align="center">
	<select name="shqk<?php echo $list[$i]['id']; ?>" id="shqk">
            <option value="-1" <?php if($list[$i]['shqk'] =="-1"){echo "selected=selected";}?>>待审核</option>
            <option value="0" <?php if($list[$i]['shqk'] ==0){echo "selected=selected";}?>>未通过</option>
            <option value="1" <?php if($list[$i]['shqk'] ==1){echo "selected=selected";}?>>已通过</option>
    </select> 	
	 </td>
    <td align="center">
	<?php if($list[$i]['ifrz'] == 1){ 
	echo "<span style='color:red'>未认证</span>";
	 }
	 if($list[$i]['ifrz'] == 2)
	 {
		 echo "<span style='color:green'>已认证</span>";
	}
	if($list[$i]['ifrz'] == 3)
	{
		echo "<span style='color:#0000FF'>已过期</span>";
		} ?>
	</td>
    <td align="center"><a href="javascript:if(confirm('确定要修改密码为123456？')){window.location.href='?action=changepwd&id=<?php echo $list[$i]['id']?>'}" title="重置密码为123456" class="style1">密码重置</a>&nbsp;&nbsp;<a href="membermod.php?id=<?php echo $list[$i]['id'];?>&page=<?php echo $pageArray['page']; ?>"><img src="images/pen.gif" alt="修改信息" title="修改信息" /></a>&nbsp;&nbsp;<a onclick="javascript:if(confirm('是否删除')){window.location.href='?action=delete&id=<?php echo $list[$i]['id']; ?>'}" href="###"><img src="images/delete.gif" alt="删除信息" title="删除信息"/></a></td>
  </tr>

<?php
	}//end loop
?>
  <tr>
  	<td colspan="14" width="1200" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        	  <tr>
        	    <td align="left"><input type="button" value="全选" id="selectAll" />&nbsp;<input type="button" value="反选" id="orderSelect" />&nbsp;<input type="submit" value="更改等级账户" name="shsyBtn" id="shsyBtn" />&nbsp;<input type="submit" value="发布所选" name="fabu" id="fabu" />&nbsp;<input type="submit" value="取消发布" name="qxfabu" id="qxfabu" /><input type="hidden" value="<?php echo $pageArray['page']; ?>" name="pages" id="pages" />
        	    &nbsp;<input type="submit" value="通过认证" name="sztjBtn" id="sztjBtn" />&nbsp;<input type="submit" value="取消认证" name="qxtjBtn" id="qxtjBtn" />&nbsp;<input type="submit" value="修改审核" name="shenhe" id="shenhe" />&nbsp;<input type="submit" value="删除所选" name="deleteSelect" id="deleteSelect" /></td>
        	    <td align="right" valign="middle">共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp;
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