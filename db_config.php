<?php 
// modify these constants to fit your environment
if (!defined("DB_SERVER")) define("DB_SERVER", _MYDB_HOST);
if (!defined("DB_NAME")) define("DB_NAME", _MYDB_DATABASE );
if (!defined("DB_USER")) define ("DB_USER", _MYDB_USER );
if (!defined("DB_PASSWORD")) define ("DB_PASSWORD", _MYDB_PASS );

// some external constants to controle the output
define("QS_VAR", "page"); // the variable name inside the query string (don't use this name inside other links)
define("NUM_ROWS", 20); // the number of records on each page
define("STR_FWD", "következő &gt;&gt;"); // the string is used for a link (step forward)
define("STR_BWD", "&lt;&lt; előző"); // the string is used for a link (step backward)
define("NUM_LINKS", 5); // the number of links inside the navigation (the default value)
?>