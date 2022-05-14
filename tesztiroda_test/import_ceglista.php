<?php
	require_once('config/config.php');
	if ($_SESSION['felhasznalo']['admin'] == false){
		die("First login as admin please!");
		header('Location:manager_login.php');
	}			
	
    //print ini_get('max_execution_time');
    
    
    
	class ceglistaImport{
		
		private $user_switch;	
		private $cegek_switch; 	
	 	private $user_in;
	 	private $ceglista_in;
	 	private $res_users;
	 	private $res_cegek;
	 	private $fdbase;
	 	private $tdbase;
	 	private $portal;
		
		public function __construct($fdbname,$fdbuser,$fdbpass,$fdbhost,$tdbname,$tdbuser,$tdbpass,$tdbhost,$_portal){
			$this->portal = $_portal;	
			
			$this->fdbase = $this->connectToDb($fdbname,$fdbuser,$fdbpass,$fdbhost);
			$this->tdbase = $this->connectToDb($tdbname,$tdbuser,$tdbpass,$tdbhost);				
			$this->user_switch = array();	
			$this->cegek_switch = array();		
			$this->user_in = array();
			$this->ceglista_in = array();
			
			$res = mysql_query('SELECT * FROM portal WHERE portal_name LIKE \''.$this->portal.'\' ',$this->tdbase)or die(mysql_error());
			if(mysql_num_rows($res)>0){
				die('A portal nev mar foglalt! Kerlek allitsd be a megfelelo parametereket!<br/>');
			}
			
			$this->getList();
				
			$this->merge();
			
			$this->insert();
			
		}			
		
		private function connectToDb($dbname,$user,$pass,$host){		
			$conn = 0;
		   	$runner = 0;
		   	$dbOK = false;
		   	while ($runner<10){		
				if($conn = mysql_connect($host, $user, $pass)){			
					mysql_select_db($dbname,$conn);
					$dbOK = true;
					break;		
				}
		       	$runner++;
		   	}		
		   	if ( $dbOK == false ){				    	
		        die("DB connection problem: ".$dbname);	
		   	}				  
			return $conn;
		}
	
		private function getList(){							
	 		$this->res_users = mysql_query('SELECT * FROM user',$this->fdbase)or die(mysql_error());		 			 		
	 		$this->res_cegek = mysql_query('SELECT * FROM ceglista',$this->fdbase)or die(mysql_error());	 		
	 		mysql_close($this->fdbase);			
		}
		
		private function merge(){						
			//userek
			$tmp = mysql_query('SELECT MAX(usid) FROM user',$this->tdbase)or die(mysql_error());
			$usOffset = mysql_fetch_row($tmp);
			$usOffset = $usOffset[0]+100;		
			while($e = mysql_fetch_assoc($this->res_users)){				
				$tmp = mysql_query('SELECT usid FROM user WHERE usname LIKE \''.addslashes($e['usname']).'\' ',$this->tdbase)or die(mysql_error());
				if(mysql_num_rows($tmp)>0){
					$old = mysql_fetch_row($tmp);
					$old = $old[0];
					$this->user_switch[$e['usid']] = $old;
					$e['usid'] = $old;
				}else{
					$e['usid']+=$usOffset;
					$this->user_in[] = $e;
				}				
			}
			$this->res_users = null;
			//ceglisták
			$tmp = mysql_query('SELECT MAX(cid) FROM ceglista',$this->tdbase)or die(mysql_error());
			$cegOffset = mysql_fetch_row($tmp);
			$cegOffset = $cegOffset[0]+100;
			while($e = mysql_fetch_assoc($this->res_cegek)){
				$tmp = mysql_query('SELECT cid FROM ceglista WHERE cegnev LIKE \''.addslashes($e['cegnev']).'\' ',$this->tdbase)or die(mysql_error());
				if(mysql_num_rows($tmp)>0){
					$old = mysql_fetch_row($tmp);
					$old = $old[0];	
					$this->cegek_switch[] = $old;				
					$e['cid'] = $old;
				}else{
					$e['cid']+=$cegOffset;
				}
				if($e['uzletkid']>0){
					if(isset($this->user_switch[$e['uzletkid']])){
						$e['uzletkid'] = $this->user_switch[$e['uzletkid']];
					}else{
						$e['uzletkid'] += $usOffset;
					}
				}
				if($e['felvitte']>0){
					if(isset($this->user_switch[$e['felvitte']])){
						$e['felvitte'] = $this->user_switch[$e['felvitte']];
					}else{
						$e['felvitte'] += $usOffset;
					}
				}
				$this->ceglista_in[] = $e;
			}
			$this->res_cegek = null;
		}
		
		private function insert(){	
		  /*  var_dump($this->fdbase);
            var_dump($this->tdbase);
		    var_dump(count($this->ceglista_in));
            var_dump(count($this->user_in));
            exit();*/
			$pid = 0;		
			mysql_query('INSERT INTO portal (portal_name) VALUES(\''.$this->portal.'\')',$this->tdbase) or die(mysql_error()) ;
			$pid = mysql_insert_id($this->tdbase);
            print $pid;
            if(!$pid)die('ajjajj');
			foreach($this->user_in as $k=>$v){
				mysql_query("INSERT INTO user(usid,usemail,usname,uspass,uslim) VALUES(".addslashes($v['usid']).",'".addslashes($v['usemail'])."','".addslashes($v['usname'])."','".addslashes($v['uspass'])."',".addslashes($v['uslim']).")",$this->tdbase) or die(mysql_error()) ;
			}
			foreach($this->ceglista_in as $k=>$v){
				if(!in_array($v['cid'],$this->cegek_switch)){
					mysql_query("INSERT INTO ceglista(cid,cegnev,cim,uzletkid,felvdat,moddat,telszam,felvitte,allapot,megj,adstatdat) VALUES(".addslashes($v['cid']).",'".addslashes($v['cegnev'])."','".addslashes($v['cim'])."',".addslashes($v['uzletkid']).",'".addslashes($v['felvdat'])."','".addslashes($v['moddat'])."','".addslashes($v['telszam'])."',".addslashes($v['felvitte']).",".addslashes($v['allapot']).",'".addslashes($v['megj'])."','".addslashes($v['adstatdat'])."')",$this->tdbase) or die(mysql_error()) ;
				}
				mysql_query("INSERT INTO portal__ceg(portal_id,ceg_id,allapot,megj,adstatdat,pc_date,uzletkid,felvitte) VALUES(".addslashes($pid).",".addslashes($v['cid']).",".addslashes($v['allapot']).",'".addslashes($v['megj'])."','".addslashes($v['adstatdat'])."','".addslashes($v['felvdat'])."',".addslashes($v['uzletkid']).",".addslashes($v['felvitte']).")",$this->tdbase) or die(mysql_error()) ;				
			}
			mysql_close($this->tdbase);
		}
		
		public function __destruct(){
			$this->user_in = null;
	 		$this->ceglista_in = null;
	 		$this->user_switch = null;	
	 		if($this->fdbase)mysql_close($this->fdbase);
	 		if($this->tdbase)mysql_close($this->tdbase);
	 		print "<h1>Done</h1>";
		}
		
	}

	
	
	
	die('<h1>Please Config First!</h1>');
	
	/**
	 * Parameter list:
	 *from databasename, user, pasword, host
	 *to databasename, user, pasword, host
	 *portal name
	 */
	$cli = new ceglistaImport('uzleti','uzleti1','uzleti','localhost',
							  'uzleti_master','uzleti','uzleti','localhost',					   		  
					   		  'Üzleti cégtudakozó');
    unset($cli);
	
	$cli = new ceglistaImport('uzleti_unios','uzleti1','uzleti','localhost',
							  'uzleti_master','uzleti','uzleti','localhost',					   		  
					   		  'Uniós tudakozó');
    unset($cli);
	
	$cli = new ceglistaImport('uzleti','uzleti1','uzleti','localhost',
							  'uzleti_master','uzleti','uzleti','localhost',					   		  
					   		  'Alapítvány tudakozó');
    unset($cli);
	
	$cli = new ceglistaImport('uzleti_alapitvany','uzleti1','uzleti','localhost',
							  'uzleti_master','uzleti','uzleti','localhost',					   		  
					   		  'Alapítvány tudakozó');
    unset($cli);
   	$cli = new ceglistaImport('uzleti_etterem','uzleti1','uzleti','localhost',
							  'uzleti_master','uzleti','uzleti','localhost',					   		  
					   		  'Étterem tudakozó');
    unset($cli);
    $cli = new ceglistaImport('uzleti_fogorvos','uzleti1','uzleti','localhost',
							  'uzleti_master','uzleti','uzleti','localhost',					   		  
					   		  'Fogorvos tudakozó');
    unset($cli);
    $cli = new ceglistaImport('uzleti_intezmeny','uzleti1','uzleti','localhost',
							  'uzleti_master','uzleti','uzleti','localhost',					   		  
					   		  'Intézmény tudakozó');
    unset($cli);
    $cli = new ceglistaImport('uzleti_orvos','uzleti1','uzleti','localhost',
							  'uzleti_master','uzleti','uzleti','localhost',					   		  
					   		  'Orvos tudakozó');
    unset($cli);
    $cli = new ceglistaImport('uzleti_szallas','uzleti1','uzleti','localhost',
							  'uzleti_master','uzleti','uzleti','localhost',					   		  
					   		  'Szállás tudakozó');
    unset($cli);		
?>