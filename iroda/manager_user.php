<?php

require_once('config/config.php');

if (!($_SESSION['felhasznalo']['admin'])){
	header('Location:manager_login.php');
}

db_Connect();

$event = 	( isset( $_REQUEST['event'] ) ) ? $_REQUEST['event'] 	: false;
$tol = 		( isset( $_GET['tol'] ) )  ? $_GET['tol']	 	: 0; 
$id = 		( isset( $_REQUEST['id'] ) ) 	  ? $_REQUEST['id'] 	: false; 

/**
 *		Eseménykezelés
 */
 
switch( $event ){
	case 'del':	//User törlése
		$a = mysql_query( 'DELETE FROM user WHERE usid = "'.$id.'"' ); 
		$a = mysql_query(' UPDATE ceglista SET uzletkid=0 WHERE uzletkid='.$id);
		restart();

	break;
	case 'add':	//User hozzáadása
		$usname=	( isset( $_REQUEST['usname'] ) ) ? $_REQUEST['usname'] 		: false;
		$usemail=	( isset( $_REQUEST['usemail'] ) )  ? $_REQUEST['usemail'] 	: false; 
		$uspass=	( isset( $_REQUEST['uspass'] ) )  ? $_REQUEST['uspass'] 	: false;
		$uslim=		( isset( $_REQUEST['uslim'] ) )	  ? $_REQUEST['uslim']	 	: false; 
		if (($usname!="") and ($usemail!="") and ($uspass!="") and ($uslim!="")){
			$sql = "SELECT * from user WHERE usname='".addslashes($usname)."'";
			$res = mysql_query($sql) or die (mysql_error());
			if (mysql_num_rows($res) != 0){
				die('Felhasználónév foglalt');
			}else if(strlen($uspass)<5){
				die('A jelszó minimum 5 karakter legyen!');
			}else if(!isNumeric($uslim)){
				die('A limitnek egy számnak kell lennie!');
			}else{
				$sql = "INSERT INTO user VALUES('','".addslashes($usemail)."','".addslashes($usname)."','".addslashes($uspass)."',".$uslim.");";
				$res = mysql_query($sql) or die(mysql_error());
				restart();
			}
		}else{
			die ('Mindent meg kell adni!');
		}
	break;	
	case 'edit':	//user szerkesztése
		$usname=	( isset( $_REQUEST['usname'] ) ) ? $_REQUEST['usname'] 		: false;
		$usemail=	( isset( $_REQUEST['usemail'] ) )  ? $_REQUEST['usemail'] 	: false; 
		$uspass=	( isset( $_REQUEST['uspass'] ) )  ? $_REQUEST['uspass'] 	: false;
		$uslim=		( isset( $_REQUEST['uslim'] ) )	  ? $_REQUEST['uslim']	 	: false; 
		$usid=		( isset( $_REQUEST['usid'] ) )	  ? $_REQUEST['usid']	 	: false; 
		if (($usname!="") and ($usemail!="") and ($uspass!="") and ($uslim!="") and ($usid!=0)){
			$sql = "SELECT * from user WHERE usname='".addslashes($usname)."' and usid!=".$usid;
			
			$res = mysql_query($sql) or die (mysql_error());
			if (mysql_num_rows($res) != 0){
				die('Felhasználónév foglalt más azonosítóju user által.');
			}else if(strlen($uspass)<5){
				die('A jelszó minimum 5 karakter legyen!');
			}else if(!isNumeric($uslim)){
				die('A limitnek egy számnak kell lennie!');
			}else{
				$sql = "UPDATE user SET usemail='".addslashes($usemail)."',usname='".addslashes($usname)."',uspass='".addslashes($uspass)."',uslim=".$uslim." WHERE usid=".$usid;
				$res = mysql_query($sql) or die(mysql_error());
				restart();
			}
		}else{
			die ('Mindent meg kell adni!');
		}
		restart();
	break;	
	default:	//userek kilistázása
		$db = array();
		$sql = 'SELECT usid FROM user WHERE 1';
		
		$s = mysql_query($sql);
		$sorok = mysql_num_rows( $s );
		
		$perLap = 50;

		$q = mysql_query( 'SELECT * FROM user ORDER by usname LIMIT '. $tol.', '.$perLap ) or die(mysql_error());

		$lapozas = tolokgeneralo( $sorok, $perLap, $tol );

		while( $d = mysql_fetch_array( $q ) ){
			$db[] = array( 
				'usid' 		=> $d['usid'],
				'usname' 	=> stripslashes($d['usname']),
				'usemail' 	=> stripslashes($d['usemail']),
				'uspass' 	=> stripslashes($d['uspass']),
				'uslim' 	=> $d['uslim']
			);
		}
	$smarty->assign( 'db', $db );
	$smarty->assign( 'pager', $lapozas );
		
	break;
}
$smarty->assign( 'niceTable', 'true' );
$tartalom=$smarty -> fetch( "manager_user.tpl" );
require(_DISPLAY_ADMIN);
?>
