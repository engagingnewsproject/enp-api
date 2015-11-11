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
        $this->data['created_at'] = date("Y-m-d H:i:s");

        // save the data and set the response
        $this->saveData();
    }

    protected function setData() {
        if(empty($this->data['site_url'])){
            $this->response = 'no_site_url';
            return false;
        }
    }

    protected function findMatch() {
        $findMatch = db_prepare("SELECT * FROM button_data
                                        WHERE meta_id = 2
                            ");
    }

    protected function updateData() {

    }

    protected function saveData() {
        $pdo = db_connect();
        //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $params = array(':site_url'   => $this->data['site_url'],
                        ':meta_id'    => $this->data['meta_id'],
                        ':post_id'    => $this->data['post_id'],
                        ':comment_id' => $this->data['comment_id'],
                        ':button'     => $this->data['button'],
                        ':clicks'     => $this->data['clicks'],
                        ':post_type'  => $this->data['post_type'],
                        ':button_url' => $this->data['button_url'],
                        ':updated'    => $this->data['updated'],
                        ':created_at' => $this->data['created_at']
                    );

        $stm = $pdo->prepare("INSERT INTO button_data (
                                                    site_url,
                                                    meta_id,
                                                    post_id,
                                                    comment_id,
                                                    button,
                                                    clicks,
                                                    post_type,
                                                    button_url,
                                                    updated,
                                                    created_at)
                            VALUES (
                                    :site_url,
                                    :meta_id,
                                    :post_id,
                                    :comment_id,
                                    :button,
                                    :clicks,
                                    :post_type,
                                    :button_url,
                                    :updated,
                                    :created_at
                                    )
                    ");

        $insert = $stm->execute($params);

        if($insert === false) {
            $this->response = 'insert_failure';
        } else {
            $this->response = 'success';
        }

    }

}
?>
