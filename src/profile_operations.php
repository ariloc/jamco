<?php

include_once 'db_connect.php';
include_once 'session.php';
include_once 'url_getters.php';

function get_nickname (int $id, $db = NULL) : ?string {
    if ((!$db || $db->connect_errno) && !($db = db_connect())) return NULL;

    $stmt = $db->prepare("SELECT username, nickname FROM users WHERE id = ?");

    $stmt->bind_param('i', $id);

    if (!$stmt->execute())
        return NULL;

    $stmt->bind_result($username, $nickname);

    if (!($stmt->fetch()))
        return NULL;

    $stmt->close();
    return $nickname ?? $username ?? NULL;
}

// TODO: Should a class be done for returning reviews, instead of arrays?
function get_reviews (int $id, $db = NULL) {
    if ((!$db || $db->connect_errno) && !($db = db_connect())) return NULL;

    $stmt = $db->prepare("SELECT reviews.song AS song_id,". 
                                "albums.id AS album_id,".
                                "songs.name AS song_name,".
                                "reviews.stars AS stars,".
                                "reviews.title AS title,".
                                "reviews.body AS body ".
                         "FROM reviews ".
                         "INNER JOIN songs ".
                         "ON reviews.song = songs.id ".
                         "LEFT JOIN albums ".
                         "ON songs.album = albums.id ".
                         "WHERE reviews.usr = ? ".
                         "LIMIT 10"
                        ); // TODO: BEWARE! There's a chance the user would have the control over how many reviews wants to see in one page (LIMIT 10).

    $stmt->bind_param('i', $id);
    if (!($stmt->execute())) return NULL;

    $result = $stmt->get_result();
    $reviews = array();
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
    $stmt->close();

    $stmt = $db->prepare("SELECT COUNT(*) FROM reviews WHERE usr = ?");
    $stmt->bind_param('i', $id);
    if (!($stmt->execute())) return NULL;
    $stmt->bind_result($review_cnt);
    $stmt->fetch();
    $stmt->close();

    return array($review_cnt, $reviews);
}

function get_songs_exhibitor (int $id, $db = NULL) {
    if ((!$db || $db->connect_errno) && !($db = db_connect())) return NULL;

    $stmt = $db->prepare("SELECT song_exhibitor.song AS song_id,".
                                "songs.name AS song_name,".
                                "albums.id AS album_id ".
                         "FROM song_exhibitor ".
                         "INNER JOIN songs ".
                         "ON song_exhibitor.song = songs.id ".
                         "LEFT JOIN albums ".
                         "ON songs.album = albums.id ".
                         "WHERE song_exhibitor.usr = ?"
                        );

    $stmt->bind_param('i', $id);
    if (!($stmt->execute())) return NULL;

    $result = $stmt->get_result();
    $songs = array();
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
    $stmt->close();

    return $songs;
}

function get_profile_data() {
    if (!($db = db_connect()))
        return -1;

    list($id, $usr) = retrieve_session();
    
    $data = array();
    $data['nickname'] = get_nickname($id, $db);
    list($data['review_cnt'], $data['reviews']) = get_reviews($id, $db);
    $data['song_exb'] = get_songs_exhibitor($id, $db);

    return $data;
}

?>
