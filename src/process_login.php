<?php

include_once 'db_connect.php';
include_once 'session.php';

function check_creds_username (string $username, string $password, $db) {
    // login by email
    $stmt = new stdClass();
    if (filter_var($username, FILTER_VALIDATE_EMAIL))
        $stmt = $db->prepare("SELECT id, password, valid_state FROM users WHERE email = ?");
    else // login by username
        $stmt = $db->prepare("SELECT id, password, valid_state FROM users WHERE username = ?");
    
    $stmt->bind_param('s',$username);
    
    $stmt->execute();

    $stmt->bind_result($id, $hashed_password, $account_state);
    
    $query_empty = 1;
    while ($stmt->fetch()) {
        $query_empty = 0;
        if (password_verify($password, $hashed_password)) {
            $stmt->close();

            if ($account_state != 1)
                return -4;

            return $id; // OK
        }
    }

    if ($query_empty)
        return -2;

    return -3;
}

// true-false if successful or not
function update_login_stats (int $id, $db) {
    $stmt = $db->prepare('UPDATE users SET last_login = now(), login_times = login_times + 1 WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

// returns >= 0 if successful, < 0 otherwise (with certain error codes)
function login(string $username, string $password, $db) {
    $usr_id = check_creds_username($username, $password, $db);

    // invalid input and/or credentials
    if ($usr_id < 0) return $usr_id;

    // valid credentials, create session
    $session = create_session($usr_id, $db);

    // if successful, TRY to update database with login date and
    // last logged in time
    update_login_stats($usr_id, $db);

    return 0; // everything OK
}

?>
