<?php
include_once('nusoap/lib/nusoap.php');
$client = new soapclient('http://117.79.237.5:8060/webservice.asmx?wsdl',true); 
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;
$sn='DXX-ZRG-010-01756';
$password='976909';
$pwd=strtoupper(md5($sn.$password));
$mobile=$_REQUEST['mobile'];//手机号
$content=$_REQUEST['content'];//内容
$ext=$_REQUEST['ext'];//扩展码，可为空
$stime=$_REQUEST['stime'];//定时时间,可为空
$rrid=$_REQUEST['rrid'];//唯一标志码，如果为空，将返回系统生成的标志码
$parameters=array("sn"=>$sn,"pwd"=>$pwd,"mobile"=>$mobile,"content"=>$content,"ext"=>$ext,"stime"=>$stime,"rrid"=>$rrid);
//利用客户端对象的 call 方法调用 WEB 服务的程序
$str=$client->call('mt',array('parameters' =>$parameters), '', '', false, true,'document','encoded'); 

/*
$proxy=$client->getProxy();

try {

 //$str=$proxy->GetBalance($parameters);
 //短信发送程序
 $result=$proxy->mt($parameters);
 echo $result;
} catch (Exception $e) {
  echo $e;
}
*/

//客户端对象的 getError() 方法可以用来检查调用过程是否出现错误。
//如果没有错误， getError() 方法返回 false ；如果有错误， getError()方法返回错误信息。
if (!$err=$client->getError()) {
    echo " 成功发送 :";
    print_r($str);
} else { 
    echo " 错误 :",$err;
}
?>
