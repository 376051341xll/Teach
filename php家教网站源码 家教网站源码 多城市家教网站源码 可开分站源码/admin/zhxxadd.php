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
	$id = $_POST['id'];
	if(empty($id))
	{
		unset($_POST['id']);
		//insert($tbName, $post)
		if($bw->insert('bw_exhibition', $_POST))
		{
			$bw->msg('新增成功!', 'zhxxlist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		//update($tbName, $post, $where)
		if($bw->update('bw_exhibition', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'zhxxlist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$newsData = $bw->selectOnly('*', 'bw_exhibition', 'id = '.$_GET['id'], '');
	$classId  = $newsData['classId'];
	$levels    = $newsData['levels'];
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
<form action="?action=insert" method="post">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="132" align="right">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $newsData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">新闻标题:</td>
    <td>&nbsp;</td>
    <td><input name="title" class="textBox" id="title" value="<?php echo $newsData['title']; ?>" />
    &nbsp;级别:&nbsp;
    <select name="levels" id="levels">
    	<option value="1">普通新闻</option>
        <option value="2">推荐新闻</option>
    </select>
   </td>
  </tr>
  <tr>
    <td align="right">所属分类:</td>
    <td>&nbsp;</td>
    <td>
    	<select name="classId" id="classId">
        <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_exhibitionclass', "lang = 'cn'", 'id DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
        <option value="<?php echo $list[$i]['id']; ?>"><?php echo $list[$i]['className']; ?></option>
        <?php
			}
		?>
       	</select>
    </td>
  </tr>
  <tr>
    <td align="right">新闻作者:</td>
    <td>&nbsp;</td>
    <td><input name="author" class="textBox" id="author" value="<?php if(empty($newsData['author'])){ echo $_SESSION['username'];}else{echo $newsData['author']; } ?>" /></td>
  </tr>
  <tr>
    <td align="right">新闻来源:</td>
    <td>&nbsp;</td>
    <td><input name="froms" class="textBox" id="froms" value="<?php if(empty($newsData['from'])){ echo '本站';}else{ echo $newsData['froms']; } ?>" /></td>
  </tr>
  <tr>
    <td align="right">发布时间:</td>
    <td>&nbsp;</td>
    <td><input name="subTime" class="textBox" id="subTime" value="<?php if(empty($newsData['subTime'])){echo date("Y-m-d H:i:s", mktime()); }else{ echo $newsData['subTime']; } ?>" /></td>
  </tr>
  <tr>
    <td align="right">信息内容:</td>
    <td>&nbsp;</td>
    <td><textarea name="content" class="editor" id="content"><?php echo $newsData['content']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">点击量:</td>
    <td>&nbsp;</td>
    <td><input name="hits" class="textBox" id="hits" value="<?php if(empty($newsData['hits'])){echo 0;}else{echo $newsData['hits'];} ?>" /></td>
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