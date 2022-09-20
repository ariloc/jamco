<?php

include_once 'db_connect.php';
include_once 'field_compliance.php';
include_once 'forgot_token_valid.php';

function confirm_forgot_pass (int $id, string $token, string $new_password, $db) {
    if (!password_complies($new_password))
        return -3;

    if (!forgot_token_valid($id, $token, $db))
        return -2;

    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    // TODO: Change token when entering the link, so that it's invalidated
    // once you visit it. The tab will keep the new token and will use it
    // to update the password. If the tab is closed, a new password reset
    // should be requested.
    
    // once the link is used successfully, it's not valid anymore
    $stmt = $db->prepare('UPDATE users SET password = ?, activation_token = NULL, activation_expiry = NULL WHERE id = ?');
    $stmt->bind_param('si', $hashed_new_password, $id);

    $stmt->execute();

    return 0;
}

?>
