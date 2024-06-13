<?php
/*
$username="REDACTED_USERNAME";
$Key="REDACTED_MOVESMS_API_KEY";
$senderId="SMARTLINK";
$tophonenumber="0700000000";
$finalmessage=urlencode("Hello from app!");
$live_url="https://sms.movesms.co.ke/api/compose?username=".$username."&api_key=".$Key."&sender=".$senderId."&to=".$tophonenumber."&message=".$finalmessage."&msgtype=5&dlr=0";
$parse_url=file($live_url);

$output1= $parse_url[0];

header($output1);
*/

$user="REDACTED_USERNAME";
$Key="REDACTED_MOVESMS_API_KEY";
$senderId="SMARTLINK";
$tophonenumber="+254700000000";
$finalmessage="Hello from App!";

$url="https://sms.movesms.co.ke/api/compose?";
$postData = array(
'username' => $user,
'api_key' => $Key,
'sender' => $senderId,
'to' => $tophonenumber,
'message' => $finalmessage,
'msgtype' => 5,
'dlr' => 0,
);

$ch = curl_init();
curl_setopt_array($ch, array(
CURLOPT_URL => $url,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_POST => true,
CURLOPT_POSTFIELDS => $postData

));

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$output = curl_exec($ch);

if (curl_errno($ch)) {

$output = curl_error($ch);
}

curl_close($ch);






/*
//AFRICAS TALKING API
require "src/AfricasTalking.php";

use AfricasTalking\SDK\AfricasTalking;

$username = 'sandbox'; // use 'sandbox' for development in the test environment
$apiKey   = 'REDACTED_AFRICASTALKING_API_KEY'; // use your sandbox app API key for development in the test environment
$AT       = new AfricasTalking($username, $apiKey);

// Get one of the services
$sms      = $AT->sms();

// Use the service
$result   = $sms->send([
    'to'      => '+254700000000',
    'message' => 'Hello World!'
]);

print_r($result);
*/
?>