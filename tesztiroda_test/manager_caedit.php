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
/*$allapot=	( isset( $_REQUEST['allapot'] ) )  ? $_REQUEST['allapot'] 	: false;*/
/*$megj=		( isset( $_REQUEST['megj'] ) )	  ? $_REQUEST['megj']	 	: false; */
$cid=		( isset( $_REQUEST['cid'] ) )	  ? $_REQUEST['cid']	 	: false;
/*$uzletkid=	( isset( $_REQUEST['uzletkid'] ) )  ? $_REQUEST['uzletkid']	 : false; */ 
$telszam=	( isset( $_REQUEST['telszam'] ) )  ? $_REQUEST['telszam']	 : false; 

//portálok lekérdezése
$res_p = mysql_query("SELECT portalid FROM portal WHERE 1")or die(mysql_error());
$portalok = array();
while($e_p = mysql_fetch_row($res_p)){
	$portalok[] = $e_p[0];
}

//megnézzük lett e portál kapcsolat postolva
$uj = array();
$uj_data = array();
if($portalok) foreach($portalok as $p_k => $p_v){
	if(isset($_POST['portalok_'.$p_v])){
		$uj[]=$p_v;
		$uj_data[$p_v]['allapot']=round($_POST['allapot_'.$p_v]);
		$uj_data[$p_v]['megj']=addslashes($_POST['megj_'.$p_v]);
		$uj_data[$p_v]['uzletkid']=addslashes($_POST['uzletkid_'.$p_v]);
	}
	
}
/*print_r($uj_data);
exit();*/

switch( $event ){
case 'del':	//cég végleges törlése
	$sql = "DELETE FROM ceglista WHERE cid=".$cid;
	$a = mysql_query($sql) or die(mysql_error()); 
	//portál kapcsolatokat is törli
	$sql = "DELETE FROM portal__ceg WHERE ceg_id=".$cid;
	$a = mysql_query($sql) or die(mysql_error()); 
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
			$st = mysql_query("SELECT portal_id, allapot FROM  portal__ceg WHERE ceg_id=".$cid) or die(mysql_error());
			$all = array();
			while($al = mysql_fetch_array($st)){
				$all[$al['portal_id']]=$al['allapot'];
			}	
			$dat = getdate();
			$idostr = $dat['year']."-".$dat['mon']."-".$dat['mday'];			
			//$sql = "UPDATE ceglista SET telszam = '".addslashes($telszam)."', uzletkid =".$uzletkid.",moddat='".$idostr."',cegnev='".addslashes($cegnev)."',cim='".addslashes($cim)."',megj='".addslashes($megj)."',allapot=".$allapot;
			//if ($allapot == 4) $sql.=", felvitte=0 ";
			//if ($allapot != $all) $sql.=", adstatdat='".$idostr."' ";
			$sql = "UPDATE ceglista SET telszam = '".addslashes($telszam)."', moddat='".$idostr."',cegnev='".addslashes($cegnev)."',cim='".addslashes($cim)."'"; 
			$sql.=" WHERE cid=".$cid;
			$res = mysql_query($sql) or die(mysql_error());
			//régi portál kapcsolatok értékek
			$rs = mysql_query("SELECT portal_id FROM portal__ceg WHERE ceg_id=$cid")or die(mysql_error());
			$regi = array();
			while($e = mysql_fetch_row($rs))$regi[]=$e[0];
			//törlendő kapcsolatok törlése
			$del = array_diff($regi,$uj);
			foreach($del as $k_p => $k_v) 
				mysql_query("DELETE FROM portal__ceg WHERE ceg_id=$cid AND portal_id=$k_v")or die(mysql_error);
			//beillesztendő kapcsolatok beillesztése
			$ins = array_diff($uj,$regi);
			foreach($ins as $k_p => $k_v) 
				mysql_query("INSERT INTO portal__ceg (ceg_id,portal_id,allapot,megj,adstatdat,pc_date,uzletkid) VALUES($cid,$k_v,{$uj_data[$k_v]['allapot']},'{$uj_data[$k_v]['megj']}','$idostr','$idostr','{$uj_data[$k_v]['uzletkid']}')")or die(mysql_error());
			//frissítendő elemek
			$upd = array_intersect($uj,$regi);
			foreach($upd as $k_p=>$k_v){
				$sql = "UPDATE portal__ceg SET megj='{$uj_data[$k_v]['megj']}',allapot='{$uj_data[$k_v]['allapot']}',uzletkid='{$uj_data[$k_v]['uzletkid']}'";
				if($uj_data[$k_v]['allapot']==4)$sql.=",felvitte=0";
				if($uj_data[$k_v]['allapot']!=$all[$k_v])$sql.=",adstatdat='$idostr' ";
				$sql.=" WHERE ceg_id=$cid AND portal_id=$k_v ";
				mysql_query($sql)or die(mysql_error());
			}			
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
			$sql = "INSERT INTO ceglista(cegnev,cim,felvdat,moddat,telszam,felvitte) VALUES('".addslashes($cegnev)."','".addslashes($cim)."','".$idostr."','".$idostr."','".addslashes($telszam)."',0);";
			$res = mysql_query($sql) or die(mysql_error());
			$cid = mysql_insert_id();
			//portál kapcsolatok beillesztése
			foreach($uj as $k_p => $k_v) 
				mysql_query("INSERT INTO portal__ceg (ceg_id,portal_id,allapot,megj,adstatdat,pc_date,uzletkid) VALUES($cid,$k_v,{$uj_data[$k_v]['allapot']},'{$uj_data[$k_v]['megj']}','$idostr','$idostr',0)")or die(mysql_error());
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
	$_SESSION['felhasznalo']['kportalok'] = "";

//csak a módosított cég mutatása
header('Location:manager_kereso.php?cid='.$cid);
?>