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
//���ܴ�
define('APPMD5',"bc301ec5a31c800c00f113c261480364");
//ÿҳ��ʾ��Ϣ����
define('PAGESIZE',20);

//��վ����������Ϣ
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

//��վ���
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
   $content = preg_replace("/<!--[^>]*-->/i", "", $content);//ע������   
   $content = preg_replace("/style=.+?['|\"]/i",'',$content);//ȥ����ʽ   
   $content = preg_replace("/class=.+?['|\"]/i",'',$content);//ȥ����ʽ   
   $content = preg_replace("/id=.+?['|\"]/i",'',$content);//ȥ����ʽ      
   $content = preg_replace("/lang=.+?['|\"]/i",'',$content);//ȥ����ʽ       
   $content = preg_replace("/width=.+?['|\"]/i",'',$content);//ȥ����ʽ    
   $content = preg_replace("/height=.+?['|\"]/i",'',$content);//ȥ����ʽ    
   $content = preg_replace("/border=.+?['|\"]/i",'',$content);//ȥ����ʽ    
   $content = preg_replace("/face=.+?['|\"]/i",'',$content);//ȥ����ʽ    
   $content = preg_replace("/face=.+?['|\"]/",'',$content);//ȥ����ʽ ֻ����Сд ����ƥ��û�д� i ����
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