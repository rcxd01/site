<?php
/*
if( $_SERVER['HTTP_HOST'] == 'tool.yowao.com' )
{
	header("Location: http://tool.yowao.com/");
	exit();
}
*/
/*
*功能:对URL进行编码
*参数说明:$web_url 网站URL，不包含"http://",例如tool.yowao.com
*完成时间:2009年4月10日
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
*功能:获取pagerank
*参数说明:$domain 网站域名，不包含"http://",例如tool.yowao.com
*完成时间:2009年9月19日
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

	$now_date = date("Y年n月j日 G时i分s秒");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="Google PR值查询工具|要哇查询工具[Yowao.CoM]" />
<title>Google PR值查询工具|要哇查询工具[Yowao.CoM]</title>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
<style type="text/css">
body{
	text-align:center;
	margin:0;
	padding:0;
	font-family:"微软雅黑";
}

/*头部logo*/
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
/*提交表单*/
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
	font-family:"微软雅黑";
	margin:10px 0;
	font-size:15px;
}


/*other内*/
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
<body onMouseOut="window.status='(tool.yowao.com)要哇实用查询!';return true">
<script language="javascript" type="text/javascript" src="/js/header.js"></script>
<div class="flo_l nav"><ul><li class="nav2"><a href="/" >生活查询</a></li>
<li class="nav2"><a href="/yule" >娱乐工具</a></li>
<li class="nav2"><a href="/caijing" >财经商务</a></li>
<li class="nav2"><a href="/jisuan" >计算/学习</a></li>
<li class="nav1"><a href="/wangluo" >电脑网络</a></li>
<li class="nav2"><a href="/zhanzhang" >站长工具</a></li>
<li class="nav2"><a href="/jiaotong" >交通查询</a></li>
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
	  <div class="Ico_aBox_tit">Google PR 查询</div>
	  <div class="Ico_aBox_intro">Google PageRank查询</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
	<div class="self_ip" id="myip">
	</div>
      <div class="mobile_k mob_body mar10">
<h1><a title="PR查询 - 中国店铺网查询工具大全">PR查询<div id="notice"></div></a></h1>
	<?php
		if( $chaxun_bool == 0 )
		{
			echo '';
		}
		else
		{
			echo '<p id="pr_info"><b>'.$website.'</b> 的PR为 '.$pr.' <img src="/img/pr/'.$pr.'.gif"/><br /><span>查询时间:'.$now_date.'</span></p><hr>';
		}
	?>
<form method="get" action="index.php" id="cha_form">
<b>输入域名：</b><input type="text" id="website" name="website" value="" /><br/>
          <center><input type="submit" id="chapr" class="mob_anniu" value="查询PageRank"/></center>
  	</form>
	  </div>
		<div class="mob_det"><font color=red><b>&nbsp;&nbsp;注意:</b></font>GOOGLE PR 是和精确完整的网址相关的，不同的网址具有不同的PR，比如www.yowao.com和yowao.com的PR是不相同的。级别从1到10级，10级为满分。PR值越高说明该网页越受欢迎（越重要）；一般PR值达到4，就算是一个不错的网站了。<br/>
&nbsp;&nbsp;<b>特别注意：</b>PR也有真假之分。假PR即PR劫持。很多站长为了短时期内获得高PR，他们将自己的网站做301跳转到一个高PR的网站。注意google在更新PR的时候，会赋予这个网站与跳转后的网站相同的PR值。但是这样的PR是假的，没有任何用处。如果站长取消301后，PR会重新评估，回到最初的PR值。而且劫持过来的PR不会给友情链接带来PR分值的。所以说，大家换友情链接的时候，不要和PR劫持的网站交换链接。

<a onClick="Javascript:if (shuoming.style.display=='none'){shuoming.style.display='';}else {shuoming.style.display='none';}"><b><font color="#FF8000"><u>PR更新时间表</u></font></b></a>	<div id="shuoming" style="DISPLAY:none"><hr><center><p><b>更新时间 时间间隔</b></p> 
<p><font color=red>2009-12-31  62天 </font></p> 
<p><font color=red>2009-10-30  128天</font></p> 
<p>2009-06-24 27天</p> 
<p>2009-05-28 56天</p> 
<p>2009-04-02 92天</p> 
<p>2008-10-31 95天</p> 
<p>2008-09-27 62天</p> 
<p>2008-07-26 87天</p> 
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


