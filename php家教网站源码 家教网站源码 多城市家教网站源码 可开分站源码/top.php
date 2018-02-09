
<!--[if lte IE 6]>
<script src="js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div, ul, img, li, input , a');
    </script>
<![endif]--> <script language="javascript" type="text/javascript">
//设为首页(兼容FF)
//<a onclick="SetHome(this,window.location)">设为首页</a>
function SetHome(obj,vrl){
        try{
                obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl);
        }
        catch(e){
                if(window.netscape) {
                        try {
                                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");  
                        }  
                        catch (e)  { 
                                alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入‘about:config’并回车\n然后将[signed.applets.codebase_principal_support]设置为'true'");  
                        }
                        var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                        prefs.setCharPref('browser.startup.homepage',vrl);
                 }
        }
}


//加入收藏(兼容FF) 
//<a onclick="AddFavorite(window.location,document.title)">加入收藏</a>
function AddFavorite(sURL, sTitle)
{
    try
    {
        window.external.addFavorite(sURL, sTitle);
    }
    catch (e)
    {
        try
        {
            window.sidebar.addPanel(sTitle, sURL, "");
        }
        catch (e)
        {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}
</script>
<?php
if($_GET["act"]=="dl")
{	
	$code=$_POST['yzm'];
	$code = strtolower($code);
	if (!empty($_SESSION['captcha_word']))
	{
		include_once('inc/cls_captcha.php');

		/* 检查验证码是否正确 */
		$validator = new captcha();
		
		if (!$validator->check_word($code))
		{
		   echo "<script>alert('验证码不正确!'); </script>";
		}else{
			$pwd=md5($_POST["password"]);
			if($hydata=$bw->selectOnly('username,id,password' ,'bw_member', "username = '".$_POST["username"]."' and password='".$pwd."' and lang='".$_COOKIE["cookie_lang"]."'"))
				{
			$_SESSION["hyusername"]=$_POST["username"];
			$_SESSION["hypassword"]=$pwd;
			$_SESSION["userid"]=$hydata["id"];
			$sql = "UPDATE bw_member SET dlcs = dlcs+1,zjtime='".date("y-m-d H:i:s")."' WHERE id = ".$_SESSION["userid"];//登录次数,登录时间
			//die($sql);
			$bw->query($sql);
			$bw->msg("登录成功","user_main.php");
				}
				else{
					$bw->msg("账号或密码错误，或登陆区域不对！");
					}
			}
	 }
	
}
if($_GET["act"]=="zxzfdl")
{	
	
	$code=$_POST['yzm'];
	$code = strtolower($code);
	if (!empty($_SESSION['captcha_word']))
	{
		include_once('inc/cls_captcha.php');

		/* 检查验证码是否正确 */
		$validator = new captcha();
		
		if (!$validator->check_word($code))
		{
		   echo "<script>alert('验证码不正确!'); </script>";
		}else{
			$pwd=md5($_POST["password"]);
			if($hydata=$bw->selectOnly('username,id,password' ,'bw_member', "username = '".$_POST["username"]."' and password='".$pwd."'"))
				{
			$_SESSION["hyusername"]=$_POST["username"];
			$_SESSION["hypassword"]=$pwd;
			$_SESSION["userid"]=$hydata["id"];
			$sql = "UPDATE bw_member SET dlcs = dlcs+1,zjtime='".date("y-m-d H:i:s")."' WHERE id = ".$_SESSION["userid"];//登录次数，登录时间
			$bw->query($sql);
			$bw->msg("登录成功","user_main.php");
				}
				else{
					$bw->msg("账号或密码错误");
					}
			}
	 }
	
}
	if($_SESSION["hyusername"]!="")
	{
	$hyyz=$bw->selectOnly('lang' ,'bw_member', "username = '".$_SESSION["hyusername"]."' and password='".$_SESSION["hypassword"]."'");
		if($hyyz["lang"]!=$_COOKIE["cookie_lang"])
		{
			//die($hyyz["lang"]);
			$_SESSION["hyusername"]="";
			$_SESSION["hypassword"]="";
			$_SESSION["userid"]="";
			$bw->msg("您的登陆区域有误,请从新登陆！","zxzf.php");
		}
	}
$langData = $bw->selectOnly('*', 'bw_lang', 'id = 1', '')//得到语言本版列表
?>
<div class="index_top"><img src="images/logo.gif" id="logo" width="240" height="59" />
<div class="index_top_r"><div><a href="pay.php"><b>支付方式</b></a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="###" onclick="SetHome(this,window.location)">设为首页</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="AddFavorite(window.location,document.title)" href="###">加入收藏</a></div>
当前站<span>[<?php echo $_COOKIE["cookie_lang"];?>]</span>&nbsp;&nbsp;&nbsp;&nbsp;<select name="" onchange="window.location.href=(this.value);">
  <option selected="selected" value="">--请选择--</option>
			<?php
  $dir=$langData["lang"];
  $split_dir = split ('[,.-]', $dir); //返回一个Array,你可以用for读出来
  for($i=0;$i<count($split_dir);$i++)
  
  {  ?>
            <option value="?lang=<?php echo base64_encode($split_dir[$i]);?>" ><?php echo $split_dir[$i];?></option>
                <?php
  }
                ?>
</select></div>
</div>
<div class="index_dao"><img src="images/index_dao_left.jpg" id="dao_l" width="22" height="54" /><a href="index.php" <?php
if(substr($_SERVER['PHP_SELF'],-9,-4)=="index"||$_SERVER['PHP_SELF']=="")
{
?>class="index_daomoren"<?php
}
?> ><font>首页</font></a>
<a href="qjj.php" <?php
if(substr($_SERVER['PHP_SELF'],-7,-4)=="qjj")
{
?>class="index_daomoren"<?php
}
?> ><font>请家教</font></a>
<a href="tutor.php"><font>做家教</font></a>
<a href="fudaoban.php"><font>辅导班</font></a>
<a href="students.php?act=k" <?php
if(substr($_SERVER['PHP_SELF'],-12,-4)=="students"||substr($_SERVER['PHP_SELF'],-15,-4)=="studentshow")
{
?>class="index_daomoren"<?php
}
?>><font>学员库</font></a>
<a href="teachers.php?act=k" <?php
if(substr($_SERVER['PHP_SELF'],-12,-4)=="teachers"||substr($_SERVER['PHP_SELF'],-15,-4)=="teachershow")
{
?>class="index_daomoren"<?php
}
?> ><font>教员库</font></a>
<a href="mxjy.php?act=k" <?php
if(substr($_SERVER['PHP_SELF'],-8,-4)=="mxjy"||substr($_SERVER['PHP_SELF'],-9,-4)=="mxjys")
{
?>class="index_daomoren"<?php
}
?> ><font>明星教员</font></a>
<a href="yszc.php?act=k" <?php
if(substr($_SERVER['PHP_SELF'],-8,-4)=="yszc")
{
?>class="index_daomoren"<?php
}
?>><font>艺术专才</font></a>
<a href="article.php" <?php
if(substr($_SERVER['PHP_SELF'],-8,-4)=="news")
{
?>class="index_daomoren"<?php
}
?>><font>文章中心</font></a>
<a href="download.php" <?php
if(substr($_SERVER['PHP_SELF'],-12,-4)=="download")
{
?>class="index_daomoren"<?php
}
?>><font>资料下载</font></a>
<a href="zfbz.php" <?php
if(substr($_SERVER['PHP_SELF'],-8,-4)=="zfbz")
{
?>class="index_daomoren"<?php
}
?> ><font>资费标准</font></a>
<a href="user_main.php" <?php
if(substr($_SERVER['PHP_SELF'],-11,-4)=="contact")
{
?>class="index_daomoren"<?php
}
?>><font>教员中心</font></a>
<img id="dao_r" src="images/index_dao_right.jpg" width="22" height="54" /></div>