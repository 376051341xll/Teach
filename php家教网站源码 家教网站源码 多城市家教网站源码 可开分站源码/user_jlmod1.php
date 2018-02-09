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
$diaoquData = $bw->selectOnly('*', 'bw_config', "lang='".$_COOKIE["cookie_lang"]."'", '');
$classData = $bw->selectOnly('*' ,'bw_member', 'id = '.$_SESSION["userid"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>宁波家教网</TITLE>
<META http-equiv=content-type content="text/html; charset=utf-8">
<META content="" name=description>
<META content="" name=keywords>
<LINK href="css/style.css" type=text/css rel=stylesheet>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="Bookmark" href="favicon.ico"><script language=Javascript>      
      var proMaxWidth = 170;   
      var proMaxHeight = 180;   
 
    function proDownImage(ImgD){    
      var image=new Image();    
       image.src=ImgD.src;    
        if(image.width>0 && image.height>0){    
         var rate = (proMaxWidth/image.width < proMaxHeight/image.height) ? proMaxWidth/image.width:proMaxHeight/image.height;    
        if(rate <= 1){    
           ImgD.width = image.width*rate;    
           ImgD.height =image.height*rate;    
        } else {    
           ImgD.width = image.width;    
            ImgD.height =image.height;    
        }    
        }    
     }   
</script>
</HEAD>
<BODY>
<?php
if($_GET["act"]=="mod")
{
		if(!empty($_FILES['tupic']['name']))
		{
			$fileName = $bw->upload('huiyuan/',204800,'tupic');
			if($fileName)
			{
				$_POST['tupic'] = $fileName;
			}
		}else{
			unset($_POST['tupic']);
			}
	//die($_POST['tupic']);
			
		if(!empty($_POST["kskqy"]))
		{
		foreach ($_POST["kskqy"] as &$value) {
    	$abc = $abc.$value.",";
			}
			$_POST["kskqy"]=$abc;
		}
		if(substr($_POST["kjskm"],0,1)==",")
		{
		$_POST["kjskm"]=substr($_POST["kjskm"],1);
		}
		if(substr($_POST["kjskm"],-1)==",")
		{
		$_POST["kjskm"]=substr($_POST["kjskm"],0,-1);
		}
		//die($_POST["kskqy"]);
		if(!empty($_POST["kfdfs"]))
		{
		foreach ($_POST["kfdfs"] as &$value) {
    	$abcd = $abcd.$value.",";
			}
			$_POST["kfdfs"]=$abcd;
		}
    //检测教员是否改动性别
	$jcData = $bw->selectOnly('sex', 'bw_member', 'id='.$_SESSION["userid"].'', '');
	if($_POST['sex']!=$jcData["sex"]){
	$sql1 = "update bw_member set jiance='".$_POST['sex'].'时间：'.date("y-m-d H:i:s")."' where id=".$_SESSION["userid"]."";
	//die($sql1);
	$bw->query($sql1);
	}
		
		if($bw->update('bw_member', $_POST, 'id = '.$_SESSION["userid"]))
		{
			$bw->msg('更新成功!', 'user_jlmod.php');
		}else{
			$bw->msg('更新失败!', 'user_jlmod.php', true);
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
     <div id="xcrz_tltle">简历修改</div>
     <div id="xcrz_nr">
       <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
     <form action="?act=mod" method="post" enctype="multipart/form-data">
         <tr>
           <td width="16%" height="40" align="right" bgcolor="#f9f9f9"><b>教员编号：</b></td>
           <td width="16%" align="left" bgcolor="#FFFFFF"><?php echo $classData['id'];?></td>
           <td width="11%" align="right" bgcolor="#f9f9f9"><b>姓名：</b></td>
           <td width="23%" align="left" bgcolor="#FFFFFF"><input name="truename" type="text" id="truename" value="<?php echo $classData['truename'];?>" /></td>
           <td width="13%" align="right" bgcolor="#f9f9f9"><b>教&nbsp;&nbsp; 龄：</b></td>
           <td width="21%" align="left" bgcolor="#FFFFFF">
           <input name="jiaolin" type="text" id="jiaolin" value="<?php echo $classData['jiaolin'];?>" size="8" maxlength="5" /></td>
         </tr>
         <tr>
           <td height="40" align="right" bgcolor="#f9f9f9"><b>性别：</b></td>
           <td align="left" bgcolor="#FFFFFF"><select name="sex" id="sex">
      <option value="1" <?php if($classData['sex']==1)
	  {
		  echo "selected='selected'";
		  }?> >男</option>
      <option value="2" <?php if($classData['sex']==2)
	  {
		  echo "selected='selected'";
		  }?>>女</option>
    </select></td>
           <td align="right" bgcolor="#f9f9f9"><b>认证情况：</b></td>
           <td align="left" bgcolor="#FFFFFF"><?php if($list[$i]['ifrz']==2){echo "已认证";}else{echo "未认证";}?></td>
           <td align="right" bgcolor="#f9f9f9"><strong>图&nbsp; 片：</strong></td>
           <td align="left" bgcolor="#FFFFFF"><input type="file" name="tupic" id="tupic" style="width:150px; height:26px;" /></td>
         </tr>
         <tr>
           <td height="40" align="right" bgcolor="#f9f9f9"><b>出生地省份：</b></td>
           <td align="left" bgcolor="#FFFFFF"><select name="csd" id="csd">
                              <option>--请选择--</option>
                              <option value="北京" <?php
                              if($classData['csd']=="北京")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>北京</option>
                                <option value="天津"  <?php
                              if($classData['csd']=="天津")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>天津</option>
                                <option value="厦门" <?php
                              if($classData['csd']=="厦门")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>厦门</option>
                                <option value="重庆" <?php
                              if($classData['csd']=="重庆")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>重庆</option>
                                <option value="安徽" <?php
                              if($classData['csd']=="安徽")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>安徽</option>
                                <option value="江苏" <?php
                              if($classData['csd']=="江苏")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>江苏</option>
                                <option value="浙江" <?php
                              if($classData['csd']=="浙江")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>浙江</option>
                                <option value="福建" <?php
                              if($classData['csd']=="福建")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>福建</option>
                                <option value="甘肃" <?php
                              if($classData['csd']=="甘肃")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>甘肃</option>
                                <option value="广东" <?php
                              if($classData['csd']=="广东")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>广东</option>
                                <option value="广西" <?php
                              if($classData['csd']=="广西")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>广西</option>
                                <option value="贵州" <?php
                              if($classData['csd']=="贵州")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>贵州</option>
                                <option value="海南" <?php
                              if($classData['csd']=="海南")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>海南</option>
                                <option value="河北" <?php
                              if($classData['csd']=="河北")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>河北</option>
                                <option value="河南" <?php
                              if($classData['csd']=="河南")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>河南</option>
                                <option value="黑龙江" <?php
                              if($classData['csd']=="黑龙江")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>黑龙江</option>
                                <option value="湖北" <?php
                              if($classData['csd']=="湖北")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>湖北</option>
                                <option value="湖南" <?php
                              if($classData['csd']=="湖南")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>湖南</option>
                                <option value="吉林" <?php
                              if($classData['csd']=="吉林")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>吉林</option>
                                <option value="江西" <?php
                              if($classData['csd']=="江西")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>江西</option>
                                <option value="辽宁" <?php
                              if($classData['csd']=="辽宁")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>辽宁</option>
                                <option value="内蒙" <?php
                              if($classData['csd']=="内蒙")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>内蒙</option>
                                <option value="宁厦" <?php
                              if($classData['csd']=="宁厦")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>宁厦</option>
                                <option value="青海" <?php
                              if($classData['csd']=="青海")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>青海</option>
                                <option value="山东" <?php
                              if($classData['csd']=="山东")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>山东</option>
                                <option value="山西" <?php
                              if($classData['csd']=="山西")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>山西</option>
                                <option value="陕西" <?php
                              if($classData['csd']=="陕西")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>陕西</option>
                                <option value="四川" <?php
                              if($classData['csd']=="四川")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>四川</option>
                                <option value="西藏" <?php
                              if($classData['csd']=="西藏")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>西藏</option>
                                <option value="香港" <?php
                              if($classData['csd']=="香港")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>香港</option>
                                <option value="新疆" <?php
                              if($classData['csd']=="新疆")
							  {
								  echo 'selected="selected"';
								  }
							  ?>>新疆</option>
                            </select></td>
           <td align="right" bgcolor="#f9f9f9"><b>出生年份：</b></td>
           <td align="left" bgcolor="#FFFFFF"><select name="birthday" id="birthday">
                              <option>--请选择--</option>
                              <?php
							  $nian1="20".date("y");
							  $xiao=$nian1-70;
							//  echo $nian1;
                             for($nian=$xiao;$nian<$nian1;$nian++)
							  {
							  ?>
              <option value="<?php echo $nian;?>" <?php 
							  if($classData['birthday']==$nian)
							  {
								  echo 'selected="selected"';
								  }
							  ?> ><?php echo $nian;?></option>
                              <?php
                              }
							  ?>
           </select></td>
           <td align="right" bgcolor="#f9f9f9"><b>毕业学校：</b></td>
           <td align="left" bgcolor="#FFFFFF"><input name="xuexiao" type="text" id="xuexiao" value="<?php echo $classData['xuexiao'];?>" /></td>
         </tr>
         <tr>
           <td height="40" align="right" bgcolor="#f9f9f9"><b>目前学历：</b></td>
           <td align="left" bgcolor="#FFFFFF">
           <select name="xueli" id="xueli">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["xueli"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php 
			  if($classData['xueli']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
    </select></td>
           <td align="right" bgcolor="#f9f9f9"><b>专业：</b></td>
           <td align="left" bgcolor="#FFFFFF">
           <input type="text" name="zhuanye" id="zhuanye" value="<?php echo $classData['zhuanye'];?>" /></td>
           <td align="right" bgcolor="#f9f9f9"><b>目前身份：</b></td>
           <td align="left" bgcolor="#FFFFFF"><select name="mqsf" id="mqsf">
                             <option>----请选择----</option>
                              <?php
$dir=$diaoquData["shenfen"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
              <option value="<?php echo $split_dir[$i];?>" <?php
              if($classData['mqsf']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?> ><?php echo $split_dir[$i];?></option>
              <?php
}
			  ?>
                            </select></td>
         </tr>
         <tr>
           <td height="40" align="right" bgcolor="#f9f9f9"><b>区域：</b></td>
           <td align="left" bgcolor="#FFFFFF"><select name="quyu" id="quyu">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php
              if($classData['quyu']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?>><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
    </select></td>
           <td align="right" bgcolor="#f9f9f9"><b><?php if($classData['levels']!=1){echo "职称等级：";}?></b></td>
           <td align="left" bgcolor="#FFFFFF"><?php if($classData['levels']!=1){?><select name="zhicheng" id="zhicheng">
      <option value="">————请选择————</option>
      <?php
$dir=$diaoquData["zhicheng"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php
              if($classData['zhicheng']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?>><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
      </select>
	  <?php 
	  }
	  ?>
	       </td>
           <td align="right" bgcolor="#f9f9f9"><b><?php if($classData['levels']!=1){echo "任职学校类别：";}?></b></td>
           <td align="left" bgcolor="#FFFFFF"><?php if($classData['levels']!=1){?><select name="rzxxlb" id="rzxxlb">
      <option value="">--请选择--</option>
      <?php
$dir=$diaoquData["leibie"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?>
      <option value="<?php echo $split_dir[$i];?>" <?php
              if($classData['rzxxlb']==$split_dir[$i])
			  {
				  echo 'selected="selected"';
				  }
			  ?>><?php echo $split_dir[$i];?></option>
      <?php
}
			  ?>
      </select>
	   <?php 
	    }
	   ?>
	      </td>
         </tr>
         <tr>
           <td height="40" align="center" bgcolor="#f9f9f9"><b>任教学科：</b></td>
           <td bgcolor="#FFFFFF"><input name="rjxk" type="text" id="rjxk" value="<?php echo $classData['rjxk'];?>"></td>
           <td align="right" bgcolor="#FFFFFF"><strong><b>地址</b>：</strong></td>
           <td bgcolor="#FFFFFF"><input name="address" type="text"  id="address" value="<?php echo $classData['address'];?>" /></td>
           <td bgcolor="#FFFFFF">&nbsp;</td>
           <td bgcolor="#FFFFFF">&nbsp;</td>
         </tr>
         <tr>
           <td height="40" align="center" bgcolor="#f9f9f9"><b>可教授课目：</b></td>
           <td colspan="5" bgcolor="#FFFFFF">&nbsp;<table width="548" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200" height="200"><select size="30" id="list1" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list2)">
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list = $bw->selectMany('id, className', 'bw_userproclass', "parentId=0", 'paixu DESC', '');
			$sum = count($list);
			for($i = 0; $i<$sum; $i++)
			{
		?>
          <option value="">------<?php echo $list[$i]['className']; ?>--------</option>
          <?php
			//selectMany($param,$tbname,$where,$order,$limit)
			$list2 = $bw->selectMany('id, className', 'bw_userproclass', "parentId=".$list[$i]['id'], 'id DESC', '');
			$sum2 = count($list2);
			for($i1 = 0; $i1<$sum2; $i1++)
			{
		?>
          <option value="<?php echo $list2[$i1]['className']; ?>"><?php echo $list2[$i1]['className']; ?></option>
          <?php
			}
			}
		?>
          </select></td>
        <td width="136" align="center"><input type="button" id="button" value=" 增加 &gt;&gt; " onclick="moveOption(this.form.list1, this.form.list2);inputs('list2','kjskm')" />
          <br />
          <span style="color:#F00; text-align:left;">(选中左侧项目点&quot;选取&quot;即可添加；选中右侧项目点 &quot;删除&quot;即可删除)
            <input type="hidden" name="kjskm" id="kjskm" value="<?php echo $newsData['kjskm'];?>" />
            </span> <br />
          <input type="button" id="button2" value=" &lt;&lt; 删除 " onclick="sc(this.form.list2);inputs('list2','kjskm')" /></td>
        <td width="212" align="left"><select size="30" id="list2" style="width:200px; height:200px;" ondblclick="moveOption(this, this.form.list1)">
           <?php
$dir=$classData['kjskm'];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><option value="<?php echo $split_dir[$i]?>"><?php echo $split_dir[$i]?></option>
          <?php
}
		  ?>
          </select></td>
        </tr>
      </table></td>
         </tr>
         <tr>
           <td height="40" align="center" bgcolor="#f9f9f9"><b>自我描述：</b></td>
           <td colspan="5" bgcolor="#FFFFFF">&nbsp;<textarea name="zwms"  id="zwms" style="width:450px; height:100px; line-height:20px;"><?php echo $classData['zwms'];?></textarea></td>
         </tr>
         <tr>
           <td height="40" align="center" bgcolor="#f9f9f9"><b>可授课区域：</b></td>
           <td colspan="5" bgcolor="#FFFFFF">&nbsp;<?php
$dir=$diaoquData["quyu"];
$split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
for($i=0;$i<count($split_dir);$i++)

{  ?><input name="kskqy[]" type="checkbox" id="kskqy" value="<?php echo $split_dir[$i];?>" <?php
if(strlen(strstr($classData['kskqy'],$split_dir[$i]))>0)
{
	echo 'checked="checked"';
	}
	//echo $newsData['kskqy'];
?> >
<?php echo $split_dir[$i];?>
              <?php
}
			  ?> </td>
         </tr>
         <tr>
           <td height="40" align="center" bgcolor="#f9f9f9"><b>可辅导方式：</b></td>
           <td colspan="5" bgcolor="#FFFFFF">&nbsp;<input name="kfdfs[]" type="checkbox" id="kfdfs" value="本人上门" <?php
if(strlen(strstr($classData['kfdfs'],"本人上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
                              本人上门
                                <input name="kfdfs[]" type="checkbox" id="kfdfs" value="学生上门" <?php
if(strlen(strstr($classData['kfdfs'],"学生上门"))>0)
{
	echo 'checked="checked"';
	}
?>>
学生上门</td>
         </tr>
         <tr>
           <td height="40" align="center" bgcolor="#f9f9f9"><b>可授课时间：</b></td>
           <td colspan="5" bgcolor="#FFFFFF">&nbsp;<input name="ksksj" type="text"  id="ksksj" style="width:400px;" value="<?php echo $classData['ksksj'];?>"></td>
         </tr>
         <tr>
           <td height="40" align="center" bgcolor="#f9f9f9"><b>薪水要求：</b></td>
           <td colspan="5" bgcolor="#FFFFFF"><textarea name="xsyq" id="xsyq" cols="45" rows="5" style="width:500px; line-height:20px;"><?php echo $classData['xsyq'];?></textarea></td>
         </tr>
         <tr>
           <td height="40" colspan="6" align="center" bgcolor="#FFFFFF"><p>&nbsp;</p>
           <p>
             <input type="submit" id="button3" value="提   交" style="width:120px; height:30px; font-size:14px; border:1px solid #CCC; background:#FFF;" />
             &nbsp; 
             &nbsp; 
             &nbsp; 
             <input type="reset" id="button4" value="重    置" style="width:120px; height:30px; font-size:14px; border:1px solid #CCC; background:#FFF;"/>
           </p></td>
         </tr></form>
       </table>
    </div>
</div>
</div>
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
<!-- main end-->
<?php include("bottom.php");?>
<!-- footer end-->
</BODY>
</HTML>
