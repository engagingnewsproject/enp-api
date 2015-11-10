<?php
// require database connection
require 'database/db_functions.php';

// Starter API template from: http://markroland.com/blog/restful-php-api/

// --- Step 1: Initialize variables and functions

/**
 * Deliver HTTP Response
 * @param string $api_response The desired HTTP response data
 * @return void
 **/
function deliver_response($api_response){



    // Set HTTP Response
    $httpResponse = setHTTPResponse($api_response['status']);
    header($httpResponse);

    // Set HTTP Response Content Type
    header('Content-Type: application/json; charset=utf-8');

    // Format data into a JSON response
    $json_response = json_encode($api_response);

    // Deliver formatted data
    echo $json_response;


    // End script process
    exit;

}

// Define API response codes and their related HTTP response
$api_response_code = array(
    'unknown' => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
    'success' => array('HTTP Response' => 200, 'Message' => 'Success'),
    'uanuthorized' => array('HTTP Response' => 401, 'Message' => 'Unauthorized'),
    'invalid-request' => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
    'invalid-response' => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format')
);

// Set default HTTP response of
$response['code'] = 0;
$response['status'] = 404;
$response['data'] = NULL;


// --- Process Request

// Method A: Say Hello to the API
if( isset($_GET['site_url']) ){
    $response['code'] = 'success';
    $response['status'] = $api_response_code[ 'success' ]['HTTP Response'];
    $response['data'] = $_GET['site_url'];
} else {
    $inputJSON = file_get_contents('php://input');
    $input= json_decode( $inputJSON, TRUE ); //convert JSON into array
    $response['code'] = 'success';
    $response['status'] = $api_response_code[ 'success' ]['HTTP Response'];
    $response['message'] = $api_response_code[ 'success' ]['Message'];
    $response['data'] = $input;
}

// --- Deliver Response

// Return Response to browser
deliver_response($response);


function setHTTPResponse($status) {
    // Define HTTP responses
    $http_response_code = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found'
    );

    return 'HTTP/1.1 '.$status.' '.$http_response_code[ $status ];
}
?>
