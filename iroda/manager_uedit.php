<?php

require_once('config/config.php');

if (!($_SESSION['felhasznalo']['admin'])){
	header('Location:manager_login.php');
}

db_Connect();


/*User szerkesztő / hozzáadó form*/

$id = 	( isset( $_REQUEST['id'] ) ) 	  ? $_REQUEST['id'] 	: false;

if ($id > 0){
	$event = 'edit';
	$q = mysql_query( 'SELECT * FROM user WHERE usid='.$id) or die(mysql_error());
	if(mysql_num_rows($q)!=1){
		die('Inkonzisztens user tábla (egyedi azonosító duplikáció lépett fel)');
	}else{	
		$d = mysql_fetch_array($q);
		$usid 		= $d['usid'];
		$usname 	= stripslashes($d['usname']);
		$usemail 	= stripslashes($d['usemail']);
		$uspass 	= stripslashes($d['uspass']);
		$uslim 		= $d['uslim'];
	}
	$smarty->assign( 'usid', $usid );
	$smarty->assign( 'usname', $usname );
	$smarty->assign( 'usemail', $usemail );
	$smarty->assign( 'uspass', $uspass );
	$smarty->assign( 'uslim', $uslim );

	
}else{
	$event = 'add';
	$smarty->assign( 'usid', 0 );
}	

$smarty->assign( 'niceTable', 'true' );
$smarty->assign( 'event', $event);
$tartalom=$smarty -> fetch( "manager_uedit.tpl" );
require(_DISPLAY_ADMIN);
?>
