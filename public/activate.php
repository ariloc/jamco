<?php

include '../src/process_activate.php';

// one or more missing arguments
if (empty($_GET['user_id']) ||
    empty($_GET['token']) || 
    !intval($_GET['user_id'])) back_to_login(2);

activate(intval($_GET['user_id']), $_GET['token']);

?>
