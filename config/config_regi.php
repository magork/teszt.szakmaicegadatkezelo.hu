<?php

//
// ÚTVONAL DEFINÍCIÓK
//
define( '_BASECHARSET', 'utf-8');
//
define( '_BASE_PATH', '/teszt.szakmaicegadatkezelo.hu/' );

define( '_PATH_CORE_EZSQL', _BASE_PATH . "mysql/core/ez_sql_core.php" );
define( '_PATH_CORE_EZRESULTS', _BASE_PATH . "mysql/results/sql_results.php" );
define( '_PATH_EZSQL', _BASE_PATH . "mysql/ezsql/ez_sql_mysql.php" );
define( '_PATH_DBCONNECT', _BASE_PATH . "mysql/ezsql/ez_sql_mysql.php" );
//
//define( "_MYDB_HOST", "db.lanten.hu" );
define( "_MYDB_HOST", "localhost" );
//define( "_MYDB_USER" , "unioscegtudakoz" );
//define( "_MYDB_USER" , "internet-telefon" );
define( "_MYDB_USER" , "szakmaic_internet-telefon" );
//define( "_MYDB_PASS" , "uniPass" );
define( "_MYDB_PASS" , "vitpot66!" );
//define( "_MYDB_DATABASE" , "unioscegtudakoz" );
define( "_MYDB_DATABASE" , "szakmaic_mavak_teszt" );

setlocale( LC_ALL, "hun_hun" );
//
//
//
?>
