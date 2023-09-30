{
	'use strict';
	window.addEventListener('DOMContentLoaded',init,false);

	var headertype = podfrontpageparallax.header_type;


	var headerbg = "";
	var headertxt = "";

	if( headertype == "text" ) {

		headerbg = document.querySelector('.front-page-header.has-header .background_image .parallax.parallax_on');
		headertxt = document.querySelector('.front-page-header.has-header .inside');

	} else if( headertype == "static" ) {

		headerbg = document.querySelector('.latest-episode.front-header .background_image .parallax.parallax_on');
		headertxt = document.querySelector('.latest-episode.front-header .front-page-inside');

	} else if( headertype == "static-posts" ) {

		headerbg = document.querySelector('.front-page-header.has-header .background_image .parallax.parallax_on');
		headertxt = document.querySelector('.front-page-header.has-header .inside');

	} else if( headertype == "slideshow" ) {

		headerbg = document.querySelectorAll('.front-page-header .slide.has-header .background_image .parallax.parallax_on');
		headertxt = document.querySelectorAll('.front-page-header .slide.has-header .inside.inside_parallax_on');

	}  else if( headertype == "video-bg" ) {
		headerbg = document.querySelectorAll('.front-page-header.front-page-header-video-background.parallax_on .video-bg');
		headertxt = document.querySelectorAll('.front-page-header.front-page-header-video-background.parallax_on .content-text');
	}
	
	var setTranslate = (x,y,el) => {
		if( el ) {
			if( NodeList.prototype.isPrototypeOf(el) ) {
				for (i = 0; i < el.length; ++i) {
				  el[i].style.transform="translate3d(" + x + "px," + y + "px,0)";
				}
			} else {
				el.style.transform="translate3d(" + x + "px," + y + "px,0)";
			}
		}
	}
	
	var xScrollPosition;
	var yScrollPosition;
	
	function init(){
	
		xScrollPosition = window.scrollX;	
		yScrollPosition = window.scrollY;
		

		setTranslate(0, yScrollPosition * 0, headertxt);
		setTranslate(0, yScrollPosition * 0.2, headerbg);
		
		requestAnimationFrame(init);
	}

}	