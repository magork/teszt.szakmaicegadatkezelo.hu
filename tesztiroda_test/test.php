<?php require_once('config/config.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>SQL Teszt</title>
    </head>
    <body>
    <h1>Próba, hogy jók-e az ékezetek: űáéúőpóüöŰÁÉÚPŐÓÖ</h1>
<?php

db_Connect();

$sql = "SELECT * FROM ceglista LIMIT 0,100";
$res = mysql_query($sql) or die (mysql_error());

while($x=mysql_fetch_assoc( $res )  ){
	echo $x['cegnev'] . '  -  ' . $x['cim'].'<br>';
}