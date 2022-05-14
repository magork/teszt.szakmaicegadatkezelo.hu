<?php

  include('iroda/config/config_public.php');
  
  $test = db_Connect();

  $beforeLI = '';

  if( isset( $pars['before'] ) ){
  
      foreach( $pars['before'] as $k => $v ){
      
        $beforeLI .= '<li><a href="'.$k.'">'.$v.'</a></li>';
        
      }
  }

  $GLOBALS["tree"] = '<ul>' . $beforeLI;

  $C = 0;

  $startFromTreeNode = ( isset( $pars['szekcio'] ) ) ? $pars['szekcio'] : 0 ;

  getLevelFromDB( $startFromTreeNode,$c);

  $GLOBALS["tree"] .= '</ul>';

?>