<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta name="keywords" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ" />
<title>IP��ַ��ѯ - �������� -  - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ�۲�ѯ����</title>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
</head>
<body onMouseOut="window.status='(tool.yowao.com)Ҫ��ʵ�ò�ѯ!';return true">
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav2"><a href="/" >�����ѯ</a></li>
<li class="nav2"><a href="/yule" >���ֹ���</a></li>
<li class="nav2"><a href="/caijing" >�ƾ�����</a></li>
<li class="nav2"><a href="/jisuan" >����/ѧϰ</a></li>
<li class="nav1"><a href="/wangluo" >��������</a></li>
<li class="nav2"><a href="/zhanzhang" >վ������</a></li>
<li class="nav2"><a href="/jiaotong" >��ͨ��ѯ</a></li>
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
      <div class="Ico_aBox_tit">IP��ַ��ѯ</div>
      <div class="Ico_aBox_intro">����IP��ַ���ڵĵ���λ��</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
      <div class="mobile_k mob_body mar10">
	 <form   name="form1"   method="post"   action="">
<b>IP/������</b><input name="ip" type="text" class="mob_int" value="" />
          <input type="submit" class="mob_copy1" value=" �ύ " onclick="getIpAddr();" />
          <input type="reset" class="mob_copy1" value=" ���� ">
  	</form>
        <font style="color:#808080">* ��¼IP����<span>5818561��</span>�����ݽ����ο�����վ����IP������ȷ�Գе��κ����Σ�</font>
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
echo "����ѯ��IP:&nbsp;".$ip."<br>IP��ϸ��ַ:&nbsp;".$QQWry->Country.$QQWry->Local; 
$ipl= $QQWry->Country;
 }
}
?>
	</div>
	<div class="ip_copy"><input type="button" class="ip_anniu flo_l" value="���Ʋ�ѯ���" onclick="copyinfo($('ipResult').innerText,1);" /></div>
</div>
      <div class="mobile_k mob_body mar10">
<iframe src="http://tool.yowao.com/ip/ditu.htm?<?echo $ipl?>" height="430" width="700" frameborder="0" scrolling="no"></iframe>
</div>
		
		<div class="mob_det">IP��Ӣ��Instruction pointer����д����˼�ǡ�����֮�以����Э�顱��IPЭ��Ҳ���Խ�����������Э�顱��<br />
	    ͨ�׵Ľ���IP��ַҲ���Գ�Ϊ��������ַ��Internet��ַ��������Ψһ��ʶ�������ϼ�������߼���ַ��ÿ̨���������������IP��ַ����ʶ�Լ����ͺ����������ǵĵ绰����һ����ͨ���绰�������ҵ���Ӧ�ĵ绰��ȫ����ĵ绰���붼��Ψһ�ġ�IP��ַҲ��һ����</div>
      </div>
  </div>
  <div class="head3"></div>
<script language="javascript" type="text/javascript" src="/js/footer_nei.js"></script>
<div style="display:none"><script type="text/javascript" src="/js/tongji.js"></script></div>
</body>
</html>
