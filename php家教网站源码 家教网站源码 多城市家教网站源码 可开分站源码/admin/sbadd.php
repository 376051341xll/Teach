<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="information-Type" information="text/html; charset=utf-8" />
<title>增加基本信息</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="editor/xheditor-zh-cn.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $('#information').xheditor({tools:'Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,Align,List,Outdent,Indent,|,Link,Unlink,Img,|,Source',skin:'o2007silver',upBtnText:"上传",html5Upload:"true",upMultiple:"99",upLinkUrl:"{editorRoot}uploadTxt.php",upLinkExt:"zip,rar,txt,pdf",upImgUrl:"{editorRoot}uploadImg.php",upImgExt:"jpg,jpeg,gif,png"});
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
		if(!empty($_FILES['pic']['name']))
		{
			$fileName = $bw->upload('../upload/sb/',204800,'pic');
			if($fileName)
			{
				$_POST['pic'] = $fileName;
			}
		}
		if($bw->insert('bw_usersb', $_POST))
		{
			$bw->msg('新增成功!', 'sblist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		//update($tbName, $post, $where)
		if($bw->update('bw_usersb', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'sblist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$sbData = $bw->selectOnly('*', 'bw_usersb', 'id = '.$_GET['id']);
?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(":radio").each(function(e){
				if($(":radio").eq(e).attr("value") == <?php echo $sbData['isshow']; ?>)
				{
					$(":radio").eq(e).attr("checked", true);	
				}
			});						   
		});
	</script>
<?php
}
?>
<form action="?action=insert" enctype="multipart/form-data" method="post">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="132" align="right">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $sbData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">姓名:</td>
    <td>&nbsp;</td>
    <td><input name="name" class="textBox" id="name" value="<?php echo $sbData['name']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">个人形象:</td>
    <td>&nbsp;</td>
    <td><input type="file" name="pic" class="textBox" id="pic" value="<?php echo $sbData['pic']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">人物简介:</td>
    <td>&nbsp;</td>
    <td><textarea name="information" class="editor" id="information"><?php echo $sbData['information']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">是否显示:</td>
    <td>&nbsp;</td>
    <td><input type="radio" name="isshow" id="isshow" value="1" checked="checked" />是&nbsp;<input type="radio" name="isshow" id="isshow" value="2" />否</td>
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