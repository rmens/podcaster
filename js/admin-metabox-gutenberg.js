"use strict";

(function($) {
	$(window).load(function() {

		/* Post format on load */
		var selected_p_format = $(".editor-post-format select.components-select-control__input").val();

		/* Editing of a new post. */
		if( $("body").hasClass("post-new-php") && $("body").hasClass("post-type-post")){
			if( selected_p_format != "gallery" ) {
				$("#thst_featured_gallery").addClass('is-hidden');
			}
		}


		/* Editing of an old post. */
		if( $("body").hasClass("post-php") && $("body").hasClass("post-type-post")){
			if( selected_p_format == "gallery" ) {
				$("#thst_featured_audio").addClass('is-hidden');
				$("#thst_featured_video").addClass('is-hidden');
				$("#thst_featured_gallery").removeClass('is-hidden');
			}
		}


		/* Changes when a specific post format is selected. */
		$("#wpbody").on("change", ".editor-post-format select.components-select-control__input", function() {
			var $current_val = $(this).val();
			
			if( $current_val == "gallery" ) {
				$( "#thst_featured_gallery" ).removeClass('is-hidden');
			} else {
				$( "#thst_featured_gallery" ).addClass('is-hidden');
			}

		});


	    /* Page Template */
	    var selected_template = $(".editor-page-attributes__template select.components-select-control__input").val();
		if( selected_template != "page/page-podcastarchive-list.php" && selected_template != "page/page-podcastarchive-grid.php" && selected_template != 'page/page-podcastarchive-list-classic.php' && selected_template != 'page/page-podcastarchive-grid-classic.php' ){
			$("#thst_podcast_archive").addClass('is-hidden');
		} 

		if( selected_template != "page/page-gutenberg.php" ){
			$( ".cmb2-id-cmb-thst-page-padding-top" ).addClass('is-hidden');
			$( ".cmb2-id-cmb-thst-page-padding-bottom" ).addClass('is-hidden');
		} 

		$("#wpbody").on("change", ".editor-page-attributes__template select.components-select-control__input", function() {
			if( $(this).val() == 'page/page-podcastarchive-list.php' || $(this).val() == 'page/page-podcastarchive-grid.php' || $(this).val() == 'page/page-podcastarchive-list-classic.php' || $(this).val() == 'page/page-podcastarchive-grid-classic.php' ) {
				$("#thst_podcast_archive").removeClass('is-hidden');
		    } else {
		    	$("#thst_podcast_archive").addClass('is-hidden');
		    }

		    if( $(this).val() == 'page/page-gutenberg.php' ) {
				$( ".cmb2-id-cmb-thst-page-padding-top" ).removeClass('is-hidden');
				$( ".cmb2-id-cmb-thst-page-padding-bottom" ).removeClass('is-hidden');
		    } else {
		    	$( ".cmb2-id-cmb-thst-page-padding-top" ).addClass('is-hidden');
				$( ".cmb2-id-cmb-thst-page-padding-bottom" ).addClass('is-hidden');
		    }
		});


	});
})(jQuery);