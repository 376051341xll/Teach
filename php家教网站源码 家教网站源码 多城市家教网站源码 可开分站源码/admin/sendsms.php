<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	$diaoquData = $bw->selectOnly('*', 'bw_config', 'lang="'.$Lang.'"', '');
		if( $_GET['act']=="k")
	{
		$_SESSION['wheredx']="";
		}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>短信发送DEMO</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="editor/xheditor-zh-cn.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $('#content').xheditor({tools:'Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,Align,List,Outdent,Indent,|,Link,Unlink,Img,|,Source',skin:'o2007silver',upBtnText:"上传",html5Upload:"true",upMultiple:"99",upLinkUrl:"{editorRoot}uploadTxt.php",upLinkExt:"zip,rar,txt,pdf",upImgUrl:"{editorRoot}uploadImg.php",upImgExt:"jpg,jpeg,gif,png"});
	});
</script>
<style>
td{
font-size:12px;}
</style>
<script>
function check()
{
	if(document.formSend.mobile.value=="")
	{
		alert("请输入手机号！");
		document.formSend.mobile.focus();
		return false;
	}
	if(document.formSend.content.value=="")
	{
		alert("内容为空");
		document.formSend.content.focus();
		return false;
	}
}
</script>
</head>

<body>
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td align="center">关键字:
  <select name="guanjianlei" id="guanjianlei">
      <option value="">关键字类型</option>
      <option value="id">教员编号</option>
      <option value="kjskm">授课科目</option>
      <option value="xuexiao">毕业/就读高校</option>
      <option value="telphone">电话</option>
      <option value="truename">姓名</option>
      <option value="zhuanye">专业</option>
  </select>
  <input name="keyword" id="keyword" />&nbsp;
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
  <select name="xiang" id="xiang">
    <option value="">所有教员</option>
    <option value="1">待认证</option>
    <option value="2">已认证</option>
    <option value="3">未发布</option>
  </select>
  短信模板:
        <select name="mb" id="mb">
            <option value="">————请选择————</option>
		<?php
			$classList = $bw->selectMany("id,title","bw_dxmb","lang='".$Lang."'","`id` DESC");
			$menu_sum = count($classList);
			for($i = 0; $i<$menu_sum; $i++)
			{
		?>
            <option value="<?php echo $classList[$i]['id'];?>"><?php echo $classList[$i]['title'];?></option>
		<?php
			}
		?>
        </select>
  &nbsp;  <input type="submit" value="搜索" /></td>
</form>
</tr>
</table>
<table width="1000" height="343" align="center">
<form action="send_action.php" method="post" name="formSend" class="STYLE3" onSubmit="return check()">
<tr>
  <td width="242" height="3"></td>
  <td width="700"></td>
  <td width="207"></td>
</tr>
<tr>
  <td></td>
  <td width="700"><div align="center" >短信发送</div></td>
  <td></td>
</tr>
<tr>
  <td height="93" align="right">手机号：</td>
  <td colspan="2" valign="middle">
<textarea name="mobile" cols="60" rows="5"><?php
if(!empty($_GET['action']) && $_GET['action'] == 'search'){
$tbName  = "bw_member";
$where   = '1=1 and dxjs =1 and lang="'.$Lang.'"  ';
	  if(!empty($_POST['keyword']) && !empty($_POST['guanjianlei']))
	  {
		$where = $where." and ".$_POST['guanjianlei']." LIKE '%".$_POST['keyword']."%'";
		$_SESSION['wheredx'] = $where;
	  }
	  if(!empty($_POST['sex']))
	  {
		$where = $where." and sex= '".$_POST['sex']."'";
		$_SESSION['wheredx'] = $where;
	  }
	  if(!empty($_POST['sex']))
	  {
		$where = $where." and sex= '".$_POST['sex']."'";
		$_SESSION['wheredx'] = $where;
	  }
	  if(!empty($_POST['diqu']))
	  {
		$where = $where." and quyu like '%".$_POST['diqu']."%'";
		$_SESSION['wheredx'] = $where;
	  }
	  if(!empty($_POST['leixing']))
	  {
		$where = $where." and levels =".$_POST['leixing'];
		$_SESSION['wheredx'] = $where;
	  }
	  if($_POST['xiang']==1)
	  {
		$where = $where." and ifrz =1";
		$_SESSION['wheredx'] = $where;
	  }
	  if($_POST['xiang']==2)
	  {
		$where = $where." and ifrz =2";
		$_SESSION['wheredx'] = $where;
	  }
	  if($_POST['xiang']==3)
	  {
		$where = $where." and iffb =1";
		$_SESSION['wheredx'] = $where;
	  }
	  if($_SESSION['wheredx']=="")
	  {
		  $_SESSION['wheredx'] = $where;
	  }
 // die($_SESSION['wheredx']);
$classList = $bw->selectMany("id,telphone",$tbName,$_SESSION['wheredx'],"`id` desc");
$menu_sum = count($classList);
for($i = 0; $i<$menu_sum; $i++)
{
?>
<?php echo $classList[$i]['telphone'];?>
<?php
if($i!=$menu_sum-1){
echo ",";
}
?>
<?php
}
}
?></textarea>多个手机号，用英文逗号隔开</td>
  </tr>
<tr>
  <td height="93" align="right">内&nbsp;&nbsp;&nbsp;&nbsp;容：</td>
  <td colspan="2"><textarea name="content" class="editor" id="content" cols="40" rows="5"><?php
if(!empty($_GET['action']) && $_GET['action'] == 'search' && $_POST['mb']!=""){
$dxmbData = $bw->selectOnly('*' ,'bw_dxmb', 'id = '.$_POST['mb']);
echo $dxmbData ['content'];
}
?></textarea></td>
  </tr>
<tr>
  <td></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td></td>
  <td>&nbsp;</td>
  <td></td>
</tr>
<tr>
  <td></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="send" type="submit" value="发送">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="reset" type="reset" value="重置"></td>
  <td></td>
</tr>
</form>
</table>
</body>
</html>