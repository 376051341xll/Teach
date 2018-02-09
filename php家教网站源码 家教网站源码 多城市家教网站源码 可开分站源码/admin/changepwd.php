<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员密码修改</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</head>

<body>
<?php
	$action = $_GET['action'];
	if($action == 'changepwd')
	{
		$pwd = md5($_POST['password']);
		$_POST['password'] = $pwd;
		//update($tbName, $post, $where)
		if($bw->update('bw_user', $_POST, "username = '{$_SESSION['username']}'"))
		{
			session_destroy();
			$bw->msg('修改成功!');
			echo "<script>window.parent.location.href='login.php'; </script>";
		}else{
			$bw->msg('修改失败!');	
		}
	}
?>

<form name="changepwdForm" action="?action=changepwd" method="post">
<table width="570" cellspacing="0" cellpadding="0">
  <tr>
    <td width="189" align="right">您好:</td>
    <td width="17">&nbsp;</td>
    <td width="362"><?php echo $_SESSION['username']; ?></td>
  </tr>
  <tr>
    <td align="right">新密码:</td>
    <td>&nbsp;</td>
    <td><input class="textBox" name="password" id="password" /></td>
  </tr>
  <tr>
    <td align="right">再次输入:</td>
    <td>&nbsp;</td>
    <td><input class="textBox" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" class="subBtn" value=" 保 存 " /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>