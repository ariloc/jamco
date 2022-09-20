<?php

include_once '../src/load_env.php';
include_once '../src/process_forgot_password.php';
include_once '../src/process_confirm_forgot_pass.php';
include_once '../src/db_connect.php';

try {
    if (empty($_POST['form']) ||
        ($_POST['form'] == 'forgot' && empty($_POST['username'])) ||
        ($_POST['form'] == 'confirm' && (empty($_POST['user_id']) ||
                                         empty($_POST['token']) ||
                                         empty($_POST['password'])))) {

        http_response_code(400); exit;
    }

    $resp_code = 500;
    if ($_POST['form'] == 'forgot') {
        $status = recover_account($_POST['username'], db_connect());
        if (is_numeric($status)) {
            switch ($status) {
                case '-2': $resp_code = 404; break; // user or email not found
                case '-3': $resp_code = 409; break; // conflict, user exists but has already requested password recovery
                default: $resp_code = 500; break; // internal error
            }
        }
        else { // '' is NOT numeric
            echo $status; // email
            $resp_code = 200;
        }
    }
    else if ($_POST['form'] == 'confirm') {
        $status = confirm_forgot_pass(intval($_POST['user_id']), $_POST['token'], $_POST['password'], db_connect());
        switch($status) {
            case 0: $resp_code = 200; break; // changed OK
            case -2: $resp_code = 401; break; // token expired, unauthorized
            case -3: $resp_code = 400; break; // invalid request (for example, password doesn't comply client-side verified restrictions)
            default: $resp_code = 500; break; // internal error
        }
    }
    http_response_code($resp_code); exit;
}
catch (Exception $e) {
    http_response_code(500); exit;
}

?>
