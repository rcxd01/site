<?php

$t=$_GET['t'];
if ($t=="2"){

setcookie('tt',"2",time()+3600*24*365);   //д��cookie


$city=$_GET['city']; 
setcookie('city',$city,time()+3600*24*365);   //д��cookie

$provice=$_GET['provice']; 
setcookie('provice',$provice,time()+3600*24*365);   //д��cookie

}

$city= UrlEncode($_COOKIE['city']);   //��ȡcookie
$provice= UrlEncode($_COOKIE['provice']);   //��ȡcookie

$tt= $_COOKIE['tt'];  //��ȡcookie

if ($city=="" && $provice==""){
Header( "Location:http://api.6164.com/tianqi/forecast123.php");
exit;
}

Header( "Location:http://api.6164.com/tianqi/forecast123.php?t=$tt&provice=$provice&city=$city");
?>
