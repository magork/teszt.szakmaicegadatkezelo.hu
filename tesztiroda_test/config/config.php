<?php

require_once( 'config_database.php' );

/* Nem kívánt látogatók elküldése melegebb éghajlatra */

if( strpos( $_SERVER['HTTP_USER_AGENT'], '2012-02-08' ) === false ){
	die('Karbatartas alatt...');
}


/* Általános változók */
define('_URL', 'http://uzleticegtudakozo.hu/');
define('_THUMB_SIZE', 206 );
define('_RES_PER_PAGE', 5 );

/* Path változók */
define('_PATH_OFFICE', 'tesztiroda_test/');

define('_PATH_SMARTY', 'smarty/class.template.php');
define('_PATH_MYSQL', 'mysql/mysql.php');
define('_PATH_XML', 'xml/class.xml2Array.php');
define('_PATH_SESSION', 'session/session.php');
define('_PATH_TEXT', 'text/');
define('_PATH_TEMPLATES', 'templates');
define('_PATH_COMPILED', 'compiled');
define('_PATH_CACHED', 'cached');
define('_PATH_MAILER', 'phpmailer/class.phpmailer.php');
define('_PATH_FUNCTIONS', 'functions/functions.php');

/* Megjelenítés */
define('_DISPLAY_PUBLIC', 'display/public.php');
define('_DISPLAY_ADMIN', 'display/admin.php');


/* FCK EDITOR PATH 2 Upload */
/* js/fckeditor/editor/filemanager helyen lehet állítani */
//define('FCK_ROOT', 'display/admin.php');

/* Admin beállítások */
define( '_ADMIN_NAME' , 'Retroétteremés Pizzéria' );
define( '_ADMIN_PASS' , 'doqmoc99' );
define( '_ADMIN_EMAIL' , 'tszasz@gmail.com' );

/* Include */
require_once(_PATH_MYSQL);
require_once(_PATH_FUNCTIONS);
require_once(_PATH_SESSION);
require_once(_PATH_SMARTY);

/* Init */

$smarty = new Template_Lite();

$smarty->template_dir = _PATH_TEMPLATES;
$smarty->compile_dir = _PATH_COMPILED;
$smarty->reserved_template_varname = "smarty";
$smarty->_cache_dir = _PATH_CACHED;

// UserID

if ( $_SESSION['felhasznalo']['id'] != 0 ){

	$smarty->assign( 'uid', $_SESSION['felhasznalo']['id'] );

} else {

	$smarty->assign( 'uid', 0 );
}

if ( $_SESSION['felhasznalo']['admin'] == true ){

	$smarty->assign( 'admin', true );

}

$sroot = explode( '/', $_SERVER['REQUEST_URI'] );
array_pop( $sroot );
$sroot = implode( '/', $sroot );
//$sroot = $_SERVER['SERVER_NAME'];

$smarty->assign( 'server_root', _URL . $sroot );

//
/* DEBUG  */
//
define( '_DEBUG' , 'on_' );
//

?>
