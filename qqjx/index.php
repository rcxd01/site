<?php

require "includes/class.template.php";
$template = new verySimpleTemplate();

if( !@$_POST['qq'] )
{
	$template->deal( 'template/header.tpl' );
	$h = $template->template;
	$template->deal( 'template/qBody.tpl' );
	$b = $template->template;
	$template->deal( 'template/footer.tpl' );
	$f = $template->template;
	echo $h . $b . $f;
	exit();
}
else
{
	$q = str_replace( '.', '', @$_POST['qq'] );
}
if( strlen( $q ) > 10 or strlen( $q ) < 5 or !is_numeric( $q ) or $q < 0 )
{
	error( '对不起,你输入的QQ号码无效.请重新输入.' );
	exit();
}
else
{
	$li = $q % 81;
	$c = file( 'data/luck.dat' );
	$t = explode( '|', $c[$li] );
	$arrayVar = array();
	$template->deal( 'template/header.tpl' );
	$h = $template->template;
	$template->deal( 'template/qBody.tpl' );
	$b = $template->template;
	$arrayVar = array (
						'QQ'	=> $q,
						'LUCKY'	=> $t[1],
						'DES'	=> $t[0],
						'JUTI'	=> $t[4],
						'TYPE'	=> $t[3]
					  );
	$template->deal( 'template/qRender.tpl', $arrayVar );
	$r = $template->template;
	$template->deal( 'template/footer.tpl' );
	$f = $template->template;
	echo $h . $b . $r . $f;

}

function error( $e )
{
	global $template;
	$arrayVar = array();
	$template->deal( 'template/header.tpl' );
	$h = $template->template;
	$template->deal( 'template/qBody.tpl' );
	$b = $template->template;
	$arrayVar = array ( 
						'ERROR'  => $e
					  );
	$template->deal( 'template/errorRender.tpl', $arrayVar );
	$r = $template->template;
	$template->deal( 'template/footer.tpl' );
	$f = $template->template;
	echo $h . $b . $r . $f;
}

?>