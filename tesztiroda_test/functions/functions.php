<?php

function limitEll($usid){
	$res = mysql_query("SELECT uslim FROM user WHERE usid=".$usid) or die(mysql_error());
	if(mysql_num_rows($res)>1){
		die('User tábla inkonzisztens: azonosító duplokáció');
	}
	$limT = mysql_fetch_array($res);
	$lim = $limT['uslim'];
	$res = mysql_query("SELECT count(*) as van FROM ceglista WHERE allapot<=2 and uzletkid=".$usid) or die(mysql_error());
	$vanT = mysql_fetch_array($res);
	$van = $vanT['van'];
	if ($van>=$lim){
		return false;
	}else{
		return true;
	}
}

function all2Str($all){
	switch($all){
		case 0:
			return 'Még nem hívott';
		break;
		case 2:
			return 'Visszahívni';
		break;
		case 4:
			return '<b>Sztornó</b>';
		break;
		case 5:
			return '<b>Regisztrált</b>';
		break;
		case 6:
			return '<b>Regisztráció alatt</b>';
		break;
		case 7:
			return '<b>Ajánlat kiküldve</b>';
		break;
		default:
			return '<i>Érvénytelen</i>';
		break;
	}
}

if ( !function_exists('str_split') ) {
function str_split($string,$split_length=1){
    $sign = (($split_length<0)?-1:1);
    $strlen = strlen($string);
    $split_length = abs($split_length);
    if ( ($split_length==0) || ($strlen==0) ){
            $result = false;
            //$result[] = "";
    }
    elseif ($split_length >= $strlen){
        $result[] = $string;
    }
    else {
        $length = $split_length;
        for ($i=0; $i<$strlen; $i++){
            $i=(($sign<0)?$i+$length:$i);
            $result[] = substr($string,$sign*$i,$length);
            $i--;
            $i=(($sign<0)?$i:$i+$length);
            if ( ($i+$split_length) > ($strlen) ){
                $length = $strlen-($i+1);
            }
            else {
                $length = $split_length;
            }
        }
    }
    return $result;
}
}

function isNumeric($str){
	$szam = " 0123456789";
	if (strlen($str)==0) {return false;}
	foreach(str_split($str) as $ind => $char){
		if (strpos($szam,$char)==''){
			return false;
		}
	}
	return true;
}

function make_date_array($xml)
{
	$back=array();
	for($i=1; $i<32; $i++)
	{
		$back['napok'][]=($i<10)?'0'.$i:$i;
	}
	$curr_year=date('Y');
	for($i=0; $i<100; $i++)
	{
		$back['evek'][]=$curr_year-$i;
	}
	$back['honapok']=$xml -> readXML (_PATH_TEXT .$_SESSION['nyelv'].'/honapok.xml' );
	return $back;
}

function tolokgeneralo($osszes, $limit, $tol, $megjelenik=9)
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

function auth($login=false)
{
	if( ($_SESSION['felhasznalo']['id']==0))
	{
		if( $login )
		{
			$_SESSION['URLback']=$_SERVER['REQUEST_URI'];
			header('Location: needlogin.php');
			die();
		}
		else
		{
			return false;
		}
	}
	else
	{
		return true;
	}
}

function super_auth( $event = 'eles' )
{

	if( $event == 'dev' )
	{
		$_SESSION['felhasznalo']['admin'] = true;
	}

	if( $_SESSION['felhasznalo']['admin'] == false )
	{
		header( 'Location: manager_login.php' );
		die();
	}
	else
	{
		return true;
	}
}

function restart( $url = false )
{
	if( $url == false )
	{
		$url = explode( '?', $_SERVER['REQUEST_URI'] );
		header( 'location: ' . $url[0] );

	} else {
		header( 'location: ' . $url );
	}

	die();
}

/*
 *		K�PFELT�LT� F�GGV�NY
 */

function pic_upload_handler( $image, $filename, $rect = false )
{
  $kep = GetImageSize($image['tmp_name']);

	$thumb_size = ( $rect == false ) ? _THUMB_SIZE : $rect;

	if( $kep[0] > $thumb_size || $kep[1] > $thumb_size ){

		list( $width, $height, $type ) = GetImageSize( $image['tmp_name'] );

		$percent = $thumb_size / $kep[0];
		$new_width = $width * $percent;
		$new_height = $height * $percent;

	} else {
		list( $new_width, $new_height, $type ) = GetImageSize( $image['tmp_name'] );
		list( $width, $height, $type  ) = GetImageSize( $image['tmp_name'] );
	}

	$image_p = imagecreatetruecolor($new_width, $new_height);

	switch( $type )
	{
		case 2:
			$imagefinal = imagecreatefromjpeg($image['tmp_name']);

			imagecopyresampled($image_p, $imagefinal, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

			if( imagejpeg( $image_p, "uploaded/" . $filename, 100) ) return 'jpg';
			else return false;
		break;

		case 1:
			$imagefinal = imagecreatefromgif($image['tmp_name']);

			imagecopyresampled($image_p, $imagefinal, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

			if( imagegif( $image_p, "uploaded/" . $filename, 100) ) return 'gif';
			else return false;
		break;

		case 3:
			$imagefinal = imagecreatefrompng($image['tmp_name']);

			imagecopyresampled($image_p, $imagefinal, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

			if( imagepng( $image_p, "uploaded/" . $filename, 100) ) return 'png';
			else return false;
		break;
	}
}

function AssignCats()
{
	global $smarty;
	
	/**
	 * 		LEK�RDEZI A SHOP MEN�J�T
	 * 		�s assignolja is izibe'
	 */

	$cats = array();
	$c = mysql_query( 'SELECT * FROM tree' );

	while( $d = mysql_fetch_array( $c ) )
	{
			$cats[] = array(
					'id' 		=> $d['item_id'],
					'txt' 		=> stripslashes( $d['item_nm'] ),
			);
	}
	$smarty->assign( 'cats', $cats );
	return $cats;
}

function CleanUpImages(){

	$imgs = array();

	$test = mysql_query( 'SELECT * FROM kepek WHERE temp = 1 AND hID != "'.$_SESSION['imageID'].'"' );

	if( mysql_num_rows( $test ) > 0 ){

		while( $d = mysql_fetch_array( $test ) )
		{
				$imgs[] = array(
						'url' 		=> $d['url'],
						'tipus' 	=> $d['tipus'],
				);
		}

		foreach( $imgs as $i )
		{
			$small_pic = 'uploaded/'.$i['url'] . '.' . $i['tipus'];
			$resized_pic = 'uploaded/'.$i['url'] . '_.' . $i['tipus'];

			if( file_exists( $small_pic ) )
			{
				unlink( $small_pic );
				unlink( $resized_pic );
			}
		}

	}

	mysql_query( $r = 'DELETE FROM kepek WHERE temp = 1 AND hID != "'.$_SESSION['imageID'].'"' );

}

function generateTagCloud(){

  global $smarty;

/**
 *      GENERATE TAG CLOUD // From torrentek.hu
 */

        $szumma = mysql_query("SELECT SUM(id) FROM tags");

        $tagz = mysql_query("SELECT id, tag, count(id) AS darab FROM `tags` GROUP BY tag");

        $minimumSize = 1;
        $maximumSize = 4;

        // Újraszámítás
        //
        while( $tag = mysql_fetch_Assoc( $tagz ) ){

          // Limit maximum size
          $size = ( ($tag['darab'] / $szumma * 10 ) > $maximumSize ) ? $maximumSize : number_format( ( $tag['darab'] / $szumma * 10 ), 5, '.', '');

          $tagArray[] = array(
          
                'tag'     => $tag['tag'],
                'size'    => $size,
                'tagID'    => $tag['id'],
                
          );
        }

        sort($tagArray);

        $smarty->assign("tags", $tagArray);

}

?>
