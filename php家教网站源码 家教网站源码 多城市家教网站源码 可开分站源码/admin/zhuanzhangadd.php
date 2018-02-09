<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	//selectOnly($param,$tbname,$where,$order)
	htqx("8.1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>增加新闻信息</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="editor/xheditor-zh-cn.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $('#content').xheditor({tools:'Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,Align,List,Outdent,Indent,|,Link,Unlink,Img,|,Source',skin:'o2007silver',upBtnText:"上传",html5Upload:"true",upMultiple:"99",upLinkUrl:"{editorRoot}uploadTxt.php",upLinkExt:"zip,rar,txt,pdf",upImgUrl:"{editorRoot}uploadImg.php",upImgExt:"jpg,jpeg,gif,png"});
	});
</script>
</head>

<body>
<?php
$action = $_GET['action'];
if($action == 'insert')
{
htqx("8.2");
	if($userData = $bw->selectOnly('money,id', 'bw_member', "truename = '{$_POST['uname']}' and id= '{$_POST['mid']}' "))
	{       
			$_POST["amount"]=$_POST["fuhao"].$_POST["amount"];
	        unset($_POST['mid']);
	        unset($_POST['fuhao']);
			unset($_POST['uname']);
	        $amount=$_POST["amount"];
			//$memberid=$_POST["memberid"];
			$_POST["away"]=$_POST["away"];
            $_POST["memberid"]=$userData['id'];
			$_POST["amount"]=$_POST["amount"];
			$_POST["recordno"]=$out_trade_no = "Y".date(Ymdhms);
			$_POST["addtime"]=date("Y-m-d H:i:s");
			$_POST["atype"]=1;
			$_POST["lang"]=$Lang;
			$_POST["username"]=$_POST["username"];
			$bw->insert('bw_moneyrecord', $_POST);
			unset($_POST);
			$_POST["money"]=$userData["money"]+($amount);
			//echo $userData["money"]+$_POST["amount"];
			$bw->update('bw_member', $_POST, "id = ".$userData['id']);
			$bw->msg('操作成功!');
	}
	else
	{
		$bw->msg('操作错误!请输入正确信息!');
	}
}
?>
<form action="?action=insert" method="post" enctype="multipart/form-data">
<table width="788" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="35" align="right">会员编号：</td>
    <td>&nbsp;</td>
    <td><input name="mid" class="textBox" id="mid" value="" /></td>
  </tr>
  <tr>
    <td width="152" height="35" align="right">会员姓名：</td>
    <td width="10">&nbsp;</td>
    <td width="630"><input name="uname" class="textBox" id="uname" value="" />
      &nbsp;</td>
  </tr>
  <tr>
    <td width="152" height="35" align="right">费用类型：</td>
    <td width="10">&nbsp;</td>
    <td><select name="acontent" id="acontent">
      <option value="1">预存款</option>
      <option value="2">认证费</option>
      <option value="3">违约款</option>
      <option value="4">信息费</option>
      <option value="5">退款</option>
      <option value="6">会员费</option>
	  <option value="7">其他</option>
    </select>
    <select name="yinhang" id="yinhang">
      <option value="1">建设银行</option>
      <option value="2">中国银行</option>
      <option value="3">工商银行</option>
      <option value="4">招商银行</option>
      <option value="5">邮政银行</option>
      <option value="6">交通银行</option>
      <option value="10">农业银行</option>
      <option value="7">信用社</option>
	  <option value="8">其他</option>
    </select></td>
  </tr>
  <tr>
    <td height="35" align="right">金额：</td>
    <td>&nbsp;</td>
    <td>
      <select name="fuhao" id="fuhao">
        <option value="+">增加</option>
        <option value="-">减少</option>
      </select>
      <input name="amount" class="textBox" id="amount" value="" style="width:200px;" /></td>
  </tr>
  <tr>
    <td height="35" align="right">转账方式：</td>
    <td>&nbsp;</td>
    <td><input name="away" class="textBox" id="away" value="" />
    如工行转账</td>
  </tr>
  <tr>
    <td height="35" align="right">业务员：</td>
    <td>&nbsp;</td>
    <td><input name="username" class="textBox" id="username" value="<?php echo $_SESSION['username'];?>" /></td>
  </tr>
  <tr>
    <td height="35" align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" class="subBtn" value=" 提 交 " />&nbsp;<input type="reset" class="subBtn" value=" 重 置 " /></td>
  </tr>
</table>
</form>
</body>
</html>