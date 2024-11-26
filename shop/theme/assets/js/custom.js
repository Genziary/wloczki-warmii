// Back to top button

$(document).ready(function () {
  $(".back-top").hide();

  $(() => {
    $(window).scroll(() => {
      if ($(this).scrollTop() > 150) {
        $(".back-top").fadeIn();
      } else {
        $(".back-top").fadeOut();
      }
    });
    $(".back-top").click(() => {
      $("body,html").animate(
        {
          scrollTop: 0,
        },
        1000,
      );
      return false;
    });
  });
});

// Initialize owl-carousel
$(document).ready(() => {
  $(".logo-slider").owlCarousel({
    autoPlay: false,
    smartSpeed: 1000,
    autoplayHoverPause: true,
    nav: true,
    dots: false,
    responsive: {
      0: {
        items: 1,
      },
      480: {
        items: 2,
      },
      768: {
        items: 3,
        nav: false,
      },
      992: {
        items: 4,
      },
      1200: {
        items: 5,
      },
    },
  });
});

$(document).ready(function(){
    $('#home-page-tabs li:first, #index .tab-content .tab-pane:first').addClass('active in');
    
    $('.thumb-container .thumb').click(function(){
    	let zdjecie=$(this).attr('data-image-medium-src');
    	$('.js-qv-product-cover').attr('src',zdjecie);
    	$('.thumb-container .thumb').removeClass('selected');
    	$(this).addClass('selected');
    	
    });
    
    $('.tabs .nav-tabs .nav-item:nth-child(1) .nav-link').trigger('click');
});
