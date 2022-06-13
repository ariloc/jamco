<?php

include_once '../src/process_login.php';
include_once '../src/process_register.php';

if (empty($_POST['username']) || 
    empty($_POST['password']) || 
    empty($_POST['form']) || 
    ($_POST['form'] != 'register' && $_POST['form'] != 'login') || 
    ($_POST['form'] == 'register' && empty($_POST['email']))) {
    http_response_code(400); exit; 
}

$resp_code = 500;
if ($_POST['form'] == 'register') {
    // TODO: Should register just return the response_code instead? Should we use a switch statement?
    $status = register($_POST['username'], $_POST['email'], $_POST['password']);
    switch ($status) {
        case 0:     $resp_code = 200; break; // OK
        case -1:    $resp_code = 500; break; // db error
        case -2:    $resp_code = 400; break; // invalid input (i.e. incorrectly formatted mail)
        case -3:    $resp_code = 309; break; // conflict (i.e. existing user/mail)
    }
    // TODO: Add more codes?

}
else {
    $status = login($_POST['username'], $_POST['password']);
    switch ($status) {
        case 0:     $resp_code = 200; break; // OK
        case -1:    $resp_code = 500; break; // db error
        case -2:    $resp_code = 404; break; // inexistent username
        case -3:    $resp_code = 403; break; // user and password don't match
    }
}

http_response_code($resp_code);
exit;
?>
