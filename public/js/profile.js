$(document).ready(function() {
    $('.profile-songs').slick({
        dots: true,
        infinite: true,
        arrows: true,
        speed: 300,
        autoplay: true,
        autoplaySpeed: 2500,
        prevArrow: '<button type="button" class="slick-arrow slick-prev fa-solid fa-chevron-left"></button>',
        nextArrow: '<button type="button" class="slick-arrow slick-next fa-solid fa-chevron-right"></button>',
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
            $('.tab-indicator').css("left", `calc(calc(calc(100% / var(--tab-count)) * ${i}) + ${initial_left})`);

            secciones.height(active_tab[0].scrollHeight);
            active_tab.empty();
            var selected = inactive_tabs.children().eq(i);
            var copy = selected.clone(true, true).appendTo(active_tab);

            copy.animate({opacity: 1}, {duration: 300, queue: false});
            $({y:-10}).animate({y:0}, {
                duration: 300,
                step: function(val) {
                    copy.css("transform", `translateY(${val}px)`);
                },
                queue: false
            });

            secciones.css({height: active_tab[0].scrollHeight});
            secciones.on('transitionend', function() {
                $(this).css("height", "");
            });
            $('html, body').animate({
                scrollTop: $(".tabs-container").offset().top - 30
            }, {duration: 400, queue: false});

            refresh_reviews_dropdown_visibility();
        });
    });
    
    function review_shave_update (quote, cnt) {
        var max_height = parseInt(quote.css("max-height").replace(/[^0-9.]/g, "")) * cnt;
        quote.find('.review-quote-body').shave(max_height);
        quote.find('.review-quote-title').shave(max_height);
    }

    function getReviewLines() {
        return $('body').css('--review-lines');
    }

    function refresh_reviews_dropdown_visibility() {
        // shrink back cards
        $('.read-more-btn > i.expanded').each(function() {
            $(this).click();
        });

        // disable expand for short reviews
        $('.profile-review-card').each(function() {
            var container = $(this).find('.text-container');
            if (container.length)
                review_shave_update(container, container.is('.expanded') ? getReviewLines() : 1);
            
            var btn = $(this).find('.read-more-btn');
            if ($(this).find('.js-shave-char').length > 0)
                btn.css("visibility", "visible");
            else
                btn.css("visibility", "hidden");
        });
    }
    
    $(window).resize(function(){
        refresh_reviews_dropdown_visibility();
    });

    // show first tab on load
    inactive_tabs.children().eq(0).clone().appendTo(active_tab);
    active_tab.children().eq(0).css({"opacity": 1, "transform": "translateY(0px)"});
    refresh_reviews_dropdown_visibility();


    $('.read-more-btn > i').click(function() {
        var respective_quote = $(this).closest('.profile-review-text').find('.text-container .review-quote');
        var quote_container = respective_quote.closest('.text-container');
        var my_card = $(this).closest('.profile-review-card-wrapper');

        $('.read-more-btn > i.expanded').not($(this)).each(function() {
            $(this).click();
        });
        if (quote_container.hasClass('expanded')) {
            quote_container.removeClass('expanded');
            quote_container.one('transitionend', function() {
                review_shave_update(quote_container, 1);
            });
        }
        else {
            quote_container.addClass('expanded');
            review_shave_update(quote_container, getReviewLines());

            // preferably scroll on expand only
            my_card[0].scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
        }
        $(this).toggleClass('expanded');

    });

    $(document).mouseup(function(e) { // dismiss reviews when clicking away
        $('.read-more-btn > i.expanded').each(function() {
            var my_card = $(e.target).closest(".profile-review-card-wrapper");
            if (my_card.length === 0 || !$(this).closest('.profile-review-card-wrapper').is(my_card)) { 
                $(this).click();
            }
        });
    });

    function modal_show (modal) {
        modal.show(0);
        modal.find('.modal-dialog-wrapper').addClass("visible");
        modal.find('.modal-dialog').addClass("visible");
    }

    function modal_hide (modal) {
        var wrapper = modal.find('.modal-dialog-wrapper');
        wrapper.removeClass('visible');
        modal.find('.modal-dialog').removeClass("visible");
        wrapper.one('transitionend', function() {
            modal.hide(0);
        });
    }
    
    $('.profile-header .profile-pic .edit-btn').click(function() {
        modal_show($('#profile-pic-upload-modal'));
    });

    $('.modal-close span').click(function() {
        var parent_modal = $(this).closest('.modal');
        modal_hide(parent_modal);
    });

    // Hide modal when clicking outside of window or pressing Esc button
    $(document).mouseup(function(e) {
        if ($('.modal').is(e.target) || $('.modal-dialog-wrapper').is(e.target))
            modal_hide($('.modal'));
    });
    $(document).keyup(function(e){
        if (e.key === "Escape")
            modal_hide($('.modal'));
    });
});
