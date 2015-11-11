<?php


// require database connection
require 'database/db_functions.php';

require 'Enp_API_Response_Class.php';
require 'Enp_API_Save_Class.php';


$sentJSON = file_get_contents('php://input');
$data= json_decode( $sentJSON, TRUE ); //convert JSON into array*/


/*
// TESTING
$sent = array(
    "site_url"=> "http://dev/respect",
    "meta_id"=>  "13212",
    "button"=>  "respect",
    "clicks"=>  "99",
    "post_id"=>  "4",
    "comment_id"=> 0,
    "post_type"=>  "post",
    "button_url"=> "http://dev/respect/?p=4"
);
$sentJSON = json_encode($sent);
$data= json_decode( $sentJSON, TRUE ); //convert JSON into array*/


// Process the save
$apiSave = new Enp_API_Save($data);
// Send the Save Response back to the requested site
$apiResponse = new Enp_API_Response($apiSave->response);

?>
