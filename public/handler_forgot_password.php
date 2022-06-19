<?php

include_once '../src/load_env.php';
include_once '../src/process_forgot_password.php';
# include_once '../src/change_password.php';

if (empty($_POST['form']) ||
    ($_POST['form'] == 'forgot' && empty($_POST['username'])) ||
    ($_POST['form'] == 'confirm' && empty($_POST['password']))) {

    http_response_code(400); exit;
}

$resp_code = 500;
if ($_POST['form'] == 'forgot') {
    $status = recover_account($_POST['username']);
    if (is_numeric($status)) {
        switch ($status) {
            case '-1': $resp_code = 500; break; // internal error
            case '-2': $resp_code = 404; break; // user or email not found
            case '-3': $resp_code = 409; break; // conflict, user exists but has already requested password recovery
        }
    }
    else { // '' is NOT numeric
        echo $status; // email
        $resp_code = 200;
    }
}
else if ($_POST['form'] == 'confirm') {

}

http_response_code($resp_code); exit;
?>
