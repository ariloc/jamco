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

/*const parentContainer = document.querySelector('profile-review-text');

parentContainer.addEventListener('click',event>={
  
  const current = event.target;

  const isReadMoreBtn = current.className.includes('read-more-btn');

  if(isReadMoreBtn) return;

  const currenttext = event.target.parentNode.querySelector('.read-more-text');
})*/