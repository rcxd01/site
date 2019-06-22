<?php
set_time_limit(0);
$naojin = trim($_GET['q']);
$id = $_GET['id'];

$r_num = 0; //结果个数
$lan = 1;
$pf = "";
$pf_l = "";

if($naojin!=""){
	$dreamdb=file("data/naojin.dat");//读取脑筋急转弯文件
	$count=count($dreamdb);//计算行数

	for($i=0; $i<$count; $i++) {
		$keyword=explode(" ",$naojin);//拆分关键字
		$dreamcount=count($keyword);//关键字个数
		$detail=explode("\t",$dreamdb[$i]);
		for ($ai=0; $ai<$dreamcount; $ai++) {
			@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[0]\");");
			if(($found)){
				if(fmod($r_num,2)==0) $fcolor=' bgcolor="#f6f6f6"'; else $fcolor='';
				$pf_l .= '<tr'.$fcolor.'><td><a href="?id='.($i+1).'">'.$detail[0].'</a></td><td width="100"><input type="button" value=" 查看答案 " onclick="document.location=\'?id='.($i+1).'\'" /></td></tr>';
				$r_num++;
				break;
			}
		}
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b><a href="./">脑筋急转弯</a>：找到 <a href="./?q='.urlencode($naojin).'"><font color="#c60a00">'.$naojin.'</font></a> 的相关脑筋急转弯'.$r_num.'个</b></td></tr><tr><td><table id="cont" cellpadding="0" cellspacing="0" width="98%" align="center"><tr><td><strong>问题</strong></td><td><strong>答案</strong></td></tr>'.$pf_l.'</table></td></tr></table>';
}elseif($id>0){
	$dreamdb=file("data/naojin.dat");//读取脑筋急转弯文件
	$count=count($dreamdb);//计算行数

	$detail=explode("\t",$dreamdb[$id-1]);
	$pf = '<table width="700" cellpadding=2 cellspacing=0 class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle"><b><a href="./">脑筋急转弯</a> > 问题</b></td><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" align="right">';
	if($id>1 && $id<=$count) $pf .= '<a href="?id='.($id-1).'">上一个</a> ';
	$pf .= '<a href="./">查看全部</a>';
	if($id>=1 && $id<$count) $pf .= ' <a href="?id='.($id+1).'">下一个</a>';
	$pf .= '</td></tr><tr><td colspan="2" align="center"><br><table border="0" width="90%" style="font-size:14px;line-height:150%"><tr><td width="80">【问题】</td><td>'.$detail[0].'</td></tr><tr><td>【答案】</td><td><input type="button" value=" 查看答案 " onclick="javascript:window.alert(\''.$detail[0].'\n\n—— '.trim($detail[1],"\n\r").'\');" /></td></tr></table><br></td></tr></table><br />';
}
if($naojin=="" || $id){
	$dreamdb=file("data/naojin.dat");//读取脑筋急转弯文件
	$count=count($dreamdb);//计算行数
	$pfl = rand(0,intval($count/60));

	for($i=$pfl*60; $i<$pfl*60+60; $i++) {
		if($i>=$count-1) break;
		$detail2=explode("\t",$dreamdb[$i]);
		if(fmod($r_num,2)==0) $fcolor=' bgcolor="#f6f6f6"'; else $fcolor='';
		$pf_l .= '<tr'.$fcolor.'><td><a href="?id='.($i+1).'">'.$detail2[0].'</a></td><td width="100"><input type="button" value=" 查看答案 " onclick="document.location=\'?id='.($i+1).'\'" /></td></tr>';
		$r_num++;
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b>推荐脑筋急转弯'.$r_num.'个</b></td></tr><tr><td><br><table id="cont" cellpadding="0" cellspacing="0" width="96%" align="center">'.$pf_l.'</table><br></td></tr></table>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
if($naojin){
	echo "<title>".$naojin." - 脑筋急转弯 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.$naojin.',脑筋急转弯,脑筋急转弯," />';
}elseif($id>0 && $id<=$count){
	echo "<title>".$detail[0]." - 脑筋急转弯 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.$detail[0].',脑筋急转弯,脑筋急转弯大全" />';
	echo '<meta name="description" content="脑筋急转弯比喻：'.$detail[0].' -- 解释：'.trim($detail[1],"\n\r").'" />';
}else{
	echo "<title>脑筋急转弯 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,脑筋急转弯,脑筋急转弯" />';
	echo '<meta name="description" content="脑筋急转弯是一种大众化的文字游戏。这种文字游戏有个明显的特点，题面很普通，但答案十分气人，一经破，令人喷饭。像早几年就有的“读完‘北京大学’要多长时间？”（答案是不足一秒）、“动物园里只比大象鼻子短的动物是什么？”（答案是“小象”），都令人叫绝。 还有一个特点，答案与题面不一定有逻辑上的联系，有的答案甚至是一种诡辩。所以，答案都是别出心裁，突破常理的，能给人以谐趣、机敏、睿智的感觉。诸如“什么东西最容易满足”，把“满”和“足”分开理解，答案是袜子。当然答案也不一定唯一，就看谁的更能刺激别人的笑神经了。因此，对同一个题面，你也可以尝试着寻找更有趣更吸引人们眼球的答案。 脑筋急转弯就是指当思维遇到特殊的阻碍时，要很快的离开习惯的思路，从别的方面来思考问题。现在泛指一些不能用通常的思路来回答的的智力问答题。脑筋急转弯分类比较广泛：有益智类，搞笑类，数学类，成人类等。" />';
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
      <div class="Ico_aBox_icon INico62"></div>
      <div class="Ico_aBox_tit">脑筋急转弯</div>
      <div class="Ico_aBox_intro">考考你的脑袋瓜子</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;" id="top"><tr><td align="center" valign="middle" height="60"><form action="./" method="get" name="f1"><b>搜索脑筋急转弯:</b><input name="q" id="q" type="text" size="18" delay="0" value="" style="width:200px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" /> <input type="submit" class="mob_copy1" value=" 搜索 " /></form></td></tr><tr><td align="center" height="30" style="font-size:14px;">输入最短的关键字，如查<a href="./?q=男">男人</a>相关的脑筋急转弯,输入<a href="./?q=男">男</a>后按Enter即可</td></tr></table><div style='height:10px;'></div>
<?php
if($naojin!=""){
	echo $pf_l;
}elseif($id>0 && $id<=$count){
	echo $pf.$pf_l;
}else{
?>
<table width="700" cellpadding="2" class="mob_ace" cellspacing="0" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b>脑筋急转弯</b></td></tr><tr><td><p style="line-height:150%;font-size:12px;">　　脑筋急转弯是一种大众化的文字游戏。这种文字游戏有个明显的特点，题面很普通，但答案十分气人，一经破，令人喷饭。像早几年就有的“读完‘北京大学’要多长时间？”（答案是不足一秒）、“动物园里只比大象鼻子短的动物是什么？”（答案是“小象”），都令人叫绝。 <br>　　还有一个特点，答案与题面不一定有逻辑上的联系，有的答案甚至是一种诡辩。所以，答案都是别出心裁，突破常理的，能给人以谐趣、机敏、睿智的感觉。诸如“什么东西最容易满足”，把“满”和“足”分开理解，答案是袜子。当然答案也不一定唯一，就看谁的更能刺激别人的笑神经了。因此，对同一个题面，你也可以尝试着寻找更有趣更吸引人们眼球的答案。<br>　　 脑筋急转弯就是指当思维遇到特殊的阻碍时，要很快的离开习惯的思路，从别的方面来思考问题。现在泛指一些不能用通常的思路来回答的的智力问答题。脑筋急转弯分类比较广泛：有益智类，搞笑类，数学类，成人类等
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


