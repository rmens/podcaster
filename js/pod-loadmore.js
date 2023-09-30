"use strict";

jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error

	//var $grid = $('.front-page-grid:not(.front-page-fit-grid) .list-of-episodes .row.masonry-container');
	var $grid = $('.list-of-episodes .row.masonry-container');
	var isRTL = pod_loadmore_params.originLeft;
	var epStyle = pod_loadmore_params.fp_ep_style;
	var originLeft = (isRTL == "1" && epStyle == "front-page-grid") ? false : true;

	var body = $('body');
	var pSettings = {};
	
	if( "front-page-fit-grid" == epStyle ) {
		$grid = $('.front-page-grid.front-page-fit-grid .list-of-episodes .row.masonry-container');
	} else if( "front-page-grid" == epStyle ) {
		$grid = $('.front-page-grid:not(.front-page-fit-grid) .list-of-episodes .row.masonry-container');
	}
	

	$grid.imagesLoaded( function() {

		if( "front-page-grid" == epStyle ) {
			$grid.masonry({
				itemSelector: '.post',
				percentPosition: true,
				columnWidth: '.grid-sizer',
				gutter: '.gutter-sizer',
				horizontalOrder: true,
				originLeft: originLeft,
				stagger: 30,
				initLayout: false,
	        	visibleStyle: { transform: 'translateY(0)', opacity: 1 },
	        	hiddenStyle: { transform: 'translateY(-50px)', opacity: 0},
			});

			// bind event listener
			$grid.on('layoutComplete', function() {
				$('.front-page-grid #loading_bg').css({
					"transition-duration": '0.7s',
					"opacity": "0",
					"visibility": "hidden"
				});
				$grid.css({
					"transition-duration": '0.7s',
					"opacity": "1",
				});
			});
			// manually trigger initial layout
			$grid.masonry();
		}


		
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

						// Change Text on Button
						button.text( pod_loadmore_params.load_more_text ); // insert new posts
						
	 					// Inside the AJAX success() 
						var $items = $( data ); // data is the HTML of loaded posts
						
						

						if( "front-page-grid" == epStyle ) {
							// Hide items while they load.
							$items.css({"opacity": "0"});

							$grid.append( $items ).imagesLoaded(function(){
								
								// Apply fitVids() to the new elements.
								$(".post.format-video").fitVids();

								// Apply mediaelement to the new elements.
								if (typeof window.wp.mediaelement != "undefined") {
									$( window.wp.mediaelement.initialize );
									if( body.hasClass('vertical-audio-vol-active')){
										pSettings = {
					                        audioVolume: "vertical"
					                    }
					                }
									$('audio, video').mediaelementplayer(pSettings);
								}


								// Append to Masonry.
								$grid.masonry( 'appended', $items ).masonry( 'reloadItems' );
							});
						} else if( "front-page-fit-grid" == epStyle ) {
							// Hide items while they load.
							$items.css({"opacity": "0", "transform" : "translate3d(0,-5%,0)"});

							$grid.append( $items ).imagesLoaded(function(){
								
								// Apply fitVids() to the new elements.
								$(".post.format-video").fitVids();

								// Apply mediaelement to the new elements.
								if (typeof window.wp.mediaelement != "undefined") {
									$( window.wp.mediaelement.initialize );
									
									if( body.hasClass('vertical-audio-vol-active')){
										pSettings = {
					                        audioVolume: "vertical"
					                    }
					                }
									$('audio, video').mediaelementplayer(pSettings);
								}

								$items.css({
									"transition-duration": '0.7s',
									"opacity": "1",
									"transform" : "translate3d(0,0%,0)"
								});

							});
						} else {
							// Hide items while they load.
							$items.css({"opacity": "0", "transform" : "translate3d(0,-5%,0)"});

							$grid.append( $items ).imagesLoaded(function(){
								
								// Apply fitVids() to the new elements.
								$(".post.format-video").fitVids();

								// Apply mediaelement to the new elements.
								if (typeof window.wp.mediaelement != "undefined") {
									$( window.wp.mediaelement.initialize );
									
									if( body.hasClass('vertical-audio-vol-active')){
										pSettings = {
					                        audioVolume: "vertical"
					                    }
					                }
									$('audio, video').mediaelementplayer(pSettings);
								}

								// Fade items in
								$items.css({
									"transition-duration": '0.7s',
									"opacity": "1",
									"transform" : "translate3d(0,0%,0)"
								});
							});
						}

						// Increase page count
						pod_loadmore_params.current_page++;

						
						if ( pod_loadmore_params.current_page == pod_loadmore_params.max_page ) {
							// Things to be done on the last page come here.
						}

						// you can also fire the "post-load" event here if you use a plugin that requires it
						// $( document.body ).trigger( 'post-load' );
					} else {
						button.remove(); // if no data, remove the button as well
						
						if( pod_loadmore_params.loaded_text ){
							$( "<p class='loaded-text'>" + pod_loadmore_params.loaded_text + "</p>" ).insertAfter( $grid ).delay(1000).fadeOut( 1000, function(){
						      $(this).remove();
						    });
						}
						
					}

				}
			});
		});
	});

});