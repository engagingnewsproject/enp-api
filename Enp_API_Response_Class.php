<?


class Enp_API_Response {
    public $response;

    // Starter API template from: http://markroland.com/blog/restful-php-api/

    public function __construct($save_status) {

        $this->response = $this->setResponse($save_status);

        $this->deliver_response();
    }
    // --- Step 1: Initialize variables and functions

    /**
     * Deliver HTTP Response
     * @param string $api_response The desired HTTP response data
     * @return void
     **/
    protected function deliver_response(){

        // Set HTTP Response
        $httpResponse = $this->setHTTPResponse($this->response['status']);
        header($httpResponse);

        // Set HTTP Response Content Type
        header('Content-Type: application/json; charset=utf-8');

        // Format data into a JSON response
        $json_response = json_encode($this->response);

        // Deliver formatted data
        echo $json_response;

        // End script process
        exit;
    }

    protected function setResponseCodes() {
        // Define API response codes and their related HTTP response
        $api_response_code = array(
            'unknown' => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
            'success' => array('HTTP Response' => 200, 'Message' => 'Success'),
            'insert-success' => array('HTTP Response' => 200, 'Message' => 'Insert Success'),
            'update-success' => array('HTTP Response' => 200, 'Message' => 'Update Success'),
            'no-changes' => array('HTTP Response' => 200, 'Message' => 'No Changes'),
            'uanuthorized' => array('HTTP Response' => 401, 'Message' => 'Unauthorized'),
            'invalid-request' => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
            'invalid-response' => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format'),
            'insert-failure' => array('HTTP Response' => 404, 'Message' => 'Insert Error'),
            'update-failure' => array('HTTP Response' => 404, 'Message' => 'Update Error'),
            'no-site-url' => array('HTTP Response' => 404, 'Message' => 'No Site URL'),
        );
        return $api_response_code;
    }


    protected function setResponse($save_status) {
        $api_response_code = $this->setResponseCodes();

        // Set default HTTP response of
        $response['code'] = 0;
        $response['status'] = 404;


        // --- Process Request


        $response['code'] = $save_status;
        $response['status'] = $api_response_code[ $save_status ]['HTTP Response'];
        $response['message'] = $api_response_code[ $save_status ]['Message'];

        return $response;
    }


    protected function setHTTPResponse($status) {
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
}
?>
