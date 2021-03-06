<?php
/**
 * $Id: mysql.php date: 2006-06-28 09:47 Haan $
 *
 * $LastChangedDate: 2006-06-28 09:47
 * $LastChangedBy: Haan $
 * 
 * MySQL kezelo fuggvenyek
 * 
 */


function db_Connect ( )
{

	static $MYSQL_connID = 0;
   	$runner = 0;
   	$dbOK = false;
   	
   	if(!empty($MYSQL_connID)) return $MYSQL_connID;
   	

   	while ( $runner < 10 )
   	{

		$MYSQL_connID = @mysql_connect( _MYDB_HOST, _MYDB_USER, _MYDB_PASS );
		if ( @mysql_select_db ( _MYDB_DATABASE, $MYSQL_connID ) )
		{

			$dbOK = true;
			break;

		}
       	$runner++;
   	}

   	if ( $dbOK == false )
   	{

    	@mysql_close( $MYSQL_connID );
        $MYSQL_connID = 0;

   	}

   	//mysql_query('SET CHARACTER SET UTF8', $MYSQL_connID);
   	//mysql_query('SET NAMES UTF8');
	return $MYSQL_connID;

}

function db_Close ( $ID )
{

	@mysql_close ( $ID );
	$MYSQL_connID = 0;

}

/**
 * a beadott objectbol egy mysql-be irhato stringet csinal
 */
function	mysqlInsert	( $table, $obj )
{

   	$sql = "INSERT INTO ".$table. " (";
   	
	$a = array();
	$b = array();

	foreach ( $obj as $key => $val )
		$a[] = $key;

	$sql.= implode( ",", $a );	// $sql-be beteszi a sor neveket, vesszovel elvalasztva
	
   	$sql.= ") VALUES (";

	foreach( $obj as $key => $val )
		$b[] = "'" . addslashes( $val ) . "'";

	$sql.= implode( ",", $b );	// $sql-be beteszi a sor neveket, vesszovel elvalasztva

   	$sql.= ")";

   	return mysql_query( $sql );
}        
//
//
//
/**
 * a beadott objectbol egy mysql-be irhato stringet csinal
 * id - ami a kulcs, ami alapjan tudja melyik sort kell updatelni
 */
function	mysqlUpdate	( $table, $obj, $id )
{

	$sql = "UPDATE " . $table . " SET ";

	$a = array();

	foreach ( $obj as $key => $val )
   		if	($key != $id) $a[] = "$key = '".addslashes($val)."'";


	$sql.= implode ( ",", $a );	// $sql-be beteszi a sor neveket, vesszovel elvalasztva

   	$sql.= " WHERE " . $id . "='" . $obj[ $id ] . "'";
   	
   	return mysql_query( $sql );

}

?>
