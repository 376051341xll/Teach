<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("inc/config.php");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $service_title; ?></title>
<meta name="keywords" content="<?php echo $service_keyword.'-'.$service_title; ?>" />
<meta name="description" content="<?php echo $service_description.'-'.$service_title; ?>" />
</head>
<body style="text-align:center;"><br />
<br />
<?php
if($bw->selectOnly('username' ,'bw_member', "username = '".$_GET["uname"]."'"))
	{
		echo '<span style="color:#ff0000">对不起该会员号已存在！</span>';
		exit;
		}else{
			echo "恭喜，该会员号可以使用";
			}
?>
</body>
</html>