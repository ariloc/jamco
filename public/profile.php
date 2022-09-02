<?php 

include_once '../src/url_getters.php';
include_once '../src/session.php';
include_once '../src/profile_operations.php';
include_once '../src/load_env.php';

list($user_id, $username) = retrieve_session();

if ($user_id <= 0) {
    header('Location: ' . URL_ROOT . '/login');
    exit();    
}

$data = get_profile_data();

?>

<!DOCTYPE html>
<html>
    <?php include "header.php"; ?>
    <body>
        <?php include "navbar.php"; ?>
        <div class="profile-header">
            <div class="profile-banner">
                <img src="img/communities/chainsmoker.png" alt="banner">
            </div>

            <div class="profile-pic-data">
                <div class="profile-pic">
                <img src="<?php echo profile_pic_url($user_id); ?>" alt="perfil">
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
                        <h1>Comunidades</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel voluptates unde, consequuntur aliquid architecto rem numquam expedita minima dolorem pariatur recusandae, eius quod quia aspernatur id impedit, tenetur! Aspernatur incidunt molestiae dolores animi ea praesentium ipsam tenetur voluptas cupiditate perspiciatis eum nihil, natus exercitationem libero earum fuga dignissimos impedit numquam, quasi, placeat officiis voluptates, ad reprehenderit fugiat? Fugiat aperiam et magni, molestiae, numquam consectetur vitae sapiente cupiditate totam laboriosam voluptate obcaecati, aliquam placeat? Suscipit dolores fuga laudantium sed, qui magni iusto dolore quia. Quis fugit exercitationem porro. Rerum nihil omnis recusandae ratione fuga alias eligendi, earum sunt veritatis praesentium eum perspiciatis. Molestias deserunt, iure neque animi quod! Impedit reprehenderit cumque, numquam velit quae cum eius quidem similique laudantium hic deleniti!</p>
                    </div>
                    <div style="padding: 10px;">
                        <h1>Playlists</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea numquam odio voluptate. Aliquam incidunt similique, et quasi ducimus quos aut autem non dignissimos dicta sit provident, voluptatibus ut blanditiis perspiciatis cum, vel temporibus minima enim. Asperiores omnis placeat officiis a tenetur sit recusandae, reprehenderit neque. Tempora quibusdam, perferendis id ratione culpa dolorum! Nemo, animi?</p><br>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum dignissimos at esse, ipsum rerum assumenda nisi obcaecati! Aliquam iure voluptatem incidunt, explicabo sit labore, perferendis eius ad vel quia. Praesentium, doloribus. Quisquam provident nostrum totam itaque debitis, minima, tempore dolores!</p>
                    </div>
                </div>
		    </div>
        </div>
    </body>
</html>
