<?php
set_time_limit(0);
$miyu = trim($_GET['q']);
$id = $_GET['id'];

$r_num = 0; //�������
$lan = 1;
$pf = "";
$pf_l = "";

if($miyu!=""){
	$dreamdb=file("data/miyu.dat");//��ȡ�����ļ�
	$count=count($dreamdb);//��������

	for($i=0; $i<$count; $i++) {
		$keyword=explode(" ",$miyu);//��ֹؼ���
		$dreamcount=count($keyword);//�ؼ��ָ���
		$detail=explode("\t",$dreamdb[$i]);
		for ($ai=0; $ai<$dreamcount; $ai++) {
			@eval("\$found = eregi(\"$keyword[$ai]\",\"$detail[0]\");");
			if(($found)){
				if(fmod($r_num,2)==0) $fcolor=' bgcolor="#f6f6f6"'; else $fcolor='';
				$pf_l .= '<tr'.$fcolor.'><td><a href="?id='.($i+1).'">'.$detail[0].'</a></td><td width="100"><input type="button" value=" �鿴�յ� " onclick="document.location=\'?id='.($i+1).'\'" /></td></tr>';
				$r_num++;
				break;
			}
		}
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b><a href="./">�����ȫ</a>���ҵ� <a href="./?q='.urlencode($miyu).'"><font color="#c60a00">'.$miyu.'</font></a> ���������'.$r_num.'��</b></td></tr><tr><td><table id="cont" cellpadding="0" cellspacing="0" width="98%" align="center"><tr><td><strong>����</strong></td><td><strong>�յ�</strong></td></tr>'.$pf_l.'</table></td></tr></table>';
}elseif($id>0){
	$dreamdb=file("data/miyu.dat");//��ȡ�����ļ�
	$count=count($dreamdb);//��������

	$detail=explode("\t",$dreamdb[$id-1]);
	$pf = '<table width="700" cellpadding=2 cellspacing=0 class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle"><b><a href="./">�����ȫ</a>��'.$detail[1].'</b></td><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" align="right">';
	if($id>1 && $id<=$count) $pf .= '<a href="?id='.($id-1).'">��һ��</a> ';
	$pf .= '<a href="./">�鿴ȫ��</a>';
	if($id>=1 && $id<$count) $pf .= ' <a href="?id='.($id+1).'">��һ��</a>';
	$pf .= '</td></tr><tr><td colspan="2" align="center"><br><table border="0" width="90%" style="font-size:14px;line-height:150%"><tr><td width="80">�����</td><td>'.$detail[0].'</td></tr><tr><td>���յס�</td><td><input type="button" value=" �鿴�� " onclick="javascript:window.alert(\''.$detail[0].'\n\n���� '.trim($detail[2],"\n\r").'\');" /></td></tr></table><br></td></tr></table><br />';
}
if($miyu=="" || $id){
	$dreamdb=file("data/miyu.dat");//��ȡ�����ļ�
	$count=count($dreamdb);//��������
	$pfl = rand(0,intval($count/60));

	for($i=$pfl*60; $i<$pfl*60+60; $i++) {
		if($i>=$count-1) break;
		$detail2=explode("\t",$dreamdb[$i]);
		if(fmod($r_num,2)==0) $fcolor=' bgcolor="#f6f6f6"'; else $fcolor='';
		$pf_l .= '<tr'.$fcolor.'><td><a href="?id='.($i+1).'">'.$detail2[0].'</a></td><td width="100"><input type="button" value=" �鿴�յ� " onclick="document.location=\'?id='.($i+1).'\'" /></td></tr>';
		$r_num++;
	}
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b>�Ƽ�����'.$r_num.'��</b></td></tr><tr><td><br><table id="cont" cellpadding="0" cellspacing="0" width="96%" align="center">'.$pf_l.'</table><br></td></tr></table>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
if($miyu){
	echo "<title>".$miyu." - �����ȫ - ���ֹ��� - - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ��ʵ�ò�ѯ</title>";
	echo '<meta name="keywords" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ,'.$miyu.',����,�����ȫ," />';
}elseif($id>0 && $id<=$count){
	echo "<title>".$detail[0]." - �����ȫ - ���ֹ��� - - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ��ʵ�ò�ѯ</title>";
	echo '<meta name="keywords" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ,'.$detail[0].',����,�����ȫ" />';
	echo '<meta name="description" content="���������'.$detail[0].' -- ���ͣ�'.trim($detail[1],"\n\r").'" />';
}else{
	echo "<title>�����ȫ - ���ֹ��� - - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ��ʵ�ò�ѯ</title>";
	echo '<meta name="keywords" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ,����,�����ȫ" />';
	echo '<meta name="description" content="����Ĳ·����ֶ������Ƚϳ������ж�ʮ���֡����ڻ�������л��ⷨ�����䷨����۷�����۷����ֿ۷�����Դ����������������мӷ����������Ӽ�������������������׷������淨������������������η����󻭷�������г�������ֱг������г���������ۺ�����бȽϷ������˷������﷨���ʴ𷨡��˵䷨��" />';
}
?>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
</head>
<body onMouseOut="window.status='(tool.yowao.com)Ҫ��ʵ�ò�ѯ!';return true">
<style type="text/css">
h3{font-size:18px;padding:10px 0 0 10px;color:#014198;}
p{padding: 10px;font-size:18px}
a.lan,a.lan:visited{color:#999;}
#cont td{height:30px;font-size:14px;padding:0 10px}
#cont a,#cont a:visited{text-decoration:none;}
#cont a:hover{text-decoration:underline;}
</style>
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav2"><a href="/" >�����ѯ</a></li>
<li class="nav1"><a href="/yule" >���ֹ���</a></li>
<li class="nav2"><a href="/caijing" >�ƾ�����</a></li>
<li class="nav2"><a href="/jisuan" >����/ѧϰ</a></li>
<li class="nav2"><a href="/wangluo" >��������</a></li>
<li class="nav2"><a href="/zhanzhang" >վ������</a></li>
<li class="nav2"><a href="/jiaotong" >��ͨ��ѯ</a></li>
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
      <div class="Ico_aBox_tit">�����ȫ</div>
      <div class="Ico_aBox_intro">��ȫ��������</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;" id="top"><tr><td align="center" valign="middle" height="60"><form action="./" method="get" name="f1"><b>��������:</b><input name="q" id="q" type="text" size="18" delay="0" value="" style="width:200px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" /> <input type="submit" class="mob_copy1" value=" ���� " /></form></td></tr><tr><td align="center" height="30" style="font-size:14px;">������̵Ĺؼ��֣����<a href="./?q=��">����</a>��ص�����,����<a href="./?q=��">��</a>��Enter����</td></tr></table><div style='height:10px;'></div>
<?php
if($miyu!=""){
	echo $pf_l;
}elseif($id>0 && $id<=$count){
	echo $pf.$pf_l;
}else{
?>
<table width="700" cellpadding="2" class="mob_ace" cellspacing="0" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="25" valign="middle" colspan="5"><b>�����ȫ</b></td></tr><tr><td><p style="line-height:150%;font-size:12px;">������վ��¼���ܼ�172�࣬��8����������ȫ�����<br>
��������Ĳ·����ֶ������Ƚϳ������ж�ʮ���֡����ڻ�������л��ⷨ�����䷨����۷�����۷����ֿ۷�����Դ����������������мӷ����������Ӽ�������������������׷������淨������������������η����󻭷�������г�������ֱг������г���������ۺ�����бȽϷ������˷������﷨���ʴ𷨡��˵䷨��<a onClick="Javascript:if (shuoming.style.display=='none'){shuoming.style.display='';}else {shuoming.style.display='none';}"><b><font color="#FF8000"><u>�鿴���շ����ľ���˵��</u></font></b></a><div id="shuoming" style="DISPLAY:none"><hr>���������ⷨ�����������������壬�ۺ��յס����磺���ϳ����ӣ�ͷ�ǹ����ӡ��ĸ������ӣ�һ��С���ӡ�����һ�����<br>���������䷨��������������˼����֮�����磺Ī��С�ˣ���һ�в�ҩ��ʹ���ӣ�<br>��������۷�����������ԭ�����⡢���⣬��������������⣬�����ۺ��յס����磺��������һ�ƴ���ѧ�ң�Ԫ�ᣩ�����������Ϊ�������Ŀ�ʼ������Ԫ���Ľ���������յ�Ϊ��Ԫ�ᡱ��<br>��������۷����������������ԭ�⣬���ö���Ӳ�����пۺ��յס����磺������𣨴�һ��������ʷ�����˫�죩���˫�족�Ǵӡ��㡱�����𡱵��������㡱�͡��𡱶��Ǻ�ģ���ˡ�˫�족�ۺ����档<br>�������ֿ۷���������ֱַ�ۺ��յ׵��֣��е�һ�ֿ�һ�֣��е�һ�ֿ۶��֣�Ҳ�еĶ��ֿ�һ�֡����磺��������һ������Ŀ��ʮ��ᣩ�������׳ơ�ʮ�塱���������롰�ᡱ��ͬ��֮�����ֱ��Ϊ��ʮ��ᡱ<br>��������Դ��������Դ����׷���������Դ�Լ�����ԭ���������¹�����Ȼ���ٿۺ��յף�Ҳ�н����������·��ġ����磺�һ�̷ˮ��ǧ�ߣ���һ��������ױȣ��������ԡ��һ�̷ˮ��ǧ�ߡ����¾䡰�������������顱���ۺ��յס�<br>�������ӷ�����������ʾ�Ĳ����ֵıʻ��������ӻ�ĳЩ����ӣ����ۺ��յס����磺��ɽ��ˮ������֣��ޣ���������á��ۡ��ѡ�������ɽ��������ɽ����������ӵá��ޡ�������ˮ��������ˮ����������ӳɡ�������<br>��������������������ʾ�Ĳ����ֵıʻ����٣�����ĳЩ��������ۺ��յס����磺����û��ˮ,����û���ࣨ��һ�֣�Ҳ�������ء�������ˮȥ���ġ�Ҳ���������ء���������ȥ��Ҳ�á�Ҳ����<br>�������Ӽ��������������ʾ���е������ӱʻ����е��ּ��ٱʻ������м��м������ۺ��յء����磺��ͷȥ��ͷ,��ͷȥ��ͷ,��ͷȥ�м�,�м�ȥ��ͷ.���ա�ȥ��Ϊ���ۣ���Ϊ���������ּ�����ϳ��յס�<br>��������׷������գ����淴ӳ�����յ׵Ĳ��롣��ʱ��������ϳɣ�Ȼ���ٿۺ��յס����磺���ˣ���һ������������<br>���������淨��������ĳЩ�ֲ��룬ȥ�ۺ��յס����磺���һ���һ��֮�ԣ�<br>���������η���������������������ֵĽṹ�����Σ���������������������󻯣�ʹ���������룬����Ȥζ�����磺�������������࣬ʯͷѹˮˮ����.����һ���ʣ�ˮ�ã�<br>�������󻭷��������Ǹ��������������ͼ����ζȥ���յס����磺Զ������ɽ��Ӱ������һҶˮƽ��������һ�֣��ۣ�<br>������ֱг���������յ�ʱ������������ͬ��������������汾��Ӧ���õ��֣����˵�ע�����������ﵽ�����յ׵�Ŀ�ġ����磺����ʮ������һ���У���򣩡�����ʮ�������������롰���г����<br>��������г�����Ƚ����е�ĳЩ�ֲ�䣬��г���ۺ��յס����磺���߹��ͬ����һ�֣�Ь����ʱ���Ƚ���Ь����Ϊ���硱����������֣����硱�롰�桱г��������롰��г�����к��յס�<br>�������ȽϷ����ǽ���״������������෴�Ĵʷ���һ�𣬼��ԱȽ϶��ۺ��յס����磺��һ�ʲ��ã���һ�����٣���һ�֣�Ϧ��<br>���������˷�����������ִ��˸񻯣��ۺ��յס����磺��λС����,��������,�����۸���,���ʹ�һǹ.����һ����۷䣩<br>���������﷨�����˻�����ĳ�����ﻯ�����߽������ִ����������֮���ﻯ���ۺ��յס����磺��ͷ.����һ�����֮�Ժ�<br>�������ʴ𷨡�������ͨ����������ʽ�����棬�ش�ʽ���յס����磺��ʮ�����˭�ƹܣ�����һ����׵���壩<br>�������˵䷨������������������Ϥ�ĳ�����ʫ�ʡ���������棬���������⣬�Ӷ��ۺ��յס����磺������飨��һ������ʷ����ֿϣ�<br>�������ų����������ų�һ��ȡһ�棬�ų��෽ȡһ�����ų����׶�ȡ�ѵġ����磺˵����˵���ò����ã���һ�֣�������ų���˵����ȡ��Ի�����ų����á������ɡ�ȡ����</div>	
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


