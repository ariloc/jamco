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

    function hideFilterWindow(delay = true) {
        $("#filter-window").slideUp(delay ? 200 : 0, function() {
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

    /* even though we have css for this, the way we reuse the desktop search bar
       may lead into a situation where the search bar isn't visible anymore after
       resizing the viewport (i.e. the window of your browser in a desktop) */
    $(window).on('resize', function() {
        if ($(this).width() > 600) {
            $("#search-close-mobile").hide(0);
            $("div.search-bar").css("display", "flex");
            $("#navbar-left-div").show(0);
            $("#navbar-right-div").show(0);
            $("#search-wrapper").css("width","");
        }
        else {
            if ($("#search-close-mobile").css('display') == 'none') {
                hideFilterWindow(false);
                $("div.search-bar").hide(0);
                $("div.search-mobile").show(0);
                $("#navbar-left-div").show(0);
                $("#navbar-right-div").show(0);
            }
        }
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
});
