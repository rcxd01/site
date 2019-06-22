<?php
$dirurl = "http://tool.yowao.com/mail/";  //��������Ŀ¼��Ŀ¼���ǵü���"/"
$picdir = "logo";  //ͼƬ�洢Ŀ¼���������޸�

function read_from_file($file){
	$fp=fopen($file,"r");
	if(!$fp){
		return(FALSE);
	}
	flock($fp,LOCK_SH);
	$data=fread($fp,filesize($file));
	fclose($fp);
	return($data);
}

function hexrgb($hexstr, $rgb){ //16������ɫתRGB��ɫ
 $int = hexdec(str_replace("#", '', $hexstr));
 switch($rgb) {
		case "r":
		return 0xFF & $int >> 0x10;
			break;
		case "g":
		return 0xFF & ($int >> 0x8);
			break;
		case "b":
		return 0xFF & $int;
			break;
		default:
		return array(
			"r" => 0xFF & $int >> 0x10,
			"g" => 0xFF & ($int >> 0x8),
			"b" => 0xFF & $int
			);
			break;
	}    
}

if($_GET['start']=="5glive"){
	$filename = "logo/sample.png";
	$type = 1;
}elseif($_GET['show']){
	$picname = $_GET['show'];
	$filename = $picdir."/".date("ymd",$picname)."/".$picname.".png";
	$type = 2;
}elseif($_GET['down']){
	$filename = $_GET['down'];
	header("Content-type: command");
	header("Content-Disposition: attachment; filename=jiuyaocha_emaillogo.png");
	readfile($picdir."/".date("ymd",$filename)."/".$filename.".png");
	exit;
}elseif($_GET['mkpic']=="5glive"){
	$username = trim($_GET['s']); //�ʼ���ַ
	if(ereg("^[0-9a-zA-Z\_@.]*$",$username) && $username){
		$host = $_GET['maillogo']; //�ʼ�HOST
		$srcUrl = "s_logo/".$host.".gif"; //EmailͼƬURL

		$back_c = "#ffffff"; //������ɫ
		$border_c = $_GET['bordercolor']; //�߿���ɫ
		$font_c = $_GET['color']; //������ɫ
		$font_size = $_GET['size']; //�����С
		$font_url = "s_font/".$_GET['mailfont'].".ttf"; //����URL

		if($_GET['border']=="true") $is_border = 1; else $is_border = 0; //�Ƿ��б߿� 0û�� ��0��
		if($host) $is_logo = 1; else $is_logo=0; //�Ƿ�������ͼ�� 0û�� ��0��

		$srcWidth = 0;
		$srcHeight = 0;

		$str_pos = imagettfbbox($font_size,0,$font_url,$username);
		$str_width = intval($str_pos[2]); //�����ַ����
		$str_height = intval(str_replace("-","",$str_pos[5])); //�����ַ��߶�

		if($is_logo){
			$origImg = ImageCreateFromGIF($srcUrl);
			$srcWidth = intval(imagesx($origImg)); //Emailͼ����
			$srcHeight = intval(imagesy($origImg)); //Emailͼ��߶�
		}

		$newWidth = $str_width + 15 + $srcWidth; //LOGO�ܿ��
		$newHeight = ($srcHeight>$str_height) ? $srcHeight+2 : $str_height+8;

		$image=imagecreatetruecolor($newWidth, $newHeight); //����ͼƬ

		$back_color = hexrgb($back_c,rgb); //ȡ������ɫ
		$back = imagecolorallocate($image, $back_color['r'], $back_color['g'], $back_color['b']); //������ɫ ��ɫ
		imagefilledrectangle($image, 0, 0, $newWidth - 1, $newHeight - 1, $back); //�������

		if($is_border){
			$border_color = hexrgb($border_c,rgb); //ȡ�߿���ɫ
			$border = imagecolorallocate($image, $border_color['r'], $border_color['g'], $border_color['b']); //�߿���ɫ
			imagerectangle($image, 0, 0, $newWidth - 1, $newHeight - 1, $border); //���߿�
		}

		if($is_logo){
			$srcX = $str_width+10; //EmailͼƬX��λ��
			$srcY = ($newHeight - $srcHeight)/2; //EmailͼƬY��λ��
			ImageCopy($image, $origImg, $srcX,$srcY,0,0,$srcWidth,$srcHeight); //��EmailͼƬ���Ƶ�LOGO��
		}

		$font_color = hexrgb($font_c,rgb); //ȡ������ɫ
		$color = imagecolorallocate($image, $font_color['r'], $font_color['g'], $font_color['b']); //������ɫ
		$str_x = $str_height+($newHeight-$str_height)/2;
		if(!$is_logo) $str_x-=2; //����߶�����
		imagettftext($image, $font_size, 0, 6, $str_x, $color, $font_url, $username); //������д��ͼƬ��

		//���ͼƬ
		$filename = time();
		$filedir = date("ymd",$filename);

		if(!file_exists($picdir."/".$filedir)){ //����ͼƬ�洢Ŀ¼�����·ݷֿ��洢
			mkdir($picdir."/".$filedir);
		}
		header("Content-type: image/png");
		imagepng($image,$picdir."/".$filedir."/".$filename.".png"); //���Ҫ��ͼƬ���ڱ��أ��򿪴�ѡ��
		imagedestroy($image);
		header("location: ?show=".$filename);
		exit;
	}elseif($username==""){
		$filename = "images/taddyshen.png";
		$type = 4;
	}else{
		$filename = "images/error.png";
		$type = 4;
	}
}else{
	$filename = "images/error.png";
	$type = 4;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="robots" content="nofollow" />
<style>
body{font-size:12px;color:#666;margin:0;}
</style>
</head>
<body onMouseOut="window.status='(yowao.com)Ҫ��ʵ�ò�ѯ!';return true">
<?php if($type==1){ ?>
<table style="border:1px solid #E7E7E7;" width="350" align="center">
<tr><td height="150" align="center"><img src="<?php echo $filename;?>" id="newlogo" /></td></tr>
</table>
<?php }elseif($type==2){ ?>
<script language="javascript">
function oCopy(obj){
obj.select();
js=obj.createTextRange();
js.execCommand("Copy");
} 
</script> 
<table style="border:1px solid #E7E7E7;" width="350" align="center">
<tr><td height="80" align="center"><img src="<?php echo $filename?>" id="newlogo" alt="����ͼ��" /></td></tr>
<tr><td height="40" bgcolor="#E7E7E7" align="center"><input name="savebutton" type="button" id="savebutton" onClick="document.location='?down=<?php echo $picname;?>'" value="���ر���" style="width:100px;line-height:150%;" /></td></tr>
<tr><td>
<table>
<tr><td height="20" align="center" width="60">ͼƬ��ַ</td><td><input type="text" value="<?php echo $dirurl.$filename;?>" style="width:200px;height:16px;font-family:arial;" onclick="this.select()" id="ubbpic" /></td><td><input type="button" value=" ���� " onclick="oCopy(ubbpic)" /></td></tr>
<tr><td height="20" align="center">HTML����</td><td><input type="text" value='<img src="<?php echo $dirurl.$filename;?>" alt="JiuYaoCha����ͼ�� yowao.com/mail" />' style="width:200px;height:16px;font-family:arial;" onclick="this.select()" id="htmlpic" /></td><td><input type="button" value=" ���� " onclick="oCopy(htmlpic)" /></td></tr>
</table>
</td></tr>
</table>
<?php }elseif($type==3){ ?>

<?php }else{ ?>
<table style="border:1px solid #E7E7E7;" width="350" align="center">
<tr><td height="150" align="center"><img src="<?php echo $filename;?>" id="newlogo" alt="��,������,������!" /></td></tr>
</table>
<?php } ?>
</body>
</html>
