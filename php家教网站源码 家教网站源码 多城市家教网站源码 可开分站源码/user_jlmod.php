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
<link rel="Bookmark" href="favicon.ico">
<script language=Javascript>      
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
		$_POST["kjskm"]=str_replace(",,",",",$_POST["kjskm"]);
		$_POST["kjskm"]=str_replace("，",",",$_POST["kjskm"]);
		if(substr($_POST["kjskm"],0,1)==",")
		{
		$_POST["kjskm"]=substr($_POST["kjskm"],1);
		}
		if(substr($_POST["kjskm"],-1)==",")
		{
		$_POST["kjskm"]=substr($_POST["kjskm"],0,-1);
		}
		//die($_POST["kjskm"]);
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
           <td width="23%" align="left" bgcolor="#FFFFFF"><?php echo $classData['truename'];?></td>
           <td width="13%" align="right" bgcolor="#f9f9f9"><b>教&nbsp;&nbsp; 龄：</b></td>
           <td width="21%" align="left" bgcolor="#FFFFFF">
           <input name="jiaolin" type="text" id="jiaolin" value="<?php echo $classData['jiaolin'];?>" size="8" maxlength="5" /></td>
         </tr>
         <tr>
           <td height="40" align="right" bgcolor="#f9f9f9"><b>性别：</b></td>
           <td align="left" bgcolor="#FFFFFF"><?php
		    if($classData['sex']==1)
			  {
			  echo "男";
			  }else{
			  echo "女";
			  }
		  ?></td>
           <td align="right" bgcolor="#f9f9f9"><b>认证情况：</b></td>
           <td align="left" bgcolor="#FFFFFF"><?php if($list[$i]['ifrz']==2){echo "已认证";}else{echo "未认证";}?></td>
           <td align="right" bgcolor="#f9f9f9"><strong>图&nbsp; 片：</strong></td>
           <td align="left" bgcolor="#FFFFFF"><input type="file" name="tupic" id="tupic" style="width:150px; height:26px;" /></td>
         </tr>
         <tr>
           <td height="40" align="right" bgcolor="#f9f9f9"><b>出生地省份：</b></td>
           <td align="left" bgcolor="#FFFFFF"><?php echo $classData['csd'];?></td>
           <td align="right" bgcolor="#f9f9f9"><b>毕业学校：</b></td>
           <td align="left" bgcolor="#FFFFFF"><?php echo $classData['xuexiao'];?></td>
         </tr>
         <tr>
           <td height="40" align="right" bgcolor="#f9f9f9"><b>目前学历：</b></td>
           <td align="left" bgcolor="#FFFFFF"><?php echo $classData['xueli'];?>
           </td>
           <td align="right" bgcolor="#f9f9f9"><b>专业：</b></td>
           <td align="left" bgcolor="#FFFFFF"><?php echo $classData['zhuanye'];?></td>
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
           <td align="right" bgcolor="#FFFFFF"><strong>E-mail：</strong></td>
           <td bgcolor="#FFFFFF"><input name="email" type="text"  id="email" value="<?php echo $classData['email'];?>" /></td>
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
            <input type="hidden" name="kjskm" id="kjskm" value="<?php echo $classData['kjskm'];?>" />
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
           </p>
		   <script type="text/javascript">   
var userAgent = navigator.userAgent.toLowerCase(); 
if(userAgent.indexOf('se 2.x') != -1){ 
 document.write("<input type='hidden' name='llq' id='llq' value='<?php  echo "搜狗浏览器"; ?>'>") //搜狗浏览器 
} 
else{
document.write("<input type='hidden' name='llq' id='llq' value='<?php  

 if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 8.0"))   

  echo "Internet Explorer 8.0";   

 else if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 7.0"))   

  echo "Internet Explorer 7.0";   

  else if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 6.0"))   

   echo "Internet Explorer 6.0";  

  else if(strpos($_SERVER["HTTP_USER_AGENT"],"Firefox/3"))  

   echo "Firefox 3";  

 else if(strpos($_SERVER["HTTP_USER_AGENT"],"Firefox/2"))  

  echo "Firefox 2";  

  else if(strpos($_SERVER["HTTP_USER_AGENT"],"Chrome"))  

   echo "Google Chrome";  

  else if(strpos($_SERVER["HTTP_USER_AGENT"],"Safari"))  

   echo "Safari";  

  else if(strpos($_SERVER["HTTP_USER_AGENT"],"Opera"))  

   echo "Opera";  

  else echo $_SERVER["HTTP_USER_AGENT"];   

?>'>")	
}
</script>
		   </td>
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
