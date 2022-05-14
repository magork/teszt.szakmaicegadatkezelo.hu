<?php 
session_start();

include('config/config.php');
include('mysql/connect.php');

$email = ( isset( $_POST['email'] ) ) ? addslashes( $_POST['email'] ) : 'nope';

$pass = ( isset( $_POST['pass'] ) ) ? addslashes( $_POST['pass'] ) : 'nope';

$dpass = $db->get_row("SELECT id, pass FROM companies WHERE email = '".$email."'");

if( $pass == $dpass->pass ){
	$_SESSION['auth'] = '1';
	$_SESSION['cid'] = $dpass->id;

	header('location: index.php?do=b2b_myoffers');

} else {
	header('location: index.php?do=auth_failed');
}

?>