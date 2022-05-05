$(document).ready(function(){
    var search_bar_focused = false;

    $("div.search-bar").mouseenter(function() {
        if (!search_bar_focused) { // Pues puede borrar la doble sombra con el popup
            $(this).css("box-shadow","3px 3px 5px -3px");
        }
    });
    $("div.search-bar").mouseleave(function() {
        if (!search_bar_focused) {
            $(this).css("box-shadow", "");
        }
    });

    $("input.search-field").focusin(function(){
        search_bar_focused = true;
        $("div.search-bar").css("width", "100%");
        $("#filter-search-button").css({"width": "auto", "opacity": "100%"});
    });

    function hideFilterWindow() {
        $("div.search-bar").css({"border-radius": ""});
        $("#filter-window").css({"opacity": ""});
        $("div.search-bar").css("box-shadow","3px 3px 5px -3px");
    }

    function searchBoxFocusOut() {
        search_bar_focused = false;
        hideFilterWindow();
        $("div.search-bar").mouseleave();
        $("div.search-bar").css({"width": ""});
        $("#filter-window").css({"width": "80%"});
        $("#filter-search-button").css({"width": "", "opacity": ""});
    }
    
    $(document).mouseup(function(e) {
        if (!$("#search-wrapper").is(e.target) && $("#search-wrapper").has(e.target).length === 0) {
            searchBoxFocusOut();
        }
    });

    $("#filter-search-button").click(function(e){
        if ($("#filter-window").css("opacity") == "0") {
            // Todo este lio solo para poder volver al ancho original sin transicion 
            $("#filter-window").addClass("notransition");
            $("#filter-window").css({"width": ""});
            $("#filter-window").outerHeight(); // fuerza a recargar, evita usar en cache
            $("#filter-window").removeClass("notransition");
            $("#filter-window").outerHeight();

            $("#filter-window").css({opacity: "100%"});
            $("div.search-bar").css({"border-bottom-left-radius": "0px",
                                     "border-bottom-right-radius": "0px",
                                     "box-shadow": "5px 11px 5px -5px, 8px -3px 5px -9px"});
        }
        else {
            hideFilterWindow();
        }
    });

    // TODO: Agregar que se pueda ver haciendo click (para celular, fundamentalmente)
    // TODO: Que al tener el mouse sobre el cuadro, no se salga
    var login_timeout;
    $(".profile-pic").hover(
        function() {
            $(".login-popup").css({"transform": "scale(1)"});
        }, function() {
            login_timeout = setTimeout(function() {
                $(".login-popup").css({"transform": ""});
            }, 300);
        }
    );

    $("#search-button-mobile").click(function(){
       // TODO: WIP 
    });
});
