<?php
include_once('class.php');

$host  = "218.85.133.27";    
$dbName= "sq8xuecheng";
$dbUser= "sq8xuecheng";
$dbPwd = "abc123321";
$dbChar= "UTF8";

$bw = new myConn($host,$dbUser,$dbPwd,$dbName,$dbChar);
date_default_timezone_set('PRC');
define('IN_ECS', true);
//加密串
define('APPMD5',"bc301ec5a31c800c00f113c261480364");
//每页显示信息条数
define('PAGESIZE',20);

//网站基本配置信息
//selectOnly($param,$tbname,$where,$order)
$webconfig = $bw->selectOnly('*', 'bw_config', '', '');

$service_title       = $webconfig['title'];
$service_keyword     = $webconfig['keyword'];
$service_description = $webconfig['description'];
$service_information = $webconfig['information'];
$service_logo 		 = $webconfig['logo'];
$bbsgg 		         = $webconfig['bbsgg'];
$newjf 		         = $webconfig['newjf'];
$newts 		         = $webconfig['newts'];
$projf 	        	 = $webconfig['projf'];
$prots 		         = $webconfig['prots'];
$bbsft 		         = $webconfig['bbsft'];
$bbsftts 		     = $webconfig['bbsftts'];
$bbshf 		         = $webconfig['bbshf'];
$bbshfts 		     = $webconfig['bbshfts'];
$htwt 		         = $webconfig['htwt'];
$hdwtts 		     = $webconfig['hdwtts'];
$jifenshow 		     = $webconfig['jifenshow'];

//网站广告
//selectMany($param,$tbname,$where,$order='',$limit='')
function phphtml($content)
{
	$content = preg_replace("/<a[^>]*>/i", "", $content);   
   $content = preg_replace("/<\/a>/i", "", $content);    
   $content = preg_replace("/<div[^>]*>/i", "", $content);   
   $content = preg_replace("/<\/div>/i", "", $content); 
   $content = preg_replace("/<img[^>]*>/i", "", $content);       
   $content = preg_replace("/<\/img>/i", "", $content);  
   $content = preg_replace("/<p[^>]*>/i", "", $content);       
   $content = preg_replace("/<\/p>/i", "", $content);     
   $content = preg_replace("/<!--[^>]*-->/i", "", $content);//注释内容   
   $content = preg_replace("/style=.+?['|\"]/i",'',$content);//去除样式   
   $content = preg_replace("/class=.+?['|\"]/i",'',$content);//去除样式   
   $content = preg_replace("/id=.+?['|\"]/i",'',$content);//去除样式      
   $content = preg_replace("/lang=.+?['|\"]/i",'',$content);//去除样式       
   $content = preg_replace("/width=.+?['|\"]/i",'',$content);//去除样式    
   $content = preg_replace("/height=.+?['|\"]/i",'',$content);//去除样式    
   $content = preg_replace("/border=.+?['|\"]/i",'',$content);//去除样式    
   $content = preg_replace("/face=.+?['|\"]/i",'',$content);//去除样式    
   $content = preg_replace("/face=.+?['|\"]/",'',$content);//去除样式 只允许小写 正则匹配没有带 i 参数
	return $content;   
}
function chgtitle($title,$length){ 
$encoding='utf-8'; 
if(mb_strlen($title,$encoding)>$length){ 
$title=mb_substr($title,0,$length,$encoding).'...'; 
} 
return $title; 
}
$service_ad = $bw->selectMany('id, title, pic, url', 'bw_ad', 'isshow = 1');
?>