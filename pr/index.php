<?php
/*
if( $_SERVER['HTTP_HOST'] == 'tool.yowao.com' )
{
	header("Location: http://tool.yowao.com/");
	exit();
}
*/
/*
*����:��URL���б���
*����˵��:$web_url ��վURL��������"http://",����tool.yowao.com
*���ʱ��:2009��4��10��
*/
function HashURL($url)
{$SEED = "Mining PageRank is AGAINST GOOGLE'S TERMS OF SERVICE. Yes, I'm talking to you, scammer.";
    $Result = 0x01020345;
    for ($i=0; $i<strlen($url); $i++) 
    {
        $Result ^= ord($SEED{$i%87}) ^ ord($url{$i});
        $Result = (($Result >> 23) & 0x1FF) | $Result << 9;
    }
    return sprintf("8%x", $Result);
}


/*
*����:��ȡpagerank
*����˵��:$domain ��վ������������"http://",����tool.yowao.com
*���ʱ��:2009��9��19��
*/
function pagerank($domain)
{	
	$StartURL = "http://www.google.com/search?client=navclient-auto&features=Rank:&q=info:";

	$GoogleURL = $StartURL.$domain. '&ch='.HashURL($domain);

	$fcontents = file_get_contents("$GoogleURL");

	$pagerank = substr($fcontents,9);
	if (!$pagerank) return "0";else return $pagerank;
}

$chaxun_bool = 0;

if ( isset($_GET['website']) )
{
	$chaxun_bool = 1;

	$website = $_GET['website'];
	$website = str_replace("http://","",$website);

	@ $pr = pagerank("$website");
	@ date_default_timezone_set(PRC);

	$now_date = date("Y��n��j�� Gʱi��s��");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="Google PRֵ��ѯ����|Ҫ�۲�ѯ����[Yowao.CoM]" />
<title>Google PRֵ��ѯ����|Ҫ�۲�ѯ����[Yowao.CoM]</title>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
<style type="text/css">
body{
	text-align:center;
	margin:0;
	padding:0;
	font-family:"΢���ź�";
}

/*ͷ��logo*/
h1{
	margin-top:0px;
}
h1 a{
	display:block;
	width:238px;
	height:80px;
	margin:0 auto;
	background:url(/img/pr/logo.gif) no-repeat;
	text-indent:-9999px;
	position:relative;
	
}
/*�ύ��*/
#website{
	border:1px solid #CCC;
	border-top-color:#666;
	width:400px;
	height:22px;
	font-weight:bold;

	font-family:Helvetica Neue,Helvetica,Arial,sans-serif;

	font-size:20px;
	line-height:30px;
	color:#333;
}
#chapr{
	font-family:"΢���ź�";
	margin:10px 0;
	font-size:15px;
}


/*other��*/
#other{
	font-size:11px;
	color:#666;
}
#other a{
	color:#245FA5;
}
#other a:hover{
	color:#6DA7E7;
}
#pr_info{
	margin:0 0 0px;
	font-size:20px;
}
#pr_info b{
	color:#2F9BCD;
}
#pr_info span{
	font-size:13px;
}
</style>
</head>
<body onMouseOut="window.status='(tool.yowao.com)Ҫ��ʵ�ò�ѯ!';return true">
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav2"><a href="/" >�����ѯ</a></li>
<li class="nav2"><a href="/yule" >���ֹ���</a></li>
<li class="nav2"><a href="/caijing" >�ƾ�����</a></li>
<li class="nav2"><a href="/jisuan" >����/ѧϰ</a></li>
<li class="nav1"><a href="/wangluo" >��������</a></li>
<li class="nav2"><a href="/zhanzhang" >վ������</a></li>
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
      <div class="Ico_aBox_icon INico76"></div>
	  <div class="Ico_aBox_tit">Google PR ��ѯ</div>
	  <div class="Ico_aBox_intro">Google PageRank��ѯ</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
	<div class="self_ip" id="myip">
	</div>
      <div class="mobile_k mob_body mar10">
<h1><a title="PR��ѯ - �й���������ѯ���ߴ�ȫ">PR��ѯ<div id="notice"></div></a></h1>
	<?php
		if( $chaxun_bool == 0 )
		{
			echo '';
		}
		else
		{
			echo '<p id="pr_info"><b>'.$website.'</b> ��PRΪ '.$pr.' <img src="/img/pr/'.$pr.'.gif"/><br /><span>��ѯʱ��:'.$now_date.'</span></p><hr>';
		}
	?>
<form method="get" action="index.php" id="cha_form">
<b>����������</b><input type="text" id="website" name="website" value="" /><br/>
          <center><input type="submit" id="chapr" class="mob_anniu" value="��ѯPageRank"/></center>
  	</form>
	  </div>
		<div class="mob_det"><font color=red><b>&nbsp;&nbsp;ע��:</b></font>GOOGLE PR �Ǻ;�ȷ��������ַ��صģ���ͬ����ַ���в�ͬ��PR������www.yowao.com��yowao.com��PR�ǲ���ͬ�ġ������1��10����10��Ϊ���֡�PRֵԽ��˵������ҳԽ�ܻ�ӭ��Խ��Ҫ����һ��PRֵ�ﵽ4��������һ���������վ�ˡ�<br/>
&nbsp;&nbsp;<b>�ر�ע�⣺</b>PRҲ�����֮�֡���PR��PR�ٳ֡��ܶ�վ��Ϊ�˶�ʱ���ڻ�ø�PR�����ǽ��Լ�����վ��301��ת��һ����PR����վ��ע��google�ڸ���PR��ʱ�򣬻ḳ�������վ����ת�����վ��ͬ��PRֵ������������PR�Ǽٵģ�û���κ��ô������վ��ȡ��301��PR�������������ص������PRֵ�����ҽٳֹ�����PR������������Ӵ���PR��ֵ�ġ�����˵����һ��������ӵ�ʱ�򣬲�Ҫ��PR�ٳֵ���վ�������ӡ�

<a onClick="Javascript:if (shuoming.style.display=='none'){shuoming.style.display='';}else {shuoming.style.display='none';}"><b><font color="#FF8000"><u>PR����ʱ���</u></font></b></a>	<div id="shuoming" style="DISPLAY:none"><hr><center><p><b>����ʱ�� ʱ����</b></p> 
<p><font color=red>2009-12-31  62�� </font></p> 
<p><font color=red>2009-10-30  128��</font></p> 
<p>2009-06-24 27��</p> 
<p>2009-05-28 56��</p> 
<p>2009-04-02 92��</p> 
<p>2008-10-31 95��</p> 
<p>2008-09-27 62��</p> 
<p>2008-07-26 87��</p> 
</center></div>
</div></br>
      </div>
  </div>
  <div class="head3"></div>
</li><li class="self_ip"></li></ul></div>
<script language="javascript" type="text/javascript" src="/ip/ip.php"></script>
<script language="javascript" type="text/javascript" src="/js/footer_nei.js"></script>
<div style="display:none"><script type="text/javascript" src="/js/tongji.js"></script></div>
<div style="display:none">

</div>
</body>
</html>


