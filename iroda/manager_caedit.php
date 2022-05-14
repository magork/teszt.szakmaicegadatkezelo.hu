<?php

require_once('config/config.php');


if ($_SESSION['felhasznalo']['admin'] == false){
	die("Te ezt nem teheted");
	header('Location:manager_login.php');
}

db_Connect();

$event = 	( isset( $_REQUEST['event'] ) ) ? $_REQUEST['event'] 	: false;
$cegnev=	( isset( $_REQUEST['cegnev'] ) ) ? $_REQUEST['cegnev'] 		: false;
$cim=		( isset( $_REQUEST['cim'] ) )  ? $_REQUEST['cim']	 	: false; 
$allapot=	( isset( $_REQUEST['allapot'] ) )  ? $_REQUEST['allapot'] 	: false;
$megj=		( isset( $_REQUEST['megj'] ) )	  ? $_REQUEST['megj']	 	: false; 
$cid=		( isset( $_REQUEST['cid'] ) )	  ? $_REQUEST['cid']	 	: false;
$uzletkid=	( isset( $_REQUEST['uzletkid'] ) )  ? $_REQUEST['uzletkid']	 : false;  
$telszam=	( isset( $_REQUEST['telszam'] ) )  ? $_REQUEST['telszam']	 : false; 

switch( $event ){
case 'del':	//cég végleges törlése
	$cid=		( isset( $_REQUEST['cid'] ) )	  ? $_REQUEST['cid']	 	: false; 
	$sql = "DELETE FROM ceglista WHERE cid=".$cid;
	$a = mysql_query($sql); 
	restart();
	break;
case 'edit':
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
			$sql = "UPDATE ceglista SET telszam = '".addslashes($telszam)."', uzletkid =".$uzletkid.",moddat='".$idostr."',cegnev='".addslashes($cegnev)."',cim='".addslashes($cim)."',megj='".addslashes($megj)."',allapot=".$allapot;
			if ($allapot == 4) $sql.=", felvitte=0 ";
			if ($allapot != $all) $sql.=", adstatdat='".$idostr."' ";
			$sql.=" WHERE cid=".$cid;
			$res = mysql_query($sql) or die(mysql_error());
		}
	}else{
		die ('Cégnevet, címet és telefonszámot meg kell adni!');
	}
	break;
case 'add':
	
	if (($cegnev!="") and ($cim!="") and ($telszam!="")){
		//szerepel e a cég az adatbázisban?
		$sql = "SELECT * from ceglista WHERE cegnev='".addslashes($cegnev)."'";
		$res = mysql_query($sql) or die (mysql_error());
		if (mysql_num_rows($res) != 0){
			die('A cég már szerepel az adatbázisban');
		}else{	
		//ha minden rendben
			$dat = getdate();
			$idostr = $dat['year']."-".$dat['mon']."-".$dat['mday'];
			$sql = "INSERT INTO ceglista VALUES('','".addslashes($cegnev)."','".addslashes($cim)."',0,'".$idostr."','".$idostr."',".$allapot.",'".addslashes($megj)."','".addslashes($telszam)."','".$idostr."',0);";
			$res = mysql_query($sql) or die(mysql_error());
			restart();
		}
		}else{
			die ('Cégnevet, címet és telefonszámot meg kell adni!');
		}
	break;

default:
	break;
}


//keresőpereméretek nullázása

	$_SESSION['felhasznalo']['kszur'] = -1;
	$_SESSION['felhasznalo']['kusname'] = "";
	$_SESSION['felhasznalo']['kcid'] = "";
	$_SESSION['felhasznalo']['kcegnev'] = "";
	$_SESSION['felhasznalo']['kcim'] = "";
	$_SESSION['felhasznalo']['kregdatK'] = "";
	$_SESSION['felhasznalo']['kregdatV'] = "";

//csak a módosított cég mutatása
header('Location:manager_kereso.php?cid='.$cid);
?>
