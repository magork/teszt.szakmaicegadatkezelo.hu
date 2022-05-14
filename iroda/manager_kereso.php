<?php

require_once('config/config.php');

if ((!auth())&&(!($_SESSION['felhasznalo']['admin']))){
	header('Location:manager_login.php');
}else{
	$usid = $_SESSION['felhasznalo']['id'];
}

db_Connect();

$tol = 		( isset( $_GET['tol'] ) )  ? $_GET['tol']	 	: 0; 

if(isset( $_REQUEST['szur'] )){
	$_SESSION['felhasznalo']['kszur'] = $_REQUEST['szur'];
}
if( isset( $_REQUEST['usname'] ) ){
	$_SESSION['felhasznalo']['kusname'] = $_REQUEST['usname'];
}
if( isset( $_REQUEST['cid'] ) ){
	$_SESSION['felhasznalo']['kcid'] = $_REQUEST['cid'];
}
if(isset( $_REQUEST['cegnev'] ) ){
	$_SESSION['felhasznalo']['kcegnev'] = $_REQUEST['cegnev'];
}
if(isset( $_REQUEST['cim'] ) ){
	$_SESSION['felhasznalo']['kcim'] = $_REQUEST['cim'];
}
if(isset( $_REQUEST['regdatK'] ) ){
	$_SESSION['felhasznalo']['kregdatK'] = $_REQUEST['regdatK'];
}
if(isset( $_REQUEST['regdatV'] ) ){
	$_SESSION['felhasznalo']['kregdatV'] = $_REQUEST['regdatV'];
}
//keresési feltételek vizsgálta (sql lekérdezés, smarty->formkitöltés)

$feltet = " WHERE 1";
if (isset($_SESSION['felhasznalo']['kszur'])and($_SESSION['felhasznalo']['kszur']!=-1)){
	$feltet.=" and allapot=".$_SESSION['felhasznalo']['kszur'];
	$smarty->assign('szuro',$_SESSION['felhasznalo']['kszur']);
}
if (isset($_SESSION['felhasznalo']['kusname'])and($_SESSION['felhasznalo']['kusname']!="")){
	$feltet.=" and usname='".addslashes($_SESSION['felhasznalo']['kusname'])."'";
	$smarty->assign('k_usname',$_SESSION['felhasznalo']['kusname']);
}
if (isset($_SESSION['felhasznalo']['kcid'])and ($_SESSION['felhasznalo']['kcid']!="") and (isNumeric($_SESSION['felhasznalo']['kcid']))){
	$feltet.=" and cid=".$_SESSION['felhasznalo']['kcid'];
	$smarty->assign('k_cid',$_SESSION['felhasznalo']['kcid']);
}
if (isset($_SESSION['felhasznalo']['kcegnev'])and $_SESSION['felhasznalo']['kcegnev']!=""){
	$feltet.=" and cegnev Like '%".addslashes($_SESSION['felhasznalo']['kcegnev'])."%'";
	$smarty->assign('k_cegnev',$_SESSION['felhasznalo']['kcegnev']);
}
if (isset($_SESSION['felhasznalo']['kcim'])and $_SESSION['felhasznalo']['kcim']!=""){
	$feltet.=" and cim Like '%".addslashes($_SESSION['felhasznalo']['kcim'])."%'";
	$smarty->assign('k_cim',$_SESSION['felhasznalo']['kcim']);
}
if (isset($_SESSION['felhasznalo']['kregdatK'])and $_SESSION['felhasznalo']['kregdatK']!=""){
	$feltet.=" and adstatdat >= '".addslashes($_SESSION['felhasznalo']['kregdatK'])."'";
	$smarty->assign('k_regk',$_SESSION['felhasznalo']['kregdatK']);
}
if (isset($_SESSION['felhasznalo']['kregdatV'])and $_SESSION['felhasznalo']['kregdatV']!=""){
	$feltet.=" and adstatdat <= '".addslashes($_SESSION['felhasznalo']['kregdatV'])."'";
	$smarty->assign('k_regv',$_SESSION['felhasznalo']['kregdatV']);
}

//die($feltet);


		//cégek kilistázása
		$db = array();
		$sql = 'SELECT cid FROM ceglista LEFT JOIN user ON ceglista.uzletkid = user.usid';
		//megkapott feltételek hozzáfűzése
		$sql.=$feltet;
		//lapozó dolgai
		$s = mysql_query($sql) or die('0'.mysql_error());
		$sorok = mysql_num_rows( $s );
		$smarty->assign('sorok',$sorok);
		$perLap = 50;
		$lapozas = tolokgeneralo( $sorok, $perLap, $tol );
		//lista lekérdezése
		$sql = 'SELECT * FROM ceglista LEFT JOIN user ON ceglista.uzletkid = user.usid' ;
		$sql.=$feltet;
		$sql.= ' ORDER by ceglista.cegnev, ceglista.cid desc LIMIT '.$tol.', '.$perLap;
		$q = mysql_query( $sql ) or die('1'.mysql_error());
		$smarty->assign('sorok',$sorok);
		while( $d = mysql_fetch_array( $q ) ){
			$editable = ((($d['uzletkid']==0) or ($d['allapot']==4)) and (limitEll($usid)) and ($usid!=$d['uzletkid'])) ? true : false;
			$db[] = array( 
				'cid' 		=> $d['cid'],
				'cegnev' 	=> stripslashes($d['cegnev']),
				'cim'	 	=> stripslashes($d['cim']),
				'usemail' 	=> stripslashes($d['usemail']),
				'felvdat' 	=> $d['felvdat'],
				'moddat'	=> $d['moddat'],
				'tel'		=> stripslashes($d['telszam']),
				'allapot'	=> all2Str($d['allapot']),
				'uzletkid'	=> $d['uzletkid'],
				'adstatdat'	=> $d['adstatdat'],
				'usname'	=> stripslashes($d['usname']),
				'megj'		=> stripslashes($d['megj']),
				'editable'	=> $editable,
				'adst'		=> $adst
			);
		}
		$smarty->assign( 'db', $db );
		$smarty->assign( 'pager', $lapozas );

$smarty->assign( 'admin', $_SESSION['felhasznalo']['admin'] );
$smarty->assign( 'niceTable', 'true' );
$tartalom=$smarty -> fetch( "manager_kereso.tpl" );
require(_DISPLAY_ADMIN);
?>
