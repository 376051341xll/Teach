<?php
	session_start();
	include_once '../inc/config.php'; 
	session_register("Lang_session");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录</title>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
$action = $_GET['action'];
if(!empty($action) && $action == 'login')
{
	$code=$_POST['codetext'];
	$code = strtolower($code);
	
	if (!empty($_SESSION['captcha_word']))
	{
		include_once('../inc/cls_captcha.php');

		/* 检查验证码是否正确 */
		$validator = new captcha();
		
		if (!$validator->check_word($code))
		{
		   echo "<script>alert('验证码不正确!'); </script>";
		}else{
			//判断用户名和密码是否正确
			$shell = $bw->shell($_POST['username'], md5($_POST['password']));
			//echo($shell);
			//die();
			$shell = $shell?true:false;
			if($shell)
			{
				session_register('shell');
				$_SESSION['shell']=$shell;	
				$_SESSION['username']=$_POST['username'];
				$quanx = $bw->selectOnly('quanxian,username,lang','bw_user',"username='".$_POST['username']."' and password='".md5($_POST['password'])."'", '');
				$_SESSION['quanxian']=$quanx['quanxian'];
				//die($_SESSION['username']);
				if($quanx['username']=="admin"||$quanx['lang']=="全站")
				{
				   $_SESSION['Lang_session']="宁波站";
				}else{
				   $_SESSION['Lang_session']=$quanx['lang'];
				}
				echo "<script>location.href='default.php'; </script>";
			}else{
				echo "<script>alert('用户名或密码不正确!'); </script>";
			}
		}
	}
}
?>
<div class="loginBox">
	<div class="loginLogo"></div>
    <div class="loginBlack"></div>
    <div class="loginMain">
    	<div class="loginMainMain">
        	<form action="?action=login" method="post">
        	<ul>
            	<li><strong>用户名:</strong><input name="username" class="textbox" id="username" maxlength="20" /></li>
                <li><strong>密　码:</strong><input type="password" name="password" class="textbox" id="password" maxlength="20" /></li>
                <li><strong>验证码:</strong><input name="codetext" class="textbox textboxCode" id="codetext" maxlength="4" />
            <img src="Code.php?act=captcha&amp;<?php echo mt_rand(); ?>" width="50" height="20" alt="CAPTCHA" border="1" onclick= "this.src=&quot;Code.php?act=captcha&amp;&quot;+Math.random()" style="cursor: pointer;" title="看不清，点击更换另一个验证码" /></li>
                <li><strong>&nbsp;</strong><input type="submit" class="button loginBTN" value="" /><input type="reset" class="button resetBTN" value="" /></li>
            </ul>
            </form>
        </div>
    </div>
    <div class="loginBottom"></div>
</div>
</body>
</html>