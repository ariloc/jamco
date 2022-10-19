<?php

include_once 'db_connect.php';
include_once 'activation_email.php';
include_once 'generate_random_token.php';
include_once 'field_compliance.php';

/*
// TODO: Setup a better way to resend an email (timer on screen) if the user doesn't 
// receive it within a couple of minutes
$resend_register_period = 5 * 60; // one mail per 5 minutes
*/

// TOKEN EXPIRY PERIOD: 2 hours
$register_expiry_period = 120 * 60;

// TODO: Delete unused users automatically to clean the tables (schedule)
function delete_unused_conflict_users (string $username, string $email, $db) {
    $stmt = $db->prepare('DELETE FROM users WHERE (username = ? OR email = ?) AND valid_state = 0 AND activation_expiry < now()');
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
}

function register (string $username, string $email, string $password, $db) {
    // invalid email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        return -2;

    // check user format 
    if (!username_complies($username))
        return -2;

    // enforce password requirements
    if (!password_complies($password))
        return -2;

    $activation_token = generate_random_token();

    $hashed_token = password_hash($activation_token, PASSWORD_DEFAULT);
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    global $register_expiry_period;
    $expiry_timestamp = date("Y-m-d H:i:s", time() + $register_expiry_period);

    // if this fails and leads to report the user/email exists, I probably have bigger issues to attend
    // so no "return -1;" here. Also consider that most of the time emails or usernames won't be repeated.
    delete_unused_conflict_users($username, $email, $db);

    $stmt = $db->prepare("INSERT INTO users (username, email, password, activation_token, activation_expiry) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $username,
                               $email,
                               $hashed_pass,
                               $hashed_token,
                               $expiry_timestamp
    );

    try { $stmt->execute(); }
    catch (Exception $e) {
        if ($stmt->errno == 1062) return -3; // duplicate entry
        throw new Exception($e->getMessage()); // otherwise continue propagating
    }

    // TODO: revert changes in database? (on fail)
    if (!send_activation_email($stmt->insert_id, $email, $activation_token))
        return -1; // error while sending email

    return 0; // everything OK
}
?>
