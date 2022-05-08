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

    $("input.search-field").focusin(function() {
        search_bar_focused = true;
        $("div.search-bar").animate({width: "100%"},100,function(){});
        $("#filter-search-button").css({"display": "flex"}).animate({
            width: "42px",
            opacity: 1
        },100);
    });

    function hideFilterWindow() {
        $("#filter-window").slideUp(200, function() {
            $("div.search-bar").css({"border-radius": "20px", "box-shadow": "3px 3px 5px -3px"});
    	});
    }

    function searchBoxFocusOut() {
        search_bar_focused = false;

        hideFilterWindow();
        $("#filter-window").animate({
            width: "80%"
        }, {
            duration: 100,
            queue: false
        });
        
        $("div.search-bar").mouseleave();
        $("div.search-bar").animate({width: "80%"},100);
        $("#filter-search-button").animate({
            width: "0px",
            opacity: 0
        },100,function(){
            $(this).hide(0);
        });
    }
    
    $(document).mouseup(function(e) {
        if (!$("#search-wrapper").is(e.target) && $("#search-wrapper").has(e.target).length === 0) {
            searchBoxFocusOut();
        }
    });

    $("#filter-search-button").click(function(e){
        if ($("#filter-window").css("display") == "none") {
            $("#filter-window").css({"width": ""});

            $("div.search-bar").css({"border-bottom-left-radius": "0px",
                                     "border-bottom-right-radius": "0px"});
            $("#filter-window").slideDown(200);
    		$("div.search-bar").delay(50).queue(function(next) {
                $(this).css({"box-shadow": "5px 11px 5px -5px, 8px -3px 5px -9px"});
                next();
            });
        }
        else {
            hideFilterWindow();
        }
    });

    /*
    var login_timeout;
    $(".profile-pic").hover(
        function() {
            $(".login-popup").css({"transform": "scale(1)"});
        }, function() {
            login_timeout = setTimeout(function() {
                $(".login-popup").css({"transform": ""});
            },300);
        }
    );
    */

    $("#search-button-mobile").click(function() {
        $("#navbar-left-div").hide(0)
        $("#navbar-right-div").hide(0);
        $("#search-wrapper").css({"width": "80vw"});
        $("div.search-bar").css({"display": "flex"}).hide(0).fadeIn(200);
        $("div.search-mobile").hide(0);
        $("div.search-bar").mouseenter();
        $("input.search-field").focus();
	    $("#search-btn-wrapper").css({"padding-left": "12px",
		                              "padding-right": "12px"});
        $("#search-close-mobile").css({"display": "flex"}).hide(0).fadeIn(200);
    });

    $("#search-close-mobile").click(function() {
        $(this).queue(function(next){
            searchBoxFocusOut();
            next();
        }).delay(200).queue(function(next){
            $("#search-wrapper").animate({"width": "30vw"},100);
            $("div.search-bar").fadeOut(100);
            $("#search-close-mobile").hide(0);
            next();
        }).delay(200).queue(function(next){
            $("#navbar-left-div").fadeIn();
            $("#navbar-right-div").fadeIn();
            $("div.search-mobile").fadeIn();
            $("#search-btn-wrapper").css({"padding-left": "",
                                          "padding-right": ""});
            next();
        });
    });

    // -- CAROUSEL --
    $(".carousel").owlCarousel({
        margin: 50,
        loop: true,
        autoplay: true,
        autoplayTimeout: 6000,
        smartSpeed: 6000,
        slideTransition: 'linear',
        autoplayHoverPause: false,
        mouseDrag: false,
        center: true,
        responsive: {

            0:{
                items:1,
                nav: false
            },

            600:{
                items:2,
                nav: false
            },

            800:{
                items:3,
                nav: false
            },

            1000:{
                items:4,
                nav: false
            },

            1200:{
                items:5,
                nav: false
            }
        }
    });

    $(".carousel").trigger('next.owl'); // Avoids the first 6s waiting time
    
    // -- END CAROUSEL --
});

/*const carousel = document.querySelector(".carousel owl-carousel");

let intervalo = null;

const start = () => {
    intervalo = setInterval(function(){
        carousel.scrollLeft = carousel.scrollLeft + 5;
    },10)
};

const stop = () => {

};

start();*/





