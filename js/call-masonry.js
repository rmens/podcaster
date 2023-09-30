"use strict";

jQuery(document).ready(function($){

	/* Legacy Episode Archive (Grid) */
	var $legacy_container_pod_library = $('.page-template-page-podcastarchive .entries.grid .row, .page-template-page-podcastarchive-grid-classic .entries.grid .row');
	$legacy_container_pod_library.imagesLoaded(function () {
		$legacy_container_pod_library.masonry({
			itemSelector: '.page-template-page-podcastarchive .entries.grid .row .podpost, .page-template-page-podcastarchive-grid-classic .entries.grid .row .podpost',
			percentPosition: true,
			columnWidth: '.grid-sizer',
			gutter: '.gutter-sizer',
			horizontalOrder: true,
			originLeft: true
		});
	});

});