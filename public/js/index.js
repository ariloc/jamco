$(document).ready(function(){
    // -- NEW CAROUSEL --
    var carousel_items = 5;
    $(".carousel-card").clone().appendTo($('.main-carousel-cards')); // duplicate the elements so it seems infinite
    
    var carousel = $('.main-carousel-cards'),
    carousel_card = $('.main-carousel-cards .carousel-card'),
    carousel_links = $('.main-carousel a'),
    threshold = 150,
    slideWidth = 300,
    slideDuration = 6000,
    dragStart, 
    dragEnd;

    function refreshCarouselViewport() { // from 1 to 5 items depending on the width of the viewport
        carousel_items = 1 + ($(this).width() > 600) +
                             ($(this).width() > 800) +
                             ($(this).width() > 1000) +
                             ($(this).width() > 1200);

        var carousel_card_width = (carousel.width() / carousel_items);
        carousel_card.css("min-width", carousel_card_width + "px");
        slideWidth = carousel_card_width;
        carousel.css("left", "-" + ((carousel[0].scrollWidth / 2) - (carousel.width() / 2) + slideWidth / 2) + "px");
    }

    $(window).on('resize', function() {
        refreshCarouselViewport(); // when the viewport is resized
    });

    function getTranslateX (e) {
        return parseFloat(e.css("transform").split(',')[4]);
    }

    function dragMainCarousel() {
        var current_drag = getTranslateX(carousel);
        var duration = Math.abs((slideDuration / slideWidth) * ((-slideWidth) - current_drag));

        carousel.animate({now: "--"}, {
            duration: duration,
            easing: 'linear',
            step: function(now, fn) {
                fn.start = current_drag;
                fn.end = -slideWidth;
                $(this).css("transform", "translateX(" + now + "px)");
            },
            done: function(){
                $('.main-carousel .carousel-card:last').after($('.main-carousel .carousel-card:first'));
                $(this).css("transform", "translateX(0px)");
                dragMainCarousel();
            }
        });
    }

    refreshCarouselViewport(); // when the page loads
    dragMainCarousel();

    var carousel_hover_timeout, carousel_blur_timeout, restart_carousel_timeout;
    var hover_carousel = false, dragging_carousel = false, carousel_stopped = false;
    function restartCarouselAnimation() {
        clearTimeout(restart_carousel_timeout);
        restart_carousel_timeout = setTimeout(function() {
            if (!hover_carousel && !dragging_carousel && carousel_stopped){
                carousel_stopped = false;
                dragMainCarousel();
            }
        },1000);
    }

    var carousel_all = $(".main-carousel *");
    carousel_all.on('mouseenter touchstart', function() {
        hover_carousel = true;
        clearTimeout(carousel_hover_timeout);
        clearTimeout(carousel_blur_timeout);
        carousel_hover_timeout = setTimeout(function(){                
            carousel.stop(true);
            carousel_stopped = true;
            restartCarouselAnimation();
        },300);
    });

    carousel_all.on('mouseleave touchend touchcancel', function() {
        hover_carousel = false;
        clearTimeout(carousel_hover_timeout);
        clearTimeout(carousel_blur_timeout);
        restartCarouselAnimation();
    });

    function getTouchX(e) {
        var evt = (typeof e.originalEvent === 'undefined') ? e : e.originalEvent;
        var touch = evt.touches[0] || evt.changedTouches[0];
        return touch.pageX;
    }

    carousel.on('mousedown touchstart', function(e){
        if (e.type == 'mousedown') e.preventDefault();
        $(this).css("cursor","grabbing");
        dragging_carousel = true;

        if (carousel.hasClass('transition')) return;
        carousel.stop(true);
        carousel_stopped = true;
        dragStart = (e.type == 'mousedown' ? event.pageX : getTouchX(e)) - getTranslateX(carousel);

        var movement_detected = false;
        $(this).on('mousemove touchmove', function(e){
            dragEnd = (e.type == 'mousemove' ? event.pageX : getTouchX(e));
            $(this).css('transform','translateX('+ dragPos() +'px)');
            carousel_links.css("cursor","grabbing");
            movement_detected = true;
        })

        /* Using namespace "main-carousel" for mouseup event in $(document),
           because removing the event handler with .off() disabled another
           listener that was used for the navbar. */
        $(document).on('mouseup.main-carousel touchend.main-carousel', function() {
            carousel.css("cursor", "");
            carousel_links.css("cursor","");
            $(document).off('.main-carousel');
            carousel.off('mousemove touchmove');
            dragging_carousel = false;
            carousel.mouseleave();

            if (!movement_detected) return;

            setTimeout(function(){movement_detected = false;}, 200);

            var cards_passed = parseInt(dragPos() / slideWidth);
            var offset_to_last = dragPos() - cards_passed * slideWidth;
            if (offset_to_last > threshold) { cards_passed++; }
            if (offset_to_last < -threshold) { cards_passed--; }
            shiftSlide(cards_passed);
        });

        
        carousel_links.on('click', function(e) {
            if(movement_detected) {
                e.preventDefault();
            }
            else {
                /* avoid carousel getting stuck after clicking in a link
                   and going back */
                carousel.mouseleave();
            }
        });
    });

    function dragPos() {
        return dragEnd - dragStart;
    }

    function shiftSlide(direction) {
        if (carousel.hasClass('transition')) return;
        dragEnd = dragStart;
        carousel.addClass('transition')
                .css('transform','translateX(' + (direction * slideWidth) + 'px)'); 
        setTimeout(function(){
            while (direction > 0) {
                $('.main-carousel .carousel-card:first').before($('.main-carousel .carousel-card:last'));
                direction--;
            }
            while(direction < 0) {
                $('.main-carousel .carousel-card:last').after($('.main-carousel .carousel-card:first'));
                direction++;
            }
            carousel.removeClass('transition')
            carousel.css('transform','translateX(0px)'); 
        },200);
    }
});
