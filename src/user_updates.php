<?php

include_once 'db_connect.php';

function change_nickname (int $id, string $nickname) {
    $db = db_connect();
    $stmt = $db->prepare('UPDATE users SET nickname = ? WHERE id = ?');
    $stmt->bind_param('si', $nickname, $id);
    $stmt->execute();
}

?>
