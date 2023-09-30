"use strict";

(function($) {
	$(window).load(function() {

		/* Post format on load */
		var selected_p_format = $(".editor-post-format select.components-select-control__input").val();

		/* Editing of a new post. */
		if( $("body").hasClass("post-new-php") && $("body").hasClass("post-type-post")){
			if( selected_p_format != "audio" ) {
				$("#thst_featured_audio").addClass('is-hidden');
			}
			if( selected_p_format != "video" ) {
				$("#thst_featured_video").addClass('is-hidden');
			}
		}


		/* Editing of an old post. */
		if( $("body").hasClass("post-php") && $("body").hasClass("post-type-post")){
			if( selected_p_format == "audio" ) {	
				$("#thst_featured_audio").removeClass('is-hidden');
				$("#thst_featured_video").addClass('is-hidden');
				$("#thst_featured_gallery").addClass('is-hidden');
			} else if( selected_p_format == "video" ) {
				$("#thst_featured_audio").addClass('is-hidden');
				$("#thst_featured_video").removeClass('is-hidden');
				$("#thst_featured_gallery").addClass('is-hidden');
			}
		}


		/* Changes when a specific post format is selected. */
		$("#wpbody").on("change", ".editor-post-format select.components-select-control__input", function() {
			var $current_val = $(this).val();

			if( $current_val == "audio" ) {
				$( "#thst_featured_audio" ).removeClass('is-hidden');
			} else {
				$( "#thst_featured_audio" ).addClass('is-hidden');
			}

			if( $current_val == "video" ) {
				$( "#thst_featured_video" ).removeClass('is-hidden');
			} else {
				$( "#thst_featured_video" ).addClass('is-hidden');
			}

		});


		/* Audio
		-------------------------------------------*/
		// Audio URL
		if( ! $("input#cmb_thst_audio_type1").is(':checked') ){
			$( ".cmb2-id-cmb-thst-audio-url" ).hide();
		}
	    $( "input[name=cmb_thst_audio_type]#cmb_thst_audio_type1" ).change( function() {
			$( ".cmb2-id-cmb-thst-audio-url" ).fadeIn();
	    } );
	    $( "input[name=cmb_thst_audio_type]:not(#cmb_thst_audio_type1)" ).change( function() {
			$( ".cmb2-id-cmb-thst-audio-url" ).fadeOut();
	    } );

		// Audio Embed (URL)
		if( ! $("input#cmb_thst_audio_type2").is(':checked') ){
			$( ".cmb2-id-cmb-thst-audio-embed" ).hide();
		}
	    $( "input[name=cmb_thst_audio_type]#cmb_thst_audio_type2" ).change( function() {
			$( ".cmb2-id-cmb-thst-audio-embed" ).fadeIn();
	    } );
	    $( "input[name=cmb_thst_audio_type]:not(#cmb_thst_audio_type2)" ).change( function() {
			$( ".cmb2-id-cmb-thst-audio-embed" ).fadeOut();
	    } );

		// Audio Embed (Code)
		if( ! $("input#cmb_thst_audio_type3").is(':checked') ){
			$( ".cmb2-id-cmb-thst-audio-embed-code" ).hide();
		}
	    $( "input[name=cmb_thst_audio_type]#cmb_thst_audio_type3" ).change( function() {
			$( ".cmb2-id-cmb-thst-audio-embed-code" ).fadeIn();
	    } );
	    $( "input[name=cmb_thst_audio_type]:not(#cmb_thst_audio_type3)" ).change( function() {
			$( ".cmb2-id-cmb-thst-audio-embed-code" ).fadeOut();
	    } );

		// Audio Embed (Playlist)
		if( ! $("input#cmb_thst_audio_type4").is(':checked') ){
			$( ".cmb2-id-cmb-thst-audio-playlist" ).hide();
		}
	    $( "input[name=cmb_thst_audio_type]#cmb_thst_audio_type4" ).change( function() {
			$( ".cmb2-id-cmb-thst-audio-playlist" ).fadeIn();
	    } );
	    $( "input[name=cmb_thst_audio_type]:not(#cmb_thst_audio_type4)" ).change( function() {
			$( ".cmb2-id-cmb-thst-audio-playlist" ).fadeOut();
	    } );



		/* Video 
		-------------------------------------------*/
		// Video oEmbed
		if( ! $("input#cmb_thst_video_type1").is(':checked') ){
			$( ".cmb2-id-cmb-thst-video-embed" ).hide();
		}
	    $( "input[name=cmb_thst_video_type]#cmb_thst_video_type1" ).change( function() {
			$( ".cmb2-id-cmb-thst-video-embed" ).fadeIn();
	    } );
	    $( "input[name=cmb_thst_video_type]:not(#cmb_thst_video_type1)" ).change( function() {
			$( ".cmb2-id-cmb-thst-video-embed" ).fadeOut();
	    } );

		// Video Embed (Code)
		if( ! $("input#cmb_thst_video_type2").is(':checked') ){
			$( ".cmb2-id-cmb-thst-video-embed-code" ).hide();
		}
	    $( "input[name=cmb_thst_video_type]#cmb_thst_video_type2" ).change( function() {
			$( ".cmb2-id-cmb-thst-video-embed-code" ).fadeIn();
	    } );
	    $( "input[name=cmb_thst_video_type]:not(#cmb_thst_video_type2)" ).change( function() {
			$( ".cmb2-id-cmb-thst-video-embed-code" ).fadeOut();
	    } );

		// Video (URL)
		if( ! $("input#cmb_thst_video_type3").is(':checked') ){
			$( ".cmb2-id-cmb-thst-video-url" ).hide();
		}
	    $( "input[name=cmb_thst_video_type]#cmb_thst_video_type3" ).change( function() {
			$( ".cmb2-id-cmb-thst-video-url" ).fadeIn();
	    } );
	    $( "input[name=cmb_thst_video_type]:not(#cmb_thst_video_type3)" ).change( function() {
			$( ".cmb2-id-cmb-thst-video-url" ).fadeOut();
	    } );

		// Video (Playlist)
		if( ! $("input#cmb_thst_video_type4").is(':checked') ){
			$( ".cmb2-id-cmb-thst-video-playlist" ).hide();
		}
	    $( "input[name=cmb_thst_video_type]#cmb_thst_video_type4" ).change( function() {
			$( ".cmb2-id-cmb-thst-video-playlist" ).fadeIn();
	    } );
	    $( "input[name=cmb_thst_video_type]:not(#cmb_thst_video_type4)" ).change( function() {
			$( ".cmb2-id-cmb-thst-video-playlist" ).fadeOut();
	    } );

	});
})(jQuery);