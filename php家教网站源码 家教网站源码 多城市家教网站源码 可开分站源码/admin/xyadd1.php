<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	$diaoquData = $bw->selectOnly('*', 'bw_config', 'lang="'.$Lang.'"', '');
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']);
	if(empty($_GET["id"]))
	{
	htqx("6.2");
	}else{
	htqx("6.3");
		 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员信息列表</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script language=javascript src="js/wpCalendar.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script language="JavaScript" src="js/DateSelect.js"></script>
<style type="text/css">
<!--
input {height:20px; line-height:20px;}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body style=" overflow:hidden;">
<?php
//删除数据
$action = $_GET['add'];
//删除单条数据
if($action=="yes")
{
	//qxtjBtn sztjBtn
	$id = $_POST['id'];
	if(empty($id))
	{
	    unset($_POST['Submit']);
		unset($_POST['Submit2']);
		unset($_POST['id']);
		//insert($tbName, $post)
		if($bw->insert('bw_qjj', $_POST))
		{
			$bw->msg('新增成功!', 'xylist.php');
		}else{
			$bw->msg('新增失败!', 'xyadd.php?id='.$id.'', true);	
		}
	}else{   
	    unset($_POST['Submit']);
		unset($_POST['Submit2']);
		unset($_POST['addtime']);
		$id=$_POST['id'];
		unset($_POST['id']);
		
		//用于检测学员年级的修改情况
		$jcData = $bw->selectOnly('xynj,szqy', 'bw_qjj', 'id='.$id.'', '');
		if($_POST['xynj']!=$jcData["xynj"]){
		$sql1 = "update bw_qjj set jiance='".$_POST['xynj'].'---时间：'.date("y-m-d H:i:s")."' where id=".$id."";
		//die($sql1);
		$bw->query($sql1);
		}
		//用于检测所在区域的修改情况
		if($_POST['szqy']!=$jcData["szqy"]){
		$sql1 = "update bw_qjj set jiance2='".$_POST['szqy'].'---时间：'.date("y-m-d H:i:s")."' where id=".$id."";
		//die($sql1);
		$bw->query($sql1);
		}
		
		if($bw->update('bw_qjj', $_POST, 'id = '.$id))
		{
			$bw->msg('更新成功!', 'xylist.php');
		}else{
			$bw->msg('更新失败!', 'xyadd.php?id='.$id.'', true);
		}
	}		
}
?>
<?php
	//查找一条数
	$id=$_GET["id"];
	if(!empty($id)){
	//echo "<script>location.href='xylist.php'; </ script>";
	$classData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$id);
	
	$sql = "UPDATE bw_qjj SET ifnew = 0 WHERE id = '".$id."' ";
	$bw->query($sql);
	}
?>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="xyadd.php?page="+thisPage.val()+"&id="+<?php echo $id; ?>;
		});//end page_SEL 		
	});
</script>

<div id="xyaddyc" style="display:none;">
<?php
if(!empty($id))
{
?>
<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5"><strong>该学员预约的教员</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>订单ID</strong></td>
    <td align="center"><strong>教员编号</strong></td>
    <td align="center"><strong>教员姓名</strong></td>
    <td align="center"><strong>订单状态</strong></td>
    <td align="center"><strong>预约时间</strong></td>
  </tr>
  
<?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_order';
				  $where    = 'xyid = '.$id.' and ifdd=1 and yylx=2 ';
				  $hyzxlist = $bw->selectPage("*", $tbName, $where, "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
				  $jyData = $bw->selectOnly('*' ,'bw_member', 'id = '.$hyzxlist[$hyzxi]['jyid']);
			  ?>
  <tr>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['id'] ;?></td>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['jyid'] ;?></td>
    <td align="center"><?php echo $jyData['truename']; ?></td>
    <td align="center"><?php if($hyzxlist[$hyzxi]['ddzt']==1 && $hyzxlist[$hyzxi]['ifdd']==1){echo "未安排";}?></td>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['subtime'] ;?></td>
  </tr>
  <?php
                  }//end loop
              ?>
  <tr>
    <td colspan="5" align="center">
	共:<?php echo $pageArray['totalRow']; ?>条信息&nbsp;&nbsp;&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>&nbsp;页&nbsp;&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=1">首页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
<!--				转到
						<select name="page_SEL" onChange="MM_jumpMenu('parent',this,0)">
                   	<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="xyadd.php?page=<?php echo $goPage; ?>&id=<?php echo $sid; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
                  </select>-->
	</td>
  </tr>
</table>
<br>
<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5"><strong>该学员家教记录</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>订单ID</strong></td>
    <td align="center"><strong>教员编号</strong></td>
    <td align="center"><strong>教员姓名</strong></td>
    <td align="center"><strong>订单状态</strong></td>
    <td align="center"><strong>时间</strong></td>
  </tr>
  
<?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_order';
				  $where    = 'xyid = '.$id.' and ifdd=2 ';
				  $hyzxlist = $bw->selectPage("*", $tbName, $where, "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
				  $jyData = $bw->selectOnly('*' ,'bw_member', 'id = '.$hyzxlist[$hyzxi]['jyid']);
			  ?>
  <tr>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['id'] ;?></td>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['jyid'] ;?></td>
    <td align="center"><?php echo $jyData['truename']; ?></td>
    <td align="center">
					<?php if($hyzxlist[$hyzxi]['ddzt']==1){echo "试教中";}?> 
					<?php if($hyzxlist[$hyzxi]['ddzt']==2){echo "订单成功";}?>
					<?php if($hyzxlist[$hyzxi]['ddzt']==3){echo "订单失败";}?> 
	</td>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['addtime'] ;?></td>
  </tr>
  <?php
                  }//end loop
              ?>
  <tr>
    <td colspan="5" align="center">
	共:<?php echo $pageArray['totalRow']; ?>条信息&nbsp;&nbsp;&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>&nbsp;页&nbsp;&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=1">首页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?id=<?php echo $id; ?>&page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
<!--				转到
						<select name="page_SEL" onChange="MM_jumpMenu('parent',this,0)">
                   	<option value="">---</option>
						<?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
						<option value="xyadd.php?page=<?php echo $goPage; ?>&id=<?php echo $sid; ?>"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
                  </select>-->
	</td>
  </tr>
</table>
<?
}
?></div>
<div style="text-align:center">
<input type="button" name="button" id="button" value="显示或者隐藏预约内容" onclick="javascript:if(getElementById('xyaddyc').style.display==''){getElementById('xyaddyc').style.display='none';}else{getElementById('xyaddyc').style.display=''}" /></div><br />
<form id="form1" name="form1" method="post" action="?add=yes">
  <table width="85%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
    <tr style="display:none;" bgcolor="#FFFFFF">
    <td align="center">性别修改检测:</td>
    <td colspan="5" align="left">&nbsp;对年级的修改：<?php echo $classData['jiance'];?>&nbsp;&nbsp;对区域的修改：<?php echo $classData['jiance2'];?></td>
  </tr>
    <tr>
      <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>备注:</strong></td>
      <td height="30" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF"><textarea name="beizhu" cols="60" rows="5" id="beizhu"><?php echo $classData['beizhu'];?></textarea></td>
    </tr>
    <tr>
      <td width="10%" height="30" align="center" bgcolor="#f9f9f9"><b>学员编号：</b></td>
      <td width="24%" bgcolor="#FFFFFF"><?php echo $classData['id'];?>
       <input name="lang" type="hidden" id="lang" value="<?php if($classData['lang']==""){echo $Lang;}else{echo $classData['lang'];}?>" />   <input name="username" type="hidden" id="username" value="<?php echo $_SESSION['username'];?>" />     </td>
      <td width="10%" align="center" bgcolor="#f9f9f9"><b>姓名：</b></td>
      <td width="24%" bgcolor="#FFFFFF"><input name="name" type="text" id="name" value="<?php echo $classData['name'];?>" /></td>
      <td width="9%" align="center" bgcolor="#f9f9f9"><b>发布时间：</b></td>
      <td width="23%" bgcolor="#FFFFFF"><input name="addtime" id="addtime" value="<?php if(empty($classData['addtime'])){echo date("Y-m-d H:i:s", mktime()); }else{ echo $classData['addtime']; } ?>" /></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>学员年级：</b></td>
      <td bgcolor="#FFFFFF"><select name="xynj" id="xynj">
        <option value="" <?php if(empty($classData['xynj'])){echo 'selected="selected"';} ?>>--请选择--</option>
        <?php
$dir=$diaoquData["nianji"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
        <option value="<?php echo $split_dir[$i];?>" <?php 
			  if($classData['xynj']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
        <?php
}
			  ?>
      </select>
	  	  </td>
      <td align="center" bgcolor="#f9f9f9"><b>学员性别：</b></td>
      <td bgcolor="#FFFFFF">
	                                 <select name="xysex">
									 <option <?php if($classData['xysex']==""){echo "selected='selected'";}?> value="">--请选择--</option>
										<option <?php if($classData['xysex']=="男"){echo "selected='selected'";}?> value="男">男</option>
										<option <?php if($classData['xysex']=="女"){echo "selected='selected'";}?> value="女">女</option>
                                     </select>	  </td>
      <td align="center" bgcolor="#f9f9f9"><b>求教科目：</b></td>
      <td bgcolor="#FFFFFF"><input name="qjkm" type="text" id="qjkm" value="<?php echo $classData['qjkm'];?>"/></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>所在区域：</b></td>
      <td bgcolor="#FFFFFF"><select name="szqy" id="szqy">
        <option value="" <?php if(empty($classData['szqy'])){echo 'selected="selected"';} ?>>--请选择--</option>
        <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
        <option value="<?php echo $split_dir[$i];?>" <?php 
			  if($classData['szqy']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
        <?php
}
			  ?>
      </select>
	  </td>
      <td align="center" bgcolor="#f9f9f9"><strong style="color:#F00;">是否显示：</strong></td>
      <td bgcolor="#FFFFFF"><select name="isshow">
        <!--<option  value="">--请选择--</option>-->
        <option <?php if($classData['isshow']=="2"){echo "selected='selected'";}?> value="2">是</option>
        <option <?php if($classData['isshow']=="" || $classData['isshow']=="1"){echo "selected='selected'";}?> value="1">否</option>
      </select></td>
      <td align="center" bgcolor="#f9f9f9"><strong>发布人：</strong></td>
      <td bgcolor="#FFFFFF"><?php echo $classData['username'];?></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>学员类型：</b></td>
      <td bgcolor="#FFFFFF"><select name="xylx">
        <option <?php if($classData['xylx']==""){echo "selected='selected'";}?> value="">--请选择--</option>
        <option <?php if($classData['xylx']=="零基础"){echo "selected='selected'";}?> value="零基础">零基础</option>
        <option <?php if($classData['xylx']=="补差型"){echo "selected='selected'";}?> value="补差型">补差型</option>
        <option <?php if($classData['xylx']=="提高型"){echo "selected='selected'";}?> value="提高型">提高型</option>
        <option <?php if($classData['xylx']=="拔尖型"){echo "selected='selected'";}?> value="拔尖型">拔尖型</option>
      </select></td>
      <td align="center" bgcolor="#f9f9f9"><b style="color:#FF0000">首页推荐：</b></td>
      <td bgcolor="#FFFFFF">
	                                <select name="sftj">
									<!-- <option <?php if($classData['sftj']==""){echo "selected='selected'";}?> value="">--请选择--</option>-->
										<option <?php if($classData['sftj']=="" || $classData['sftj']=="1"){echo "selected='selected'";}?> value="1">是</option>
										<option <?php if($classData['sftj']=="0"){echo "selected='selected'";}?> value="0">否</option>
        </select>	  </td>
      <td align="center" bgcolor="#f9f9f9"><b style="color:#FF0000">是否会员：</b></td>
      <td bgcolor="#FFFFFF">
	                                 <select name="sfhy">
									<!-- <option <?php if($classData['sfhy']==""){echo "selected='selected'";}?> value="">--请选择--</option>-->
										<option <?php if($classData['sfhy']=="1"){echo "selected='selected'";}?> value="1">是</option>
										<option <?php if($classData['sfhy']=="" || $classData['sfhy']=="0"){echo "selected='selected'";}?> value="0">否</option>
                                     </select>	  </td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>学员信息来源：</b></td>
      <td bgcolor="#FFFFFF">
	  <select name="xyxxly" id="xyxxly">
<option value="">----请选择----</option>
          <?php
$dir=$diaoquData["xyxxly"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
          <option value="<?php echo $split_dir[$i];?>" <?php 
			  if($classData['xyxxly']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
              <?php
}
			  ?>
      </select>	  </td>
      <td align="center" bgcolor="#f9f9f9"><b style="color:#FF0000">状态：</b></td>
      <td bgcolor="#FFFFFF">
	                                 <select name="zt">
										<!--<option <?php if($classData['zt']==""){echo "selected='selected'";}?> value="">--请选择--</option>-->
										<option <?php if($classData['zt']=="" || $classData['zt']=="未安排"){echo "selected='selected'";}?> value="未安排">未安排</option>
										<option <?php if($classData['zt']=="正在试教"){echo "selected='selected'";}?> value="正在试教">正在试教</option>
                                     </select>	</td>
      <td align="center" bgcolor="#FFFFFF"><b style="color:#FF0000">到期时间：</b></td>
      <td bgcolor="#FFFFFF">
	  <input type="text" value="<?php echo $classData['dqsj']; ?>" name="dqsj" id="dqsj" onfocus="showCalendar(this)" style="width:100px;" readonly/>
<!--<input name="dqsj" type="text" class="INPUT" id="dqsj"  value="<?php if ($classData['dqsj']=="")
{
  $Date_1=date("Y-m-d");
  print $Date_1;
}
  else
{

  print  date("Y-m-d",strtotime($classData['dqsj']));
} ?>" size="16" readonly="true"><img src="Images/icon_calender.gif" width="23" height="21" style="cursor:hand" onClick="showDatePicker(document.all.dqsj)">--></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>报酬：</b></td>
      <td bgcolor="#FFFFFF"><input name="bcs" type="text" id="bcs" value="<?php echo $classData['bcs'];?>"/></td>
      <td align="center" bgcolor="#f9f9f9"><strong>会员费：</strong></td>
      <td bgcolor="#FFFFFF"><input name="hyf" type="text" id="hyf" value="<?php if(empty($classData['hyf'])){echo "0";}else{echo $classData['hyf'];}?>"/></td>
      <td align="center" bgcolor="#f9f9f9"><b>信息费：</b></td>
      <td bgcolor="#FFFFFF"><input name="xxf" type="text" id="xxf" value="<?php echo $classData['xxf'];?>"/></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>学员状况：</b></td>
      <td colspan="5" bgcolor="#FFFFFF"><textarea name="xyzk" cols="60" rows="5" id="xyzk"><?php echo $classData['xyzk'];?></textarea></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>授课安排：</b></td>
      <td colspan="5" bgcolor="#FFFFFF"><textarea name="skap" cols="60" rows="5" id="skap"><?php echo $classData['skap'];?></textarea></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>联系电话：</b></td>
      <td colspan="5" bgcolor="#FFFFFF"><input name="tel" type="text" id="tel" size="80" value="<?php echo $classData['tel'];?>"/></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>详细地址：</b></td>
      <td colspan="5" bgcolor="#FFFFFF"><input name="adds" type="text" id="adds" size="80" value="<?php echo $classData['adds'];?>"/></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>公汽路线：</b></td>
      <td colspan="5" bgcolor="#FFFFFF"><input name="gqlx" type="text" id="gqlx" size="80" value="<?php echo $classData['gqlx'];?>"/></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b style="color:#ff621a">教员要求：</b></td>
      <td colspan="5" bgcolor="#FFFFFF">&nbsp;<input name="id" type="hidden" id="id" value="<?php echo $classData['id'];?>"/><input name="memo" type="hidden" id="memo" value="<?php echo $classData['memo'];?>"/></td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>性别要求：</b></td>
      <td colspan="5" bgcolor="#FFFFFF">
	                                 <select name="jysex">
									    <option <?php if($classData['jysex']==""){echo "selected='selected'";}?> value="不限">--不限--</option>
										<option <?php if($classData['jysex']=="男"){echo "selected='selected'";}?> value="男">男</option>
										<option <?php if($classData['jysex']=="女"){echo "selected='selected'";}?> value="女">女</option>
                                     </select>	  </td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>资格要求：</b></td>
      <td colspan="5" bgcolor="#FFFFFF"><!--<textarea name="zgyq" cols="60" rows="5" id="zgyq"><?php echo $classData['zgyq'];?></textarea>-->
	                <select name="zgyq" id="zgyq">
					        <option <?php  if($classData['zgyq']==""){echo "selected='selected'";}?> value="">选择类型</option>
							<option <?php  if($classData['zgyq']==1){echo "selected='selected'";}?> value="1">大学生</option>
							<option <?php  if($classData['zgyq']==2){echo "selected='selected'";}?> value="2">职业教师</option>
							<option <?php  if($classData['zgyq']==3){echo "selected='selected'";}?> value="3">留学、海归</option>
							<option <?php  if($classData['zgyq']==5){echo "selected='selected'";}?> value="5">明星在职教师</option>
							<option <?php  if($classData['zgyq']==6){echo "selected='selected'";}?> value="6">明星大学生</option>
					  <option <?php  if($classData['zgyq']==4){echo "selected='selected'";}?> value="4">其他</option>
                    </select>	  </td>
    </tr>
    <tr>
      <td height="30" align="center" bgcolor="#f9f9f9"><b>其他要求：</b></td>
      <td colspan="5" bgcolor="#FFFFFF"><label>
        <textarea name="qtyq" cols="60" rows="5" id="qtyq"><?php echo $classData['qtyq'];?></textarea>
      </label></td>
    </tr>
	<tr>
      <td height="30" colspan="6" align="center" bgcolor="#f9f9f9"><label>
        <input type="submit" name="Submit" value="提交" />&nbsp;&nbsp;
        <input type="reset" name="Submit2" value="重置" />
      </label></td>
    </tr>
  </table>
</form>
<div style="text-align:center">
  <input type="submit" name="button2" id="button2" value="短信发送显示或隐藏" onclick="javascript:if(getElementById('ycduanxin').style.display==''){getElementById('ycduanxin').style.display='none';}else{getElementById('ycduanxin').style.display=''}" />
</div>
<iframe id="ycduanxin" src="sendsms_qun.php?act=k" width="100%" height="620" frameborder="0" style="display:none;"></iframe>
</body>
</html>