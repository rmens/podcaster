"use strict";
var resizeTimer;

jQuery(document).ready(function ($) {
    updateContainer();
    updateAudioArt();

    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            updateContainer();
            updateAudioArt();
        }, 25);
    });

    function updateContainer() {
        var $containerW = $(window).width();
        var $frontPageHeader = $(".front-page-header");

        if( $frontPageHeader.hasClass("slideshow")) {
            var slides = $(".front-page-header.slideshow .slide");

            slides.each( function(idx, slide) {
                var slide = $(slide);
                var $sEmbedContainer = slide.find('.embed-container');
                var $sEmbedTextCenter = slide.find('.embed-col-text.content');
                var $sEmbedText = slide.find('.embed-container > .embed-col-text:not(.content)');
                var $sEmbedMedia = slide.find('.embed-col-media');
                var $sAudioPlayer = slide.find('.audio_player');
                var $sVideoPlayer = slide.find('.video_player');

                if ($containerW <= 768) {

                    if( $sEmbedText.length > 0 && $sEmbedMedia.length > 0 && $sAudioPlayer.length > 0 ) {
                        $sAudioPlayer.appendTo($sEmbedText);
                    } else if( $sEmbedTextCenter.length > 0 && $sEmbedMedia.length > 0 && $sAudioPlayer.length > 0 ) {
                        $sAudioPlayer.appendTo($sEmbedTextCenter);
                    }
                    if( $sEmbedText.length > 0 && $sEmbedMedia.length > 0 && $sVideoPlayer.length > 0 ) {
                        $sVideoPlayer.appendTo($sEmbedText);
                    } else if( $sEmbedTextCenter.length > 0 && $sEmbedMedia.length > 0 && $sVideoPlayer.length > 0 ) {
                        $sVideoPlayer.appendTo($sEmbedTextCenter);
                    }
                }

                if ($containerW > 769) {

                    if( $sEmbedText.length > 0 && $sEmbedMedia.length > 0 && $sAudioPlayer.length > 0 ) {
                        $sAudioPlayer.appendTo($sEmbedMedia);
                    } else if( $sEmbedTextCenter.length > 0 && $sEmbedMedia.length > 0 && $sAudioPlayer.length > 0 ) {
                        $sAudioPlayer.appendTo($sEmbedMedia);
                    }
                    if( $sEmbedText.length > 0 && $sEmbedMedia.length > 0 && $sVideoPlayer.length > 0 ) {
                        $sVideoPlayer.appendTo($sEmbedMedia);
                    } else if( $sEmbedTextCenter.length > 0 && $sEmbedMedia.length > 0 && $sVideoPlayer.length > 0 ) {
                        $sVideoPlayer.appendTo($sEmbedTextCenter);
                    }
                }
            });
            
        } else {
            var embedContainer = $('.front-page-header .row .embed-container');
            var $embedText = $('.front-page-header .embed-container > .embed-col-text');
            var $embedMedia = $('.front-page-header .embed-container .embed-col-media');
            
            var $embededPlayer = $('.front-page-header .row .embed-container .audio_player');
            var $embededVideoPlayer = $('.front-page-header .row .embed-container .video_player');


            if( embedContainer.hasClass("embed-alignment-left") || embedContainer.hasClass("embed-alignment-right") || embedContainer.hasClass("embed-alignment-center") ) {
                
                if ($containerW <= 768) {
                    if( $embededPlayer.parents('.front-page-header .embed-container.embed-alignment-left .embed-col.embed-col-media').length > 0 || $embededPlayer.parents('.front-page-header .embed-container.embed-alignment-right .embed-col.embed-col-media').length > 0 ) {
                        $embededPlayer.appendTo( $embedText );
                    } else if( $embededPlayer.parents('.front-page-header .embed-container.embed-alignment-center .embed-col.embed-col-media').length > 0 ) {
                        var $embedTextCenter = $('.front-page-header .embed-container .embed-col-text.content');
                        $embededPlayer.appendTo( $embedTextCenter );
                    } 

                    if( $embededVideoPlayer.parents('.front-page-header .embed-container.embed-alignment-left .embed-col.embed-col-media').length > 0 || $embededVideoPlayer.parents('.front-page-header .embed-container.embed-alignment-right .embed-col.embed-col-media').length > 0 ) {
                        $embededVideoPlayer.appendTo( $embedText );
                    } else if( $embededVideoPlayer.parents('.front-page-header .embed-container.embed-alignment-center .embed-col.embed-col-media').length > 0 ) {
                        var $embedTextCenter = $('.front-page-header .embed-container.embed-alignment-center .embed-col-text.content');
                        $embededVideoPlayer.appendTo( $embedTextCenter );
                    }
                }

                if ($containerW > 769) {
                    if( $embededPlayer.parents('.front-page-header .embed-container.embed-alignment-left > .embed-col.embed-col-text').length > 0 || $embededPlayer.parents('.front-page-header .embed-container.embed-alignment-right > .embed-col.embed-col-text').length > 0 ) {
                        $embededPlayer.appendTo( $embedMedia );
                    } else if( $embededPlayer.parents('.front-page-header .embed-container.embed-alignment-center .embed-col.embed-col-text.content').length > 0 ) {
                        $embededPlayer.appendTo( $embedMedia );
                    } 

                    if( $embededVideoPlayer.parents('.front-page-header .embed-container.embed-alignment-left > .embed-col.embed-col-text').length > 0 || $embededVideoPlayer.parents('.front-page-header .embed-container.embed-alignment-right > .embed-col.embed-col-text').length > 0 ) {
                        $embededVideoPlayer.appendTo( $embedMedia );
                    } else if( $embededPlayer.parents('.front-page-header .embed-container.embed-alignment-center .embed-col.embed-col-text.content').length > 0 ) {
                        $embededVideoPlayer.appendTo( $embedMedia );
                    }
                }
            }
        }
    }

    function updateAudioArt(){
        var $windowW = $(window).width();
        var $frontPageHeader = $(".front-page-header");
        var $audioArtContainer = $('.front-page-header .main-featured-container');
        var $audioArtImg = $('.front-page-header .main-featured-container .img');


        if( $audioArtImg.parents($audioArtContainer).length > 0 ) {

            if( $frontPageHeader.hasClass("slideshow")) {
                var slides = $(".front-page-header.slideshow .slide ");

                slides.each( function(idx, slide) {
                    var slide = $(slide);

                    var $sAudioArtContainer = slide.find('.main-featured-container');
                    var $sEmbedText = slide.find('.embed-col-text');
                    var $sEmbedTextHeading = slide.find('.embed-col-text-heading');
                    var $sText = slide.find('.main-featured-container > .text');
                    var $sImg = slide.find('.main-featured-container .img');

                    if ($windowW <= 768) {

                        if($sEmbedTextHeading.length > 0 ) {
                            $sImg.appendTo($sEmbedTextHeading);
                        } else if( $sEmbedText.length > 0 ) {
                            $sImg.appendTo($sEmbedText);
                        } else if( $sText ) {
                            $sImg.appendTo($sText);
                        }
                    }

                    if ($windowW > 769) {

                        if($sAudioArtContainer.length > 0 ) {

                            $sImg.appendTo($sAudioArtContainer);
                        }
                    }
                });

            } else {
                var $embedText = $audioArtContainer.find('.embed-container .embed-col-text');
                var $embedTextHeading = $audioArtContainer.find('.embed-container .embed-col-text-heading');
                var $text = $audioArtContainer.find('.text');
                var $img = $audioArtContainer.find('.img');


                if ($windowW <= 768) {

                    if($embedTextHeading.length > 0 ) {
                        $img.appendTo($embedTextHeading);
                    } else if( $embedText.length > 0 ) {
                        $img.appendTo($embedText);
                    } else if( $text ) {
                        $img.appendTo($text);
                    }
                }
                if ($windowW > 769) {

                    if($audioArtContainer.length > 0 ) {
                        $img.appendTo($audioArtContainer);
                    }
                }
            }
        }
    }


    // Open menu to the left if too close
    var $navElement = $("#nav .thst-menu > li.menu-item-has-children ");
    var $isRTL = podresize.readdirection;

    if( $isRTL ) {
        $navElement.each(function(idx, li) {

            var linkElement = $(li);
            //var rightOffset = ($(window).width() - (linkElement.offset().left + linkElement.outerWidth()));
            var leftOffset = linkElement.offset().left;

            if( linkElement.children(".sub-menu").length > 0 ) {

                var liLeftOffset = leftOffset;
                var liSubMenuWidth = linkElement.children(".sub-menu").width();

                if (liLeftOffset < liSubMenuWidth * 2.5 ) {
                    linkElement.addClass("menu-open-dir-right");
                }
            }
        });

    } else {
        $navElement.each(function(idx, li) {

            var linkElement = $(li);
            var rightOffset = ($(window).width() - (linkElement.offset().left + linkElement.outerWidth()));

            if( linkElement.children(".sub-menu").length > 0 ) {

                var liRightOffset = rightOffset;
                var liSubMenuWidth = linkElement.children(".sub-menu").width();

                if (liRightOffset < liSubMenuWidth * 2.5 ) {
                    linkElement.addClass("menu-open-dir-left");
                }
            }
        });
    }
});