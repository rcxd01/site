<?php
set_time_limit(0);
$prescription = trim($_GET['q']);
$id = intval($_GET['id']);

$r_num = 0; //�������
$lan = 2;
$pf = "";
$pf_l = "";

if($prescription!=""){
	$dreamdb=file("data/pft.dat");//��ȡƫ���ļ�
	$count=count($dreamdb);//��������

	for($i=0; $i<$count; $i++) {
		$keyword=explode(" ",$prescription);//��ֹؼ���
		$dreamcount=count($keyword);//�ؼ��ָ���
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
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b><a href="./">���ƫ��</a>���ҵ� <a href="./?q='.urlencode($prescription).'"><font color="#c60a00">'.$prescription.'</font></a> �����ƫ��'.$r_num.'��</b></td></tr><tr><td><table cellpadding="5" cellspacing="10" width="100%">'.$pf_l.'</table></td></tr></table>';
}elseif($id>0){
	$dreamdb=file("data/pf.dat");//��ȡƫ���ļ�
	$count=count($dreamdb);//��������

	$detail=explode("\t",$dreamdb[$id-1]);
	$pf = '<table width="700" cellpadding=2 cellspacing=0 class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle"><b><a href="./">���ƫ��</a> / <a href="./?q='.urlencode($detail[1]).'">'.$detail[1].'</a> / <a href="./?q='.urlencode($detail[2]).'">'.trim($detail[2],"\r\n").'</a> / '.$detail[0].'</b></td><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" align="right">';
	if($id>1 && $id<=$count) $pf .= '<a href="?id='.($id-1).'">��һ��</a> ';
	$pf .= '<a href="./">�鿴ȫ��</a>';
	if($id>=1 && $id<$count) $pf .= ' <a href="?id='.($id+1).'">��һ��</a>';
	$pf .= '</td></tr><tr><td align="center" colspan="2"><h3>'.$detail[0].'</h3></td></tr><tr><td style="padding:5px;line-height:21px;" colspan="2"><p>'.$detail[3].'</p><center><b><font color=#F77824>Ҫ��</font></b><font color=#5AA2EE>��������</font><font color=#FF0000>�����ƫ����Դ�����磬ʹ��ǰ����ҽ����</font></center></td></tr></table>';
}else{
	$dreamdb=file("data/pft.dat");//��ȡƫ���ļ�
	$count=count($dreamdb);//��������

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
	$pf_l = '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>�Ƽ����ƫ��'.$r_num.'��</b></td></tr><tr><td><table cellpadding="5" cellspacing="10" width="100%">'.$pf_l.'</table></td></tr></table>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
if($prescription){
	echo "<title>".$prescription." - ���ƫ����ȫ - �����ѯ - - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ�۲�ѯ����</title>";
	echo '<meta name="keywords" content="'.$prescription.',���ƫ��,��ҽƫ��,��ҩƫ��,ƫ����ȫ" />';
}elseif($id>0 && $id<=$count){
	echo "<title>".$detail[0]." - ".$detail[2]." - ".$detail[1]." - ���ƫ����ȫ - ���ֹ��� - - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ��ʵ�ò�ѯ</title>";
	echo '<meta name="keywords" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ,'.$detail[0].",".$detail[2].",".$detail[1].',ƫ��,���ƫ����ȫ" />';
}else{
	echo "<title>���ƫ����ȫ - �����ѯ - - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ�۲�ѯ����</title>";
	echo '<meta name="keywords" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ,���ƫ��,��ҽƫ��,��ҩƫ��,ƫ����ȫ" />';
	echo '<meta name="description" content="���ƫ����ȫtool.yowao.com���ռ�������ҽƫ������ҩƫ����Сƫ�����м���ƫ��������ƫ��������ƫ��������ƫ����ţƤѢƫ����ֹ��ƫ��������ƫ������ðƫ��������ƫ�����̴�ƫ��������ƫ��������ƫ��������ƫ������Ѫѹƫ����θ��ƫ��������ƫ���ȡ�" />';
}
?>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
</head>
<body onMouseOut="window.status='(tool.yowao.com)Ҫ��ʵ�ò�ѯ!';return true">
<style type="text/css">
h3{font-size:24px;padding:15px 10px 5px 10px;color:#014198;}
p{padding: 10px;}
a.lan,a.lan:visited{color:#999;}
</style>
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav1"><a href="/" >�����ѯ</a></li>
<li class="nav2"><a href="/yule" >���ֹ���</a></li>
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
<script language="javascript" type="text/javascript" src="/js/shenghuo.js"></script>
</ul></div></div>
<div class="head3"></div></div>

<script type="text/javascript">alimama_bm_revision = "909d86278c3145d2cc4df55fb92e1924f4ef0b31";alimama_bm_bid = "17332313";alimama_bm_width = 950;alimama_bm_height = 90;alimama_bm_xmlsrc = "http://img.uu1001.cn/x3/2011-02-05/00-27/2011-02-05_4c7dc8f3935fe17c11df62464abdadf0_0.xml";alimama_bm_link = "http%3A%2F%2F";alimama_bm_ds = "";alimama_bm_as = "default"</script><script type="text/javascript" src="http://img.uu1001.cn/bmv3.js?v=909d86278c3145d2cc4df55fb92e1924f4ef0b31"></script>
<div style='height:5px;'></div>
<div class="w950">
  <div class="head4">
    <div class="Ico_aBox">
      <div class="Ico_aBox_icon INico23"></div>
      <div class="Ico_aBox_tit">ƫ��</div>
      <div class="Ico_aBox_intro">���ƫ����ȫ</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
<table width="700" cellpadding="2" cellspacing="0" style="border:1px solid #A4C4DC;" id="top"><tr><td align="center" valign="middle" height="60"><form action="./" method="get" name="f1"><b>����ƫ����</b><input name="q" id="q" type="text" size="18" delay="0" value="" style="width:200px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" /> <input type="submit" class="mob_copy1" value=" ���� " /></form></td></tr><tr><td align="center" height="30" style="font-size:14px;">ƫ�����ࣺ<a href="./?q=%C4%DA%BF%C6">�ڿ�</a> <a href="./?q=%CD%E2%BF%C6">���</a> <a href="./?q=%D6%D7%C1%F6">����</a> <a href="./?q=%C6%A4%B7%F4">Ƥ��</a> <a href="./?q=%CE%E5%B9%D9">���</a> <a href="./?q=%B8%BE%BF%C6">����</a> <a href="./?q=%C4%D0%BF%C6">�п�</a> <a href="./?q=%B6%F9%BF%C6">����</a> <a href="./?q=%B1%A3%BD%A1">����</a> <a href="./?q=%D2%A9%BE%C6">ҩ��</a> <a href="./?q=%C6%E4%CB%FB">����</a></td></tr></table><div style='height:10px;'></div>
<?php
if($prescription!=""){
	//echo $pf_l.$pf;
	echo $pf_l;
}elseif($id>0 && $id<=$count){
	echo $pf;
}else{
	echo '<table width="700" cellpadding="2" cellspacing="0" class="mob_ace" style="border:1px solid #A4C4DC;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>���ƫ����ȫ</b></td></tr><tr><td><p style="line-height:150%">������νƫ������ָҩζ���࣬��ĳЩ��֢���ж�����Ч�ķ�������ǧ���������ҹ���������ŷǳ��ḻ���򵥶�����Ч���������������֢��ƫ�����ط����鷽���������������̺�����վ�ؽ�����������ƫ�������ռ������㼯����һ�����ƫ����ȫ��������¼�˸���ƫ�����鷽���ط�7000������<br />�����ˡ����ƫ����ȫ��֮ʳ�ơ�������ѡ�����÷��ľ������������ƫ��Ϊ�����������ҡ��������ã�������Ч���棬���޸����á����㼯�˹Ž��������������ط������ʺϼ�ͥʹ�á������������Ѳ�����δ��ʱ��������һ����Щ���ƫ���������������벻������Ч����Щ���ƫ�������ʺϼ�ͥ�����������ƣ���ҽԺ��һЩ��ҽ�Լ���ҽרҵҽ��������Ҳ�Ǻ��вο���ֵ�ġ�<br />����ע�⣺ƫ����Ч����ʱ�����͸��˵�����״����ͬ���죬����ñ�վ��ƫ������ʱ��Ҫ���ݵ�����Լ������������ѡ���ѡ�ú��ʵķ�������ʱ�ؽ����Ʋ���</p></td></tr></table>
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


