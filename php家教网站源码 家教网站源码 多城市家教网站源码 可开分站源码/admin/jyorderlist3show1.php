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
<table width="60%" align="center" cellspacing="0">
  <tr class="showtr">
    <td height="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<strong style="font-size:16px">
	<?php if($orderData['ddzt']==2){echo "<font color='#0066CC'>订单成功</font>";}?>
	<?php if($orderData['ddzt']==3){echo "<font color='#ff0000'>订单失败</font>";}?>
	</strong>	</td>
    <td height="30"><?php if(!empty($orderData['cltime'])){echo "处理时间：".$orderData['cltime'];}?>&nbsp;</td>
  </tr>
  <tr class="showtr">
    <td width="120" height="30" align="right">订单编号：</td>
    <td align="left">&nbsp;<span id="ctl00_ContentPlaceHolder1_lblr_id"><?php echo $orderData['id'];?></span> </td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right">学员编号：</td>
    <td align="left">&nbsp;<span id="ctl00_ContentPlaceHolder1_lbls_id"><?php echo $xyData['id'];?></span></td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right">联系人 <span id="ctl00_ContentPlaceHolder1_lbls_name"></span>(学员) ： </td>
    <td align="left">&nbsp;<span id="ctl00_ContentPlaceHolder1_lbls_pname"><?php echo $xyData['name'];?></span></td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right">学员情况：</td>
    <td align="left">
	<span id="ctl00_ContentPlaceHolder1_lbls_detail1"><?php echo $xyData['xylx'];?></span>
	<br /><br />
    <span id="ctl00_ContentPlaceHolder1_lbls_detail2"><?php echo $xyData['xyzk'];?></span> </td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right">教员编号：</td>
    <td align="left">&nbsp;<span id="ctl00_ContentPlaceHolder1_lblt_id"><?php echo $jyData['id'];?></span></td>
  </tr>
  <tr class="showtr">
      <td height="30" align="right">教员姓名：</td>
      <td align="left">&nbsp;<?php echo $jyData['truename'];?></td>
    </tr>
  <tr class="showtr">
    <td height="30" align="right">信息费：</td>
    <td align="left"><?php echo $xyData['xxf'];?>&nbsp;</td>
  </tr>
  <?php
  if($xyData['sfhy']==1)
  {
  ?>
  <tr class="showtr">
    <td height="30" align="right">会员费：</td>
    <td align="left"><?php echo $xyData['hyf'];?>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
  <tr class="showtr">
    <td height="30" align="right">备注：</td>
    <td align="left"><label>
      <textarea name="bz" cols="50" rows="6" id="bz"><?php echo $orderData['yyqk'];?></textarea>
      <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
    </label></td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right">信息费：</td>
    <td align="left"><label>
      <input name="xxf" type="text" id="xxf" />
    (无此项请留空)</label></td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right">会员费：</td>
    <td align="left"><input name="hyf" type="text" id="hyf" />
(无此项请留空)</td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right">违约款：</td>
    <td align="left"><input name="wyk" type="text" id="wyk" />
(无此项请留空)</td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right">业务员：</td>
    <td align="left"><input name="ywy" type="text" id="ywy"  value="<?php if(!empty($orderData['username'])){echo $orderData['username'];}else{echo $_SESSION['username'];}?>" /></td>
  </tr>
  <tr class="showtr">
    <td height="30" align="right">订单处理情况：</td>
    <td align="left"><label>
      <input type="radio" name="ddzt" value="2" <?php if($orderData['ddzt']==2){echo "checked='checked'";}?> />
    成功
     <input type="radio" name="ddzt" value="3" <?php if($orderData['ddzt']==3){echo "checked='checked'";}?> />
    失败</label></td>
  </tr>
  <tr>
      <td height="50" colspan="2" align="center"><?php
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
    <td height="50" colspan="2" align="center"><a href="jyorderlist3.php">《《返回》》</a></td>
  </tr>
</table>
</form>
</body>
</html>