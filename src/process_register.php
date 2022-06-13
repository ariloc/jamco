<?php

include_once 'db_connect.php';
include_once 'activation_email.php';

// TOKEN EXPIRY PERIOD: 15 minutes
$expiry_period = 15 * 60;

function generate_activation_code() : string {
    return bin2hex(random_bytes(16));
}

function register (string $username, string $email, string $password) {
    if (($db = db_connect()) == NULL) return -1; // database error

    // invalid email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        return -2;

    // 6-32, starts with letter, alphanumeric
    if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username))
        return -2;

    $activation_token = generate_activation_code();

    $hashed_token = password_hash($activation_token, PASSWORD_DEFAULT);
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    global $expiry_period;
    $expiry_timestamp = date("Y-m-d H:i:s", time() + $expiry_period);

    $stmt = $db->prepare("INSERT INTO users (username, email, password, activation_token, activation_expiry) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $username,
                               $email,
                               $hashed_pass,
                               $hashed_token,
                               $expiry_timestamp,
    );

    if (!$stmt->execute()) {
        if ($stmt->errno == 1062) return -3; // duplicate entry 
        return 1; // error with database
    }

    // TODO: revert changes in database?
    if (!send_activation_email($stmt->insert_id, $email, $activation_token))
        return -1; // error while sending email

    return 0; // everything OK
}
?>
