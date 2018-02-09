<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	//selectOnly($param,$tbname,$where,$order)
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script language="javascript">
function selall(formname){
for(var i=0;i<formname.sq.length;i++){
formname.sq[i].checked=true
}
}
function optall(formname){
for(var i=0;i<formname.sq.length;i++){
if(formname.sq[i].checked==false){
formname.sq[i].checked=true
}
else{formname.sq[i].checked=false}
}
}
</script>
<?php
if(!empty($_GET["id"]))
{
 $qxdate = $bw->selectOnly('quanxian', 'bw_user',"id=".$_GET["id"], '');
}
htqx("1.3");
if($_GET["act"]=="souquan")
{
 $qxdate = $bw->selectOnly('username', 'bw_user',"id=".$_POST["id"], '');
	if($_SESSION['username']!="admin"&&$qxdate["username"]==$_SESSION['username'])
	{
		echo "<script>alert('请勿非法操作！');history.go(-1);</script>";
		exit;
		}
if(!empty($_POST["quanxian"]))
		{
		foreach ($_POST["quanxian"] as &$value) {
    	$abc = $abc.$value.",";
			}
			$_POST["quanxian"]=$abc;
		}else{
		    $_POST["quanxian"]="";
		}
		//die($_POST["quanxian"]);
if($bw->update('bw_user', $_POST, 'id = '.$_POST['id']))
		{
			$bw->msg('更新成功!', 'adminlist.php');
		}else{
			$bw->msg('更新失败!', '', true);
		}
}
//die($qxdate["quanxian"]);
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.STYLE15 {font-weight: bold}
.STYLE16 {font-size: 12px}
.right_bk {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: solid;
	border-top-color: #808080;
	border-right-color: #808080;
	border-bottom-color: #808080;
	border-left-color: #808080;
}
.left_biank {
	border-top-width: 2px;
	border-right-width: 2px;
	border-bottom-width: 2px;
	border-left-width: 2px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #565656;
	border-right-color: #565656;
	border-bottom-color: #565656;
	border-left-color: #565656;
}
.xia_biank {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dashed;
	border-left-style: none;
	border-top-color: #565656;
	border-right-color: #565656;
	border-bottom-color: #565656;
	border-left-color: #565656;
}
.STYLE18 {
	font-size: 12px;
	color: #666666;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" style="border-bottom:2px solid #B5CFD9;"><div align="center" class="STYLE15"><span class="STYLE16"><font color="#333">授 权 管 理</font></span></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top">
      <table width="100%" height="200" border="0" cellpadding="0" cellspacing="0">
        <form action="?act=souquan" method="post" name="formsq" id="formsq">
        <tr>
          <td width="57%" align="right" valign="top"><br>
              <table width="540" border="0" cellspacing="0" cellpadding="0"> <?php
               if(strlen(strstr($_SESSION['quanxian'],"1.1"))>0||strlen(strstr($_SESSION['quanxian'],"1.2"))>0||strlen(strstr($_SESSION['quanxian'],"1.3"))>0||strlen(strstr($_SESSION['quanxian'],"1.4"))>0||strlen(strstr($_SESSION['quanxian'],"1.5"))>0||$_SESSION['username']=="admin")
		 {
			  ?><tr>
                  <td width="461" height="30" align="left" valign="middle" class="xia_biank"><span class="STYLE18">管理员设置：<?php
         if(strlen(strstr($_SESSION['quanxian'],"1.1"))>0||$_SESSION['username']=="admin")
		 {
				  ?><input name="quanxian[]" type="checkbox" id="sq" value="1.1" <?php
         if(strlen(strstr($qxdate['quanxian'],"1.1"))>0)
		 {
			echo "checked"; 
		}
			  ?> >
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"1.2"))>0||$_SESSION['username']=="admin")
		 {
?>
<input name="quanxian[]" type="checkbox" id="sq" value="1.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"1.2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"1.3"))>0||$_SESSION['username']=="admin")
		 {
?>
<input name="quanxian[]" type="checkbox" id="sq" value="1.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"1.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
授权
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"1.4"))>0||$_SESSION['username']=="admin")
		 {
?>
<input name="quanxian[]" type="checkbox" id="sq" value="1.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"1.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"1.4"))>0||$_SESSION['username']=="admin")
		 {
?>
<input name="quanxian[]" type="checkbox" id="sq" value="1.5" <?php
         if(strlen(strstr($qxdate['quanxian'],"1.5"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除<?php
		 }
?> </span></td>
                  <td width="79" align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"2.1"))>0||strlen(strstr($_SESSION['quanxian'],"2.2"))>0||strlen(strstr($_SESSION['quanxian'],"2.3"))>0||strlen(strstr($_SESSION['quanxian'],"2.4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="30" align="left" valign="middle" class="xia_biank"><span class="STYLE18">网站基本配置：<?php
         if(strlen(strstr($_SESSION['quanxian'],"2.1"))>0||$_SESSION['username']=="admin")
		 {
				  ?>
                      <input name="quanxian[]" type="checkbox" id="sq" value="2.1"  <?php
         if(strlen(strstr($qxdate['quanxian'],"2.1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"2.2"))>0||$_SESSION['username']=="admin")
		 {
?>
<input name="quanxian[]" type="checkbox" id="sq" value="2.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"2.2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"2.3"))>0||$_SESSION['username']=="admin")
		 {
?>  
<input name="quanxian[]" type="checkbox" id="sq" value="2.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"2.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"2.4"))>0||$_SESSION['username']=="admin")
		 {
?>   
<input name="quanxian[]" type="checkbox" id="sq" value="2.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"2.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除
 <?php
		 }
		  ?>        </span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"3.1"))>0||strlen(strstr($_SESSION['quanxian'],"3.2"))>0||strlen(strstr($_SESSION['quanxian'],"3.3"))>0||strlen(strstr($_SESSION['quanxian'],"3.4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="30" align="left" valign="middle" class="xia_biank"><span class="STYLE18">网站信息栏目：<?php
         if(strlen(strstr($_SESSION['quanxian'],"3.1"))>0||$_SESSION['username']=="admin")
		 {
?> 
                      <input name="quanxian[]" type="checkbox" id="sq" value="3.1" <?php
         if(strlen(strstr($qxdate['quanxian'],"3.1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"3.2"))>0||$_SESSION['username']=="admin")
		 {
?> 
<input name="quanxian[]" type="checkbox" id="sq" value="3.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"3.2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"3.3"))>0||$_SESSION['username']=="admin")
		 {
?> 
<input name="quanxian[]" type="checkbox" id="sq" value="3.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"3.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"3.4"))>0||$_SESSION['username']=="admin")
		 {
?> 
<input name="quanxian[]" type="checkbox" id="sq" value="3.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"3.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除 <?php
		 }
?></span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"4.1"))>0||strlen(strstr($_SESSION['quanxian'],"4.2"))>0||strlen(strstr($_SESSION['quanxian'],"4.3"))>0||strlen(strstr($_SESSION['quanxian'],"4.4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="30" align="left" valign="middle" class="xia_biank"><span class="STYLE18">资费标准栏目：<?php
         if(strlen(strstr($_SESSION['quanxian'],"4.1"))>0||$_SESSION['username']=="admin")
		 {
?>  <input name="quanxian[]" type="checkbox" id="sq" value="4.1" <?php
         if(strlen(strstr($qxdate['quanxian'],"4.1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"4.2"))>0||$_SESSION['username']=="admin")
		 {
?> 
<input name="quanxian[]" type="checkbox" id="sq" value="4.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"4.2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"4.3"))>0||$_SESSION['username']=="admin")
		 {
?> 
<input name="quanxian[]" type="checkbox" id="sq" value="4.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"4.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"4.4"))>0||$_SESSION['username']=="admin")
		 {
?> 
<input name="quanxian[]" type="checkbox" id="sq" value="4.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"4.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除
<?php } ?>  </span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"5.1"))>0||strlen(strstr($_SESSION['quanxian'],"5.2"))>0||strlen(strstr($_SESSION['quanxian'],"5.3"))>0||strlen(strstr($_SESSION['quanxian'],"5.4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="30" align="left" valign="middle" class="xia_biank"><span class="STYLE18">教员管理：<?php
         if(strlen(strstr($_SESSION['quanxian'],"5.1"))>0||$_SESSION['username']=="admin")
		 {
?>  <input name="quanxian[]" type="checkbox" id="sq" value="5.1" <?php
         if(strlen(strstr($qxdate['quanxian'],"5.1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"5.2"))>0||$_SESSION['username']=="admin")
		 {
?> 

<input name="quanxian[]" type="checkbox" id="sq" value="5.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"5.2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"5.3"))>0||$_SESSION['username']=="admin")
		 {
?> 

<input name="quanxian[]" type="checkbox" id="sq" value="5.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"5.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"5.4"))>0||$_SESSION['username']=="admin")
		 {
?> 

<input name="quanxian[]" type="checkbox" id="sq" value="5.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"5.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除 <?php
 }
?>

                  </span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"6.1"))>0||strlen(strstr($_SESSION['quanxian'],"6.2"))>0||strlen(strstr($_SESSION['quanxian'],"6.3"))>0||strlen(strstr($_SESSION['quanxian'],"6.4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="30" align="left" valign="middle" class="xia_biank"><span class="STYLE18">学员管理：
<?php
         if(strlen(strstr($_SESSION['quanxian'],"6.1"))>0||$_SESSION['username']=="admin")
		 {
?> 
<input name="quanxian[]" type="checkbox" id="sq" value="6.1" <?php
         if(strlen(strstr($qxdate['quanxian'],"6.1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"6.2"))>0||$_SESSION['username']=="admin")
		 {
?> 


<input name="quanxian[]" type="checkbox" id="sq" value="6.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"6.2"))>0)
		 {
			echo "checked"; 
		}
			  ?> >
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"6.3"))>0||$_SESSION['username']=="admin")
		 {
?> 

<input name="quanxian[]" type="checkbox" id="sq" value="6.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"6.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"6.4"))>0||$_SESSION['username']=="admin")
		 {
?> 

<input name="quanxian[]" type="checkbox" id="sq" value="6.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"6.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除 <?php
		 }
?>

                  </span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"7.1"))>0||strlen(strstr($_SESSION['quanxian'],"7.2"))>0||strlen(strstr($_SESSION['quanxian'],"7.3"))>0||strlen(strstr($_SESSION['quanxian'],"7.4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="30" align="left" valign="middle" class="xia_biank"><span class="STYLE18">订单管理：
<?php
         if(strlen(strstr($_SESSION['quanxian'],"7.1"))>0||$_SESSION['username']=="admin")
		 {
?> 
                      
                    <input name="quanxian[]" type="checkbox" id="sq" value="7.1" <?php
         if(strlen(strstr($qxdate['quanxian'],"7.1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"7.2"))>0||$_SESSION['username']=="admin")
		 {
?> 

<input name="quanxian[]" type="checkbox" id="sq" value="7.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"7.2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"7.3"))>0||$_SESSION['username']=="admin")
		 {
?> 

<input name="quanxian[]" type="checkbox" id="sq" value="7.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"7.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"7.4"))>0||$_SESSION['username']=="admin")
		 {
?> 

<input name="quanxian[]" type="checkbox" id="sq" value="7.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"7.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除<?php
		 }
?>

                  </span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"8.1"))>0||strlen(strstr($_SESSION['quanxian'],"8.2"))>0||strlen(strstr($_SESSION['quanxian'],"8.3"))>0||strlen(strstr($_SESSION['quanxian'],"8.4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="30" align="left" valign="middle" class="xia_biank"><span class="STYLE18">财务管理：
<?php
         if(strlen(strstr($_SESSION['quanxian'],"8.1"))>0||$_SESSION['username']=="admin")
		 {
?> <input name="quanxian[]" type="checkbox" id="sq" value="8.1" <?php
         if(strlen(strstr($qxdate['quanxian'],"8.1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"8.2"))>0||$_SESSION['username']=="admin")
		 {
?> 

<input name="quanxian[]" type="checkbox" id="sq" value="8.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"8.2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"8.3"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="8.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"8.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"8.4"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="8.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"8.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除<?php
		 }
?>

</span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"9.1"))>0||strlen(strstr($_SESSION['quanxian'],"9.2"))>0||strlen(strstr($_SESSION['quanxian'],"9.3"))>0||strlen(strstr($_SESSION['quanxian'],"9.4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="30" align="left" valign="middle" class="xia_biank"><span class="STYLE18">广告信息管理：
                        
                       
<?php
         if(strlen(strstr($_SESSION['quanxian'],"9.1"))>0||$_SESSION['username']=="admin")
		 {
?> <input name="quanxian[]" type="checkbox" id="sq" value="9.1" <?php
         if(strlen(strstr($qxdate['quanxian'],"9.1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"9.2"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="9.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"9.2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"9.3"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="9.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"9.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"9.4"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="9.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"9.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除 
<?php
		 }
?>


                  </span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"10.1"))>0||strlen(strstr($_SESSION['quanxian'],"10.2"))>0||strlen(strstr($_SESSION['quanxian'],"10.3"))>0||strlen(strstr($_SESSION['quanxian'],"10.4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="35" align="left" valign="middle" class="xia_biank"><span class="STYLE18">文章|辅导班管理：
                    <?php
                    
         if(strlen(strstr($_SESSION['quanxian'],"10.1"))>0||$_SESSION['username']=="admin")
		 {
			 ?>  
                      <input name="quanxian[]" type="checkbox" id="sq" value="10.1" <?php
         if(strlen(strstr($qxdate['quanxian'],"10.1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"10.2"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="10.2" <?php
         if(strlen(strstr($qxdate['quanxian'],"10.2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"10.3"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="10.3" <?php
         if(strlen(strstr($qxdate['quanxian'],"10.3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"10.4"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="10.4" <?php
         if(strlen(strstr($qxdate['quanxian'],"10.4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除
<?php
		 }
?>

                  </span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"11_1"))>0||strlen(strstr($_SESSION['quanxian'],"11_2"))>0||strlen(strstr($_SESSION['quanxian'],"11_3"))>0||strlen(strstr($_SESSION['quanxian'],"11_4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="35" align="left" valign="middle" class="xia_biank"><span class="STYLE18">资料下载管理：
                 
<?php
         if(strlen(strstr($_SESSION['quanxian'],"11_1"))>0||$_SESSION['username']=="admin")
		 {
?>     
                      <input name="quanxian[]" type="checkbox" id="sq" value="11_1" <?php
         if(strlen(strstr($qxdate['quanxian'],"11_1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"11_2"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="11_2" <?php
         if(strlen(strstr($qxdate['quanxian'],"11_2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"11_3"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="11_3" <?php
         if(strlen(strstr($qxdate['quanxian'],"11_3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"11_4"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="11_4" <?php
         if(strlen(strstr($qxdate['quanxian'],"11_4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除
<?php
		 }
?>
</span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"12_1"))>0||strlen(strstr($_SESSION['quanxian'],"12_2"))>0||strlen(strstr($_SESSION['quanxian'],"12_3"))>0||strlen(strstr($_SESSION['quanxian'],"12_4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="35" align="left" valign="middle" class="xia_biank"><span class="STYLE18">友情链接管理：
               
<?php
         if(strlen(strstr($_SESSION['quanxian'],"12_1"))>0||$_SESSION['username']=="admin")
		 {
?>       
                      <input name="quanxian[]" type="checkbox" id="sq" value="12_1" <?php
         if(strlen(strstr($qxdate['quanxian'],"12_1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"12_2"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="12_2" <?php
         if(strlen(strstr($qxdate['quanxian'],"12_2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"12_3"))>0||$_SESSION['username']=="admin")
		 {
?>


<input name="quanxian[]" type="checkbox" id="sq" value="12_3" <?php
         if(strlen(strstr($qxdate['quanxian'],"12_3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"12_4"))>0||$_SESSION['username']=="admin")
		 {
?>


<input name="quanxian[]" type="checkbox" id="sq" value="12_4" <?php
         if(strlen(strstr($qxdate['quanxian'],"12_4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除
<?php
		 }
?>

<br>
                  </span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"13_1"))>0||strlen(strstr($_SESSION['quanxian'],"13_2"))>0||strlen(strstr($_SESSION['quanxian'],"13_3"))>0||strlen(strstr($_SESSION['quanxian'],"13_4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <tr>
                  <td height="35" align="left" valign="middle" class="xia_biank"><span class="STYLE18">站内信箱管理：
                    
<?php
         if(strlen(strstr($_SESSION['quanxian'],"13_1"))>0||$_SESSION['username']=="admin")
		 {
?>
  
                      <input name="quanxian[]" type="checkbox" id="sq" value="13_1" <?php
         if(strlen(strstr($qxdate['quanxian'],"13_1"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
查看
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"13_2"))>0||$_SESSION['username']=="admin")
		 {
?>


<input name="quanxian[]" type="checkbox" id="sq" value="13_2" <?php
         if(strlen(strstr($qxdate['quanxian'],"13_2"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
新增
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"13_3"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="13_3" <?php
         if(strlen(strstr($qxdate['quanxian'],"13_3"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
修改
<?php
		 }
         if(strlen(strstr($_SESSION['quanxian'],"13_4"))>0||$_SESSION['username']=="admin")
		 {
?>

<input name="quanxian[]" type="checkbox" id="sq" value="13_4" <?php
         if(strlen(strstr($qxdate['quanxian'],"13_4"))>0)
		 {
			echo "checked"; 
		}
			  ?>>
删除
<?php
		 }
?>
<br>
                  </span></td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>
               <?php
		 }
               if(strlen(strstr($_SESSION['quanxian'],"15_1"))>0||strlen(strstr($_SESSION['quanxian'],"15_2"))>0||strlen(strstr($_SESSION['quanxian'],"15_3"))>0||strlen(strstr($_SESSION['quanxian'],"15_4"))>0||$_SESSION['username']=="admin")
		 {
			   ?>
                <?php
		 }
				?>
                <tr>
                  <td height="30" align="center" valign="middle"><span class="STYLE16">
                    <input type="reset" name="Submit2" value="重置" />
                    &nbsp;
                    <input type="button" name="Submit3" value="全选" onClick="selall(document.formsq)">
&nbsp;
<input type="button" name="Submit" value="反选" onClick="optall(document.formsq)">
&nbsp;</span></td>
                  <td align="center" valign="middle">&nbsp;</td>
                </tr>
            </table></td>
          <td width="43%"><table width="100%" height="454" border="0" cellpadding="0" cellspacing="0" class="right_bk">
            
            <tr>
              <td height="454" align="left"><span class="STYLE16">&nbsp;
                  被授权管理员：<?php 
	$bumendate = $bw->selectOnly('username', 'bw_user',"id='".$_GET["id"]."'", '');
	echo $bumendate["username"];
				  ?><br>
                  <br>
&nbsp; 授权管理员：<?php 
	echo $_SESSION['username'];
	?><br>
<br>
                  &nbsp; 
                  <input type="submit" id="act" value="授权">
                  <input name="id" type="hidden" id="id" value="<?php echo $_GET["id"]; ?>">
              </span></td>
            </tr>
              
              
          </table></td>
        </tr></form>
      </table>
    </td>
  </tr>
</table>
</body>
</html>