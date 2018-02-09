<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新闻分类管理</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
</head>

<body>
<table width="1030" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
	//insert($tbName, $post)
	$action = $_GET['action'];
	if($action == 'insert')
	{
		//print_r($_POST);
		if($bw->insert('bw_productclass', $_POST))
		{
			$bw->msg('新增成功!', 'proclass.php');	
		}else{
			$bw->msg('新增失败!', 'proclass.php');	
		}
	}
	
  ?>
  <form name="firstForm" action="?action=insert" method="post">
  <tr>
    <td width="263" align="right">新增分类:</td>
    <td width="20">&nbsp;</td>
    <td width="745"><input name="className" id="className" />&nbsp;<input type="submit" value=" 确 定 " /></td>
  </tr>
  </form>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  //update($tbName, $post, $where)
  	if($action == 'update')
	{
		$classId = $_POST['classId'];
		unset($_POST['classId']);
		if(!empty($_POST['className']))
		{
			if($bw->update('bw_productclass', $_POST, 'id = '.$classId))	
			{
				$bw->msg('更新成功!', 'proclass.php');	
			}else{
				$bw->msg('更新失败!', 'proclass.php');	
			}
		}else{
			$bw->msg('要修改的类别名称不能为空!', 'proclass.php');	
		}
	}
  ?>
  <form name="twoForm" action="?action=update" method="post">
  <tr>
    <td align="right">将:</td>
    <td>&nbsp;</td>
    <td>
    	<select name="classId" id="classId">
        <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_productclass', "lang = 'cn'", 'id DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
        <option value="<?php echo $list[$i]['id']; ?>"><?php echo $list[$i]['className']; ?></option>
        <?php
			}
		?>
       	</select>&nbsp;修改为:&nbsp;
        <input name="className" id="className" />&nbsp;<input type="submit" value=" 确 定 " />
    </td>
  </tr>
  </form>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  	if($action == 'delete')
	{
		//delete($tbName, $where)
		$id = $_POST['classId'];
		if($id > 7)
		{
			if($bw->delete('bw_productclass', 'id = '.$_POST['classId']))
			{
				$bw->msg('删除成功!', 'proclass.php');	
			}else{
				$bw->msg('删除失败!', 'proclass.php');	
			}
		}else{
			$bw->msg('系统默认分类不能删除', 'proclass.php');	
		}
	}
  ?>
  <form name="deleteForm" action="?action=delete" method="post">
  <tr>
    <td align="right">将:</td>
    <td>&nbsp;</td>
    <td><select name="classId" id="classId">
        <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_productclass', "lang = 'cn'", 'id DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
        <option value="<?php echo $list[$i]['id']; ?>"><?php echo $list[$i]['className']; ?></option>
        <?php
			}
		?>
       	</select>&nbsp;删除&nbsp;<input type="submit" value=" 确 定 " /></td>
  </tr>
  </form>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


</body>
</html>