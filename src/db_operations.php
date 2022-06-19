<?php

// Here lies implementations for simple and general operations in the database that may be useful across the project.

include_once 'db_connect.php';

// Given an id, deletes the user that matches the id
function delete_by_id (int $id, $db = NULL) {
    if ((!$db || $db->connect_errno) && !($db = db_connect())) return false;

    $stmt = $db->prepare('DELETE FROM users WHERE id = ?');
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}

?>
