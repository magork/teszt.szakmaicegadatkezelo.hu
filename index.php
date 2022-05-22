<?php 
header('content-type: text/html; character-set: utf-8');
session_start();

$auth = ( isset( $_SESSION['auth'] ) ) ? $_SESSION['auth'] : 'nope';
$cid = ( isset( $_SESSION['cid'] ) ) ? $_SESSION['cid'] : 'nope';

// DOMAIN CHECK
if( strpos( $_SERVER['SERVER_NAME'], 'information' ) !== false ) $logo = '_id';
else $logo = '';

// TITLE SETTING
$title = ( $logo == '' ) ? 'Uniós Tudakozó' : 'European Information Database';

// DEFAULT LANGUAGE
$defLang = ( $logo == '' ) ? 'hu' : 'en';

// SET LANGUAGE
$_SESSION['lang'] = ( isset( $_SESSION['lang'] ) ) ? $_SESSION['lang'] : $defLang;
$lang = $_SESSION['lang'];


//
	include('data/dict.php');
	include('config/config.php');
	//include('admin/src/mainframe.class.php');	
	require_once "admin/src/mainframe.class.php";
	


try {
    // connect
	$connection = mysqli_connect(_MYDB_HOST, _MYDB_USER,_MYDB_PASS,_MYDB_DATABASE);
	$sql = "SELECT id, user, pass FROM felhasznalok";
	$result = $connection->query($sql);
	var_dump($result->fetch_assoc());

  
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
exit();
}
$do = isset( $_GET['do'] ) ? $_GET['do'] : 'default';
// if( $do == 'comp_list' || $do == 'comp_search' ){

// 	include('pagina.class.php');
// 	$pages = new MyPagina;

// } else{

// 	include('mysql/connect.php');
// 	include( _PATH_CORE_EZRESULTS );
// 	$ezr = new ez_results;

// }

// $main = new mainframe;

//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Magyar Vállalkozás Kezelő</title>
  <meta name="robots" content="index, follow" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8;" />
  <meta name="author" content="RapidxHTML" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/lightbox.css" rel="stylesheet" type="text/css" />
  <!--[if lte IE 7]><link href="css/iehacks.css" rel="stylesheet" type="text/css" /><![endif]-->
  <script type="text/javascript" src="js/mootools.js"></script>
  <script type="text/javascript" src="js/litebox-1.0.js"></script>
  <!--[if IE 6]>
  <script type="text/javascript" src="js/ie6pngfix.js"></script>
  <script type="text/javascript">
    DD_belatedPNG.fix('img, ul, ol, li, div, p, a, h1, h2, h3, h4, h5, h6');
  </script>
  <![endif]-->
 <link rel="shortcut icon" href="favicon.ico?11" type="image/x-icon">
<script>
function submitFrom( q, type ){
	if( $('q') ) $( 'q' ).value = q;
	$( 'type' ).value = type;
	$( 'searchform' ).submit();
}

function draw_map(id, address, theId ) {
	 this.id = theId;
	 var pass = this;
	 this.map = new GMap2(document.getElementById(id));

		 var geocoder = new GClientGeocoder();
		
		 function showAddress(address) {
			 geocoder.getLatLng(
			 address,
			 function(point) {
				 if (!point) {
				 // alert(address + " not found");
				 } else {
					map.setCenter(point, 15);
					var marker = new GMarker(point);
					map.addOverlay(marker);
					marker.bindInfoWindowHtml($( 'googleinfo' ).innerHTML);
					marker.openInfoWindowHtml($( 'googleinfo' ).innerHTML);
				 }
			 }
			 );
		 }
		 showAddress(address);
}
</script>
<?php if( isset( $_GET['do'] ) ){ if( $_GET['do'] == 'comp_show' ){ ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=AIzaSyDHAetJf3O52QDuaa5ilpcPLDTxsUelXrM"type="text/javascript"></script>
<?php }} ?>

</head>

<body>

<!-- wrapper -->
<div class="rapidxwpr floatholder">

  <!-- header -->
  <div id="header">
  
  	<div style="text-align:right">
			<?php if( $lang !== 'hu' ){ ?><a href="switch_lang.php?lang=hu"><img src="images/hu.gif" /></a><?php } ?>
			<?php if( $lang !== 'en' ){ ?><a href="switch_lang.php?lang=en"><img src="images/gb.gif" /></a><?php } ?>
			<?php if( $lang !== 'de' ){ ?><a href="switch_lang.php?lang=de"><img src="images/de.gif" /></a><?php } ?>
	</div>


		
    <!-- logo -->
    <a href="index.php"><img id="logo" class="correct-png" src="images/logo.png" alt="Home" title="Home" /></a>
    <!-- / logo -->

	<div id="search">
		<form action="index.php" id="searchform" method="get" enctype="application/x-www-form-urlencoded">
			<input type="text" name="q" value="<?=$dict[$lang]['search']?>..." id="free" style="background-color:#FCF5D8;" onclick="if(this.value == '<?=$dict[$lang]['search']?>...') this.value=''" onblur="if(this.value == '') this.value =  'Keresés...'" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="" onclick="submitFrom( $('free').value, 'free' )" id="btn"><br />
			<input type="hidden" name="type" value="free" id="type" />
			<input type="hidden" name="do" value="comp_search" id="type" />
		</form>
	</div>

    <!-- topmenu -->
    <div id="topmenu">
			<ul>
				<li><a href="index.php"><span><?=$dict[$lang]['home']?></span></a></li>	
				<li><a href="?do=search"><span><?=$dict[$lang]['advsearch']?></span></a></li></li>
				<li><a href="?do=about"><span><?=$dict[$lang]['about']?></span></a></li>
				<li><a href="?do=register"><span><?=$dict[$lang]['register']?></span></a></li>
			</ul>
	
    </div> 
	
    <!-- / topmenu -->


  </div>
  <!-- / header -->
 
  <!-- main body -->
  <div id="middle">
  
    <!-- main image -->
    <div class="main-image">
      <img src="images/main-image.jpg" alt="Image" />
    </div>
    <!-- / main image -->


    <div id="main" class="clearingfix">
      <div id="mainmiddle" class="floatbox">
      
    <?php
			/***************************************************************************************************************************
			
													CONTROLLER SECTION
			***************************************************************************************************************************/
		var_dump($do)
				switch( $do ){
		
					case "default":
							echo '<h1>'.$dict[$lang]['tev'].'</h1>';
							//$main->init();
					break;

					case "comp_list":
							$parent = ( isset($_GET['parent']) ) ? $_GET['parent'] : '';
							$main->comp_list( $_GET['cat'], $_GET['cat_name'], $parent );
					break;
		
					case "comp_show":
							$main->comp_show( $_GET['cid'], $_GET['cname'] );
					break;
		
					case "comp_search":
							$cname = ( isset($_GET['cname']) ) 	? 	$_GET['cname'] : '';
							$cat = ( isset($_GET['cat']) ) 		? 	$_GET['cat'] : '';
							$city = ( isset($_GET['city']) ) 	? 	$_GET['city'] : '';
							$iso = ( isset($_GET['iso']) ) 		? 	$_GET['iso'] : '';
							$brand = ( isset($_GET['brand']) ) 	? 	$_GET['brand'] : '';
							$region = ( isset($_GET['region'])) ?	$_GET['region'] : '';
							//
							$type = ( isset($_GET['type']) ) ? $_GET['type'] : '';
							// Felső kereső:
							$key = ( isset($_GET['q']) ) ? $_GET['q'] : '';
							//
							$main->comp_search( urlencode($cname),urlencode($cat),urlencode($city),urlencode($iso),urlencode($brand),urlencode($region), $type, $key );
							//
					break;
		
					case "search":
							$output = include('tpl/search.tpl');
					break;
		
					case "about":
							$output = include('tpl/about.tpl');
					break;
		
					case "register":
							$output = include('tpl/reg.tpl');
					break;
		
					case "auth_failed":
							echo "<br><br><strong>A belépés sikertelen volt...</strong>";
					break;
		
					case "send_reg":
							$message = "<h3>Cég neve:</h3> " . $_POST['comp'] ."\n<h3>Regisztráló neve:</h3> " . $_POST['user'] ."\n<h3>Telefonszáma:</h3> ". $_POST['tel'];
		/*
							if( mail( 'cs.zotya@freemail.hu', 'Új regisztráció', $msg ) ){
								echo"<p>&nbsp;</p>Köszönjük.<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>"; 
							} else {
								echo"Hiba lépett fel, kérjük próbálja meg később.";
							}
							*/    
  /*require_once('recaptchalib.php');
  $privatekey = "6Ld4tMgSAAAAAEGu4ZKFy_xGonIrjvOD2isMkSFO";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("Hibás ellenőrző kód!");
  } else {
*/
if(($_POST['comp'] != "") && ($_POST['user'] != "") && ($_POST['tel'] != "") && ($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code'])))
{

							require("phpmailer/class.phpmailer.php");

							$mail = new phpmailer();

							$mail->CharSet  = "utf-8";
							$mail->From     = 'regisztracio@magyaruzletitudakozo.hu';
							$mail->FromName = "Magyar Üzleti Tudakozó";
							$mail->Mailer   = "mail";
							$mail->Subject  = "Új regisztráció érkezett";

							// HTML body
							$body = $message;
						
							// Plain text body (for mail clients that cannot read HTML)
							$text_body  = strip_tags( $message );
						
							$mail->Body    = $body;
							$mail->AltBody = $text_body;
							$mail->AddAddress( 'regisztracio@magyaruzletitudakozo.hu', 'Web');						
							//$mail->AddAddress( 'tszasz@gmail.com', 'Kow');						
							
							if(!$mail->Send()) echo "para van";
echo "Levelét elküldtük.";
}
else
{
echo "Nem töltött ki minden mezőt. Kérjük, minden adatot adjon meg.";
}
						
						
					break;
					/* 
					 *****B2B SYSTEM*****
										*/
		
					case "b2b_list":
							$main->b2b_list( $_GET['type'] );
					break;
		
					case "b2b_add":
							$main->b2b_add( $cid );
					break;
					
					case "b2b_myoffers":
							$main->b2b_myoffers( $cid );
					break;
		
					case "b2b_parse":
							//$fejlec, $offer, $cID, $type
							$main->b2b_parse($_POST['fejlec'], $_POST['szoveg'], $cid, $_POST['type'], $_POST['cat'] );
					break;
		
					case "b2b_search":
							$main->b2b_search();
					break;
					
                    case "partners":
include("partners.txt");
                    break;

				}
				//include('Mail.php');
		
			?>

		</div>	 
 
				
      </div>
  
  </div>
  <!-- / main body -->

</div>
<!-- / wrapper -->
  </div>

        <div id="login" align="center">
        <?php

        if( $auth !== 'nope' )
		{
			echo'<a href="?do=b2b_add" class="topmenu">Ajánlat beküldése</a> ';
			echo'<a href="?do=b2b_myoffers" class="topmenu">Ajánlataim</a> ';
			echo'<a href="logout.php" class="topmenu">Kilépés</a>';
			echo'<script>$("login").style.display="block";$("login").style.height = "30px"</script>';
		}
        ?>
        </div>

<div align="center">

<!-- footer -->

<div class="rapidxwpr floatholder">
  <div id="footer" class="clearingfix">
  
    <!-- footermenu -->
			<ul class="footermenu">
				<li><a href="index.php" class="menu"><?=$dict[$lang]['home']?></a></li>	
				<li><a href="?do=search" class="menu"><?=$dict[$lang]['advsearch']?></a></li></li>
				<li><a href="?do=about" class="menu"><?=$dict[$lang]['about']?></a></li>
				<li><a href="?do=register" class="menu"><?=$dict[$lang]['register']?></a></li>
				<li><a href="?do=partners" class="menu">&Aacute;SZF</a></li>
			</ul>

    <!-- / footermenu -->
    
  </div>
</div>				
<!-- / footer -->

</body>
</html>
