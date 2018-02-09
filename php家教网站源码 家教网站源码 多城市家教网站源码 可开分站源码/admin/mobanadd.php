<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
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
	  
	  
	  var type = $("input[name = type ]");
	  type.click(function(){
			if(type.eq(1).attr("checked") == true)
			{
				$("#ispic").show();
			}else{
				$("#ispic").hide();	
			}
	  });
	  
	});
</script>
<style type="text/css">
#ispic{display:none;}
</style>
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
			if(!empty($_FILES['pic']["name"]))
			{
				$fileName = $bw->upload('../upload/moban/',204800,'pic');
				//die($fileName);
				if($fileName)
				{
					$_POST['pic'] = $fileName;
				}
				//die($_POST['pic'])
			}
		if($bw->insert('bw_moban', $_POST))
		{
			$bw->msg('新增成功!', 'mobanlist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		//update($tbName, $post, $where)
			if(!empty($_FILES['pic']["name"]))
			{
				$fileName = $bw->upload('../upload/moban/',204800,'pic');
				//die($fileName);
				if($fileName)
				{
					$_POST['pic'] = $fileName;
				}
				//die($_POST['pic'])
			}else{
				$linkData = $bw->selectOnly('pic', 'bw_moban', 'id = '.$_POST['id'], '');
					$_POST['pic'] = $linkData["pic"];
				}
		if($bw->update('bw_moban', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'mobanlist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$linkData = $bw->selectOnly('*', 'bw_moban', 'id = '.$_GET['id'], '');
	$isshow = $linkData['isshow'];
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
<form action="?action=insert" method="post" enctype="multipart/form-data">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="261" align="right">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td width="521">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $linkData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td><span style="color:#F00;">请先把文件传到根目录template文件夹下</span></td>
  </tr>
  <tr>
    <td align="right">模板名称:</td>
    <td>&nbsp;</td>
    <td><input name="title" class="textBox" id="title" value="<?php echo $linkData['title']; ?>" /></td>
  </tr>
  <tr >
    <td align="right">模板图片:</td>
    <td>&nbsp;</td>
    <td><input type="file" name="pic" class="textBox" id="pic" value="<?php echo $linkData['pic']; ?>" /><span class="msg">*图片大小192宽65高 (px)</span></td>
  </tr>
  <tr>
    <td align="right">模板地址:</td>
    <td>&nbsp;</td>
    <td><input name="weizhi" class="textBox" id="weizhi" value="<?php echo $linkData['weizhi']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">是否启用:</td>
    <td>&nbsp;</td>
    <td>&nbsp;<input name="isshow" type="radio" value="1"  <?php if ($isshow==1)
	{
		echo "checked";
		}
		else
		{ 
		if(empty($isshow))
		{
		echo "checked";
		}
			}
	 ?> />是&nbsp;<input name="isshow" type="radio" value="0" <?php if ($isshow==0&&!empty($isshow))
	{
		echo "checked";
		}
	 ?>/>否
      <input type="hidden" name="addtime" id="addtime" value="<?php echo date("Y-m-d H:i:s");?>" /></td>
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