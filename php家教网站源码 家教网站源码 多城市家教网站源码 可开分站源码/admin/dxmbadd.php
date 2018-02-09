<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	if(empty($_GET["id"]))
	{
	htqx("14_2");
	}else{
	htqx("14_3");
		 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加基本信息</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<!--<script type="text/javascript" src="editor/xheditor-zh-cn.min.js"></script>-->
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
	$id = $_POST['id'];
	if(empty($id))
	{
		unset($_POST['id']);
		//insert($tbName, $post)
		if($bw->insert('bw_dxmb', $_POST))
		{
			$bw->msg('新增成功!', 'dxmblist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		//update($tbName, $post, $where)
		if($bw->update('bw_dxmb', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'dxmblist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$baseData = $bw->selectOnly('*', 'bw_dxmb', 'id = '.$_GET['id'], '');
	?>
	<?php
}
?>
<form action="?action=insert" method="post">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="132" align="right">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $baseData['id']; ?>" />
	<input name="addtime" id="addtime" type="hidden" value="<?php if(empty($baseData['addtime'])){echo date("Y-m-d H:i:s", mktime()); }else{ echo $baseData['addtime']; } ?>" /><input name="lang" type="hidden" id="lang" value="<?php if($baseData['lang']==""){echo $Lang;}else{echo $baseData['lang'];}?>" />
	</td>
  </tr>
  <tr>
    <td align="right">信息标题:</td>
    <td>&nbsp;</td>
    <td><input name="title" class="textBox" id="title" value="<?php echo $baseData['title']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">内容信息:</td>
    <td>&nbsp;</td>
    <td><textarea name="content" class="editor" id="content"><?php echo $baseData['content']; ?></textarea></td>
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