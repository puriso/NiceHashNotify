<?php
define("CLASS_DIRECTORY",dirname(__FILE__).DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR);

require_once( dirname(__FILE__).DIRECTORY_SEPARATOR."class"."config.php" );
require_once( CLASS_DIRECTORY . "LineApi.php" );
require_once( CLASS_DIRECTORY . "NiceHashApi.php" );
require_once(  CLASS_DIRECTORY . "BtcExchangeApi.php" );

// Http request body
$requests = json_decode(file_get_contents('php://input'));

$message_text = $requests->{"events"}[0]->{"message"}->{"text"};
$replay_token = $requests->{"events"}[0]->{"replyToken"};

$NiceHashAPI     = new NiceHashAPI();
$replay_message = $NiceHashAPI->MakeTextForMessage();


//$is_bitcoin_address = preg_match('/^[13]+[a-zA-Z0-9]{26,33}$/u', '1AfGtrhpBVcsasnBkBmaZf6QuUYeXTQw',

$LineAPI     = new LineAPI();
$LineAPI->ReplayMessage($replay_token,$replay_message);


