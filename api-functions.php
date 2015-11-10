<?


class Enp_API_Response {
    public $response;
    public $data;

    // Starter API template from: http://markroland.com/blog/restful-php-api/

    public function __construct($sentData) {

        $this->data = $sentData;

        $this->response = $this->setResponse();

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

    protected function setResponseCode() {
        // Define API response codes and their related HTTP response
        $api_response_code = array(
            'unknown' => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
            'success' => array('HTTP Response' => 200, 'Message' => 'Success'),
            'uanuthorized' => array('HTTP Response' => 401, 'Message' => 'Unauthorized'),
            'invalid-request' => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
            'invalid-response' => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format')
        );
        return $api_response_code;
    }


    protected function setResponse() {
        $api_response_code = $this->setResponseCode();

        // Set default HTTP response of
        $response['code'] = 0;
        $response['status'] = 404;
        $response['data'] = NULL;


        // --- Process Request


        $response['code'] = 'success';
        $response['status'] = $api_response_code[ 'success' ]['HTTP Response'];
        $response['message'] = $api_response_code[ 'success' ]['Message'];
        $response['data'] = $this->data;

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
