<?php

$IMAGE_DIR = $_SERVER['DOCUMENT_ROOT'] . 'public/img/profile_pic/';
    
function delete_profile_pic (int $id) {
    if ($id <= 0) return;
    global $IMAGE_DIR;
    unlink($IMAGE_DIR . $id);
}

function upload_profile_pic (int $id, string $img_data) {
    if ($id <= 0) return;

    global $IMAGE_DIR;
    $image = imagecreatefromstring(dataurl_decode($img_data));
    $size = min(imagesx($image), imagesy($image));
    $image = imagecrop($image, 
        [
            'x' => 0,
            'y' => 0,
            'width' => $size,
            'height' => $size
        ]
    );
    $image = imagescale($image, 512); // 512x512px

    imagepng($image, $IMAGE_DIR . $id);
}

function dataurl_decode($data): string {
    $data = explode(',', $data)[1];
    $data = base64_decode($data);
    if (!$data)
        throw new Exception("Image decoding error.");
    return $data;
}

?>
