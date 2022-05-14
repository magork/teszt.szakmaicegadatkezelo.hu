<?php

require_once('config/config.php');

if (!auth()){
	header('Location:manager_login.php');

}else{
	$usid = $_SESSION['felhasznalo']['id'];
}

db_Connect();

$event = 	( isset( $_REQUEST['event'] ) ) ? $_REQUEST['event'] 	: false;
$tol = 		( isset( $_GET['tol'] ) )  ? $_GET['tol']	 	: 0; 
$szur =		( isset( $_REQUEST['szur'] ) ) 	  ? $_REQUEST['szur'] 	: false;
if ($szur){
	$_SESSION['felhasznalo']['szuro'] = $szur;
}
/**
 *		Eseménykezelés
 */
 
switch( $event ){
	case 'del':	//cég végleges törlése
		$cid=		( isset( $_REQUEST['cid'] ) )	  ? $_REQUEST['cid']	 	: false; 
		$sql = "DELETE FROM ceglista WHERE allapot<4 and felvitte>0 and uzletkid = ".$usid." and cid=".$cid;
		$a = mysql_query($sql); 
		restart();

	break;
	case 'felvesz':	//cég felvétele
		if (!limitEll($usid)){
			die("Jelenleg nincs lehetősége több cég felvitelére!");
		}
		$cid=		( isset( $_REQUEST['cid'] ) )	  ? $_REQUEST['cid']	 	: false; 
		if ($cid){
			$dat = getdate();
			$idostr = $dat['year']."-".$dat['mon']."-".$dat['mday'];	
			$sql = "UPDATE ceglista SET allapot=0, adstatdat='".$idostr."', uzletkid=".$usid." WHERE cid=".$cid;
			//die($sql);
			$a = mysql_query($sql);
		}
		restart();

	break;
	case 'del1':	//a céget csak a munkakosárból törli. gazdátlan cég uzletkid=0, alapból nem hívott állapotú
		$cid=		( isset( $_REQUEST['cid'] ) )	  ? $_REQUEST['cid']	 	: false; 
		$dat = getdate();
		$idostr = $dat['year']."-".$dat['mon']."-".$dat['mday'];
		$sql = "UPDATE ceglista SET moddat='".$idostr."',uzletkid=0 WHERE allapot<4 and felvitte!=".$usid." and uzletkid=".$usid." and cid=".$cid;
		//die($sql);
		$a = mysql_query($sql); 
		restart();		
	break;
	case 'add':	//cég hozzáadása
		$cegnev=	( isset( $_REQUEST['cegnev'] ) ) ? $_REQUEST['cegnev'] 		: false;
		$cim=		( isset( $_REQUEST['cim'] ) )  ? $_REQUEST['cim']	 	: false; 
		$allapot=	( isset( $_REQUEST['allapot'] ) )  ? $_REQUEST['allapot'] 	: false;
		$megj=		( isset( $_REQUEST['megj'] ) )	  ? $_REQUEST['megj']	 	: false;
		$telszam=	( isset( $_REQUEST['telszam'] ) )  ? $_REQUEST['telszam'] 	: false;  
		if (($cegnev!="") and ($cim!="") and ($telszam!="")){
			// limit ellenőrzés
			if (!limitEll($usid)){
				die("Jelenleg nincs lehetősége több cég felvitelére!");
			}
			//szerepel e a cég az adatbázisban?
			$sql = "SELECT * from ceglista WHERE cegnev='".addslashes($cegnev)."'";
			$res = mysql_query($sql) or die (mysql_error());
			if (mysql_num_rows($res) != 0){
				die('A cég már szerepel az adatbázisban');
			}else{	
			//ha minden rendben
				$dat = getdate();
				$idostr = $dat['year']."-".$dat['mon']."-".$dat['mday'];
				$sql = "INSERT INTO ceglista VALUES('','".addslashes($cegnev)."','".addslashes($cim)."',".$usid.",'".$idostr."','".$idostr."',".$allapot.",'".addslashes($megj)."','".addslashes($telszam)."','".$idostr."',".$usid.");";
				$res = mysql_query($sql) or die(mysql_error());
				restart();
			}
		}else{
			die ('Cégnevet, címet és telefonszámot meg kell adni!');
		}
	break;	
	case 'edit':	//cég szerkesztése
		$cegnev=	( isset( $_REQUEST['cegnev'] ) ) ? $_REQUEST['cegnev'] 		: false;
		$cim=		( isset( $_REQUEST['cim'] ) )  ? $_REQUEST['cim']	 	: false; 
		$allapot=	( isset( $_REQUEST['allapot'] ) )  ? $_REQUEST['allapot'] 	: false;
		$megj=		( isset( $_REQUEST['megj'] ) )	  ? $_REQUEST['megj']	 	: false; 
		$cid=		( isset( $_REQUEST['cid'] ) )	  ? $_REQUEST['cid']	 	: false;
		$telszam=	( isset( $_REQUEST['telszam'] ) )  ? $_REQUEST['telszam'] 	: false;  
		
		//ha mindent kitöltöttem mehet
		if (($cegnev!="") and ($cim!="") and ($cid!=0) and ($telszam!="")){
			$sql = "SELECT * from ceglista WHERE cegnev='".addslashes($cegnev)."' and cid!=".$cid;
			$res = mysql_query($sql) or die (mysql_error());
			if (mysql_num_rows($res) != 0){
				die('Cég már felvíve más által.');
			}else{	
				$st = mysql_query("SELECT allapot FROM ceglista WHERE cid=".$cid) or die(mysql_error());
    				$al = mysql_fetch_array($st);
				$all = $al['allapot']; 
				$dat = getdate();
				$idostr = $dat['year']."-".$dat['mon']."-".$dat['mday'];
				$sql = "UPDATE ceglista SET moddat='".$idostr."',megj='".addslashes($megj)."',allapot=".$allapot." ";
    				if ($allapot != $all) $sql.=", adstatdat='".$idostr."' ";
				$sql.=" WHERE allapot<4 and uzletkid=".$usid." and cid=".$cid;
				//allapot<4 biztosítja hogy admin által valamilyen állapotba hozott cég nem szerkeszthető;
				$res = mysql_query($sql) or die(mysql_error());
				$sql = "UPDATE ceglista SET telszam = '".addslashes($telszam)."' ,cegnev='".addslashes($cegnev)."' ,cim='".addslashes($cim)."' ";    			
				$sql.=" WHERE allapot<4 and felvitte>0 and uzletkid=".$usid." and cid=".$cid;
				
				$res = mysql_query($sql) or die(mysql_error());				
				//felvitte>0 azaz ha nem admin vitte fel akkor írhatja át ezeket a mezőket
				restart();
			}
		}else{
			die ('Cégnevet, címet és telefonszámot meg kell adni!');
		}
		restart();
	break;	
	default:
		// limit ellenőrzés
		if(!limitEll($usid)){
			$smarty->assign( 'lehet', false );
		}else{
			$smarty->assign( 'lehet', true );
		}

		//saját cégek kilistázása
		$db = array();
		$sql = 'SELECT cid FROM ceglista WHERE uzletkid='.$usid;
		if (isset($_SESSION['felhasznalo']['szuro']) and $_SESSION['felhasznalo']['szuro']!=-1){
			$sql.=' and allapot='.$_SESSION['felhasznalo']['szuro'];
		}
		$s = mysql_query($sql) or die(mysql_error());
		$sorok = mysql_num_rows( $s );
	
		$perLap = 50;
		
		$sql = 'SELECT * FROM ceglista WHERE uzletkid='.$usid ;
		if (isset($_SESSION['felhasznalo']['szuro']) and $_SESSION['felhasznalo']['szuro']!=-1){
			$sql.=' and allapot='.$_SESSION['felhasznalo']['szuro'];
			$smarty->assign( 'szuro', $_SESSION['felhasznalo']['szuro'] );
		}
		$sql.= ' ORDER by moddat desc, cid desc LIMIT '.$tol.', '.$perLap;
		$q = mysql_query( $sql ) or die(mysql_error());

		$lapozas = tolokgeneralo( $sorok, $perLap, $tol );

		while( $d = mysql_fetch_array( $q ) ){
			$editable = ($d['allapot']<4) ? true : false;
			$torl = ($d['felvitte']>0) ? true : false;
			$torl1 = ($d['felvitte']!=$usid) ? true: false;
			$db[] = array( 
				'cid' 		=> $d['cid'],
				'cegnev' 	=> stripslashes($d['cegnev']),
				'cim'	 	=> stripslashes($d['cim']),
				'telszam' 	=> stripslashes($d['telszam']),
				'felvdat' 	=> $d['felvdat'],
				'moddat'	=> $d['moddat'],
				'allapot'	=> all2Str($d['allapot']),
				'uzletkid'	=> $d['uzletkid'],
				'adstatdat'	=> $d['adstatdat'],
				'megj'		=> stripslashes($d['megj']),
				'editable'	=> $editable,
				'torl1'		=> $torl1,
				'torl'		=> $torl
			);
		}
		$smarty->assign( 'db', $db );
		$smarty->assign( 'pager', $lapozas );
	break;
}
$smarty->assign( 'niceTable', 'true' );
$tartalom=$smarty -> fetch( "manager_cegeim.tpl" );
require(_DISPLAY_ADMIN);
?>
