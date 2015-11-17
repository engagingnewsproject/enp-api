<?
// code for handling errors

function log_error($error, $data) {
    $log_result = 'Error: '.$error.',';
    foreach($data as $key=>$value) {
        $log_result .= $key.'['.$value.'],';
    }
    // pop the last comma
    $log_result = substr($log_result, 0, -1);
    $log_result .= "\n";
    // Write the contents to the file,
    file_put_contents('error-log/errors.txt', $log_result, FILE_APPEND | LOCK_EX);
    // go to sleep for half a second
    usleep(500000);
}

?>
