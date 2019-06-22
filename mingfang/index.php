<?php
set_time_limit(0);
$prescription = trim($_GET['q']);
$id = intval($_GET['id']);

$r_num = 0; //结果个数
$lan = 3;
$pf = "";
$pf_l = "";

if($prescription!=""){
	$dreamdb=file("data/mf.dat");//读取名方文件
	$count=count($dreamdb);//计算行数

	for($i=0; $i<$count; $i++) {
		$keyword=explode(" ",$prescription);//拆分关键字
		$dreamcount=count($keyword);//关键字个数
		$detail=explode("\t",$dreamdb[$i]);
		for ($ai=0; $ai<$dreamcount; $ai++) {
			@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[0]\");");
			if(($found)){
				if(fmod($r_num,$lan)==0) $pf_l .= "<tr>";
				$pf_l .= '<td width="'.(100/$lan).'%"><img src="/img/jiantou.gif" /> <a href="?id='.($i+1).'">'.$detail[0].'</a></td>';
				if(fmod($r_num,$lan)+1==$lan) $pf_l .= "</tr>";
				$r_num++;
				break;
			}
		}
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b><a href="./">中草药名方</a>：找到 <a href="./?q='.urlencode($prescription).'"><font color="#c60a00">'.$prescription.'</font></a> 的相关名方'.$r_num.'个</b></td></tr><tr><td><table cellpadding="5" cellspacing="10" width="100%">'.$pf_l.'</table></td></tr></table>';
}elseif($id>0){
	$dreamdb=file("data/mf.dat");//读取名方文件
	$count=count($dreamdb);//计算行数

	$detail=explode("\t",$dreamdb[$id-1]);
	$pf = '<table width="700" cellpadding=2 cellspacing=0 class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle"><b><a href="./">中草药名方</a> / '.$detail[0].'</b></td><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" align="right">';
	if($id>1 && $id<=$count) $pf .= '<a href="?id='.($id-1).'">上一个</a> ';
	$pf .= '<a href="./">查看全部</a>';
	if($id>=1 && $id<$count) $pf .= ' <a href="?id='.($id+1).'">下一个</a>';
	$pf .= '</td></tr><tr><td align="center" colspan="2"><h3>'.$detail[0].'</h3></td></tr><tr><td style="padding:5px;line-height:21px;" colspan="2"><p>'.$detail[1].'</p><center><b><font color=#F77824>要哇</font></b><font color=#5AA2EE>提醒您：</font><font color=#FF0000>此中草药名方来源于网络，使用前请遵医嘱。</font></center></td></tr></table>';
}else{
	$dreamdb=file("data/mf.dat");//读取名方文件
	$count=count($dreamdb);//计算行数

	$pfl = rand(0,intval($count/60));

	for($i=$pfl*60; $i<$pfl*60+60; $i++) {
		if($i>=$count-1) break;
		$detail=explode("\t",$dreamdb[$i]);
		if(fmod($r_num,$lan)==0) $pf_l .= "<tr>";
		$pf_l .= '<td width="'.(100/$lan).'%"><img src="/img/jiantou.gif" /> <a href="?id='.($i+1).'">'.$detail[0].'</a></td>';
		if(fmod($r_num,$lan)+1==$lan) $pf_l .= "</tr>";
		$r_num++;
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>推荐中草药名方'.$r_num.'个</b></td></tr><tr><td><table cellpadding="5" cellspacing="10" width="100%">'.$pf_l.'</table></td></tr></table>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
if($prescription){
	echo "<title>".$prescription." - 中草药名方大全 - 生活查询 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.$prescription.',中草药,名方,中药,中草药名方大全" />';
}elseif($id>0 && $id<=$count){
	echo "<title>".$detail[0]." - 中草药名方大全 - 生活查询 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.$detail[0].',中草药,名方,中药,中草药名方大全" />';
	echo '<meta name="description" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.str_replace("<br>","",$detail[1]).'中草药名方大全。" />';
}else{
	echo "<title>中草药名方大全 - 生活查询 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,中草药名方,名方大全" />';
	echo '<meta name="description" content="中草药名方大全，中草药，是中医所使用的独特药物，也是中医区别于其他医学的重要标志。中国人民对中草药的探索经历了几千年的历史。相传，神农尝百草，首创医药，神农被尊为“药皇”。中药主要由植物药（根、茎、叶、果）、动物药（内脏、皮、骨、器官等）和矿物药组成。因植物药占中药的大多数，所以中药也称中草药。" />';
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
      <div class="Ico_aBox_icon INico24"></div>
      <div class="Ico_aBox_tit">中草药名方</div>
      <div class="Ico_aBox_intro">中草药名方大全</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
<table width="700" cellpadding="2" cellspacing="0" style="border:1px solid #A4C4DC;" id="top"><tr><td align="center" valign="middle" height="60"><form action="./" method="get" name="f1"><b>搜索名方:</b><input name="q" id="q" type="text" size="18" delay="0" value="" style="width:200px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" /> <input type="submit" class="mob_copy1" value=" 搜索 " /></form></td></tr><tr><td align="center" height="30" style="font-size:14px;">名方分类：<a href="./?q=%CC%C0">汤</a> <a href="./?q=%CD%E8">丸</a> <a href="./?q=%C9%A2">散</a> <a href="./?q=%B8%E0">膏</a> <a href="./?q=%D2%FB">饮</a> <a href="./?q=%B8%E2">糕</a> <a href="./?q=%F4%FA">酊</a> <a href="./?q=%BC%C1">剂</a> <a href="./?q=%BC%E5">煎</a> <a href="./?q=%BE%C6">酒</a> <a href="./?q=%D6%E0">粥</a> <a href="./?q=%B7%BD">方</a></td></tr></table><div style='height:10px;'></div>
<?php
if($prescription!=""){
	//echo $pf_l.$pf;
	echo $pf_l;
}elseif($id>0 && $id<=$count){
	echo $pf;
}else{
	echo '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>中草药名方大全</b></td></tr><tr><td><p style="line-height:150%">所谓中草药，是中医所使用的独特药物，也是中医区别于其他医学的重要标志。中国人民对中草药的探索经历了几千年的历史。相传，神农尝百草，首创医药，神农被尊为“药皇”。<br>　中药主要由植物药（根、茎、叶、果）、动物药（内脏、皮、骨、器官等）和矿物药组成。因植物药占中药的大多数，所以中药也称中草药。<br>　　目前，各地使用的中药已达5000种左右，把各种药材相配伍而形成的方剂，更是数不胜数。经过几千年的研究，形成了一门独立的科学——本草学。
</p></td></tr></table><br>';
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


