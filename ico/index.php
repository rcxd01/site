<?php
$output = "";
if($_FILES['upimage']!=''){
if(isset($_FILES['upimage']['tmp_name']) && $_FILES['upimage']['tmp_name'] && is_uploaded_file($_FILES['upimage']['tmp_name'])){
if($_FILES['upimage']['type']>512000){
$typeinfo = "���ϴ����ļ�������������� ����ܳ���512K";
}
$fileext = array("image/pjpeg","image/jpeg","image/gif","image/x-png");
if(!in_array($_FILES['upimage']['type'],$fileext)){
$typeinfo =  "���ϴ����ļ���ʽ����ȷ ��֧�� jpg��gif��png";
}
if($im = @imagecreatefrompng($_FILES['upimage']['tmp_name']) or $im = @imagecreatefromgif($_FILES['upimage']['tmp_name']) or $im = @imagecreatefromjpeg($_FILES['upimage']['tmp_name'])){
$imginfo = @getimagesize($_FILES['upimage']['tmp_name']);
if(!is_array($imginfo)){
$typeinfo = "ͼ�θ�ʽ�����޷���������ͼƬ.";
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
$typeinfo = "����ͼ�����...����ͼƬ��������.";
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="Ҫ�۲�ѯ,�����ѯ,���ֹ���,��������,����|ѧϰ��ѯ,��������,վ������,��ͨ��ѯ" />
<title>ICOͼ���������� - �������� - - IP��ַ��ѯ|�ֻ���������ز�ѯ|���֤|�绰�����ѯ|����|������|����|���ֲ�ѯ|- Ҫ�۲�ѯ����</title>
<link href="/css/yowao.css" rel="stylesheet" type="text/css" />
<link href="/favicon.ico" rel="shortcut icon" />
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
<script language="javascript" type="text/javascript" src="/js/wangluo.js"></script>
</ul></div></div>
<div class="head3"></div></div>

<script type="text/javascript">alimama_bm_revision = "909d86278c3145d2cc4df55fb92e1924f4ef0b31";alimama_bm_bid = "17332313";alimama_bm_width = 950;alimama_bm_height = 90;alimama_bm_xmlsrc = "http://img.uu1001.cn/x3/2011-02-05/00-27/2011-02-05_4c7dc8f3935fe17c11df62464abdadf0_0.xml";alimama_bm_link = "http%3A%2F%2F";alimama_bm_ds = "";alimama_bm_as = "default"</script><script type="text/javascript" src="http://img.uu1001.cn/bmv3.js?v=909d86278c3145d2cc4df55fb92e1924f4ef0b31"></script>
<div style='height:5px;'></div>
<div class="w950">
  <div class="head4">
    <div class="Ico_aBox">
      <div class="Ico_aBox_icon INico63"></div>
      <div class="Ico_aBox_tit">ICOͼ������</div>
      <div class="Ico_aBox_intro">��������Faviconͼ��</div>
    </div>
  </div>
  <div class="knr">
    <div class="mobile_main">
      <div class="mobile_k mob_body mar10">
<?php if($typeinfo){echo $typeinfo;}?>
<form  method="post" enctype='multipart/form-data'>
ѡ��ͼƬ��<input type="file" name="upimage" size="30"><br />֧�ָ�ʽ��png��jpg��gif<br /><br />
Ŀ��ߴ磺
<input type="radio" name="size" value="1" id="s1"><label for="s1">16*16</label>
<input type="radio" name="size" value="2" id="s2" checked><label for="s2">32*32</label>
<input type="radio" name="size" value="3" id="s3"><label for="s3">48*48</label><br /><br />
<input type="submit" class="mob_copy2" value="����ͼ��">
</form>
	  </div>		
		<div class="mob_det">1����վʹ�ã�ICOͼ�������Ϊ��־��Ŀǰ�������������֧��ICOͼ�꣬����ʾ��������ĵ�ַ������ǩ���ղؼ��ϣ�������IE���ʱ�վʱ��IE��ַ����������ɫ"Z"ͼ�ꡣһ������£���Ϊ����վ��־��ICOͼ���СΪ16��16������Ϊ"favicon.ico"��Ȼ�����ϴ����ռ�ĸ�Ŀ¼���������ҳ�����&lt;head&gt;��&lt;/head&gt;֮���������Ĵ��룺
  <form name='form' method='post' action=''>
  <tr>
  <td>
<textarea rows=2 name='WEcode' style="width:700px;font-size:12px;height:15px;border:1px solid #E9E9E0;" title="˫����������" onDblClick="this.form.WEcode.focus();this.form.WEcode.select();window.clipboardData.setData('Text',this.form.WEcode.value);alert('�����Ѹ��Ƶ�������');return true;"><link rel="shortcut icon" href="favicon.ico"></textarea></td>
  </tr>
</form><br>
2���ļ��л��߳���ʹ�ã����ļ���ʹ��Ϊ������ICOͼ������Ϊ"ds.ico"��Ȼ�������Ĵ��븴�Ƶ����±��������ڸ��ļ��и�Ŀ¼�ڣ�����Ϊ"desktop.ini"��
<form name='form' method='post' action=''>
  <tr>
  <td>
<textarea rows=2 name='WEcode' style="width:700px;font-size:12px;height:70px;border:1px solid #E9E9E0;" title="˫����������" onDblClick="this.form.WEcode.focus();this.form.WEcode.select();window.clipboardData.setData('Text',this.form.WEcode.value);alert('�����Ѹ��Ƶ�������');return true;">[.ShellClassInfo]
InfoTip=�ļ���˵��
IconFile=ds.ico
IconIndex=0
</textarea></td>
  </tr>
</form><br>
3�������̷����޸ķ�������ICOͼ������Ϊ"partition.ico"��Ȼ�������Ĵ��븴�Ƶ����±��������ڸ÷�����Ŀ¼�ڣ�����Ϊ"autorun.inf"��
<form name='form' method='post' action=''>
  <tr>
  <td>
<textarea rows=2 name='WEcode' style="width:700px;font-size:12px;height:45px;border:1px solid #E9E9E0;" title="˫����������" onDblClick="this.form.WEcode.focus();this.form.WEcode.select();window.clipboardData.setData('Text',this.form.WEcode.value);alert('�����Ѹ��Ƶ�������');return true;">[autorun]
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


