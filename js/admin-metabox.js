"use strict";

jQuery( document ).ready( function($) {

	/*
	 * POST
	 * Gallery Metabox */
	if( ! $("input#post-format-gallery").is(':checked') ){
		$( "#thst_featured_gallery" ).hide();
	}

    $( "input[name=post_format]#post-format-gallery" ).change( function() {
		$( "#thst_featured_gallery" ).fadeIn();
    } );

    $( "input[name=post_format]:not(#post-format-gallery)" ).change( function() {
		$( "#thst_featured_gallery" ).fadeOut();
    } );

    /* PAGE
     * Page Template */
    var selected_template = $("select#page_template option:selected").val();


	if( $("body").hasClass("post-php") && $("body").hasClass("post-type-page")){
		let templates = ["page/page-podcastarchive-list.php", "page/page-podcastarchive-grid.php", "page/page-podcastarchive-list-classic.php", "page/page-podcastarchive-grid-classic.php"];

		if( templates.includes(selected_template) === false ) {
			$( "#thst_podcast_archive" ).hide();
		}
	}

	if( selected_template != "page/page-gutenberg.php" ){
		$( ".cmb2-id-cmb-thst-page-padding-top" ).hide();
		$( ".cmb2-id-cmb-thst-page-padding-bottom" ).hide();
	} 

	$("select#page_template").on('change', function() {
		if( $(this).val() == 'page/page-podcastarchive-list.php' || $(this).val() == 'page/page-podcastarchive-grid.php' || $(this).val() == 'page/page-podcastarchive-list-classic.php' || $(this).val() == 'page/page-podcastarchive-grid-classic.php' ) {
			$( "#thst_podcast_archive" ).fadeIn();
	    } else {
	    	$( "#thst_podcast_archive" ).fadeOut();
	    }


	    if( $(this).val() == 'page/page-gutenberg.php' ) {
			$( ".cmb2-id-cmb-thst-page-padding-top" ).fadeIn();
			$( ".cmb2-id-cmb-thst-page-padding-bottom" ).fadeIn();
	    } else {
	    	$( ".cmb2-id-cmb-thst-page-padding-top" ).fadeOut();
			$( ".cmb2-id-cmb-thst-page-padding-bottom" ).fadeOut();
	    }

	});

});