<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>宁波家教</title>
</head>

<body>
<?php

//$username="sq8xuecheng";
//$password="abc123321";
//$DatabaseName="sq8xuecheng";
//$DatabaseCharset="utf8";
//$server="218.85.133.27";
$username="root";
$password="";
$DatabaseName="xcjy";
$DatabaseCharset="utf8";
$server="127.0.0.1";
$MySQL_DB_Handle=mysql_connect($server,$username,$password);
@mysql_query("SET NAMES 'utf8'",$MySQL_DB_Handle); 
mysql_select_db($DatabaseName) or die("数据库不存在!");
@mysql_query("SET NAMES 'utf8'",$MySQL_DB_Handle); 
?>
<?php
//SQL数据库连接
//宁波站
//$serverName = "222.73.85.200"; //数据库服务器地址
//$uid = "a0608095210"; //数据库用户名
//$pwd = "yzqxcjy7758258"; //数据库密码

//福州站
//$serverName = "222.73.85.200"; //数据库服务器地址
//$uid = "a0817212326"; //数据库用户名
//$pwd = "57942986"; //数据库密

//杭州站
$serverName = "222.73.85.198"; //数据库服务器地址
$uid = "a0915094041"; //数据库用户名
$pwd = "7240164"; //数据库密

$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"a0915094041");
$conn1 = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn1 == false)
{
    echo "连接失败！";
    die( print_r( sqlsrv_errors(), true));
}else{ echo "chenggong！";}
$query = sqlsrv_query($conn1, "SELECT  * FROM a0915094041.dbo.orders");
while($row = sqlsrv_fetch_array($query)){
	if($row["o_state"]==1||$row["o_state"]=="-1")
	{
		$ddzt=1; //正在试教
		}elseif($row["o_state"]==2){
			$ddzt=2; //订单成功
		}elseif($row["o_state"]=="-2"){
			$ddzt=3; //订单失败
	}else{
		$ddzt=0; //订单未安排
		}
	//die($row['o_state']);
	//die($row['t_birthday']);
	//$csnf=substr("".$row['t_birthday']."",0,4);
	$Rs_query="insert into `bw_order`(xyid,jyid,ifdd,ddzt,ddqk,lang) values(".$row["s_id"].",".$row["t_id"].",2,".$ddzt.",'".iconv("gb2312","utf-8",$row["o_detail2"])."','杭州站')";
	//echo $Rs_query."<br>";
	//exit;
    mysql_query($Rs_query);
   // echo $row['t_id']."-----".iconv("gb2312","utf-8",)."<br/>";
}
?>
</body>
</html>
