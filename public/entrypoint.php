<?php

include_once '../src/session.php';
include_once '../src/delete_profile_pic.php';
include_once '../src/db_connect.php';

if (empty($_POST['q'])) {
    http_response_code(400); exit;
}

try {
    $db = db_connect();

    switch ($_POST['q']) {
        case 'delete_profile_pic': delete_profile_pic(retrieve_session()[0]); break;
    }
}
catch (Exception $e) {
    http_response_code(500); exit;
}

?>
