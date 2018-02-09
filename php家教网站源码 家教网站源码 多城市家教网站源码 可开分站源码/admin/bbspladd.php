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
		function ubb_html(str){
		//alert(str)
		str = str.replace(/</ig,'&lt;');
		str = str.replace(/>/ig,'&gt;');
		str = str.replace(/\n/ig,'<br />');
		str = str.replace(/\[code\](.+?)\[\/code\]/ig, function($1, $2) {return phpcode($2);});

		str = str.replace(/\[hr\]/ig,'<hr />');
		str = str.replace(/\[\/(size|color|font|hilitecolor)\]/ig,'</font>');
		str = str.replace(/\[(sub|sup|u|i|strike|b|blockquote|li|p|ul|ol|li)\]/ig,'<$1>');
		str = str.replace(/\[\/(sub|sup|u|i|strike|b|blockquote|li|p|ul|ol|li)\]/ig,'</$1>');
		str = str.replace(/\[\/align\]/ig,'</p>');
		str = str.replace(/\[(\/)?h([1-6])\]/ig,'<$1h$2>');

		str = str.replace(/\[align=(left|center|right|justify)\]/ig,'<p align="$1">');
		str = str.replace(/\[size=(\d+?)\]/ig,'<font size="$1">');
		str = str.replace(/\[color=([^\[\<]+?)\]/ig, '<font color="$1">');
		str = str.replace(/\[hilitecolor=([^\[\<]+?)\]/ig, '<font style="background-color:$1">');
		str = str.replace(/\[font=([^\[\<]+?)\]/ig, '<font face="$1">');
		str = str.replace(/\[list=(a|A|1)\](.+?)\[\/list\]/ig,'<ol type="$1">$2</ol>');
		str = str.replace(/\[(\/)?list\]/ig,'<$1ul>');

		str = str.replace(/\[s:(\d+)\]/ig,function($1,$2){ return smilepath($2);});
		str = str.replace(/\[img\]([^\[]*)\[\/img\]/ig,'<img src="$1" border="0" />');
		str = str.replace(/\[url=([^\]]+)\]([^\[]+)\[\/url\]/ig, '<a href="$1">'+'$2'+'</a>');
		str = str.replace(/\[url\]([^\[]+)\[\/url\]/ig, '<a href="$1">'+'$1'+'</a>');
		return str;
	}
</script>
</head>

<body>
<?php

//查询
if(!empty($_GET['id']))
{
	$newsData = $bw->selectOnly('*', 'bw_userbbspl', 'id = '.$_GET['id'], '');
	$hyData = $bw->selectOnly('*', 'bw_userbbs', 'id = '.$newsData['bbsid'], '');
}
?>
<form action="?action=insert" method="post" enctype="multipart/form-data">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="148" align="right">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $newsData['id']; ?>" /></td>
  </tr>
  <tr>
    <td align="right">论坛标题:</td>
    <td>&nbsp;</td>
    <td><?php echo $hyData["title"];?></td>
  </tr>
  <tr>
    <td align="right">会 员 号:</td>
    <td>&nbsp;</td>
    <td><?php echo $newsData['username']; ?></td>
  </tr>
  <tr>
    <td align="right">发布时间:</td>
    <td>&nbsp;</td>
    <td><?php echo $newsData['addtime']; ?></td>
  </tr>
  <tr>
    <td align="right">信息内容:</td>
    <td>&nbsp;</td>
    <td><div id="content"><?php echo $newsData['content']; ?></div><script>
		str = ubb_html(document.getElementById("content").innerText);
		document.getElementById("content").innerHTML=str;
		</script></td>
  </tr>
  </table>
</form>
</body>
</html>