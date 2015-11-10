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

        // setup the timestamp
        $this->data['updated'] = date("Y-m-d H:i:s");

        // save the data and set the response
        $this->saveData();
    }

    protected function setData() {
        if(empty($this->data['site_url'])){
            $this->response = 'no_site_url';
            return false;
        }
    }

    protected function saveData() {

        $result = db_query("INSERT INTO button_data (
                                                    site_url,
                                                    meta_id,
                                                    post_id,
                                                    button,
                                                    clicks,
                                                    post_type,
                                                    post_url,
                                                    updated)
                            VALUES (
                                    '". $this->data['site_url'] ."',
                                    '". $this->data['meta_id'] ."',
                                    '". $this->data['post_id'] ."',
                                    '". $this->data['button'] ."',
                                    '". $this->data['clicks'] ."',
                                    '". $this->data['post_type'] ."',
                                    '". $this->data['post_url'] ."',
                                    '". $this->data['updated'] ."'
                                    )
                    ");

        if($result === false) {
            $this->response = 'mysql_insert_failure';
        } else {
            $this->response = 'success';
        }

    }

}
?>
