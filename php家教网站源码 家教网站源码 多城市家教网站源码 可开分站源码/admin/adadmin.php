<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
	if(empty($_GET["id"]))
	{
    htqx("1.2");
	}else{
    htqx("1.4");
		 }
	$langData = $bw->selectOnly('*', 'bw_lang', 'id = 1', '');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加广告信息</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script><script language="javascript">
function yanz()
{
	if(document.getElementById("username").value=="")
	{
		alert("管理员登陆账号不能为空");
		document.getElementById("username").focus();
		return false;
	}
	if(document.getElementById("bumen").value=="")
	{
		alert("部门不能为空");
		document.getElementById("bumen").focus();
		return false;
	}
	<?php
	if(empty($_GET["id"]))
	{
	?>
	if(document.getElementById("password").value=="")
	{
		alert("密码不能为空");
		document.getElementById("password").focus();
		return false;
	}
	if(document.getElementById("password2").value=="")
	{
		alert("重复密码不能为空");
		document.getElementById("password2").focus();
		return false;
	}
	<?php
	}
	?>
	if(document.getElementById("password").value!=document.getElementById("password2").value)
		{
			alert("两次输入的密码不一致");
			return false;
		}
	return true;
}
</script>
</head>

<body>
<?php
$action = $_GET['action'];
		if(!empty($_POST['password']))
		{
		$_POST['password']=md5($_POST['password']);
			}
if($action == 'insert')
{
	$id = $_POST['id'];
	if(empty($id))
	{
		unset($_POST['id']);
		//insert($tbName, $post)
		//update($tbName, $post, $where)
		//print_r($_POST);
		//exit;
		if( $bw->selectOnly('id', 'bw_user',"username='".$_POST['username']."'", ''))
		{
			$bw->msg('用户名已经存在!', 'adadmin.php');
			exit;
			}
		if($bw->insert('bw_user', $_POST))
		{
			$bw->msg('新增成功!', 'adminlist.php');	
		}else{
			$bw->msg('新增失败!', '', true);	
		}
	}else{
		if(empty($_POST['password']))
		{
		unset($_POST['password']);
			}
		unset($_POST['parentid']);
		//update($tbName, $post, $where)
		if($bw->update('bw_user', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'adminlist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
	}
}

//查询
if(!empty($_GET['id']))
{
	$adData = $bw->selectOnly('*', 'bw_user', 'id = '.$_GET['id'], '');
}
?>
<form name="insertForm" action="?action=insert" enctype="multipart/form-data" method="post" onsubmit="return yanz();">
<table width="788" cellspacing="0" cellpadding="0">
  <tr>
    <td width="132" align="right">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="630">&nbsp;<input type="hidden" name="id" id="id" value="<?php echo $adData['id']; ?>" /><input type="hidden" name="parentid" id="parentid" value="<?php 
	$parentname = $bw->selectOnly('id', 'bw_user',"username='".$_SESSION['username']."'", '');
	echo $parentname["id"];
	 ?>" /></td>
  </tr>
  <tr>
    <td align="right">管理员账号:</td>
    <td>&nbsp;</td>
    <td><input name="username" class="textBox" id="username" value="<?php echo $adData['username']; ?>" <?php
    if($_SESSION['username']!="admin"&&!empty($adData['username']))
	{
		echo "readonly";
		}
	?>/></td>
  </tr>
  <tr>
    <td height="30" align="right">所属部门:</td>
    <td>&nbsp;</td>
    <td><input name="bumen" class="textBox" id="bumen" value="<?php

		if(empty($adData['bumen']))
		{
			if($_SESSION['username']!="admin")
			{
	$bumendate = $bw->selectOnly('bumen', 'bw_user',"username='".$_SESSION['username']."'", '');
	echo $bumendate["bumen"];	
			}	
		}else{
			echo $adData['bumen'];
			}
		 
	 
	 ?>"  <?php
    if($_SESSION['username']!="admin")
	{
		echo "readonly";
		}
	?>/></td>
  </tr>
  <tr>
    <td align="right">所属站点</td>
    <td>&nbsp;</td>
    <td>
	<select name="lang">
	 <?php
	   if(!empty($adData['lang'])){
	 ?>
	 <option value="<?php echo $adData['lang'];?>" selected="selected" ><?php echo $adData['lang'];?></option>
	 <?php 
	   }
	 ?>
			<?php
			  $dir=$langData["lang"];
			  $split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
			  for($i=0;$i<count($split_dir);$i++)
			  { 
			?>
            <option <?php 
			if($split_dir[$i]==$_SESSION["Lang_session"] && empty($adData['lang'])){
				echo "selected='selected'";
				}
			?> value="<?php echo $split_dir[$i];?>" ><?php echo $split_dir[$i];?></option>
            <?php
              }
            ?>
            <option value="全站">全站</option>
   </select>
	</td>
  </tr>
  <tr>
    <td align="right">管理员密码:</td>
    <td>&nbsp;</td>
    <td><input name="password" type="password" class="textBox" id="password" value="" />&nbsp;&nbsp;<span style="color:#F00;">如果不修改请留空</span></td>
  </tr>
   <tr>
    <td align="right">重复管理员密码:</td>
    <td>&nbsp;</td>
    <td><input type="password" class="textBox" id="password2" value="" />&nbsp;&nbsp;<span style="color:#F00;">如果不修改请留空</span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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