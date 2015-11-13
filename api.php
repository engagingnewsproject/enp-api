<?php

/*
// Only for TESTING
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

// require database connection
require 'database/db_functions-004cf329-659d-40d4-9c7e-6c2dea495653.php';

require 'Enp_API_Response_Class.php';
require 'Enp_API_Save_Class.php';

$sentJSON = file_get_contents('php://input');
$data= json_decode( $sentJSON, TRUE ); //convert JSON into array*/
// append the timestamp
$data['updated'] = date("Y-m-d H:i:s");

// Process the save
$apiSave = new Enp_API_Save($data);

$log_result = $apiSave->response."|".$data['site_url']."|".$data['meta_id']."|".$data['post_id']."|".$data['comment_id']."|".$data['updated']."\n";
// Write the contents to the file,
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents('log/log-e104c5b7-5ba5-4e14-94fe-0d31c6ccf0e1.txt', $log_result, FILE_APPEND | LOCK_EX);


// Send the Save Response back to the requested site
$apiResponse = new Enp_API_Response($apiSave->response);

?>
