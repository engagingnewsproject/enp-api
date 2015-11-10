<?php
// require database connection
require 'database/db_functions.php';

require 'api-functions.php';

$sentJSON = file_get_contents('php://input');
$sentData= json_decode( $sentJSON, TRUE ); //convert JSON into array

/* TESTING
$sent = 'http://dev/respect';
$sentJSON = json_encode($sent);
$sentData= json_decode( $sentJSON, TRUE ); //convert JSON into array
var_dump($sentJSON);
*/


// Return Response to browser
$api = new Enp_API_Response($sentData);
?>
