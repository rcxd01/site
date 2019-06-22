<?php
set_time_limit(0);
$prescription = trim($_GET['q']);
$id = intval($_GET['id']);

$r_num = 0; //结果个数
$lan = 2;
$pf = "";
$pf_l = "";

if($prescription!=""){
	$dreamdb=file("data/pft.dat");//读取偏方文件
	$count=count($dreamdb);//计算行数

	for($i=0; $i<$count; $i++) {
		$keyword=explode(" ",$prescription);//拆分关键字
		$dreamcount=count($keyword);//关键字个数
		for ($ai=0; $ai<$dreamcount; $ai++) {
			@eval("\$found = eregi(\"$keyword[$ai]\",\"$dreamdb[$i]\");");
			if(($found)){
				$detail=explode("\t",$dreamdb[$i]);
				if(fmod($r_num,$lan)==0) $pf_l .= "<tr>";
				$pf_l .= '<td width="'.(100/$lan).'%">[<a href="./?q='.urlencode($detail[1]).'" class="lan">'.$detail[1].'</a>';
				if(trim($detail[2],"\r\n")!="") $pf_l .= '|<a href="./?q='.urlencode($detail[2]).'" class="lan">'.trim($detail[2],"\r\n").'</a>';
				$pf_l .= '] <img src="/img/jiantou.gif" /> <a href="?id='.($i+1).'">'.$detail[0].'</a></td>';
				if(fmod($r_num,$lan)+1==$lan) $pf_l .= "</tr>";
				$r_num++;
				break;
			}
		}
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b><a href="./">民间偏方</a>：找到 <a href="./?q='.urlencode($prescription).'"><font color="#c60a00">'.$prescription.'</font></a> 的相关偏方'.$r_num.'个</b></td></tr><tr><td><table cellpadding="5" cellspacing="10" width="100%">'.$pf_l.'</table></td></tr></table>';
}elseif($id>0){
	$dreamdb=file("data/pf.dat");//读取偏方文件
	$count=count($dreamdb);//计算行数

	$detail=explode("\t",$dreamdb[$id-1]);
	$pf = '<table width="700" cellpadding=2 cellspacing=0 class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle"><b><a href="./">民间偏方</a> / <a href="./?q='.urlencode($detail[1]).'">'.$detail[1].'</a> / <a href="./?q='.urlencode($detail[2]).'">'.trim($detail[2],"\r\n").'</a> / '.$detail[0].'</b></td><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" align="right">';
	if($id>1 && $id<=$count) $pf .= '<a href="?id='.($id-1).'">上一个</a> ';
	$pf .= '<a href="./">查看全部</a>';
	if($id>=1 && $id<$count) $pf .= ' <a href="?id='.($id+1).'">下一个</a>';
	$pf .= '</td></tr><tr><td align="center" colspan="2"><h3>'.$detail[0].'</h3></td></tr><tr><td style="padding:5px;line-height:21px;" colspan="2"><p>'.$detail[3].'</p><center><b><font color=#F77824>要哇</font></b><font color=#5AA2EE>提醒您：</font><font color=#FF0000>此民间偏方来源于网络，使用前请遵医嘱。</font></center></td></tr></table>';
}else{
	$dreamdb=file("data/pft.dat");//读取偏方文件
	$count=count($dreamdb);//计算行数

	$pfl = rand(0,intval($count/30));

	for($i=$pfl*30; $i<$pfl*30+30; $i++) {
		if($i>=$count-1) break;
		$detail=explode("\t",$dreamdb[$i]);
		if(fmod($r_num,$lan)==0) $pf_l .= "<tr>";
		$pf_l .= '<td width="'.(100/$lan).'%">[<a href="./?q='.urlencode($detail[1]).'" class="lan">'.$detail[1].'</a>';
		if(trim($detail[2],"\r\n")!="") $pf_l .= '|<a href="./?q='.urlencode($detail[2]).'" class="lan">'.trim($detail[2],"\r\n").'</a>';
		$pf_l .= '] <img src="/img/jiantou.gif" /> <a href="?id='.($i+1).'">'.$detail[0].'</a></td>';
		if(fmod($r_num,$lan)+1==$lan) $pf_l .= "</tr>";
		$r_num++;
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>推荐民间偏方'.$r_num.'个</b></td></tr><tr><td><table cellpadding="5" cellspacing="10" width="100%">'.$pf_l.'</table></td></tr></table>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
if($prescription){
	echo "<title>".$prescription." - 民间偏方大全 - 生活查询 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>";
	echo '<meta name="keywords" content="'.$prescription.',民间偏方,中医偏方,中药偏方,偏方大全" />';
}elseif($id>0 && $id<=$count){
	echo "<title>".$detail[0]." - ".$detail[2]." - ".$detail[1]." - 民间偏方大全 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.$detail[0].",".$detail[2].",".$detail[1].',偏方,民间偏方大全" />';
}else{
	echo "<title>民间偏方大全 - 生活查询 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,民间偏方,中医偏方,中药偏方,偏方大全" />';
	echo '<meta name="description" content="民间偏方大全tool.yowao.com，收集各种中医偏方，中药偏方，小偏方，有减肥偏方，美容偏方，咳嗽偏方，鼻炎偏方，牛皮癣偏方，止咳偏方，牙疼偏方，感冒偏方，咳嗽偏方，痔疮偏方，糖尿病偏方，生发偏方，冻疮偏方，高血压偏方，胃病偏方，便秘偏方等。" />';
}
?>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
</head>
<body onMouseOut="window.status='(tool.yowao.com)要哇实用查询!';return true">
<style type="text/css">
h3{font-size:24px;padding:15px 10px 5px 10px;color:#014198;}
p{padding: 10px;}
a.lan,a.lan:visited{color:#999;}
</style>
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav1"><a href="/" >生活查询</a></li>
<li class="nav2"><a href="/yule" >娱乐工具</a></li>
<li class="nav2"><a href="/caijing" >财经商务</a></li>
<li class="nav2"><a href="/jisuan" >计算/学习</a></li>
<li class="nav2"><a href="/wangluo" >电脑网络</a></li>
<li class="nav2"><a href="/zhanzhang" >站长工具</a></li>
<li class="nav2"><a href="/jiaotong" >交通查询</a></li>
</ul></div>
</div></div></div>
<div class="w950">
<div class="knr"><div class="xdh">
<ul id="ful">
<script language="javascript" type="text/javascript" src="/js/shenghuo.js"></script>
</ul></div></div>
<div class="head3"></div></div>

<script type="text/javascript">alimama_bm_revision = "909d86278c3145d2cc4df55fb92e1924f4ef0b31";alimama_bm_bid = "17332313";alimama_bm_width = 950;alimama_bm_height = 90;alimama_bm_xmlsrc = "http://img.uu1001.cn/x3/2011-02-05/00-27/2011-02-05_4c7dc8f3935fe17c11df62464abdadf0_0.xml";alimama_bm_link = "http%3A%2F%2F";alimama_bm_ds = "";alimama_bm_as = "default"</script><script type="text/javascript" src="http://img.uu1001.cn/bmv3.js?v=909d86278c3145d2cc4df55fb92e1924f4ef0b31"></script>
<div style='height:5px;'></div>
<div class="w950">
  <div class="head4">
    <div class="Ico_aBox">
      <div class="Ico_aBox_icon INico23"></div>
      <div class="Ico_aBox_tit">偏方</div>
      <div class="Ico_aBox_intro">民间偏方大全</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
<table width="700" cellpadding="2" cellspacing="0" style="border:1px solid #A4C4DC;" id="top"><tr><td align="center" valign="middle" height="60"><form action="./" method="get" name="f1"><b>搜索偏方：</b><input name="q" id="q" type="text" size="18" delay="0" value="" style="width:200px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" /> <input type="submit" class="mob_copy1" value=" 搜索 " /></form></td></tr><tr><td align="center" height="30" style="font-size:14px;">偏方分类：<a href="./?q=%C4%DA%BF%C6">内科</a> <a href="./?q=%CD%E2%BF%C6">外科</a> <a href="./?q=%D6%D7%C1%F6">肿瘤</a> <a href="./?q=%C6%A4%B7%F4">皮肤</a> <a href="./?q=%CE%E5%B9%D9">五官</a> <a href="./?q=%B8%BE%BF%C6">妇科</a> <a href="./?q=%C4%D0%BF%C6">男科</a> <a href="./?q=%B6%F9%BF%C6">儿科</a> <a href="./?q=%B1%A3%BD%A1">保健</a> <a href="./?q=%D2%A9%BE%C6">药酒</a> <a href="./?q=%C6%E4%CB%FB">其他</a></td></tr></table><div style='height:10px;'></div>
<?php
if($prescription!=""){
	//echo $pf_l.$pf;
	echo $pf_l;
}elseif($id>0 && $id<=$count){
	echo $pf;
}else{
	echo '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>民间偏方大全</b></td></tr><tr><td><p style="line-height:150%">　　所谓偏方，是指药味不多，对某些病症具有独特疗效的方剂。数千年来，在我国民间流传着非常丰富、简单而又疗效神奇的治疗疑难杂症的偏方、秘方、验方，方书著作浩如烟海。本站特将流传于民间的偏方加以收集整理，汇集成这一《民间偏方大全》，共收录了各类偏方、验方、秘方7000余条。<br />　　此《民间偏方大全》之食疗、土方精选，所用方材均以民间土方、偏方为主，不仅易找、易买、易用，而且疗效神奇，又无副作用。它汇集了古今诸多名方、妙方、秘方，最适合家庭使用。当您患有疑难病久治未愈时，不妨试一试这些民间偏方，或许能起到意想不到的疗效。这些民间偏方不但适合家庭进行自我治疗，对医院的一些中医以及西医专业医生来讲，也是很有参考价值的。<br />　　注意：偏方疗效会因时令、地域和各人的身体状况不同而异，请采用本站的偏方方剂时，要根据地域和自己的身体情况有选择地选用合适的方剂，适时地进行疗补。</p></td></tr></table>
<br>';
	echo $pf_l;
}
?>
</div>
</div>
  <div class="head3"></div>
<script language="javascript" type="text/javascript" src="/js/footer_nei.js"></script>
<div style="display:none"><script type="text/javascript" src="/js/tongji.js"></script></div>
</body>
</html>


