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
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2
                }
            }
        ],
    });
});

$(document).ready(function() {
    $('ul.tabs li a:first').addClass('active');
    $('.secciones article').hide();
	$('.secciones article:first').show();

    $('ul.tabs li a').click(function(){
    	$('ul.tabs li a').removeClass('active');
    	$(this).addClass('active');
    	$('.secciones article').hide();

    	var activeTab = $(this).attr('href');
    	$(activeTab).show();
    	return false;
    });
});