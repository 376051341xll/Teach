<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	if(empty($_GET["id"]))
	{
	htqx("4.2");
	}else{
	htqx("4.3");
		 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加基本信息</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" src="ckeditor/ckeditor.js"></script>
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
		if($bw->insert('bw_zfbz', $_POST))
		{
			$bw->msg('新增成功!', 'zfbzlist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		//update($tbName, $post, $where)
		if($bw->update('bw_zfbz', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'zfbzlist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$baseData = $bw->selectOnly('*', 'bw_zfbz', 'id = '.$_GET['id'], '');
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			var classId = $("#classId > option");
			classId.each(function(e){
				if(classId.eq(e).attr("value") == <?php echo $classId; ?>)
				{
					classId.eq(e).attr("selected", true);	
				}
			});
		});
	</script>
	<?php
}
?>
<form action="?action=insert" method="post">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="132" align="right">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $baseData['id']; ?>" />
	<input name="lang" type="hidden" id="lang" value="<?php if($baseData['lang']==""){echo $Lang;}else{echo $baseData['lang'];}?>" />
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
    <td><textarea name="content" id="content"><?php echo $baseData['content']; ?></textarea>
  <script type="text/javascript">
 CKEDITOR.replace( 'content',
 {
 	filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
 	filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
 	filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
 	filebrowserUploadUrl : 
 	   'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
 	filebrowserImageUploadUrl : 
 	   'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
 	filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
 } 
 );
</script></td>
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