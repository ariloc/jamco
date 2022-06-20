<?php

include_once 'db_connect.php';
include_once 'recover_email.php';
include_once 'generate_random_token.php';

// TOKEN EXPIRY PERIOD (ACCOUNT RECOVERY): 20 minutes
$recovery_expiry_period = 20 * 60;
$resend_recovery_period = 5 * 60; // one mail per 5 minutes

function obfuscate_email ($email) {
    $em = explode("@",$email);
    $og_len = strlen($em[0]);
    $len = min(3, floor($og_len / 2)); // show 3 chars at most
    $em[0] = substr($em[0], 0, $len) . str_repeat('*', strlen($em[0])-$len);

    // "supports multiple '@' symbols in address"
    for ($i = 1; $i < count($em)-1; $i++)
        $em[$i] = str_repeat('*', strlen($em[$i]));
                    
    return implode('@', $em);
}

function set_recovery_token (int $id, string $token, $db = NULL) {
    if ((!$db || $db->connect_errno) && !($db = db_connect()))
        return false;

    global $recovery_expiry_period;
    $expiry_timestamp = date("Y-m-d H:i:s", time() + $recovery_expiry_period);

    $stmt = $db->prepare('UPDATE users SET activation_token = ?, activation_expiry = ? WHERE id = ?');
    
    $stmt->bind_param('ssi', $token, $expiry_timestamp, $id);
    return $stmt->execute();
}

function recover_account (string $username) {
    if (!($db = db_connect())) return '-1'; // db error

    $stmt = new stdClass();
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $stmt = $db->prepare('SELECT id, email, valid_state, COALESCE(activation_expiry, "") FROM users WHERE email = ?');
    }
    else {
        $stmt = $db->prepare('SELECT id, email, valid_state, COALESCE(activation_expiry, "") FROM users WHERE username = ?');
    }

    $stmt->bind_param('s', $username);
    if (!$stmt->execute()) return '-1'; // db error

    $stmt->bind_result($id, $email, $account_state, $prv_expiry);

    $no_results = 1;
    while ($stmt->fetch()) { // should loop at most 1 result
        // only recover enabled accounts
        if ($account_state != 1) continue;
        $no_results = 0;
    }

    // if no valid accounts found, user or email doesn't exist
    if ($no_results)
        return '-2';

    // if requested in less time than the resend period
    global $recovery_expiry_period, $resend_recovery_period;
    if ($prv_expiry != '' &&
        time() <= (strtotime($prv_expiry) - 
                   $recovery_expiry_period +
                   $resend_recovery_period))
        return '-3';


    // we'll reuse the token field for password recovery
    $token = generate_random_token();

    if (!set_recovery_token($id, password_hash($token, PASSWORD_DEFAULT), $db))
        return '-1'; // db error

    if (!send_recover_email($id, $email, $token))
        return '-1'; // server email error

    return obfuscate_email($email);
}

?>
