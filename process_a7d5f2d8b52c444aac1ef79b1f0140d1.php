<?php


// require database connection
require 'database/db_functions-004cf329-659d-40d4-9c7e-6c2dea495653.php';

require 'Enp_API_Response_Class.php';
require 'Enp_API_Save_Class.php';

$sentJSON = file_get_contents('php://input');
$data= json_decode( $sentJSON, TRUE ); //convert JSON into array*/



// Process the save
$apiSave = new Enp_API_Save($data);
// Send the Save Response back to the requested site
$apiResponse = new Enp_API_Response($apiSave->response);

?>
