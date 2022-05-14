<?php

if( $_SESSION['auth'] == 1 ){
/*
include("src/admin.class.php");
include("../config/config.php");
include("../mysql/connect.php");
include( _PATH_CORE_EZRESULTS );
*/
$admin = new admin;
$ezr = new ez_results;
$regions = $admin->get_regions();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>-BIZDIR::ADMIN::PANEL-</title>
<style type="text/css">
<!--
img{
	border: 0px;
}
body {
	font-family:Arial, Helvetica, sans-serif;
	background-color: #5599FF;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(../images/stripes.gif);
	color: #333333;
	font-size: 12px;
}
input{
	margin: 0px;
}

ul{
	list-style-type: none;
	background-color:#fff;
	width: 230px;
	padding: 10px;
	float: left;
}
u{
	font-size: 14px;
	font-weight: bold;
	color: #CC0000;
}
hr{
	width: 70%;
	height: 1px;
	border: 0px;
	background-color:#aaa;
}
/* //////////////////////////////////////////////////// */
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #009900;
}
a:hover {
	text-decoration: none;
	color: #009900;
}
a:active {
	text-decoration: none;
	color: #009900;
}
#menu {
	padding: 12px;
	height: auto;
	width: 97%;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #00CC00;
	background-color: #FFFFFF;
	border-bottom-width: 7px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
	text-align: left;
	vertical-align: middle;
}
.padding {
	width:95%;
	padding: 20px;
}
a.cat{
	color:#000000;
	font-size:14px;
}
a.cat:hover{
	color:#009900;
	font-size:14px;
}

a.blk{
	padding: 5px;
	background-color:#000000;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
a.blk:HOVER{
	color: #FF9900;
	top: 3px;
	padding-bottom: 8px;
}
tr.tr_head{
	background-color: #990000;
	color:#FFFFFF;
	font-weight:bold;
	display: table-row;
}
tr.row{
	background-color: #ffffff;
	color:#444;
	overflow: hidden;
	display: table-row;
}
#sublist{
	float: left;
}

#formme{
	clear: left;
	padding: 10px;
	width: 480px;
	color: #FFFFFF;
	background-color:#990000;
}
#oszlop{
	float: left;
	width: 125px;
}
-->
</style>
<script type="text/javascript">

function toggle(obj) {
	var el = document.getElementById(obj);
	if ( el.style.display != 'none' ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
}

function modify( ajdi ) {
	var NewStr = document.getElementById( 'c' + ajdi).value;
	document.location = 'index.php?do=category_edit&str=' + NewStr + '&id=' + ajdi;
}

function deleteIt( id, name ){
	if ( confirm( 'Biztos, hogy törlöd a ' + name + ' céget?' ) ){
		document.location = 'index.php?do=comp_delete&id=' + id;
	}
}

function deleteCat( id, name ){
	if ( confirm( 'Biztos, hogy törlöd a ' + name + ' kategóriát?' ) ){
		document.location = 'index.php?do=category_delete&id=' + id;
	}
}

function deleteOffer( id ){
	if ( confirm( 'Biztos, hogy törlöd az ajánlatot?' ) ){
		document.location = 'index.php?do=b2b_del&id=' + id;
	}
}
function reactivateOffer( id ){
	if ( confirm( 'Biztos, hogy újra aktiválod ajánlatot?' ) ){
		document.location = 'index.php?do=b2b_reactivate&id=' + id;
	}
}
function checkBoxes(){
	var boxes = document.getElementsByTagName('input');
	var counter = 0;
	for(i=0; i < boxes.length; i++)
	{
			if( boxes[i].type == 'checkbox' && boxes[i].checked == true ){
				counter++
			}
	}
	if ( counter == 0 ){
		alert( "Katergóriát kötelező megadni" )
		return false;
	} else {
		return true;
	}
}
</script>
</head>

<body>
<div id="menu">
<form action="index.php">
	<input type="hidden" name="do" value="comp_list">
	<input type="text" name="q"><input type="submit" value="keresés">
</form>

<?php

  if( $_SESSION['who'] == 'S' ) 
	echo'<p><a href="?do=order_list"><img src="img/categories.png" width="48" height="48" border="0" align="absmiddle">Sorrendek </a><a href="?do=category_list"><img src="img/categories.png" width="48" height="48" border="0" align="absmiddle">Kateg&oacute;ri&aacute;k  </a><a href="?do=comp_list"><img src="img/addedit.png" width="48" height="48" border="0" align="absmiddle">Cégek  </a><a href="?do=b2b_pass"><img src="img/menu.png" width="48" height="48" border="0" align="absmiddle">B2B Manager</a> <a href="?do=config"><img src="img/config.png" width="48" height="48" border="0" align="absmiddle">Beállítások</a> <a href="logout.php"><img src="img/frontpage.png" width="48" height="48" border="0" align="absmiddle">Kilépés</a></p>';

  elseif( $_SESSION['who'] == 'A' )
	echo'<p><a href="?do=comp_list"><img src="img/addedit.png" width="48" height="48" border="0" align="absmiddle">Cégek  </a><a href="?do=b2b_pass"><img src="img/menu.png" width="48" height="48" border="0" align="absmiddle">B2B Manager</a>  <a href="logout.php"><img src="img/frontpage.png" width="48" height="48" border="0" align="absmiddle">Kilépés</a></p>';

?>
</div>
<?php

	$do = ( isset( $_REQUEST['do'] ) ) ? $_REQUEST['do'] : 'comp_list';

	/* **********************
	  SUBMENÜ CÉGKEZELŐHÖZ
	********************** */

	$pos = strpos( $do, 'comp' );
	
	if ($pos === false) {
		// DO Nothing
	} 
	else 
	{
		echo "<a style='margin-left: 22px;' href='index.php?do=comp_add' class='blk'>Cég felvitele</a> <a href='index.php?do=comp_list' class='blk'>Cégek listázása</a>";
	}


	/* **********************
		 SUBMENÜ B2B-hez
	********************** */

	$pos = strpos( $do, 'b2b' );
	
	if ($pos === false) {
		// DO Nothing
	} 
	else 
	{
		echo "<a style='margin-left: 22px;' href='index.php?do=b2b_pass' class='blk'>Jelszó kiküldése</a>
			<a href='index.php?do=b2b_activate' class='blk'>Ajánlatok aktiválása</a>
			<a href='index.php?do=b2b_keres' class='blk'>Keres ajánlatok</a>
			<a href='index.php?do=b2b_kinal' class='blk'>Kínál ajánlatok</a>
			<a href='index.php?do=b2b_lejart' class='blk'>Lejárt ajánlatok</a>";
	}

	echo'<div class="padding">';

	/***************************************************************************************************************************
														CONTROLLER SECTION
	***************************************************************************************************************************/

	switch( $do ){

	/* ************************
		KATEGÓRIA CONTROLLER
	************************ */
	
				case "order_list":

					if( isset( $_GET['id'] )) $id = $_GET['id'];
					else $id = 0;
					
					$admin->main_order_list( $id );
					
					if( isset( $_GET['id'] ) && $_GET['id'] != 0 )
					{
						echo"<div id='sublist'>";

							$admin->sub_order_list( $_GET['id'] );

						echo"</div>";
					}
			
				break;

				case "cat_order_edit":
					
					$admin->cat_order_edit( $_GET['id'] );
					
				break;
				
				case "modify_order":
					
					$admin->modify_order( $_GET['id'], $_POST );

				break;

				case "category_list":

					if( isset( $_GET['id'] )) $id = $_GET['id'];
					else $id = 0;

					$admin->main_category_list( $id );
					
					if( isset( $_GET['id'] ) && $_GET['id'] != 0 ){
						echo"<div id='sublist'>";

							$admin->sub_category_list( $_GET['id'] );

						echo"</div>";
					}

					echo"<div id='formme'>";
						$admin->category_form();
					echo"</div>";

				break;

				case "category_delete":
					$admin->category_delete( $_GET['id'] );
				break;

				case "category_edit":
					$admin->category_edit( $_GET['str'], $_GET['id'] );
				break;

				case "add_category":
					if( !empty( $_POST['category'] ) )
					{
						if( $_POST['main'] == 'on' ){
							$admin->add_category( $_POST['category'], $_POST['parent'], $_POST['hide'] );
						} 
						else 
						{
							$admin->add_category( $_POST['category'], 0, $_POST['hide'] );
						}
					}
					else
					{ 
						echo 'A kategória nevét kötelező megadni.<br><a href="javascript:history.back();">Vissza az előző oldalra</a>';
					}
				break;

	/* ***************************
		CÉGADATBÁZIS CONTROLLER
	*************************** */

				case "comp_list":
					$search	= ( isset( $_GET['q'] ) ) ? $_GET['q'] : false;

					$admin->comp_list( $search );
				break;

				case "comp_add":
					$admin->comp_add();
				break;

				case "comp_parse":
					$admin->comp_parse( $_POST['cname'], $_POST['address'], $_POST['places'], $_POST['email'], $_POST['region'], $_POST['city'], $_POST['tel'], $_POST['url'], $_POST['brands'], $_POST['description'], $_POST['cat'], $_POST['advcat'], $_POST['fax'], $_POST['iso'] );
				break;

				case "comp_delete":
					if( isset( $_GET['BRSR'] ) ) $page = $_GET['BRSR'];
					$admin->comp_delete( $_GET['id'], $page );
				break;
				
				case "comp_edit":
					$admin->comp_edit( $_GET['id'] );
				break;

				case "comp_parse_edit":
					if( isset( $_GET['BRSR'] ) ) $page = $_GET['BRSR'];
					$admin->comp_parse_edit( $_POST['id'], $_POST['cname'], $_POST['address'], $_POST['places'], $_POST['email'], $_POST['region'], $_POST['city'], $_POST['tel'], $_POST['url'], $_POST['brands'], $_POST['description'], $_POST['cat'], $page, $_POST['advcat'], $_POST['fax'], $_POST['iso']  );
				break;
				
	/* **********************
		  USER CONTROLLER
	********************** */
	
				case "add_user":
					$admin->add_user( $_POST['user'], $_POST['pass'], $_POST['sz'] );
					header( 'Location: index.php?do=config' );
				break;	
				
				case "modify_user":
					$admin->modify_user( $_POST['user'], $_POST['pass'], $_POST['uid'] );
				break;
				
				case "del_user":
					$admin->del_user( $_GET['id'] );
				break;
				
	/* **********************
		  B2B CONTROLLER
	********************** */
	
				case "b2b_pass":
				
					$q = ( isset( $_GET['q'] ) ) ? $_GET['q'] : false;
				
					$admin->b2b_pass( $q );
				break;
				
				case "b2b_sendmail":
					$admin->b2b_sendmail( $_GET['id'] );
				break;

				case "b2b_lejart":
					$admin->b2b_list( 'over' );
				break;
				
				case "b2b_kinal":
					$admin->b2b_list( 'kin' );
				break;
				
				case "b2b_keres":
					$admin->b2b_list( 'ker' );
				break;

				case "b2b_del":
					$admin->b2b_del_offer( $_GET['id'] );
				break;

				case "b2b_activate":
					$admin->b2b_activate();
				break;
				
				case "b2b_reactivate":
					$admin->b2b_reactivate( $_GET['id'] );
				break;

				case "b2b_apply":
					$admin->b2b_apply( $_GET['id'] );
				break;

				case "config":
					$admin->config();
				break;
				
	/* **********************
		  B2B CONTROLLER
	********************** */
	
				case "mod_ad_links":
					$admin->mod_ad_links( $_POST );
				break;				
				
	}
}
?>
</div>
</body>
</html>	