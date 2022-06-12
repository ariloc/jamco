<?php

include '../src/db_connect.php';

function back_to_login(int $code) {
    
}

if (empty($_POST['user_id']) || empty($_POST['token']))
    back_to_login(2);

if(!($db = db_connect())) back_to_login(1);


$stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE id = ? AND activation_key = ?");
$stmt->bind_param('ss', $_POST['user_id'], $_POST['token']);



?>
