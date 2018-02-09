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

//查询
if(!empty($_GET['id']))
{
	$newsData = $bw->selectOnly('*', 'bw_diaocha', 'id = '.$_GET['id'], '');
	$zongzhi=$newsData['Azhi']+$newsData['Bzhi']+$newsData['Czhi']+$newsData['Dzhi']+$newsData['Ezhi'];
}
?>
<form action="?action=insert" method="post" enctype="multipart/form-data">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="171" align="right">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td width="611">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $newsData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">问卷标题:</td>
    <td>&nbsp;</td>
    <td><?php echo $newsData['title']; ?>
      &nbsp; </td>
  </tr>
  <tr>
    <td align="right">A选项:<?php echo $newsData['Atitle'];?></td>
    <td>&nbsp;</td>
    <td><div style=" width:300px; height:10px;"><div style="height:10px; width:<?php
   $azhi=ceil($newsData['Azhi']/$zongzhi*100);
   echo $azhi;
	?>%; background:#F00;"></div></div><?php
    echo $azhi."%";
	?></td>
  </tr>
  <tr>
    <td align="right">B选项:<?php echo $newsData['Btitle'];?></td>
    <td>&nbsp;</td>
    <td><div style=" width:300px; height:10px;"><div style="height:10px; width:<?php
   $bzhi=ceil($newsData['Bzhi']/$zongzhi*100);
   echo $bzhi;
	?>%; background: #0F0"></div></div><?php
    echo $bzhi."%";
	?></td>
  </tr>
  <tr>
    <td align="right">C选项:<?php echo $newsData['Ctitle'];?></td>
    <td>&nbsp;</td>
    <td><div style=" width:300px; height:10px;"><div style="height:10px; width:<?php
   $czhi=ceil($newsData['Czhi']/$zongzhi*100);
   echo $czhi;
	?>%;background: #00F"></div></div><?php
    echo $czhi."%";
	?></td>
  </tr>
  <tr>
    <td align="right">D选项:<?php echo $newsData['Dtitle'];?></td>
    <td>&nbsp;</td>
    <td><div style=" width:300px; height:10px;"><div style="height:10px; width:<?php
   $dzhi=ceil($newsData['Dzhi']/$zongzhi*100);
   echo $dzhi;
	?>%;background: #FF0;"></div></div><?php
    echo $dzhi."%";
	?></td>
  </tr>
  <tr>
    <td align="right">E选项:<?php echo $newsData['Etitle'];?></td>
    <td>&nbsp;</td>
    <td><div style=" width:300px; height:10px;"><div style="height:10px; width:<?php
   $ezhi=ceil($newsData['Ezhi']/$zongzhi*100);
   echo $ezhi;
	?>%;background: #0FF;"></div></div><?php
    echo $ezhi."%";
	?></td>
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