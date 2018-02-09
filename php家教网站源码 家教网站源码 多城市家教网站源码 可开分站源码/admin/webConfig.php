<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	$configData = $bw->selectOnly('*', 'bw_config', ' lang="'.$Lang.'" ', '');
	htqx("2.1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站基本配置</title>
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
//update
$action = $_GET['action'];
if(!empty($action) && $action == 'update')
{
	htqx("2.3");
	$id=$_POST["id"];
		if(!empty($_FILES['logo']['name']))
		{
			unlink("{$configData['logo']}");
			//update($tbName, $post, $where)
			$fileName = $bw->upload('../upload/ad/',204800,'logo');
			if($fileName)
			{
				$elem = array();
				$elem['logo'] = $fileName;
			}
		}
		$_POST["xueli"]=str_replace(",,",",",$_POST["xueli"]);
		$_POST["xueli"]=str_replace("，",",",$_POST["xueli"]);
		if(substr($_POST["xueli"],0,1)==",")
		{
		$_POST["xueli"]=substr($_POST["xueli"],1);
		}
		if(substr($_POST["xueli"],-1)==",")
		{
		$_POST["xueli"]=substr($_POST["xueli"],0,-1);
		}
		$_POST["shenfen"]=str_replace(",,",",",$_POST["shenfen"]);
		$_POST["shenfen"]=str_replace("，",",",$_POST["shenfen"]);
		if(substr($_POST["shenfen"],0,1)==",")
		{
		$_POST["shenfen"]=substr($_POST["shenfen"],1);
		}
		if(substr($_POST["shenfen"],-1)==",")
		{
		$_POST["shenfen"]=substr($_POST["shenfen"],0,-1);
		}
		$_POST["zhicheng"]=str_replace(",,",",",$_POST["zhicheng"]);
		$_POST["zhicheng"]=str_replace("，",",",$_POST["zhicheng"]);
		if(substr($_POST["zhicheng"],0,1)==",")
		{
		$_POST["zhicheng"]=substr($_POST["zhicheng"],1);
		}
		if(substr($_POST["zhicheng"],-1)==",")
		{
		$_POST["zhicheng"]=substr($_POST["zhicheng"],0,-1);
		}
		$_POST["quyu"]=str_replace(",,",",",$_POST["quyu"]);
		$_POST["quyu"]=str_replace("，",",",$_POST["quyu"]);
		if(substr($_POST["quyu"],0,1)==",")
		{
		$_POST["quyu"]=substr($_POST["quyu"],1);
		}
		if(substr($_POST["quyu"],-1)==",")
		{
		$_POST["quyu"]=substr($_POST["quyu"],0,-1);
		}
		$_POST["leibie"]=str_replace(",,",",",$_POST["leibie"]);
		$_POST["leibie"]=str_replace("，",",",$_POST["leibie"]);
		if(substr($_POST["leibie"],0,1)==",")
		{
		$_POST["leibie"]=substr($_POST["leibie"],1);
		}
		if(substr($_POST["leibie"],-1)==",")
		{
		$_POST["leibie"]=substr($_POST["leibie"],0,-1);
		}
	//	$_POST["xueli"]=str_replace(",",",",$_POST["xueli"])
	if(empty($id))
	{
	    unset($_POST['Submit']);
		unset($_POST['Submit2']);
		unset($_POST['id']);
		//insert($tbName, $post)
		if($bw->insert('bw_config', $_POST))
		{
			$bw->msg('新增成功!', 'webConfig.php');
		}else{
			$bw->msg('新增失败!', 'webConfig.php');	
		}
	}else{
		if($bw->update('bw_config', $_POST, 'lang="'.$Lang.'"'))
		{
			if(is_array($elem))
			{
				$bw->update('bw_config', $elem, 'id='.$id.' and lang="'.$Lang.'"');
			}
			echo "<script>alert('更新成功!'); location.href='webConfig.php'; </script>";
		}else{
			echo "<script>alert('更新失败!'); history.go(-1); </script>";	
		}
	}
}
?>
<form name="webConfigFrom" action="?action=update" enctype="multipart/form-data" method="post">
<table width="1062" height="317" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="261" align="right">网站标题:</td>
    <td width="15">&nbsp;</td>
    <td width="784"><input name="title" class="textBox" id="title" value="<?php echo $configData['title']; ?>" maxlength="100" />
	<input name="id" class="textBox" id="id" value="<?php echo $configData['id']; ?>" type="hidden"/>
	<input name="lang" class="textBox" id="lang" value="<?php echo $Lang; ?>" type="hidden"/>
	</td>
  </tr>
  <tr>
    <td align="right">网站关键字:</td>
    <td>&nbsp;</td>
    <td><textarea name="keyword" class="textarea" id="keyword"><?php echo $configData['keyword']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">网站描述:</td>
    <td>&nbsp;</td>
    <td><textarea name="description" class="textarea" id="description"><?php echo $configData['description']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">底部说明信息:</td>
    <td>&nbsp;</td>
    <td><textarea name="information" class="editor" id="information"><?php echo $configData['information']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">请家教热线：</td>
    <td>&nbsp;</td>
    <td><label>
      <input name="qjjphone" type="text" id="qjjphone" size="45" value="<?php echo $configData['qjjphone']; ?>" />
    </label></td>
  </tr>
  <tr>
    <td align="right">教员热线：</td>
    <td>&nbsp;</td>
    <td><input name="jyphone" type="text" id="jyphone" size="45" value="<?php echo $configData['jyphone']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">benner服务热线：</td>
    <td>&nbsp;</td>
    <td><input name="bphone" type="text" id="bphone" size="45" value="<?php echo $configData['bphone']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">学历设置：</td>
    <td>&nbsp;</td>
    <td><textarea name="xueli" id="xueli" cols="45" rows="5"><?php if(empty($configData['xueli'])){echo '大专以下,大专在读,大专毕业,本科在读,本科毕业,硕士在读,硕士毕业,博士在读,博士毕业';}else{echo $configData['xueli']; } ?></textarea></td>
  </tr>
  <tr>
    <td align="right">目前身份设置：</td>
    <td>&nbsp;</td>
    <td><textarea name="shenfen" id="shenfen" cols="45" rows="5"><?php if(empty($configData['shenfen'])){echo '在读大学生,在读研究生,在读博士生,其他学生,幼儿教师,小学教师,初中教师,高中教师,大学教师,专业培训机构教师';}else{echo $configData['shenfen']; } ?></textarea></td>
  </tr>
  <tr>
    <td align="right">职称等级设置：</td>
    <td>&nbsp;</td>
    <td><textarea name="zhicheng" id="zhicheng" cols="45" rows="5"><?php if(empty($configData['zhicheng'])){echo '尚无职称等级,幼儿教师,小学二级教师,小学一级教师,小学高级教师,小学特级教师,中学二级教师,中学一级教师,中学高级教师,中学特级教师,大学助教,大学讲师,副教授,正教授';}else{echo $configData['zhicheng']; } ?></textarea></td>
  </tr>
  <tr>
    <td align="right">区域设置：</td>
    <td>&nbsp;</td>
    <td><textarea name="quyu" id="quyu" cols="45" rows="5"><?php echo $configData['quyu']; ?></textarea></td>
  </tr>
  <tr>
    <td align="right">任教学校类别设置：</td>
    <td>&nbsp;</td>
    <td><textarea name="leibie" id="leibie" cols="45" rows="5"><?php if(empty($configData['leibie'])){echo '幼儿园,小学,初中,高中,大学,专业培训机构,其他学校';}else{echo $configData['leibie']; } ?></textarea></td>
  </tr>
  <tr>
    <td align="right">年级设置：</td>
    <td>&nbsp;</td>
    <td><textarea name="nianji" id="nianji" cols="45" rows="5"><?php if(empty($configData['nianji'])){echo '幼儿,一年级,二年级,三年级,四年级,五年级,六年级,七年级,八年级,九年级,高一,高二,高三,三校生,自考生,大一,大二,大三,大四,成人,外国人,其它情况';}else{echo $configData['nianji']; } ?></textarea></td>
  </tr>
  <tr>
    <td align="right">学员信息来源：</td>
    <td>&nbsp;</td>
    <td><textarea name="xyxxly" id="xyxxly" cols="45" rows="5"><?php if(empty($configData['xyxxly'])){echo '宣传单,海报,百度搜索,朋友介绍,论坛,短信,其他网站';}else{echo $configData['xyxxly']; } ?></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" class="subBtn" value=" 提 交 " /></td>
  </tr>
</table>
</form>
</body>
</html>