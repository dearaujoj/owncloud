<?php

// Init owncloud
require_once('../../lib/base.php');
header( "Content-Type: application/jsonrequest" );

OC_APP::enable($_POST['appid']);

?>
