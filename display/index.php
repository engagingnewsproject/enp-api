
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

                    // check to see if orderby and order parameters are there. If so, remove them.
                    $query_link = preg_replace("/(orderby=)\w*(&)/", "", $query_link);
                    $query_link = preg_replace("/(order=)((ASC)|(DESC))/", "", $query_link);
                    $query_link = preg_replace("/(&&)/", "&", $query_link);
                    $query_link = str_replace("?&", "?", $query_link);
                    $query_link = trim($query_link, "&");// trim & if at end of string
                }
                foreach($findMatches as $row) {
                    if($i === 0) {
                        $table = '<h3 class="site-url"><a href="?site_url='.$row['site_url'].'">'.$row['site_url'].'</a></h3>
                         <div class="site-data">
                             <table>
                                <tbody>
                                    <thead>
                                        <th>Button <span class="order-wrap"><a href="'.$query_link.'&orderby=button&order=ASC" class="up"><svg class="icon-up"><use xlink:href="#icon-up"></use></svg></a><a href="'.$query_link.'&orderby=button&order=DESC" class="down"><svg class="icon-down"><use xlink:href="#icon-down"></use></svg></a></span></th>
                                        <th>Type <span class="order-wrap"><a href="'.$query_link.'&orderby=post_type&order=ASC" class="up"><svg class="icon-up"><use xlink:href="#icon-up"></use></svg></a><a href="'.$query_link.'&orderby=post_type&order=DESC" class="down"><svg class="icon-down"><use xlink:href="#icon-down"></use></svg></a></span></th>
                                        <th class="integer"><span class="order-wrap"><a href="'.$query_link.'&orderby=clicks&order=DESC" class="up"><svg class="icon-up"><use xlink:href="#icon-up"></use></svg></a><a href="'.$query_link.'&orderby=clicks&order=ASC" class="down"><svg class="icon-down"><use xlink:href="#icon-down"></use></svg></a></span> Clicks</th>
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
        <? // svg icons ?>
            <svg style="display: none;">
                <symbol id="icon-up" viewBox="0 0 1024 1024">
                    <path d="M495.488 398.464c-13.952 14.272-33.376 15.392-50.432 0l-125.056-119.904-125.056 119.904c-17.056 15.392-36.512 14.272-50.368 0-13.952-14.24-13.056-38.304 0-51.68 12.992-13.376 150.24-144.064 150.24-144.064 6.944-7.136 16.064-10.72 25.184-10.72s18.24 3.584 25.248 10.72c0 0 137.184 130.688 150.24 144.064 13.088 13.376 13.952 37.44 0 51.68z"></path>
                </symbol>
                <symbol id="icon-down" viewBox="0 0 1024 1024">
                    <path d="M144.512 241.536c13.952-14.272 33.376-15.392 50.432 0l125.056 119.904 125.056-119.904c17.056-15.392 36.512-14.272 50.368 0 13.952 14.24 13.056 38.304 0 51.68-12.992 13.376-150.24 144.064-150.24 144.064-6.944 7.136-16.064 10.72-25.184 10.72s-18.24-3.584-25.248-10.72c0 0-137.184-130.688-150.24-144.064-13.088-13.376-13.952-37.44 0-51.68z"></path>
                </symbol>
            </svg>
        <? // end svg ?>
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






