<?php

class mainframe{

    function mainframe(){
        global $dict, $lang;
        $this->dict = $dict;
        $this->lang = $lang;
    }

	function pager($osszes, $limit, $tol, $megjelenik=9)
	{
		$back = array();
	
		if($tol <= 0) $back['prevenabled'] = false;
		else $back['prevenabled'] = true;
	
		if(($tol+$limit) >= $osszes) $back['nextenabled'] = false;
		else $back['nextenabled'] = true;
	
		$min_position = $tol-(floor($megjelenik/2))*$limit;
		$max_position = $tol+(floor($megjelenik/2))*$limit;
	
		if($min_position<0) while($min_position<0) {$max_position+=$limit;$min_position+=$limit;};
	
		if($max_position>$osszes) while($max_position>($limit*floor($osszes/$limit))) {$max_position-=$limit;$min_position-=$limit;};
	
		$back['tolok'] = array();
	
		for($i=0;$osszes>($limit*($i));$i++)
		{
			$curr_tol=$limit*$i;
	
			if(($curr_tol>=$min_position)&&($curr_tol<=$max_position))
			{
				if($curr_tol == $tol) $selected=true;
				else $selected=false;
	
				$back['tolok'][] = array
				(
					'tol' 		=> $curr_tol,
					'szam' 		=> ($i+1),
					'selected' 	=> $selected,
				);
			}
		}
		$back['tol'] = ($tol+1).'-'.((($tol+$limit)<$osszes)?($tol+$limit):$osszes);
		$back['limit'] = $limit;
		$back['osszes'] = $osszes;
		$back['prev'] = $tol-$limit;
		$back['next'] = $tol+$limit;
		$back['first'] = 0;
		$back['last'] = $limit*floor($osszes/$limit);
	
		return $back;
	}
	
	function get_regions()
	{
		$regions = file('data/region.dat');
		$mydata = array();
		foreach( $regions as $stuff ){
			$data = explode( '::', $stuff );
			$mydata[ $data[0] ] = $data[1];
		}
		return $mydata;
	}

	function comp_list( $id, $cat_name, $parent ){

		global $db;

		$perlap = 20;

		$lap = isset( $_GET['lap'] ) ? $_GET['lap'] : 0;
		
		$cat = isset( $_GET['cat'] ) ? $_GET['cat'] : 0;
		
		$cat_name = isset( $_GET['cat_name'] ) ? $_GET['cat_name'] : 0;
		
		$parent = isset( $_GET['parent'] ) ? $_GET['parent'] : false;
		
		/*********** SECURITY **************************/
			
			$id = addslashes( $id );
			$cat_name = addslashes( $cat_name );
			
		/***********************************************/

		if( $parent == 'true' )
		{
			// RÉGI QUERY
			/*
			$sql = "SELECT * FROM companies 
					WHERE 
					LOWER( address ) LIKE '%".$cat_name."%' OR 
					LOWER( places ) LIKE '%".$cat_name."%' OR 
					LOWER( cname ) LIKE '%".$cat_name."%' OR 
					LOWER( url ) LIKE '%".$cat_name."%' OR 
					LOWER( brands ) LIKE '%".$cat_name."%' OR 
					LOWER( description ) LIKE '%".$cat_name."%' OR 
					id IN ( SELECT cID FROM switch WHERE catID IN ( SELECT id FROM categories WHERE LOWER( category ) LIKE '%".$cat_name."%' ))
					ORDER BY LOWER( cname )
					LIMIT $lap,$perlap";
			*/

			$sql = "SELECT companies.*, switch.catID, sorrend.hely
					FROM companies
					LEFT JOIN switch ON switch.cID = id
					LEFT JOIN sorrend ON sorrend.cegID = companies.id
					AND sorrend.catID = switch.catID
					WHERE switch.catID = '$id'
					ORDER BY hely DESC, cname ASC
					LIMIT $lap,$perlap";

			$ossz = "SELECT companies.*, switch.catID, sorrend.hely
					FROM companies
					LEFT JOIN switch ON switch.cID = id
					LEFT JOIN sorrend ON sorrend.cegID = companies.id
					AND sorrend.catID = switch.catID
					WHERE switch.catID = '$id'
					ORDER BY hely DESC";
		}

		else

		{
			$sql = "SELECT companies.*, switch.catID, sorrend.hely
					FROM companies
					LEFT JOIN switch ON switch.cID = id
					LEFT JOIN sorrend ON sorrend.cegID = companies.id
					AND sorrend.catID = switch.catID
					WHERE switch.catID = '$id'
					ORDER BY hely DESC, cname ASC
					LIMIT $lap,$perlap";

			$ossz = "SELECT companies.*, switch.catID, sorrend.hely
					FROM companies
					LEFT JOIN switch ON switch.cID = id
					LEFT JOIN sorrend ON sorrend.cegID = companies.id
					AND sorrend.catID = switch.catID
					WHERE switch.catID = '$id'
					ORDER BY hely DESC";
		}

		// LEKÉRDEZÉSEK

						 mysql_query("SET NAMES UTF8 COLLATE utf8_general_ci");

		$result		=	 mysql_query( $sql );
		
		$osszes		=	 mysql_query( $ossz );

		$total 		= 	 mysql_num_rows( $osszes );
//echo $sql;
		// LAPOZÁS

		$pager = $this->pager( $total, $perlap, $lap );
		
			
		echo "<span><h2 align='center'>".$this->dict[$_SESSION['lang']]['cat'].':  '.$cat_name."</h2>";
		echo "<div class='nav'>";
		echo "<strong>".$this->dict[$_SESSION['lang']]['results'].": ".$total."</strong><br>";
		
		/* id address cname email region city tel url brands description places pass ts */
		/* 0  1		  2		3	  4      5    6   7   8      9 		 	 10		11   12 */

		if( $total > $perlap )
		{

			echo $this->dict[$_SESSION['lang']]['paging'].': ';

			if( $pager['prevenabled'] ) 
			{ 
				echo '<a href="index.php?do=comp_list&cat='.$cat.'&cat_name='.$cat_name.'&parent='.$parent.'&lap='. $pager['prev'] .'">'.$this->dict[$_SESSION['lang']]['prev'].'</a>'; 
			}
			
			foreach ( $pager['tolok'] as $tol )
			{
			
					if( $tol['selected'] )
					{
						echo'<b style="color: #fff"> ' . $tol['szam'] . ' </b>';

					} else {

						echo'<a class="navlink" href="index.php?do=comp_list&cat='.$cat.'&cat_name='.$cat_name.'&parent='.$parent.'&lap=' . $tol['tol'] . '"><b> ' . $tol['szam'] . ' </b></a>';
					}
			}

			if( $pager['nextenabled'] )
			{
						echo'<a href="index.php?do=comp_list&cat='.$cat.'&cat_name='.$cat_name.'&parent='.$parent.'&lap=' .  $pager['next'] . '">'.$this->dict[$_SESSION['lang']]['next'].'</a>';
			}
		}

		echo "</div>";

		$eredmenyek = array();
		$helyezesek = array();
		$ceg = array();

		echo "<table cellpadding='3' cellspacing='1' width='95%' id='lister'>
		<tr class='tr_head'> <td>".$this->dict[$_SESSION['lang']]['cname']."</td><td>".$this->dict[$_SESSION['lang']]['phone']."</td><td>".$this->dict[$_SESSION['lang']]['city']."</td><td>E-mail</td> </tr>";

		while( $res = mysql_fetch_row( $result ) ){
		
				$eredmenyek[] = $res;
				$helyezesek[] = ( isset($res[22]) ) ? $res[22] : 9999;
				$ceg[] = $res[2];
		}

		array_multisort( $helyezesek, SORT_ASC, $ceg, SORT_ASC, $eredmenyek );

		foreach( $eredmenyek as $res ){
				echo"<tr class='row' valign='top'>
								<td><strong><a href=\"?do=comp_show&cname=".$res[2]."\">".$res[2]."</a></strong></td>
								<td>".$res[6]."</td>
								<td>".$res[5]."</td>
								<td>".$res[3]."</td> 
					 </tr>";
		}
		
		echo "</table>";
	}
	
	function comp_show( $id, $cname ){
		global $db;
		/*********** SECURITY ***********/
			$id = addslashes( $id );
			$cname = addslashes( $cname );

		/********************************/
//		$data = $db->get_row("SELECT * FROM companies WHERE id = '".$id."'");
		$data = $db->get_row("SELECT * FROM companies WHERE cname = '$cname'");

		$regions = $this->get_regions();
            
            $img = $db->get_results( 'SELECT * FROM kepek WHERE ceg_id = ' . $data->id );

			echo '<div class="imagesw">';

            if( $img ){
                foreach( $img as $i ){
                    echo "<div class='thumbs'><a href='uploaded/".$i->url."' rel='lightbox[example]'><img alt='".$i->id."' src='uploaded/thumbs/".$i->url."'></a></div>";
                }
            }
            echo '</div>';
            
		echo'<table width="100%" border="0" cellspacing="0" cellpadding="0" id="lister" align="center">
			  <tr>
				<td width="600" valign="top" style="position:relative">
					<h3>&nbsp;'.$data->cname.' ('.$data->city.')</h3>
					
					<input type="hidden" name="id" value="'.$data->id.'" />
						<table width="530" border="0" cellspacing="3" cellpadding="1" bgcolor="">
						  <tr>
							<td align="right" valign="middle"></td>
							<td>'.$regions[$data->region].'</td>
						  </tr>
						  <tr>
							<td align="right" valign="middle"> </td>
							<td>'.$data->address.'</td>
						  </tr>
						  <tr>
							<td align="right" valign="top"><strong>'.$this->dict[$_SESSION['lang']]['phone'].'</strong></td>
							<td>'.nl2br($data->tel).' <br><strong>Fax: </strong>'.$data->fax.' </td>
						  </tr>
						  <tr>
							<td align="right" valign="top"><strong>'.$this->dict[$_SESSION['lang']]['tevek'].': </strong></td>
							<td>';
							switch( $this->lang ){
								case 'hu':
									echo $data->advcat;
								break;
								case 'en':
									echo $data->advcat_en;
								break;
								case 'de':
									echo $data->advcat_de;
								break;
							}
						  echo '</td>
						  </tr>
						  <tr>
							<td align="right" valign="middle"><strong>'.$this->dict[$_SESSION['lang']]['iso'].': </strong></td>
							<td>'.$data->iso.'</td>
						  </tr>
						  <tr>
							<td align="right" valign="top"><strong>'.$this->dict[$_SESSION['lang']]['brands'].': </strong></td>
							<td>'.$data->brands.'<br />
						  </tr>
						  <tr>
							<td align="right" valign="middle"></td>
							<td><strong>Web:</strong> <a href="http://'.$data->url.'">'.$data->url.'</a> <strong>E-mail:</strong> <a href="mailto:'.$data->email.'">'.$data->email.'</a></td>
						  </tr>
						  <tr>
							<td align="right" valign="top"><strong>'.$this->dict[$_SESSION['lang']]['intro'].': </strong></td>
							<td>';
							switch( $this->lang ){
								case 'hu':
									echo $data->description;
								break;
								case 'en':
									echo $data->description_en;
								break;
								case 'de':
									echo $data->description_de;
								break;
							}
							
							echo '</td>
						  </tr>
						  <tr>
							<td align="right" valign="top"><strong>'.$this->dict[$_SESSION['lang']]['address'].': </strong></td>
							<td>'.$data->places.'</td>
						  </tr>				
						  <tr>
							<td align="right" valign="top"><strong>'.$this->dict[$_SESSION['lang']]['map'].': </strong></td>
							<td>
								<div id="google_map" style="height:300px;width:500px;"> </div>
								<div id="googleinfo" style="display:none;"><strong>Cím:</strong> '.$data->address.'</div>
								<script>
									window.onload = function(){ draw_map( "google_map", "'.$data->address.'", "" ); };
								</script>
							</td>
						  </tr>
						</table>
						<br />';

						//
						// Ha később mégis kellenének a kategóriák...
						//

						/*
						<fieldset><legend><strong>Tevékenységi körök:</strong></legend>';

						$kategoriak = $db->get_results("SELECT * FROM categories WHERE id IN ( SELECT catID FROM switch WHERE cID = '".$id."' )");

						$col3 = "<strong>Kategóriák: </strong>";
			
						foreach( $kategoriak as $cats ){
							$col3 .= $cats->category . " ";
						}
						echo $col3."</fieldset>*/
						
						echo"</td></tr>
						</table>";
	}

	function comp_search( $cname, $cat, $city, $iso, $brand, $region, $type, $keyword )
	{

		/*********** SECURITY ***********/
			$cname 	= addslashes( mb_strtolower(  urldecode($cname), 'UTF8'));
			$cat 	= addslashes( mb_strtolower(  urldecode($cat),	 'UTF8'));
			$city 	= addslashes( mb_strtolower(  urldecode($city),	 'UTF8'));
			$iso 	= addslashes( mb_strtolower(  urldecode($iso),	 'UTF8'));
			$brand 	= addslashes( mb_strtolower(  urldecode($brand), 'UTF8'));
			$region = addslashes( mb_strtolower(  urldecode($region),'UTF8'));
			//
			$type = addslashes( $type );
			//

			$keyword = addslashes( mb_strtolower( urldecode( $keyword ), 'UTF8'));

		/********************************/

		mysql_query("SET NAMES UTF8 COLLATE utf8_general_ci");
		
		/********************************/

		$queryStr = 'SELECT *  FROM companies WHERE ';

		switch( $type ){

			case "adv":

				$cname = ( $cname == '' ) ? '' : "LOWER( cname ) LIKE '%".$cname."%'";
				$cat = ( $cat == '' ) ? '' :  "( id IN ( SELECT cID FROM switch WHERE catID IN ( SELECT id FROM categories WHERE LOWER( category ) LIKE '%".$cat."%' )) OR LOWER( advcat ) LIKE '%".$cat."%' )";
				
				$city = ( $city == '' ) ? '' : "LOWER( city ) LIKE '%".$city."%'";
				$iso = ( $iso == '' ) ? '' : "LOWER( iso ) LIKE '%".$iso."%'";
				$brand = ( $brand == '' ) ? '' : "LOWER( brands ) LIKE '%".$brand."%'";
				$region = ( $region == '' ) ? '' : "region = '".$region."'";

				$queryStr = ( $cname == '' ) ? 	$queryStr : $queryStr . $cname . ' AND ';
				$queryStr = ( $cat == '' ) ? 	$queryStr : $queryStr . $cat . ' AND ';
				$queryStr = ( $city == '' ) ? 	$queryStr : $queryStr . $city . ' AND ';
				$queryStr = ( $iso == '' ) ? 	$queryStr : $queryStr . $iso . ' AND ';
				$queryStr = ( $brand == '' ) ? 	$queryStr : $queryStr . $brand . ' AND ';
				$queryStr = ( $region == '' ) ? $queryStr : $queryStr . $region;

				$queryStr = ( substr( $queryStr, -4 ) == 'AND ' ) ? substr( $queryStr, 0, strlen( $queryStr )-4) : $queryStr;

				//Debug, remélem sohasem kell már... ;)
				//echo $queryStr;

				$sql = $queryStr;

				$head = false;

			break;

			case "free":

				$test = mysql_query( "SELECT id FROM categories WHERE LOWER( category ) = '$keyword'" );

				//$mivan  = mysql_num_rows( $test );
				$mivan  = mysql_fetch_array( $test );

//var_dump( $mivan );

				if( $mivan > 0 )
				{

						$sql  = "SELECT companies.*, switch.catID, sorrend.hely
										FROM companies
										LEFT JOIN switch ON switch.cID = id
										LEFT JOIN sorrend ON sorrend.cegID = companies.id
										AND sorrend.catID = switch.catID
										WHERE switch.catID = ( SELECT id FROM categories WHERE LOWER(category) = '".$keyword."' OR category = '.$keyword.' )
										ORDER BY hely DESC, companies.cname ASC";

				} else {

						$sql   = "SELECT * FROM companies WHERE ";
						$sql  .= "LOWER( cname ) LIKE '%".$keyword."%' ";
						$sql  .= "OR id IN ( SELECT cID FROM switch WHERE catID IN ( SELECT id FROM categories WHERE LOWER( category ) LIKE '%".$keyword."%' )) OR LOWER( advcat ) LIKE '%".$keyword."%' ";
						$sql  .= "OR LOWER( brands ) LIKE '%".$keyword."%' ";
						$sql  .= "ORDER by cname DESC";
//echo $sql;
				}

				$head = true;
			break;

		}

		if( $head ) echo "<h2 align='center'>".$this->dict[$_SESSION['lang']]['results']." \"". stripslashes($keyword) ."\" ".$this->dict[$_SESSION['lang']]['keyword']."</h2>";

		$result		=	 mysql_query( $sql );
		
		$total 		= 	 mysql_num_rows( $result );

		// LAPOZÁS

		echo "<div class='nav'>";
		echo "<strong>".$this->dict[$_SESSION['lang']]['total_res'].": ".$total."</strong><br>";
		
		/* id address cname email region city tel url brands description places pass ts */
		/* 0  1		  2		3	  4      5    6   7   8      9 		 	 10		11   12 */


		$eredmenyek = array();
		$helyezesek = array();
		$ceg = array();

		echo "<table cellpadding='3' cellspacing='1' width='95%' id='lister'>
		<tr class='tr_head'> <td>".$this->dict[$_SESSION['lang']]['cname']."</td><td>".$this->dict[$_SESSION['lang']]['phone']."</td><td>".$this->dict[$_SESSION['lang']]['city']."</td><td>E-mail</td> </tr>";

		while( $res = mysql_fetch_row( $result ) ){
		
				$eredmenyek[] = $res;
				$helyezesek[] = ( isset($res[22]) ) ? $res[22] : 9999;
				$ceg[] = $res[2];
		}

		array_multisort( $helyezesek, SORT_ASC, $ceg, SORT_ASC, $eredmenyek );

		foreach( $eredmenyek as $res ){
				echo"<tr class='row' valign='top'>
								<td><strong><a href=\"?do=comp_show&cname=".$res[2]."\">".$res[2]."</a></strong></td>
								<td>".$res[6]."</td>
								<td>".$res[5]."</td>
								<td>".$res[3]."</td> 
					 </tr>";
		}
		
		echo "</table>";

	}

	function init(){
		global $db;

		$oszlopok = $db->get_var("SELECT COUNT(*) FROM categories WHERE parent = '0'");
		$c = 0;
		$entries = round( $oszlopok / 3 );
		$cats = $db->get_results("SELECT * FROM categories ORDER BY category");
		$even = '';
		foreach ( $cats as $sor )
		{
		        // Lang
		        switch( $_SESSION['lang'] ){
                    case 'hu':
                        // nothing
                    break;
                    case 'en':
                        $sor->category = $sor->category_en;
                    break;
                    case 'de':
                        $sor->category = $sor->category_de;
                    break;
                } 
		        

				if( $sor->parent == 0 ) 
				{
					if( $c == $entries || $c == 0 )
					{
						echo"<div class='oszlop'>";
					}
		
					echo "<u><a href='index.php?do=comp_list&cat=".$sor->id."&cat_name=".$sor->category."&parent=true'>".$sor->category."</a></u><br>\n";
		
					$actual = $sor->id;
		
						foreach ( $cats as $sorok )
						{
            		        // Lang
            		        switch( $_SESSION['lang'] ){
                                case 'hu':
                                    // nothing
                                break;
                                case 'en':
                                    $sorok->category = $sorok->category_en;
                                break;
                                case 'de':
                                    $sorok->category = $sorok->category_de;
                                break;
                            } 
							if( $sorok->parent == $actual && $sorok->hidden == 0 )
							{
							  $even = ( $even == '' ) ? "class='odd'" : '';
							  echo "<a href='index.php?do=comp_list&cat=".$sorok->id."&cat_name=".$sorok->category."' ".$even.">".$sorok->category."</a>\n ";
							}
						}
					echo"<br />\n";

					if( $c == $entries - 1 ){
						echo" </div>\n ";
						$c = 0;
					} 
					else {	$c++;  }
				}
		} 
	}

	/* **********************
		SUBMENÜ B2B-hez
	********************** */
	
	function b2b_list( $type )
	{
		global $ezr;
		global $db;

		$type = addslashes( $type );

		switch( $type ){
		
			case 'ker':	
				echo "<h3><font color='#aa0000'>Ajánlatot</font> kérők listázása:</h3>";
				$typestr = "Keres";
			break;

			case 'kin':	
				echo "<h3><font color='#aa0000'>Ajánlatot</font> küldők listázása:</h3>";
				$typestr = "Kínál";
			break;

		}

		//  Egy kis segítség :)
		// 	-----------------------------------------------------
		//  id  	 fejlec  	 offer  	 cID  	 ts  	 type
		//	col1	 col2		 col3		 col4	 col5	 col6

		function modme( $col1, $col2, $col3, $col4, $col5, $col6 ){
			global $db;

			$cname = $db->get_var("SELECT cname FROM companies WHERE id = '".$col4."'");
			$col4 = "<a href=\"index.php?do=comp_show&cname=".$cname."\">" . $cname . "</a>";

			$fortnight = mktime(date("H", $col5), date("i", $col5), 0, date("m", $col5), date("d", $col5)+14, date("Y", $col5));

			$col5 = date("Y/m/d H:i",$col5) ." <strong>Lejár:</strong> " . date("Y/m/d H:i",$fortnight);

			$kategoriak = $db->get_results("SELECT * FROM categories WHERE id IN ( SELECT catID FROM switch WHERE oID = '".$col1."' )");

			$col3 .= "<p><strong>Kategóriák:</strong></p>";

			if( $kategoriak ){
				foreach( $kategoriak as $cats ){
					$col3 .= " " . $cats->category . " ";
				}
			}
		}
		$ezr->nav_top = true;
		$ezr->nav_bottom = true;
		$ezr->num_results_per_page = 50;
		$ezr->set_qs_val("do","comp_list");
		$ezr->register_function( 'modme' );
		$ezr->results_empty = "Jelenleg nincs aktuális ajánlat ebben a kategóriában.";
		$ezr->results_open = "<table cellpadding='3' cellspacing='1' width='500' id='lister'>";
		$ezr->results_heading = "<tr class='tr_head'> <td>Cég neve: </td><td>Beküldve: </td> </tr>";
		$ezr->results_row = "<tr class='row' style='background-color: #dfdfdf'>
								 <td width='200'><strong>COL4</strong></td>
								 <td>COL5</td>
							 <tr>
							 <tr class='row' valign='top'>
								 <td colspan='2'><strong>Ajánlat megnevezése: COL2</strong><br>COL3
							 </td>
							 </tr>";
		$ezr->text_count = "NUMBERdb $typestr ajánlat az adatbázisban";

		$ezr->query_mysql("SELECT * FROM offers WHERE type = '".$type."' AND ts + '1209600' > UNIX_TIMESTAMP() AND active = '1'");

        $ezr->display();
	}

	function b2b_add(){
		global $db;
		echo'<form id="form1" name="form1" method="post" action="index.php?do=b2b_parse">
			  <table width="80%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td><h3>Aj&aacute;nlat megnevez&eacute;se </h3></td>
				</tr>
				<tr>
				  <td class="padd"><input type="text" name="fejlec" style="border: 1px solid #333; width: 400px" /></td>
				</tr>
				<tr>
				  <td><h3>Aj&aacute;nlat t&iacute;pusa </h3></td>
				</tr>
				<tr>
				  <td class="padd"><select name="type">
				  		<option value="kin">Ajánlatot küldök</option>
				  		<option value="ker">Ajánlatot kérek</option>
					  </select>
				  </td>
				</tr>
				<tr>
				  <td><h3>Aj&aacute;nlat sz&ouml;vege </h3></td>
				</tr>
				<tr>
				  <td class="padd"><textarea name="szoveg" style="width: 400px; height: 200px;"></textarea></td>
				</tr>
				<tr>
				  <td><h3>Aj&aacute;nlat kateg&oacute;ri&aacute;i</h3></td>
				</tr>
				<tr>
				<td class="padd"><br /><fieldset style="width: 100%;"><legend>Tevékenységi körök</legend>';

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
								echo"<div class='oszlop' style='width: 150px;'>";
							}
				
							echo '<div style="padding-bottom: 3px;"><u>'.$sor->category.'</u></div><br>';

							$actual = $sor->id;
				
								foreach ( $cats as $sorok )
								{
									if( $sorok->parent == $actual )
									{
									  echo "<input type='checkbox' value='".$sorok->id."' name='cat[]' style='width: 15px;'> ".$sorok->category."<br>";
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

				echo'</fieldset></td>
				</tr>
				<tr>
				  <br><br>
				  	  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="Submit" value="Ajánlat beküldése" />
				  <br><br>
				</td>
				</tr>
			  </table>
			</form>';
	}

	function b2b_parse( $fejlec, $offer, $cID, $type, $cats ){
		global $db;

		#id 	fejlec 	offer 	cID 	ts 	type 	active

		$fejlec = addslashes( $fejlec );
		$offer = addslashes( $offer );
		$cID = addslashes( $cID );
		$type = addslashes( $type );

		$db->query("INSERT INTO offers( id, fejlec, offer, cID, ts, type, active ) VALUES ('','".$fejlec."','".$offer."','".$cID."', UNIX_TIMESTAMP(),'".$type."','0')");

		$insertid = $db->insert_id;

		foreach( $cats as $insert ){
			$db->query("INSERT INTO switch( oID, catID ) values( '".$insertid."', '".$insert."' )");
		}

		echo"<script> document.location = 'index.php?do=b2b_myoffers'; </script>";
		
	}
	function b2b_myoffers( $cid )
	{
		global $ezr;
		global $db;

		//  Egy kis segítség :)
		// 	-----------------------------------------------------
		//  id  	 fejlec  	 offer  	 cID  	 ts  	 type
		//	col1	 col2		 col3		 col4	 col5	 col6

		function modme( $col1, $col2, $col3, $col4, $col5, $col6, $col7 ){
			global $db;

			$cname = $db->get_var("SELECT cname FROM companies WHERE id = '".$col4."'");
			$col4 = "<a href=\"index.php?do=comp_show&cname=".$cname."\">" . $cname . "</a>";

			$fortnight = mktime(date("H", $col5), date("i", $col5), 0, date("m", $col5), date("d", $col5)+14, date("Y", $col5));

			$col5 = date("Y/m/d H:i",$col5) ." <strong>Lejár:</strong> " . date("Y/m/d H:i",$fortnight);

			$kategoriak = $db->get_results("SELECT * FROM categories WHERE id IN ( SELECT catID FROM switch WHERE oID = '".$col1."' )");

			$col3 .= "<p><strong>Kategóriák:</strong></p>";

			if( $kategoriak ){
				foreach( $kategoriak as $cats ){
					$col3 .= " " . $cats->category . " ";
				}
			}
		}
		$ezr->nav_top = true;
		$ezr->nav_bottom = true;
		$ezr->num_results_per_page = 50;
		$ezr->set_qs_val("do","comp_list");
		$ezr->register_function( 'modme' );
		$ezr->results_empty = "Még nem érkeztek ajánlatok ebbe a kategóriába.";
		$ezr->results_open = "<table cellpadding='3' cellspacing='1' width='500' id='lister'>";
		$ezr->results_heading = "<tr class='tr_head'> <td>Cég neve: </td><td>Beküldve: </td> </tr>";
		$ezr->results_row = "<tr class='row' style='background-color: #dfdfdf'>
								 <td width='200'><strong>COL4</strong></td>
								 <td>COL5</td>
							 <tr>
							 <tr class='row' valign='top'>
								 <td colspan='2'>Stáusz: <img src='admin/img/COL7.gif'>
							 </td>
							 <tr class='row' valign='top'>
								 <td colspan='2'><strong>Ajánlat megnevezése: COL2</strong><br>COL3
							 </td>
							 </tr>";
		$ezr->text_count = "NUMBERdb ajánlattal rendelkezik";

		$ezr->query_mysql("SELECT * FROM offers WHERE cID = '".$cid."'");

        $ezr->display();

	}
/*
	function b2b_search(  ){
		
	}
*/

}

?>
