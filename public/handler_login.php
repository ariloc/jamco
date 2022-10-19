<?php

include_once '../src/load_env.php';
include_once '../src/process_login.php';
include_once '../src/process_register.php';
include_once '../src/db_connect.php';

try {
    if (empty($_POST['username']) || 
        empty($_POST['password']) || 
        empty($_POST['form']) || 
        ($_POST['form'] != 'register' && $_POST['form'] != 'login') || 
        ($_POST['form'] == 'register' && empty($_POST['email']))) {
        http_response_code(400); exit; 
    }

    // TODO: refactor
    // TODO: add more codes?
    $resp_code = 500;
    if ($_POST['form'] == 'register') {
        // TODO: Should register just return the response_code instead? Should we use a switch statement?
        $status = register($_POST['username'], $_POST['email'], $_POST['password'], db_connect());
        switch($status) {
            case 0: $resp_code = 200; break; // OK
            case -2: $resp_code = 400; break; // invalid input (i.e. incorrectly formatted mail)
            case -3: $resp_code = 409; break; // conflict (i.e. existing user/mail)
            default: $resp_code = 500; break; // db error
        }
    }
    else {
        $status = login($_POST['username'], $_POST['password'], db_connect());
        switch ($status) {
            case 0: $resp_code = 200; break; // OK
            case -2: $resp_code = 404; break; // inexistent username
            case -3: $resp_code = 401; break; // user and password don't match
            case -4: $resp_code = 403; break; // account disabled
            default: $resp_code = 500; break; // db error
        } 
    }

    http_response_code($resp_code); exit;
}
catch (Exception $e) {
    http_response_code(500); exit;
}
?>
