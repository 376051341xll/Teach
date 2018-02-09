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
<script type="text/javascript" src="js/jquery.js"></script><script language=javascript src="js/wpCalendar.js"></script>
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
		//insert($tbName, $post)
		if($bw->insert('bw_hygg', $_POST))
		{
			$bw->msg('新增成功!', 'hygglist.php');
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		//update($tbName, $post, $where)
$hyggData = $bw->selectOnly('*', 'bw_hygg', 'id = '.$_POST['id'], '');
		if($hyggData["zhuangtai"]!=2&&$_POST["zhuangtai"]==2)
		{
			$userData = $bw->selectOnly('*', 'bw_member', "username = '{$_POST['username']}'");
			$bw->jifen($userData["id"],"广告申请成功","-".$_POST["jifen"],"扣除".$_POST['username'].$_POST["jifen"]."积分");
		}
		if($bw->update('bw_hygg', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'hygglist.php');
		}else{
			$bw->msg('更新失败!', 'hygglist.php', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$hyggData = $bw->selectOnly('*', 'bw_hygg', 'id = '.$_GET['id'], '');
}
?>
<form action="?action=insert" method="post" enctype="multipart/form-data">
  <table width="719" height="565" cellpadding="0" cellspacing="0">
    <tr>
      <td height="36" align="right">申请会员：</td>
      <td height="36">&nbsp;</td>
      <td height="36"><input name="username" class="textBox" id="username" value="<?php echo $hyggData["username"];?>" /></td>
    </tr>
    <tr>
      <td width="245" height="36" align="right">广告位置：</td>
      <td width="10" height="36">&nbsp;</td>
      <td width="468" height="36"><input name="title" class="textBox" id="title" value="<?php echo $hyggData["title"];?>" style="width:280px;" /></td>
    </tr>
    <tr>
      <td width="245" height="36" align="right">联系电话：</td>
      <td width="10" height="36">&nbsp;</td>
      <td width="468" height="36"><input name="lianxi" class="textBox" id="lianxi" value="<?php echo $hyggData["lianxi"];?>" /></td>
    </tr>
    <tr>
      <td height="36" align="right">处理状态：</td>
      <td height="36">&nbsp;</td>
      <td height="36"><select name="zhuangtai" id="zhuangtai">
        <option value="1" <?php 
		if($hyggData["zhuangtai"]==1)
		{
			echo "selected";
			}
		?>>申请中</option>
        <option value="2" <?php 
		if($hyggData["zhuangtai"]==2)
		{
			echo "selected";
			}
		?>>已处理</option>
        <option value="3" <?php 
		if($hyggData["zhuangtai"]==3)
		{
			echo "selected";
			}
		?>>已过期</option>
      </select></td>
    </tr>
    <tr>
      <td height="36" align="right">需要积分：</td>
      <td height="36">&nbsp;</td>
      <td height="36"><input name="jifen" class="textBox" id="jifen" value="<?php echo $hyggData["jifen"];?>" /></td>
    </tr>
    <tr>
      <td height="36" align="right">申请时间：</td>
      <td height="36">&nbsp;</td>
      <td height="36"><input name="addtime" class="textBox" id="addtime" value="<?php echo $hyggData["addtime"];?>" onfocus="showCalendar(this)" /></td>
    </tr>
    <tr>
      <td width="245" height="36" align="right">开始日期：</td>
      <td width="10" height="36">&nbsp;</td>
      <td width="468" height="36"><input name="kaishi" class="textBox" id="kaishi" value="<?php echo $hyggData["kaishi"];?>" onfocus="showCalendar(this)"/></td>
    </tr>
    <tr>
      <td width="245" height="36" align="right">结束日期：</td>
      <td width="10" height="36">&nbsp;</td>
      <td width="468" height="36"><input name="daoqi" class="textBox" id="daoqi" value="<?php echo $hyggData["daoqi"];?>"  onfocus="showCalendar(this)"/></td>
    </tr>
    <tr>
      <td height="203" align="right">广告描述：</td>
      <td height="203">&nbsp;</td>
      <td height="203"><textarea name="content" class="tarea" id="content" style=" width:450px; height:180px;"><?php echo $hyggData["content"];?></textarea></td>
    </tr>
    <tr>
      <td height="36" align="right">&nbsp;</td>
      <td height="36">&nbsp;</td>
      <td height="36"><input type="submit" class="tj" value=" 提 交 " />
        
      <input type="reset" value=" 重 置 " class="cz" /></td>
    </tr>
    <tr>
      <td height="36" align="right">&nbsp;</td>
      <td height="36">&nbsp;</td>
      <td height="36"><input type="hidden" name="id" id="id" value="<?php echo $_GET["id"]; ?>" /></td>
    </tr>
  </table>
</form>
</body>
</html>