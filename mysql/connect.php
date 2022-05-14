<?php

require( _PATH_CORE_EZSQL );
require( _PATH_EZSQL );

$db = new ezSQL_mysql(_MYDB_USER,_MYDB_PASS,_MYDB_DATABASE,_MYDB_HOST);

$db->query("SET NAMES utf8 COLLATE utf8_general_ci");

?>