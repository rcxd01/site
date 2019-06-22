<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询" />
<title>IP地址查询 - 电脑网络 -  - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
</head>
<body onMouseOut="window.status='(tool.yowao.com)要哇实用查询!';return true">
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav2"><a href="/" >生活查询</a></li>
<li class="nav2"><a href="/yule" >娱乐工具</a></li>
<li class="nav2"><a href="/caijing" >财经商务</a></li>
<li class="nav2"><a href="/jisuan" >计算/学习</a></li>
<li class="nav1"><a href="/wangluo" >电脑网络</a></li>
<li class="nav2"><a href="/zhanzhang" >站长工具</a></li>
<li class="nav2"><a href="/jiaotong" >交通查询</a></li>
</ul></div>
</div></div></div>
<div class="w950">
<div class="knr"><div class="xdh">
<ul id="ful">
<script language="javascript" type="text/javascript" src="/js/wangluo.js"></script>
</ul></div></div>
<div class="head3"></div></div>

<script type="text/javascript">alimama_bm_revision = "909d86278c3145d2cc4df55fb92e1924f4ef0b31";alimama_bm_bid = "17332313";alimama_bm_width = 950;alimama_bm_height = 90;alimama_bm_xmlsrc = "http://img.uu1001.cn/x3/2011-02-05/00-27/2011-02-05_4c7dc8f3935fe17c11df62464abdadf0_0.xml";alimama_bm_link = "http%3A%2F%2F";alimama_bm_ds = "";alimama_bm_as = "default"</script><script type="text/javascript" src="http://img.uu1001.cn/bmv3.js?v=909d86278c3145d2cc4df55fb92e1924f4ef0b31"></script>
<div style='height:5px;'></div>
<div class="w950">
  <div class="head4">
    <div class="Ico_aBox">
      <div class="Ico_aBox_icon INico15"></div>
      <div class="Ico_aBox_tit">IP地址查询</div>
      <div class="Ico_aBox_intro">搜索IP地址所在的地理位置</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
      <div class="mobile_k mob_body mar10">
	 <form   name="form1"   method="post"   action="">
<b>IP/域名：</b><input name="ip" type="text" class="mob_int" value="" />
          <input type="submit" class="mob_copy1" value=" 提交 " onclick="getIpAddr();" />
          <input type="reset" class="mob_copy1" value=" 重置 ">
  	</form>
        <font style="color:#808080">* 收录IP数据<span>5818561条</span>，数据仅供参考，本站不对IP数据正确性承担任何责任！</font>
	  </div>
		
<div class="mobile_k mar10" id="ipResult" >
	<div class="mob_body1">
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
echo "您查询的IP:&nbsp;".$ip."<br>IP详细地址:&nbsp;".$QQWry->Country.$QQWry->Local."<br/>";
$ipl= $QQWry->Country;
}else
{
echo "您输入的好像火星IP,本站不能查询.";
}
}else{
$ip=get_real_ip();
if (($_SERVER["HTTP_CLIENT_IP"]) or ($_SERVER['HTTP_X_FORWARDED_FOR'])){
$ifErr=$QQWry->QQWry($ip); 
echo "您的真实IP是".$ip."<br>来自&nbsp;".$QQWry->Country.$QQWry->Local."<br/>"; 
$ipl= $QQWry->Country;
$ip=$_SERVER['REMOTE_ADDR'];
$ifErr=$QQWry->QQWry($ip); 
echo "您的代理IP是".$ip."<br>来自&nbsp;".$QQWry->Country.$QQWry->Local; 
}
else{
$ip=$_SERVER['REMOTE_ADDR']; 
$ifErr=$QQWry->QQWry($ip); 
echo "您查询的IP:&nbsp;".$ip."<br>IP详细地址:&nbsp;".$QQWry->Country.$QQWry->Local; 
$ipl= $QQWry->Country;
 }
}
?>
	</div>
	<div class="ip_copy"><input type="button" class="ip_anniu flo_l" value="复制查询结果" onclick="copyinfo($('ipResult').innerText,1);" /></div>
</div>
      <div class="mobile_k mob_body mar10">
<iframe src="http://tool.yowao.com/ip/ditu.htm?<?echo $ipl?>" height="430" width="700" frameborder="0" scrolling="no"></iframe>
</div>
		
		<div class="mob_det">IP是英文Instruction pointer的缩写，意思是“网络之间互连的协议”，IP协议也可以叫做“因特网协议”。<br />
	    通俗的讲：IP地址也可以称为互联网地址或Internet地址，是用来唯一标识互联网上计算机的逻辑地址。每台连网计算机都依靠IP地址来标识自己，就很类似于我们的电话号码一样，通过电话号码来找到相应的电话，全世界的电话号码都是唯一的。IP地址也是一样。</div>
      </div>
  </div>
  <div class="head3"></div>
<script language="javascript" type="text/javascript" src="/js/footer_nei.js"></script>
<div style="display:none"><script type="text/javascript" src="/js/tongji.js"></script></div>
</body>
</html>
