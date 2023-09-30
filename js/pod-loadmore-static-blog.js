"use strict";

jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error

	var $entries_container = $('.blog-front-page .entries-container.entries');
	var isRTL = pod_loadmore_params.originLeft;
	var epStyle = pod_loadmore_params.fp_ep_style;
	var originLeft = (isRTL == "1" && epStyle == "front-page-grid") ? false : true;



	$( '.pod_loadmore' ).on( 'click', function() {
 		
		var button = $(this);
		var data = {
			'action': 'loadmore',
			'query': pod_loadmore_params.posts, // that's how we get params from wp_localize_script() function
			'page' : pod_loadmore_params.current_page
		};
 	
		$.ajax({ // you can also use $.post here
			url : pod_loadmore_params.ajaxurl, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text( pod_loadmore_params.loading_text ); // change the button text, you can also add a preloader image
			},
			success : function( data ){

				if( data ) { 

					// Inside the AJAX success() 
					var $items = $( data ); // data is the HTML of loaded posts

					// Change Text on Button
					button.text( pod_loadmore_params.load_more_text );
					
					// Hide items while they load.
					$items.css({
						"opacity": "0", 
						"transition-duration": "0.7s", 
						"transform": "translateY(-50px)"
					});
					
					// Add the new posts
					button.before($items).imagesLoaded(function(){
						// Reload jS
						$(".post.format-video").fitVids();
						
						if (typeof window.wp.mediaelement != "undefined") {
							$( window.wp.mediaelement.initialize );
							$('audio, video').mediaelementplayer();
						}	


						// Reload Flexslider
						jQuery('.blog-front-page .entries .post .flexslider').flexslider({
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
					});

					// Fade in the items after they load.
					$items.css({
						"opacity": "1", 
						"transition-duration": "0.7s", 
						"transform": "translateY(0)"
					});					
					

					// Increase page count
					pod_loadmore_params.current_page++;

					// If last page, remove the button
					if ( pod_loadmore_params.current_page == pod_loadmore_params.max_page ) {
						//button.remove(); 

						/*if( pod_loadmore_params.loaded_text ){
							$( "<p class='loaded-text'>" + pod_loadmore_params.loaded_text + "</p>" ).insertAfter( $grid ).delay(1000).fadeOut( 1000, function(){
						      $(this).remove();
						    });;
						}*/
					}

					// you can also fire the "post-load" event here if you use a plugin that requires it
					// $( document.body ).trigger( 'post-load' );
				} else {
					button.remove(); // if no data, remove the button as well
					
					if( pod_loadmore_params.loaded_text ){
						$( "<p class='loaded-text'>" + pod_loadmore_params.loaded_text + "</p>" ).insertAfter( $entries_container ).delay(1000).fadeOut( 1000, function(){
					      $(this).remove();
					    });
					}
					
				}

			}
		});
	});

});