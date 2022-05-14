<?php
if( strpos( $_SERVER['HTTP_USER_AGENT'], '2012-02-08' ) === false ){
	die('Karbatartas alatt...');
}
require_once('config/config.php');

super_auth();

$tartalom = $smarty -> fetch( "index.tpl" );
require(_DISPLAY_ADMIN);

?>
