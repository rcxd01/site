<?php 
error_reporting(7);
set_time_limit(300);

// Server List File
$config['server_list'] = "whois.lst";

$domain = trim($_POST['domain']);
$domain = strtolower($domain);

if(substr($domain,0,7) == "http://") {
	$domain = str_replace("http://","",$domain);
}
if(substr($domain,0,4) == "www.") {
	$domain = str_replace("www.","",$domain);
}

function whois_request($server, $query)
{
    $data = "";
	if(!$fp = @fsockopen($server, 43)) {
		Return false;
	} else {
		fputs($fp, $query . "\r\n");
        while (!feof($fp)) {
            $data .= fread($fp, 1000);
        } 
        fclose($fp);
	}
    return nl2br($data);
}

function get_server() {
	global $config,$domain;
	$serverarray = file($config['server_list']);
	$i = 0;
	foreach($serverarray as $key=>$val) {
		if(substr($val,0,1) != "#") {
			$server_p = explode("|",$val);
			$server[$i]['tld'] = $server_p[0];
			$server[$i]['server'] = $server_p[1];
			$server[$i]['avail'] = $server_p[2];
			$server[$i]['infoserver'] = $server_p[3];
			$server[$i]['backserver'] = $server_p[4];
			$server[$i]['info'] = $server_p[5];
		}
		$i++;
	}

	$domain_c = explode(".",$domain);
	$partnum = count($domain_c);
	$last_part_1 = $domain_c[$partnum-1];
	$last_part_2 = $domain_c[$partnum-2];
	
	foreach($server as $key=>$val) {
		if($val['tld'] == $last_part_2.".".$last_part_1) {
			Return $val;
		} elseif($val['tld'] == $last_part_1) {
			Return $val;
		}
	}
	Return false;
}

function startwhois() {
	global $domain;
	if(!$server = get_server()) {
		die("�޷���ѯ�����͵�����");
	}
	$result1 = whois_request($server['server'], $domain);
	$result2 = whois_request($server['infoserver'], $domain);
	if(!$result1 && !$result2) {
		echo "�޷����ӷ�����";
		die();
	} else {
		$result = $result1."<br />".$result2;
		echo $result;
	}
}

if(isset($_GET['action']) && trim($_GET['action']) == "do") {
	startwhois();
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ" />
<title>WHOIS��ѯ - վ������ - - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ�۲�ѯ����</title>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<script src="/js/whois.js" type="text/javascript"></script>
<link href="/favicon.ico" rel="shortcut icon" />
<SCRIPT type="text/javascript">
<!--
	var xmlHttp;
	function creatXMLHttpRequest() {
		if(window.ActiveXObject) {
			xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
		} else if(window.XMLHttpRequest) {
			xmlHttp = new XMLHttpRequest();
		}
	}

	function startRequest() {
		var queryString;
		var domain = document.getElementById('domain').value;
		queryString = "domain=" + domain;
		creatXMLHttpRequest();
		xmlHttp.open("POST","?action=do","true");
		xmlHttp.onreadystatechange = handleStateChange;
		xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
		xmlHttp.send(queryString);
	}

	function handleStateChange() {
		if(xmlHttp.readyState == 1) {
			document.getElementById('result').style.cssText = "";
			document.getElementById('result').innerText = "Loading...";
		}
		if(xmlHttp.readyState == 4) {
			if(xmlHttp.status == 200) {
				document.getElementById('result').style.cssText = "";
				var allcon =  xmlHttp.responseText;
				document.getElementById('result').innerHTML = allcon;
			}
		}
	}
 
//-->
</SCRIPT>
</head>
<body onMouseOut="window.status='(tool.yowao.com)Ҫ��ʵ�ò�ѯ!';return true">
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav2"><a href="/" >�����ѯ</a></li>
<li class="nav2"><a href="/yule" >���ֹ���</a></li>
<li class="nav2"><a href="/caijing" >�ƾ�����</a></li>
<li class="nav2"><a href="/jisuan" >����/ѧϰ</a></li>
<li class="nav2"><a href="/wangluo" >��������</a></li>
<li class="nav1"><a href="/zhanzhang" >վ������</a></li>
<li class="nav2"><a href="/jiaotong" >��ͨ��ѯ</a></li>
</ul></div>
</div></div></div>
<div class="w950">
<div class="knr"><div class="xdh">
<ul id="ful">
<SCRIPT language=javascript src="/js/zhanzhang.js" type=text/javascript></SCRIPT>
</ul></div></div>
<div class="head3"></div></div>


<script type="text/javascript">alimama_bm_revision = "909d86278c3145d2cc4df55fb92e1924f4ef0b31";alimama_bm_bid = "17332313";alimama_bm_width = 950;alimama_bm_height = 90;alimama_bm_xmlsrc = "http://img.uu1001.cn/x3/2011-02-05/00-27/2011-02-05_4c7dc8f3935fe17c11df62464abdadf0_0.xml";alimama_bm_link = "http%3A%2F%2F";alimama_bm_ds = "";alimama_bm_as = "default"</script><script type="text/javascript" src="http://img.uu1001.cn/bmv3.js?v=909d86278c3145d2cc4df55fb92e1924f4ef0b31"></script>
<div style='height:5px;'></div>
<div class="w950"><div class="head4"><div class="Ico_aBox">
						<div class="Ico_aBox_icon INico77"></div>
						<div class="Ico_aBox_tit">WHOIS��ѯ</div>
						<div class="Ico_aBox_intro">�鿴����WHOIS��Ϣ</div>
					</div>
</div>
					<div class="knr">
					  <div class="mobile_main">

<div class="mob_ace">

	<center><div>������������<input name="domain" type="text" size="36" maxlength="100" id="url" onkeydown="if(event.keyCode==13)event.keyCode=9;" />
    <input type="button" name="button"  value="�� ѯ" id="sub" onclick="startRequest();" /></div></center></div>
<div style='height:10px;'></div>
  <div id="result" style="display:none" class="mob_hei"></div>

<div style='height:10px;'></div>
<div class="mob_hei">
WHOIS����һ��������ѯ�Ѿ���ע����������ϸ��Ϣ�����ݿ⣨�����������ˡ�����ע���̡�����ע�����ں͹������ڵȣ���ͨ��WHOIS��ʵ�ֶ�����ע����Ϣ��ѯ��WHOIS Database������վWHOIS��ѯϵͳ֧�ֹ�������WHOIS��ѯ����������WHOIS��ѯ��Ӣ������WHOIS��ѯ����������WHOIS��ѯ��֧�����ٸ�������׺��WHOIS��ѯ��
</div>


</div></div>
				
					<div class="head3"></div></div>
<script language="javascript" type="text/javascript" src="/js/footer_nei.js"></script>
<div style="display:none"><script type="text/javascript" src="/js/tongji.js"></script></div>
</body>
</html>


