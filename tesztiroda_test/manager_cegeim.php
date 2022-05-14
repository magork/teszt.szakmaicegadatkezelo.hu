<?php

/**
 * @todo törléseknél csak azokat a protálokat ajánlja fel amibe be van víve a cég (és a feltételek megegyeznek)
 * @todo template
 * @todo editálás
 */


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

//portálok lekérdezése
$res_p = mysql_query("SELECT portalid,portal_name FROM portal WHERE 1")or die(mysql_error());
$portalok = array();
while($e_p = mysql_fetch_row($res_p)){
	$portalok[] = $e_p[0];
	$portal_list[$e_p[0]] = stripslashes($e_p[1]);
}
$smarty->assign('portal_list',$portal_list);
$smarty->assign('portalok',$portalok);
//megnézzük lett e portál kapcsolat postolva
$uj = array();
$uj_data = array();
if($portalok) foreach($portalok as $p_k => $p_v){
	if(isset($_POST['portalok_'.$p_v])){
		$uj[]=$p_v;
		$uj_data[$p_v]['allapot']=round($_POST['allapot_'.$p_v]);
		$uj_data[$p_v]['megj']=addslashes($_POST['megj_'.$p_v]);
	}
	
}


if ($szur){
	$_SESSION['felhasznalo']['szuro'] = $szur;
}
if(isset( $_POST['szurnev'])){
	$_SESSION['felhasznalo']['szurnev'] = $_POST['szurnev'];
}
/**
 *		Eseménykezelés
 */
 
switch( $event ){
	case 'del':	//cég végleges törlése
		$cid=		( isset( $_REQUEST['cid'] ) )	  ? round($_REQUEST['cid'])	 	: false; 
		$pid=		( isset( $_REQUEST['pid'] ) )	  ? round($_REQUEST['pid'])	 	: false;		
		//ha nincs admin által beállított állapot és nem admin vitte fel és ő a tulajdonosa most, törölhetem				
		$sql = 'DELETE FROM portal__ceg 
				WHERE ceg_id='.$cid.' AND portal_id = '.$pid.' AND 
					  uzletkid='.$usid.' AND felvitte>0 AND allapot<4';
		mysql_query($sql)or die(mysql_error());					
		//megnézem fennvan e a cég egyik protálon is
		$res = mysql_query('SELECT count(*) FROM portal__ceg WHERE ceg_id='.$cid)or die(mysql_error());
		$e = mysql_fetch_row($res);
		//ha nincs törlöm
		if($e['0']==0){
			mysql_query('DELETE FROM ceglista WHERE cid='.$cid)or die(mysql_error());
		}		
		restart();

	break;
	case 'felvesz':	//cég felvétele
		if (!limitEll($usid)){
			die("Jelenleg nincs lehetősége több cég felvitelére!");
		}
		$cid=		( isset( $_REQUEST['cid'] ) )	  ? round($_REQUEST['cid'])	 	: false; 
		$pid=		( isset( $_REQUEST['pid'] ) )	  ? round($_REQUEST['pid'])	 	: false;
		if ($cid && $pid ){
			$dat = getdate();
			$idostr = $dat['year']."-".$dat['mon']."-".$dat['mday'];			
			//van e ilyen portál cég kapcsolat
			$sql = "SELECT count(*) FROM portal__ceg WHERE ceg_id=$cid AND portal_id=$pid";
			$res = mysql_query($sql) or die(mysql_error());
			$e = mysql_fetch_row($res);
			//ha nincs létrehozzuk (oylan mintha ő vitte volna fel ahhoz a protálhoz)
			if($e['0']==0){
				$sql = "INSERT INTO portal__ceg (portal_id,ceg_id,uzletkid,felvitte,allapot,pc_date,adstatdat) 
						VALUES ($pid,$cid,$usid,$usid,0,'$idostr','$idostr')";
			//ha van updatelünk a szabályokra figyelve
			}else{					
				$sql = "UPDATE ceglista as c 
						LEFT JOIN portal__ceg as pc ON pc.ceg_id = c.cid
						SET pc.allapot=0, pc.adstatdat='".$idostr."', pc.uzletkid=".$usid." WHERE cid=".$cid." AND (pc.allapot=4 or pc.allapot=0)";
								
			}
			//die($sql);
			$a = mysql_query($sql) or die(mysql_error());
			
		}
		restart();

	break;
	case 'del1':	//a céget csak a munkakosárból törli. gazdátlan cég uzletkid=0, alapból nem hívott állapotú
		$cid=		( isset( $_REQUEST['cid'] ) )	  ? round($_REQUEST['cid'])	 	: 0; 
		$pid=		( isset( $_REQUEST['pid'] ) )	  ? round($_REQUEST['pid'])	 	: 0;
		$dat = getdate();
		$idostr = $dat['year']."-".$dat['mon']."-".$dat['mday'];
		$sql = "UPDATE ceglista as c
				LEFT JOIN portal__ceg as pc ON pc.ceg_id = c.cid
				SET c.moddat='$idostr',pc.uzletkid=0 
				WHERE pc.allapot<4 and pc.felvitte!=$usid and pc.uzletkid=$usid and pc.ceg_id=$cid AND pc.portal_id=$pid";
		$a = mysql_query($sql) or die(mysql_error()); 
		restart();		
	break;
	case 'add':	//cég hozzáadása
		$cegnev=	( isset( $_REQUEST['cegnev'] ) ) ? $_REQUEST['cegnev'] 		: false;
		$cim=		( isset( $_REQUEST['cim'] ) )  ? $_REQUEST['cim']	 	: false; 
		$telszam=	( isset( $_REQUEST['telszam'] ) )  ? $_REQUEST['telszam'] 	: false; 
		//megnézzük lett e portál kapcsolat postolva
		$uj = array();
		if($portalok) foreach($portalok as $p_k => $p_v){
			if(isset($_POST['portalok_'.$p_v]))$uj[]=$p_v;
		} 
		if (($cegnev!="") and ($cim!="") and ($telszam!="") and (count($uj)>0)){
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
				$sql = "INSERT INTO ceglista(cegnev,cim,uzletkid,felvdat,moddat,telszam,felvitte) VALUES('".addslashes($cegnev)."','".addslashes($cim)."',".$usid.",'".$idostr."','".$idostr."','".addslashes($telszam)."',".$usid.");";
				$res = mysql_query($sql) or die(mysql_error());
				$cid = mysql_insert_id();
				//portál kapcsolatok beillesztése
				foreach($uj as $k_p => $k_v) 
					mysql_query("INSERT INTO portal__ceg (ceg_id,portal_id,allapot,megj,adstatdat,pc_date,felvitte,uzletkid) VALUES($cid,$k_v,{$uj_data[$k_v]['allapot']},'{$uj_data[$k_v]['megj']}','$idostr','$idostr',$usid,$usid)")or die(mysql_error());
				restart();
			}
		}else{
			die ('Cégnevet, címet és telefonszámot meg kell adni!');
		}
	break;	
	case 'edit':	//cég szerkesztése
		$cegnev=	( isset( $_REQUEST['cegnev'] ) ) ? $_REQUEST['cegnev'] 		: false;
		$cim=		( isset( $_REQUEST['cim'] ) )  ? $_REQUEST['cim']	 	: false; 
	//	$allapot=	( isset( $_REQUEST['allapot'] ) )  ? $_REQUEST['allapot'] 	: false;
	//	$megj=		( isset( $_REQUEST['megj'] ) )	  ? $_REQUEST['megj']	 	: false; 
		$cid=		( isset( $_REQUEST['cid'] ) )	  ? $_REQUEST['cid']	 	: false;
		$telszam=	( isset( $_REQUEST['telszam'] ) )  ? $_REQUEST['telszam'] 	: false;  
		$uj = array();
		$pid = ( isset( $_REQUEST['pid'] ) )  ? $_REQUEST['pid'] 	: false;
		//ha mindent kitöltöttem mehet
		
		if (($cegnev!="") and ($cim!="") and ($cid!=0) and ($telszam!="") and $pid and $cid){
			$sql = "SELECT * from ceglista WHERE cegnev='".addslashes($cegnev)."' and cid!=".$cid;
			$res = mysql_query($sql) or die (mysql_error());
			if (mysql_num_rows($res) != 0){
				die('Cég már felvíve más által.');
			}else{	
				$st = mysql_query("SELECT portal_id, allapot FROM  portal__ceg WHERE ceg_id=".$cid) or die(mysql_error());
				$all = array();
				//ha bárhol olyan állapota van ami után már nem szerkeszthető akkor ne szerkessze
				$update_available = true;
				while($al = mysql_fetch_array($st)){
					$all[$al['portal_id']]=$al['allapot'];
					if($al['allapot']>=4)
						$update_available = false;
				}									
				if($update_available){
					$sql = "UPDATE ceglista SET telszam = '".addslashes($telszam)."' ,cegnev='".addslashes($cegnev)."' ,cim='".addslashes($cim)."' ";    			
					$sql.=" WHERE felvitte>0 and uzletkid=".$usid." and cid=".$cid;								
					$res = mysql_query($sql) or die(mysql_error());		
					//felvitte>0 azaz ha nem admin vitte fel akkor írhatja át ezeket a mezőket
				}
												
				//($all[$pid] != $_POST['allapot_'.$pid])
				if($_POST['allapot_'.$pid]>=4) die('Ehhez nincs jogosultsága');
				mysql_query('UPDATE portal__ceg 
							 SET allapot='.round($_POST['allapot_'.$pid]).',megj=\''.$_POST['megj_'.$pid].'\' '.( ($all[$pid] != $_POST['allapot_'.$pid])?',adstatdat = \''.date('Y-m-d').'\'':'' ).' 
							 WHERE ceg_id='.$cid.' AND portal_id='.$pid.' AND allapot<4 AND uzletkid='.$usid)or die(mysql_error());
				
					
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
		$sql = 'SELECT cid FROM ceglista as c
				LEFT JOIN portal__ceg as pc ON pc.ceg_id = c.cid 
				WHERE pc.uzletkid='.$usid;
		if (isset($_SESSION['felhasznalo']['szuro']) and $_SESSION['felhasznalo']['szuro']!=-1){
			$sql.=' and pc.allapot='.$_SESSION['felhasznalo']['szuro'];
		}
		if (isset($_SESSION['felhasznalo']['szurnev']) and $_SESSION['felhasznalo']['szurnev']!=''){
			$sql.=" and c.cegnev LIKE '%".addslashes($_SESSION['felhasznalo']['szurnev'])."%'";			
		}
		$sql.=" GROUP BY cid ";
		$s = mysql_query($sql) or die(mysql_error());
		$sorok = mysql_num_rows( $s );
	
		$perLap = 50;
		
		$sql = 'SELECT c.* FROM ceglista as c
				LEFT JOIN portal__ceg as pc ON pc.ceg_id = c.cid  
				WHERE pc.uzletkid='.$usid ;
		if (isset($_SESSION['felhasznalo']['szuro']) and $_SESSION['felhasznalo']['szuro']!=-1){
			$sql.=' and pc.allapot='.$_SESSION['felhasznalo']['szuro'];
			$smarty->assign( 'szuro', $_SESSION['felhasznalo']['szuro'] );
		}
		if (isset($_SESSION['felhasznalo']['szurnev']) and $_SESSION['felhasznalo']['szurnev']!=''){
			$sql.=" and c.cegnev LIKE '%".addslashes($_SESSION['felhasznalo']['szurnev'])."%'";
			$smarty->assign( 'szurnev', $_SESSION['felhasznalo']['szurnev'] );
		}
		$sql.= ' GROUP BY c.cid ORDER by moddat desc, cid desc LIMIT '.$tol.', '.$perLap;
		$q = mysql_query( $sql ) or die(mysql_error());

		$lapozas = tolokgeneralo( $sorok, $perLap, $tol );
		$ceg_ids='(0';
		while( $d = mysql_fetch_array( $q ) ){
			$ceg_ids.=','.$d['cid'];
			//$editable = ($d['allapot']<4) ? true : false;
			//$torl = ($d['felvitte']>0) ? true : false;
			//$torl1 = ($d['felvitte']!=$usid) ? true: false;
			$db[$d['cid']] = array( 
				'cid' 		=> $d['cid'],
				'cegnev' 	=> stripslashes($d['cegnev']),
				'cim'	 	=> stripslashes($d['cim']),
				'telszam' 	=> stripslashes($d['telszam']),
			//	'felvdat' 	=> $d['felvdat'],
				'moddat'	=> $d['moddat'],
			//	'allapot'	=> all2Str($d['allapot']),
			//	'uzletkid'	=> $d['uzletkid'],
			//	'adstatdat'	=> $d['adstatdat'],
			//	'megj'		=> stripslashes($d['megj']),
				'not_editable'	=> array(),
				'not_torl1'		=> array(),
				'not_torl'		=> array()
			);
		}
		$ceg_ids.=')';
		$res = mysql_query("SELECT pc.pc_date, p.portal_name, pc.ceg_id, pc.allapot, pc.adstatdat, pc.megj, pc.portal_id, pc.felvitte
							FROM portal__ceg as pc 
							LEFT JOIN portal as p ON p.portalid = pc.portal_id
							WHERE pc.ceg_id IN $ceg_ids AND pc.uzletkid = $usid
							ORDER BY pc_date ASC")or die(mysql_error());
		while($e = mysql_fetch_assoc($res)){
			$db[$e['ceg_id']]['p_connects'][$e['portal_id']]=$e['portal_name'];
			$db[$e['ceg_id']]['portal'][] = array('date'=>$e['pc_date'],
												  'name'=>stripslashes($e['portal_name']),
												  'megj'=>stripslashes($e['megj']),
												  'allapot'=>all2Str($e['allapot']),
												  'adstatdat'=>$e['adstatdat']	
											);
			//nem szerkeszthető az adott portálon
			if($e['allapot']>=4) 	 $db[$e['ceg_id']]['not_editable'][] = $e['portal_id'] ;
			//nem lledobható az adott portálon
			if($e['felvitte']==$usid)$db[$e['ceg_id']]['not_torl1'][] = $e['portal_id'];
			//nem törölhető az adott portálon
			if($e['felvitte']==0)	 $db[$e['ceg_id']]['not_torl'][] = $e['portal_id'];
		}	
		//ami nem szerkeszthető, nem is ledobható és nem is törölhető az adott portálon
		foreach($db as $k=>&$v){
			$v['not_torl1'] = array_unique(array_merge($v['not_torl1'],$v['not_editable']));
			$v['not_torl'] = array_unique(array_merge($v['not_torl'],$v['not_editable']));
		}	
		$smarty->assign( 'db', $db );
		$smarty->assign( 'pager', $lapozas );
	break;
}
$smarty->assign( 'niceTable', 'true' );
$tartalom=$smarty -> fetch( "manager_cegeim.tpl" );
require(_DISPLAY_ADMIN);
?>
