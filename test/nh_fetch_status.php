<?php
ini_set('display_errors', "On");
echo "start";
define("RELATIVE_PATH","..");
define("CLASS_DIRECTORY",dirname(__FILE__).DIRECTORY_SEPARATOR.RELATIVE_PATH.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR);

require_once( RELATIVE_PATH . dirname(__FILE__).DIRECTORY_SEPARATOR.RELATIVE_PATH.DIRECTORY_SEPARATOR."class"."config.php" );
require_once( CLASS_DIRECTORY . "LineApi.php" );
require_once( CLASS_DIRECTORY . "NiceHashApi.php" );

$NiceHashAPI = new NiceHashAPI();
$nicehash_status = $NiceHashAPI->FetchWorkerStatus();

var_dump($nicehash_status);
