<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加产品信息</title>
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
		
		if(!empty($_FILES['smallpic']['name']))
		{
			$fileName = $bw->upload('../upload/smallpic/',204800,'smallpic');
			if($fileName)
			{
				$_POST['smallpic'] = $fileName;
			}
		}
		if(!empty($_FILES['bigpic']['name']))
		{
			$fileName = $bw->upload('../upload/bigpic/',204800,'bigpic');
			if($fileName)
			{
				$_POST['bigpic'] = $fileName;
			}
		}
		//insert($tbName, $post)
		if($bw->insert('bw_product', $_POST))
		{
			$bw->msg('新增成功!', 'prolist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		if(!empty($_FILES['smallpic']['name']))
		{
			$fileName = $bw->upload('../upload/smallpic/',204800,'smallpic');
			if($fileName)
			{
				$_POST['smallpic'] = $fileName;
			}
		}
		if(!empty($_FILES['bigpic']['name']))
		{
			$fileName = $bw->upload('../upload/bigpic/',204800,'bigpic');
			if($fileName)
			{
				$_POST['bigpic'] = $fileName;
			}
		}
		//update($tbName, $post, $where)
		if($bw->update('bw_product', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'prolist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$proData = $bw->selectOnly('*', 'bw_product', 'id = '.$_GET['id'], '');
	$classId = $proData['classId'];
	$levels  = $proData['levels'];
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
<form action="?action=insert" method="post" enctype="multipart/form-data">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="145" align="right">&nbsp;</td>
    <td width="11">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $proData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">产品名称:</td>
    <td>&nbsp;</td>
    <td><input name="name" class="textBox" id="name" value="<?php echo $proData['name']; ?>" />
    &nbsp;级别:&nbsp;
    <select name="levels" id="levels">
    	<option value="1">普通产品</option>
        <option value="2">热卖产品</option>
        <option value="3">最新产品</option>
        <option value="4">特价产品</option>
        <option value="5">礼盒包装</option>
    </select>
   </td>
  </tr>
  <tr>
    <td align="right">产品编号:</td>
    <td>&nbsp;</td>
    <td><input name="number" class="textBox" id="number" value="<?php if(empty($proData['number'])){echo mktime();}else{echo $proData['number'];} ?>" maxlength="50" /></td>
  </tr>
  <tr>
    <td align="right">所属分类:</td>
    <td>&nbsp;</td>
    <td>
    	<select name="classId" id="classId">
        <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_productclass', "lang = 'cn'", 'id DESC', '');
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
    <td align="right">价格:</td>
    <td>&nbsp;</td>
    <td><input name="price" class="textBox" id="price" value="<?php if(empty($proData['price'])){echo 0;}else{echo $proData['price'];} ?>" maxlength="10" /></td>
  </tr>
  <tr>
    <td align="right">重量:</td>
    <td>&nbsp;</td>
    <td><input name="zhongliang" class="textBox" id="zhongliang" value="<?php if(empty($proData['zhongliang'])){echo 0;}else{echo $proData['zhongliang'];} ?>" maxlength="10" /></td>
  </tr>
  <tr>
    <td align="right">产品等级:</td>
    <td>&nbsp;</td>
    <td><input name="exp" class="textBox" id="exp" value="<?php echo $proData['exp']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">产品规格:</td>
    <td>&nbsp;</td>
    <td><input name="guige" class="textBox" id="guige" value="<?php echo $proData['guige']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">产品缩略图:</td>
    <td>&nbsp;</td>
    <td><input type="file" name="smallpic" class="textBox" id="smallpic" value="<?php echo $proData['smallpic']; ?>" />
    宽150px 高107px</td>
  </tr>
  <tr>
    <td align="right">产品高清图:</td>
    <td>&nbsp;</td>
    <td><input type="file" name="bigpic" class="textBox" id="bigpic" value="<?php echo $proData['bigpic']; ?>" />
    宽393px 高328px</td>
  </tr>
  <tr>
    <td align="right">发布时间:</td>
    <td>&nbsp;</td>
    <td><input name="subTime" class="textBox" id="subTime" value="<?php if(empty($proData['subTime'])){echo date("Y-m-d H:i:s", mktime()); }else{ echo $proData['subTime']; } ?>" /></td>
  </tr>
  <tr>
    <td align="right">详细信息:</td>
    <td>&nbsp;</td>
    <td><textarea name="content" class="editor" id="content"><?php echo $proData['content']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">收藏次数:</td>
    <td>&nbsp;</td>
    <td><input name="shoucan" class="textBox" id="shoucan" value="<?php if(empty($proData['shoucan'])){echo 0;}else{echo $proData['shoucan'];} ?>" maxlength="10" /></td>
  </tr>
  <tr>
    <td align="right">点击量:</td>
    <td>&nbsp;</td>
    <td><input name="hits" class="textBox" id="hits" value="<?php if(empty($proData['hits'])){echo 0;}else{echo $proData['hits'];} ?>" maxlength="10" /></td>
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