<?php

function db_connect() {
    $ini_array = parse_ini_file('../creds.ini');
    $servername = $ini_array['servername'];
    $username = $ini_array['username'];
    $password = $ini_array['password'];
    $dbname = $ini_array['dbname'];
    
    // Now use exceptions for internal errors
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli($servername, $username, $password, $dbname);

    // For proper safety reasons (TODO: is it ok?)
    $conn->set_charset('utf8mb4');

    return $conn;
}

?>
