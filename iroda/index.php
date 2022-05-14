<?php

require_once('config/config.php');

super_auth();

$tartalom = $smarty -> fetch( "index.tpl" );
require(_DISPLAY_ADMIN);

?>