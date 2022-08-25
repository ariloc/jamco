<?php

include_once 'db_connect.php';

function forgot_token_valid (int $id, string $token, $db = NULL) {
    if ((!$db || $db->connect_errno) && !($db = db_connect())) return false; // on any error, we have no way to verify the token

    // also checks the account is valid, in case it was disabled
    // between requesting password reset and entering the link
    $stmt = $db->prepare('SELECT activation_token FROM users WHERE id = ? AND now() <= activation_expiry AND valid_state = 1');
    $stmt->bind_param('i', $id);

    if (!$stmt->execute()) return false;
    $stmt->bind_result($hashed_token);

    $no_results = true;
    while ($stmt->fetch()) 
        $no_results = false;

    if ($no_results) return false;

    return password_verify($token, $hashed_token);
}

?>
