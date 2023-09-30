<?php 

if( ! function_exists( 'pod_load_more_scripts' ) ) {
	function pod_load_more_scripts() {
	 
		global $wp_query; 
		$active_plugin = pod_get_plugin_active();
		$paged_static = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;
		$arch_category = pod_theme_option('pod-recordings-category', '');
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';

		$pod_front_num_posts = pod_theme_option('pod-front-posts', 9);
		
		$pod_fh_type = pod_theme_option('pod-featured-header-type', 'static');
		$featured_content = pod_theme_option('pod-featured-header-content', 'newest');

		/* Check for static front page template */
		$pod_fp_id = get_option( 'page_on_front' );
		$pod_fp_current_template = get_page_template_slug( $pod_fp_id );

			
		if( $active_plugin == 'ssp' ) {

			$ssp_post_types = ssp_post_types();
			$ssp_arch_category = pod_ssp_active_cats("ssp");

			
			if ( isset( $pod_front_num_posts ) && (  $ssp_arch_category != '' || $arch_category != '' ) ) { 
				$args = array( 
					'post_type' => $ssp_post_types,
					'posts_per_page' => $pod_front_num_posts, 
					'paged' => $paged_static, 
					'ignore_sticky_posts' => true,
					'post_status' => 'published',
					'offset' => 1,
					'tax_query' => array(
		                'relation' => 'OR',
		                array(
		                    'taxonomy' => 'category',
		                    'field'    => 'term_id',
		                    'terms'    => $arch_category,
		                ),
		                array(
		                    'taxonomy' => 'series',
		                    'field'    => 'term_id',
		                    'terms'    => $ssp_arch_category,
		                ),
		            ),
				);
			} else {
				$args = array( 
					'post_type' => $ssp_post_types,
					'posts_per_page' => $pod_front_num_posts, 
					'paged' => $paged_static, 
					'ignore_sticky_posts' => true,
					'post_status' => 'published'
				);
			}

		} else {

			if ( isset( $pod_front_num_posts ) && $arch_category != '' ) { 
	   			$args = array( 
	   				'cat' => $arch_category, 
	   				'posts_per_page' => $pod_front_num_posts, 
	   				'paged' => $paged_static,
	   				'ignore_sticky_posts' => true,
	   				'post_status' => 'published'
	   			);
		  	} else { 
		  		$args = array( 
		  			//'cat' => 'uncategorized', 
		  			'posts_per_page' => 9, 
		  			'paged' => $paged_static, 
		  			'ignore_sticky_posts' => true,
		  			'post_status' => 'published'
		  		);
		  	}

		} 
	  			
	  	$wp_query_load_more_episodes = new WP_Query( $args );

	  	// Load js files
		$scriptsrc = get_template_directory_uri() . '/js/';
		$pod_ajax_button_text = pod_theme_option('pod-ajax-link-txt', 'Load More');
		$pod_ajax_loading_text = pod_theme_option('pod-ajax-link-loading-txt', 'Loading...');
		$pod_ajax_loaded_text = pod_theme_option('pod-ajax-link-loaded-txt', 'No more posts to load.');
		$pod_fp_ep_style = pod_theme_option('pod-front-style', 'front-page-list');
		$pod_is_rtl = pod_theme_option('pod-reading-direction', false);
		wp_enqueue_script('jquery');

		if(  $pod_fp_current_template == "page/page-frontpage-blog.php" || $pod_fp_current_template == "page/page-frontpage-blog-right.php" || $pod_fp_current_template == "page/page-frontpage-blog-left.php" ) { 

			// register our main script but do not enqueue it yet
			wp_register_script( 'pod_loadmore_static_blog', get_template_directory_uri() . '/js/pod-loadmore-static-blog.js', array('jquery'), false );
		 
			// we have to pass parameters to pod-loadmore.js.
			wp_localize_script( 'pod_loadmore_static_blog', 'pod_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
				'posts' => json_encode( $wp_query_load_more_episodes->query_vars ), // everything about your loop is here
				'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
				'max_page' => $wp_query_load_more_episodes->max_num_pages,
				'load_more_text' => $pod_ajax_button_text,
				'loading_text' => $pod_ajax_loading_text,
				'loaded_text' => $pod_ajax_loaded_text

			) );
			
		 	wp_enqueue_script( 'pod_loadmore_static_blog' );

		} else {

			// register our main script but do not enqueue it yet
			wp_register_script( 'pod_loadmore', get_template_directory_uri() . '/js/pod-loadmore.js', array('jquery', 'thst-masonry', 'thst-imagesloaded'), true );
		 
			// we have to pass parameters to pod-loadmore.js.
			wp_localize_script( 'pod_loadmore', 'pod_loadmore_params', array(
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
				'posts' => json_encode( $wp_query_load_more_episodes->query_vars ), // everything about your loop is here
				'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
				'max_page' => $wp_query_load_more_episodes->max_num_pages,
				'load_more_text' => $pod_ajax_button_text,
				'loading_text' => $pod_ajax_loading_text,
				'loaded_text' => $pod_ajax_loaded_text,
				'originLeft' => $pod_is_rtl,
				'fp_ep_style' => $pod_fp_ep_style

			) );

			/* Enqueue ajax script */
		 	wp_enqueue_script( 'pod_loadmore' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'pod_load_more_scripts' );


if( ! function_exists( 'pod_loadmore_ajax_handler' ) ) {
	function pod_loadmore_ajax_handler(){

		/* Check for static front page template */
		$pod_fp_id = get_option( 'page_on_front' );
		$pod_fp_current_template = get_page_template_slug( $pod_fp_id );

		$pod_fh_type = pod_theme_option('pod-featured-header-type', 'static');
		$featured_content = pod_theme_option('pod-featured-header-content', 'newest');
		$pod_front_num_posts = pod_theme_option('pod-front-posts', 9);
		$arch_category = pod_theme_option('pod-recordings-category', '');
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';

		// prepare our arguments for the query
		$args = json_decode( stripslashes( $_POST['query'] ), true );

		$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
		$args['category__in'] = $arch_category;
		$args['posts_per_page'] = $pod_front_num_posts;
		$args['post_status'] = 'publish';
		$args['offset'] = 1;


		// Calculate offset for ajax loading.
		if ( isset( $args['offset'] ) ) {
		    $offset = absint( $args['offset'] );
		    $args['offset'] = absint( ( $args['paged'] - 1 ) * $args['posts_per_page'] ) + $offset;
		}

		// Check for exceptions and set offset to 0.
		if( $pod_fh_type == "text"  || $pod_fh_type == "hide" || $pod_fh_type == "video-bg" || ( $pod_fh_type == "static-posts" && $featured_content == "featured" ) || ( $pod_fh_type == "slideshow" && $featured_content == "featured" ) ) {
			$args['offset'] = 0;

			if ( isset( $args['offset'] ) ) {
			    $offset = absint( $args['offset'] );
			    $args['offset'] = absint( ( $args['paged'] - 1 ) * $args['posts_per_page'] ) + $offset;
			}
		}


		$the_query = new WP_Query( $args );

		if( $the_query->have_posts() ) :
	 
			while( $the_query->have_posts() ): $the_query->the_post(); 

				if(  $pod_fp_current_template == "page/page-frontpage-blog.php" || $pod_fp_current_template == "page/page-frontpage-blog-right.php" || $pod_fp_current_template == "page/page-frontpage-blog-left.php" ) {
				
					get_template_part( 'postfp/format', get_post_format() );
				
				} else {

					get_template_part( 'templates-parts/frontpage','episodes' );

				}

	   		 endwhile;
	 
		endif;
		die; // here we exit the script and even no wp_reset_query() required!
		
	}
}
add_action('wp_ajax_loadmore', 'pod_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'pod_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}