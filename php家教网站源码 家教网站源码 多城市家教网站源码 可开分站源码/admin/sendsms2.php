<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���ŷ���DEMO</title>
<style type="text/css">
<!--
.STYLE2 {
	font-family: "����";
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
		alert("�������ֻ��ţ�");
		document.formSend.mobile.focus();
		return false;
	}
	if(document.formSend.content.value=="")
	{
		alert("����Ϊ��");
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
  <td><div align="center" class="STYLE2">���ŷ���</div></td>
  <td></td>
</tr>
<tr>
  <td height="188"></td>
  <td><p>�� �� ��:
      <input name="mobile">
  ����ֻ��ţ���Ӣ�Ķ��Ÿ���</p>
    <p>�� չ ��:
      <input name="ext">
      ��Ϊ��</p>
    <p>��ʱʱ��:&nbsp;<input name="stime">
      ��ʽ�磺2009-10-30 14:18:00</p>
    <p>Ψһ��־:
      <input name="rrid">
    ��Ϊ���򷵻�ϵͳ����rrid</p>
    <p>���ݣ�&nbsp;&nbsp;&nbsp;
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
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="send" type="submit" value="����">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="reset" type="reset" value="����"></td>
  <td></td>
</tr>
</form>
</table>
</body>
</html>