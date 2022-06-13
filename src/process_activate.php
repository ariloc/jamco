<?php

include_once 'db_connect.php';

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

    header("Location: /login?register=" . $targetRegister . 
           "&message=" . $message . "&msg_iserror=" . $msg_iserror);
    exit();
}

function activate_by_id ($db, int $id) {
    $stmt = $db->prepare('UPDATE users SET activation_token = NULL, activation_expiry = NULL, valid_state = 1 WHERE id = ?');
    
    print_r($db->error_list);
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}

function delete_by_id ($db, int $id) {
    $stmt = $db->prepare('DELETE FROM users WHERE id = ?');
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}

function activate_db (int $id, string $token) {
    if (!($db = db_connect())) return -1; // database error

    $stmt = $db->prepare("SELECT activation_token, activation_expiry < now() FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);

    if(!$stmt->execute())
        return -1;

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
            delete_by_id($db, $id);
            return -3; // expired, try registering again
        }
        activate_by_id($db, $id);
        return 0; // ok
    }

    return -2; // invalid arguments (they don't match)
}

// TODO: Refactor such that db is an optional argument, and is only renewed if invalid (?)
function activate (int $id, string $token) {
    $ret_code = activate_db($id, $token);
    back_to_login($ret_code);
}


?>
