<?php

include_once '../src/process_login.php';
include_once '../src/process_register.php';

if (empty($_POST['username']) || 
    empty($_POST['password']) || 
    empty($_POST['form']) || 
    ($_POST['form'] != 'register' && $_POST['form'] != 'login') || 
    ($_POST['form'] == 'register' && empty($_POST['email']))) {
    http_response_code(400); exit(); 
}

// TODO: refactor
$resp_code = 500;
if ($_POST['form'] == 'register') {
    // TODO: Should register just return the response_code instead? Should we use a switch statement?
    $status = register($_POST['username'], $_POST['email'], $_POST['password']);
    if ($status == 0) $resp_code = 200; // OK
    else if ($status == -1) $resp_code = 500; // db error
    else if ($status == -2) $resp_code = 400; // invalid input (i.e. incorrectly formatted mail)
    else if ($status == -3) $resp_code = 309; // conflict (i.e. existing user/mail)
    // TODO: Add more codes?

}
else {
    $status = login($_POST['username'], $_POST['password']);
    if ($status == 0) $resp_code = 200; // OK
    else if ($status == -1) $resp_code = 500; // db error
    else if ($status == -2) $resp_code = 404; // inexistent username
    else if ($status == -3) $resp_code = 401; // user and password don't match
    else if ($status == -4) $resp_code = 403; // account disabled
}

http_response_code($resp_code);
exit();
?>
