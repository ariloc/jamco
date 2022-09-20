<?php
    
function delete_profile_pic (int $id) {
    if ($id <= 0) return;
    unlink($_SERVER['DOCUMENT_ROOT'] . 'public/img/profile_pic/' . $id);
}

?>
