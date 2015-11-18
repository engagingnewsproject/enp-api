
<html>
    <head>
        <?  // turn error reporting on
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            require '../database/db_functions-004cf329-659d-40d4-9c7e-6c2dea495653.php';

            function displayTable($findMatches) {

                $i = 0;
                $query_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                if(strpos($query_link,'?') === false) {
                    $query_link .= '?'; // set it up for a query
                } else {
                    $query_link .= '&'; // to append another query
                }
                foreach($findMatches as $row) {
                    if($i === 0) {
                        $table = '<h3 class="site-url"><a href="?site_url='.$row['site_url'].'">'.$row['site_url'].'</a></h3>
                         <div class="site-data">
                             <table>
                                <tbody>
                                    <thead>
                                        <th>Button <a href="'.$query_link.'orderby=button&order=ASC" class="up">&uparrow;</a><a href="'.$query_link.'orderby=button&order=DESC" class="down">&downarrow;</a></th>
                                        <th>Type <a href="'.$query_link.'orderby=post_type&order=ASC" class="up">&uparrow;</a><a href="'.$query_link.'orderby=post_type&order=DESC" class="down">&downarrow;</a></th>
                                        <th class="integer"><a href="'.$query_link.'orderby=clicks&order=ASC" class="up">&uparrow;</a><a href="'.$query_link.'orderby=clicks&order=DESC" class="down">&downarrow;</a> Clicks</th>
                                    </thead>';
                        $i++;
                    }

                    $table .= '<tr>
                                <td>'.$row['button'].'</td>
                                <td><a href="'.$row['button_url'].'">'.$row['post_type'].'</a></td>
                                <td class="integer">'.$row['clicks'].'</td>
                            </tr>';


                }
                $table .= '</tbody>
                        </table>
                    </div>';

                return $table;
            }


            function queryTable($site_url) {
                $pdo = db_connect();

                if(isset($_GET['orderby'])) {
                    $orderby = $_GET['orderby'];
                } else {
                    $orderby = 'clicks';
                }

                if(isset($_GET['order'])) {
                    $order = $_GET['order'];
                } else {
                    $order = 'DESC';
                }

                $stm = $pdo->prepare("SELECT * FROM button_data
                                            WHERE site_url = :site_url
                                            ORDER BY $orderby $order
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

        <link rel='stylesheet' href='style.css' type='text/css' media='all' />
    </head>
    <body>
        <header class="masthead">
            <h1>Engaging Button Data</h1>
            <? echo (isset($_GET['site_url']) ?  '<p class="hint"><a href="../display"><span class="chevron">&lsaquo;</span> Back to All Results</a></p>' : '');?>
        </header>

        <main class="main">

            <?
            if(isset($_GET['site_url'])) {
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
            ?>
        </main>
    </body>
</html>






