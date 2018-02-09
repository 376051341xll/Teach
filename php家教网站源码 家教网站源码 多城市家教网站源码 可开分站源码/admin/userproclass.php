<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
	htqx("2.1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户产品分类管理</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){						   
	var firstSubmit = $("#firstSubmit");
	
	firstSubmit.click(function(){
		var firstClassName = $("#firstClassName").val();
		if(firstClassName == "")
		{
			alert("新增大类名称不能为空!");
			return false;
		}
	});//end firstSubmit click;
	
	
	var classSubmit = $("#classSubmit");
	classSubmit.click(function(){
		var className = $("#className").val();
		if(className == "")
		{
			alert("子类名称不能为空!");
			return false;
		}
	});//end classSubmit click;
	
	var updateSubmit = $("#updateSubmit");
	updateSubmit.click(function(){
		var updateClassName = $("#updateClassName").val();	
		if(updateClassName == "")
		{
			alert("请输入要修改为的类名!");
			return false;
		}
	});//end updateSubmit click;
	 
	var deleteSubmit = $("#deleteSubmit");
	deleteSubmit.click(function(){
		var deleteForm = $("#deleteForm");
		if(confirm("确定删除吗?"))
		{
			deleteForm.submit();	
		}else{
			return false;	
		}							
	});//end deleteSubmit click;

});
</script>
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
	htqx("2.2");
		//print_r($_POST);
		if($bw->insert('bw_userproclass', $_POST))
		{
			$bw->msg('新增成功!', 'userproclass.php');	
		}else{
			$bw->msg('新增失败!', 'userproclass.php');	
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
  //插入下级分类
  	if($action == 'insertChild')
	{
	htqx("2.2");
		$_POST['parentId'] = $_POST['classId'];
		unset($_POST['classId']);
		if(!empty($_POST['parentId']))
		{
			if($bw->insert('bw_userproclass', $_POST))	
			{
				$bw->msg('新增成功!', 'userproclass.php');	
			}else{
				$bw->msg('新增失败!', 'userproclass.php');	
			}
		}
	}
  ?>
  <form name="fourForm" action="?action=insertChild" method="post">
  <tr>
    <td align="right">在:</td>
    <td>&nbsp;</td>
    <td>
    	<select name="classId" id="classId">
        <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$fourList = $bw->selectMany('id, className', 'bw_userproclass', "parentId = 0", 'paixu DESC');
			$fourSum = count($fourList);
			for($fouri = 0; $fouri<$fourSum; $fouri++)
			{
		?>
        <option value="<?php echo $fourList[$fouri]['id']; ?>"><?php echo $fourList[$fouri]['className']; ?></option>
        <?php
			}
		?>
       	</select>
    	&nbsp;下增加:&nbsp;
        <input name="className" id="className" />
        子类&nbsp;<input type="submit" value=" 确 定 " />
    </td>
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
	htqx("2.3");
		$classId = $_POST['classId'];
		unset($_POST['classId']);
		if(!empty($_POST['className']))
		{
			if($bw->update('bw_userproclass', $_POST, 'id = '.$classId))	
			{
				$bw->msg('更新成功!', 'userproclass.php');	
			}else{
				$bw->msg('更新失败!', 'userproclass.php');	
			}
		}else{
			$bw->msg('要修改的类别名称不能为空!', 'userproclass.php');	
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
			$list = $bw->selectMany('id, className', 'bw_userproclass', "parentId = 0", 'paixu DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
        <option value="<?php echo $list[$i]['id']; ?>"><?php echo $list[$i]['className']; ?></option>
        <?php
			$bw->getChildClass($list[$i]['id'], 'parentId', 'bw_userproclass');
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
	htqx("2.4");
		//delete($tbName, $where)
		$id = $_POST['classId'];
		if($id > 3)
		{
			if($bw->delete('bw_userproclass', 'id = '.$_POST['classId']))
			{
				$bw->msg('删除成功!', 'userproclass.php');	
			}else{
				$bw->msg('删除失败!', 'userproclass.php');	
			}
		}else{
			$bw->msg('系统默认分类不能删除', 'userproclass.php');	
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
			$list = $bw->selectMany('id, className', 'bw_userproclass', "parentId=0", 'paixu DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
        <option value="<?php echo $list[$i]['id']; ?>"><?php echo $list[$i]['className']; ?></option>
        <?php
			$bw->getChildClass($list[$i]['id'], 'parentId', 'bw_userproclass');
			}
		?>
       	</select>&nbsp;删除&nbsp;<input type="submit" value=" 确 定 " /></td>
  </tr>
  </form>  <?php
  //update($tbName, $post, $where)
  	if($action == 'paixu')
	{
		$classId = $_POST['classId'];
		unset($_POST['classId']);
		if(!empty($_POST['paixu']))
		{
		htqx("2.3");
			if($bw->update('bw_userproclass', $_POST, 'id = '.$classId))	
			{
				$bw->msg('更新成功!', 'userproclass.php');	
			}else{
				$bw->msg('更新失败!', 'userproclass.php');	
			}
		}else{
			$bw->msg('请输入排序的数字!', 'userproclass.php');	
		}
	}
  ?>
  <form name="paixuForm" action="?action=paixu" method="post">
  <tr>
    <td align="right">大类排序：</td>
    <td>&nbsp;</td>
    <td><select name="classId" id="classId">
      <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$fourList = $bw->selectMany('id, className', 'bw_userproclass', "parentId = 0", 'paixu DESC');
			$fourSum = count($fourList);
			for($fouri = 0; $fouri<$fourSum; $fouri++)
			{
		?>
      <option value="<?php echo $fourList[$fouri]['id']; ?>"><?php echo $fourList[$fouri]['className']; ?></option>
      <?php
			}
		?>
    </select>      &nbsp;修改为:&nbsp;
      <input name="paixu" id="paixu" size="5" maxlength="5" />
      &nbsp;
    <input type="submit" value=" 确 定 " />
    数字越到排越前面</td>
  </tr>
  </form>
</table>


</body>
</html>