<?php
set_time_limit(0);
$xiehouyu = trim($_GET['q']);
$id = $_GET['id'];

$r_num = 0; //结果个数
$lan = 1;
$pf = "";
$pf_l = "";

if($xiehouyu!=""){
	$dreamdb=file("data/xiehouyu.dat");//读取歇后语文件
	$count=count($dreamdb);//计算行数

	for($i=0; $i<$count; $i++) {
		$keyword=explode(" ",$xiehouyu);//拆分关键字
		$dreamcount=count($keyword);//关键字个数
		$detail=explode("\t",$dreamdb[$i]);
		for ($ai=0; $ai<$dreamcount; $ai++) {
			@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[0]\");");
			if(($found)){
				if(fmod($r_num,2)==0) $fcolor=' bgcolor="#f6f6f6"'; else $fcolor='';
				$pf_l .= '<tr'.$fcolor.'><td><a href="?id='.($i+1).'">'.$detail[0].'</a></td><td width="100"><input type="button" value=" 查看解释 " onclick="javascript:window.alert(\''.$detail[0].'\n\n—— '.trim($detail[1],"\n\r").'\');" /></td></tr>';
				$r_num++;
				break;
			}
		}
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b><a href="./">歇后语大全</a>：找到 <a href="./?q='.urlencode($xiehouyu).'"><font color="#c60a00">'.$xiehouyu.'</font></a> 的相关歇后语'.$r_num.'个</b></td></tr><tr><td><table id="cont" cellpadding="0" cellspacing="0" width="98%" align="center"><tr><td><strong>歇后语比喻</strong></td><td><strong>歇后语解释</strong></td></tr>'.$pf_l.'</table></td></tr></table>';
}elseif($id>0){
	$dreamdb=file("data/xiehouyu.dat");//读取歇后语文件
	$count=count($dreamdb);//计算行数

	$detail=explode("\t",$dreamdb[$id-1]);
	$pf = '<table width="700" cellpadding=2 cellspacing=0 class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle"><b><a href="./">歇后语大全</a>：'.$detail[0].'</b></td><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" align="right">';
	if($id>1 && $id<=$count) $pf .= '<a href="?id='.($id-1).'">上一个</a> ';
	$pf .= '<a href="./">查看全部</a>';
	if($id>=1 && $id<$count) $pf .= ' <a href="?id='.($id+1).'">下一个</a>';
	$pf .= '</td></tr><tr><td colspan="2" align="center"><br><table border="0" width="90%" style="font-size:14px;line-height:150%"><tr><td width="80">【比喻】</td><td>'.$detail[0].'</td></tr><tr><td>【解释】</td><td>'.$detail[1].'</td></tr></table><br></td></tr></table><br />';
}
if($xiehouyu=="" || $id){
	$dreamdb=file("data/xiehouyu.dat");//读取歇后语文件
	$count=count($dreamdb);//计算行数
	$pfl = rand(0,intval($count/60));

	for($i=$pfl*60; $i<$pfl*60+60; $i++) {
		if($i>=$count-1) break;
		$detail2=explode("\t",$dreamdb[$i]);
		if(fmod($r_num,2)==0) $fcolor=' bgcolor="#f6f6f6"'; else $fcolor='';
		$pf_l .= '<tr'.$fcolor.'><td><a href="?id='.($i+1).'">'.$detail2[0].'</a></td><td width="100"><input type="button" value=" 查看解释 " onclick="document.location=\'?id='.($i+1).'\'" /></td></tr>';
		$r_num++;
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b>推荐歇后语'.$r_num.'个</b></td></tr><tr><td><br><table id="cont" cellpadding="0" cellspacing="0" width="96%" align="center">'.$pf_l.'</table><br></td></tr></table>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
if($xiehouyu){
	echo "<title>".$xiehouyu." - 歇后语大全 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.$xiehouyu.',歇后语,歇后语大全," />';
}elseif($id>0 && $id<=$count){
	echo "<title>".$detail[0]." - 歇后语大全 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.$detail[0].',歇后语,歇后语大全" />';
	echo '<meta name="description" content="歇后语比喻：'.$detail[0].' -- 解释：'.trim($detail[1],"\n\r").'" />';
}else{
	echo "<title>歇后语大全 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,歇后语,歇后语大全" />';
	echo '<meta name="description" content="歇后语是我国人民在生活实践中创造的一种特殊语言形式。它一般由两个部分构成，前半截是形象的比喻，像谜面，后半截是解释、说明，像谜底，十分自然贴切。在一定的语言环境中，通常说出前半截，“歇”去后半截，就可以领会和猜想出它的本意，所以称它为歇后语。" />';
}
?>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
</head>
<body onMouseOut="window.status='(tool.yowao.com)要哇实用查询!';return true">
<style type="text/css">
h3{font-size:18px;padding:10px 0 0 10px;color:#014198;}
p{padding: 10px;font-size:18px}
a.lan,a.lan:visited{color:#999;}
#cont td{height:30px;font-size:14px;padding:0 10px}
#cont a,#cont a:visited{text-decoration:none;}
#cont a:hover{text-decoration:underline;}
</style>
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav2"><a href="/" >生活查询</a></li>
<li class="nav1"><a href="/yule" >娱乐工具</a></li>
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
<script language="javascript" type="text/javascript" src="/js/yule.js"></script>
</ul></div></div>
<div class="head3"></div></div>

<script type="text/javascript">alimama_bm_revision = "909d86278c3145d2cc4df55fb92e1924f4ef0b31";alimama_bm_bid = "17332313";alimama_bm_width = 950;alimama_bm_height = 90;alimama_bm_xmlsrc = "http://img.uu1001.cn/x3/2011-02-05/00-27/2011-02-05_4c7dc8f3935fe17c11df62464abdadf0_0.xml";alimama_bm_link = "http%3A%2F%2F";alimama_bm_ds = "";alimama_bm_as = "default"</script><script type="text/javascript" src="http://img.uu1001.cn/bmv3.js?v=909d86278c3145d2cc4df55fb92e1924f4ef0b31"></script>
<div style='height:5px;'></div>
<div class="w950">
  <div class="head4">
    <div class="Ico_aBox">
      <div class="Ico_aBox_icon INico26"></div>
      <div class="Ico_aBox_tit">歇后语大全</div>
      <div class="Ico_aBox_intro">最全最经典的歇后语</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;" id="top"><tr><td align="center" valign="middle" height="60"><form action="./" method="get" name="f1"><b>搜索歇后语:</b><input name="q" id="q" type="text" size="18" delay="0" value="" style="width:200px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" /> <input type="submit" class="mob_copy1" value=" 搜索 " /></form></td></tr><tr><td align="center" height="30" style="font-size:14px;">输入最短的关键字，如查找<a href="./?q=鼠">老鼠</a>相关的歇后语,输入<a href="./?q=鼠">鼠</a>后按Enter即可</td></tr></table><div style='height:10px;'></div>
<?php
if($xiehouyu!=""){
	echo $pf_l;
}elseif($id>0 && $id<=$count){
	echo $pf.$pf_l;
}else{
?>
<table width="700" cellpadding="2" class="mob_ace" cellspacing="0" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b>歇后语大全</b></td></tr><tr><td><p style="line-height:150%;font-size:12px;">　　歇后语是我国人民在生活实践中创造的一种特殊语言形式。它一般由两个部分构成，前半截是形象的比喻，像谜面，后半截是解释、说明，像谜底，十分自然贴切。在一定的语言环境中，通常说出前半截，“歇”去后半截，就可以领会和猜想出它的本意，所以称它为歇后语。<br />　
四季相关歇后语：<a href="?q=春">春</a> <a href="?q=夏">夏</a> <a href="?q=秋">秋</a> <a href="?q=冬">冬</a><br />　
十二生肖歇后语：<a href="?q=鼠">鼠</a> <a href="?q=牛">牛</a> <a href="?q=虎">虎</a> <a href="?q=兔">兔</a> <a href="?q=龙">龙</a> <a href="?q=蛇">蛇</a> <a href="?q=马">马</a> <a href="?q=羊">羊</a> <a href="?q=猴">猴</a> <a href="?q=鸡">鸡</a> <a href="?q=狗">狗</a> <a href="?q=猪">猪</a><br />
&nbsp;&nbsp;&nbsp;&nbsp;描写数字歇后语：<a href="?q=一">一</a> <a href="?q=二">二</a> <a href="?q=三">三</a> <a href="?q=四">四</a> <a href="?q=五">五</a> <a href="?q=六">六</a> <a href="?q=七">七</a> <a href="?q=八">八</a> <a href="?q=九">九</a> <a href="?q=十">十</a> <a href="?q=百">百</a> <a href="?q=千">千</a> <a href="?q=万">万</a><br />
</p></td></tr></table><div style='height:10px;'></div>
<?php
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


