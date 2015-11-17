<?
    require 'database/db_functions-004cf329-659d-40d4-9c7e-6c2dea495653.php';



    if($_GET['site_url']) {
        $findMatches = queryTable($_GET['site_url']);
        if($findMatches) {
            echo displayTable($findMatches);
        } else {
            echo 'no results found';
        }
    } else {

        $sites = getUniqueSites();

        // loop through all the matches and output each table
        foreach($sites as $site) {
            $findMatches = queryTable($site['site_url']);
            if($findMatches) {
                echo displayTable($findMatches);
            } else {
                echo 'no results found';
            }
        }

    }



    function displayTable($findMatches) {

        $i = 0;
        foreach($findMatches as $row) {
            if($i === 0) {
                $table = '<h3><a href="?site_url='.$row['site_url'].'">'.$row['site_url'].'</a></h3>
                 <table>
                    <tbody>
                        <thead>
                            <th>Button</th>
                            <th>Clicks</th>
                            <th>Post Type</th>
                        </thead>';
                $i++;
            }

            $table .= '<tr>
                        <td>'.$row['button'].'</td>
                        <td>'.$row['clicks'].'</td>
                        <td><a href="'.$row['button_url'].'">'.$row['post_type'].'</a></td>
                    </tr>';


        }
        $table .= '</tbody>
            </table>';

        return $table;
    }


    function queryTable($site_url) {
        $pdo = db_connect();

        $stm = $pdo->prepare("SELECT * FROM button_data
                                    WHERE site_url = :site_url
                        ");

        $params = array(':site_url'   => $site_url);
        $stm->execute($params);
        $findMatches = $stm->fetchAll();

        return $findMatches;
    }


    function getUniqueSites() {
        $pdo = db_connect();
        $stm = $pdo->prepare("SELECT DISTINCT site_url FROM button_data");
        $params = array();
        $stm->execute($params);
        $sites = $stm->fetchAll();

        return $sites;
    }


?>
