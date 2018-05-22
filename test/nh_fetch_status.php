<?php
ini_set('display_errors', "1");
echo "start";
define("RELATIVE_PATH","..");
define("CLASS_DIRECTORY",dirname(__FILE__).DIRECTORY_SEPARATOR.RELATIVE_PATH.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR);

require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.RELATIVE_PATH.DIRECTORY_SEPARATOR."config.php" );
require_once( CLASS_DIRECTORY . "LineApi.php" );
require_once( CLASS_DIRECTORY . "NiceHashApi.php" );

$NiceHashAPI     = new NiceHashAPI();
$nicehash_status = $NiceHashAPI->MakeTextForMessage();

print_r($nicehash_status);
