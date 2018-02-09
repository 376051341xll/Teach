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
include 'inc/config.php';

if($_GET["act"]=="yy"&&!empty($_GET["id"]))
{
	if($bw->delete("bw_order","id=".$_GET["id"]))
	{
	$bw->msg('取消成功', 'user_sqgl.php');
	exit;
	}else{
	$bw->msg('取消失败', 'user_sqgl.php');
	exit;
		}
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>宁波家教网</TITLE>
<META http-equiv=content-type content="text/html; charset=utf-8">
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico">
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script type="text/javascript">
	$(document).ready(function(){
		var thisPage = $("#page_SEL");
		thisPage.change(function(){
		location.href="user_sqgl.php?page="+thisPage.val()"";
		});//end page_SEL 		
	});
</script>
</HEAD>
<BODY>
<?php include("top.php");?>
<!-- header end-->
<div class="user_c">
<div class="user_left">
<?php include("user_left.php");?>
</div>
<div class="user_right">
     <div id="sjgl_tltle">
	 <div  class="sjgl_memu2">申请管理</div>
     <div class="sjgl_memu1"><a href="user_sjgl.php">试教管理</a></div>
    </div>
    <div id="sjgl_nr">
	  <table width="100%" id="sq" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
          <td width="14%" align="center" bgcolor="#FFFFFF" class="tdbg">学员编号</td>
          <td width="17%" height="29" align="center" bgcolor="#FFFFFF" class="tdbg">学员姓名</td>
          <td width="15%" align="center" bgcolor="#FFFFFF" class="tdbg">性别</td>
          <td width="11%" align="center" bgcolor="#FFFFFF" class="tdbg">年级</td>
          <td width="11%" align="center" bgcolor="#FFFFFF" class="tdbg">求教科目</td>
          <td width="14%" align="center" bgcolor="#FFFFFF" class="tdbg">区域</td>
          <td width="18%" align="center" bgcolor="#FFFFFF" class="tdbg">预约类型</td>
        </tr>
          <?php
  //查询
  //selectPage($param,$tbname,$where,$order,$limit)
  //requestPage($tbname,$limit) : array('totalRow'=>$totalRow,'totalPage'=>$totalPage,'page'=>$page,'pagePrev'=>$pagePrev,'pageNext'=>$pageNext);
  $pageSize = 8;
  $tbName   = "bw_order";
  $where    = 'jyid='.$_SESSION["userid"]." and xyid in (select id from bw_qjj where isshow=2)";
  //搜索
 // die($_SESSION['wherejflist']);
  $list = $bw->selectPage("*",$tbName,$where,"`id` DESC",$pageSize);
  $pageArray = $bw->requestPage($tbName,$where,$pageSize);
  $sum = count($list);
  for($i = 0; $i<$sum; $i++)
  {
	  $classData = $bw->selectOnly('*' ,'bw_qjj', 'id = '.$list[$i]["xyid"]);
?>
        <tr>
          <td align="center" bgcolor="#FFFFFF"><a href="studentshow.php?id=<?php echo $list[$i]["xyid"];?>" target="_blank"><?php echo $classData["id"];?></a></td>
          <td height="30" align="center" bgcolor="#FFFFFF"><a href="studentshow.php?id=<?php echo $list[$i]["xyid"];?>" target="_blank"><?php echo $classData["name"];?></a></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $classData["xysex"];?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $classData["xynj"];?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $classData["qjkm"];?></td>
          <td align="center" bgcolor="#FFFFFF"><?php echo $classData["szqy"];?></td>
          <td align="center" bgcolor="#FFFFFF"><?php
          if ($list[$i]["yylx"]==1)
		  {
			  echo "您的主动预约";
			  }else
			  {
				  echo "学员的主动预约";
				  }
          if ($list[$i]["yylx"]==1)
		  {
		  ?> &nbsp; <input type="button" name="button" id="button" value="取消预约" onClick="javascript:if(confirm('您确定要取消预约吗？')){window.location.href='?act=yy&id=<?php echo $list[$i]['id']; ?>'}"><?php
		  }
		  ?></td>
        </tr>
        <?php
		}
		?>
        <tr>
          <td height="30" colspan="7" align="center" bgcolor="#f7f7f7" style="line-height:20px;">共:<?php echo $pageArray['totalRow']; ?>&nbsp;条信息&nbsp;当前:<span><?php echo $pageArray['page']; ?></span>/<?php echo $pageArray['totalPage']; ?>页&nbsp;&nbsp;&nbsp;&nbsp; <a href="?page=1">第一页</a>&nbsp;&nbsp; <a href="?page=<?php echo $pageArray['pagePrev']; ?>">上一页</a>&nbsp;&nbsp; <a href="?page=<?php echo $pageArray['pageNext']; ?>">下一页</a>&nbsp;&nbsp; <a href="?page=<?php echo $pageArray['totalPage']; ?>">尾页</a>&nbsp;&nbsp;
              跳到
              <select name="page_SEL" id="page_SEL" onChange="MM_jumpMenu('parent',this,0)">
                          <option value="">---</option>
                          <?php
						  for($goPage = 1; $goPage <= $pageArray['totalPage']; $goPage++)
						  {
						?>
                          <option value="?page=<?php echo $goPage; ?>"><?php echo $goPage; ?></option>
                          <?php
						 }
						?>
                      </select></td>
        </tr>
        <tr>
          <td height="150" colspan="7" bgcolor="#FFFFFF" style="line-height:20px;">
		  <?php
			$classData = $bw->selectOnly('content,title' ,'bw_base', 'id = 9');
            echo $classData['content'];
		  ?>
		  </td>
        </tr>
      </table>
	</div>
  </div>
</div>
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
