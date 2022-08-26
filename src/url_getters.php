<?php

function generic_img_url (string $prefix, ?int $id) {
    if ($id != NULL) {
        $path = 'img/' . $prefix . '/' . $id; // it shouldn't be mandatory to have an extension, right?
        if (file_exists($path)) return $path;
    }
    return 'img/' . $prefix . '/0';
}

function profile_pic_url (?int $id) {
    return generic_img_url("profile_pic", $id);
}

function album_cover_url (?int $id) {
    return generic_img_url("albums", $id);
}

function song_url (?int $id) {
    if ($id == NULL)
        return 'songs/0';
    return "songs/$id"; // TODO: Generic when I have more?
}

?>
