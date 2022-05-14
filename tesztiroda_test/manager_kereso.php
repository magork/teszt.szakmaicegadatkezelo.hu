<?php

require_once('config/config.php');

if ((!auth())&&(!($_SESSION['felhasznalo']['admin']))){
	header('Location:manager_login.php');
}else{
	$usid = $_SESSION['felhasznalo']['id'];
}

db_Connect();

$tol = 		( isset( $_GET['tol'] ) )  ? $_GET['tol']	 	: 0; 

//php_ini('display_errors','on');

//portálok lekérdezése

$res_p = mysql_query("SELECT * FROM portal WHERE 1")or die(mysql_error());
$portalok = array();
while($e_p = mysql_fetch_assoc($res_p)){
	$portalok[$e_p['portalid']] = stripslashes($e_p['portal_name']);
}
$smarty->assign('portalok',$portalok);			


if(isset($_POST['kereses_esemeny'])){
	//mely portálok lettek lekérdezve
	$portal_ids = array();
	$akp = array();
	if($portalok) $akp = array_keys($portalok);
	if($akp)foreach($akp as $p_k => $p_v){
		if(isset($_POST['portalok_'.$p_v])) $portal_ids[] = $p_v;
	}
	$_SESSION['felhasznalo']['kportalok'] = $portal_ids;
}

//szuresi feltetellek mentese
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

$feltet = " WHERE 1 ";
if(isset($_SESSION['felhasznalo']['kportalok']) and ($_SESSION['felhasznalo']['kportalok'])){
	$feltet.=" AND ( 0 ";
	foreach($_SESSION['felhasznalo']['kportalok'] as $kpf=>$kpv){
		$feltet.=" OR pc.portal_id=$kpv ";
	}
	$feltet.=") ";
	$smarty->assign('portal_ids',$_SESSION['felhasznalo']['kportalok']);
}

if (isset($_SESSION['felhasznalo']['kszur'])and($_SESSION['felhasznalo']['kszur']!=-1)){
	$feltet.=" and pc.allapot=".$_SESSION['felhasznalo']['kszur'];
	$smarty->assign('szuro',$_SESSION['felhasznalo']['kszur']);
}
if (isset($_SESSION['felhasznalo']['kusname'])and($_SESSION['felhasznalo']['kusname']!="")){
	$feltet.=" and usname LIKE '%".addslashes($_SESSION['felhasznalo']['kusname'])."%'";
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
	$feltet.=" and pc.adstatdat >= '".addslashes($_SESSION['felhasznalo']['kregdatK'])."'";
	$smarty->assign('k_regk',$_SESSION['felhasznalo']['kregdatK']);
}
if (isset($_SESSION['felhasznalo']['kregdatV'])and $_SESSION['felhasznalo']['kregdatV']!=""){
	$feltet.=" and pc.adstatdat <= '".addslashes($_SESSION['felhasznalo']['kregdatV'])."'";
	$smarty->assign('k_regv',$_SESSION['felhasznalo']['kregdatV']);
}

//die($feltet);

		
		//cégek kilistázása
		$db = array();
		$sql = 'SELECT cid
				FROM ceglista 
				LEFT JOIN portal__ceg as pc ON pc.ceg_id = ceglista.cid
				LEFT JOIN user ON pc.uzletkid = user.usid ';
		//megkapott feltételek hozzáfűzése
		$sql.=$feltet.' GROUP BY cid';
		//lapozó dolgai
		$s = mysql_query($sql) or die('0'.mysql_error());
		$sorok = mysql_num_rows( $s );
	
		$smarty->assign('sorok',$sorok);
		$perLap = 50;
		$lapozas = tolokgeneralo( $sorok, $perLap, $tol );
		//lista lekérdezése
		$sql = 'SELECT ceglista.*
				FROM ceglista 
				LEFT JOIN portal__ceg as pc ON pc.ceg_id = ceglista.cid
				LEFT JOIN user ON pc.uzletkid = user.usid
				LEFT JOIN portal as p ON p.portalid = pc.portal_id';
		$sql.=$feltet;
		$sql.= ' GROUP BY cid ORDER by ceglista.cegnev, ceglista.cid desc LIMIT '.$tol.', '.$perLap;
		$q = mysql_query( $sql ) or die('1'.mysql_error());
		$smarty->assign('sorok',$sorok);
		$ceg_ids='(0';
		$db = array();
		while( $d = mysql_fetch_array( $q ) ){			
			$ceg_ids.=','.$d['cid'];
			$db[$d['cid']] = array( 
				'cid' 		=> $d['cid'],
				'cegnev' 	=> stripslashes($d['cegnev']),				
				'cim'	 	=> stripslashes($d['cim']),
			//	'usemail' 	=> stripslashes($d['usemail']),
				'felvdat' 	=> $d['felvdat'],
				'moddat'	=> $d['moddat'],
				'tel'		=> stripslashes($d['telszam']),
			//	'allapot'	=> all2Str($d['allapot']),
			//	'uzletkid'	=> $d['uzletkid'],
			//	'adstatdat'	=> $d['adstatdat'],
			//	'usname'	=> stripslashes($d['usname']),
			//	'megj'		=> stripslashes($d['megj']),
				'not_editable'	=> array(),
			//	'adst'		=> $adst
			);
		}
		$ceg_ids.=')';
		$res = mysql_query("SELECT pc.pc_date, p.portal_name, pc.ceg_id, pc.allapot, pc.portal_id , pc.adstatdat,pc.uzletkid, pc.megj, user.*
							FROM portal__ceg as pc 
							LEFT JOIN portal as p ON p.portalid = pc.portal_id
							LEFT JOIN user ON pc.uzletkid = user.usid
							WHERE pc.ceg_id IN $ceg_ids 
							ORDER BY pc_date ASC")or die(mysql_error());
		while($e = mysql_fetch_assoc($res)){
			$db[$e['ceg_id']]['portal'][] = array('date'=>$e['pc_date'],
												  'name'=>stripslashes($e['portal_name']),
												  'megj'=>stripslashes($e['megj']),
												  'allapot'=>all2Str($e['allapot']),
												  'usname'=>stripslashes($e['usname']),
												  'usemail' => stripslashes($e['usemail']),	
												  'adstatdat'=>$e['adstatdat'],
												  'portal_id'=>$e['portal_id']);
			if(!((($e['uzletkid']==0) or ($e['allapot']==4)) and (limitEll($usid)) and ($usid!=$e['uzletkid']))){
				$db[$e['ceg_id']]['not_editable'][] = 	$e['portal_id'];		 
			}
		}
		
		//var_dump( $db );
		$smarty->assign( 'db', $db );
		$smarty->assign( 'pager', $lapozas );

$smarty->assign( 'admin', $_SESSION['felhasznalo']['admin'] );
$smarty->assign( 'niceTable', 'true' );
$tartalom=$smarty -> fetch( "manager_kereso.tpl" );
require(_DISPLAY_ADMIN);
?>
