<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
	if(empty($_GET["id"]))
	{
	htqx("12_2");
	}else{
	htqx("12_3");
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
	
	if(!empty($_FILES['pic']['name']))
	{
		$fileName = $bw->upload('../upload/friends/',204800,'pic');
		if($fileName)
		{
			$_POST['pic'] = $fileName;
		}
	}
	//die($_POST['pic']);
	
	if(empty($id))
	{
		unset($_POST['id']);
		//insert($tbName, $post)
		if($bw->insert('bw_friendlink', $_POST))
		{
			$bw->msg('新增成功!', 'linklist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		//update($tbName, $post, $where)
		if($bw->update('bw_friendlink', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'linklist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$linkData = $bw->selectOnly('*', 'bw_friendlink', 'id = '.$_GET['id'], '');
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
    <td width="132" align="right">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $linkData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">链接类型:</td>
    <td>&nbsp;</td>
    <td><input type="radio" name="type" id="type" value="1" <?php if($linkData['type']==1){echo "checked='checked'";}?> />文字链接<input type="radio" name="type" id="type" value="2" <?php if($linkData['type']==2){echo "checked='checked'";}?>/>图片链接</td>
  </tr>
  <tr>
    <td align="right">所属分类:</td>
    <td>&nbsp;</td>
    <td><input type="radio" name="classId" id="classId" value="1" checked="checked" />友情链接<input type="radio" name="classId" id="classId" value="2" />品牌企业<input type="radio" name="classId" id="classId" value="3" />支持单位</td>
  </tr>
  <tr>
    <td align="right">链接标题:</td>
    <td>&nbsp;</td>
    <td><input name="title" class="textBox" id="title" value="<?php echo $linkData['title']; ?>" /></td>
  </tr>
  <tr id="ispic">
    <td align="right">链接图片:</td>
    <td>&nbsp;</td>
    <td><input type="file" name="pic" class="textBox" id="pic" value="<?php echo $linkData['pic']; ?>" /><span class="msg">*图片大小173宽56高 (px)</span></td>
  </tr>
  <tr>
    <td align="right">链接url:</td>
    <td>&nbsp;</td>
    <td><input name="url" class="textBox" id="url" value="<?php echo $linkData['url']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">是否启用:</td>
    <td>&nbsp;</td>
    <td>&nbsp;<input name="isshow" type="radio" value="1" <?php if($linkData['isshow']==1){echo "checked='checked'";}?> />是&nbsp;<input name="isshow" type="radio" value="2" <?php if($linkData['isshow']==2){echo "checked='checked'";}?>  />否</td>
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