(function($, document, window){
	'use strict';

	if (JSON && localStorage && localStorage.getItem('user')) {
		var user = JSON.parse(localStorage.getItem('user') || '{}');
		window.intercomSettings = {app_id: 'i0yqsxbt', name: user.name, email: user.email, created_at: user.timestamp};
	}

	$(document).ready(function() {

		/***************** Waypoints ******************/

		$('.wp1').waypoint(function() {
			$('.wp1').addClass('animated fadeInUp');
		}, {
			offset: '75%'
		});
		$('.wp2').waypoint(function() {
			$('.wp2').addClass('animated fadeInUp');
		}, {
			offset: '75%'
		});
		$('.wp3').waypoint(function() {
			$('.wp3').addClass('animated fadeInRight');
		}, {
			offset: '75%'
		});

		/***************** Initiate Fancybox ******************/

		$('.single_image').fancybox({
			padding: 4,
		});

		/***************** Tooltips ******************/
	    $('[data-toggle="tooltip"]').tooltip();

		/***************** Nav Transformicon ******************/

		/* When user clicks the Icon */
		$('.nav-toggle').click(function() {
			$(this).toggleClass('active');
			$('.header-nav').toggleClass('open');
			event.preventDefault();
		});
		/* When user clicks a link */
		$('.header-nav li a').click(function() {
			$('.nav-toggle').toggleClass('active');
			$('.header-nav').toggleClass('open');

		});

		/***************** Header BG Scroll ******************/

		$(function() {
			// Check if already scrolled on load (eg a refresh)
			$(window).load(function() {
				var scroll = this.scrollY;
				if ( scroll > 0) {
					$('section.navigation').addClass('fixed');
				}
			});
			$(window).scroll(function() {
				var scroll = $(window).scrollTop();

				if ($('section.navigation').hasClass('regular')) {
					return;
				}

				if (scroll >= 20) {
					$('section.navigation').addClass('fixed');
					$('header').css({
						"padding": "25px 0"
					});
					$('header .member-actions').css({
						"top": "26px",
					});
					$('header .navicon').css({
						"top": "34px",
					});
				} else {
					$('section.navigation').removeClass('fixed');
					$('header').css({
						"padding": "40px 0"
					});
					$('header .member-actions').css({
						"top": "41px",
					});
					$('header .navicon').css({
						"top": "48px",
					});
				}
			});
		});
		/***************** Smooth Scrolling ******************/

		$(function() {

			$('a[href*=#]:not([href=#])').click(function() {
				if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {

					var target = $(this.hash);
					target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
					if (target.length) {
						$('html,body').animate({
							scrollTop: target.offset().top
						}, 500);
						return false;
					}
				}
			});

		});

	});
	
})(jQuery, document, window);