<?php

// Init owncloud
require_once('../../lib/base.php');

// We send json data
header( "Content-Type: application/jsonrequest" );

// Check if we are a user
if( !OC_USER::isLoggedIn() || !OC_GROUP::inGroup( OC_USER::getUser(), 'admin' )){
	echo json_encode( array( "status" => "error", "data" => array( "message" => "Authentication error" )));
	exit();
}

$success = true;
$error = "add user to";
$action = "add";

$username = $_POST["username"];
$group = $_POST["group"];

// Toggle group
if( OC_GROUP::inGroup( $username, $group )){
	$action = "remove";
	$error = "remove user from";
	$success = OC_GROUP::removeFromGroup( $username, $group );
}
else{
	$success = OC_GROUP::addToGroup( $username, $group );
}

// Return Success story
if( $success ){
	echo json_encode( array( "status" => "success", "data" => array( "username" => $username, "action" => $action, "groupname" => $group )));
}
else{
	echo json_encode( array( "status" => "error", "data" => array( "message" => "Unable to $error group $group" )));
}

?>
