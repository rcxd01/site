<?php
set_time_limit(0);
$miyu = trim($_GET['q']);
$id = $_GET['id'];

$r_num = 0; //结果个数
$lan = 1;
$pf = "";
$pf_l = "";

if($miyu!=""){
	$dreamdb=file("data/miyu.dat");//读取谜语文件
	$count=count($dreamdb);//计算行数

	for($i=0; $i<$count; $i++) {
		$keyword=explode(" ",$miyu);//拆分关键字
		$dreamcount=count($keyword);//关键字个数
		$detail=explode("\t",$dreamdb[$i]);
		for ($ai=0; $ai<$dreamcount; $ai++) {
			@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[0]\");");
			if(($found)){
				if(fmod($r_num,2)==0) $fcolor=' bgcolor="#f6f6f6"'; else $fcolor='';
				$pf_l .= '<tr'.$fcolor.'><td><a href="?id='.($i+1).'">'.$detail[0].'</a></td><td width="100"><input type="button" value=" 查看谜底 " onclick="document.location=\'?id='.($i+1).'\'" /></td></tr>';
				$r_num++;
				break;
			}
		}
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b><a href="./">谜语大全</a>：找到 <a href="./?q='.urlencode($miyu).'"><font color="#c60a00">'.$miyu.'</font></a> 的相关谜语'.$r_num.'个</b></td></tr><tr><td><table id="cont" cellpadding="0" cellspacing="0" width="98%" align="center"><tr><td><strong>谜语</strong></td><td><strong>谜底</strong></td></tr>'.$pf_l.'</table></td></tr></table>';
}elseif($id>0){
	$dreamdb=file("data/miyu.dat");//读取谜语文件
	$count=count($dreamdb);//计算行数

	$detail=explode("\t",$dreamdb[$id-1]);
	$pf = '<table width="700" cellpadding=2 cellspacing=0 class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle"><b><a href="./">谜语大全</a>：'.$detail[1].'</b></td><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" align="right">';
	if($id>1 && $id<=$count) $pf .= '<a href="?id='.($id-1).'">上一个</a> ';
	$pf .= '<a href="./">查看全部</a>';
	if($id>=1 && $id<$count) $pf .= ' <a href="?id='.($id+1).'">下一个</a>';
	$pf .= '</td></tr><tr><td colspan="2" align="center"><br><table border="0" width="90%" style="font-size:14px;line-height:150%"><tr><td width="80">【谜语】</td><td>'.$detail[0].'</td></tr><tr><td>【谜底】</td><td><input type="button" value=" 查看答案 " onclick="javascript:window.alert(\''.$detail[0].'\n\n—— '.trim($detail[2],"\n\r").'\');" /></td></tr></table><br></td></tr></table><br />';
}
if($miyu=="" || $id){
	$dreamdb=file("data/miyu.dat");//读取谜语文件
	$count=count($dreamdb);//计算行数
	$pfl = rand(0,intval($count/60));

	for($i=$pfl*60; $i<$pfl*60+60; $i++) {
		if($i>=$count-1) break;
		$detail2=explode("\t",$dreamdb[$i]);
		if(fmod($r_num,2)==0) $fcolor=' bgcolor="#f6f6f6"'; else $fcolor='';
		$pf_l .= '<tr'.$fcolor.'><td><a href="?id='.($i+1).'">'.$detail2[0].'</a></td><td width="100"><input type="button" value=" 查看谜底 " onclick="document.location=\'?id='.($i+1).'\'" /></td></tr>';
		$r_num++;
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b>推荐谜语'.$r_num.'个</b></td></tr><tr><td><br><table id="cont" cellpadding="0" cellspacing="0" width="96%" align="center">'.$pf_l.'</table><br></td></tr></table>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
if($miyu){
	echo "<title>".$miyu." - 谜语大全 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.$miyu.',谜语,谜语大全," />';
}elseif($id>0 && $id<=$count){
	echo "<title>".$detail[0]." - 谜语大全 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,'.$detail[0].',谜语,谜语大全" />';
	echo '<meta name="description" content="谜语比喻：'.$detail[0].' -- 解释：'.trim($detail[1],"\n\r").'" />';
}else{
	echo "<title>谜语大全 - 娱乐工具 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇实用查询</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询,谜语,谜语大全" />';
	echo '<meta name="description" content="谜语的猜法多种多样，比较常见的有二十多种。属于会意体的有会意法、反射法、借扣法、侧扣法、分扣发、溯源法；属于增损体的有加法、减法、加减法；属于离合体的有离底法、离面法；属于象形体的有象形法、象画法；属于谐音体的有直谐法、间谐法；属于综合体的有比较法、拟人法、拟物法、问答法、运典法。" />';
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
      <div class="Ico_aBox_icon INico49"></div>
      <div class="Ico_aBox_tit">谜语大全</div>
      <div class="Ico_aBox_intro">最全最经典的谜语</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;" id="top"><tr><td align="center" valign="middle" height="60"><form action="./" method="get" name="f1"><b>谜语搜索:</b><input name="q" id="q" type="text" size="18" delay="0" value="" style="width:200px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" /> <input type="submit" class="mob_copy1" value=" 搜索 " /></form></td></tr><tr><td align="center" height="30" style="font-size:14px;">输入最短的关键字，如查<a href="./?q=雷">打雷</a>相关的谜语,输入<a href="./?q=雷">雷</a>后按Enter即可</td></tr></table><div style='height:10px;'></div>
<?php
if($miyu!=""){
	echo $pf_l;
}elseif($id>0 && $id<=$count){
	echo $pf.$pf_l;
}else{
?>
<table width="700" cellpadding="2" class="mob_ace" cellspacing="0" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b>谜语大全</b></td></tr><tr><td><p style="line-height:150%;font-size:12px;">　　本站收录了总计172类，近8万条最新最全的谜语。<br>
　　谜语的猜法多种多样，比较常见的有二十多种。属于会意体的有会意法、反射法、借扣法、侧扣法、分扣发、溯源法；属于增损体的有加法、减法、加减法；属于离合体的有离底法、离面法；属于象形体的有象形法、象画法；属于谐音体的有直谐法、间谐法；属于综合体的有比较法、拟人法、拟物法、问答法、运典法。<a onClick="Javascript:if (shuoming.style.display=='none'){shuoming.style.display='';}else {shuoming.style.display='none';}"><b><font color="#FF8000"><u>查看猜谜方法的具体说明</u></font></b></a><div id="shuoming" style="DISPLAY:none"><hr>　　【会意法】总体理解谜面的意义，扣合谜底。例如：脸上长钩子，头角挂扇子。四根粗柱子，一条小辫子。（打一动物：象）<br>　　【反射法】即反其谜面意思而猜之。例如：莫用小人（打一中草药：使君子）<br>　　【借扣法】不用谜面原意或多意、反意，借用谜面别解成新意，用来扣合谜底。例如：开明（打一唐代文学家：元结）“开明”别解为“明朝的开始”，即元朝的结束，因此谜底为“元结”。<br>　　【侧扣法】不正面理解谜面原意，借用多义从侧面烘托扣合谜底。例如：江枫渔火（打一《儒林外史》人物：双红）这里“双红”是从“枫”、“火”得名，“枫”和“火”都是红的，因此“双红”扣合谜面。<br>　　【分扣法】谜面的字分别扣合谜底的字，有的一字扣一字，有的一字扣多字，也有的多字扣一字。例如：望穿（打一昆曲剧目：十五贯）“望”俗称“十五”，“穿”与“贯”有同义之处，分别扣为“十五贯”<br>　　【溯源法】“溯源”及追溯谜面的来源以及与其原出处的上下关联，然后再扣合谜底，也有叫它承上启下法的。例如：桃花谭水深千尺（打一成语：无与伦比）这则谜以“桃花谭水深千尺”的下句“不及汪伦送我情”，扣合谜底。<br>　　【加法】将谜面提示的部分字的笔划予以增加或将某些字相加，来扣合谜底。例如：好山好水（打二字：崔，淮）这里“好”扣“佳”，“好山”及“佳山”，自身相加得“崔”；“好水”及“佳水”，自身相加成“淮”。<br>　　【减法】将谜面提示的部分字的笔划减少，或用某些字相减来扣合谜底。例如：池中没有水,地上没有泥（打一字：也）将“池”的三点水去掉的“也”，将“地”的土字旁去掉也得“也”。<br>　　【加减法】按谜面的提示，有的字增加笔划，有的字减少笔划，既有加有减，最后扣合谜地。例如：上头去下头,下头去上头,两头去中间,中间去两头.本谜“去”为谜眼，分为上下两部分即可组合成谜底。<br>　　【离底法】此谜，谜面反映的是谜底的拆离。猜时，将谜面合成，然后再扣合谜底。例如：七人（打一县名：开化）<br>　　【离面法】将谜面某些字拆离，去扣合谜底。例如：诧（打一成语：一家之言）<br>　　【象形法】根据事物的特征，汉字的结构（相形），进行拟人拟物，加以形象化，使人引起联想，增加趣味。例如：冰上两点嫌它多，石头压水水爬坡.（打一名词：水泵）<br>　　【象画法】此谜是根据谜面整体具有图画意味去合谜底。例如：远树两行山倒影，轻舟一叶水平流。（打一字：慧）<br>　　【直谐法】制作谜底时，利用声音相同或相近的字来代替本来应该用的字，把人的注意力引开，达到隐藏谜底的目的。例如：增加十两（打一城市：天津）“增加十两”及“添斤”，与“天津”谐音。<br>　　【间谐法】先将谜中的某些字拆变，再谐音扣合谜底。例如：二者规格不同（打一字：鞋）猜时，先将“鞋”拆为“圭”、“革”两部分，“圭”与“规”谐音，“革”与“格”谐音，切合谜底。<br>　　【比较法】是将形状、字义相近或相反的词放在一起，加以比较而扣合谜底。例如：加一笔不好，加一倍不少（打一字：夕）<br>　　【拟人法】将谜面的字词人格化，扣合谜底。例如：有位小姑娘,身穿黄衣衫,你若欺负她,她就戳一枪.（打一动物：蜜蜂）<br>　　【拟物法】将人或人体某部分物化，或者将谜面字词语义或所言之事物化，扣合谜底。例如：枕头.（打一成语：置之脑后）<br>　　【问答法】此种谜通常是用提问式的谜面，回答式的谜底。例如：八十万禁军谁掌管？（打一成语：首当其冲）<br>　　【运典法】词类谜语以人们熟悉的成语、口语、诗词、典故作谜面，而将意义别解，从而扣合谜底。例如：宝玉求婚（打一美国历史人物：林肯）<br>　　【排除法】就是排除一面取一面，排除多方取一方，排除容易而取难的。例如：说不叫说，拿不叫拿（打一字：最）这里排除“说”而取“曰”，排除“拿”而换成“取”。</div>	
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


