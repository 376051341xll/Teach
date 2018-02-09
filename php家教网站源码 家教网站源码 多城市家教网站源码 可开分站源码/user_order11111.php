<?php  session_start();
if(!empty($_GET["lang"])){
setcookie("cookie_lang",base64_decode(iconv("gb2312","utf-8",$_GET["lang"])), time()+2592000);
echo "<script language='javascript'>	window.location.href='index.php';  </script>";
}
if($_COOKIE["cookie_lang"]=="")
{
setcookie("cookie_lang","宁波站", time()+2592000);
echo "<script language='javascript'>	window.location.href='index.php';  </script>";
}
 include("inc/config.php");
 include("checkuser.php");
  ?>
<?php
if(!empty($_POST["xyid"]))
{
	$classData = $bw->selectOnly('money,sex,ifrz' ,'bw_member', 'id = '.$_SESSION["userid"]);
	$xyData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$_POST["xyid"]);
	if($classData["sex"]==1)
	{
		$sex="男";
		}else{
		$sex="女";
			}
	$sex1=1;
	if(!empty($xyData["jysex"])&&$xyData["jysex"]!="不限")
	{
		if($xyData["jysex"]!=$sex)
		{
			$sex1=2;
			}
		}
	//die($xyData['xxf']);
	if($classData["ifrz"]==1)
	{
	$bw->msg('您未通过认证，申请失败。马上认证？',"user_wsrz.php");
		exit;
	}elseif($classData["ifrz"]==3)
	{
	$bw->msg('您的认证已过期，请重新认证。立即认证？',"user_wsrz.php");
		exit;
	}elseif($levels["ifrz"]!=$xyData["zgyq"] || $sex1==2)
	{
	$bw->msg('您不符合家教要求，请关注其他订单信息！',"students.php");
		exit;
	}
	elseif($classData['money']>$xyData['xxf'])
	{
	$sqlstr="INSERT INTO bw_order (xyid,jyid,yylx,subtime,lang) VALUES ({$_POST['xyid']},{$_SESSION['userid']},1,'".date('Y-m-d')."','".$_COOKIE["cookie_lang"]."')";
	//die($sqlstr);
	$bw->query($sqlstr);
	$bw->msg('预约成功，请您等待后台审核!');
	echo "<script>window.close();</script>";
	exit;
	}else{
		$bw->msg('不满足要求，或者是您的金额不够',"studentshow.php?id=".$_POST["xyid"]);
		exit;
		}
	}
?>