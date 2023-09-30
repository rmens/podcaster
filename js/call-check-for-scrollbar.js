"use strict";
jQuery(document).ready(function($) {
	let $scrollbarWidth = window.outerWidth - window.innerWidth;

	if ($(document).height() > $(window).height()) {

		// Add CSS class for an active scrollbar.
	    $('body').addClass("scrollbar-active");

	    if( $scrollbarWidth > 0) {
	    	let maxWidthCalc = "calc(100vw + " + $scrollbarWidth + "px)";
	    	let widthCalc = "calc(100vw + " + $scrollbarWidth + "px)";

	    	var $css = "<style>.template-gutenberg .entry-content .alignfull { margin-left : calc( ( 50% - 50vw ) + calc( " + $scrollbarWidth + "px / 2 ) ) !important; margin-right : calc( ( 50% - 50vw ) + calc( " + $scrollbarWidth + "px / 2 ) ) !important; max-width : calc(100vw - " + $scrollbarWidth + "px); width : calc(100vw - " + $scrollbarWidth + "px)} </style>";
			$("body").append($css);
		}
	}
});