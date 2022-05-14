<?php

require_once('config/config.php');


if (!auth() and !($_SESSION['felhasznalo']['admin'])){
	header('Location:manager_login.php');
}else{
	$usid = $_SESSION['felhasznalo']['id'];
}

db_Connect();

/*cég szerkesztő / hozzáadó form*/

$id = 	( isset( $_REQUEST['id'] ) ) 	  ? $_REQUEST['id'] 	: false;
$pid = 	( isset( $_REQUEST['pid'] ) ) 	  ? $_REQUEST['pid'] 	: false;
//portálok lekérdezése
$res_p = mysql_query("SELECT * FROM portal WHERE 1")or die(mysql_error());
$portalok = array();
while($e_p = mysql_fetch_assoc($res_p)){
	$portalok[$e_p['portalid']] = stripslashes($e_p['portal_name']);
}
$smarty->assign('portalok',$portalok);

if ($id > 0){			//ha kapott cég id-t akkor szerkesztési mód
	$event = 'edit';
	$sql = 'SELECT * FROM ceglista WHERE cid='.$id;
	if (!($_SESSION['felhasznalo']['admin'])){ $sql.=' and uzletkid='.$usid;}	//user csak sajátot
	$q = mysql_query( $sql ) or die(mysql_error());
	
	if(mysql_num_rows($q)!=1){
		die('Inkonzisztens céglista (azonosító duplikáció). Vagy nincs jogosultsága ezt a céget szerkeszteni.');
	}else{	
		$d = mysql_fetch_array($q);
		$nem 		= ($d['felvitte']==0) ?true:false;
		$cid 		= $d['cid'];
		$cegnev 	= stripslashes($d['cegnev']);
		$cim	 	= stripslashes($d['cim']);
		$telszam 	= stripslashes($d['telszam']);
		//$allapot	= $d['allapot'];
		//$uzletkid	= $d['uzletkid'];
		//$megj		= stripslashes($d['megj']);
	}
	if (($_SESSION['felhasznalo']['admin'])){
		$res = mysql_query("SELECT usid, usname FROM user WHERE 1") or die(mysql_error());
		$userek = array();
		while($user = mysql_fetch_array($res)){
		    array_push($userek,array('id'=>$user['usid'],'usname'=>stripslashes($user['usname'])));		
		}
		$smarty->assign('userek',$userek);
	}
	//portálkapcsolatok lekérdezése
	$res = mysql_query("SELECT * FROM portal__ceg WHERE ceg_id=$cid".($_SESSION['felhasznalo']['admin']?"":" AND uzletkid=$usid AND allapot<4 and portal_id=".$pid) )or die(mysql_error());
	$portal_ids = array();
	$ceg_data = array();
	while($e = mysql_fetch_assoc($res)){
		$portal_ids[] = $e['portal_id'];
		$ceg_data[$e['portal_id']] = array(
			'allapot'=>$e['allapot'],
			'megj'=>stripslashes($e['megj']),
			'adstatdat'=>stripslashes($e['adstatdat']),
			'uzletkid'=>$e['uzletkid'],
			'editable'=>($e['allapot']<4)
		);		
	}	
	$smarty->assign('portal_ids',$portal_ids);
	$smarty->assign('ceg_data',$ceg_data);
	
	$smarty->assign( 'cid', $cid );
	$smarty->assign( 'pid', $pid );
	$smarty->assign( 'cegnev', $cegnev );
	$smarty->assign( 'cim', $cim );
	$smarty->assign( 'telszam', $telszam );
	//$smarty->assign( 'allapot', $allapot );
	//$smarty->assign( 'uzletkid', $uzletkid );
	//$smarty->assign( 'megj', $megj );
	$smarty->assign('nem',$nem);
	
}else{				//ha nem kapott user id-t akkor új céget vihet fel
	$event = 'add';
	$smarty->assign( 'cid', 0 );
}	

$smarty->assign( 'niceTable', 'true' );
$smarty->assign( 'event', $event);
$smarty->assign( 'admin',$_SESSION['felhasznalo']['admin']);
$tartalom=$smarty -> fetch( "manager_cedit.tpl" );
require(_DISPLAY_ADMIN);
?>