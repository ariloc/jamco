<?php

include_once '../src/session.php';
include_once '../src/db_connect.php';
include_once '../src/profile_pic.php';

if (empty($_POST['q'])) {
    http_response_code(400); exit;
}

try {
    $db = db_connect();

    switch ($_POST['q']) {
        case 'delete_profile_pic': 
            delete_profile_pic(retrieve_session()[0]);
            break;
        case 'upload_profile_pic':
            if (empty($_POST['image_data'])) {
                http_response_code(400); exit;
            }
            upload_profile_pic(retrieve_session()[0], $_POST['image_data']);
            break;
    }
}
catch (Exception $e) {
    http_response_code(500); exit;
}

?>
