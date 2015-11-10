<?


class Enp_API_Save {
    private $data;
    public $response; // sends response code (ie - 'success', 'unauthorized', etc)
                      // to be used by Enp_API_Response

    public function __construct($data) {
        $this->data = $data;

        if($this->data === NULL) {
            $this->response = 'invalid-request';
            return false;
        }

        // save the data and set the response
        $this->saveData();
    }

    protected function saveData() {
        if(!empty($this->data['site_url'])){
            $result = db_query("INSERT INTO button_data (site_url) VALUES ( '". $this->data['site_url'] ."' ) ");

            if($result === false) {
                $this->response = 'mysql_insert_failure';
            } else {
                $this->response = 'success';
            }

        }

    }

}
?>
