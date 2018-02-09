<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	$diaoquData = $bw->selectOnly('*', 'bw_config', 'lang="'.$Lang.'"', '');
	if(empty($_GET["id"]))
	{
	htqx("5.2");
	}else{
	htqx("5.3");
		 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加新闻信息</title>
<link rel="stylesheet" type="text/css" href="css/css.css" /><script language=javascript src="js/wpCalendar.js"></script>
<style>
table{margin:12px auto; border:0px solid #EAF4FD;}
table tr td{margin:12px auto; border:1px solid #EAF4FD;}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="editor/xheditor-zh-cn.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $('#content').xheditor({tools:'Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,Align,List,Outdent,Indent,|,Link,Unlink,Img,|,Source',skin:'o2007silver',upBtnText:"上传",html5Upload:"true",upMultiple:"99",upLinkUrl:"{editorRoot}uploadTxt.php",upLinkExt:"zip,rar,txt,pdf",upImgUrl:"{editorRoot}uploadImg.php",upImgExt:"jpg,jpeg,gif,png"});
	});
</script>
</head>

<body>
<?php
$action = $_GET['action'];
$pages=$_GET['page'];//翻页用的
if($action == 'insert')
{
	$id = $_POST['id'];
	if(empty($id))
	{
		//insert($tbName, $post)
		if($bw->insert('bw_member', $_POST))
		{
			$bw->msg('新增成功!', 'memberlist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
	
	//检测管理员是否改变性别
	$jcData = $bw->selectOnly('sex', 'bw_member', 'id='.$id.'', '');
	if($_POST['sex']!=$jcData["sex"]){
	$sql1 = "update bw_member set jiance2='".$_POST['sex'].'时间：'.date("y-m-d H:i:s")."' where id=".$id."";
	//die($sql1);
	$bw->query($sql1);
	}
	
	
	$pages = $_POST['pages'];//翻页用的
	unset($_POST['pages']);//翻页用的
		//update($tbName, $post, $where)
		//die($_POST["kskqy"]);
		if(!empty($_POST["kskqy"]))
		{
		foreach ($_POST["kskqy"] as &$value) {
    	$abc = $abc.$value.",";
			}
			$_POST["kskqy"]=$abc;
		}
		//die($_POST["kskqy"]);
		if(!empty($_POST["kfdfs"]))
		{
		foreach ($_POST["kfdfs"] as &$value) {
    	$abcd = $abcd.$value.",";
			}
			$_POST["kfdfs"]=$abcd;
		}
		//die($_POST["kfdfs"]);
		if(empty($_POST["daoqi"])){
		    unset($_POST['daoqi']);
		}
		$_POST["kjskm"]=str_replace(",,",",",$_POST["kjskm"]);
		$_POST["kjskm"]=str_replace("，",",",$_POST["kjskm"]);
		if(substr($_POST["kjskm"],0,1)==",")
		{
		$_POST["kjskm"]=substr($_POST["kjskm"],1);
		}
		if(substr($_POST["kjskm"],-1)==",")
		{
		$_POST["kjskm"]=substr($_POST["kjskm"],0,-1);
		}
		$_POST["kskqy"]=str_replace(",,",",",$_POST["kskqy"]);
		$_POST["kskqy"]=str_replace("，",",",$_POST["kskqy"]);
		if(substr($_POST["kskqy"],0,1)==",")
		{
		$_POST["kskqy"]=substr($_POST["kskqy"],1);
		}
		if(substr($_POST["kskqy"],-1)==",")
		{
		$_POST["kskqy"]=substr($_POST["kskqy"],0,-1);
		}
		$_POST["kfdfs"]=str_replace(",,",",",$_POST["kfdfs"]);
		$_POST["kfdfs"]=str_replace("，",",",$_POST["kfdfs"]);
		if(substr($_POST["kfdfs"],0,1)==",")
		{
		$_POST["kfdfs"]=substr($_POST["kfdfs"],1);
		}
		if(substr($_POST["kfdfs"],-1)==",")
		{
		$_POST["kfdfs"]=substr($_POST["kfdfs"],0,-1);
		}
		if($_POST["iffb"]=="")
		{
			$_POST["iffb"]=1;
			}
		if($_POST["ifzc"]=="")
		{
			$_POST["ifzc"]=1;
			}
		if($_POST["iftj"]=="")
		{
			$_POST["iftj"]=1;
			}
		if($bw->update('bw_member', $_POST, 'id = '.$_POST['id']))
		{
		//die("memberlist.php?page='".$pages."'");
			$bw->msg('更新成功!', 'memberlist.php?page='.$pages.'');
		}else{
			$bw->msg('更新失败!', 'memberlist.php?page='.$pages.'', true);
		}
	}
}

//查询
$id=$_GET['id'];
if(!empty($_GET['id']))
{
	$newsData = $bw->selectOnly('*', 'bw_member', 'id = '.$_GET['id'], '');
	$sql = "UPDATE bw_member SET ifnew = 0 WHERE id = '".$id."' ";
	$bw->query($sql);
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="membermod.php?page="+thisPage.val()+"&id="+<?php echo $id; ?>;
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
    <td colspan="5"><strong>预约的订单</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>订单ID</strong></td>
    <td align="center"><strong>学员编号</strong></td>
    <td align="center"><strong>学员姓名</strong></td>
    <td align="center"><strong>订单状态</strong></td>
    <td align="center"><strong>时间</strong></td>
  </tr>
  
<?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_order';
				  $where    = 'jyid = '.$id.' and ifdd=1';
				  $hyzxlist = $bw->selectPage("*", $tbName, $where, "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
				  $xyData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$hyzxlist[$hyzxi]['xyid']);
			  ?>
  <tr>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['id'] ;?></td>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['xyid'] ;?></td>
    <td align="center"><?php echo $xyData['name']; ?></td>
    <td align="center">
					<?php if($hyzxlist[$hyzxi]['ddzt']==1 && $hyzxlist[$hyzxi]['ifdd']==2){echo "试教中";}else{echo "未安排";}?> 
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
						<option value="membermod.php?page=<?php echo $goPage; ?>&id=<?php echo $id; ?> target='main'"><?php echo $goPage; ?></option>
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
    <td colspan="5"><strong>该教员家教记录</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>订单ID</strong></td>
    <td align="center"><strong>学员编号</strong></td>
    <td align="center"><strong>学员姓名</strong></td>
    <td align="center"><strong>订单状态</strong></td>
    <td align="center"><strong>时间</strong></td>
  </tr>
  
<?php
				  //selectPage($param,$tbname,$where,$order,$limit)
				  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
				  $pageSize = 20;
				  $tbName   = 'bw_order';
				  $where    = 'jyid = '.$id.' and ifdd=2';
				  $hyzxlist = $bw->selectPage("*", $tbName, $where, "id DESC", $pageSize);
				  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
				  $hyzxsum = count($hyzxlist);
				  for($hyzxi = 0; $hyzxi<$hyzxsum; $hyzxi++)
				  {
				  $xyData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$hyzxlist[$hyzxi]['xyid']);
			  ?>
  <tr>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['id'] ;?></td>
    <td align="center"><?php echo $hyzxlist[$hyzxi]['xyid'] ;?></td>
    <td align="center"><?php echo $xyData['name']; ?></td>
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
						<option value="membermod.php?page=<?php echo $goPage; ?>&id=<?php echo $id; ?> target='main'"><?php echo $goPage; ?></option>
						<?php
						 }
						?>
                  </select>-->
	</td>
  </tr>
</table>
<?
}
?></div><div style="text-align:center">
<input type="button" name="button" id="button" value="显示或者隐藏预约内容" onclick="javascript:if(getElementById('xyaddyc').style.display==''){getElementById('xyaddyc').style.display='none';}else{getElementById('xyaddyc').style.display=''}" /></div>
<form action="?action=insert" method="post" enctype="multipart/form-data">
<?php
//echo $newsData["levels"];
//exit;
if($newsData["levels"]==1)
{
?>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr style="display:none;">
    <td align="right">性别修改检测</td>
    <td colspan="7" align="left">（1是男，2是女）&nbsp;&nbsp;教员自己修改的：<?php echo $newsData['jiance'];?>&nbsp;&nbsp;管理员修改的：<?php echo $newsData['jiance2'];?></td>
  </tr>
  <tr>
    <td align="right"><span style="color:#F00;">备注：</span></td>
    <td colspan="7" align="left"><textarea name="gzjl" id="gzjl" cols="45" rows="5" style="width:100%; line-height:20px;"><?php echo $newsData['gzjl'];?></textarea></td>
  </tr>
  <tr>
    <td align="right"><input type="hidden" name="id" id="id" value="<?php echo $newsData['id']; ?>" />
	<input type="hidden" name="pages" id="pages" value="<?php echo $pages; //翻页用的 ?>" />编号：</td>
    <td><input name="lang" type="hidden" id="lang" value="<?php if($newsData['lang']==""){echo $Lang;}else{echo $newsData['lang'];}?>" /><?php echo $newsData['id']; ?></td>
    <td align="right">会员名：</td>
    <td><?php echo $newsData['username']; ?></td>
    <td align="right">姓名：</td>
    <td><input type="text" name="truename" id="truename" value="<?php echo $newsData['truename']; ?>" /></td>
    <td align="right">性别：</td>
    <td align="left"><select name="sex" id="sex">
      <option value="1" <?php if($newsData['sex']==1)
	  {
		  echo "selected='selected'";
		  }?> >男</option>
      <option value="2" <?php if($newsData['sex']==2)
	  {
		  echo "selected='selected'";
		  }?>>女</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">身份证：</td>
    <td><input name="idcode" type="text"  id="idcode" value="<?php echo $newsData['idcode'];?>" /></td>
    <td align="right">专业：</td>
    <td><input type="text" name="zhuanye" id="zhuanye" value="<?php echo $newsData['zhuanye']; ?>" /></td>
    <td align="right">学校：</td>
    <td><input name="xuexiao" type="text"  id="xuexiao" value="<?php echo $newsData['xuexiao'];?>" /></td>
    <td align="right">学历：</td>
    <td align="left"><select name="xueli" id="xueli">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["xueli"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php 
			  if($newsData['xueli']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
    </select></td>
  </tr>
  <tr>
    <td align="right">省份：</td>
    <td><input type="text" name="csd" id="csd" value="<?php echo $newsData['csd']; ?>" /></td>
    <td align="right">区域：</td>
    <td><select name="quyu" id="quyu">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php
              if($newsData['quyu']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?>><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
    </select></td>
    <td align="right">账户：</td>
    <td><?php echo $newsData['Money']; ?></td>
    <td align="right">电话：</td>
    <td align="left"><input name="telphone" type="text"  id="telphone" value="<?php echo $newsData['telphone'];?>" /></td>
  </tr>
  <tr>
    <td align="right">邮箱：</td>
    <td><input name="email" type="text"  id="email" value="<?php echo $newsData['email'];?>" /></td>
    <td align="right">QQ：</td>
    <td><input name="qq" type="text"  id="qq" value="<?php echo $newsData['qq'];?>" /></td>
    <td align="right">地址：</td>
    <td><input name="address" type="text"  id="address" value="<?php echo $newsData['address'];?>" /></td>
    <td align="right">认证情况：</td>
    <td align="left"><select name="ifrz" id="ifrz">
      <option value="1" <?php
	   if($newsData['ifrz']==1)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >未认证</option>
      <option value="2" <?php
	   if($newsData['ifrz']==2)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >已认证</option>
      <option value="3" <?php
	   if($newsData['ifrz']==3)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >已过期</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">认证到期：</td>
    <td><input type="text" value="<?php echo $newsData['daoqi']; ?>" name="daoqi" id="daoqi" onfocus="showCalendar(this)" style="width:100px;" readonly/></td>
    <td align="right">星级：</td>
    <td><select name="ifxj" id="ifxj">
      <option value="6">请选择</option>
      <option value="1" <?php
        if ($newsData['ifxj']==1)
		{
			echo 'selected="selected"';
			}
		?>>一星级</option>
      <option value="2"  <?php
        if ($newsData['ifxj']==2)
		{
			echo 'selected="selected"';
			}
		?>>二星级</option>
      <option value="3" <?php
        if ($newsData['ifxj']==3)
		{
			echo 'selected="selected"';
			}
		?>>三星级</option>
      <option value="4" <?php
        if ($newsData['ifxj']==4)
		{
			echo 'selected="selected"';
			}
		?>>四星级</option>
      <option value="5" <?php
        if ($newsData['ifxj']==5)
		{
			echo 'selected="selected"';
			}
		?>>五星级</option>
      </select></td>
    <td align="right">是否发布：</td>
    <td><input type="checkbox" name="iffb" id="iffb" value="2" <?php
    if($newsData['iffb']==2)
	{
		echo 'checked="checked"';
		}
	?> />
      打钩代表发布</td>
    <td align="right">目前身份：</td>
    <td align="left"><select name="mqsf" id="mqsf">
      <option value="">----请选择----</option>
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
      </select></td>
  </tr>
  <tr>
    <td align="right">艺术专才：</td>
    <td align="left"><input type="checkbox" name="ifzc" id="ifzc" value="2" <?php
    if($newsData['ifzc']==2)
	{
		echo 'checked="checked"';
		}
	?>  />
      打钩代表是</td>
    <td align="right">推荐首页：</td>
    <td align="left"><input type="checkbox" name="iftj" id="iftj" value="2" <?php
    if($newsData['iftj']==2)
	{
		echo 'checked="checked"';
		}
	?>  />
      打钩代表推荐</td>
    <td align="right">认证人：</td>
    <td align="left"><?php echo $newsData['uname']; ?></td>
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">可教授科目：</td>
    <td colspan="7" align="left"><table width="548" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200" height="200"><select size="30" id="list1" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list2)">
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_userproclass', "parentId=0", 'paixu DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
          <option value="">------<?php echo $list[$i]['className']; ?>--------</option>
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list2 = $bw->selectMany('id, className', 'bw_userproclass', "parentId=".$list[$i]['id'], 'id DESC', '');
			$sum2 = count($list2);
			for($i1 = 0; $i1<$sum2; $i1++)
			{
		?>
          <option value="<?php echo $list2[$i1]['className']; ?>"><?php echo $list2[$i1]['className']; ?></option>
          <?php
			}
			}
		?>
          </select></td>
        <td width="136" align="center"><input type="button" id="button" value=" 增加 &gt;&gt; " onclick="moveOption(this.form.list1, this.form.list2);inputs('list2','kjskm')" />
          <br />
          <span style="color:#F00; text-align:left;">(选中左侧项目点&quot;选取&quot;即可添加；选中右侧项目点 &quot;删除&quot;即可删除)
            <input type="hidden" name="kjskm" id="kjskm" value="<?php echo $newsData['kjskm'];?>" />
            </span> <br />
          <input type="button" id="button2" value=" &lt;&lt; 删除 " onclick="sc(this.form.list2);inputs('list2','kjskm')" /></td>
        <td width="212" align="left"><select size="30" id="list2" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list1)">
          <?php
$dir=$newsData['kjskm'];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><option value="<?php echo $split_dir[$i]?>"><?php echo $split_dir[$i]?></option>
          <?php
}
		  ?>
          </select></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">自我描述：</td>
    <td colspan="7" align="left"><textarea name="zwms"  id="zwms" style="width:100%; height:120px; line-height:20px;"><?php echo $newsData['zwms'];?></textarea></td>
  </tr>
  <tr>
    <td align="right">可授课区域：</td>
    <td colspan="7" align="left"> <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><input name="kskqy[]" type="checkbox" id="kskqy" value="<?php echo $split_dir[$i];?>" <?php
if(strlen(strstr($newsData['kskqy'],$split_dir[$i]))>0)
{
	echo 'checked="checked"';
	}
	//echo $newsData['kskqy'];
?> >
<?php echo $split_dir[$i];?>
              <?php
}
			  ?> </td>
  </tr>
  <tr>
    <td align="right">可辅导方式：</td>
    <td colspan="2" align="left"><input name="kfdfs[]" type="checkbox" id="kfdfs" value="本人上门" <?php
if(strlen(strstr($newsData['kfdfs'],"本人上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
      本人上门
      <input name="kfdfs[]" type="checkbox" id="kfdfs" value="学生上门" <?php
if(strlen(strstr($newsData['kfdfs'],"学生上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
      学生上门</td>
    <td align="right">可授课时间：</td>
    <td colspan="4" align="left"><input name="ksksj" type="text"  id="ksksj" value="<?php echo $newsData['ksksj'];?>" style="width:100%"></td>
    </tr>
  <tr>
    <td align="right">薪水要求：</td>
    <td colspan="7" align="left"><textarea name="xsyq" id="xsyq" cols="45" rows="5" style="width:100%; line-height:20px;"><?php echo $newsData['xsyq'];?></textarea></td>
  </tr>
  <tr>
    <td colspan="8" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="11%">身份证图片：</td>
        <td width="39%" align="left"><?php
		if(!empty($newsData['sfzpic']))
		{
        
		?><a href="<?php echo '../'.$newsData['sfzpic'];?>" target="_blank"><img src="<?php echo '../'.$newsData['sfzpic']; ?>" alt="" height="200" border="0" /></a><?php
		}
		?></td>
        <td width="13%" align="right" valign="middle">毕业证图片：</td>
        <td width="37%" align="left"><?php
		if(!empty($newsData['byzpic']))
		{
        
		?><a href="<?php echo '../'.$newsData['byzpic']; ?>" target="_blank"><img src="<?php echo '../'.$newsData['byzpic']; ?>" height="200" alt="" /></a>
        <?php
		}
		?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">资格证书图片：</td>
    <td colspan="7"><?php
		if(!empty($newsData['zgzspic']))
		{
        
		?><a href="<?php echo '../'.$newsData['zgzspic']; ?>"><img src="<?php echo '../'.$newsData['zgzspic']; ?>" height="200" alt="" /></a><?php
		}
		?></td>
  </tr>
  <tr align="right">
    <td colspan="8" align="center"><input type="submit" class="subBtn" value=" 提 交 " />
&nbsp;
<input type="reset" class="subBtn" value=" 重 置 " /></td>
  </tr>
</table>
<?php
}
if($newsData["levels"]==2)
{
?>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><span style="color:#F00;">备注：</span></td>
    <td colspan="7" align="left"><textarea name="gzjl" id="gzjl" cols="45" rows="5" style="width:100%; line-height:20px;"><?php echo $newsData['gzjl'];?></textarea></td>
  </tr>
  <tr>
    <td align="right">编号：</td>
    <td><?php echo $newsData['id']; ?></td>
    <td align="right">会员名：</td>
    <td><?php echo $newsData['username']; ?> <input name="lang" type="hidden" id="lang" value="<?php if($newsData['lang']==""){echo $Lang;}else{echo $newsData['lang'];}?>" />
      <input type="hidden" name="pages" id="pages" value="<?php echo $pages; //翻页用的 ?>" /></td>
    <td align="right">姓名：</td>
    <td><input type="text" name="truename" id="truename" value="<?php echo $newsData['truename']; ?>" /></td>
    <td align="right">性别：</td>
    <td><select name="sex" id="sex">
      <option value="1" <?php if($newsData['sex']==1)
	  {
		  echo "selected='selected'";
		  }?> >男</option>
      <option value="2" <?php if($newsData['sex']==2)
	  {
		  echo "selected='selected'";
		  }?>>女</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">身份证：</td>
    <td><input name="idcode" type="text"  id="idcode" value="<?php echo $newsData['idcode'];?>" /></td>
    <td align="right">专业：</td>
    <td><input type="text" name="zhuanye" id="zhuanye" value="<?php echo $newsData['zhuanye']; ?>" /></td>
    <td align="right">学校：</td>
    <td><input type="text" name="xuexiao" id="xuexiao" value="<?php echo $newsData['xuexiao']; ?>" /></td>
    <td align="right">学历：</td>
    <td><select name="xueli" id="xueli">
                              <option value="">--请选择--</option>
          <?php
$dir=$diaoquData["xueli"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
          <option value="<?php echo $split_dir[$i];?>" <?php 
			  if($newsData['xueli']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
              <?php
}
			  ?>
      </select></td>
  </tr>
  <tr>
    <td align="right">省份：</td>
    <td><input type="text" name="csd" id="csd" value="<?php echo $newsData['csd']; ?>" /></td>
    <td align="right">区域：</td>
    <td><select name="quyu" id="quyu">
                              <option value="">--请选择--</option>
                                    <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
              <option value="<?php echo $split_dir[$i];?>" <?php
              if($newsData['quyu']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?>><?php echo $split_dir[$i];?></option>
              <?php
}
			  ?>
                            </select></td>
    <td align="right">账户<input type="hidden" name="id" id="id" value="<?php echo $newsData['id']; ?>" />：</td>
    <td><?php echo $newsData['Money']; ?></td>
    <td align="right">电话：</td>
    <td><input name="telphone" type="text"  id="telphone" value="<?php echo $newsData['telphone'];?>" /></td>
  </tr>
  <tr>
    <td align="right">邮箱：</td>
    <td><input name="email" type="text"  id="email" value="<?php echo $newsData['email'];?>" /></td>
    <td align="right">QQ：</td>
    <td><input name="qq" type="text"  id="qq" value="<?php echo $newsData['qq'];?>" /></td>
    <td align="right">地址：</td>
    <td><input name="address" type="text"  id="address" value="<?php echo $newsData['address'];?>" /></td>
    <td align="right">认证情况：</td>
    <td><select name="ifrz" id="ifrz">
      <option value="1" <?php
	   if($newsData['ifrz']==1)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >未认证</option>
      <option value="2" <?php
	   if($newsData['ifrz']==2)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >已认证</option>
      <option value="3" <?php
	   if($newsData['ifrz']==3)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >已过期</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">认证到期：</td>
    <td><input type="text" value="<?php echo $newsData['daoqi']; ?>" name="daoqi" id="daoqi" onfocus="showCalendar(this)" style="width:100px;" readonly/></td>
    <td align="right">星级：</td>
    <td><select name="ifxj" id="ifxj">
        <option value="6">请选择</option>
        <option value="1" <?php
        if ($newsData['ifxj']==1)
		{
			echo 'selected="selected"';
			}
		?>>一星级</option>
        <option value="2"  <?php
        if ($newsData['ifxj']==2)
		{
			echo 'selected="selected"';
			}
		?>>二星级</option>
        <option value="3" <?php
        if ($newsData['ifxj']==3)
		{
			echo 'selected="selected"';
			}
		?>>三星级</option>
        <option value="4" <?php
        if ($newsData['ifxj']==4)
		{
			echo 'selected="selected"';
			}
		?>>四星级</option>
        <option value="5" <?php
        if ($newsData['ifxj']==5)
		{
			echo 'selected="selected"';
			}
		?>>五星级</option>
      </select></td>
    <td align="right">是否发布：</td>
    <td><input type="checkbox" name="iffb" id="iffb" value="2" <?php
    if($newsData['iffb']==2)
	{
		echo 'checked="checked"';
		}
	?> />
打钩代表是</td>
    <td align="right">教龄：</td>
    <td><input name="jiaolin" type="text" id="jiaolin" size="5" maxlength="5" value="<?php echo $newsData['jiaolin']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">目前身份：</td>
    <td><select name="mqsf" id="mqsf">
                              <option value="">----请选择----</option>
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
			  ?></select></td>
    <td align="right">职称等级：</td>
    <td><select name="zhicheng" id="zhicheng">
      <option value="">————请选择————</option>
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
      </select></td>
    <td align="right">任职学校类别：</td>
    <td><select name="rzxxlb" id="rzxxlb">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["leibie"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php
              if($newsData['rzxxlb']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?>><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
      </select></td>
    <td align="right">任教学科：</td>
    <td><input name="rjxk" type="text" id="rjxk" value="<?php echo $newsData['rjxk'];?>"></td>
    </tr>
  <tr>
    <td align="right">艺术专长：</td>
    <td><input type="checkbox" name="ifzc" id="ifzc" value="2" <?php
    if($newsData['ifzc']==2)
	{
		echo 'checked="checked"';
		}
	?>  />
      打钩代表是</td>
    <td align="right">推荐首页：</td>
    <td><input type="checkbox" name="iftj" id="iftj" value="2" <?php
    if($newsData['iftj']==2)
	{
		echo 'checked="checked"';
		}
	?>  />
      打钩代表推荐</td>
    <td align="right">认证人：</td>
    <td><?php echo $newsData['uname']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">可教授科目：</td>
    <td colspan="7" align="left"><table width="548" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200" height="200"><select size="30" id="list1" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list2)">
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_userproclass', "parentId=0", 'paixu DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
          <option value="">------<?php echo $list[$i]['className']; ?>--------</option>
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list2 = $bw->selectMany('id, className', 'bw_userproclass', "parentId=".$list[$i]['id'], 'id DESC', '');
			$sum2 = count($list2);
			for($i1 = 0; $i1<$sum2; $i1++)
			{
		?>
          <option value="<?php echo $list2[$i1]['className']; ?>"><?php echo $list2[$i1]['className']; ?></option>
          <?php
			}
			}
		?>
          </select></td>
        <td width="136" align="center"><input type="button" id="button" value=" 增加 &gt;&gt; " onclick="moveOption(this.form.list1, this.form.list2);inputs('list2','kjskm')" />
          <br />
          <span style="color:#F00; text-align:left;">(选中左侧项目点&quot;选取&quot;即可添加；选中右侧项目点 &quot;删除&quot;即可删除)
            <input type="hidden" name="kjskm" id="kjskm" value="<?php echo $newsData['kjskm'];?>" />
            </span> <br />
          <input type="button" id="button2" value=" &lt;&lt; 删除 " onclick="sc(this.form.list2);inputs('list2','kjskm')" /></td>
        <td width="212" align="left"><select size="30" id="list2" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list1)">
          <?php
$dir=$newsData['kjskm'];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><option value="<?php echo $split_dir[$i]?>"><?php echo $split_dir[$i]?></option>
          <?php
}
		  ?>
          </select></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">自我描述：</td>
    <td colspan="7" align="left"><textarea name="zwms"  id="zwms" style="width:100%; height:120px; line-height:20px;"><?php echo $newsData['zwms'];?></textarea></td>
  </tr>
  <tr>
    <td align="right">可授课区域：</td>
    <td colspan="7" align="left"> <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><input name="kskqy[]" type="checkbox" id="kskqy" value="<?php echo $split_dir[$i];?>" <?php
if(strlen(strstr($newsData['kskqy'],$split_dir[$i]))>0)
{
	echo 'checked="checked"';
	}
	//echo $newsData['kskqy'];
?> >
<?php echo $split_dir[$i];?>
              <?php
}
			  ?> </td>
  </tr>
  <tr>
    <td align="right">可辅导方式：</td>
    <td colspan="2" align="left"><input name="kfdfs[]" type="checkbox" id="kfdfs" value="本人上门" <?php
if(strlen(strstr($newsData['kfdfs'],"本人上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
      本人上门
      <input name="kfdfs[]" type="checkbox" id="kfdfs" value="学生上门" <?php
if(strlen(strstr($newsData['kfdfs'],"学生上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
      学生上门</td>
    <td colspan="2" align="right">可授课时间：</td>
    <td colspan="3" align="left"><input name="ksksj" type="text"  id="ksksj" value="<?php echo $newsData['ksksj'];?>" style="width:100%"></td>
  </tr>
  <tr>
    <td align="right">薪水要求：</td>
    <td colspan="7" align="left"><textarea name="xsyq" id="xsyq" cols="45" rows="5" style="width:100%; line-height:20px;"><?php echo $newsData['xsyq'];?></textarea></td>
  </tr>
  <tr>
    <td colspan="8" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="11%">身份证图片：</td>
        <td width="39%" align="left"><?php
		if(!empty($newsData['sfzpic']))
		{
        
		?><a href="<?php echo '../'.$newsData['sfzpic'];?>" target="_blank"><img src="<?php echo '../'.$newsData['sfzpic']; ?>" alt="" height="200" border="0" /></a><?php
		}
		?></td>
        <td width="13%" align="right" valign="middle">毕业证图片：</td>
        <td width="37%" align="left"><?php
		if(!empty($newsData['byzpic']))
		{
        
		?><a href="<?php echo '../'.$newsData['byzpic']; ?>" target="_blank"><img src="<?php echo '../'.$newsData['byzpic']; ?>" height="200" alt="" /></a>
        <?php
		}
		?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">资格证书图片：</td>
    <td colspan="7"><?php
		if(!empty($newsData['zgzspic']))
		{
        
		?><a href="<?php echo '../'.$newsData['zgzspic']; ?>"><img src="<?php echo '../'.$newsData['zgzspic']; ?>" height="200" alt="" /></a><?php
		}
		?></td>
  </tr>
  <tr align="right">
    <td colspan="8" align="center"><input type="submit" class="subBtn" value=" 提 交 " />
&nbsp;
<input type="reset" class="subBtn" value=" 重 置 " /></td>
  </tr>
</table>
<?php
}
if($newsData["levels"]==3)
{
?>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><span style="color:#F00;">备注：</span></td>
    <td colspan="7" align="left"><textarea name="gzjl" id="gzjl" cols="45" rows="5" style="width:100%; line-height:20px;"><?php echo $newsData['gzjl'];?></textarea></td>
  </tr>
  <tr>
    <td align="right">编号：</td>
    <td><?php echo $newsData['id']; ?><input type="hidden" name="id" id="id" value="<?php echo $newsData['id']; ?>" />
	<input type="hidden" name="pages" id="pages" value="<?php echo $pages; //翻页用的 ?>" /><input name="lang" type="hidden" id="lang" value="<?php if($newsData['lang']==""){echo $Lang;}else{echo $newsData['lang'];}?>" /></td>
    <td align="right">会员名：</td>
    <td><?php echo $newsData['username']; ?></td>
    <td align="right">姓名：</td>
    <td><input type="text" name="truename" id="truename" value="<?php echo $newsData['truename']; ?>" /></td>
    <td align="right">性别：</td>
    <td><select name="sex" id="sex">
      <option value="1" <?php if($newsData['sex']==1)
	  {
		  echo "selected='selected'";
		  }?> >男</option>
      <option value=2 <?php if($newsData['sex']==2)
	  {
		  echo "selected='selected'";
		  }?>>女</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">身份证：</td>
    <td><input name="idcode" type="text"  id="idcode" value="<?php echo $newsData['idcode'];?>" /></td>
    <td align="right">国籍：</td>
    <td><input name="guojia" type="text"  id="guojia" value="<?php echo $newsData['guojia'];?>"></td>
    <td align="right">专业：</td>
    <td><input type="text" name="zhuanye" id="zhuanye" value="<?php echo $newsData['zhuanye']; ?>" /></td>
    <td align="right">学校：</td>
    <td><input name="xuexiao" type="text"  id="xuexiao" value="<?php echo $newsData['xuexiao'];?>" /></td>
  </tr>
  <tr>
    <td align="right">学历：</td>
    <td><select name="xueli" id="xueli">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["xueli"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php 
			  if($newsData['xueli']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
    </select></td>
    <td align="right">省份：</td>
    <td><input type="text" name="csd" id="csd" value="<?php echo $newsData['csd']; ?>" /></td>
    <td align="right">区域：</td>
    <td><select name="quyu" id="quyu">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php
              if($newsData['quyu']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?>><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
    </select></td>
    <td align="right">账户：</td>
    <td><?php echo $newsData['Money']; ?></td>
  </tr>
  <tr>
    <td align="right">电话：</td>
    <td><input name="telphone" type="text"  id="telphone" value="<?php echo $newsData['telphone'];?>" /></td>
    <td align="right">邮箱：</td>
    <td><input name="email" type="text"  id="email" value="<?php echo $newsData['email'];?>" /></td>
    <td align="right">QQ：</td>
    <td><input name="qq" type="text"  id="qq" value="<?php echo $newsData['qq'];?>" /></td>
    <td align="right">地址：</td>
    <td><input name="address" type="text"  id="address" value="<?php echo $newsData['address'];?>" /></td>
  </tr>
  <tr>
    <td align="right">认证情况：</td>
    <td><select name="ifrz" id="ifrz">
      <option value="1" <?php
	   if($newsData['ifrz']==1)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >未认证</option>
      <option value="2" <?php
	   if($newsData['ifrz']==2)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >已认证</option>
      <option value="3" <?php
	   if($newsData['ifrz']==3)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >已过期</option>
      </select></td>
    <td align="right">认证到期：</td>
    <td><input type="text" value="<?php echo $newsData['daoqi']; ?>" name="daoqi" id="daoqi" onfocus="showCalendar(this)" style="width:100px;" readonly/></td>
    <td align="right">星级：</td>
    <td><select name="ifxj" id="ifxj">
      <option value="6">请选择</option>
      <option value="1" <?php
        if ($newsData['ifxj']==1)
		{
			echo 'selected="selected"';
			}
		?>>一星级</option>
      <option value="2"  <?php
        if ($newsData['ifxj']==2)
		{
			echo 'selected="selected"';
			}
		?>>二星级</option>
      <option value="3" <?php
        if ($newsData['ifxj']==3)
		{
			echo 'selected="selected"';
			}
		?>>三星级</option>
      <option value="4" <?php
        if ($newsData['ifxj']==4)
		{
			echo 'selected="selected"';
			}
		?>>四星级</option>
      <option value="5" <?php
        if ($newsData['ifxj']==5)
		{
			echo 'selected="selected"';
			}
		?>>五星级</option>
      </select></td>
    <td align="right">是否发布：</td>
    <td><input type="checkbox" name="iffb" id="iffb" value="2" <?php
    if($newsData['iffb']==2)
	{
		echo 'checked="checked"';
		}
	?> />
      打钩代表是</td>
  </tr>
  <tr>
    <td align="right">目前身份：</td>
    <td><select name="mqsf" id="mqsf">
      <option value="">----请选择----</option>
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
      </select></td>
    <td align="right">艺术专才：</td>
    <td><input type="checkbox" name="ifzc" id="ifzc" value="2" <?php
    if($newsData['ifzc']==2)
	{
		echo 'checked="checked"';
		}
	?>  />
      打钩代表是</td>
    <td align="right">推荐首页：</td>
    <td><input type="checkbox" name="iftj" id="iftj" value="2" <?php
    if($newsData['iftj']==2)
	{
		echo 'checked="checked"';
		}
	?>  />
      打钩代表推荐</td>
    <td align="right">认证人：</td>
    <td><?php echo $newsData['uname']; ?></td>
  </tr>
  <tr>
    <td align="right">可教授科目：</td>
    <td colspan="7" align="left"><table width="548" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200" height="200"><select size="30" id="list1" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list2)">
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_userproclass', "parentId=0", 'paixu DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
          <option value="">------<?php echo $list[$i]['className']; ?>--------</option>
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list2 = $bw->selectMany('id, className', 'bw_userproclass', "parentId=".$list[$i]['id'], 'id DESC', '');
			$sum2 = count($list2);
			for($i1 = 0; $i1<$sum2; $i1++)
			{
		?>
          <option value="<?php echo $list2[$i1]['className']; ?>"><?php echo $list2[$i1]['className']; ?></option>
          <?php
			}
			}
		?>
          </select></td>
        <td width="136" align="center"><input type="button" id="button" value=" 增加 &gt;&gt; " onclick="moveOption(this.form.list1, this.form.list2);inputs('list2','kjskm')" />
          <br />
          <span style="color:#F00; text-align:left;">(选中左侧项目点&quot;选取&quot;即可添加；选中右侧项目点 &quot;删除&quot;即可删除)
            <input type="hidden" name="kjskm" id="kjskm" value="<?php echo $newsData['kjskm'];?>" />
            </span> <br />
          <input type="button" id="button2" value=" &lt;&lt; 删除 " onclick="sc(this.form.list2);inputs('list2','kjskm')" /></td>
        <td width="212" align="left"><select size="30" id="list2" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list1)">
          <?php
$dir=$newsData['kjskm'];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><option value="<?php echo $split_dir[$i]?>"><?php echo $split_dir[$i]?></option>
          <?php
}
		  ?>
          </select></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">自我描述：</td>
    <td colspan="7" align="left"><textarea name="zwms"  id="zwms" style="width:100%; height:120px; line-height:20px;"><?php echo $newsData['zwms'];?></textarea></td>
  </tr>
  <tr>
    <td align="right">可授课区域：</td>
    <td colspan="7" align="left"> <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><input name="kskqy[]" type="checkbox" id="kskqy" value="<?php echo $split_dir[$i];?>" <?php
if(strlen(strstr($newsData['kskqy'],$split_dir[$i]))>0)
{
	echo 'checked="checked"';
	}
	//echo $newsData['kskqy'];
?> >
<?php echo $split_dir[$i];?>
              <?php
}
			  ?> </td>
  </tr>
  <tr>
    <td align="right">可辅导方式：</td>
    <td colspan="2" align="left"><input name="kfdfs[]" type="checkbox" id="kfdfs" value="本人上门" <?php
if(strlen(strstr($newsData['kfdfs'],"本人上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
      本人上门
      <input name="kfdfs[]" type="checkbox" id="kfdfs" value="学生上门" <?php
if(strlen(strstr($newsData['kfdfs'],"学生上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
      学生上门</td>
    <td colspan="2" align="right">可授课时间：</td>
    <td colspan="3" align="left"><input name="ksksj" type="text"  id="ksksj" value="<?php echo $newsData['ksksj'];?>" style="width:100%"></td>
  </tr>
  <tr>
    <td align="right">薪水要求：</td>
    <td colspan="7" align="left"><textarea name="xsyq" id="xsyq" cols="45" rows="5" style="width:100%; line-height:20px;"><?php echo $newsData['xsyq'];?></textarea></td>
  </tr>
  <tr>
    <td colspan="8" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="11%">身份证图片：</td>
        <td width="39%" align="left"><?php
		if(!empty($newsData['sfzpic']))
		{
        
		?><a href="<?php echo '../'.$newsData['sfzpic'];?>" target="_blank"><img src="<?php echo '../'.$newsData['sfzpic']; ?>" alt="" height="200" border="0" /></a><?php
		}
		?></td>
        <td width="13%" align="right" valign="middle">毕业证图片：</td>
        <td width="37%" align="left"><?php
		if(!empty($newsData['byzpic']))
		{
        
		?><a href="<?php echo '../'.$newsData['byzpic']; ?>" target="_blank"><img src="<?php echo '../'.$newsData['byzpic']; ?>" height="200" alt="" /></a>
        <?php
		}
		?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">资格证书图片：</td>
    <td colspan="7"><?php
		if(!empty($newsData['zgzspic']))
		{
        
		?><a href="<?php echo '../'.$newsData['zgzspic']; ?>"><img src="<?php echo '../'.$newsData['zgzspic']; ?>" height="200" alt="" /></a><?php
		}
		?></td>
  </tr>
  <tr align="right">
    <td colspan="8" align="center"><input type="submit" class="subBtn" value=" 提 交 " />
&nbsp;
<input type="reset" class="subBtn" value=" 重 置 " /></td>
  </tr>
</table>
<?php
}
if($newsData["levels"]==4)
{
?>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><span style="color:#F00;">备注：</span></td>
    <td colspan="7" align="left"><textarea name="gzjl" id="gzjl" cols="45" rows="5" style="width:100%; line-height:20px;"><?php echo $newsData['gzjl'];?></textarea></td>
  </tr>
  <tr>
    <td align="right">编号：</td>
    <td><?php echo $newsData['id']; ?><input type="hidden" name="id" id="id" value="<?php echo $newsData['id']; ?>" />
	<input type="hidden" name="pages" id="pages" value="<?php echo $pages; //翻页用的 ?>" /><input name="lang" type="hidden" id="lang" value="<?php if($newsData['lang']==""){echo $Lang;}else{echo $newsData['lang'];}?>" /></td>
    <td align="right">会员名：</td>
    <td><?php echo $newsData['username']; ?></td>
    <td align="right">姓名：</td>
    <td><input type="text" name="truename" id="truename" value="<?php echo $newsData['truename']; ?>" /></td>
    <td align="right">性别：</td>
    <td><select name="sex" id="sex">
      <option value="1" <?php if($newsData['sex']==1)
	  {
		  echo "selected='selected'";
		  }?> >男</option>
      <option value="2" <?php if($newsData['sex']==2)
	  {
		  echo "selected='selected'";
		  }?>>女</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">身份证：</td>
    <td><input name="idcode" type="text"  id="idcode" value="<?php echo $newsData['idcode'];?>" /></td>
    <td align="right">国家：</td>
    <td><input name="guojia" type="text"  id="guojia" value="<?php echo $newsData['guojia'];?>"></td>
    <td align="right">专业：</td>
    <td><input type="text" name="zhuanye" id="zhuanye" value="<?php echo $newsData['zhuanye']; ?>" /></td>
    <td align="right">学校：</td>
    <td><input name="xuexiao" type="text"  id="xuexiao" value="<?php echo $newsData['xuexiao'];?>" /></td>
  </tr>
  <tr>
    <td align="right">学历：</td>
    <td><select name="xueli" id="xueli">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["xueli"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php 
			  if($newsData['xueli']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
    </select></td>
    <td align="right">省份：</td>
    <td><input type="text" name="csd" id="csd" value="<?php echo $newsData['csd']; ?>" /></td>
    <td align="right">区域：</td>
    <td><select name="quyu" id="quyu">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php
              if($newsData['quyu']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?>><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
    </select></td>
    <td align="right">账户：</td>
    <td><?php echo $newsData['Money']; ?></td>
  </tr>
  <tr>
    <td align="right">电话：</td>
    <td><input name="telphone" type="text"  id="telphone" value="<?php echo $newsData['telphone'];?>" /></td>
    <td align="right">邮箱：</td>
    <td><input name="email" type="text"  id="email" value="<?php echo $newsData['email'];?>" /></td>
    <td align="right">QQ：</td>
    <td><input name="qq" type="text"  id="qq" value="<?php echo $newsData['qq'];?>" /></td>
    <td align="right">地址：</td>
    <td><input name="address" type="text"  id="address" value="<?php echo $newsData['address'];?>" /></td>
  </tr>
  <tr>
    <td align="right">认证情况：</td>
    <td><select name="ifrz" id="ifrz">
      <option value="1" <?php
	   if($newsData['ifrz']==1)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >未认证</option>
      <option value="2" <?php
	   if($newsData['ifrz']==2)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >已认证</option>
      <option value="3" <?php
	   if($newsData['ifrz']==3)
	  {
		  echo 'selected="selected"';
		  }
	  ?> >已过期</option>
      </select></td>
    <td align="right">认证到期：</td>
    <td><input type="text" value="<?php echo $newsData['daoqi']; ?>" name="daoqi" id="daoqi" onfocus="showCalendar(this)" style="width:100px;" readonly/></td>
    <td align="right">星级：</td>
    <td><select name="ifxj" id="ifxj">
      <option value="6">请选择</option>
      <option value="1" <?php
        if ($newsData['ifxj']==1)
		{
			echo 'selected="selected"';
			}
		?>>一星级</option>
      <option value="2"  <?php
        if ($newsData['ifxj']==2)
		{
			echo 'selected="selected"';
			}
		?>>二星级</option>
      <option value="3" <?php
        if ($newsData['ifxj']==3)
		{
			echo 'selected="selected"';
			}
		?>>三星级</option>
      <option value="4" <?php
        if ($newsData['ifxj']==4)
		{
			echo 'selected="selected"';
			}
		?>>四星级</option>
      <option value="5" <?php
        if ($newsData['ifxj']==5)
		{
			echo 'selected="selected"';
			}
		?>>五星级</option>
      </select></td>
    <td align="right">是否发布：</td>
    <td><input type="checkbox" name="iffb" id="iffb" value="2" <?php
    if($newsData['iffb']==2)
	{
		echo 'checked="checked"';
		}
	?> />
      打钩代表是</td>
  </tr>
  <tr>
    <td align="right">目前身份：</td>
    <td><input type="text" name="mqsf" id="mqsf" style="width:120px;" value="<?php echo $newsData['mqsf'];?>"></td>
    <td align="right">艺术专长：</td>
    <td><input type="checkbox" name="ifzc" id="ifzc" value="2" <?php
    if($newsData['ifzc']==2)
	{
		echo 'checked="checked"';
		}
	?>  />
      打钩代表是</td>
    <td align="right">推荐首页：</td>
    <td><input type="checkbox" name="iftj" id="iftj" value="2" <?php
    if($newsData['iftj']==2)
	{
		echo 'checked="checked"';
		}
	?>  />
      打钩代表推荐</td>
    <td align="right">认证人：</td>
    <td><?php echo $newsData['uname']; ?></td>
  </tr>
  <tr>
    <td align="right">可教授科目：</td>
    <td colspan="7" align="left"><table width="548" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200" height="200"><select size="30" id="list1" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list2)">
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_userproclass', "parentId=0", 'paixu DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
          <option value="">------<?php echo $list[$i]['className']; ?>--------</option>
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list2 = $bw->selectMany('id, className', 'bw_userproclass', "parentId=".$list[$i]['id'], 'id DESC', '');
			$sum2 = count($list2);
			for($i1 = 0; $i1<$sum2; $i1++)
			{
		?>
          <option value="<?php echo $list2[$i1]['className']; ?>"><?php echo $list2[$i1]['className']; ?></option>
          <?php
			}
			}
		?>
          </select></td>
        <td width="136" align="center"><input type="button" id="button" value=" 增加 &gt;&gt; " onclick="moveOption(this.form.list1, this.form.list2);inputs('list2','kjskm')" />
          <br />
          <span style="color:#F00; text-align:left;">(选中左侧项目点&quot;选取&quot;即可添加；选中右侧项目点 &quot;删除&quot;即可删除)
            <input type="hidden" name="kjskm" id="kjskm" value="<?php echo $newsData['kjskm'];?>" />
            </span> <br />
          <input type="button" id="button2" value=" &lt;&lt; 删除 " onclick="sc(this.form.list2);inputs('list2','kjskm')" /></td>
        <td width="212" align="left"><select size="30" id="list2" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list1)">
          <?php
$dir=$newsData['kjskm'];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><option value="<?php echo $split_dir[$i]?>"><?php echo $split_dir[$i]?></option>
          <?php
}
		  ?>
          </select></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">自我描述：</td>
    <td colspan="7" align="left"><textarea name="zwms"  id="zwms" style="width:100%; height:120px; line-height:20px;"><?php echo $newsData['zwms'];?></textarea></td>
  </tr>
  <tr>
    <td align="right">可授课区域：</td>
    <td colspan="7" align="left"> <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><input name="kskqy[]" type="checkbox" id="kskqy" value="<?php echo $split_dir[$i];?>" <?php
if(strlen(strstr($newsData['kskqy'],$split_dir[$i]))>0)
{
	echo 'checked="checked"';
	}
	//echo $newsData['kskqy'];
?> >
<?php echo $split_dir[$i];?>
              <?php
}
			  ?> </td>
  </tr>
  <tr>
    <td align="right">可辅导方式：</td>
    <td colspan="2" align="left"><input name="kfdfs[]" type="checkbox" id="kfdfs" value="本人上门" <?php
if(strlen(strstr($newsData['kfdfs'],"本人上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
      本人上门
      <input name="kfdfs[]" type="checkbox" id="kfdfs" value="学生上门" <?php
if(strlen(strstr($newsData['kfdfs'],"学生上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
      学生上门</td>
    <td colspan="2" align="right">可授课时间：</td>
    <td colspan="3" align="left"><input name="ksksj" type="text"  id="ksksj" value="<?php echo $newsData['ksksj'];?>" style="width:100%"></td>
  </tr>
  <tr>
    <td align="right">薪水要求：</td>
    <td colspan="7" align="left"><textarea name="xsyq" id="xsyq" cols="45" rows="5" style="width:100%; line-height:20px;"><?php echo $newsData['xsyq'];?></textarea></td>
  </tr>
  <tr>
    <td colspan="8" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="11%">身份证图片：</td>
        <td width="39%" align="left"><?php
		if(!empty($newsData['sfzpic']))
		{
        
		?><a href="<?php echo '../'.$newsData['sfzpic'];?>" target="_blank"><img src="<?php echo '../'.$newsData['sfzpic']; ?>" alt="" height="200" border="0" /></a><?php
		}
		?></td>
        <td width="13%" align="right" valign="middle">毕业证图片：</td>
        <td width="37%" align="left"><?php
		if(!empty($newsData['byzpic']))
		{
        
		?><a href="<?php echo '../'.$newsData['byzpic']; ?>" target="_blank"><img src="<?php echo '../'.$newsData['byzpic']; ?>" height="200" alt="" /></a>
        <?php
		}
		?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right">资格证书图片：</td>
    <td colspan="7"><?php
		if(!empty($newsData['zgzspic']))
		{
        
		?><a href="<?php echo '../'.$newsData['zgzspic']; ?>"><img src="<?php echo '../'.$newsData['zgzspic']; ?>" height="200" alt="" /></a><?php
		}
		?></td>
  </tr>
  <tr align="right">
    <td colspan="8" align="center"><input type="submit" class="subBtn" value=" 提 交 " />
&nbsp;
<input type="reset" class="subBtn" value=" 重 置 " /></td>
  </tr>
</table>
<?php
}
?>
</form>
<script language="JavaScript"><!--
function moveOption(e1, e2){
		 a=1;
     try{
         var e = e1.options[e1.selectedIndex];
		  for (i=0;i<e2.length;i++) {
			if(e2.options[i].value==e.value)
			{
				a=2
				}  
		  }
		  if (a==1&&e.value.length!=0)
		  {
			// alert(e.value.length)
         e2.options.add(new Option(e.text, e.value));
		  }
     }    catch(e){}
}
     function sc(e1)
	 {
         var e = e1.options[e1.selectedIndex];
		 e1.options.remove(e1.selectedIndex);
		 }	
	 function inputs(a,b){
    var aa,bb;
    aa=document.getElementById(a);
     document.getElementById(b).value="";
    for (i=0;i<aa.length;i++) {
	 bb=document.getElementById(b).value+",";	
     document.getElementById(b).value=bb+aa.options[i].value;
     //alert(aa.options[i].value);
    }
   }
//--></script>
<div style="text-align:center">
  <input type="submit" name="button2" id="button2" value="短信发送显示或隐藏" onclick="javascript:if(getElementById('ycduanxin').style.display==''){getElementById('ycduanxin').style.display='none';}else{getElementById('ycduanxin').style.display=''}" />
</div>
<iframe id="ycduanxin" src="sendsms_qun.php?act=k" width="100%" height="620" frameborder="0" style="display:none;"></iframe>
</body>
</html>