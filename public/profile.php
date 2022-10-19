<?php 

include_once '../src/url_getters.php';
include_once '../src/session.php';
include_once '../src/profile_operations.php';
include_once '../src/load_env.php';
include_once '../src/db_connect.php';

list($user_id, $username) = retrieve_session();

if ($user_id <= 0) {
    header('Location: ' . URL_ROOT . '/login');
    exit();    
}

$data = get_profile_data(db_connect());

?>

<!DOCTYPE html>
<html>
    <?php include "header.php"; ?>
    <body>
        <?php include "navbar.php"; ?>
        <div class="profile-header">
            <div class="profile-banner-wrapper">
                <div class="profile-banner">
                    <img src="img/communities/chainsmoker.png" alt="banner">
                    <div class="edit-btn">
                        <i class="fa-solid fa-image"></i>
                    </div>
                </div>
            </div>

            <div class="profile-pic-data">
                <div class="profile-pic-wrapper">
                    <div class="profile-pic">
                        <img src="<?php echo profile_pic_url($user_id); ?>" alt="perfil">
                        <div class="edit-btn">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </div>
                </div>

                <div class="profile-data">
                <h3><?php echo $data['nickname'] ?? "Nickname"; ?></h3>
                    <ul class="profile-data-info">
                        <li><?php echo $data['review_cnt']; ?> Reviews</li>
                        <li>134 Comunidades</li>
                        <li>134 Playlists</li>
                    </ul>
                </div>
            </div>
        </div>

        <?php if (!empty($data['song_exb'])): ?>
        <div class="profile-songs-wrapper">
            <div class="profile-songs">
                <?php foreach ($data['song_exb'] as $song): ?>
                <div>
                    <div class="profile-slide-content">
                    <a href="<?php echo song_url($song['song_id']); ?>">
                            <img src="<?php echo album_cover_url($song['album_id']); ?>">
                        </a>
                        <h6><?php echo $song['song_name']; ?></h6>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="tabs-container">
            <div class="tabs-wrapper">
                <div class="tabs">
                    <div>
                        <span class="fa fa-bookmark"></span><span class="tab-text">Reseñas</span>
                    </div>
                    <div>
                        <span class="fa fa-users"></span><span class="tab-text">Comunidades</span>
                    </div>
                    <div>
                        <span class="fa fa-music"></span><span class="tab-text">Playlists</span>
                    </div>
                </div>
                <div class="tab-indicator"></div>
            </div>

		    <div class="secciones">
                <div class="active"></div>
                <div class="inactive">
                    <div>
                        <div class="profile-review w3-row">
                            <?php foreach($data['reviews'] as $row): ?>
                            <div class="profile-review-card-wrapper w3-col l6">
                                <div class="profile-review-card">
                                    <div class="profile-review-header">
                                        <div class="profile-review-header-data">
                                            <div class="profile-review-image">
                                                <img src="<?php echo album_cover_url($row['album_id']); ?>">
                                            </div>
                                            <div class="profile-review-header-container">
                                                <div class="profile-review-header-data-user">
                                                    <a href="<?php echo song_url($row['song_id']); ?>">
                                                            <?php echo $row['song_name']; ?>
                                                    </a>
                                                </div>
                                                <div class="rating-stars">
                                                    <?php for ($star = 1; $star <= 5; $star++): ?>
                                                    <i class="material-icons">
                                                        <?php $v = ($row['stars']-$star); ?>
                                                        <?php echo ($v >= 0) ? "star" : (($v > -1) ? "star_half" : "star_border"); ?>
                                                    </i>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-review-text">
                                        <?php if(isset($row['title']) || isset($row['body'])): ?>
                                        <div class="text-container">
                                            <p class="review-quote">
                                                <?php if(isset($row['title'])): ?>
                                                <b class="review-quote-title">
                                                    <?php echo $row['title']; ?>
                                                </b>
                                                <?php endif; ?>

                                                <?php if(isset($row['body'])): ?>
                                                <span class="review-quote-body">
                                                    <?php echo $row['body']; ?>
                                                </span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <?php endif; ?>

                                        <div class="read-more-btn">
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div style="padding: 10px;">
                    <div class ="profile-communities">

                    <div class="profile-communities-cards">
                            <div class="profile-communities-banner">
                                <img src="img/communities/chainsmoker.png">
                            </div>
                            <div class="profile-communities-header">
                                <h3>Nombre_Comunidad</h3>
                                <span class="fa fa-user"></span><span class="tab-text">1625</span>
                                <div class="tags-carousel">
                                    <a href="tags/clasica" class="music-tag">clásica</a> <a href="tags/Mundo" class="music-tag">Mundo</a>
                                </div>
                            </div>
                        </div>

                        <div class="profile-communities-cards">
                            <div class="profile-communities-banner">
                                <img src="img/communities/chainsmoker.png">
                            </div>
                            <div class="profile-communities-header">
                                <h3>Nombre_Comunidad</h3>
                                <span class="fa fa-user"></span><span class="tab-text">1625</span>
                                <div class="tags-carousel">
                                    <a href="tags/clasica" class="music-tag">clásica</a> <a href="tags/Mundo" class="music-tag">Mundo</a>
                                </div>
                            </div>
                        </div>


                        <div class="profile-communities-cards">
                            <div class="profile-communities-banner">
                                <img src="img/communities/chainsmoker.png">
                            </div>
                            <div class="profile-communities-header">
                                <h3>Nombre_Comunidad</h3>
                                <span class="fa fa-user"></span><span class="tab-text">1625</span>
                                <div class="tags-carousel">
                                    <a href="tags/clasica" class="music-tag">clásica</a> <a href="tags/Mundo" class="music-tag">Mundo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div style="padding: 10px;">
                        <div class="profile-playlist">
                            <div class="profile-playlist-cards">
                                <img src="img/communities/chainsmoker.png">
                                <h3>Nombre_Playlist</h3>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                            </div>
                            <div class="profile-playlist-cards">
                                <img src="img/communities/chainsmoker.png">
                                <h3>Nombre_Playlist</h3>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                            </div>
                            <div class="profile-playlist-cards">
                                <img src="img/communities/chainsmoker.png">
                                <h3>Nombre_Playlist</h3>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                            </div>
                            <div class="profile-playlist-cards">
                                <img src="img/communities/chainsmoker.png">
                                <h3>Nombre_Playlist</h3>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal">
            <div class="modal-dialog-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content"></div>
                    <div class="modal-close">
                        <span class="material-icons">close</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="crop-image-modal" style="display: none;">
            <div class="image-cropper-wrapper">
                <img class="image-cropper" src="img/profile_pic/0"></img>
            </div>
        </div>

        <div style="display: none;" id="profile-pic-upload-modal">
            <div class="profile-pic">
                <img src="<?php echo profile_pic_url($user_id); ?>" alt="perfil">
            </div>
            <div class="profile-pic-modal-footer">
                <div class="profile-upload-btn-row row main-buttons">
                    <input class="profile-pic-file-upload" type="file" accept="image/gif, image/png, image/jpeg"></input>
                    <div class="wrapper w3-col s6">
                        <div class="delete-pic-alert"> 
                            <b>¿Eliminar foto?</b>
                        </div>
                        <div class="profile-upload-btn positive-btn upload">
                            <p>
                                <i class="fa-solid fa-upload"></i><span class="btn-txt">&nbsp;&nbsp;Subir</span>
                            </p>
                        </div>
                    </div>
                    <div class="wrapper w3-col s6">
                        <div class="profile-upload-btn neutral-btn cancel-delete" id="delete-profile-pic-cancel-btn">
                            <p>
                                <i class="fa-solid fa-arrow-left"></i>
                            </p>
                        </div>
                        <div class="profile-upload-btn negative-btn delete" id="delete-profile-pic-btn">
                            <p>
                                <i class="fa-solid fa-trash"></i><span class="btn-txt">&nbsp;&nbsp;Eliminar</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="profile-upload-btn-row upload-bar hidden">
                    <div class="profile-upload-btn neutral-btn back-btn">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div class="filename">
                        <p>Archivo.jpg</p>
                    </div>
                    <div class="profile-upload-btn positive-btn upload-btn">
                        <i class="fa-solid fa-upload"></i>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
