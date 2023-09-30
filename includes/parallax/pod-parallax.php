<?php 


/**
 * pod_header_parallax()
 * Function that manages the parallax settings for pages
 *
 * @param string $post_id - ID of the page
 * @return string $output - <div> for background image and parallax.
 * @since 1.8.9
 */
if( ! function_exists( 'pod_header_parallax' ) ){
	function pod_header_parallax( $post_id=0 ) {

		$pod_plugin_active = pod_get_plugin_active();
		$format = get_post_format( $post_id );
		if( $pod_plugin_active == "ssp" ) {
			$format = pod_ssp_get_format( $post_id );
		}

		$bg_parallax = '';


		if( is_front_page() && ! is_home()) {

			// Check what type of header is active.
			$header_type = pod_theme_option( 'pod-featured-header-type', 'static' );

			if( $header_type == "text" || $header_type = "static" ) {

				$bg_parallax = pod_theme_option( 'pod-frontpage-header-par', false );
				$bg_parallax = ($bg_parallax) ? "on" : "off";

			} elseif( $header_type == "static-posts" || $header_type = "slideshow" ) {

				$bg_parallax = get_post_meta( $post_id, 'cmb_thst_feature_post_para', true );

			}

		} elseif( is_home() ) {

			$bg_parallax = pod_theme_option( 'pod-blog-header-par', false );
			$bg_parallax = ($bg_parallax) ? "on" : "off";
		
		} elseif( is_page() ) {

			$bg_parallax = get_post_meta( $post_id, 'cmb_thst_page_header_parallax', true );

		} elseif( is_single() && ( $format == "audio" || $format == "video" )) {

			$bg_parallax = pod_theme_option( 'pod-single-header-par', false );
			$bg_parallax = ($bg_parallax) ? "on" : "off";

		} 

		$output = '<div class="background_image"><div class="parallax parallax_' . $bg_parallax . '"></div></div>';

		return $output;
	}
}



/**
 * pod_load_javascript_files()
 * Load Front-End jS Scripts.
 *
 * @since Podcaster 1.0
 */
if( ! function_exists('pod_load_parallax_js_files') ) {
	function pod_load_parallax_js_files() {

		$scriptsrc = get_template_directory_uri() . '/js/';

		$pod_plugin_active = pod_get_plugin_active();

		if( is_singular() ){
			$post_id = get_the_ID();
			$format = get_post_format( $post_id );

			if( $pod_plugin_active == "ssp" ) {
				$format = pod_ssp_get_format( $post_id );
			}
		}


		/* Handles parallax */
		if( is_front_page() && ! is_home() ){
			wp_register_script( 'thst-call-parallax-front-page', $scriptsrc . 'call-parallax-front-page.js', array(), '1.0', true );
			
			/* Get theme options */
			$header_type = pod_theme_option( 'pod-featured-header-type', 'static' );

			$fp_header_options = array(
				'header_type' => $header_type,
			);
			wp_localize_script( 'thst-call-parallax-front-page', 'podfrontpageparallax', $fp_header_options );
			wp_enqueue_script( 'thst-call-parallax-front-page' );

		} elseif( is_page() || is_home() ) {
			
			$check_if_blog = is_home();

			$page_header_options = array(
				'check_if_blog' => $check_if_blog,
			);
			wp_register_script( 'thst-call-parallax', $scriptsrc . 'call-parallax.js', array(), '1.0', true );
			wp_localize_script( 'thst-call-parallax', 'podpageparallax', $page_header_options );
			wp_enqueue_script( 'thst-call-parallax' );

		} elseif( is_single() && ($format == "audio" || $format == "video") ) {

			$bg_parallax = pod_theme_option( 'pod-single-header-par', false );

			$post_single_media = array(
				'post_format' => $format,
			);
			wp_register_script( 'thst-call-parallax-media', $scriptsrc . 'call-parallax-media.js', array(), '1.0', true );
			wp_localize_script( 'thst-call-parallax-media', 'podsinglemediaparallax', $post_single_media );

			if( $bg_parallax ) {
				wp_enqueue_script( 'thst-call-parallax-media' );
			}
		}




	}
}
add_action( 'wp_enqueue_scripts', 'pod_load_parallax_js_files' );



if( ! function_exists( 'pod_page_header_parallax_css' ) ) {
	function pod_page_header_parallax_css() {

		// Manage filter
		$header_filter_active = pod_theme_option( 'pod-filter-active', true );
		$header_filter_color = pod_theme_option( 'pod-transparent-screen', '' );
		$header_filter_rgba = !empty( $header_filter_color['rgba']) ? $header_filter_color['rgba'] : "rgba(0,0,0,0.5)";
		$header_filter_rgba = (! $header_filter_active ) ? "rgba(0,0,0,0)" : $header_filter_rgba;

		$css = "";
		$css .= '<style>';

		if ( is_page() || is_home() ) {

			if( is_page() ){
	        	// Get the post id using the get_the_ID(); function:
	        	$post_id = get_the_ID();

	        	$bg_style = get_post_meta($post_id, 'cmb_thst_page_header_bg_style', true);
	        	$pod_archive_img_use = get_post_meta($post_id, 'cmb_thst_podcast_image_use', true);
	        	$pod_archive_img_use = ($pod_archive_img_use == "") ? 'pod-archive-img-thumbnail' : $pod_archive_img_use;
	        	$bg_style_output = ($bg_style == "") ? " auto" : "cover";
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), '' );
				$header_img = !empty( $image ) ? $image[0] : '';

				$css .= '.page .reg .content_page_thumb .background_image .parallax {
					background-image: url(' . $header_img . ');
					' . $bg_style . ';
				}';

				if( is_page_template( 'page/page-podcastarchive-grid.php' ) || is_page_template( 'page/page-podcastarchive-list.php' ) || is_page_template( 'page/page-podcastarchive-grid-classic.php' ) || is_page_template( 'page/page-podcastarchive-list-classic.php' ) ) {
					if( $pod_archive_img_use == 'pod-archive-img-thumbnail' ) {
						$css .= '.page .reg .content_page_thumb .background_image .parallax {
							background-image: none;
						}';

					}
				}


			} elseif( is_home() ) {
				$header_img = pod_theme_option( 'pod-blog-header' );
				$header_img = ! empty( $header_img["url"] ) ? $header_img["url"] : '';
				$bg_style = pod_theme_option( 'pod-blog-bg-style', 'background-repeat:repeat;' );

				$css .= '.blog .reg .content_page_thumb .background_image .parallax {
					background-image: url(' . $header_img . ');
				}';

			}

			$css .= '
				.page .reg .content_page_thumb,
				.blog .reg .content_page_thumb {
					position: relative;
					overflow: hidden;

				}
				.page .reg .content_page_thumb .background_image,
				.blog .reg .content_page_thumb .background_image { 
					display: block;
					width: 100%;
					position: absolute;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					overflow: hidden;
				}
				.page .reg .content_page_thumb .background_image .parallax,
				.blog .reg .content_page_thumb .background_image .parallax {
					position: absolute;
					top: -50px;
					left: 0;
					right: 0;
					bottom: -50px;
				}';
				if( $bg_style) {
					$css .= '.blog .reg .content_page_thumb .background_image .parallax {
						' . $bg_style . '
					}';
				}
				$css .= '.page .reg .content_page_thumb .background_image:before,
				.blog .reg .content_page_thumb .background_image:before {
					content: " ";
					background: ' . $header_filter_rgba . ';
					display: block;
					position: absolute;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					z-index: 1;
				}
				.page .reg .content_page_thumb .screen,
				.blog .reg .content_page_thumb .screen {
					position: relative;
					z-index: 2;
					background: none;
				}';
			$css .= '</style>';


			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));

    		
			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));
		}
	}
}
add_action("wp_head", "pod_page_header_parallax_css", 175);


if( ! function_exists( 'pod_audio_header_parallax_css' ) ) {
	function pod_audio_header_parallax_css() {

		$pod_plugin_active = pod_get_plugin_active();
		$pod_featured_header_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		$post_id = get_the_ID();
		$format = get_post_format( $post_id );
		if( $pod_plugin_active == "ssp" ) {
			$format = pod_ssp_get_format( $post_id );
		}


		// Manage filter
		$header_filter_active = pod_theme_option( 'pod-filter-active', true );
		$header_filter_color = pod_theme_option( 'pod-transparent-screen', '' );
		$header_filter_rgba = ! empty( $header_filter_color['rgba'] ) ? $header_filter_color['rgba'] : "rgba(0,0,0,0.5)";
		$header_filter_rgba = (! $header_filter_active ) ? "rgba(0,0,0,0)" : $header_filter_rgba;

		// Get the post id using the get_the_ID(); function:
		$post_id = get_the_ID();

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), '' );
		$header_img = !empty( $image ) ? $image[0] : '';

		$bg_parallax = pod_theme_option( 'pod-single-header-par', false );
	    $bg_style = pod_theme_option( 'pod-single-bg-style', 'background-repeat:repeat;' );

		if ( is_single() && ( $format == "audio" || $format == "video" ) ) {
        	
        	if( $format == "audio" || $format == "video" ){

	        	$featured_post_header_img = get_post_meta( $post_id, 'cmb_thst_feature_post_img', true );
	        	
	        	$header_img = ( $featured_post_header_img != '' && ( $pod_featured_header_type == 'static-posts' || $pod_featured_header_type == 'slideshow')  ) ? $featured_post_header_img : $header_img;
	        		
	        } 

			$css = '<style>
				.single .single-featured.format-audio.audio-featured-image-background,
				.single .single-featured.format-video.video-featured-image-background {
					position: relative;
					background-image: none;
					overflow: hidden;

				}
				.single .single-featured.format-audio.audio-featured-image-background .background_image,
				.single .single-featured.format-video.video-featured-image-background .background_image { 
					display: block;
					width: 100%;
					position: absolute;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					overflow: hidden;
				}
				.single .single-featured.format-audio.audio-featured-image-background .background_image .parallax,
				.single .single-featured.format-video.video-featured-image-background .background_image .parallax {
					background-image: url(' . $header_img . ');
					background-position: center center;
					position: absolute;
					top: -50px;
					left: 0;
					right: 0;
					bottom: -50px;
					' . $bg_style . ';
				} 
				.single .single-featured.format-audio.audio-featured-image-background .background_image:before,
				.single .single-featured.format-video.video-featured-image-background .background_image:before {
					content: " ";
					background: ' . $header_filter_rgba . ';
					display: block;
					position: absolute;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					z-index: 1;
				}
				.single .single-featured.format-audio.audio-featured-image-background .background.translucent,
				.single .single-featured.format-video.video-featured-image-background .background.translucent {
					position: relative;
					z-index: 2;
					background: none;
				}';
			$css .= '</style>';


			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));

    		
			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));
		}
	}
}
add_action("wp_head", "pod_audio_header_parallax_css", 175);


if( ! function_exists( 'pod_front_page_header_parallax_css' ) ) {
	function pod_front_page_header_parallax_css() {
		
		// Check what type of header is active.
		$header_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		
		// Manage filter
		$header_filter_active = pod_theme_option( 'pod-filter-active', true );
		$header_filter_color = pod_theme_option( 'pod-transparent-screen', '' );
		$header_filter_rgba = $header_filter_color;
		
		if( is_array($header_filter_color)) {
			$header_filter_rgba = !empty( $header_filter_color['rgba'] ) ? $header_filter_color['rgba'] : "rgba(0,0,0,0.5)";
			$header_filter_rgba = (! $header_filter_active ) ? "rgba(0,0,0,0)" : $header_filter_rgba;
		}

		$header_bg_active = pod_theme_option('pod-frontpage-header-bg-activate', false);
		if( $header_bg_active == false ) {
			return;
		}

		$css = "";
		$css .= '<style>';

		
		if( $header_type == "text" || $header_type == "static" ) {
			$header_from_page = pod_theme_option( 'pod-page-image', false );
			$header_img = pod_theme_option( 'pod-upload-frontpage-header' );
			$header_img = !empty( $header_img["url"] ) ? $header_img["url"] : '' ;


			if( $header_from_page ) {

				$page_id = get_the_ID();
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $page_id ), '' );
				$header_img = ! empty( $image[0] ) ? $image[0] : '';

			}

			$bg_parallax = pod_theme_option( 'pod-frontpage-header-par', false );
        	$bg_style = pod_theme_option( 'pod-frontpage-bg-style', 'background-repeat:repeat;' );
        	$bg_posi = ( $bg_style != "background-repeat:repeat;") ? "center center" : "initial";


        	$css .= '
        		body.has-featured-image .front-page-header.static .background_image .parallax,
				body.has-featured-image .front-page-header.has-header .background_image .parallax,
				body.has-featured-image .latest-episode.front-header .background_image .parallax {
					background-image: url(' . $header_img . ');
					background-position: ' . $bg_posi .';
					position: absolute;
					top: -50px;
					left: 0;
					right: 0;
					bottom: -50px;
					' . $bg_style . ';
				}';
		} 

		$css .= '
				.front-page-header.static,
				.front-page-header.has-header,
				.latest-episode.front-header,
				.front-page-header .slide.has-header {
					position: relative;
					overflow: hidden;
				}
				.front-page-header.static .background_image,
				.front-page-header.has-header .background_image,
				.latest-episode.front-header .background_image,
				.front-page-header .slide.has-header .background_image { 
					display: block;
					width: 100%;
					position: absolute;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					overflow: hidden;
				}
				.front-page-header.static .background_image .parallax,
				.front-page-header.has-header .background_image .parallax,
				.latest-episode.front-header .background_image .parallax,
				.front-page-header .slide.has-header .background_image .parallax {
					position: absolute;
					top: -50px;
					left: 0;
					right: 0;
					bottom: -50px;
				}
				body.has-featured-image .front-page-header.static .background_image:before, 
				body.has-featured-image .front-page-header.has-header .background_image:before,
				body.has-featured-image .latest-episode.front-header .background_image:before,
				body.has-featured-image .front-page-header .slide.has-header .background_image:before {
					content: " ";
					background: ' . $header_filter_rgba . ';
					display: block;
					position: absolute;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					z-index: 1;
				}
				.front-page-header.static .inside,
				.front-page-header.has-header .inside,
				.header-filter-active .front-page-header.static.has-header .inside,
				.latest-episode.front-header .translucent,
				.front-page-header .slide.has-header .inside {
					position: relative;
					z-index: 2;
					background: none;
				}
				.header-filter-active .front-page-header.static .translucent,
				.header-filter-active .latest-episode.front-header .translucent,
				.header-filter-active .front-page-header.slideshow .has-header .inside {
					background: none;
				}';
			$css .= '</style>';

			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));

			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));
		
	}
}
add_action("wp_head", "pod_front_page_header_parallax_css", 175);

if( ! function_exists( 'pod_front_page_header_video_parallax_css' ) ) {
	function pod_front_page_header_video_parallax_css() {
		
		// Check what type of header is active.
		$header_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		
		// Manage filter
		$header_filter_active = pod_theme_option( 'pod-filter-active', true );
		$header_filter_color = pod_theme_option( 'pod-transparent-screen', '' );
		$header_filter_rgba = !empty( $header_filter_color['rgba'] ) ? $header_filter_color['rgba'] : "rgba(0,0,0,0.5)";
		$header_filter_rgba = (! $header_filter_active ) ? "rgba(0,0,0,0)" : $header_filter_rgba;
		
		$header_video_bg_active = pod_theme_option('pod-frontpage-header-bg-video-activate', true);
		
		if( $header_video_bg_active == false ) {
			return;
		}

		$css = "";
		$css .= '<style>';

		$css .= '
				body.has-featured-image .front-page-header-video-background .video-bg .screen {
					background: ' . $header_filter_rgba . ';
				}';
			$css .= '</style>';

			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));

			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));
		
	}
}
add_action("wp_head", "pod_front_page_header_video_parallax_css", 175);