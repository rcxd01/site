<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询" />
<title>迅雷/快车下载地址转换 - 电脑网络 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>
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
      <div class="Ico_aBox_icon INico54"></div>
      <div class="Ico_aBox_tit">下载地址转换</div>
      <div class="Ico_aBox_intro">迅雷/快车下载地址转换</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
      <div class="mobile_k mob_body mar10">
<?php
if(!empty($_POST['source'])) {
if($_POST['btncode']=='加密') {
$xunleiencodeurl = "thunder://".base64_encode("AA".$_POST['source']."ZZ");
$flashgetencodeurl = "flashget://".base64_encode($_POST['source']);
echo<<<eot
	加密成功,以下是为您生成的地址，复制到下载工具即可下载.<br />
迅雷地址：{$xunleiencodeurl}<br />
快车地址：{$flashgetencodeurl}<hr>
eot;
}
if($_POST['btncode']=='解密') {
if(stristr($_POST['source'],'thunder://')){
echo '原始地址：'.substr(base64_decode(str_ireplace("thunder://","",$_POST['source'])),2,-2);
}
if(stristr($_POST['source'],'flashget://')){
echo '原始地址：'.str_ireplace("[FLASHGET]","",base64_decode(str_ireplace("flashget://","",$_POST['source'])));
}
}
}
?>
<form method="post">
请输入地址:<br />
<input name="source" size="48"><br /><br />
<input type="submit" name="btncode" class="mob_copy1" value="加密">
<input type="submit" name="btncode" class="mob_copy1" value="解密">
</form>
	  </div>		
		<div class="mob_det">只要把迅雷的加密地址或者快车的加密地址输入上面框中再点击解密，程序就会自动判断对应的协议再还原出原始地址。<br />如果您输入的是一个标准的HTTP下载地址那么就会输出迅雷和快车的下载专用加密地址。</div>
      </div>
  </div>
  <div class="head3"></div>
<script language="javascript" type="text/javascript" src="../js/footer_nei.js"></script>
<div style="display:none"><script type="text/javascript" src="/js/tongji.js"></script></div>
</body>
</html>


