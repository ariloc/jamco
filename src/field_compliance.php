<?php

// Here lies functions to check compliance for fields that have to have
// a specific criteria or format.
// This way, any changes can be done quickly without looking around the source files.

function password_complies (string $password) : bool {
    return preg_match('/^(?=.*[A-Za-z])(?=.*[0-9]).{8,}$/', $password);
}

function username_complies (string $username) : bool {
    return preg_match('/^[A-Za-z][A-Za-z0-9_]{4,30}[A-Za-z]$/', $username);
}

?>
