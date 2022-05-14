<?php

$auth = $_SESSION['felhasznalo']['admin'] || auth ();

$smarty->assign('admin', $_SESSION['felhasznalo']['admin'] );
$smarty->assign('auth',$auth);

$frame=$smarty -> fetch( "admin.tpl" );
$frame=preg_replace('/<!-- tartalom -->/', $tartalom, $frame);

if(!empty($local['tpl']))
{
	$frame=preg_replace('/<!-- local -->/', $smarty -> fetch( $local['tpl'] ), $frame);
}

header('Content-Type: text/html; charset=utf-8');
echo $frame;
?>
