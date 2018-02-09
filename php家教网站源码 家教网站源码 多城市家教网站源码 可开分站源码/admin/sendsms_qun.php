<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	$diaoquData = $bw->selectOnly('*', 'bw_config', 'lang="'.$Lang.'"', '');
		if( $_GET['act']=="k")
	{
		$_SESSION['wheredx_qun_qun']="";
		}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>短信发送DEMO</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<!--<script type="text/javascript" src="editor/xheditor-zh-cn.min.js"></script>-->
<style>
td{
font-size:12px;}
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
<script language="JavaScript"><!--
function moveOption(e1, e2){
		 a=1;
     try{
         var e = e1.options[e1.selectedIndex];
		  for (i=0;i<e2.length;i++) {
			if(e2.options[i].value==e.value)
			{
				a=2
				}  
		  }
		  if (a==1&&e.value.length!=0)
		  {
			// alert(e.value.length)
         e2.options.add(new Option(e.text, e.value));
		  }
     }    catch(e){}
}
function suoyou(e1, e2){
     try{
         //var e = e1.options;
		 //alert(e1.options.length)
		  for (i=0;i<e1.options.length;i++) 
		  {
		 a=1;
				  for (j=0;j<e2.length;j++) 
				  {
						if(e2.options[j].value!=e1.options[i].value)
							{
							a=2
							}  
		 		 }
				if(a==2)
				{
				 e2.options.add(new Option(e1.options[i].text, e1.options[i].value));
				}
		  }
     }    catch(e){}
}
     function sc(e1)
	 {
         var e = e1.options[e1.selectedIndex];
		 e1.options.remove(e1.selectedIndex);
		 }	
	 function inputs(a,b){
    var aa,bb;
    aa=document.getElementById(a);
     document.getElementById(b).value="";
    for (i=0;i<aa.length;i++) {
	 bb=document.getElementById(b).value+",";	
     document.getElementById(b).value=bb+aa.options[i].value;
     //alert(aa.options[i].value);
    }
   }
//--></script>
</head>

<body>
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<tr>
<form name="searchForm" action="?action=search" method="post">
<td align="center">关键字:
  <select name="guanjianlei" id="guanjianlei">
      <option value="">关键字类型</option>
      <option value="id">教员编号</option>
      <option value="kjskm">授课科目</option>
      <option value="xuexiao">毕业/就读高校</option>
      <option value="telphone">电话</option>
      <option value="truename">姓名</option>
      <option value="zhuanye">专业</option>
  </select>
  <input name="keyword" id="keyword" />&nbsp;
  <select name="sex" id="sex">
      <option value="">性别</option>
      <option value="1">男</option>
      <option value="2">女</option>
  </select>
  <select name="diqu" id="diqu">
      <option value="">选择区域</option><?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>"><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
  </select>
  <select name="leixing" id="leixing">
    <option value="">选择类型</option>
    <option value="1">大学生</option>
    <option value="2">职业教师</option>
    <option value="3">留学、海归</option>
    <option value="4">其他人员</option>
  </select>
  <select name="xiang" id="xiang">
    <option value="">所有教员</option>
    <option value="1">待认证</option>
    <option value="2">已认证</option>
    <option value="3">未发布</option>
  </select>
  短信模板:
        <select name="mb" id="mb">
            <option value="">————请选择————</option>
		<?php
			$classList = $bw->selectMany("id,title","bw_dxmb","lang='".$Lang."'","`id` DESC");
			$menu_sum = count($classList);
			for($i = 0; $i<$menu_sum; $i++)
			{
		?>
            <option value="<?php echo $classList[$i]['id'];?>"><?php echo $classList[$i]['title'];?></option>
		<?php
			}
		?>
        </select>
  &nbsp;  <input type="submit" value="搜索" /></td>
</form>
</tr>
</table>
<table width="1000" height="343" align="center">
<form action="send_action_qun.php" method="post" name="formSend" class="STYLE3" onSubmit="return check()">
<tr>
  <td width="242" height="3"></td>
  <td width="700"></td>
  <td width="207"></td>
</tr>
<tr>
  <td></td>
  <td width="700"><div align="center" >短信发送</div></td>
  <td></td>
</tr>
<tr>
  <td height="93" align="right">手机号：</td>
  <td colspan="2" valign="middle">
<!--<textarea name="mobile" cols="60" rows="5"></textarea>-->

<table width="548" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200" height="200"><select size="30" id="list1" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list2)">
          <?php
if(!empty($_GET['action']) && $_GET['action'] == 'search'){
$tbName  = "bw_member";
$where   = '1=1 and dxjs =1 and lang="'.$Lang.'"  ';
	  if(!empty($_POST['keyword']) && !empty($_POST['guanjianlei']))
	  {
		$where = $where." and ".$_POST['guanjianlei']." LIKE '%".$_POST['keyword']."%'";
		$_SESSION['wheredx_qun'] = $where;
	  }
	  if(!empty($_POST['sex']))
	  {
		$where = $where." and sex= '".$_POST['sex']."'";
		$_SESSION['wheredx_qun'] = $where;
	  }
	  if(!empty($_POST['sex']))
	  {
		$where = $where." and sex= '".$_POST['sex']."'";
		$_SESSION['wheredx_qun'] = $where;
	  }
	  if(!empty($_POST['diqu']))
	  {
		$where = $where." and quyu like '%".$_POST['diqu']."%'";
		$_SESSION['wheredx_qun'] = $where;
	  }
	  if(!empty($_POST['leixing']))
	  {
		$where = $where." and levels =".$_POST['leixing'];
		$_SESSION['wheredx_qun'] = $where;
	  }
	  if($_POST['xiang']==1)
	  {
		$where = $where." and ifrz =1";
		$_SESSION['wheredx_qun'] = $where;
	  }
	  if($_POST['xiang']==2)
	  {
		$where = $where." and ifrz =2";
		$_SESSION['wheredx_qun'] = $where;
	  }
	  if($_POST['xiang']==3)
	  {
		$where = $where." and iffb =1";
		$_SESSION['wheredx_qun'] = $where;
	  }
	  if($_SESSION['wheredx_qun']=="")
	  {
		  $_SESSION['wheredx_qun'] = $where;
	  }
 // die($_SESSION['wheredx_qun']);
$classList = $bw->selectMany("id,telphone,truename",$tbName,$_SESSION['wheredx_qun'],"`id` desc");
$menu_sum = count($classList);
for($i = 0; $i<$menu_sum; $i++)
{
?>

<option value="<?php echo $classList[$i]['telphone'];?>"><?php echo $classList[$i]['telphone'];?>&nbsp;&nbsp;<?php echo $classList[$i]['truename'];?></option>
<?php
}
}
?>
          </select></td>
        <td width="136" align="center"><input type="button" id="button" value=" 增加 &gt;&gt; " onClick="moveOption(this.form.list1, this.form.list2);inputs('list2','mobile')" />
          <br>
          <br>
<input type="button" id="button" value=" 增加全部 &gt;&gt; " onClick="suoyou(this.form.list1, this.form.list2);inputs('list2','mobile')"  />
          <br />
          <span style="color:#F00; text-align:left;">(选中左侧项目点&quot;选取&quot;即可添加；选中右侧项目点 &quot;删除&quot;即可删除)
            <input type="hidden" name="mobile" id="mobile" value="" />
            </span> <br />
          <input type="button" id="button2" value=" &lt;&lt; 删除 " onClick="sc(this.form.list2);inputs('list2','mobile')" />
          <br>
          <br>
<input type="button" id="button2" value=" &lt;&lt; 删除所有 " onClick="javascript:document.getElementById('list2').options.length=0;document.getElementById('mobile').value='';" /></td>
        <td width="212" align="left"><select size="30" id="list2" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list1)">
          <option value=""></option>
          </select></td>
        </tr>
      </table>


</td>
  </tr>
<tr>
  <td height="93" align="right">内&nbsp;&nbsp;&nbsp;&nbsp;容：</td>
  <td colspan="2"><textarea name="content" class="editor" id="content" cols="40" rows="5"><?php
if(!empty($_GET['action']) && $_GET['action'] == 'search' && $_POST['mb']!=""){
$dxmbData = $bw->selectOnly('*' ,'bw_dxmb', 'id = '.$_POST['mb']);
echo $dxmbData ['content'];
}
?></textarea></td>
  </tr>
<tr>
  <td></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td></td>
  <td>&nbsp;</td>
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