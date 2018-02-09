<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加新闻信息</title>
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
     if(empty($_POST["iftj"]))
	 {
		 $_POST["iftj"]=0;
		 }
	$id = $_POST['id'];
	if(empty($id))
	{
		//insert($tbName, $post)
		$sqlstr="insert into bw_diaocha(title,Atitle,Btitle,Ctitle,Dtitle,Etitle,iftj,addtime) values('".$_POST["title"]."','".$_POST["Atitle"]."','".$_POST["Btitle"]."','".$_POST["Ctitle"]."','".$_POST["Dtitle"]."','".$_POST["Etitle"]."','".$_POST["iftj"]."','".date("Y-m-d H:i:s")."')";
		//die($sqlstr);
	$bw->query($sqlstr);	
	$bw->msg('新增成功!', 'wjdclist.php');
	}else{
		//update($tbName, $post, $where)

		if($bw->update('bw_diaocha', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'wjdclist.php');
		}else{
			$bw->msg('更新失败!', 'wjdclist.php', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$newsData = $bw->selectOnly('*', 'bw_diaocha', 'id = '.$_GET['id'], '');
}
?>
<form action="?action=insert" method="post" enctype="multipart/form-data">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="171" align="right">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td width="611">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $newsData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">问卷标题:</td>
    <td>&nbsp;</td>
    <td><input name="title" class="textBox" id="title" value="<?php echo $newsData['title']; ?>" style="width:500px;" />
      &nbsp; </td>
  </tr>
  <tr>
    <td align="right">A选项:</td>
    <td>&nbsp;</td>
    <td><input name="Atitle" class="textBox" id="Atitle" value="<?php echo $newsData['Atitle'];?>" style="width:500px;" /></td>
  </tr>
  <tr>
    <td align="right">B选项:</td>
    <td>&nbsp;</td>
    <td><input name="Btitle" class="textBox" id="Btitle" value="<?php echo $newsData['Btitle'];?>"  style="width:500px;"/></td>
  </tr>
  <tr>
    <td align="right">C选项:</td>
    <td>&nbsp;</td>
    <td><input name="Ctitle" class="textBox" id="Ctitle" value="<?php echo $newsData['Ctitle'];?>"  style="width:500px;"/></td>
  </tr>
  <tr>
    <td align="right">D选项:</td>
    <td>&nbsp;</td>
    <td><input name="Dtitle" class="textBox" id="Dtitle" value="<?php echo $newsData['Dtitle'];?>"  style="width:500px;"/></td>
  </tr>
  <tr>
    <td align="right">E选项:</td>
    <td>&nbsp;</td>
    <td><input name="Etitle" class="textBox" id="Etitle" value="<?php echo $newsData['Etitle'];?>"  style="width:500px;"/></td>
  </tr>
  <tr>
    <td align="right">是否推荐</td>
    <td>&nbsp;</td>
    <td><input name="iftj" type="checkbox" id="iftj" value="1"  <?php
    if($newsData['iftj']==1)
	{
		echo "checked";
		}
	?>/>
      <span style="color:#F00;">（打钩代表推荐）</span></td>
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