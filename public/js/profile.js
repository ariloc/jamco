$(document).ready(function() {
    $('.profile-songs').slick({
        dots: true,
        infinite: true,
        arrows: true,
        speed: 300,
        slidesToScroll: 1,
        slidesToShow: 5,
        responsive: [
            {
              breakpoint: 1100,
              settings: {
                slidesToShow: 5,
                slidesToScroll: 2,
                infinite: true,
                dots: true
              }
            },
            {
                breakpoint: 900,
                settings: {
                  slidesToShow: 4,
                  slidesToScroll: 1,
                  infinite: true,
                  dots: true
                }
              },
            {
              breakpoint: 700,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 520,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
    });

    initial_left = $('.tab-indicator').css("left");
    secciones = $('.secciones');
    active_tab = secciones.children('.active');
    inactive_tabs = secciones.children('.inactive');

    $('.tabs > div').each(function(i) {
        $(this).click(function() {
            $('.tab-indicator').css("left", `calc(calc(calc(100% / 3) * ${i}) + ${initial_left})`);

            active_tab.empty();
            var selected = inactive_tabs.children().eq(i);
            var copy = selected.clone().appendTo(active_tab);

            copy.animate({opacity: 1}, {duration: 300, queue: false});
            $({y:-10}).animate({y:0}, {
                duration: 300,
                step: function(val) {
                    copy.css("transform", `translateY(${val}px)`);
                },
                queue: false
            });

            secciones.animate({height: active_tab[0].scrollHeight}, {duration: 300, queue: false});
            $('html, body').animate({
                scrollTop: $(".tabs-container").offset().top - 30
            }, {duration: 400, queue: false});
        });
    });
    
    $(window).resize(function(){
        secciones.css("height", active_tab[0].scrollHeight);
    });

    // show first tab on load
    inactive_tabs.children().eq(0).clone().appendTo(active_tab);
    secciones.css({"height": active_tab[0].scrollHeight});
    active_tab.children().eq(0).css({"opacity": 1, "transform": "translateY(0px)"});
});
