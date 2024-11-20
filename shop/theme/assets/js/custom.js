// Back to top button

$(document).ready(function(){
	$(".back-top").hide();
	
	$(() => {
		$(window).scroll(() => {
			if ($(this).scrollTop() > 150) {
				$('.back-top').fadeIn();
			} else {
				$('.back-top').fadeOut();
			}
		});
		$('.back-top').click(() => {
			$('body,html').animate({
				scrollTop: 0
			}, 1000);
			return false;
		});
	});
});

// Initialize owl-carousel
$(document).ready(() => {
  $(".owl-carousel").owlCarousel({
    nav: true,
    items: 1
  });
});
