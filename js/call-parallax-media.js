{
	'use strict';
	window.addEventListener('DOMContentLoaded',init,false);

	var post_format = podsinglemediaparallax.post_format;
	var headerbg = '';
	var headertxt = '';

	if( post_format == "audio" ) {
		headerbg = document.querySelector('.single .single-featured.format-audio.audio-featured-image-background .background_image .parallax.parallax_on');
		headertxt = document.querySelector('.single .single-featured-audio-container');
	} else if( post_format == "video" ) {
		headerbg = document.querySelector('.single .single-featured.format-video.video-featured-image-background .background_image .parallax.parallax_on');
		headertxt = document.querySelector('.single .single-featured-video-container');
	}
	
	var setTranslate = (x,y,el) => {

		if( el !== null ) {
			el.style.transform="translate3d(" + x + "px," + y + "px,0)";
		}
	}
	
	var xScrollPosition;
	var yScrollPosition;
	
	function init(){
	
		xScrollPosition=window.scrollX;	
		yScrollPosition=window.scrollY;

		setTranslate(0, yScrollPosition * 0, headertxt);
		setTranslate(0, yScrollPosition * 0.2, headerbg);
		
		requestAnimationFrame(init);
	}

}	