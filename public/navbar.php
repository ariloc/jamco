<?php

include_once '../src/session.php';

function profile_pic_path_id (int $id) {
    $path = "img/profile_pic/$id"; // it shouldn't be mandatory to have an extension, right?
    if (file_exists($path)) return $path;
    return 'img/profile_pic/0';
}

list($id, $usr) = retrieve_session();
if ($id > 0)
    $profile_pic_path = profile_pic_path_id($id);

?>

<header class="navbar w3-cell-row">
    <div id="navbar-left-div" class="w3-container w3-cell w3-cell-middle" style="width: 30%;">
        <a href="/">
            <img class="logo" src="img/assets/logo.svg" alt="Logo Jamco" />
        </a>
    </div>
    <div class="w3-cell w3-cell-middle">
        <div id="search-btn-wrapper">
            <button id="search-close-mobile" class="navbar-button">
                <i class="material-icons">close</i>
            </button>

            <div id="search-wrapper">
                <div class="search-mobile">
                    <button id="search-button-mobile" class="navbar-button">
                        <i class="material-icons">search</i>
                    </button>    
                </div>

                <div class="search-bar">
                    <input class="search-field w3-input" type="text" placeholder="Búsqueda..." />
                    <button class="navbar-button" id="filter-search-button">
                        <i class="material-icons">filter_alt</i>
                    </button>
                    <button class="navbar-button">
                        <i class="material-icons">search</i>
                    </button>    
                </div>
                
                <div id="filter-window-wrapper">
                    <div id="filter-window" style="background-color: var(--light-color);">
                        <div class="w3-container">
                            <!-- TODO: Agregar filtros por tags, rating, etc, cuando sea posible -->
                            <h4>Filtrar por:</h4>
                            <div class="w3-row">
                                <div class="w3-col l3 m6 filter-container">
                                    <input class="w3-check" type="checkbox" id="cbox-filter-communities">
                                    <label for="cbox-filter-communities">Comunidades</label>
                                </div>
                                <div class="w3-col l3 m6 filter-container">
                                    <input class="w3-check" type="checkbox" id="cbox-filter-songs">
                                    <label for="cbox-filter-songs">Canciones</label>
                                </div>
                                <div class="w3-col l3 m6 filter-container">
                                    <input class="w3-check" type="checkbox" id="cbox-filter-albums">
                                    <label for="cbox-filter-albums">Álbumes</label>
                                </div>
                                <div class="w3-col l3 m6 filter-container">
                                    <input class="w3-check" type="checkbox" id="cbox-filter-artists">
                                    <label for="cbox-filter-artists">Artistas</label>
                                </div>
                            </div>
                            <p></p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="navbar-right-div" class="w3-container w3-cell w3-cell-middle" style="width: 30%;">

        <div class="profile-wrapper">

            <?php if (isset($profile_pic_path)) : ?>
                <div class="profile-pic">
                    <a href="profile">
                        <img src="<?php echo $profile_pic_path; ?>" ></img>
                    </a>
                </div>
            <?php else : ?>
                <a href="login" class="standalone-navbar-button">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>
