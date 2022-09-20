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
        wrapper.on('transitionend', function(e) {
            if (!$(e.target).is(this)) return;
            modal.hide(0);
            modal.find('.modal-content').empty();
            $(this).off('transitionend');
        });
    }
    
    $('.profile-header .profile-pic .edit-btn').click(function() {
        $('#profile-pic-upload-modal').children().clone(true, true).appendTo('.modal-content');
        modal_show($('.modal'));
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

    
    $('.profile-upload-btn-row.main-buttons .delete').click(function() {
        if ($(this).closest('.icon-btn').length == 0) {
            $(this).closest('.wrapper').addClass('icon-btn');

            var row_container = $(this).closest('.profile-upload-btn-row.main-buttons');
            row_container.find('.delete-pic-alert').addClass('icon-btn');

            var upload_btn = row_container.find('.upload');
            upload_btn.css("opacity", "0");
            upload_btn.on('transitionend', function() {
                if ($(this).css('opacity') == "0") {
                    $(this).css('visibility', 'hidden');
                    $(this).off('transitionend');
                }
            });
            row_container.find('.cancel-delete').show(0);
        }
        else {
            var btn_icon = $(this).find('i');
            btn_icon.removeClass();
            btn_icon.addClass("fa-solid fa-cog fa-spin");
            $.ajax({
                method: "POST",
                url: 'entrypoint',
                data: 'q=delete_profile_pic',
                success: function(data, textStatus, xhr) {
                    location.reload();
                }
            });
        }
    });


    $('.profile-upload-btn-row.main-buttons .cancel-delete').click(function() {
        $(this).closest('.wrapper').removeClass('icon-btn');

        var row_container = $(this).closest('.profile-upload-btn-row.main-buttons');
        row_container.find('.delete-pic-alert').removeClass('icon-btn');
        row_container.find('.upload').css({"visibility": "visible", "opacity": "1"});
        $(this).on('transitionend', function() {
            if ($(this).css("width") == "0") {
                $(this).hide(0);
                $(this).off('transitionend');
            }
        });
    });

    $('.profile-upload-btn-row.main-buttons .upload').click(function() {
        $(this).closest('.profile-upload-btn-row.main-buttons').find('.profile-pic-file-upload').trigger('click');
    });

    $('.profile-pic-file-upload').change(function() {
        $(this).closest('.profile-upload-btn-row.main-buttons').addClass("hidden");
        var upload_wrapper = $(this).closest('.profile-pic-modal-footer').find('.profile-upload-btn-row.upload-bar');
        upload_wrapper.removeClass("hidden");
        upload_wrapper.find(".filename p").text($('.profile-pic-file-upload')[0].files[0]['name']);
    });

    $('.profile-upload-btn-row.upload-bar .back-btn').click(function() {
        var row_container = $(this).closest('.profile-upload-btn-row.upload-bar');
        var upload_btn = row_container.find('.upload-btn');

        $(this).addClass("morph-to-upload-btn").css("left", "0").removeClass("neutral-btn").addClass("positive-btn");
        $(this).find("i").removeClass().addClass("fa-solid fa-upload");

        upload_btn.addClass("morph-to-upload-btn").css("right", "0").removeClass('positive-btn').addClass('negative-btn');
        upload_btn.find("i").removeClass().addClass("fa-solid fa-trash");

        row_container.find('.filename').fadeOut(200);

        $(this).on('transitionend', function(e) {
            if (!$(e.target).is(this)) return;
            row_container.closest('.profile-pic-modal-footer').find('.profile-upload-btn-row.main-buttons').removeClass("hidden");
            row_container.addClass("hidden");
            row_container.on('transitionend', function(ev) {
                if (!$(ev.target).is(this)) return;
                $(this).replaceWith($('#profile-pic-upload-modal').find('.profile-upload-btn-row.upload-bar').clone(true, true));
            });

            $(this).off('transitionend');
        });
    });
});
