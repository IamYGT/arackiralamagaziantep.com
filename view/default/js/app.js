wow = new WOW(
	{
		animateClass: 'animated',
	}
	);

	wow.init();


jQuery(document).ready(function ($) {
	$('#owl-slider').owlCarousel({
		loop: true,
		margin: 0,
		nav: false,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		dots: true,
		autoplay:true,
        autoplayTimeout:3000,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});

});

jQuery(document).ready(function ($) {
	$('#owl-araclar').owlCarousel({
		loop: true,
		margin: 30,
		nav: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		dots: true,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 4
			}
		}
	});

});



jQuery(document).ready(function ($) {
	$('#owl-neler').owlCarousel({
		loop: true,
		margin: 30,
		nav: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		dots: true,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 4
			}
		}
	});

});


jQuery(document).ready(function ($) {
	$('#owl-markalar').owlCarousel({
		loop: true,
		margin: 30,
		nav: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		dots: false,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 5
			}
		}
	});

});