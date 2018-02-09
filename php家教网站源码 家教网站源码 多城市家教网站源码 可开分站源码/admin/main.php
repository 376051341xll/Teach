<?php
session_start();

if($_SESSION['shell'] < 1)
{
	$_SESSION['shell'] = '';
	echo "<script>window.parent.location.href='login.php'; </script>";
}

error_reporting(0);
$myself_look=0; //是否显示本文件绝对路径和当前的系统用户名（ 0 否 1 是  ）
//安全设置完成
$phpver = phpversion();
list($v_Upper,$v_Major,$v_Minor) = explode(".",$phpver);
if(($v_Upper > 4 && $v_major < 1) || $v_Upper < 4){
  $_GET = $HTTP_GET_VARS;
  $_POST = $HTTP_POST_VARS;
  $_SERVER = $HTTP_SERVER_VARS;
}
$page_begin=getmicrotime();
@set_time_limit(0);
$pass="<font color=green><b>√</b></font>";
$error="<font color=red><b>×</b></font>";
function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    }
function add_arithmetic(){
    $time_start = getmicrotime();
    for ($i=0; $i <= 2000000; $i++){
        $summation=1+1;
        }
    $time_end = getmicrotime();
    $time = $time_end - $time_start;
    return ($time);
    }
if (!empty($_POST[add_check])){$add_checkend=add_arithmetic();}
function sqrt_arithmetic(){
    $time_start = getmicrotime();
    $pi_arithmetic=pi();
    for ($i=0; $i <= 2000000; $i++){
        $summation=sqrt($pi_arithmetic);
        }
    $time_end = getmicrotime();
    $time = $time_end - $time_start;
    return ($time);
    }
if (!empty($_POST[sqrt_check])){$sqrt_checkend=sqrt_arithmetic();}
$PHP_SELF = $_SERVER[PHP_SELF] ? $SERVER[PHP_SELF] : $_SERVER[SCRIPT_NAME];
$me_name = substr( strrchr($PHP_SELF,'/' ), 1 );
function read_file($file_path){
    $handle=fopen($file_path,"r");
    $time_start=getmicrotime();
    for($i=0;$i <= 10000;$i++){
        fread($handle,10240);
        rewind($handle);
	    }
    $time_end = getmicrotime();
    fclose($handle);
    $time = $time_end - $time_start;
 	return($time);
	}
if (!empty($_POST[read_check])){$read_checkend=sqrt_arithmetic();}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/css.css" rel="stylesheet" type="text/css" />
<title>首显文件</title>
<style type="text/css">
<!--
BODY {
	FONT-FAMILY: 宋体;
	FONT-SIZE: 9pt;
	scrollbar-face-color: #e9e9e9;
	scrollbar-shadow-color: #cecece;
	scrollbar-3dlight-color: #e9e9e9;
	scrollbar-arrow-color: #000000;
	scrollbar-track-color: #e9e9e9;
	font-family: "verdana", "arial", "helvetica", "sans-serif";
	scrollbar-darkshadow-color: #ffffff;
	scrollbar-highligh-color: #f6f6f6;
}
td {
	font-size: 12px;
}
a:link {
	text-decoration: none;
	color: #0099CC;
}
a:visited {
	color: #0099CC;
	text-decoration: none;
}
a:hover {
	color: #0099CC;
	text-decoration: none;
}
a:active {
	color: #0099CC;
	text-decoration: none;
}
-->
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		 var screenHeight = $(document).height();
		 var tableHeight = $("table").height();
		 var chaHeight = (screenHeight-tableHeight)/2;
		 
		 $("table").css("margin-top",chaHeight+"px");
	});
</script>
</head>

<body>
<center>
<table width="79%" border="0" cellpadding="0" cellspacing="1" >
  <tr>
    <td height="25" align="right" bgcolor="#FBFAF6">服务器解译引擎：</td>
    <td align="left" bgcolor="#FBFAF6"><?php echo @getenv("SERVER_SOFTWARE");?></td>
  </tr>
  <tr> 
    <td width="20%" height="25" align="right" bgcolor="#FBFAF6">PHP版本：</td>
    <td width="54%" align="left" bgcolor="#FBFAF6">
	 <?php echo PHP_VERSION;?></td>
  </tr>
  <tr> 
    <td height="25" align="right" bgcolor="#FFFFFF">
      PHP运行方式：</td>
    <td align="left" bgcolor="#FFFFFF">
<?php echo strtoupper(php_sapi_name());?></td>
  </tr>
  <tr> 
    <td height="25" align="right" bgcolor="#FBFAF6">
      站 点 物 理 路 径：</td>
    <td align="left" bgcolor="#FBFAF6"><?php echo @getenv("SCRIPT_FILENAME");?></td>
  </tr>
  <tr> 
    <td height="25" align="right" bgcolor="#FFFFFF">
      允许最大上传文件： </td>
    <td align="left" bgcolor="#FFFFFF"><?php echo @get_cfg_var("file_uploads") ?  @get_cfg_var("upload_max_filesize") : $error;?></td>
  </tr>
  <tr> 
    <td height="25" align="right" bgcolor="#FBFAF6">
      Zend引擎版本：</td>
    <td align="left" bgcolor="#FBFAF6"><?php echo zend_version();?></td>
  </tr>
  
  <tr> 
    <td height="25" align="right" bgcolor="#FBFAF6">
      &nbsp;MySQL数据库支持：</td>
    <td align="left" bgcolor="#FBFAF6"><?php echo function_exists(mysql_close) ? $pass : $error;?></td>
  </tr>
  <tr> 
    <td height="25" align="right" bgcolor="#FFFFFF">
      MySQL最大连接数：</td>
    <td align="left" bgcolor="#FFFFFF"><?php echo @get_cfg_var("mysql.max_links")==-1 ? "不限" : @get_cfg_var("mysql.max_links");?></td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#FBFAF6">&nbsp;</td>
    <td bgcolor="#FBFAF6">&nbsp;</td>
  </tr>
  
  <tr> 
    <td height="10" bgcolor="#FFFFFF"></td>
    <td valign="middle" bgcolor="#FFFFFF"></td>
  </tr>
  
  
   <tr> 
    <td height="25" colspan="3">&nbsp;</td>
  </tr>
  
</table>
</center>
</body>
</html>