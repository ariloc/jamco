<?php

include_once '../src/session.php';
include_once '../src/profile_pic.php';
include_once '../src/user_updates.php';

if (empty($_POST['q'])) {
    http_response_code(400); exit;
}

try {
    // TODO: Return some message to go back to login with 403?
    // 401 CAN'T BE USED, it MUST return a WWW-Authenticate header, according to the spec (which doesn't apply to our case)
    $usr_id = retrieve_session()[0];
    if ($usr_id <= 0) { // 403 -> needs to login.
        http_response_code(403); exit;
    }

    switch ($_POST['q']) {
        case 'delete_profile_pic': 
            delete_profile_pic($usr_id);
            break;
        case 'upload_profile_pic':
            if (empty($_POST['image_data'])) {
                http_response_code(400); exit;
            }
            upload_profile_pic($usr_id, $_POST['image_data']);
            break;
        case 'change_nickname':
            if (empty($_POST['nickname'])) {
                http_response_code(400); exit;
            }
            change_nickname($usr_id, $_POST['nickname']);
            break;
    }
}
catch (Exception $e) {
    http_response_code(500); exit;
}

?>
