"use strict";

jQuery(document).ready(function($) {
	var slideAuto = podflex.flex_auto;
	var slideStyle = podflex.flex_style;

	$('.featured-podcast.slide .flexslider').flexslider({
		animation: "slide",
		easing: "swing",  
		smoothHeight: true,
		slideshow: false,
		controlNav: true,
		directionNav: false,

	});
	jQuery('.post .flexslider').flexslider({
		animation: 'slide',
		slideshow: false,
		controlNav: false,
		directionNav: true, 
		slideshowSpeed: 7000,
		animationSpeed: 1000,
		touch: true,
		smoothHeight: true, 
		start: function(slider) {
			slider.removeClass('loading_post');
		}
	});
	
	var featured_header = jQuery('.front-page-header.slideshow.flexslider');
	featured_header.flexslider({
		slideshow: slideAuto,
		selector: ".slides > .slide",
		animation: slideStyle,
		controlNav: true,
		directionNav: true, 
		slideshowSpeed: 5000,
		animationSpeed: 1000,
		touch: true,
		smoothHeight: true,
		start: function(slider) {
			featured_header.removeClass('loading_featured');
			featured_header.prev().addClass('hide_bg');
		}
	});
	jQuery('.single .flexslider, .sidebar .widget_media_gallery .flexslider ').flexslider({
		animation: 'slide',
		slideshow: false,
		controlNav: false,
		directionNav: true, 
		slideshowSpeed: 7000,
		animationSpeed: 1000,
		itemWidth: 600,
		move: 1,
		touch: true,
		smoothHeight: true, 
		start: function(slider) {
			slider.removeClass('loading_post');
		}
	});
	
	/*Flexslider for the large Slideshow Block*/	
	jQuery('.headlines_l_slider.flexslider').flexslider({
		animation: 'slide',
		controlNav: false,
		directionNav: true,
		smoothHeight: false,
		slideshowSpeed: 5000,
		animationSpeed: 1000,
		touch: true,
	});
});