<?php
    $env_array = parse_ini_file('../env.ini');
    define("URL_ROOT", $env_array['url_root']);
?>
