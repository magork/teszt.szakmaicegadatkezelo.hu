<?php

session_start();


if(!isset($_SESSION['felhasznalo']))
{
		$_SESSION['felhasznalo'] = array();
		$_SESSION['felhasznalo']['id'] = 0;
		$_SESSION['felhasznalo']['name'] = '';
		$_SESSION['felhasznalo']['admin'] = '';
}
		
if(!isset($_SESSION['URLback']))
{

	$_SESSION['URLback'] = '';

}

if(!isset($_SESSION['basket']))
{
	$_SESSION['basket'] = array();
}
if(!isset($_SESSION['imageID']))
{
	$_SESSION['imageID'] = '';
}
 
?>