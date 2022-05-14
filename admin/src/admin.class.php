<?php 
//
class admin{

	/* **********************
		HIRDETÉS KEZELŐ
	********************** */
	
	function mod_ad_links( $poster )
	{

		$handle = fopen( '../adv_bal.nfo', 'w+');

		if (fwrite($handle, $poster['bal']) === FALSE) 
		{
			die( "Íráshiba");
		}

		$handle = fopen( '../adv_jobb.nfo', 'w+');

		if (fwrite($handle, $poster['jobb']) === FALSE) 
		{
			die( "Íráshiba");
		}

		echo '<script>document.location = "index.php?do=config"</script>';

	}	

	/* **********************
		FELHASZNÁLÓ KEZELŐ
	********************** */
	
	
	function add_user( $user, $pass, $sz )
	{
		global $db;
		
		$db->query( 'INSERT INTO felhasznalok( user,pass,who ) VALUES( "'.$user.'","'.$pass.'","'.$sz.'" )' );
		
		echo '<script>document.location = "index.php?do=config"</script>';

	}
	
	function del_user( $id )
	{
		global $db;
		
		$db->query( 'DELETE FROM felhasznalok WHERE id = "'.$id.'"' );
		
		echo '<script>document.location = "index.php?do=config"</script>';

	}
	
	function modify_user( $user, $pass, $id )
	{
		global $db;
		
		$db->query( 'UPDATE felhasznalok SET user = "'.$user.'", pass = "'.$pass.'" WHERE id = "'.$id.'"' );
		echo $user;
		echo '<script>document.location = "index.php?do=config"</script>';

	}

	
	/* **********************
		SORREND KEZELŐ
	********************** */
	
	function main_order_list($id = 0)
	{
		global $db;
		echo'<ul>';

		$leker = $db->get_results("SELECT * FROM categories WHERE parent = '0'");

			$inert = '';
			
			foreach( $leker as $sor )
			{

				if( $sor->id == $id ){
					$insert = " <---";
				} else $insert = '';

				echo"<li><a href='?do=cat_order_edit&id=$sor->id'><img src='img/edit.gif' align='absmiddle'></a> <a href='index.php?do=order_list&id=".$sor->id."' class='cat'>".$sor->category.$insert."</a><br><input type='text' name='".$sor->id."' value='".$sor->category."' style='display: none; margin-left:30px;' id='c".$sor->id."'><input type='button' value='Ok' onclick='modify( ".$sor->id." )' style='display: none;' id='b".$sor->id."'></li>\n";
			}

		echo '</ul>';
	}

	function sub_order_list($id = 0)
	{
		global $db;
		echo'<ul>';

		$leker = $db->get_results("SELECT * FROM categories WHERE parent = '".$id."'");

		if( $leker != NULL ){
			foreach($leker as $sor)
			{
					// A köv. soron be van linkelve a kategória:

					$hidden = ( $sor->hidden == 1 ) ? " <span style='color: #f00;font-weight: bold'>(r)</span>" : "";

					echo"<li><a href='?do=cat_order_edit&id=$sor->id'><img src='img/edit.gif' align='absmiddle'></a> <a href='?do=cat_order_edit&id=$sor->id' class='cat'>".$sor->category.$hidden."</a><br></li>\n";
			}
		}
		else
		{
			echo "<img src='img/i.png' align='absmiddle'> A kategóra nem tartalmaz elemeket";
		}

		echo '</ul>';
	}

	function cat_order_edit( $id )
	{
	
		$sql = "SELECT companies.*, switch.catID, sorrend.hely
				FROM companies
				LEFT JOIN switch ON switch.cID = id
				LEFT JOIN sorrend ON sorrend.cegID = companies.id
				AND sorrend.catID = switch.catID
				WHERE switch.catID = '$id'
				ORDER BY hely DESC, cname ASC";

		$result = mysql_query( $sql );
		
		echo "<form action='index.php?do=modify_order&id=$id' method='post'>
		<table cellpadding='3' cellspacing='1' width='650' id='lister'>
		<tr class='tr_head'> <td>Cég neve</td><td>Telefon</td><td>Város</td><td>E-mail</td><td>Sorrend</td> </tr>";

		while( $res = mysql_fetch_array( $result ) )
		{
		//print_r($res);
				
				// Update vagy insert?
				
				$todo = ( $res['hely'] == '' ) ? 'ic' : 'uc';
				
				echo"<tr class='row' valign='top'>
								<td><strong><a href=\"http://uzleticegtudakozo.hu/?do=comp_show&cid=".$res[0]."&cname=".$res[2]."\">".$res[2]."</a></strong></td>
								<td>".$res[6]."</td>
								<td>".$res[5]."</td>
								<td>".$res[3]."</td> 
								<td><input type='text' name='".$todo.$res['id']."' value='".$res['hely']."' style='width: 25px'></td> 
					 </tr>";
		}
		echo "</table><input type='submit'></form>";
	}

	function modify_order( $id, $p )
	{

		if( $p )
		{
			foreach( $p as $key => $up )
			{

				if( $up != 0 )
				{
				
					$todo = ( substr( $key, 0,2 ) == 'ic' ) ? 'INSERT' : 'UPDATE';
					
					if( $todo == "INSERT" )
					{
					
						mysql_query( 'INSERT INTO sorrend( cegID, catID, hely ) VALUES( "'.substr( $key, 2, strlen($key) ).'","'.$id.'","'.$up.'" )' );
					
					} else {
	
						mysql_query( 'UPDATE sorrend SET hely = "'.$up.'" WHERE cegID = "'.substr( $key, 2, strlen($key) ).'"' );
					
					}			
				} else {
				
					mysql_query( 'DELETE FROM sorrend WHERE cegID = '.substr( $key, 2, strlen($key) ).' AND catID = "'.$id.'"' );
				
				}
			}
		}
		
		echo 'Sorrend elmentve, <a href="#" onclick="history.back()">vissza az elző oldalra</a>';
		
		
	}

	/* **********************
		KATEGÓRIA KEZELŐ
	********************** */


	function main_category_list($id = 0)
	{
		global $db;
		echo'<ul>';

		$leker = $db->get_results("SELECT * FROM categories WHERE parent = '0'");

			$inert = '';
			
			foreach( $leker as $sor ){

				if( $sor->id == $id ){
					$insert = " <---";
				} else $insert = '';

				echo"<li><a href='#' onclick=\"deleteCat('".$sor->id."', '".$sor->category."')\"><img src='img/delete.gif' align='absmiddle'></a><a onclick='toggle(\"c".$sor->id."\");toggle(\"b".$sor->id."\")'> <img src='img/edit.gif' align='absmiddle' style='cursor: pointer;'></a> <a href='index.php?do=category_list&id=".$sor->id."' class='cat'>".$sor->category.$insert."</a><br>
                    <div style='display: none; margin-left:30px;' id='c".$sor->id."'>
                        HU:<input type='text' id='cat".$sor->id."' value='".$sor->category."'><br>
                        EN:<input type='text' id='cat".$sor->id."_en' value='".$sor->category_en."'><br>
                        DE:<input type='text' id='cat".$sor->id."_de' value='".$sor->category_de."'><input type='button' value='Ok' onclick='modify( ".$sor->id." )' style='display: none;' id='b".$sor->id."'>
                    </div></li>\n";
			}

		echo '</ul>';
	}
	
	function sub_category_list($id = 0)
	{
		global $db;
		echo'<ul>';

		$leker = $db->get_results("SELECT * FROM categories WHERE parent = '".$id."'");

		if( $leker != NULL ){
		
			foreach($leker as $sor){

					$hidden = ( $sor->hidden == 1 ) ? " <span style='color: #f00;font-weight: bold'>(r)</span>" : "";
    				echo"<li><a href='#' onclick=\"deleteCat('".$sor->id."', '".$sor->category."')\"><img src='img/delete.gif' align='absmiddle'></a><a onclick='toggle(\"c".$sor->id."\");toggle(\"b".$sor->id."\")'> <img src='img/edit.gif' align='absmiddle' style='cursor: pointer;'></a> ".$sor->category.$insert."<br>
                        <div style='display: none; margin-left:30px;' id='c".$sor->id."'>
                            HU:<input type='text' id='cat".$sor->id."' value='".$sor->category."'><br>
                            EN:<input type='text' id='cat".$sor->id."_en' value='".$sor->category_en."'><br>
                            DE:<input type='text' id='cat".$sor->id."_de' value='".$sor->category_de."'><input type='button' value='Ok' onclick='modify( ".$sor->id." )' style='display: none;' id='b".$sor->id."'>
                        </div></li>\n";
                    // Old, egynyelvű
					//echo"<li><a href='?do=category_delete&id=".$sor->id."'><img src='img/delete.gif' align='absmiddle'></a><a onclick='toggle(\"c".$sor->id."\");toggle(\"b".$sor->id."\")'> <img src='img/edit.gif' align='absmiddle' style='cursor: pointer;'></a> ".$sor->category.$hidden."<br><input type='text' name='".$sor->id."' value='".$sor->category."' style='display: none; margin-left:30px;' id='c".$sor->id."'><input type='button' value='Ok' onclick='modify( ".$sor->id." )' style='display: none;' id='b".$sor->id."'></li>\n";
			}
		}
		else
		{
			echo "<img src='img/i.png' align='absmiddle'> A kategóra nem tartalmaz elemeket";
		}

		echo '</ul>';
	}

	function category_delete( $id = 0 )
	{
		global $db;
		$leker = $db->query("DELETE FROM categories WHERE id = '".$id."' OR parent = '".$id."'");
		//
		$parent = $db->get_var("SELECT parent FROM categories WHERE id='".$id."'");
		if( $parent == 0 ) $parent = '';
		echo"<script> document.location = 'index.php?do=category_list&id=".$parent."' </script>";
	}

	function category_edit( $str, $str_en, $str_de, $id = 0 )
	{
		global $db;
		$leker = $db->query("UPDATE categories SET category = '".$str."', category_en = '".$str_en."', category_de = '".$str_de."' WHERE id = '".$id."'");
		//
		$parent = $db->get_var("SELECT parent FROM categories WHERE id='".$id."'");
		if( $parent == 0 ) $parent = '';
		echo"<script> document.location = 'index.php?do=category_list&id=".$parent."' </script>";
	}

	function category_form()
	{
		global $db;
		echo <<<STUFF
		<form onsubmit="return csekk()" action="index.php?do=add_category" method="post" enctype="application/x-www-form-urlencoded">
		<strong>Új hozzáadása</strong><br /><br />

		<input name="category" type="text" size="20" /> <input value="Hozzáad" type="submit" size="20" /><br /><br />
		Alkategóriát szerertnék hozzáadni:&nbsp;<input name="main" type="checkbox" id="chx" onclick="toggle('clist')"/><br />
		Legyen rejtett:&nbsp;<input name="hide" type="checkbox" id="hide" /><br /><br />
STUFF;
		echo'<select size="1" name="parent" id="clist" style="display: none;">
			<option selected value="no">Az alábbiak egyikébe...</option>';

		$leker = $db->get_results("SELECT * FROM categories WHERE parent = '0'");
			foreach($leker as $sor){
					echo"<option value=\"".$sor->id."\">".$sor->category."</option>\n";
			}
		echo '</select></form>
		<script> 
		document.getElementById("chx").checked = false;
		document.getElementById("clist").selectedIndex = 0;
		
		function csekk()
		{
			var hide = ( document.getElementById("hide").checked ) ? true : false;
			var c = ( document.getElementById("chx").checked ) ? true : false;

			if( hide == true && c == false )
			{
				alert( "Főtevékenységi kör nem lehet rejtett" );
				return false;
			}
			else
			{
				return true;
			}
		}
		
		</script>';
	}

	function add_category($str, $parent, $hide)
	{
		global $db;
		
		$hide = ( $hide == 'on' ) ? 1 : 0;
		
		$leker = $db->query("INSERT INTO categories ( id, category, parent, hidden ) VALUES ('', '".$str."', '".$parent."', '".$hide."')");
		//$db->debug();
		echo"<script> document.location = 'index.php?do=category_list&id=".$parent."' </script>";
	}


	/* **********************
		CÉGADATBÁZIS KEZELŐ
	********************** */

	/* id address cname email region city tel url brands description description_en description_de places pass ts */
	/* 1  2		  3		4	  5      6    7   8   9      10 		 11             12             13     14   15
	*/

	function get_regions()
	{
		$regions = file('../data/region.dat');
		$mydata = array();
		foreach( $regions as $stuff ){
			$data = explode( '::', $stuff );
			$mydata[ $data[0] ] = $data[1];
		}
		return $mydata;
	}

	/* ************************
		! CÉGADAT LISTÁZÓ !
	************************ */

	function comp_list( $search = '' )
	{
		global $ezr;
		global $db;

		function get_cats( $col1, $col2, $col3, $col4 ,$col5, $col6, $col7, $col8, $col9, $col10, $col11, $col12, $col13, $col14, $col15, $col16, $col17, $col18, $col19, $col20, $col21 ){
			global $db;
			global $regions;

			//$results = $db->get_results("SELECT * FROM categories WHERE id IN ( SELECT catID FROM switch WHERE cid = '".$col1."' )");

			$col9 .= "<br/><strong>Tevékenységek:</strong><br/>";
/*
			if( $results )
			{
				foreach( $results as $cats ){
					$col9 .= " " . $cats->category . " ";
				}
			}
*/
			//$col9 = '';

			if ( strlen( $col9 ) > 23 ) $col9 = substr( $col9, 0, 23 ) . '...';

			$col5 = $regions[ $col5 ];

			$col15 = date("Y/m/d H:i",$col15);
		}
		
		if( $search ){
							$insertSQL  = ' WHERE LOWER(companies.cname) LIKE "%'.$search.'%" OR 
											LOWER(companies.city) LIKE "%'.$search.'%" OR 
											LOWER(companies.brands) LIKE "%'.$search.'%" OR 
											LOWER(companies.advcat) LIKE "%'.$search.'%" OR 
											LOWER(companies.description) LIKE "%'.$search.'%"';

			$ezr->set_qs_val("q", $search );

		}
		else $insertSQL = '';
		
		$ezr->nav_top = true;
		$ezr->nav_bottom = true;
		$ezr->num_results_per_page = 15;
		$ezr->register_function( 'get_cats' );
		$ezr->set_qs_val("do","comp_list");
		$ezr->results_empty = "Lekérdezés hiba!";
		$ezr->results_open = "<table cellpadding='3' cellspacing='1' width='100%'>";
		$ezr->results_heading = "<tr class='tr_head'> <td>Cég neve</td><td>Kontaktok</td><td>Város/Régió</td><td>Márkák/Kategóriák</td><td width='150'>Cím/telephelyek</td><td width='150'>Leírás</td><td>Action</td> </tr>";

		if( $_SESSION['who'] == 'S' )
		{
			$ezr->results_row = "<tr class='row' valign='top'> 
									<td><strong>COL3</strong><br /><br /> <strong>Rögzítve</strong>:<br /> COL15<br /><br /><em><strong>Minősítés:</strong></em><br>COL21</td>
									<td><em><strong>Web:</strong></em><br /><a href='COL8' target='new'>COL8</a><br /> <em><strong>E-mail:</strong></em><br /> <a href='mailto:COL4'>COL4</a> <br /><em><strong>Telefon:</strong></em><br /><strong>COL7</strong> <em><strong><br />Fax:</strong></em><br /><strong>COL20</strong></td>
									<td><strong>COL6</strong> <br> COL5</td>
									<td><strong>Márkák:</strong><br>COL9</td> 
									<td>COL2 <br /><a onclick='toggle(\"xCOL1\")' style='cursor: pointer;'><img src='img/add.png' align='absmiddle'>Telephely</a> <span id='xCOL1' style='display:none;'><hr> COL13</span></td>
									<td> <a onclick='toggle(\"dCOL1\")' style='cursor: pointer;'><img src='img/i.png' align='absmiddle'>NFO</a><br/> <span id='dCOL1' style='display:none;'>COL10</span></td>
									<td width='40'>
										<a href='javascript:deleteIt(\"COL1\", \"COL3\")'><img src='img/delete.gif' title='Törlés' align='absmiddle'></a>
										<a href='?do=comp_edit&id=COL1''><img src='img/edit.gif' title='Szerkesztés' align='absmiddle'></a>
									</td> 
								</tr>";
		}else{

			$ezr->results_row = "<tr class='row' valign='top'> 
									<td><strong>COL3</strong><br /><br /> <strong>Rögzítve</strong>:<br /> COL15<br /><br /><em><strong>Minősítés:</strong></em><br>COL21</td>
									<td><em><strong>Web:</strong></em><br /><a href='COL8' target='new'>COL8</a><br /> <em><strong>E-mail:</strong></em><br /> <a href='mailto:COL4'>COL4</a> <br /><em><strong>Telefon:</strong></em><br /><strong>COL7</strong> <em><strong><br />Fax:</strong></em><br /><strong>COL20</strong></td>
									<td><strong>COL6</strong> <br> COL5</td>
									<td><strong>Márkák:</strong><br>COL9</td> 
									<td>COL2 <br /><a onclick='toggle(\"xCOL1\")' style='cursor: pointer;'><img src='img/add.png' align='absmiddle'>Telephely</a> <span id='xCOL1' style='display:none;'><hr> COL13</span></td>
									<td> <a onclick='toggle(\"dCOL1\")' style='cursor: pointer;'><img src='img/i.png' align='absmiddle'>NFO</a><br/> <span id='dCOL1' style='display:none;'>COL10</span></td>
									<td width='40'>
										<a href='?do=comp_edit&id=COL1''><img src='img/edit.gif' title='Szerkesztés' align='absmiddle'></a>
									</td> 
								</tr>";
		}

		$ezr->text_count = "NUMBER cég az adatbázisban";

		$ezr->query_mysql("SELECT * FROM companies $insertSQL ORDER by cname");
/*
		$ezr->query_mysql( $sql = "SELECT companies . * , categories.category
													FROM companies
													LEFT JOIN switch ON switch.cID = companies.id
													LEFT JOIN categories ON categories.id = switch.cID
													$insertSQL
													GROUP BY companies.id
													ORDER by cname");
*/
        $ezr->display();
	}

	/* **********************
		CÉG HOZZÁADÁSA
	********************** */

	function comp_add()
	{
		global $db;
		echo'<form action="index.php?do=comp_parse" method="post" enctype="multipart/form-data" onsubmit="return checkBoxes()">
			 <table width="850" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
			  <tr>
				<td width="350" valign="top">

						<table width="400" border="0" cellspacing="3" cellpadding="1" bgcolor="">
						  <tr>
							<td width="133" align="right" valign="middle">C&eacute;g neve </td>
							<td><input name="cname" type="text" id="address" size="30" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Regio</td>
							<td>
							<select name="region">
									<option value=""></option>
									<option value="12">B&#225;cs-Kiskun megye</option>
									<option value="16">Baranya megye</option>
									<option value="11">B&#233;k&#233;s megye</option>
								
									<option value="7">Borsod-Aba&#250;j-Zempl&#233;n megye</option>
									<option value="13">Csongr&#225;d megye</option>
									<option value="4">Fej&#233;r megye</option>
									<option value="19">Győr-Moson-Sopron megye</option>
								
									<option value="8">Hajd&#250;-Bihar megye</option>
									<option value="6">Heves megye</option>
									<option value="10">J&#225;sz-Nagykun-Szolnok megye</option>
									<option value="3">Kom&#225;rom-Esztergom megye</option>
									<option value="5">N&#243;gr&#225;d megye</option>
								
									<option value="2">Pest megye</option>
									<option value="15">Somogy megye</option>
									<option value="9">Szabolcs-Szatm&#225;r-Bereg megye</option>
								
									<option value="14">Tolna megye</option>
									<option value="20">Vas megye</option>
									<option value="17">Veszpr&#233;m megye</option>
									<option value="18">Zala megye</option>
				
								</select>
							</td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Sz&eacute;khely</td>
							<td><input name="address" type="text" id="address" size="30" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">Telephelyek</td>
							<td><textarea name="places" cols="30" rows="3" id="places"></textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Telefon</td>
							<td><textarea name="tel" type="text" id="tel"></textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Fax</td>
							<td><input name="fax" type="text" id="tel" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">Egyéb tevékenységek</td>
							<td><textarea name="advcat" cols="30" rows="4" id="description"></textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">Egyéb tevékenységek angolul</td>
							<td><textarea name="advcat_en" cols="30" rows="4" id=""></textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">Egyéb tevékenységek németül</td>
							<td><textarea name="advcat_de" cols="30" rows="4" id=""></textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Minősítés</td>
							<td><input name="iso" type="text" id="tel" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">C&eacute;gbemutat&oacute;</td>
							<td><textarea name="description" cols="30" rows="5" id="description"></textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">C&eacute;gbemutat&oacute; angolul</td>
							<td><textarea name="description_en" cols="30" rows="5" id="description"></textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">C&eacute;gbemutat&oacute; németül</td>
							<td><textarea name="description_de" cols="30" rows="5" id="description_En"></textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">E-mail</td>
							<td><input name="email" type="text" id="email" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Webcím</td>
							<td><input name="url" type="text" id="url" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">V&aacute;ros</td>
							<td><input name="city" type="text" id="city" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">M&aacute;rk&aacute;k</td>
							<td><input name="brands" type="text" id="brands" size="30" /><br />
							<font size="1">(Szóközzel elválasztott márkák)</font></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">&nbsp;</td>
							<td><input type="submit" name="Submit" value="Cég felvitele" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle"></td>
							<td><h1>Képek feltöltése</h1></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Kép 1</td>
							<td><input type="file" name="img[]" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Kép 2</td>
							<td><input type="file" name="img[]" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Kép 3</td>
							<td><input type="file" name="img[]" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Kép 4</td>
							<td><input type="file" name="img[]" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Kép 5</td>
							<td><input type="file" name="img[]" /></td>
						  </tr>
						</table>
					</td>
				<td valign="top"><br /><fieldset><legend>Tevékenységi körök</legend>';

				$oszlopok = $db->get_var("SELECT COUNT(*) FROM categories WHERE parent = '0'");
				$c = 0;
				$entries = round( $oszlopok / 3 );

				$cats = $db->get_results("SELECT * FROM categories");
				
				foreach ( $cats as $sor )
				{
				
						if( $sor->parent == 0 ) 
						{
							if( $c == $entries || $c == 0 )
							{
								echo"<div id='oszlop'>";
							}
				
							echo '<div style="padding-bottom: 3px;"><u>'.$sor->category.'</u><input type="checkbox" value="'.$sor->id.'" name="cat[]"></div><br>';

							$actual = $sor->id;
				
								foreach ( $cats as $sorok )
								{
									if( $sorok->parent == $actual )
									{
									
									  $hidden = ( $sorok->hidden == 1 ) ? " <span style='color: #f00;font-weight: bold'>(r)</span>" : "";

									  echo "<input type='checkbox' value='".$sorok->id."' name='cat[]'> ".$sorok->category.$hidden."<br>";
									}
								}
							echo"<br />";

							if( $c == $entries - 1 ){
								echo"</div>";
								$c = 0;
							} 
							else {	$c++;	}
						}
				} 

			echo '</fieldset></td>
			  </tr>
			</table></form>';
	}

	/* **********************
	    CÉGADAT FELDOLGÓZÓ
	********************** */

	function comp_parse( $cname, $address, $places, $email, $region, $city, $tel, $url, $brands, $description, $description_en ,$description_de, $cats, $advcat, $advcat_en, $advcat_de, $fax, $iso )
	{
		global $db, $_FILES;
error_reporting( E_ALL );
		$pass = strtoupper( substr ( md5( rand() ), 0, 6 ) );
		
		if( !empty( $cats ) ){
			$leker = $db->query("INSERT INTO companies ( id, address, cname, email, region, city, tel, url, brands, description, description_en, description_de, places, pass, ts, advcat, advcat_en, advcat_de, fax, iso ) VALUES 
                                ( NULL, '$address', '$cname', '$email', '$region', '$city', '$tel', '$url', '$brands', '$description', '$description_en', '$description_de', '$places', '$pass', UNIX_TIMESTAMP(), '$advcat', '$advcat_en', '$advcat_de', '$fax', '$iso' ) ");

			$insertid = $db->insert_id;

			foreach( $cats as $insert ){
				$db->query("INSERT INTO switch( cID, catID ) values( '".$insertid."', '".$insert."' )");
			}
			
			/* Képek beillesztése */

			if( !empty( $_FILES ) ){

                 include( 'ImageFilter.class.php' );

                 $x = 0;
                 foreach( $_FILES['img']['tmp_name'] as $tmp ){

                        $origName = $_FILES['img']['name'][ $x ];
                        
                        // Get file extension
                        $ext = strrchr( $origName, ".");

                        // Generate non existing filename
                        $hash = md5( $_FILES['img']['tmp_name'][ $x ] );

                        while( file_exists( _BASE_PATH . $hash . $ext ) ){
                        
                                $hash = md5( $_FILES['img']['tmp_name'][ $x ] . mt_rand( 0, 1000 ) );
                        }

////////////////////////////////////////////////////////

                        // If it was an image, resize it...

                        if( @getimagesize( $tmp ) ){

                            // Move uploaded file to the uploaded dir, Resizing from temp file doesen't work
                            $up = move_uploaded_file( $tmp, _BASE_PATH . 'uploaded/' . $hash . $ext );

                            // First resizing
                                $chain = array();
                                $chain[] = array('resize', array('width' => 453, 'noaspect' => false ));
                                //$chain[] = array('crop', array('width' => 100, 'height' => 100, 'valign' => 'middle'));

                                $m = new ImageModifier( $chain ); 
                                $m->load( '../uploaded/' . $hash . $ext );
                                $t = $m->getGD();

                            // Delete original file, it is not needed anymore
                            unlink( _BASE_PATH . 'uploaded/' . $hash . $ext );

                            // Create big resized file
                            imageJpeg( $t,  _BASE_PATH . 'uploaded/' . $hash . $ext );

                            // Seconf resizing // Based on the resized file
                                $chain2 = array();
                                $chain2[] = array('resize', array('width' => 150, 'noaspect' => false ));
                                //$chain[] = array('crop', array('width' => 100, 'height' => 100, 'valign' => 'middle'));

                                $n = new ImageModifier( $chain2 ); 
                                $n->load( '../uploaded/' . $hash . $ext );

                            // Create thumbnail
                            imageJpeg( $n->getGD(),  _BASE_PATH . 'uploaded/thumbs/' . $hash . $ext );
                        }

////////////////////////////////////////////////////////

                        $x++;
                        
                        // Beszúrás adatbázisba
                        
                        if( $ext ) $db->query("INSERT INTO kepek( id, ceg_id, url ) values( NULL, '".$insertid."', '".$hash . $ext."' )");
                        //var_dump( $z );
                 }
			} // img upload end
			
		} else {
			echo"Kategóriát kötelező megadni!";
		}
		
		echo"<script> document.location = 'index.php?do=comp_add' </script>";
	}

	/* **********************
	      CÉG TÖRLÉSE
	********************** */

	function comp_delete( $id, $page )
	{
		global $db;
		$db->query("DELETE FROM companies WHERE id = '".$id."'");
		$db->query("DELETE FROM switch WHERE cID = '".$id."'");
		echo"<script> document.location = 'index.php?do=comp_list&BRSR=".$page."' </script>";
	}

	/* **********************
		CÉGSZERKESZTŐ
	********************** */

	function comp_edit( $id )
	{
		global $db;

		$data = $db->get_row("SELECT * FROM companies WHERE id = '".$id."'");
		$imgs = $db->get_results("SELECT * FROM kepek WHERE ceg_id = '".$id."'");

		echo'<form action="index.php?do=comp_parse_edit" method="post" enctype="multipart/form-data">
			 <table width="800" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
			  <tr>
				<td width="400" valign="top" bgcolor="#ffffff">
					<h3>&nbsp;&nbsp;&nbsp;&nbsp;Cégadatok szerkesztése</h3>
					<input type="hidden" name="id" value="'.$id.'" />
						<table width="400" border="0" cellspacing="3" cellpadding="1" bgcolor="">
						  <tr>
							<td width="133" align="right" valign="middle">C&eacute;g neve </td>
							<td><input name="cname" type="text" id="address" size="30" value="'.$data->cname.'" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Sz&eacute;khely</td>
							<td><input name="address" type="text" id="address" value="'.$data->address.'" size="40" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">Telephelyek</td>
							<td><textarea name="places" cols="30" rows="3" id="places">'.$data->places.'</textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">E-mail</td>
							<td><input name="email" type="text" id="email" value="'.$data->email.'" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Regio</td>
							<td>
							<select name="region" id="regiok">
									<option value=""></option>
									<option value="12">B&#225;cs-Kiskun megye</option>
									<option value="16">Baranya megye</option>
									<option value="11">B&#233;k&#233;s megye</option>
								
									<option value="7">Borsod-Aba&#250;j-Zempl&#233;n megye</option>
									<option value="13">Csongr&#225;d megye</option>
									<option value="4">Fej&#233;r megye</option>
									<option value="19">Győr-Moson-Sopron megye</option>
								
									<option value="8">Hajd&#250;-Bihar megye</option>
									<option value="6">Heves megye</option>
									<option value="10">J&#225;sz-Nagykun-Szolnok megye</option>
									<option value="3">Kom&#225;rom-Esztergom megye</option>
									<option value="5">N&#243;gr&#225;d megye</option>
								
									<option value="2">Pest megye</option>
									<option value="15">Somogy megye</option>
									<option value="9">Szabolcs-Szatm&#225;r-Bereg megye</option>
								
									<option value="14">Tolna megye</option>
									<option value="20">Vas megye</option>
									<option value="17">Veszpr&#233;m megye</option>
									<option value="18">Zala megye</option>
				
								</select>
							</td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">V&aacute;ros</td>
							<td><input name="city" type="text" id="city" value="'.$data->city.'" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Telefon</td>
							<td><input name="tel" type="text" id="tel" value="'.$data->tel.'" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Fax</td>
							<td><input name="fax" type="text" id="tel" value="'.$data->fax.'" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Minősítés</td>
							<td><input name="iso" type="text" id="tel" value="'.$data->iso.'" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">Url</td>
							<td><input name="url" type="text" id="url" value="'.$data->url.'" size="25" /></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle">M&aacute;rk&aacute;k</td>
							<td><input name="brands" type="text" id="brands" value="'.$data->brands.'" size="40" /><br />
							<font size="1">(Szóközzel elválasztott márkák)</font></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">C&eacute;gbemutat&oacute;</td>
							<td><textarea name="description" cols="30" rows="5" id="description">'.str_replace( '<br />', "\n", $data->description).'</textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">C&eacute;gbemutat&oacute; angolul</td>
							<td><textarea name="description_en" cols="30" rows="5" id="description">'.str_replace( '<br />', "\n", $data->description_en).'</textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">C&eacute;gbemutat&oacute; németül</td>
							<td><textarea name="description_de" cols="30" rows="5" id="description_En">'.str_replace( '<br />', "\n", $data->description_de).'</textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">Egyéb tevékenységek</td>
							<td><textarea name="advcat" cols="30" rows="4" id="adv_cat">'.str_replace( "<br />", "\n", $data->advcat).'</textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">Egyéb tevékenységek angolul</td>
							<td><textarea name="advcat_en" cols="30" rows="4" id="adv_cat_en">'.str_replace( "<br />", "\n", $data->advcat_en).'</textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="top">Egyéb tevékenységek németül</td>
							<td><textarea name="advcat_de" cols="30" rows="4" id="adv_cat_De">'.str_replace( "<br />", "\n", $data->advcat_de).'</textarea></td>
						  </tr>
						  <tr>
							<td align="right" valign="middle"></td>
							<td><h1>Képek feltöltése / törlése</h1></td>
						  </tr>';

                          $x = 5;
                            
                          if( $imgs ){

                              foreach( $imgs as $i ){
                                 echo'<tr>
                                        <td align="right" valign="middle">Kép '. ( 6 - $x ).'</td>
                                        <td>
                                            <img src="../uploaded/thumbs/'.$i->url.'">
                                            <input type="file" name="img[]" /><br>
                                            <input type="checkbox" name="delete[]" value="'.$i->id.'|'.$i->url.'" /> Kép törlése
                                            <hr>
                                        </td>
                                      </tr>';
                                 $x--;
                              }
                          }
                              while( $x !== 0 ){
                                 echo'<tr>
                                        <td align="right" valign="middle">Kép '.( 6 - $x ).'</td>
                                        <td>
                                            <input type="file" name="img[]" />
                                        </td>
                                      </tr>';
                                 $x--;
                              }

						  echo '<tr>
							<td align="right" valign="middle">&nbsp;</td>
							<td><input type="submit" name="Submit" value="Cég módosítása" /></td>
						  </tr>
						</table>
						<script>
							document.getElementById(\'regiok\').value = '.$data->region.';
						</script>
					</td>
				<td valign="top"><br /><fieldset><legend>Tevékenységi körök</legend>';

				$cats = $db->get_results("SELECT catID FROM switch WHERE cID = '".$data->id."'", ARRAY_N);

				$catlist = array();

				foreach( $cats as $key => $c )
				{
					$catlist[] = $c[0];
					//debug it :) hop itt will be never needed ;)
					//echo $c[0]. ' ';
				}

				$oszlopok = $db->get_var("SELECT COUNT(*) FROM categories WHERE parent = '0'");
				$c = 0;
				$entries = round( $oszlopok / 3 );

				$cats = $db->get_results("SELECT * FROM categories");
				
				foreach ( $cats as $sor )
				{
				
						if( $sor->parent == 0 ) 
						{
							if( $c == $entries || $c == 0 )
							{
								echo"<div id='oszlop'>";
							}
									if( in_array( $sor->id, $catlist ) )
									{
										echo '<div style="padding-bottom: 3px;"><u>'.$sor->category.'</u><input type="checkbox" value="'.$sor->id.'" name="cat[]" CHECKED></div><br>';

									}else{
									
										echo '<div style="padding-bottom: 3px;"><u>'.$sor->category.'</u><input type="checkbox" value="'.$sor->id.'" name="cat[]"></div><br>';
									}

							$actual = $sor->id;
				
								foreach ( $cats as $sorok )
								{
									if( $sorok->parent == $actual )
									{
										// Itt döntöm el, hogy kell-e neki pipa :)
										
										$hidden = ( $sorok->hidden == 1 ) ? " <span style='color: #f00;font-weight: bold'>(r)</span>" : "";

										if( in_array( $sorok->id, $catlist ) )
										{
										  echo "<input type='checkbox' value='".$sorok->id."' name='cat[]' checked='checked'> ".$sorok->category.$hidden."<br>";
										} else {
										  echo "<input type='checkbox' value='".$sorok->id."' name='cat[]'> ".$sorok->category.$hidden."<br>";
										}
									}
								}
							echo"<br />";

							if( $c == $entries - 1 ){
								echo"</div>";
								$c = 0;
							} 
							else {	$c++;	}
						}
				} 

			echo '</fieldset></td>
			  </tr>
			</table></form>';
	}

	/* *****************************
	    SZERKESZTÉS FELDOLGOZÁSA
	***************************** */

	function comp_parse_edit( $id, $cname, $address, $places, $email, $region, $city, $tel, $url, $brands, $description, $description_en, $description_de, $cats, $page, $advcat, $advcat_en, $advcat_de, $fax, $iso )
	{
		global $db;

        // képek törlése

        if( isset( $_POST['delete'] ) ){
        
                foreach( $_POST['delete'] as $d ){
                        
                        $img = explode( '|', $d );
                        
                        // Remove from DB
                        $db->query($x = "DELETE FROM kepek WHERE id = " . $img[0] );
                        echo $x;
                        // Delete files as well
                        if( file_exists( '../uploaded/' . $img[1] ) ) unlink( '../uploaded/' . $img[1] );
                        if( file_exists( '../uploaded/thumbs/' . $img[1] ) ) unlink( '../uploaded/thumbs/' . $img[1] );
                }        
        }
			/* Képek beillesztése */

			if( !empty( $_FILES ) ){

                 include( 'ImageFilter.class.php' );

                 $x = 0;
                 foreach( $_FILES['img']['tmp_name'] as $tmp ){

                        $origName = $_FILES['img']['name'][ $x ];
                        
                        // Get file extension
                        $ext = strrchr( $origName, ".");

                        // Generate non existing filename
                        $hash = md5( $_FILES['img']['tmp_name'][ $x ] );

                        while( file_exists( _BASE_PATH . $hash . $ext ) ){
                        
                                $hash = md5( $_FILES['img']['tmp_name'][ $x ] . mt_rand( 0, 1000 ) );
                        }

////////////////////////////////////////////////////////

                        // If it was an image, resize it...

                        if( @getimagesize( $tmp ) ){

                            // Move uploaded file to the uploaded dir, Resizing from temp file doesen't work
                            $up = move_uploaded_file( $tmp, _BASE_PATH . 'uploaded/' . $hash . $ext );

                            // First resizing
                                $chain = array();
                                $chain[] = array('resize', array('width' => 453, 'noaspect' => false ));
                                //$chain[] = array('crop', array('width' => 100, 'height' => 100, 'valign' => 'middle'));

                                $m = new ImageModifier( $chain ); 
                                $m->load( '../uploaded/' . $hash . $ext );
                                $t = $m->getGD();

                            // Delete original file, it is not needed anymore
                            unlink( _BASE_PATH . 'uploaded/' . $hash . $ext );

                            // Create big resized file
                            imageJpeg( $t,  _BASE_PATH . 'uploaded/' . $hash . $ext );

                            // Seconf resizing // Based on the resized file
                                $chain2 = array();
                                $chain2[] = array('resize', array('width' => 150, 'noaspect' => false ));
                                //$chain[] = array('crop', array('width' => 100, 'height' => 100, 'valign' => 'middle'));

                                $n = new ImageModifier( $chain2 ); 
                                $n->load( '../uploaded/' . $hash . $ext );

                            // Create thumbnail
                            imageJpeg( $n->getGD(),  _BASE_PATH . 'uploaded/thumbs/' . $hash . $ext );
                        }

////////////////////////////////////////////////////////

                        $x++;
                        
                        // Beszúrás adatbázisba
                        
                        if( $ext ) $db->query("INSERT INTO kepek( id, ceg_id, url ) values( NULL, '".$id."', '".$hash . $ext."' )");
                        //var_dump( $z );
                 }
			} // img upload end
			
		if( !empty( $cats ) ){
			$leker = $db->query("UPDATE companies SET address = '".$address."',
								cname = '".$cname."',
								email = '".$email."',
								region = '".$region."',
								city = '".$city."',
								tel = '".$tel."',
								url = '".$url."',
								brands = '".$brands."',
								description = '".nl2br($description)."',
								description_en = '".nl2br($description_en)."',
								description_de = '".nl2br($description_de)."',
								advcat = '".$advcat."',
								advcat_en = '".$advcat_en."',
								advcat_de = '".$advcat_de."',
								fax = '".$fax."',
								iso = '".$iso."',
								places = '".nl2br($places)."' WHERE id = '".$id."'");

			$db->query("DELETE FROM switch WHERE cID = '".$id."'");

			foreach( $cats as $insert ){
				$db->query("INSERT INTO switch( cID, catID ) values( '".$id."', '".$insert."' )");
			}
		} else {
		var_dump($_POST);
			echo"Kategóriát kötelező megadni!<a href='javascript: history.back()'> Vissza az előző oldalra</a>";
			exit();
		}
		echo"<script>document.location = 'index.php?do=comp_list&BRSR=".$page."' </script>";
	}
	
	/* **********************
		B2B PASWORD KÜLDŐ
	********************** */

	/* id address cname email region city tel url brands description places pass ts */
	/* 1  2		  3		4	  5      6    7   8   9      10 		 11		12   13
	*/

	function b2b_pass( $q )
	{
		global $ezr;
		global $db;
		
		$search = ( $q ) ? "WHERE LOWER(cname) LIKE '%$q%'" : '';
		
		echo "<form action='index.php' method='get'><input type='hidden' name='do' value='b2b_pass'><input type='text' name='q'><input type='submit'></form>";
		echo "<h2>Jelszó kiküldése cégek részére</h2>";

		$ezr->nav_top = true;
		$ezr->nav_bottom = true;
		$ezr->num_results_per_page = 50;
		$ezr->set_qs_val("do","b2b_pass");
		$ezr->results_empty = "Lekérdezés hiba!";
		$ezr->results_open = "<table cellpadding='3' cellspacing='1' width='500'>";
		$ezr->results_heading = "<tr class='tr_head'> <td>Cég neve</td><td>Telefon</td><td>Város</td><td>Küldés</td><td>Státusz</td> </tr>";
		$ezr->results_row = "<tr class='row' valign='top'> 
								<td><strong><a href='?do=comp_edit&id=COL1'>COL3</a></strong></td>
								<td>COL7</td>
								<td>COL6</td>
								<td><a href='?do=b2b_sendmail&id=COL1'><img src='img/send.gif' align='absmiddle'> Küldés</a></td> 
								<td align='center'><img src='img/COL16.gif'></td> 
							</tr>";
		$ezr->text_count = "NUMBER cég az adatbázisban";
		$ezr->query_mysql("SELECT * FROM companies ".$search." ORDER BY cname");
        $ezr->display();
	}
	
	function b2b_reactivate( $id ){
        
        $t = mysql_query( "UPDATE offers SET ts = UNIX_TIMESTAMP() WHERE id = " . $id );

		if( $t ) echo"<script> document.location = 'index.php?do=b2b_lejart' </script>";
		else echo"<script> alert('MySQL error')</script>";
	}

	function b2b_sendmail( $id )
	{
		global $db;

		$data = $db->get_row("SELECT email, pass, cname FROM companies WHERE id='".$id."'");
		
		$message = "<h3>Tisztelt ".$data->cname.",</h3>Az alábbi jelszóval be tud lépni B2B ajánlatküldő rendszerébe:<br> A jelszó: ".$data->pass." <br> Az alábbi linken a beléptető oldalra kerül.<br><br> <a href='http://www.magyaruzletitudakozo.hu'>Tovább a Magyar üzleti tudakozó oldalára.</a>";

		$a = include("../phpmailer/class.phpmailer.php");
		
		$mail = new phpmailer();

		$mail->CharSet  = "utf-8";
		$mail->From     = 'noreply@magyaruzletitudakozo..hu';
		$mail->FromName = "Magyar Üzleti Tudakozó";
		$mail->Mailer   = "mail";
		$mail->Subject  = "Aktiváltuk B2B szolgáltatásunkat";

		// HTML body
		$body = $message;

		// Plain text body (for mail clients that cannot read HTML)
		$text_body  = strip_tags( $message );

		$mail->Body    = $body;
		$mail->AltBody = $text_body;

		$mail->AddAddress( $data->email, $data->cname );						

		if( $mail->Send() ){
			//echo'ok';
			$db->query("UPDATE companies SET active = '1' WHERE id = '".$id."'");
			echo"<script> document.location = 'index.php?do=b2b_pass' </script>";

		} else {

			echo "<strong>Hiba történt a jelszó küldése közben... <br />
					Próbáld meg újra, vagy kérj segítséget!</strong>";
		}
	}

	/* *****************************
		B2B UNIVERZÁLIS LISTÁZÓ :)
	***************************** */

	function b2b_list( $type )
	{
		global $ezr;
		global $db;

		switch( $type ){
		
			case 'ker':	
				echo "<h2><font color='#aa0000'>Keres</font> ajánlatok listázása:</h2>";
				$typestr = "Keres";
			break;

			case 'kin':	
				echo "<h2><font color='#aa0000'>Kínál</font> ajánlatok listázása:</h2>";
				$typestr = "Kínál";
			break;

			case 'over':	
				echo "<h2><font color='#aa0000'>Lejárt</font> ajánlatok listázása:</h2>";
				$typestr = "Lejárt";
			break;
		}
		//  Egy kis segítség :)
		// 	-----------------------------------------------------
		//  id  	 fejlec  	 offer  	 cID  	 ts  	 type
		//	col1	 col2		 col3		 col4	 col5	 col6
		
		function modme( $col1, $col2, $col3, $col4, $col5, $col6 ){
			global $db;

			$cname = $db->get_var("SELECT cname FROM companies WHERE id = '".$col4."'");
			$col4 = $cname;

			$fortnight = mktime(date("H", $col5), date("i", $col5), 0, date("m", $col5), date("d", $col5)+60, date("Y", $col5));
			
			$col5 = date("Y/m/d H:i",$col5) ." <strong>Lejár:</strong> " . date("Y/m/d H:i",$fortnight);
			
			$kategoriak = $db->get_results("SELECT * FROM categories WHERE id IN ( SELECT catID FROM switch WHERE oID = '".$col1."' )");

			$col3 .= "</span><p><strong>Kategóriák:</strong></p>";

			foreach( $kategoriak as $cats ){
				$col3 .= " " . $cats->category . " ";
			}

			
		}
		if( $type == 'over' ){
            
            $react = "<a href='javascript:reactivateOffer( \"COL1\" )'><font size='3'><img src='img/ok.gif' title='Törlés' align='absmiddle'> ÚJRA AKTIVÁL </font>";
		
		} else {
            
            $react = '';
		}
		$ezr->nav_top = true;
		$ezr->nav_bottom = true;
		$ezr->num_results_per_page = 50;
		$ezr->set_qs_val("do","b2b_list");
		$ezr->register_function( 'modme' );
		$ezr->results_empty = "Még nem érkeztek ajánlatok ebbe a kategóriába.";
		$ezr->results_open = "<table cellpadding='3' cellspacing='1' width='500'>";
		$ezr->results_heading = "<tr class='tr_head'> <td>Cég neve: </td><td>Beküldve: </td> </tr>";
		$ezr->results_row = "<tr class='row'>
								 <td width='200'><strong>COL4</strong></td>
								 <td>COL5</td>
							 <tr>
							 <tr class='row' valign='top'> 
								 <td colspan='2'><strong>Fejléc: COL2</strong><br><a onclick='toggle(\"offCOL1\")' style='cursor: pointer;'><img src='img/i.png' align='absmiddle'>Részletek</a><br><span id='offCOL1' style='display: none;'>COL3
								 <p align='right'>$react<a href='javascript:deleteOffer( \"COL1\" )'><font size='3'><img src='img/delete.gif' title='Törlés' align='absmiddle'> TÖRLÉS </font></p>
								 </td>
							 </tr>";
		$ezr->text_count = "NUMBERdb $typestr ajánlat az adatbázisban";

		if( $type == 'over' ){
			// Mához két hétre lévő TIMESTAMP
			$fortnight = mktime(date("H", time()), date("i", time()), 0, date("m", time()), date("d", time())+60, date("Y", time()));
			$ezr->query_mysql("SELECT * FROM offers WHERE ts + '4838400' < UNIX_TIMESTAMP() AND active = '1'");

		} else {

			$ezr->query_mysql("SELECT * FROM offers WHERE type = '".$type."' AND ts + '4838400' > UNIX_TIMESTAMP() AND active = '1'");
		}
        $ezr->display();
	}

	function b2b_del_offer( $id ){
		global $db;
		$db->query("DELETE FROM offers WHERE id = '".$id."'");
		echo"<script> document.location = 'index.php?do=b2b_pass' </script>";
	}

	function b2b_apply( $id ){
		global $db;
		$db->query("UPDATE offers SET active = '1' WHERE id = '".$id."'");
		echo"<script> document.location = 'index.php?do=b2b_activate' </script>";
	}
	
	function b2b_activate()
	{
		global $ezr;
		global $db;

		echo "<h2><font color='#aa0000'>Elbírálás alatt lévő</font> ajánlatok listázása:</h2>";

		//  Egy kis segítség :)
		// 	-----------------------------------------------------
		//  id  	 fejlec  	 offer  	 cID  	 ts  	 type	active
		//	col1	 col2		 col3		 col4	 col5	 col6	col7
		
		function modme( $col1, $col2, $col3, $col4, $col5, $col6, $col7 ){
			global $db;

			$cname = $db->get_var("SELECT cname FROM companies WHERE id = '".$col4."'");
			$col4 = $cname;

			$fortnight = mktime(date("H", $col5), date("i", $col5), 0, date("m", $col5), date("d", $col5)+60, date("Y", $col5));
			
			$col5 = date("Y/m/d H:i",$col5) ." <strong>Lejár:</strong> " . date("Y/m/d H:i",$fortnight);
			
			$kategoriak = $db->get_results("SELECT * FROM categories WHERE id IN ( SELECT catID FROM switch WHERE oID = '".$col1."' )");

			$col3 .= "</span><p><strong>Kategóriák:</strong></p>";

			foreach( $kategoriak as $cats ){
				$col3 .= " " . $cats->category . " ";
			}
		}
		$ezr->nav_top = true;
		$ezr->nav_bottom = true;
		$ezr->num_results_per_page = 50;
		$ezr->set_qs_val("do","b2b_activate");
		$ezr->register_function( 'modme' );
		$ezr->results_empty = "Nincs elbírálás alatt lévő ajánlat.";
		$ezr->results_open = "<table cellpadding='3' cellspacing='1' width='500'>";
		$ezr->results_heading = "<tr class='tr_head'> <td>Cég neve: </td><td>Beküldve: </td> </tr>";
		$ezr->results_row = "<tr class='row'>
								 <td width='200'><strong>COL4</strong></td>
								 <td>COL5</td>
							 <tr>
							 <tr class='row' valign='top'> 
								 <td colspan='2'><strong>Fejléc: COL2</strong><br><a onclick='toggle(\"offCOL1\")' style='cursor: pointer;'><img src='img/i.png' align='absmiddle'>Részletek</a><br><span id='offCOL1' style='display: none;'>COL3
								 <p align='right'><a href='index.php?do=b2b_apply&id=COL1'><font size='3'><img src='img/ok.gif' title='Ajánlat jóváhagyása' align='absmiddle'> Jóváhagyás </font><a href='javascript:deleteOffer( \"COL1\" )'><font size='3'><img src='img/delete.gif' title='Törlés' align='absmiddle'> Törlés </font></p>
								 </td>
							 </tr>";
		$ezr->text_count = "NUMBERdb függőben lévő ajánlat az adatbázisban";

		$ezr->query_mysql("SELECT * FROM offers WHERE ts + '4838400' > UNIX_TIMESTAMP() AND active = 0");

        $ezr->display();
	}
	function config()
	{
		global $ezr;
		global $db;
		
		echo'';
		
		function modme( $col1, $col2, $col3, $col4 ){
			global $db;

			$col4 = ( $col4 == 'A' ) ? 'Adminisztrátor' : 'Rendszergazda';
		}

		$bal = implode( file( '../adv_bal.nfo' ));
		$jobb = implode( file( '../adv_jobb.nfo' ));

		$ezr->nav_top = true;
		$ezr->nav_bottom = true;
		$ezr->num_results_per_page = 50;
		$ezr->register_function( 'modme' );
		$ezr->set_qs_val("do","config");
		$ezr->results_open = "<fieldset><legend>Felhasználó kezelő</legend><table cellpadding='3' cellspacing='1' width='75%'>";
		$ezr->results_heading = "<tr class='tr_head'> <td>Felhasználó neve: </td><td>Jelszava: </td><td>Szerepe </td><td> </td> </tr>";
		$ezr->results_row = "<tr class='row'>
								 <td width='200'><form action='index.php?do=modify_user' method='post'><input type='text' name='user' value='COL2'></td>
								 <td><input type='password' name='pass' value='COL3'>
								 <input type='hidden' name='uid' value='COL1'></td>
								 <td>COL4</td>
								 <td width='210'><input type='button' value='Törlés' onclick='document.location = \"index.php?do=del_user&id=COL1\"'><input type='submit' value='módosítás'></form></td>
							 <tr>";
							 
		$ezr->text_count = "NUMBER felhasználó";

		$ezr->query_mysql("SELECT * FROM felhasznalok ORDER BY user ASC");

        $ezr->display();

		echo "<hr>";
		
		echo'<form action="index.php?do=add_user" method="post">';

		echo"<table cellpadding='3' cellspacing='1' width='500'>";
		echo"<tr class='tr_head'> <td>ÚJ Felhasználó neve: </td><td>Jelszava: </td><td>Szerepe: </td> </tr>";
		echo"<tr class='row'>
							 <td width='200'><input type='text' name='user' value=''></td>
							 <td><input type='password' name='pass' value=''></td>
							 <td><select name='sz'><option value='A'>Adminisztrátor</option><option value='S'>Rendszergazda</option></select></td>
			 <tr></table>";

		echo "<br><input type='submit'></form></fieldset><hr>";
		
		echo"<fieldset><legend>Hirdetés kezelő</legend><form action='index.php?do=mod_ad_links' method='post'><table cellpadding='3' cellspacing='1' width='500'>";
		echo"<tr class='tr_head'> <td>Bal oldali hirdetés linkjei: </td><td>Jobb oldali hirdetés linkjei: </td> </tr>";
		echo"<tr class='row'>

							 <td><textarea name='bal' style='width: 240px; height: 100px'>$bal</textarea></td>
							 <td><textarea name='jobb' style='width: 240px; height: 100px'>$jobb</textarea></td>

			 <tr></table><br><input type='submit' value='Módisít'></form></fieldset>";	

	}
}
?>
