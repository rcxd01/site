<?php
set_time_limit(0);
$q = trim($_GET['q']); //关键词
$page = intval($_GET['p']); //页数
if($page==0) $page=1;

$r_num = 0; //结果个数
$p_num = 40; //每页结果的数据条数
$result = "";

$shengpy = array('B','T','H','S','N','L','J','H','S','J','Z','A','F','J','S','H','H','H','G','G','H','C','S','G','Y','X','S','G','Q','N','X','X','A','T');
$sheng = array('北京','天津','河北','山西','内蒙古','辽宁','吉林','黑龙江','上海','江苏','浙江','安徽','福建','江西','山东','湖南','湖北','河南','广东','广西','海南','重庆','四川','贵州','云南','西藏','陕西','甘肃','青海','宁夏','新疆','香港','澳门','台湾');

if($q){
	switch ($_GET['w']){
		case "sheng":
		case "diqu":
		case "shi":
		case "cun":
		case "youbian":
		case "quhao":
			$keydb = "cache/".$_GET['w']."/".urlencode($q).".htm";
			break;
		default:
			$keydb = "cache/all/".urlencode($q).".htm";
			break;
	}

	if (!@file_exists($keydb)){
		$dreamdb=file("data/post.dat");//读取区号文件
		$count=count($dreamdb);//计算行数

		for($i=0; $i<$count; $i++) {
			$keyword=explode(" ",$q);//拆分关键字
			$dreamcount=count($keyword);//关键字个数
			$detail=explode("\t",$dreamdb[$i]);

			for ($ai=0; $ai<$dreamcount; $ai++){
				switch ($_GET['w']){
					case "sheng":
						@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[0]\");");
						break;
					case "diqu":
						@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[1]\");");
						break;
					case "shi":
						@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[2]\");");
						break;
					case "cun":
						@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[3]\");");
						break;
					case "youbian":
						@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[4]\");");
						break;
					case "quhao":
						@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[5]\");");
						break;
					default:
						@eval("\$found = eregi(\"$keyword[$ai]\",\"$dreamdb[$i]\");");
						break;
				}

				if(($found)){
					$r_num++;
					if(fmod($r_num, $p_num)==0) $r .= "\n";
					$r .= '<tr height="24"><td><a href="?q='.urlencode($detail[0]).'&w=sheng">'.$detail[0].'</a></td><td><a href="?q='.urlencode($detail[1]).'&w=diqu">'.$detail[1].'</a></td><td><a href="?q='.urlencode($detail[2]).'&w=shi">'.$detail[2].'</a></td><td><a href="?q='.urlencode($detail[3]).'&w=cun">'.$detail[3].'</a></td><td><a href="?q='.$detail[4].'&w=youbian">'.$detail[4].'</a></td><td><a href="?q='.trim($detail[5],"\n\r").'&w=quhao">'.trim($detail[5],"\n\r").'</a></td></tr>';
					if($r_num>=$p_num*($page-1)+1 && $r_num<=$p_num*$page){
						$result .= '<tr height="24"><td><a href="?q='.urlencode($detail[0]).'&w=sheng">'.$detail[0].'</a></td><td><a href="?q='.urlencode($detail[1]).'&w=diqu">'.$detail[1].'</a></td><td><a href="?q='.urlencode($detail[2]).'&w=shi">'.$detail[2].'</a></td><td><a href="?q='.urlencode($detail[3]).'&w=cun">'.$detail[3].'</a></td><td><a href="?q='.$detail[4].'&w=youbian">'.$detail[4].'</a></td><td><a href="?q='.trim($detail[5],"\n\r").'&w=quhao">'.trim($detail[5],"\n\r").'</a></td></tr>';
					}
					break;
				}
			}
			$p = ceil($r_num/$p_num); //结果实际页数
		}
		//将数据缓存下来
		//$fp = @fopen($keydb,"a");
		//@fwrite($fp,$r_num."\n".$r);
		//@fclose($fp);
	}else{
		$dreamdb=file($keydb);
		$r_num = trim($dreamdb[0],"\n\r");
		$p = ceil($r_num/$p_num); //结果实际页数
		if($page>$p) $page=$p;
		$result = $dreamdb[$page];
	}

	for($i=1; $i<=$p; $i++){
		$post_l .= '<a href="?q='.urlencode($q).'&p='.$i;
		if($_GET['w']) $post_l .= '&act='.$_GET['w'];
		if($i==$page){
			$post_l .= '"><font color="red">['.$i.']</font></a> ';
		}else{
			$post_l .= '">['.$i.']</a> ';
		}
	}
	$post_l = '<tr><td align="center" style="font-size:14px;padding:10px;" bgcolor="#EDF7FF">分页：'.$post_l.' (共计'.$r_num.'个，每页'.$p_num.'个)</td></tr>';

	$result = '<table width="750" cellpadding="2" cellspacing="0" style="border:1px solid #AACCEE;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle"><b>找到'.$r_num.'个与 <a href="./?q='.urlencode($q).'"><font color="#c60a00">'.$q.'</font></a> 相关的邮编区号</b></td></tr><tr><td><table cellpadding="4" cellspacing="4" width="100%" style="text-align:center"><tr style="text-align:center;font-weight:bold;" height="26" bgcolor="#efefef"><td width="80">省</td><td>地区</td><td>市县</td><td>乡镇村</td><td width="80">邮政编码</td><td width="60">电话区号</td></tr>'.$result.'</table></td></tr>'.$post_l.'</table>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
switch ($_GET['w']){
	case "sheng":
		$qw = "省份: ";
		break;
	case "diqu":
		$qw = "地区: ";
		break;
	case "shi":
		$qw = "市县: ";
		break;
	case "cun":
		$qw = "村镇乡: ";
		break;
	case "youbian":
		$qw = "邮编: ";
		break;
	case "quhao":
		$qw = "区号: ";
		break;
	default:
		break;
}

if($q){
	echo "<title>".$q."邮编查询 - 生活查询 -  - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>";
	echo '<meta name="keywords" content="'.$q.','.$q.'邮编,'.$q.'区号,'.$q.'邮政编码,'.$q.'电话区号,查询" />';
	echo '<meta name="description" content="'.$q.'邮政编码区号查询youbian.wofav.cn，本邮编区号查询系统拥有'.$q.'最全最新的邮编区号数据（6万多条），可以查询'.$q.'精确到'.$q.'的街道村镇的邮编区号，支持模糊查询，输入省名、市名、县名或村名即可查到'.$q.'相关邮编区号，也可以由邮编或区号反查地理位置。" />';
}else{
	echo "<title>全国邮编查询 - 生活查询 -  - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>";
	echo '<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询" />';
	echo '<meta name="description" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询" />';
}
?>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
</head>
<body onMouseOut="window.status='(tool.yowao.com)要哇实用查询!';return true">
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav1"><a href="/" >生活查询</li>
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
<div style='height:5px;'></div><div class="w950">
  <div class="head4">
    <div class="Ico_aBox">
      <div class="Ico_aBox_icon INico4"></div>
	  <div class="Ico_aBox_tit">邮编查询</div>
	  <div class="Ico_aBox_intro">邮政编码/区号查询</div>
    </div>
  </div>
  <div class="knr">
<div align="center"><br>
<style type="text/css">
h3{font-size:24px;padding:15px 10px 5px 10px;color:#014198;}
p{padding: 10px;}
</style>
<table width="750" cellpadding="2" cellspacing="0" style="border:1px solid #AACCEE;" id="top"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>邮编区号查询</b></td></tr><tr><td align="center" valign="middle" style="padding:20px;"><form action="./" method="get" name="f1"><input name="q" id="q" type="text" size="18" delay="0" value="<?php echo $q;?>" style="width:200px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /> <input type="submit" class="mob_copy1" value=" 查找 " /></form></td></tr><tr><td align="center" style="font-size:12px;padding:0 0 10px 0;line-height:150%;">查询省名、市名、县名、村名的时候请去掉<font color="red">省市县村</font>后缀<br>如查询“河南省”，请输入“河南”，支持邮编或区号反查地理位置<br>例：<a href="?q=%BA%D3%C4%CF&w=sheng">河南</a> <a href="?q=%D6%A3%D6%DD&w=diqu">郑州</a> <a href="?q=%D6%A3%D6%DD%CA%D0&w=shi">郑州市</a> <a href="?q=%C2%ED%C9%BD%BF%DA&w=cun">马山口</a> <a href="?q=474363&w=youbian">474363</a> <a href="?q=0377&w=quhao">0377</a></td></tr>
<tr><td style="background:url(/img/kuang6.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>高级查询</b></td></tr><tr><td align="center" valign="middle" style="padding:20px;">
<table style="font-size:14px;" width="96%" align="center">
<tr>
<td width="50%"><form action="./" method="get" name="f1">　　按省名查：<select name="q" id="q" style="width:106px;height:22px;font-size:16px;">
<?php
$count = count($sheng);
for($i=0;$i<$count;$i++){
	echo '<option value="'.$sheng[$i].'"';
	if($_GET['w']=="sheng" && $sheng[$i]==$q) echo ' selected';
	echo '>'.$shengpy[$i].' '.$sheng[$i].'</option>';
}
?>
</select><input name="w" id="w" type="hidden" value="sheng" /> <input type="submit" class="mob_copy1" value=" 查找 " /></form></td><td width="50%"><form action="./" method="get" name="f1">　按地区名查：<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="diqu") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="diqu" /> <input type="submit" class="mob_copy1" value=" 查找 " /></form></td>
</tr>
<tr>
<td><form action="./" method="get" name="f1">　按县市名查：<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="shi") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="shi" /> <input type="submit" class="mob_copy1" value=" 查找 " /></form></td><td><form action="./" method="get" name="f1">按乡镇村名查：<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="cun") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="cun" /> <input type="submit" class="mob_copy1" value=" 查找 " /></form></td>
</tr>
<tr>
<td><form action="./" method="get" name="f1">　　按邮编查：<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="youbian") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="youbian" /> <input type="submit" class="mob_copy1" value=" 查找 " /></form></td><td><form action="./" method="get" name="f1">　　按区号查：<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="quhao") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="quhao" /> <input type="submit" class="mob_copy1" value=" 查找 " /></form></td>
</tr>
</table>
</td></tr></table><br />
<?php
if($q!=""){
	echo $result;
}else{
	echo '<table width="750" cellpadding="2" cellspacing="0" class="mob_det"><tr><td height="26" valign="middle" colspan="5"></td><td><p style="line-height:150%">　　本邮编区号查询系统拥有<strong>全国最全最新的邮编区号数据</strong>（6万多条），可以查询精确到街道村镇的邮编区号，支持模糊查询，输入省名、市名、县名或村名即可查到相关邮编区号，也可以由邮编或区号反查地理位置。<br>　　我国采用四级六位编码制，前两位表示省、市、自治区，第三位代表邮区，第四位代表县、市，最后两位代表投递邮局，最后两位是代表从这个城市哪个投递区投递的，即投递区的位置。<br>　　例如：邮政编码“474363”，“47”代表河南省，“43”代表南阳，“63”代表所在投递区。 </p></td></tr></table><br>';
	echo $result;
?>

</td></tr></table>
<?php
}
?>
  </div>
  </div>
  <div class="head3"></div>
</div>
<script language="javascript" type="text/javascript" src="/js/footer_nei.js"></script>
<div style="display:none"><script type="text/javascript" src="/js/tongji.js"></script></div>
</body>
</html>

