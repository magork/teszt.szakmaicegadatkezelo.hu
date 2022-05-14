<?php

	function getLevelFromDB($parent_id, $c){

    $c++;

		$sql = "SELECT item_id, item_nm FROM tree WHERE item_parent_id=$parent_id ORDER BY item_order";

		$res = mysql_query ($sql);

		if($res)
		{
			while($row=mysql_fetch_array($res)){

				$GLOBALS["tree"] .= "<li><a href='index.php?event=show_categiries&cat=". $row['item_id'] ."'>\r";
				
				/* PRRINT OPTION SUBDIRS */

				if( $c != 1 ) 
				{
					for( $i=0; $i < $c; $i++ ) $GLOBALS["tree"] .=  "&nbsp;"; // Ez ismétlõdik a gyerek elõtt

           // Ez megy a gyerek menüpont elé
					 $GLOBALS["tree"] .=  "-&nbsp;";
				}
 
				$GLOBALS["tree"] .= str_replace('"',"&quot;",$row['item_nm']);

				$GLOBALS["tree"] .=  "</a></li>\r";

				getLevelFromDB($row['item_id'], $c);

			}
		} else { echo mysql_error(); }
	}
	
?>