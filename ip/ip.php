<?php
include_once('./qqwry.php');
$QQWry=new QQWry; 
function get_real_ip(){
$ip=false;
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
$ip = $_SERVER["HTTP_CLIENT_IP"];
}
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
for ($i = 0; $i < count($ips); $i++) {
if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
$ip = $ips[$i];
break;
}
}
}
return $ip;
}
function is_ip($str) {
    $ip = explode(".", $str);
    if (count($ip)<4 || count($ip)>4) return 0;
    foreach($ip as $ip_addr) {
        if ( !is_numeric($ip_addr) ) return 0;
        if ( $ip_addr<0 || $ip_addr>255 ) return 0;
    }
    return 1;
}
if($_POST['ip']){
$ip=$_POST['ip'];
preg_match('/((\w|-)+\.)+[a-z]{2,4}/i',$ip) ? $ip=gethostbyname($ip) : $ip;
if(is_ip($ip)){
$ifErr=$QQWry->QQWry($ip); 
echo "����ѯ��IP:&nbsp;".$ip."<br>IP��ϸ��ַ:&nbsp;".$QQWry->Country.$QQWry->Local."<br/>";
$ipl= $QQWry->Country;
}else
{
echo "������ĺ������IP,��վ���ܲ�ѯ.";
}
}else{
$ip=get_real_ip();
if (($_SERVER["HTTP_CLIENT_IP"]) or ($_SERVER['HTTP_X_FORWARDED_FOR'])){
$ifErr=$QQWry->QQWry($ip); 
echo "������ʵIP��".$ip."<br>����&nbsp;".$QQWry->Country.$QQWry->Local."<br/>"; 
$ipl= $QQWry->Country;
$ip=$_SERVER['REMOTE_ADDR'];
$ifErr=$QQWry->QQWry($ip); 
echo "���Ĵ���IP��".$ip."<br>����&nbsp;".$QQWry->Country.$QQWry->Local; 
}
else{
$ip=$_SERVER['REMOTE_ADDR']; 
$ifErr=$QQWry->QQWry($ip); 
echo ""; 
$ipl= $QQWry->Country;
 }
}
?>
document.getElementById('myip').innerHTML = "<a href='http://tool.yowao.com/ip/' target='_blank'>����IP��<span class='cBlue'><?php echo $ip?></span>�����ԣ�<span class='cBlue'><?php echo $QQWry->Country.$QQWry->Local?></span></a>";