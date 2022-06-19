<?php

function generate_random_token() : string {
    return bin2hex(random_bytes(16));
}

?>
