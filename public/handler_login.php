<?php

#include '../src/process_login.php'
include '../src/process_register.php';

if (empty($_POST['username']) || 
    empty($_POST['password']) || 
    empty($_POST['form']) || 
    ($_POST['form'] != 'register' && $_POST['form'] != 'login') || 
    ($_POST['form'] == 'register' && empty($_POST['email']))) {
    http_response_code(400); exit; 
}

$resp_code = 500;
if ($_POST['form'] == 'register') {
    $status = register($_POST['username'], $_POST['email'], $_POST['password']);
    if ($status == 3) $resp_code = 409; // conflict
    if ($status == 2) $resp_code = 400; // invalid input (i.e. incorrectly formatted mail)
    if ($status == 1) $resp_code = 500; // db error
    if ($status == 0) $resp_code = 200; // OK
    // TODO: Add more codes?

}
else {
    // TODO: login may return a number whether it succeeded or not 
    # login($_POST['username'], $_POST['email']);
}

http_response_code($resp_code);
exit;
?>
