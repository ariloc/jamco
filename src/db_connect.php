<?php

function db_connect() {
    $ini_array = parse_ini_file('../creds.ini');
    $servername = $ini_array['servername'];
    $username = $ini_array['username'];
    $password = $ini_array['password'];
    $dbname = $ini_array['dbname'];
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // TODO: Manage errors in a better way?
    if ($conn->connect_error) {
        return NULL;
    }

    // For proper safety reasons (TODO: is it ok?)
    $conn->set_charset('utf8mb4');

    return $conn;
}

?>
