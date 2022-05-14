<?php

/**
 * template_lite { getSection } function plugin
 *
 * Type:     function
 * Name:     getSection
 * Purpose:  Kategóriákat jelenít meg így faszerkezetben

	 pl.: { getSection szekcio=10 }

	 szekcio = szülő elem, amitől kezdeni kell az olvasást
	 
	 before = tömböt vár, aminek eleminek kulcsa az url, értéke a szöveg
            Belileszt egy vagy több elemet a lista elé

 * Author:   Kow <tibi@szasz.hu>
 *
 */

function tpl_function_getSection($pars, &$tpl)
{

  require_once('fgv.getSection.php');

  include('sub.getSection.php');
  
  /**
   >    $tree-t a sub.include hozza létre és tartalmazza a fát
   */

  $toReturn = $GLOBALS["tree"];

  /**
   *    SEND BACK DATA TO COMPILED PHP
   */
	
	return $toReturn;
}

?>