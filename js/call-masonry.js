jQuery(document).ready(function($){
	
	//Infinite Scroll
	var $container = $('.list-of-episodes .row.masonry-container, .fromtheblog .row .row');

	$container.imagesLoaded(function () {
		$container.masonry({
			itemSelector: '.inside-container, .fromtheblog .post',
			percentPosition: true,
			gutter: 0,
		});
	});
});