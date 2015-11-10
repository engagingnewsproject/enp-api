<?


class Enp_API_Save {
    private $data;
    public $response; // sends response code (ie - 'success', 'unauthorized', etc)
                      // to be used by Enp_API_Response

    public function __construct($data) {
        $this->data = $data;
        if($data === NULL) {
            $this->response = 'invalid-request';
        } else {
            $this->response = 'success';
        }

    }

}
?>
