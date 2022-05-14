<?php
/**
 *
 *	Készítette:
 *	Szász Tibor
 *	www.skyweb.hu
 *	
 *  Minden jog fenntartva!
 *
 */
require_once('config/config.php');

db_Connect();

if( _DEBUG == 'on' ) var_dump( $_POST );

/*
 *		Külsõ változók
 */

$user = ( isset( $_POST['user'] ) ) ? $_POST['user'] : false;
$pass = ( isset( $_POST['pass'] ) ) ? $_POST['pass'] : false;

//
$cats = array();

/*
 *		Akkor hogy is állunk...
 */

if( $user == _ADMIN_NAME && $pass == _ADMIN_PASS ){

		$_SESSION['felhasznalo']['admin'] = true;
		header( 'Location: manager_user.php' );
		die();

} else {

	$res = mysql_query("SELECT usid FROM user WHERE uspass='".addslashes($pass)."' and usname='".addslashes($user)."'") or die(mysql_error());
	if ((mysql_num_rows($res)) != 1){
		$tartalom = $smarty -> fetch( "manager_login.tpl" );
		require(_DISPLAY_ADMIN);
	}else{
		$e = mysql_fetch_array($res);
		$_SESSION['felhasznalo']['admin'] = false;
		$_SESSION['felhasznalo']['id'] = $e['usid'];
		header ('Location: manager_cegeim.php');
		die();
	}
}
?>
