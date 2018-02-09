<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>短信发送DEMO</title>
<style type="text/css">
<!--
.STYLE2 {
	font-family: "宋体";
	font-size: 36px;
}
.STYLE3 {color: #0099FF}
body {
	background-color: #CCCCCC;
	background-image: url();
	background-repeat: no-repeat;
}
body,td,th {
	color: #3399CC;
}
-->
</style>
<script>
function check()
{
	if(document.formSend.mobile.value=="")
	{
		alert("请输入手机号！");
		document.formSend.mobile.focus();
		return false;
	}
	if(document.formSend.content.value=="")
	{
		alert("内容为空");
		document.formSend.content.focus();
		return false;
	}
}
</script>
</head>

<body>

<table width="1017" height="343">
<form action="send_action.php" method="post" name="formSend" class="STYLE3" onSubmit="return check()">
<tr>
  <td width="242" height="3"></td>
  <td width="552"></td>
  <td width="207"></td>
</tr>
<tr>
  <td></td>
  <td><div align="center" class="STYLE2">短信发送</div></td>
  <td></td>
</tr>
<tr>
  <td height="188"></td>
  <td><p>手 机 号:
      <input name="mobile">
  多个手机号，用英文逗号隔开</p>
    <p>扩 展 码:
      <input name="ext">
      可为空</p>
    <p>定时时间:&nbsp;<input name="stime">
      格式如：2009-10-30 14:18:00</p>
    <p>唯一标志:
      <input name="rrid">
    如为空则返回系统生成rrid</p>
    <p>内容：&nbsp;&nbsp;&nbsp;
      <textarea name="content" cols="50" rows="5"></textarea></p></td>
  <td></td>
</tr>
<tr>
  <td></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="send" type="submit" value="发送">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="reset" type="reset" value="重置"></td>
  <td></td>
</tr>
</form>
</table>
</body>
</html>