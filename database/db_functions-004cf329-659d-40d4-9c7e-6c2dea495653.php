<?php // Database Functions

function db_connect() {

    // Define connection as a static variable, to avoid connecting more than once
    static $connection;

    // Try and connect to the database, if a connection has not been established yet
    if(!isset($connection)) {
        // Load configuration as an array. Use the actual location of your configuration file
        $config = parse_ini_file('database_config-4930dc35-7547-4449-9896-0d44d24a2423.ini');
        // $connection = mysqli_connect($config['host'],$config['username'],$config['password'],$config['dbname']);
        $pdo = new PDO("mysql:host=".$config['host'].";dbname=".$config['dbname'], $config['username'], $config['password']);

    }

    // If connection was not successful, handle the error
    if($pdo === false) {
        // Handle error - notify administrator, log to a file, show an error screen, etc.
        return 'connection error';
    }

    return $pdo;
}

?>
