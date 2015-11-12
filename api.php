<?php

/*
// TESTING
$sent = array(
    "site_url"=> "http://dev/respect",
    "meta_id"=>  "13212",
    "button"=>  "respect",
    "clicks"=>  "100",
    "post_id"=>  "4",
    "comment_id"=> 0,
    "post_type"=>  "post",
    "button_url"=> "http://dev/respect/?p=4"
);
$sentJSON = json_encode($sent);
//$data= json_decode( $sentJSON, TRUE ); //convert JSON into array*/

// live from plugin data
$sentJSON = file_get_contents('php://input');

// get the current server URL, then go back to the root and to our processing file
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$url = $url.'/../process_a7d5f2d8b52c444aac1ef79b1f0140d1.php';

// pass connection to our guid processing file to make it harder to track the connection
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $sentJSON);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($sentJSON))
);

$result = curl_exec($ch);

curl_close($ch);


$log_result = $result."\n";
// Write the contents to the file,
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents('log/log-e104c5b7-5ba5-4e14-94fe-0d31c6ccf0e1.log', $log_result, FILE_APPEND | LOCK_EX);


?>
