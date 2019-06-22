<?php
$output = "";
if($_FILES['upimage']!=''){
if(isset($_FILES['upimage']['tmp_name']) && $_FILES['upimage']['tmp_name'] && is_uploaded_file($_FILES['upimage']['tmp_name'])){
if($_FILES['upimage']['type']>512000){
$typeinfo = "你上传的文件体积超过了限制 最大不能超过512K";
}
$fileext = array("image/pjpeg","image/jpeg","image/gif","image/x-png");
if(!in_array($_FILES['upimage']['type'],$fileext)){
$typeinfo =  "你上传的文件格式不正确 仅支持 jpg，gif，png";
}
if($im = @imagecreatefrompng($_FILES['upimage']['tmp_name']) or $im = @imagecreatefromgif($_FILES['upimage']['tmp_name']) or $im = @imagecreatefromjpeg($_FILES['upimage']['tmp_name'])){
$imginfo = @getimagesize($_FILES['upimage']['tmp_name']);
if(!is_array($imginfo)){
$typeinfo = "图形格式错误！无法处理这张图片.";
}
switch($_POST['size']){
case 1;
$resize_im = @imagecreatetruecolor(16,16);
$size = 16;
break;
case 2;
$resize_im = @imagecreatetruecolor(32,32);
$size = 32;
break;
case 3;
$resize_im = @imagecreatetruecolor(48,48);
$size = 48;
break;
default;
$resize_im = @imagecreatetruecolor(32,32);
$size = 32;
break;
}
imagecopyresampled($resize_im,$im,0,0,0,0,$size,$size,$imginfo[0],$imginfo[1]);
class phpthumb_ico {
function phpthumb_ico() {
return true;
}

function GD2ICOstring(&$gd_image_array) {
foreach ($gd_image_array as $key => $gd_image) {
$ImageWidths[$key] = ImageSX($gd_image);
$ImageHeights[$key] = ImageSY($gd_image);
$bpp[$key] = ImageIsTrueColor($gd_image) ? 32 : 24;
$totalcolors[$key] = ImageColorsTotal($gd_image);
$icXOR[$key] = '';
for ($y = $ImageHeights[$key] - 1; $y >= 0; $y--) {
for ($x = 0; $x < $ImageWidths[$key]; $x++) {
$argb = $this->GetPixelColor($gd_image, $x, $y);
$a = round(255 * ((127 - $argb['alpha']) / 127));
$r = $argb['red'];
$g = $argb['green'];
$b = $argb['blue'];
if ($bpp[$key] == 32) {
$icXOR[$key] .= chr($b).chr($g).chr($r).chr($a);
} elseif ($bpp[$key] == 24) {
$icXOR[$key] .= chr($b).chr($g).chr($r);
}
if ($a < 128) {
@$icANDmask[$key][$y] .= '1';
} else {
@$icANDmask[$key][$y] .= '0';
}
}
// mask bits are 32-bit aligned per scanline
while (strlen($icANDmask[$key][$y]) % 32) {
$icANDmask[$key][$y] .= '0';
}
}
$icAND[$key] = '';
foreach ($icANDmask[$key] as $y => $scanlinemaskbits) {
for ($i = 0; $i < strlen($scanlinemaskbits); $i += 8) {
$icAND[$key] .= chr(bindec(str_pad(substr($scanlinemaskbits, $i, 8), 8, '0', STR_PAD_LEFT)));
}
}
}
foreach ($gd_image_array as $key => $gd_image) {
$biSizeImage = $ImageWidths[$key] * $ImageHeights[$key] * ($bpp[$key] / 8);
// BITMAPINFOHEADER - 40 bytes
$BitmapInfoHeader[$key] = '';
$BitmapInfoHeader[$key] .= "\x28\x00\x00\x00"; // DWORD biSize;
$BitmapInfoHeader[$key] .= $this->LittleEndian2String($ImageWidths[$key], 4); // LONG biWidth;
// The biHeight member specifies the combined
// height of the XOR and AND masks.
$BitmapInfoHeader[$key] .= $this->LittleEndian2String($ImageHeights[$key] * 2, 4); // LONG biHeight;
$BitmapInfoHeader[$key] .= "\x01\x00"; // WORD biPlanes;
$BitmapInfoHeader[$key] .= chr($bpp[$key])."\x00"; // wBitCount;
$BitmapInfoHeader[$key] .= "\x00\x00\x00\x00"; // DWORD biCompression;
$BitmapInfoHeader[$key] .= $this->LittleEndian2String($biSizeImage, 4); // DWORD biSizeImage;
$BitmapInfoHeader[$key] .= "\x00\x00\x00\x00"; // LONG biXPelsPerMeter;
$BitmapInfoHeader[$key] .= "\x00\x00\x00\x00"; // LONG biYPelsPerMeter;
$BitmapInfoHeader[$key] .= "\x00\x00\x00\x00"; // DWORD biClrUsed;
$BitmapInfoHeader[$key] .= "\x00\x00\x00\x00"; // DWORD biClrImportant;
}

$icondata = "\x00\x00"; // idReserved; // Reserved (must be 0)
$icondata .= "\x01\x00"; // idType; // Resource Type (1 for icons)
$icondata .= $this->LittleEndian2String(count($gd_image_array), 2); // idCount; // How many images?
$dwImageOffset = 6 + (count($gd_image_array) * 16);
foreach ($gd_image_array as $key => $gd_image) {
// ICONDIRENTRY idEntries[1]; // An entry for each image (idCount of 'em)
$icondata .= chr($ImageWidths[$key]); // bWidth; // Width, in pixels, of the image
$icondata .= chr($ImageHeights[$key]); // bHeight; // Height, in pixels, of the image
$icondata .= chr($totalcolors[$key]); // bColorCount; // Number of colors in image (0 if >=8bpp)
$icondata .= "\x00"; // bReserved; // Reserved ( must be 0)
$icondata .= "\x01\x00"; // wPlanes; // Color Planes
$icondata .= chr($bpp[$key])."\x00"; // wBitCount; // Bits per pixel
$dwBytesInRes = 40 + strlen($icXOR[$key]) + strlen($icAND[$key]);
$icondata .= $this->LittleEndian2String($dwBytesInRes, 4); // dwBytesInRes; // How many bytes in this resource?
$icondata .= $this->LittleEndian2String($dwImageOffset, 4); // dwImageOffset; // Where in the file is this image?
$dwImageOffset += strlen($BitmapInfoHeader[$key]);
$dwImageOffset += strlen($icXOR[$key]);
$dwImageOffset += strlen($icAND[$key]);
}
foreach ($gd_image_array as $key => $gd_image) {
$icondata .= $BitmapInfoHeader[$key];
$icondata .= $icXOR[$key];
$icondata .= $icAND[$key];
}
return $icondata;
}
function LittleEndian2String($number, $minbytes=1) {
$intstring = '';
while ($number > 0) {
$intstring = $intstring.chr($number & 255);
$number >>= 8;
}
return str_pad($intstring, $minbytes, "\x00", STR_PAD_RIGHT);
}
function GetPixelColor(&$img, $x, $y) {
if (!is_resource($img)) {
return false;
}
return @ImageColorsForIndex($img, @ImageColorAt($img, $x, $y));
}
}

$icon = new phpthumb_ico();
$gd_image_array = array($resize_im);
$icon_data = $icon->GD2ICOstring($gd_image_array);
header("Accept-Ranges: bytes");
header("Accept-Length: ".strlen($icon_data));
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=" .'favicon.ico');
echo $icon_data;
exit;
}else{
$typeinfo = "生成图标错误...这张图片或许已损坏.";
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="要哇查询,生活查询,娱乐工具,财务商务,计算|学习查询,电脑网络,站长工具,交通查询" />
<title>ICO图标在线生成 - 电脑网络 - - IP地址查询|手机号码归属地查询|身份证|电话号码查询|黄历|万年历|区号|各种查询|- 要哇查询工具</title>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
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
<script language="javascript" type="text/javascript" src="/js/wangluo.js"></script>
</ul></div></div>
<div class="head3"></div></div>

<script type="text/javascript">alimama_bm_revision = "909d86278c3145d2cc4df55fb92e1924f4ef0b31";alimama_bm_bid = "17332313";alimama_bm_width = 950;alimama_bm_height = 90;alimama_bm_xmlsrc = "http://img.uu1001.cn/x3/2011-02-05/00-27/2011-02-05_4c7dc8f3935fe17c11df62464abdadf0_0.xml";alimama_bm_link = "http%3A%2F%2F";alimama_bm_ds = "";alimama_bm_as = "default"</script><script type="text/javascript" src="http://img.uu1001.cn/bmv3.js?v=909d86278c3145d2cc4df55fb92e1924f4ef0b31"></script>
<div style='height:5px;'></div>
<div class="w950">
  <div class="head4">
    <div class="Ico_aBox">
      <div class="Ico_aBox_icon INico63"></div>
      <div class="Ico_aBox_tit">ICO图标生成</div>
      <div class="Ico_aBox_intro">在线生成Favicon图标</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
      <div class="mobile_k mob_body mar10">
<?php if($typeinfo){echo $typeinfo;}?>
<form  method="post" enctype='multipart/form-data'>
选择图片：<input type="file" name="upimage" size="30"><br />支持格式：png，jpg，gif<br /><br />
目标尺寸：
<input type="radio" name="size" value="1" id="s1"><label for="s1">16*16</label>
<input type="radio" name="size" value="2" id="s2" checked><label for="s2">32*32</label>
<input type="radio" name="size" value="3" id="s3"><label for="s3">48*48</label><br /><br />
<input type="submit" class="mob_copy2" value="生成图标">
</form>
	  </div>		
		<div class="mob_det">1、网站使用：ICO图标可以作为标志，目前主流的浏览器都支持ICO图标，它显示于浏览器的地址栏、标签及收藏夹上，例如用IE访问本站时在IE地址栏看到的蓝色"Z"图标。一般情况下，作为把网站标志的ICO图标大小为16×16，命名为"favicon.ico"，然后将其上传到空间的根目录，最后在网页代码的&lt;head&gt;与&lt;/head&gt;之间加入下面的代码：
  <form name='form' method='post' action=''>
  <tr>
  <td>
<textarea rows=2 name='WEcode' style="width:700px;font-size:12px;height:15px;border:1px solid #E9E9E0;" title="双击拷贝代码" onDblClick="this.form.WEcode.focus();this.form.WEcode.select();window.clipboardData.setData('Text',this.form.WEcode.value);alert('代码已复制到剪贴板');return true;"><link rel="shortcut icon" href="favicon.ico"></textarea></td>
  </tr>
</form><br>
2、文件夹或者程序使用：以文件夹使用为例，把ICO图标命名为"ds.ico"，然后把下面的代码复制到记事本并保存在该文件夹根目录内，命名为"desktop.ini"：
<form name='form' method='post' action=''>
  <tr>
  <td>
<textarea rows=2 name='WEcode' style="width:700px;font-size:12px;height:70px;border:1px solid #E9E9E0;" title="双击拷贝代码" onDblClick="this.form.WEcode.focus();this.form.WEcode.select();window.clipboardData.setData('Text',this.form.WEcode.value);alert('代码已复制到剪贴板');return true;">[.ShellClassInfo]
InfoTip=文件夹说明
IconFile=ds.ico
IconIndex=0
</textarea></td>
  </tr>
</form><br>
3、分区盘符的修改方法：把ICO图标命名为"partition.ico"，然后把下面的代码复制到记事本并保存在该分区根目录内，命名为"autorun.inf"：
<form name='form' method='post' action=''>
  <tr>
  <td>
<textarea rows=2 name='WEcode' style="width:700px;font-size:12px;height:45px;border:1px solid #E9E9E0;" title="双击拷贝代码" onDblClick="this.form.WEcode.focus();this.form.WEcode.select();window.clipboardData.setData('Text',this.form.WEcode.value);alert('代码已复制到剪贴板');return true;">[autorun]
icon=partition.ico
</textarea></td>
  </tr>
</form>
</div>
      </div>
  </div>
  <div class="head3"></div>
<script language="javascript" type="text/javascript" src="/js/footer_nei.js"></script>
<div style="display:none"><script type="text/javascript" src="/js/tongji.js"></script></div>
</body>
</html>


