"use strict";
jQuery(document).ready(function($) {
  $(window).scroll(function() {
    if ($(document).scrollTop() > 300) {
      $(".sticky-featured-audio-container").addClass("image-visible");
    } else {
      $(".sticky-featured-audio-container").removeClass("image-visible");
    }
  });
});