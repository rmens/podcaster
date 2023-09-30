"use strict";


jQuery(document).ready(function($) {
	
	$(window).on("load, resize", function() {
	    var viewportWidth = $(window).width();

	    // Add CSS class ".responsive-menu-active" once the menu is actually active
	    if (viewportWidth < 992) {
	    	$('#nav').removeClass('responsive-menu-inactive');
	        $('#nav').addClass('responsive-menu-active');
	    } else {
	    	$('#nav').addClass('responsive-menu-inactive');
	    	$('#nav').removeClass('responsive-menu-active');
	    }
	
	}).resize();

	if ( $('#nav').hasClass('drop') ) {

		let $opener = $('.open-menu');

		$opener.on('click', function() {
			if( $opener.hasClass('menu-is-open') ){

				$('#nav.drop').stop().slideUp(500);
				$(this).removeClass("menu-is-open");

			} else {

				$('#nav.drop').stop().height('auto').slideDown(500);
				$(this).addClass("menu-is-open");
				
			}
		});

	} else {
		/* Toggle Menu */
		var windowWidth = jQuery(window).width();
		
		$('.above').on('click','.open-menu', function() {
			if ( $('#nav').hasClass('open') ) {
				$('#nav').removeClass('open');
			} else {
				$('#nav').addClass('open');
			}
		});
		
		if(windowWidth < 1025){
			
			$('#nav.toggle .menu-item-has-children > a').addClass('menu-trigger');

			$('#nav.toggle').on('click', '.menu-item-has-children > a.menu-trigger', function(event) {
				event.preventDefault();
				if ( $(this).next('ul').hasClass('open') ) {
					$(this).removeClass('active');
					$(this).next('.sub-menu').removeClass('open');
				} else {
					$(this).closest('ul').find('.active').removeClass('active');
					$(this).next('.sub-menu').addClass('open');
					$(this).addClass('active');
				}
			});
		}
	}


	$('.above .nav-search-form').on('click','.open-search-bar', function(event) {
		event.preventDefault();
		if ( $('.search-form-drop').hasClass('open') ) {
			$('.search-form-drop').removeClass('open');
		} else {
			$('.search-form-drop').addClass('open');
		}
	});


	/* Loading Header */
    jQuery('#loading_bg').addClass("hide_bg");


	/* Add class for lightbox 2 and galleries */
	jQuery(".gallery-item .image_cont a").attr('data-lightbox', 'lightbox');


	/* Resize Navigation Bar */
	jQuery(document).on("scroll",function() {
		var windowWidth = jQuery(window).width();
		if( windowWidth > 1024){
			if(jQuery(document).scrollTop() > 0){ 
				jQuery(".above.large_nav").removeClass("large_nav").addClass("small_nav");
				jQuery(".nav-placeholder.large_nav").addClass("show");
			} else {
				jQuery(".above.small_nav").removeClass("small_nav").addClass("large_nav");
				jQuery(".nav-placeholder.large_nav").removeClass("show");
			}
		}
	});


	/* Gutenberg Template Full width scrollbar */
	var scrollBarWidth = window.innerWidth - document.body.clientWidth;
	$(".template-gutenberg .entry-content .alignfull").css({ 'margin-right' : 'calc( (-100vw / 2 + 100% / 2) - ' + scrollBarWidth + 'px)' });



	// Does the browser actually support the video element?
	var supportsVideo = !!document.createElement('video').canPlayType;

	if (supportsVideo) {

		// Video background
		var videoContainer = document.getElementById('videoContainer');
		var video = document.getElementById('videobg');
		var videoControls = document.getElementById('video-controls');
		var playButton = document.getElementById('playpause');
		
		if( video !== null ) {
			// Check if autoplay is active
			if( playButton !== null && videoControls !== null ) {
				if(!video.paused && video.hasAttribute("autoplay")) {
					playButton.setAttribute('data-state', 'pause');
					videoControls.setAttribute('data-state-button', 'button-pause');
				}
			

				// Display the user defined video controls
				videoControls.setAttribute('data-state', 'visible');
				

				var changeButtonState = function(type) {
				   // Play/Pause button
				   if (type == 'playpause') {
				      if (video.paused || video.ended) {
				        playpause.setAttribute('data-state', 'play');
				        videoControls.setAttribute('data-state-button', 'button-play');
				      }
				      else {
				        playpause.setAttribute('data-state', 'pause');
				        videoControls.setAttribute('data-state-button', 'button-pause');
				      }
				   }
				}

			
				video.addEventListener('play', function() {
				   changeButtonState('playpause');
				}, false);
				video.addEventListener('pause', function() {
				   changeButtonState('playpause');
				}, false);

				playpause.addEventListener('click', function(e) {
				   if (video.paused || video.ended) {
				   	video.play();
				   } else {
				   	video.pause();
				   }
				});
			}
		}
	}
});