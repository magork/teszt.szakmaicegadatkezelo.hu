<?php

define( '_BASECHARSET', 'utf-8');
//
define( '_BASE_PATH', '/home/domains/uzleticegtudakozo.hu/html/' );

define( '_PATH_CORE_EZSQL', _BASE_PATH . "mysql/core/ez_sql_core.php" );
define( '_PATH_CORE_EZRESULTS', _BASE_PATH . "mysql/results/sql_results.php" );
define( '_PATH_EZSQL', _BASE_PATH . "mysql/ezsql/ez_sql_mysql.php" );
define( '_PATH_DBCONNECT', _BASE_PATH . "mysql/ezsql/ez_sql_mysql.php" );
//
//
//define( "_MYDB_HOST", "db.lanten.hu" );
define( "_MYDB_HOST", "localhost" );
//define( "_MYDB_USER" , "unioscegtudakoz" );
define( "_MYDB_USER" , "magyar03_magyar" );
//define( "_MYDB_PASS" , "uniPass" );
define( "_MYDB_PASS" , "MagyarPass909" );
//define( "_MYDB_DATABASE" , "unioscegtudakoz" );
define( "_MYDB_DATABASE" , "magyar03_magyar" );
setlocale( LC_ALL, "hun_hun" );


require( _PATH_CORE_EZSQL );
require( _PATH_EZSQL );

$db = new ezSQL_mysql(_MYDB_USER,_MYDB_PASS,_MYDB_DATABASE,_MYDB_HOST);

//$db->query("SET NAMES UTF8 COLLATE utf8_general_ci");

?>