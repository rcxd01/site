<?php
set_time_limit(0);
$q = trim($_GET['q']); //�ؼ���
$page = intval($_GET['p']); //ҳ��
if($page==0) $page=1;

$r_num = 0; //�������
$p_num = 40; //ÿҳ�������������
$result = "";

$shengpy = array('B','T','H','S','N','L','J','H','S','J','Z','A','F','J','S','H','H','H','G','G','H','C','S','G','Y','X','S','G','Q','N','X','X','A','T');
$sheng = array('����','���','�ӱ�','ɽ��','���ɹ�','����','����','������','�Ϻ�','����','�㽭','����','����','����','ɽ��','����','����','����','�㶫','����','����','����','�Ĵ�','����','����','����','����','����','�ຣ','����','�½�','���','����','̨��');

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
		$dreamdb=file("data/post.dat");//��ȡ�����ļ�
		$count=count($dreamdb);//��������

		for($i=0; $i<$count; $i++) {
			$keyword=explode(" ",$q);//��ֹؼ���
			$dreamcount=count($keyword);//�ؼ��ָ���
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
			$p = ceil($r_num/$p_num); //���ʵ��ҳ��
		}
		//�����ݻ�������
		//$fp = @fopen($keydb,"a");
		//@fwrite($fp,$r_num."\n".$r);
		//@fclose($fp);
	}else{
		$dreamdb=file($keydb);
		$r_num = trim($dreamdb[0],"\n\r");
		$p = ceil($r_num/$p_num); //���ʵ��ҳ��
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
	$post_l = '<tr><td align="center" style="font-size:14px;padding:10px;" bgcolor="#EDF7FF">��ҳ��'.$post_l.' (����'.$r_num.'����ÿҳ'.$p_num.'��)</td></tr>';

	$result = '<table width="750" cellpadding="2" cellspacing="0" style="border:1px solid #AACCEE;"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle"><b>�ҵ�'.$r_num.'���� <a href="./?q='.urlencode($q).'"><font color="#c60a00">'.$q.'</font></a> ��ص��ʱ�����</b></td></tr><tr><td><table cellpadding="4" cellspacing="4" width="100%" style="text-align:center"><tr style="text-align:center;font-weight:bold;" height="26" bgcolor="#efefef"><td width="80">ʡ</td><td>����</td><td>����</td><td>�����</td><td width="80">��������</td><td width="60">�绰����</td></tr>'.$result.'</table></td></tr>'.$post_l.'</table>';
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
		$qw = "ʡ��: ";
		break;
	case "diqu":
		$qw = "����: ";
		break;
	case "shi":
		$qw = "����: ";
		break;
	case "cun":
		$qw = "������: ";
		break;
	case "youbian":
		$qw = "�ʱ�: ";
		break;
	case "quhao":
		$qw = "����: ";
		break;
	default:
		break;
}

if($q){
	echo "<title>".$q."�ʱ��ѯ - �����ѯ -  - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ�۲�ѯ����</title>";
	echo '<meta name="keywords" content="'.$q.','.$q.'�ʱ�,'.$q.'����,'.$q.'��������,'.$q.'�绰����,��ѯ" />';
	echo '<meta name="description" content="'.$q.'�����������Ų�ѯyoubian.wofav.cn�����ʱ����Ų�ѯϵͳӵ��'.$q.'��ȫ���µ��ʱ��������ݣ�6������������Բ�ѯ'.$q.'��ȷ��'.$q.'�Ľֵ�������ʱ����ţ�֧��ģ����ѯ������ʡ����������������������ɲ鵽'.$q.'����ʱ����ţ�Ҳ�������ʱ�����ŷ������λ�á�" />';
}else{
	echo "<title>ȫ���ʱ��ѯ - �����ѯ -  - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ�۲�ѯ����</title>";
	echo '<meta name="keywords" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ" />';
	echo '<meta name="description" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ" />';
}
?>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
</head>
<body onMouseOut="window.status='(tool.yowao.com)Ҫ��ʵ�ò�ѯ!';return true">
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav1"><a href="/" >�����ѯ</li>
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
<div style='height:5px;'></div><div class="w950">
  <div class="head4">
    <div class="Ico_aBox">
      <div class="Ico_aBox_icon INico4"></div>
	  <div class="Ico_aBox_tit">�ʱ��ѯ</div>
	  <div class="Ico_aBox_intro">��������/���Ų�ѯ</div>
    </div>
  </div>
  <div class="knr">
<div align="center"><br>
<style type="text/css">
h3{font-size:24px;padding:15px 10px 5px 10px;color:#014198;}
p{padding: 10px;}
</style>
<table width="750" cellpadding="2" cellspacing="0" style="border:1px solid #AACCEE;" id="top"><tr><td style="background:url(/img/kuang5.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>�ʱ����Ų�ѯ</b></td></tr><tr><td align="center" valign="middle" style="padding:20px;"><form action="./" method="get" name="f1"><input name="q" id="q" type="text" size="18" delay="0" value="<?php echo $q;?>" style="width:200px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /> <input type="submit" class="mob_copy1" value=" ���� " /></form></td></tr><tr><td align="center" style="font-size:12px;padding:0 0 10px 0;line-height:150%;">��ѯʡ����������������������ʱ����ȥ��<font color="red">ʡ���ش�</font>��׺<br>���ѯ������ʡ���������롰���ϡ���֧���ʱ�����ŷ������λ��<br>����<a href="?q=%BA%D3%C4%CF&w=sheng">����</a> <a href="?q=%D6%A3%D6%DD&w=diqu">֣��</a> <a href="?q=%D6%A3%D6%DD%CA%D0&w=shi">֣����</a> <a href="?q=%C2%ED%C9%BD%BF%DA&w=cun">��ɽ��</a> <a href="?q=474363&w=youbian">474363</a> <a href="?q=0377&w=quhao">0377</a></td></tr>
<tr><td style="background:url(/img/kuang6.gif);padding:0 5px;color:#014198;" height="26" valign="middle" colspan="5"><b>�߼���ѯ</b></td></tr><tr><td align="center" valign="middle" style="padding:20px;">
<table style="font-size:14px;" width="96%" align="center">
<tr>
<td width="50%"><form action="./" method="get" name="f1">������ʡ���飺<select name="q" id="q" style="width:106px;height:22px;font-size:16px;">
<?php
$count = count($sheng);
for($i=0;$i<$count;$i++){
	echo '<option value="'.$sheng[$i].'"';
	if($_GET['w']=="sheng" && $sheng[$i]==$q) echo ' selected';
	echo '>'.$shengpy[$i].' '.$sheng[$i].'</option>';
}
?>
</select><input name="w" id="w" type="hidden" value="sheng" /> <input type="submit" class="mob_copy1" value=" ���� " /></form></td><td width="50%"><form action="./" method="get" name="f1">�����������飺<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="diqu") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="diqu" /> <input type="submit" class="mob_copy1" value=" ���� " /></form></td>
</tr>
<tr>
<td><form action="./" method="get" name="f1">�����������飺<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="shi") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="shi" /> <input type="submit" class="mob_copy1" value=" ���� " /></form></td><td><form action="./" method="get" name="f1">����������飺<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="cun") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="cun" /> <input type="submit" class="mob_copy1" value=" ���� " /></form></td>
</tr>
<tr>
<td><form action="./" method="get" name="f1">�������ʱ�飺<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="youbian") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="youbian" /> <input type="submit" class="mob_copy1" value=" ���� " /></form></td><td><form action="./" method="get" name="f1">���������Ų飺<input name="q" id="q" type="text" size="18" delay="0" value="<?php if($_GET['w']=="quhao") echo $q; ?>" style="width:100px;height:22px;font-size:16px;font-family: Geneva, Arial, Helvetica, sans-serif;" onMouseOver="this.select()" /><input name="w" id="w" type="hidden" value="quhao" /> <input type="submit" class="mob_copy1" value=" ���� " /></form></td>
</tr>
</table>
</td></tr></table><br />
<?php
if($q!=""){
	echo $result;
}else{
	echo '<table width="750" cellpadding="2" cellspacing="0" class="mob_det"><tr><td height="26" valign="middle" colspan="5"></td><td><p style="line-height:150%">�������ʱ����Ų�ѯϵͳӵ��<strong>ȫ����ȫ���µ��ʱ���������</strong>��6������������Բ�ѯ��ȷ���ֵ�������ʱ����ţ�֧��ģ����ѯ������ʡ����������������������ɲ鵽����ʱ����ţ�Ҳ�������ʱ�����ŷ������λ�á�<br>�����ҹ������ļ���λ�����ƣ�ǰ��λ��ʾʡ���С�������������λ��������������λ�����ء��У������λ����Ͷ���ʾ֣������λ�Ǵ������������ĸ�Ͷ����Ͷ�ݵģ���Ͷ������λ�á�<br>�������磺�������롰474363������47���������ʡ����43��������������63����������Ͷ������ </p></td></tr></table><br>';
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

