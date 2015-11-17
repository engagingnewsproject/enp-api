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
require 'Enp_API_Save_Class.php';

$sentJSON = file_get_contents('php://input');
$data= json_decode( $sentJSON, TRUE ); //convert JSON into array*/

try{
    if(!empty($data['error'])) {
        throw new Exception('Error sent from plugin.');
    }
    if(filter_var($data['site_url'], FILTER_VALIDATE_URL) === false) {
        throw new Exception('$data[site_url] is not a URL');
    }

    // no exceptions caught, so keep going
    require 'Enp_API_Response_Class.php';
    // append the timestamp
    $data['updated'] = date("Y-m-d H:i:s");
    // Process the save
    $apiSave = new Enp_API_Save($data);

    $log_result = $apiSave->response."|".$data['site_url']."|".$data['meta_id']."|".$data['post_id']."|".$data['comment_id']."|".$data['updated']."\n";
    // Write the contents to the file,
    file_put_contents('log/log-e104c5b7-5ba5-4e14-94fe-0d31c6ccf0e1.txt', $log_result, FILE_APPEND | LOCK_EX);


    // Send the Save Response back to the requested site
    $apiResponse = new Enp_API_Response($apiSave->response);

} catch(Exception $e) {
    require 'error_handling.php';
    log_error($e->getMessage(), $data);
}

exit();
?>
