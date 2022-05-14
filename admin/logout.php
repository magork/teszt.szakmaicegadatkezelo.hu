<?php
session_start();

$_SESSION['auth'] = 0;

session_destroy();

header('location: index.php');

?>