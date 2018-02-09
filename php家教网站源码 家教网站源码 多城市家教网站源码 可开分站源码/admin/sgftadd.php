<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加信息信息</title>
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
	$id = $_POST['id'];
	if(empty($id))
	{
		unset($_POST['id']);
		//insert($tbName, $post)
		if(!empty($_POST['pic']))
		{
			$fileName = $bw->upload('../upload/sgsc/',204800,'pic');
			if($fileName)
			{
				$_POST['pic'] = $fileName;
			}
		}
		if($bw->insert('bw_h2o', $_POST))
		{
			$bw->msg('新增成功!', 'sgftlist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		
		//update($tbName, $post, $where)
		if(!empty($_FILES['pic']['name']))
		{
			$xwData = $bw->selectOnly('pic' ,'bw_h2o', 'id = '.$_POST['id']);
            if(!empty($xwData["pic"]))
			{
				unlink($xwData["pic"]);
				}
			$fileName = $bw->upload('../upload/sgsc/',204800,'pic');
			if($fileName)
			{
				$_POST['pic'] = $fileName;
			}
		}
		if($bw->update('bw_h2o', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'sgftlist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$sgftData = $bw->selectOnly('*', 'bw_h2o', 'id = '.$_GET['id'], '');
	$levels    = $sgftData['levels'];
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			var level = $("#levels > option");
			level.each(function(e){
				if(level.eq(e).attr("value") == <?php echo $levels; ?>)
				{
					level.eq(e).attr("selected", true);	
				}
			});
		});
	</script>
	<?php
}
?>
<form action="?action=insert" method="post" enctype="multipart/form-data">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="132" align="right">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $sgftData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">信息标题:</td>
    <td>&nbsp;</td>
    <td><input name="title" class="textBox" id="title" value="<?php echo $sgftData['title']; ?>" />
    &nbsp;级别:&nbsp;
    <select name="levels" id="levels">
    	<option value="1">普通信息</option>
        <option value="2">推荐信息</option>
    </select>
   </td>
  </tr>
  <tr>
    <td align="right">信息作者:</td>
    <td>&nbsp;</td>
    <td><input name="author" class="textBox" id="author" value="<?php if(empty($sgftData['author'])){ echo $_SESSION['username'];}else{echo $sgftData['author']; } ?>" /></td>
  </tr>
  <tr>
    <td align="right">图 &nbsp;&nbsp;&nbsp;&nbsp;片：</td>
    <td>&nbsp;</td>
    <td><input type="file" name="pic" id="pic" /></td>
  </tr>
  <tr>
    <td align="right">信息来源:</td>
    <td>&nbsp;</td>
    <td><input name="froms" class="textBox" id="froms" value="<?php if(empty($sgftData['from'])){ echo '本站';}else{ echo $sgftData['froms']; } ?>" /></td>
  </tr>
  <tr>
    <td align="right">发布时间:</td>
    <td>&nbsp;</td>
    <td><input name="subTime" class="textBox" id="subTime" value="<?php if(empty($sgftData['subTime'])){echo date("Y-m-d H:i:s", mktime()); }else{ echo $sgftData['subTime']; } ?>" /></td>
  </tr>
  <tr>
    <td align="right">信息内容:</td>
    <td>&nbsp;</td>
    <td><textarea name="content" class="editor" id="content"><?php echo $sgftData['content']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">点击量:</td>
    <td>&nbsp;</td>
    <td><input name="hits" class="textBox" id="hits" value="<?php if(empty($sgftData['hits'])){echo 0;}else{echo $sgftData['hits'];} ?>" /></td>
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