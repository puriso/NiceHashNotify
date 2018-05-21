<?php
error_log("callback start");

require_once( dirname(__FILE__).DIRECTORY_SEPARATOR."config.php" );

// Http request body
$requests = json_decode(file_get_contents('php://input'));

error_log($requests);
