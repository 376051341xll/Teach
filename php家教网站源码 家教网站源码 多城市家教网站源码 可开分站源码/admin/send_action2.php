<?php
include_once('nusoap/lib/nusoap.php');
$client = new soapclient('http://117.79.237.3:8060/webservice.asmx?wsdl',true); 
$client->soap_defencoding = 'GB2312';
$client->decode_utf8 = false;
$sn='DXX-ZRG-010-01756';
$password='976909';
$pwd=strtoupper(md5($sn.$password));
$mobile=$_REQUEST['mobile'];//�ֻ���
$content=$_REQUEST['content'];//����
$ext=$_REQUEST['ext'];//��չ�룬��Ϊ��
$stime=$_REQUEST['stime'];//��ʱʱ��,��Ϊ��
$rrid=$_REQUEST['rrid'];//Ψһ��־�룬���Ϊ�գ�������ϵͳ���ɵı�־��
$parameters=array("sn"=>$sn,"pwd"=>$pwd,"mobile"=>$mobile,"content"=>$content,"ext"=>$ext,"stime"=>$stime,"rrid"=>$rrid);
//���ÿͻ��˶���� call �������� WEB ����ĳ���
$str=$client->call('mt',array('parameters' =>$parameters), '', '', false, true,'document','encoded'); 

/*
$proxy=$client->getProxy();

try {

 //$str=$proxy->GetBalance($parameters);
 //���ŷ��ͳ���
 $result=$proxy->mt($parameters);
 echo $result;
} catch (Exception $e) {
  echo $e;
}
*/

//�ͻ��˶���� getError() �����������������ù����Ƿ���ִ���
//���û�д��� getError() �������� false ������д��� getError()�������ش�����Ϣ��
if (!$err=$client->getError()) {
    echo " �ɹ����� :";
    print_r($str);
} else { 
    echo " ���� :",$err;
}
?>
