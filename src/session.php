<?php

// TODO: refactor? en otro lugar?
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

include_once 'db_connect.php';

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

function retrieve_session() {

    if (empty($_SESSION['id']) || empty($_SESSION['username']) || !intval($_SESSION['id']))
        return array(0,'');

    return array(intval($_SESSION['id']), $_SESSION['username']);
}

?>
