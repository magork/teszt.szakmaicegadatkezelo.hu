<?php

class mainframe{
	public $osszes; 
	public $limit; 
	public $tol; 
	public $megjelenik;
	


	
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
	



}

?>
