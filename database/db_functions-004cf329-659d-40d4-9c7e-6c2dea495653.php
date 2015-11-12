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
        $log_result = 'no database connection';
        // Write the contents to the file,
        // using the FILE_APPEND flag to append the content to the end of the file
        // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
        file_put_contents('../log/log-e104c5b7-5ba5-4e14-94fe-0d31c6ccf0e1.txt', $log_result, FILE_APPEND | LOCK_EX);
        return 'connection error';
    }

    return $pdo;
}

