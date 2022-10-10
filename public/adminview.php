<!DOCTYPE html>
<html>
    <?php include "header.php"?>
    <body>
        <?php include "navbar.php"?>

        <div class="menu" id="modalMenu">
            <div class="menu-content">
                <span class="close">
                    <img class="close" src="img/assets/close.svg" alt="x">
                </span>
                <div class="w3-row">
                    <div class="w3-col l2">    
                        <img class="menu-icon" src="img/communities/charly.png">
                        <img class="menu-symbol" src="img/assets/editIcon.svg" style="margin-top:22%; margin-left:0px;">
                    </div>
                    <div class="w3-col l9 menu-box">
                        <p>Rock Nacional!</p>
                    </div>
                    <div class="w3-col l1">
                        <img class="menu-symbol" src="img/assets/editIcon.svg">
                        <img class="menu-symbol" src="img/assets/trash.svg">
                    </div>
                </div>
                <div class="w3-row">
                    <div class="w3-col l2">
                        <h4 style="margin-left:30px;margin-top:40px;">Tags</h4>
                    </div>
                    <div class="w3-col l9 menu-box">
                        <div class="tags">
                            <a href="tags/rock" class="music-tag">rock</a> 
                            <a href="tags/Argentina" class="music-tag">Argentina</a>
                        </div>
                    </div>
                    <div class="w3-col l1">
                        <img class="menu-symbol" src="img/assets/editIcon.svg">
                    </div>
                </div>
            </div>
        </div>

        <!--link rel="stylesheet" href="adminview.css"-->

        <div class="wrapper">
            <div class="w3-container w3-round-xxlarge" id="table-cont"> 
                <div class="w3-row" id="view-type"><!--style="background-color:var(--dark-color);"-->
                    <h1>Comunidades:</h1>
                </div>

                <div class="w3-row grid-header">
                    <!--div class="w3-col m2 l1"><p style="margin-left: 10px;"> Icon</p></div>
                    <div class="w3-col m4 l4"><p>Nombre</p></div>
                    <div class="w3-col m4 l3"><p>Miembros</p></div>
                    <div class="w3-col m10 l3"><p>Publicaciones</p></div>  
                    <div class="w3-col m2 l1"><p>Opciones</p></div-->       
                </div>
                <div class="w3-row w3-white grid-row">
                    <div class="w3-col m2 l1"><img class="grid-icon" src="img/communities/charly.png" alt="Comunidad: Rock Nacional!"></div>
                    <div class="w3-col m4 l4"><p>Rock Nacional!</p></div>
                    <div class="w3-col m4 l3"><p>36,748 miembros</p></div>
                    <div class="w3-col m10 l3"><p>12,355 reviews</p></div>

                    <div class="w3-col m2 l1">
                        <div class="show">
                            <img class="grid-icon" src="img/assets/options.svg" alt="Opciones">
                        </div>
                    </div>
                </div>

                <div class="w3-row w3-grey grid-row">
                    <div class="w3-col m2 l1"><img class="grid-icon" src="img/communities/beethoven.png" alt="Comunidad: Música Clásica"></div>
                    <div class="w3-col m4 l4"><p>Música Clásica</p></div>
                    <div class="w3-col m4 l3"><p>14,341 miembros</p></div>
                    <div class="w3-col m10 l3"><p>6,780 reviews</p></div>
                    <div class="w3-col m2 l1"><a><img class="grid-icon" src="img/assets/options.svg" alt="Opciones"></a></div>
                </div>
                <div class="w3-row w3-white grid-row">
                    <div class="w3-col m2 l1"><img class="grid-icon" src="img/communities/evangelion.png" alt="Comunidad: Evangelion"></div>
                    <div class="w3-col m4 l4"><p>Evangelion</p></div>
                    <div class="w3-col m4 l3"><p>10,999 miembros</p></div>
                    <div class="w3-col m10 l3"><p>5,678 reviews</p></div>
                    <div class="w3-col m2 l1"><a><img class="grid-icon" src="img/assets/options.svg" alt="Opciones"></a></div>
                </div>
                <div class="w3-row w3-grey grid-row">
                    <div class="w3-col m2 l1"><img class="grid-icon" src="img/communities/wos.png" alt="Comunidad: Fans de Wos"></div>
                    <div class="w3-col m4 l4"><p>Fans de Wos</p></div>
                    <div class="w3-col m4 l3"><p>6,769 miembros</p></div>
                    <div class="w3-col m10 l3"><p>4,980 reviews</p></div>
                    <div class="w3-col m2 l1"><a><img class="grid-icon" src="img/assets/options.svg" alt="Opciones"></a></div>
                </div>
                <div class="w3-row w3-white grid-row">
                    <div class="w3-col m2 l1"><img class="grid-icon" src="img/communities/led_zeppelin.png" alt="Comunidad: Led Zeppelin"></div>
                    <div class="w3-col m4 l4"><p>Led Zeppelin</p></div>
                    <div class="w3-col m4 l3"><p>13,847 miembros</p></div>
                    <div class="w3-col m10 l3"><p>4,675 reviews</p></div>
                    <div class="w3-col m2 l1"><a><img class="grid-icon" src="img/assets/options.svg" alt="Opciones"></a></div>
                </div>
                <div class="w3-row w3-grey grid-row">
                    <div class="w3-col m2 l1"><img class="grid-icon" src="img/communities/los_palmeras.png" alt="Comunidad: Los Palmeras"></div>
                    <div class="w3-col m4 l4"><p>Los Palmeras</p></div>
                    <div class="w3-col m4 l3"><p>5,814 miembros</p></div>
                    <div class="w3-col m10 l3"><p>4,350 reviews</p></div>
                    <div class="w3-col m2 l1"><a><img class="grid-icon" src="img/assets/options.svg" alt="Opciones"></a></div>
                </div>
                <div class="w3-row w3-white grid-row">
                    <div class="w3-col m2 l1"><img class="grid-icon" src="img/communities/queen.png" alt="Comunidad: Queen"></div>
                    <div class="w3-col m4 l4"><p>Queen</p></div>
                    <div class="w3-col m4 l3"><p>12,768 miembros</p></div>
                    <div class="w3-col m10 l3"><p>3,758 reviews</p></div>
                    <div class="w3-col m2 l1"><a><img class="grid-icon" src="img/assets/options.svg" alt="Opciones"></a></div>
                </div>
                <div class="w3-row w3-grey grid-row">
                    <div class="w3-col m2 l1"><img class="grid-icon" src="img/communities/tito_y_pelusa.png" alt="Comunidad: Canciones Infantiles Argentina"></div>
                    <div class="w3-col m4 l4"><p>Canciones Infantiles Argentina</p></div>
                    <div class="w3-col m4 l3"><p>8,293 miembros</p></div>
                    <div class="w3-col m10 l3"><p>2,855 reviews</p></div>
                    <div class="w3-col m2 l1"><a><img class="grid-icon" src="img/assets/options.svg" alt="Opciones"></a></div>
                </div>
                <div class="w3-row w3-white grid-row">
                    <div class="w3-col m2 l1"><img class="grid-icon" src="img/communities/twenty_one.png" alt="Comunidad: Twenty One Pilots"></div>
                    <div class="w3-col m4 l4"><p>Twenty One Pilots</p></div>
                    <div class="w3-col m4 l3"><p>10,620 miembros</p></div>
                    <div class="w3-col m10 l3"><p>2,567 reviews</p></div>
                    <div class="w3-col m2 l1"><a><img class="grid-icon" src="img/assets/options.svg" alt="Opciones"></a></div>
                </div>
                <div style="background-color:var(--main-color); border-radius:0px 0px 20px 20px; height:25px;"></div>
            </div>  



            <footer class="pie-pagina">
                <div class="footer-2">
                    <small>&copy; 2022 <b>Jamco</b> - Todos los Derechos Reservados</small> <!--copyright cuidado-->
                </div>
            </footer>
        </div>
    </body>
</html>