<?php 

if( strpos( $_SERVER['HTTP_USER_AGENT'], '2012-02-08' ) === false ){
	die('Karbatartas alatt...');
}


error_reporting(0);

	/********************
	*	SOME INCLUDE
	*********************/

	include("src/admin.class.php");
	include("../config/config.php");
	include("../mysql/connect.php");
	include( _PATH_CORE_EZRESULTS );

session_start();

$pass	 	= ( isset( $_POST['p'] ) ) ? $_POST['p'] : false;
$user 		= ( isset( $_POST['u'] ) ) ? $_POST['u'] : false;
$event 		= ( isset( $_POST['e'] ) ) ? $_POST['e'] : false;

$_SESSION['auth'] = ( isset( $_SESSION['auth'] ) ) ? $_SESSION['auth'] : 'nope';

if( $event == 'login' )
{
	$res = $db->get_var( 'SELECT who FROM felhasznalok WHERE user = "'.addslashes($user).'" AND pass = "'.addslashes($pass).'" ' );

	if( $db->num_rows == 1 )
	{
		$_SESSION['auth'] = '1';
		$_SESSION['who'] = $res;
	}
}
	//var_dump( $_SESSION );
	include('loggedin.php');

if( $_SESSION['auth'] != 1 )
{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Courier New, Courier, monospace;
	font-size: 14px;
	color: #000;
}
body {
	background-color: #fda;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="e" value="login" />
	<p>&nbsp;</p>
  <table width="100%" height="104" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="49%" height="59" align="right" valign="middle">Felhaszn&aacute;l&oacute;n&eacute;v: </td>
		<td width="51%" align="left" valign="middle"><input type="text" name="u" /></td>
	  </tr>
	  <tr>
		<td height="45" align="right" valign="middle">Jelsz&oacute;: </td>
		<td align="left" valign="middle"><input type="password" name="p" /> <input value="bel&eacute;p&eacute;s" type="submit" />
		</td>
	  </tr>
  </table>
</form>
</body>
</html>
<?
}
?>