{
	'use strict';
	window.addEventListener('DOMContentLoaded',init,false);

	let checkifblog = podpageparallax.check_if_blog;
	let headerbg = '';
	let headertxt = '';


	if( checkifblog ) {

		headerbg = document.querySelector('.blog .reg .content_page_thumb .background_image .parallax.parallax_on');
		headertxt = document.querySelector('.blog .reg .heading .title');

	} else {

		headerbg = document.querySelector('.page .reg .content_page_thumb .background_image .parallax.parallax_on');
		headertxt = document.querySelector('.page .reg .heading .title');
	}


	let setTranslate = (x,y,el) => {
		if( el !== null ) {
			el.style.transform="translate3d(" + x + "px," + y + "px,0)";
		}
	}
	
	let xScrollPosition;
	let yScrollPosition;
	
	function init(){
	
		xScrollPosition=window.scrollX;	
		yScrollPosition=window.scrollY;

		setTranslate(0, yScrollPosition * 0, headertxt);
		setTranslate(0, yScrollPosition * 0.2, headerbg);
		
		requestAnimationFrame(init);
	}

}	