<?php include("checkuser.php"); ?><img src="images/yhgrzx.jpg" width="166" height="23" id="daohang">
<ul>
<li><a href="###">欢迎页面</a></li>
</ul>
<ul id="nei">
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_main")
{
?>id="zhong"<?php
}
?> >&#8226;<a href="user_main.php">欢迎页面</a></li>
</ul>
<div class="qinc"></div>
<ul>
<li><a href="###">身份认证</a></li>
</ul>
<ul id="nei">
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_wsrz")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_wsrz.php" >网上认证</a></li>
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_xcrz")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_rzxz.php">认证须知</a></li>
</ul>
<div class="qinc"></div>
<ul>
<li><a href="###">账户管理</a></li>
</ul>
<ul id="nei">
<li>&#8226;<a href="zxzf_zfb.php?acontent=1" target="_blank">充值</a></li>
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_sqtk")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_sqtk.php">申请退款</a></li>
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_jlcx")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_jlcx.php">记录查询</a></li>
</ul>
<div class="qinc"></div>
<ul>
<li><a href="###">资料管理</a></li>
</ul>
<ul id="nei">
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_jlyl")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_jlyl.php">简历预览</a></li>
<li <?php
if(substr($_SERVER['PHP_SELF'],-14,-4)=="user_jlmod")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_jlmod.php">修改简历</a></li>
</ul>
<div class="qinc"></div>
<ul>
<li><a href="###">订单管理</a></li>
</ul>
<ul id="nei">
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_sqgl")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_sqgl.php">申请管理</a></li>
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_sjgl")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_sjgl.php">试教管理</a></li>
</ul>
<div class="qinc"></div>
<ul>
<li><a href="###">功能设置</a></li>
</ul>
<ul id="nei">
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_fsxx"||substr($_SERVER['PHP_SELF'],-12,-4)=="user_sjx"||substr($_SERVER['PHP_SELF'],-13,-4)=="user_yfxx")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_fsxx.php">信件管理</a></li>
<li <?php
if(substr($_SERVER['PHP_SELF'],-13,-4)=="user_mmxg")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_mmxg.php">修改密码</a></li>
<li <?php
if(substr($_SERVER['PHP_SELF'],-12,-4)=="user_out")
{
?>id="zhong"<?php
}
?>>&#8226;<a href="user_out.php">注销登录</a></li>
</ul>
<div class="qinc" style="height:50px;"></div>