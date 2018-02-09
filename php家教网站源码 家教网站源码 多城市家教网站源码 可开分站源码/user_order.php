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
    $orderList = $bw->selectMany('*' ,'bw_order', 'xyid = '.$_POST["xyid"]);
	$menu_sum = count($orderList);
	for($i = 0; $i<$menu_sum; $i++)
	{
		if($orderList[$i]["jyid"]==$_SESSION["userid"])
		{
		   $bw->msg('您已经申请过此订单，请关注其他订单信息！',"students.php");
		   exit;
		}
	}
	$classData = $bw->selectOnly('money,sex,ifrz,levels,ifxj' ,'bw_member', 'id = '.$_SESSION["userid"]);
	$xyData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$_POST["xyid"]);
	if($xyData["ifxj"]==5)
	{
		if($classData["ifxj"]<3||$classData["ifxj"]==6||$classData["levels"]!=2)
		{
			$bw->msg('您不符合家教要求，请关注其他订单信息！1',"students.php");
				exit;
		}
	}
	if($xyData["ifxj"]==6)
	{
		if($classData["ifxj"]<3||$classData["ifxj"]==6||$classData["levels"]!=1)
		{
			$bw->msg('您不符合家教要求，请关注其他订单信息！2',"students.php");
				exit;
		}
		
	}
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
	
	if($xyData["zgyq"]==1)
	{
	  // die ($xyData["zgyq"]."...........".$classData["levels"]);
			if($classData["levels"]==2 || $sex1==2)
			{
			$bw->msg('您不符合家教要求，请关注其他订单信息！3',"students.php");
				exit;
			}
		
		}elseif($xyData["zgyq"]==2){
		 //die ($xyData["zgyq"]."...........".$classData["levels"]);
		    if($classData["levels"]!=2 || $sex1==2)
			{
			$bw->msg('您不符合家教要求，请关注其他订单信息！4',"students.php");
				exit;
			}
		
	}

	if($classData["ifrz"]==1)
	{
	$bw->msg('您未通过认证，申请失败。马上认证？',"user_wsrz.php");
		exit;
	}elseif($classData["ifrz"]==3)
	{
	$bw->msg('您的认证已过期，请重新认证。立即认证？',"user_wsrz.php");
		exit;
	}
	else
	{
	$sqlstr="INSERT INTO bw_order (xyid,jyid,yylx,addtime,ifnew,lang) VALUES ({$_POST['xyid']},{$_SESSION['userid']},1,'".date('Y-m-d H:i:s')."',1,'".$_COOKIE["cookie_lang"]."')";
	//die($sqlstr);
	$bw->query($sqlstr);
	$bw->msg('预约成功，请您等待后台审核!');
	echo "<script>window.close();</script>";
	exit;
	}
}
?>