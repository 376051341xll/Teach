<?php
	require '../inc/shell.php';
	require '../inc/config.php';
	$Lang=$_SESSION["Lang_session"];
	$diaoquData = $bw->selectOnly('*', 'bw_config', 'id = 1', '');
	//selectOnly($param,$tbname,$where,$order)
	//unset($_SESSION['wherememberlist']); 
	if(empty($_GET["id"]))
	{
	htqx("7.2");
	}else{
	htqx("7.3");
		 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员信息列表</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<style>
td{ padding:5px;}
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</head>
<body>
<?php
$act=$_GET["act"];
if(!empty($act) && $act=="add")
{
                $ddzts=$_POST['ddzt'];
			   
				$sql = "UPDATE bw_order SET ddzt = ".$ddzts.",cltime= '".date("Y-m-d H:i:s")."' WHERE id = ".$_POST['id']."";
				$bw->query($sql);

				 $oData = $bw->selectOnly('jyid,xyid', 'bw_order', "id = ".$_POST['id']);
					if($ddzts==2)//订单成功时候的处理
					{
						$sqls = "UPDATE bw_qjj SET isshow = 1,zt='成功' WHERE id = ".$oData['xyid'];
						$bw->query($sqls);
						
						$jyData = $bw->selectOnly('*', 'bw_member', "id = ".$oData['jyid']);
						
						//扣除信息费
						if(!empty($_POST['xxf']))
						{
						$sqlstr="INSERT INTO bw_moneyrecord (memberid,atype,recordno,addtime,acontent,away,amemo,amount,lang,username) VALUES (".$jyData["id"].",1,'"."Y".date(Ymdhms)."','".date('Y-m-d H:i:s')."',4,'订单成功扣除信息费','订单成功扣除信息费','"."-".$_POST['xxf']."','".$Lang."','".$_POST['ywy']."')";
						$bw->query($sqlstr);
						
						$sqlxxf = "UPDATE bw_member SET Money = Money-".$_POST['xxf']." WHERE id = '".$jyData['id']."'";
						$bw->query($sqlxxf);
						}
						//扣除会员费
						if(!empty($_POST['hyf']))
						{
						$sqlstrs="INSERT INTO bw_moneyrecord (memberid,atype,recordno,addtime,acontent,away,amemo,amount,lang,username) VALUES (".$jyData["id"].",1,'"."Y".date(Ymdhms)."','".date('Y-m-d H:i:s')."',6,'订单成功扣除会员费','订单成功扣除会员费','"."-".$_POST['hyf']."','".$Lang."','".$_POST['ywy']."')";
						$bw->query($sqlstrs);
						
						$sqlhyf = "UPDATE bw_member SET Money = Money-".$_POST['hyf']." WHERE id = '".$jyData['id']."'";
						$bw->query($sqlhyf);
						}

				    }
					elseif($ddzts==3)//订单失败后的处理
					{
				// die($oData['jyid']);
					$sqls = "UPDATE bw_qjj SET isshow = 1,zt='未安排' WHERE id = ".$oData['xyid'];
					$bw->query($sqls);
					//die($sqls);
					
					    //扣除违约款
						if(!empty($_POST['wyk']))
						{
						$jyData = $bw->selectOnly('*', 'bw_member', "id = ".$oData['jyid']);
						
						$sqlstrs="INSERT INTO bw_moneyrecord (memberid,atype,recordno,addtime,acontent,away,amemo,amount,lang,username) VALUES (".$jyData["id"].",1,'"."Y".date(Ymdhms)."','".date('Y-m-d H:i:s')."',3,'扣除违约款','扣除违约款','"."-".$_POST['wyk']."','".$Lang."','".$_POST['ywy']."')";
						$bw->query($sqlstrs);
						 
						$sqlwyk = "UPDATE bw_member SET Money = Money-".$_POST['wyk']." WHERE id = '".$jyData['id']."'";
						$bw->query($sqlwyk);
						}
				    }

    if(!empty($_POST['bz']))
	{
		$sql = "UPDATE bw_order SET yyqk = '".$_POST['bz']."' WHERE id = ".$_POST['id']."";
		$bw->query($sql);
	}
	$bw->msg('操作成功!','jyorderlist3show.php?id='.$_POST['id'].'');
}
?>
<?php
$orderData = $bw->selectOnly('*' ,'bw_order', 'id = '.$_GET['id']);
$xyData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$orderData['xyid']);
$jyData = $bw->selectOnly('*' ,'bw_member', 'id = '.$orderData['jyid']);
?>
<form action="?act=add" method="post">
<table align="center" cellspacing="1" bgcolor="#EAF4FD">
  <tr class="showtr">
    <td height="30" colspan="8" align="center" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <strong style="font-size:16px">
        <?php if($orderData['ddzt']==2){echo "<font color='#0066CC'>订单成功</font>";}?>
        <?php if($orderData['ddzt']==3){echo "<font color='#ff0000'>订单失败</font>";}?>
      </strong>	<?php if(!empty($orderData['cltime'])){echo "处理时间：".$orderData['cltime'];}?>&nbsp;</td>
    </tr>
  <tr class="showtr">
    <td height="30" align="right" bgcolor="#FFFFFF">订单编号：</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;<span id="ctl00_ContentPlaceHolder1_lblr_id"><?php echo $orderData['id'];?></span> </td>
    <td align="right" bgcolor="#FFFFFF">学员编号：</td>
    <td align="left" bgcolor="#FFFFFF"><?php echo $xyData['id'];?></td>
    <td align="right" bgcolor="#FFFFFF">联系人：</td>
    <td align="left" bgcolor="#FFFFFF"><?php echo $xyData['name'];?></td>
    <td align="right" bgcolor="#FFFFFF">学员类型：</td>
    <td align="left" bgcolor="#FFFFFF"><?php echo $xyData['xylx'];?></td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right" bgcolor="#FFFFFF">信息费：</td>
    <td align="left" bgcolor="#FFFFFF"><?php echo $xyData['xxf'];?></td>
    <td align="right" bgcolor="#FFFFFF">会员费：</td>
    <td align="left" bgcolor="#FFFFFF"><?php echo $xyData['hyf'];?>&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">学员情况：</td>
    <td colspan="3" align="left" bgcolor="#FFFFFF" style="word-wrap:break-word;word-break:normal;"><div style="width:300px;"><?php echo $xyData['xyzk'];?></div></td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right" bgcolor="#FFFFFF">教员编号：</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;<span id="ctl00_ContentPlaceHolder1_lblt_id"><?php echo $jyData['id'];?></span></td>
    <td align="right" bgcolor="#FFFFFF">教员姓名：</td>
    <td align="left" bgcolor="#FFFFFF"><?php echo $jyData['truename'];?></td>
    <td align="right" bgcolor="#FFFFFF">信息费：</td>
    <td align="left" bgcolor="#FFFFFF"><input name="xxf" type="text" id="xxf" style="width:50px" />
      <br />
(无此项请留空)</td>
    <td align="right" bgcolor="#FFFFFF">会员费：</td>
    <td align="left" bgcolor="#FFFFFF"><input name="hyf" type="text" id="hyf" style="width:50px;" />
      <br />
      (无此项请留空)</td>
  </tr>
  <tr class="showtr">
      <td height="30" align="right" bgcolor="#FFFFFF">违约款：</td>
      <td align="left" bgcolor="#FFFFFF"><input name="wyk" type="text" id="wyk" style="width:50px;" />
        <br />
(无此项请留空)</td>
      <td align="right" bgcolor="#FFFFFF">业务员：</td>
      <td colspan="5" align="left" bgcolor="#FFFFFF"><input name="ywy" type="text" id="ywy"  value="<?php if(!empty($orderData['username'])){echo $orderData['username'];}else{echo $_SESSION['username'];}?>" /></td>
    </tr>
  <?php
  if($xyData['sfhy']==1)
  {
  ?>
  <?php
  }
  ?>
  <tr class="showtr">
    <td height="30" align="right" bgcolor="#FFFFFF">备注：</td>
    <td colspan="7" align="left" bgcolor="#FFFFFF"><label>
      <textarea name="bz" cols="50" rows="6" id="bz"><?php echo $orderData['yyqk'];?></textarea>
      <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
      </label></td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right" bgcolor="#FFFFFF">订单处理情况：</td>
    <td colspan="7" align="left" bgcolor="#FFFFFF"><label>
      <input type="radio" name="ddzt" value="2" <?php if($orderData['ddzt']==2){echo "checked='checked'";}?> />
      成功
      <input type="radio" name="ddzt" value="3" <?php if($orderData['ddzt']==3){echo "checked='checked'";}?> />
      失败</label></td>
    </tr>
  <tr>
      <td height="50" colspan="8" align="center" bgcolor="#FFFFFF"><?php
      if(($orderData['ddzt']==2||$orderData['ddzt']==3)&&$_SESSION['username']!="admin")
	  {
		  echo "<span style='color:#ff0000;'>您不能修改当前内容</span>";
		  }else
		  {
	  ?><label>
        <input type="submit" name="Submit" value="提交" />&nbsp;&nbsp;&nbsp;
        <input type="reset" name="Submit2" value="重置" />
      </label><?php
		  }
	  ?></td>
  </tr>
  <tr>
    <td height="50" colspan="8" align="center" bgcolor="#FFFFFF"><a href="jyorderlist3.php">《《返回》》</a></td>
  </tr>
</table>
</form>
</body>
</html>