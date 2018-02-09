<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
	if(!empty($_GET['id']))
	{
		htqx("9.3");
	}else{
		htqx("9.2");
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加广告信息</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
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
		//update($tbName, $post, $where)
		if(!empty($_FILES['pic']['name']))
		{
			$fileName = $bw->upload('../upload/ad/',2048000,'pic');
			if($fileName)
			{
				$_POST['pic'] = $fileName;
			}
		}
		//print_r($_POST);
		//exit;
		if($bw->insert('bw_ad', $_POST))
		{
			$bw->msg('新增成功!', 'adlist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		if(!empty($_FILES['pic']['name']))
		{
			$adData = $bw->selectOnly('pic' ,'bw_ad', 'id = '.$_POST['id']);
            if(!empty($adData["pic"]))
			{
				unlink($adData["pic"]);
				}
			$fileName = $bw->upload('../upload/ad/',2048000,'pic');
			if($fileName)
			{
				$_POST['pic'] = $fileName;
			}
		}
		//update($tbName, $post, $where)
		if($bw->update('bw_ad', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'adlist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$adData = $bw->selectOnly('*', 'bw_ad', 'id = '.$_GET['id'], '');
	$isshow = $adData['isshow'];
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			var radio = $(":radio");
			radio.each(function(e){
				if(radio.eq(e).attr("value") == <?php echo $isshow; ?>)
				{
					radio.eq(e).attr("checked", true);	
				}
			});
		});
	</script>
	<?php
}
?>
<form name="insertForm" action="?action=insert" enctype="multipart/form-data" method="post">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="132" align="right">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $adData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">标题:</td>
    <td>&nbsp;</td>
    <td><input name="title" class="textBox" id="title" value="<?php echo $adData['title']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">规格说明:</td>
    <td>&nbsp;</td>
    <td><input name="picsm" class="textBox" id="picsm" value="<?php echo $adData['picsm']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">上传广告图片:</td>
    <td>&nbsp;</td>
    <td><input type="file" name="pic" class="textBox" id="pic" /></td>
  </tr>
   <tr>
    <td align="right">图片链接:</td>
    <td>&nbsp;</td>
    <td><input name="url" class="textBox" id="url" value="<?php echo $adData['url']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">是否启用:</td>
    <td>&nbsp;</td>
    <td>&nbsp;<input name="isshow" type="radio" value="1" checked="checked" />是&nbsp;<input name="isshow" type="radio" value="2" />否</td>
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