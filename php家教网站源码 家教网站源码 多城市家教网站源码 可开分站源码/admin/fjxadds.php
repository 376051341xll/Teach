<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
		$diaoquData = $bw->selectOnly('*', 'bw_config', 'lang="'.$Lang.'"', '');
		if( $_GET['act']=="k")
	{
		$_SESSION['wherefj']="";
		}
    if(empty($_GET["id"]))
	{
	htqx("13_2");
	}else{
	htqx("13_3");
		 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加基本信息</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
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
if($action == 'insert')
{   
    $content=$_POST["content"];
	$xxlx=$_POST["xxlx"];
	$title=$_POST["title"];
	if(trim($_POST["uid"])==''){
		$bw->msg("请输入教员编号");
	} else{
		$split_dir = split ('[,.-]', $_POST["uid"]); //返回一個Array,你可以用for讀出來
		if(count($split_dir)==1)
		{
			$sql = "insert into bw_zxwdhf(uid,content,title,xxlx,addtime,lang) values(".$_POST["uid"].",'".$content."','".$title."',".$xxlx.",'".date("Y-m-d H:i:s")."','".$Lang."')";	
			die($sql);
				//die($sql);	 
			mysql_query($sql);
			$bw->msg("发送成功");
		}elseif(count($split_dir)>1){
			//die($_POST["uid"]);
			for($i=0;$i<count($split_dir);$i++)
			{  
				if($i==0) $values = "(".$split_dir[$i].",'".$content."','".$title."',".$xxlx.",'".date("Y-m-d H:i:s")."','".$Lang."')";
				else $values .= ",(".$split_dir[$i].",'".$content."','".$title."',".$xxlx.",'".date("Y-m-d H:i:s")."','".$Lang."')";
				
			}
			if($values!=''){
				$sql = "insert into bw_zxwdhf(uid,content,title,xxlx,addtime,lang) values".$values;
				//die($sql );
				mysql_query($sql); 
				$bw->msg("发送成功");
			} else 
				$bw->msg("请输入正确的教员编号");

		}
	}
}
?>
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
  &nbsp;  <input type="submit" value="搜索" /></td>
</form>
</tr>
</table>
<form action="?action=insert" method="post">
<table width="788" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right">主题:</td>
    <td>&nbsp;</td>
    <td><input name="title" class="textBox" id="title" />
    </td>
  </tr>
  <tr style='display:none;'>
    <td align="right">信息类型</td>
    <td>&nbsp;</td>
    <td>
    <select name="xxlx" id="xxlx">
        <option value="1">单条信息</option>
        <option value="2">群发信息</option>
    </select>
    </td>
  </tr>
  <tr>
    <td align="right">教员编号</td>
    <td>&nbsp;</td>
    <td>
    <textarea name="uid" cols="60" rows="5" id="uid"><?php
if(!empty($_GET['action']) && $_GET['action'] == 'search'){
$tbName  = "bw_member";
$where   = '1=1 and dxjs =1 and lang="'.$Lang.'"  ';
	  if(!empty($_POST['keyword']) && !empty($_POST['guanjianlei']))
	  {
		$where = $where." and ".$_POST['guanjianlei']." LIKE '%".$_POST['keyword']."%'";
		$_SESSION['wherefj'] = $where;
	  }
	  if(!empty($_POST['sex']))
	  {
		$where = $where." and sex= '".$_POST['sex']."'";
		$_SESSION['wherefj'] = $where;
	  }
	  if(!empty($_POST['sex']))
	  {
		$where = $where." and sex= '".$_POST['sex']."'";
		$_SESSION['wherefj'] = $where;
	  }
	  if(!empty($_POST['diqu']))
	  {
		$where = $where." and quyu like '%".$_POST['diqu']."%'";
		$_SESSION['wherefj'] = $where;
	  }
	  if(!empty($_POST['leixing']))
	  {
		$where = $where." and levels =".$_POST['leixing'];
		$_SESSION['wherefj'] = $where;
	  }
	  if($_POST['xiang']==1)
	  {
		$where = $where." and ifrz =1";
		$_SESSION['wherefj'] = $where;
	  }
	  if($_POST['xiang']==2)
	  {
		$where = $where." and ifrz =2";
		$_SESSION['wherefj'] = $where;
	  }
	  if($_POST['xiang']==3)
	  {
		$where = $where." and iffb =1";
		$_SESSION['wherefj'] = $where;
	  }
	  if($_SESSION['wherefj']=="")
	  {
		  $_SESSION['wherefj'] = $where;
	  }
 // die($_SESSION['wheredx']);
$classList = $bw->selectMany("id,telphone",$tbName,$_SESSION['wherefj'],"`id` desc");
$menu_sum = count($classList);
for($i = 0; $i<$menu_sum; $i++)
{
?>
<?php echo $classList[$i]['id'];?>
<?php
if($i!=$menu_sum-1){
echo ",";
}
?>
<?php
}
}
?></textarea>
    </td>
  </tr>
  <tr>
    <td align="right">内容:</td>
    <td>&nbsp;</td>
    <td><textarea name="content" class="editor" id="content"></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" class="subBtn" value=" 提 交 " />&nbsp;<input type="reset" class="subBtn" value=" 重 置 " /></td>
  </tr>
</table>
</form>
</body>
</html>