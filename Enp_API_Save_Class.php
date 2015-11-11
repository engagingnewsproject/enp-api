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

        // Check the database to see if we have a match
        $match = $this->findMatch();

        if($match === false) {
            // No match was found, so let's insert the data
            $this->insertData();
        } else {
            $this->updateData();
        }

    }

    protected function setData() {
        if(empty($this->data['site_url'])){
            $this->response = 'no_site_url';
            return false;
        }
    }

    protected function findMatch() {
        $pdo = db_connect();

        $stm = $pdo->prepare("SELECT * FROM button_data
                                        WHERE site_url = :site_url
                                        AND meta_id = :meta_id
                                        AND post_id = :post_id
                                        AND comment_id = :comment_id
                            ");

        $params = array(':site_url'   => $this->data['site_url'],
                        ':meta_id'    => $this->data['meta_id'],
                        ':post_id'    => $this->data['post_id'],
                        ':comment_id' => $this->data['comment_id']
                        );

        $stm->execute($params);

        $findMatch = $stm->fetch(); // gets one row

        return $findMatch;

    }

    protected function updateData() {
        $pdo = db_connect();

        $params = array(':clicks'     => $this->data['clicks'],
                        ':updated'    => $this->data['updated'],
                        ':site_url'   => $this->data['site_url'],
                        ':meta_id'    => $this->data['meta_id'],
                        ':post_id'    => $this->data['post_id'],
                        ':comment_id' => $this->data['comment_id']
                    );

        $stm = $pdo->prepare("UPDATE button_data
                                 SET clicks  = :clicks,
                                     updated = :updated
                               WHERE site_url = :site_url
                                 AND meta_id = :meta_id
                                 AND post_id = :post_id
                                 AND comment_id = :comment_id
                    ");

        $update = $stm->execute($params);

        if($update === false) {
            $this->response = 'update-failure';
        } else {
            $this->response = 'update-success';
        }
    }



    protected function insertData() {
        $pdo = db_connect();

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
            $this->response = 'insert-failure';
        } else {
            $this->response = 'insert-success';
        }

    }

}
?>
