<?php
		session_start();
if(!empty($_GET["lang"])){
setcookie("cookie_lang",base64_decode(iconv("gb2312","utf-8",$_GET["lang"])), time()+2592000);
echo "<script language='javascript'>	window.location.href='index.php';  </script>";
}
if($_COOKIE["cookie_lang"]=="")
{
setcookie("cookie_lang","宁波站", time()+2592000);
echo "<script language='javascript'>	window.location.href='index.php';  </script>";
}
	include 'inc/config.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0054)#?WT.mc_id=c03-BDPP-101&WT.srch=1 -->
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>宁波家教网</TITLE>
<META http-equiv=content-type content="text/html; charset=utf-8">
<META content="" name=description>
<META content="" name=keywords>
<META content=1 name=SmartView_Page>
<META content="本页版权归宁波家教网所有。all rights reserved" name=copyright>
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico"><META content="MSHTML 6.00.2900.6082" name=GENERATOR>
</HEAD>
<BODY>
<?php
$classList = $bw->selectMany("xyid","bw_order","jyid=".$_SESSION["userid"]." and ddzt=1 and ifdd=2","`id` DESC");
		//var_dump($classList);
		//exit;
		$xyid1="";
		$menu_sum = count($classList);
		for($i = 0; $i<$menu_sum; $i++)
		{
			if($xyid1=="")
			{
			$xyid1=$classList[$i]["xyid"];
			}else{
			$xyid1=$xyid1.",".$classList[$i]["xyid"];
				 }
		}
if (!empty($xyid1))
{
$tuik = $bw->selectOnly('sum(xxf) as xxz,sum(hyf) as hyz' ,'bw_qjj', 'id in ('.$xyid1.')');
$tuikz=$tuik["xxz"]+$tuik["hyz"]."";
}
if($_GET["act"]=="tk"&&!empty($_GET["id"]))
{
	if($bw->delete("bw_withdraw","id=".$_GET["id"]))
	{
	$bw->msg('取消成功', 'user_sqtk.php');
	exit;
	}else{
	$bw->msg('取消失败', 'user_sqtk.php');
	exit;
		}
}
if($_GET["action"]=="add")
{
$tuik = $bw->selectOnly('money' ,'bw_member', 'id = '.$_SESSION["userid"]);
if(($tuik["money"]-$tuikz)<$_POST["amount"])
{
	$bw->msg('您输入的退款余额不足！', 'user_sqtk.php');
	exit;
	}
//die($tuik["money"]);
if($bw->insert('bw_withdraw', $_POST))
		{
		 
			$bw->msg('成功提交申请，我们将及时处理您的申请!', 'user_sqtk.php');
		}else{
			$bw->msg('提供申请不成功，请重试一下!', 'user_sqtk.php');
		}
}
?>
<?php include("top.php");?>
<!-- header end-->
<div class="user_c">
<div class="user_left">
<?php include("user_left.php");?>
</div>
<div class="user_right">
     <div id="xcrz_tltle">申请退款</div>
     <div id="xcrz_nr">
      <table width="748" border="0" bgcolor="#C9C9C9" cellspacing="1" cellpadding="0">
        <tr>
          <td width="746" height="30" align="left" valign="middle" bgcolor="#F1F1F1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 账户余额： 
            <font style="font-size:16px; font-weight:bold">
            <?
$classData = $bw->selectOnly('money' ,'bw_member', 'id = '.$_SESSION["userid"]);
echo $classData['money'];
?>
          </font> &nbsp; 元</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table width="746" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="50" align="left" valign="middle"><form id="form1" name="form1" method="post" action="?action=add">
          <table width="600" border="0" align="left" cellpadding="0" cellspacing="5">
            <tr>
              <td width="99" height="30"><div align="right">申请退款金额：</div></td>
              <td width="471"><input name="amount" type="text" id="amount" value="<?php if($classData['money']-$tuikz>0)
		{
			echo $classData['money']-$tuikz;
			}else{
				echo "0";
				 }
			  ?>" />
                元</td>
            </tr>
            <tr>
              <td height="30" align="right">退款银行：</td>
              <td><input type="text" name="yinh" id="yinh">
                *</td>
            </tr>
            <tr>
              <td height="30" align="right">户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 名：</td>
              <td><input type="text" name="huming" id="huming">
                *</td>
            </tr>
            <tr>
              <td height="30" align="right">银行账号：</td>
              <td><input type="text" name="zhanghao" id="zhanghao">
                *</td>
            </tr>
            <tr>
              <td height="30" align="right">开卡所在地：</td>
              <td><input type="text" name="add1" id="add1">
                *</td>
            </tr>
            <tr>
              <td height="30"><div align="right">申请退款原因：</div></td>
              <td><textarea name="reason" cols="38" rows="6" id="reason"></textarea>
                <input name="mid" type="hidden" id="mid" value="<?php echo $_SESSION["userid"];?>" />
                <input name="addtime" type="hidden" id="addtime" value="<?php echo date("Y-m-d H:i:s");?>">
				<input name="lang" type="hidden" id="lang" value="<?php echo $_COOKIE["cookie_lang"];?>">
				</td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td><label>
                <input type="submit" value="立即申请" />
              </label></td>
            </tr>
          </table>
                </form> </td>
              </tr>
          </table></td>
        </tr>
      </table>
      <div style="margin-top:8px;">
        <table width="748" id="sj" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
          <tr>
            <td width="161" height="29" align="center" bgcolor="#FFFFFF" class="tdbg">申请时间</td>
            <td width="105" align="center" bgcolor="#FFFFFF" class="tdbg">退款金额</td>
            <td width="221" align="center" bgcolor="#FFFFFF" class="tdbg">退款理由</td>
            <td width="88" align="center" bgcolor="#FFFFFF" class="tdbg">退款情况</td>
            <td width="167" align="center" bgcolor="#FFFFFF" class="tdbg">备&nbsp;&nbsp;注</td>
          </tr>
         <?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_withdraw";
  $where    = 'mid='.$_SESSION["userid"];
  //搜索
		$_SESSION['wherejflist'] = $where;
 // die($_SESSION['wherejflist']);
  $list = $bw->selectPage("*",$tbName,$_SESSION['wherejflist'],"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$_SESSION['wherejflist'],$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
          <tr>
            <td height="30" align="center" bgcolor="#FFFFFF"><?php echo $list[$i]['addtime']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo $list[$i]['amount']; ?>元</td>
            <td align="center" bgcolor="#FFFFFF"><?php echo $list[$i]['reason']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><?php  switch ($list[$i]['ispass'])
		{
		case 0: echo "<font color='#FF6600'>申请中</font>";break;
		case 1: echo "<font color='#0000ff'>已受理申请</font>";break;
		case 2: echo "<font color='#006600'>退款成功</font>";break;
		case 3: echo "<font color='#ff0000'>申请未通过</font>";break;
		}?></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo $list[$i]['memo']; ?>
              &nbsp;  <input type="button" name="button" id="button" value="取消退款" onclick="javascript:if(confirm('您确定要取消退款吗？')){window.location.href='?act=tk&id=<?php echo $list[$i]['id']; ?>'}"></td>
          </tr>
          <?php
	}//end loop
?>
          <tr>
            <td height="30" colspan="5" align="center" bgcolor="#FFFFFF">共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp; <a href="?page=1">第一页</a>&nbsp;&nbsp; <a href="?page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp; <a href="?page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp; <a href="?page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
              跳到
              <select name="page_SEL" id="page_SEL">
                          <option value="">---</option>
                          <?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
                          <option value="<?php echo $goPage; ?>"><?php echo $goPage; ?></option>
                          <?php
						 }
						?>
                      </select></td>
          </tr>
          <tr>
            <td height="30" colspan="5" align="center" bgcolor="#F7F7F7">充值记录可能存在延时，仅供参考，请以实际金额变化为准</td>
          </tr>
        </table>
      </div>
    </div>
</div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
