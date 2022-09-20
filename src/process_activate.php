<?php

include_once 'db_connect.php';
include_once 'db_operations.php';

function back_to_login (int $code) {
    $msg_iserror = 1;
    $targetRegister = 0;

    switch ($code) {
        case 0:
            $msg_iserror = 0;
            $message = "Su cuenta ha sido activada correctamente. Ahora puede iniciar sesión.";
            break;

        // case -1 gets ignored as it goes for the default (db error)

        case -2:
            $message = "Uno o más argumentos no fueron enviados o son inválidos. Intente registrarse nuevamente.";
            $targetRegister = 1;
            break;

        case -3:
            $message = "El token de validación ha expirado. Intente registrarse nuevamente";
            $targetRegister = 1;
            break;

        default:
            $message = "Se ha producido un error desconocido. Inténtelo nuevamente";
    }

    header("Location: " . URL_ROOT . "/login?register=" . $targetRegister . 
           "&message=" . $message . "&msg_iserror=" . $msg_iserror);
    exit();
}

function activate_by_id (int $id, $db) {
    $stmt = $db->prepare('UPDATE users SET activation_token = NULL, activation_expiry = NULL, valid_state = 1 WHERE id = ?');
    
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

function activate_db (int $id, string $token, $db) {
    $stmt = $db->prepare("SELECT activation_token, activation_expiry < now() FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);

    $stmt->execute();

    $stmt->bind_result($hashed_token_aux, $expired_aux);

    $query_empty = 1;
    while ($stmt->fetch()) { // empty buffer first (no 2 simultaneous queries)
        $query_empty = 0;
        $hashed_token = $hashed_token_aux;
        $expired = $expired_aux;
    }

    if ($query_empty) return -2; // invalid arguments

    if (password_verify($token, $hashed_token)) {
        if ($expired) {
            delete_by_id($id, $db);
            return -3; // expired, try registering again
        }
        activate_by_id($id, $db);
        return 0; // ok
    }

    return -2; // invalid arguments (they don't match)
}

// TODO: Refactor such that db is an optional argument, and is only renewed if invalid (?)
function activate (int $id, string $token) {
    $db = db_connect();
    try {
        $ret_code = activate_db($id, $token, $db);
        back_to_login($ret_code);
    }
    catch (Exception $e) {
        back_to_login(-1);
    }
}

?>
