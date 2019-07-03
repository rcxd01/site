<?php
header("Content-Type:text/html;charset=gb2312");
header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>114啦网址导航 - 天气预报</title>
<style type="text/css">
body {font-size:12px; background:none; color:#666; font-family: Tahoma, Arial,  Helvetica, "\5b8b\4f53", sans-serif; }
img { border:0;}
ul,li,body { padding:0; margin:0;}
a { color:#666; text-decoration: none; cursor:pointer; }
a:hover { text-decoration:underline; color:#f00; }
.button { background:url(images/icons.gif) no-repeat 0 -25px; display:inline-block; height:21px; width:63px; line-height:21px; text-align:center; color:#333; font-size:12px;}
a.button:hover { background-position:0 0; color:#07519A; text-decoration:none; }
#setCityBox { zoom:1;}
#setCityBox:after {content:"\0020";display:block;clear:both;height:0;}
#setCityBox select,#setCityBox a { font-family: Tahoma, Arial,  Helvetica, "\5b8b\4f53", sans-serif; font-size:12px; margin:1px 2px 0 0; float:left;}
#setCityBox li { display:inline;list-style:none;}
#weather { height:22px; line-height:22px; *line-height:26px; overflow:hidden;}
#weather a:hover { border-bottom:1px dashed #f00; text-decoration:none;}
* html .i { position:relative; top:2px;}
</style>
<!--[if IE 7]>
<style type="text/css">
#l_city { width:80px;}
.i { vertical-align:middle;}
</style>
<![endif]-->
</head>
<body>
<div id="weather"></div>
<ul id="setCityBox" style="display:none;">
<li>
  <select id="w_pro" onchange="Weather.cp(this.value)">
    <option value="109">B 北京</option>
    <option value="117">S 上海</option>
    <option value="110">T 天津</option>
    <option value="135">C 重庆</option>
    <option value="119">A 安徽</option>
    <option value="123">F 福建</option>
    <option value="127">G 广东</option>
    <option value="128">G 广西</option>
    <option value="137">G 贵州</option>
    <option value="131">G 甘肃</option>
    <option value="111">H 河北</option>
    <option value="124">H 河南</option>
    <option value="125">H 湖北</option>
    <option value="126">H 湖南</option>
    <option value="129">H 海南</option>
    <option value="116">H 黑龙江</option>
    <option value="122">J 江西</option>
    <option value="120">J 江苏</option>
    <option value="115">J 吉林</option>
    <option value="114">L 辽宁</option>
    <option value="132">N 宁夏</option>
    <option value="113">N 内蒙古</option>
    <option value="133">Q 青海</option>
    <option value="118">S 山东</option>
    <option value="112">S 山西</option>
    <option value="130">S 陕西</option>
    <option value="136">S 四川</option>
    <option value="139">X 西藏</option>
    <option value="134">X 新疆</option>
    <option value="138">Y 云南</option>
    <option value="121">Z 浙江</option>
    <option value="140">X 香港</option>
    <option value="141">A 澳门</option>
    <option value="142">T 台湾</option>
  </select>
  <select id="w_city" onchange="Weather.cc(this.value);"></select>
  <select id="l_city"></select>
  </li>
  <li>
  <a class="button" onclick="Weather.custom()">确 定</a> <a class="button" onclick="Weather.autoLoad(this)">自动判断</a>
  </li>
</ul>
<script type="text/javascript" src="js/citys.js"></script>
<script type="text/javascript" src="js/weather.js?v=20100715"></script>
</body>
</html>
