<?php

require_once('config/config.php');

if (!($_SESSION['felhasznalo']['admin'])){
	header('Location:manager_login.php');
}

db_Connect();

$tol = 		( isset( $_GET['tol'] ) )  ? $_GET['tol']	 	: 0; 
$mire =		( isset( $_REQUEST['mire'] ) ) 	  ? $_REQUEST['mire'] 	: false;
if ($mire){
	$_SESSION['felhasznalo']['mire'] = $mire;
}
if($_SESSION['felhasznalo']['mire']==0){
	$_SESSION['felhasznalo']['mire']=4;
}
$smarty->assign( 'mire', $_SESSION['felhasznalo']['mire'] );

if(isset( $_REQUEST['regdatK'] ) ){
	$_SESSION['felhasznalo']['kregdatS'] = $_REQUEST['regdatK'];
}
if(isset( $_REQUEST['regdatV'] ) ){
	$_SESSION['felhasznalo']['kregdatVS'] = $_REQUEST['regdatV'];
}

$feltet="";
$feltet1="";
if (isset($_SESSION['felhasznalo']['kregdatS'])and $_SESSION['felhasznalo']['kregdatS']!=""){
	$feltet.=" and pc.adstatdat >= '".addslashes($_SESSION['felhasznalo']['kregdatS'])."'";
	$feltet1.=" and pc.adstatdat >= '".addslashes($_SESSION['felhasznalo']['kregdatS'])."'";
	$smarty->assign('k_regk',$_SESSION['felhasznalo']['kregdatS']);
}
if (isset($_SESSION['felhasznalo']['kregdatVS'])and $_SESSION['felhasznalo']['kregdatVS']!=""){
	$feltet.=" and pc.adstatdat <= '".addslashes($_SESSION['felhasznalo']['kregdatVS'])."'";
	$feltet1.=" and pc.adstatdat <= '".addslashes($_SESSION['felhasznalo']['kregdatVS'])."'";
	$smarty->assign('k_regv',$_SESSION['felhasznalo']['kregdatVS']);
}

		
		$db = array();
		$sql = "SELECT user.usid 
				FROM ceglista 
				LEFT JOIN user ON ceglista.uzletkid = user.usid 
				LEFT JOIN portal__ceg as pc ON pc.ceg_id = ceglista.cid								
				WHERE 1 ".$feltet." and pc.allapot=".$_SESSION['felhasznalo']['mire']." 
				GROUP BY usid";
//		die($sql);
		//lapozó dolgai
		$s = mysql_query($sql) or die('0'.mysql_error());
		$sorok = mysql_num_rows( $s );
		
		$perLap = 1;
		$lapozas = tolokgeneralo( $sorok, $perLap, $tol );
		//lista lekérdezése
		$sql = 'SELECT count(*) as db, 
				user.usname, user.usemail, user.usid 
				FROM user 
				LEFT JOIN ceglista ON ceglista.uzletkid = user.usid
				LEFT JOIN portal__ceg as pc ON pc.ceg_id = ceglista.cid								
				WHERE ceglista.uzletkid>0 '.$feltet.' and pc.allapot='.$_SESSION['felhasznalo']['mire']." 
				GROUP BY user.usname" ;
		$sql.= ' ORDER by db desc LIMIT '.$tol.', '.$perLap;
	//die($sql);
		$q = mysql_query( $sql ) or die('1'.mysql_error().'<br>'.$sql);

		while( $d = mysql_fetch_array( $q ) ){
		        
		//	die("SELECT * FROM ceglista WHERE 1 ".$feltet1." and uzletkid=".$d['usid']." and allapot=".$_SESSION['felhasznalo']['mire']." ORDER BY adstatdat DESC");
			$qq = mysql_query("SELECT ceglista.cid, ceglista.cegnev, ceglista.cim, ceglista.telszam, ceglista.felvdat, ceglista.moddat, p.portal_name , pc.adstatdat,pc.megj,pc.pc_date
							   FROM ceglista
							   LEFT JOIN portal__ceg as pc ON pc.ceg_id = ceglista.cid
							   LEFT JOIN portal as p ON p.portalid = pc.portal_id
							   WHERE 1 ".$feltet1." and ceglista.uzletkid=".$d['usid']." and pc.allapot=".$_SESSION['felhasznalo']['mire']." ORDER BY pc.adstatdat DESC") or die(mysql_error());
			$lista = array();
			while($z = mysql_fetch_array($qq)){
				$lista[] = array( 
				'cid' 		=> $z['cid'],
				'cegnev' 	=> stripslashes($z['cegnev']),
				'cim'	 	=> stripslashes($z['cim']),
				'telszam' 	=> stripslashes($z['telszam']),
				'felvdat' 	=> $z['felvdat'],
				'moddat'	=> $z['moddat'],
				'adstatdat'	=> $z['adstatdat'],
				'megj'		=> stripslashes($z['megj']),
				'portal_name'	=> stripslashes($z['portal_name']),
				'pc_date'	=> stripslashes($z['pc_date']),				
				);
			}
			$db[] = array( 
				'usname'=> stripslashes($d['usname']),
				'usemail'=> stripslashes($d['usemail']),
				'db'	=> $d['db'],
				'cegek' => $lista
			);
		}
		$smarty->assign( 'db', $db );
		$smarty->assign( 'pager', $lapozas );


$smarty->assign( 'niceTable', 'true' );
$tartalom=$smarty -> fetch( "manager_stat.tpl" );
require(_DISPLAY_ADMIN);
?>
