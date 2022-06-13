<?php

include_once 'db_connect.php';

function check_creds_username (string $username, string $password, $db = NULL) {
    if ((!$db || $db->conn_error) && !($db = db_connect())) return -1;

    // login by email
    $stmt = new mysqli_stmt();
    if (filter_var($username, FILTER_VALIDATE_EMAIL))
        $stmt = $db->prepare("SELECT id, password FROM users WHERE email = ?");
    else // login by username
        $stmt = $db->prepare("SELECT id, password FROM users WHERE username = ?");
    
    $stmt->bind_param('s',$username);
    
    if (!$stmt->execute())
        return -1;

    $stmt->bind_result($id, $hashed_password);
    
    $query_empty = 1;
    while ($stmt->fetch()) {
        $query_empty = 0;
        if (password_verify($password, $hashed_password)) {
            $stmt->close(); // TODO: Beware if the id gets wiped
            return $id; // OK
        }
    }

    if ($query_empty)
        return -2;

    return -3;
}

function create_session (int $id, $db = NULL) {
    if ((!$db || $db->conn_error) && !($db = db_connect())) return -1;

    $stmt = $db->prepare('SELECT username FROM users WHERE id = ?');
    $stmt->bind_param('d', $id);
    $stmt->execute();

    $stmt->bind_result($user_aux);

    $username = '';
    while ($stmt->fetch()) $username = $user_aux;

    if (empty($username))
        return -1; // internal error

    // TODO: Also check if regeneration is successful? See next comment!
    session_start();
    session_regenerate_id();

    // TODO: Implement session expiry with timestamps, for improved security
    // Keep in mind to keep regenerating sessions
    // https://www.php.net/manual/en/features.session.security.management.php#features.session.security.management.session-data-deletion
    // https://stackoverflow.com/questions/10165424/how-secure-are-php-sessions
    // https://www.php.net/manual/en/function.session-regenerate-id.php
    $_SESSION['id'] = $id;
    $_SESSION['username'] = $username;

    return 0;
} 

// returns >= 0 if successful, < 0 otherwise (with certain error codes)
function login(string $username, string $password) {
    if (!($db = db_connect())) return -1;
    
    $usr_id = check_creds_username($username, $password, $db);

    // invalid input and/or credentials
    if ($usr_id < 0) return $usr_id;

    // valid credentials, create session
    return create_session($usr_id, $db);
}

?>
