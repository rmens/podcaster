"use strict";

jQuery( document ).ready( function($) {

	/* Audio Metabox */
	if( ! $("input#post-format-audio").is(':checked') ){
		$( "#thst_featured_audio" ).hide();
	}
    $( "input[name=post_format]#post-format-audio" ).change( function() {
		$( "#thst_featured_audio" ).fadeIn();
    } );


    /* Video Metabox */
    $( "input[name=post_format]:not(#post-format-audio)" ).change( function() {
		$( "#thst_featured_audio" ).fadeOut();
    } );
	if( ! $("input#post-format-video").is(':checked') ){
		$( "#thst_featured_video" ).hide();
	}
    $( "input[name=post_format]#post-format-video" ).change( function() {
		$( "#thst_featured_video" ).fadeIn();
    } );
    $( "input[name=post_format]:not(#post-format-video)" ).change( function() {
		$( "#thst_featured_video" ).fadeOut();
    } );


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