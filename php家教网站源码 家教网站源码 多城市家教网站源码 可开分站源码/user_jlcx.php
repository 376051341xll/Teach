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
<?php include("top.php");?>
<!-- header end-->
<div class="user_c">
<div class="user_left">
<?php include("user_left.php");?>
</div>
<div class="user_right">
     <div id="xcrz_tltle">记录查询</div>
    <div id="xcrz_nr">
      <table width="748" border="0" bgcolor="#C9C9C9" cellspacing="1" cellpadding="0">
        <tr>
          <td width="746" height="30" align="left" valign="middle" bgcolor="#F1F1F1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 账户余额</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table width="746" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="503" height="50" align="left" valign="middle">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <font style="font-size:16px; font-weight:bold"><?
$classData = $bw->selectOnly('money' ,'bw_member', 'id = '.$_SESSION["userid"]);
echo $classData['money'];
?></font>
               &nbsp; 元</td>
              <td width="243" align="right" valign="middle"><a href="zxzf_zfb.php?acontent=1" target="_blank"><img src="images/user_mscz.jpg" width="70" height="28" border="0"></a>&nbsp; &nbsp; <a href="user_sqtk.php"><img src="images/user_sqtk.jpg" width="70" height="28" border="0"></a>&nbsp; &nbsp; </td>
            </tr>
          </table></td>
        </tr>
      </table>
      <div style="margin-top:15px;">
      <div style="height:34px; border:1px solid #C9C9C9; background:#F1F1F1;"><img style="margin-top:6px; margin-left:30px;" src="images/user_czjl.jpg" width="113" height="22"></div>
      </div>
      <div style="margin-top:8px;">
        <table width="748" id="sj" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
          <tr>
            <td width="141" height="29" align="center" bgcolor="#FFFFFF" class="tdbg">订单号</td>
            <td width="126" align="center" bgcolor="#FFFFFF" class="tdbg">费用类型</td>
            <td width="114" align="center" bgcolor="#FFFFFF" class="tdbg">充值&nbsp;/&nbsp;消费类型</td>
            <td width="108" align="center" bgcolor="#FFFFFF" class="tdbg">金额</td>
            <td width="163" align="center" bgcolor="#FFFFFF" class="tdbg">充值时间</td>
            <td width="89" align="center" bgcolor="#FFFFFF" class="tdbg">充值情况</td>
          </tr>
		  <?php
	 if($bw->selectOnly('*' ,'bw_moneyrecord', 'memberid = '.$_SESSION["userid"]))
	 {
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = PAGESIZE;
  $tbName   = "bw_moneyrecord";
  $where1    = 'memberid='.$_SESSION["userid"];
  $where    = '';
  //搜索
 // die($_SESSION['wherejflist']);
  $list = $bw->selectPage("*",$tbName,$where1,"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$where1,$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
?>
          <tr>
            <td height="30" align="center" bgcolor="#FFFFFF"><?php echo $list[$i]['recordno']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><?php  switch ($list[$i]['acontent'])
		{
		case 1: echo "预存款";break;
		case 2: echo "认证费";break;
		case 3: echo "违约款";break;
		case 4: echo "信息费";break;
		case 5: echo "退款";break;
		case 6: echo "其他";break;
		}?></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo $list[$i]['away']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo $list[$i]['amount']; ?>元</td>
            <td align="center" bgcolor="#FFFFFF"><?php echo $list[$i]['addtime']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><?php  switch ($list[$i]['atype'])
		{
		case 1: echo "操作成功";break;
		case 0: echo "<font color='#ff0000'>操作失败</font>";break;
		}?></td>
          </tr>
		  <?php
  }//end loop
?>
          <tr>
            <td height="30" colspan="6" align="center" bgcolor="#FFFFFF">共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="?page=1">第一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp;
				<a href="?page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
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
<?php
}
?>
          <tr>
            <td height="30" colspan="6" align="center" bgcolor="#F7F7F7">充值记录可能存在延时，仅供参考，请以实际金额变化为准</td>
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
