<?php 


/**
 * Detect if SSP is active (admin side only)
 *
 * @param -
 * @since 1.9.3
 * @return bool
 */
if( !function_exists( 'pod_is_active_ssp' ) ){
	function pod_is_active_ssp() {

		// Detect plugin (admin only).
		if ( class_exists( 'SSP_Admin' ) || function_exists( 'ss_get_podcast' ) ) {
		    return true;
		}
		return false;
	}
}

/**
 * Detect if BPP is active (admin side only)
 *
 * @param -
 * @since 1.9.3
 * @return bool
 */
if( !function_exists( 'pod_is_active_bpp' ) ){
	function pod_is_active_bpp() {

		// Detect plugin (admin only).
		if ( function_exists('powerpress_content') ) {
		    return true;
		}
		return false;
	}
}
/**
 * Detect if Podcaster Media is active (admin side only)
 *
 * @param -
 * @since 1.9.3
 * @return bool
 */

if( !function_exists( 'pod_is_active_podm' ) ){
	function pod_is_active_podm() {

		// Detect plugin (admin only).
		if ( function_exists('pod_media_player') ) {
		    return true;
		}
		return false;
	}
}

/*
 *
 * GUTENBERG
 *-------------------------------------------------------*/

/**
 * Check if Block Editor is active.
 * Must only be used after plugins_loaded action is fired.
 *
 * @return bool
 */
if( ! function_exists( 'pod_is_gutenberg_active' ) ) {
	function pod_is_gutenberg_active() {
	    // Gutenberg plugin is installed and activated.
	    $gutenberg = ! ( false === has_filter( 'replace_editor', 'gutenberg_init' ) );

	    // Block editor since 5.0.
	    $block_editor = version_compare( $GLOBALS['wp_version'], '5.0-beta', '>' );

	    if ( ! $gutenberg && ! $block_editor ) {
	        return false;
	    }

	    if ( pod_is_classic_editor_plugin_active() ) {
	        $editor_option       = get_option( 'classic-editor-replace' );
	        $block_editor_active = array( 'no-replace', 'block' );

	        return in_array( $editor_option, $block_editor_active, true );
	    }
	    return true;
	}
}

/**
 * Check if Classic Editor plugin is active.
 *
 * @return bool
 */
if( ! function_exists( 'pod_is_classic_editor_plugin_active' ) ) {
	function pod_is_classic_editor_plugin_active() {
	    if ( ! function_exists( 'is_plugin_active' ) ) {
	        include_once ABSPATH . 'wp-admin/includes/plugin.php';
	    }

	    if ( ! class_exists( 'Classic_Editor' ) ) {
	        return false;
	    }

	    return true;
	}
}



/*
 *
 * SUPPORTING
 *-------------------------------------------------------*/

/**
 * Add documentation link to the menu
 */
if( ! function_exists( 'pod_docs_link' ) ) {
	function pod_docs_link(){
		add_submenu_page( 
			'pod-theme-options', 
			'Documentation', 
			esc_html__( "Documentation", "podcaster" ), 
			'edit_themes', 
			'pod-docs', 
			'pod_docs_page');
	}
}
add_action('admin_menu', 'pod_docs_link', 30);

if( ! function_exists( 'pod_docs_page' ) ) {
	function pod_docs_page() { ?>
	    <script type="text/javascript">
	        //<![CDATA[
	            window.location.replace("http://themestation.co/documentation/podcaster");
	        //]]>
	    </script>
	<?php }
}

/**
 * Add the support link to the menu
 */
if( ! function_exists( 'pod_support_link' ) ) {
	function pod_support_link(){
		add_submenu_page( 
			'pod-theme-options', 
			'Theme Support', 
			esc_html__( "Theme Support", "podcaster" ), 
			'edit_themes', 
			'thst-support', 
			'pod_support_page');
	}
}
add_action('admin_menu', 'pod_support_link', 30);


if( ! function_exists( 'pod_support_page' ) ) {
	function pod_support_page() { ?>
	    <script type="text/javascript">
	        //<![CDATA[
	            window.location.replace("https://themeforest.net/item/podcaster-multimedia-wordpress-theme/6804946/support");
	        //]]>
	    </script>
	<?php }
}


/**
 * Function to convert em unit into px unit.
 *
 * @param int $em - Font size in em.
 * @since 1.8.7
 * @return int - Font size in px.
 */
if( ! function_exists( 'pod_em_to_px' ) ){
	function pod_em_to_px( $em ) {
		return $em * 16;
	}
}

/**
 * Function to convert px unit into em unit.
 *
 * @param int $px - Font size in px.
 * @since 1.8.7
 * @return int - Font size in em.
 */
if( ! function_exists( 'pod_px_to_em' ) ){
	function pod_px_to_em( $px ) {
		return $px / 16;
	}
}


/**
 * Function to calculate vw value for min and max font sizes. Needed for responsive font sizes.
 *
 * @param int $max_size - Max font size in em.
 * @param int $min_size - Min font size in em.
 * @param int $resolution - Screen resolution size in px.
 * @since 1.8.7
 * @return int - Font size in vw.
 */
if( ! function_exists( 'pod_vw' ) ){
	function pod_vw( $max_size, $min_size, $resolution ) {

		$max_size = ! is_numeric( $max_size ) ? ( int ) $max_size : $max_size;
		$min_size = ! is_numeric( $min_size ) ? ( int ) $min_size : $min_size;

		$size_difference = $max_size - $min_size;

		$px = pod_em_to_px( $size_difference );
		$vw = ( $px / $resolution ) * 100;

		return round( $vw, 2 );
	}
}


/**
 * Calculates font size in vw.
 *
 * @since 1.8.7
 * @return string $font_size_vw - Font size in vw
 */
if( ! function_exists( 'pod_calc_responsive_padding_size' ) ){
	function pod_calc_responsive_padding_size( $padding_size=0,  $padding_size_min=0, $screen_resolution="1920") {
		$padding_size = (int) $padding_size;
		if( $padding_size == 0 ) {
			$padding_size_min = (int) 0;
		}
		$padding_size_em = pod_px_to_em( $padding_size );
		$padding_size_min = pod_px_to_em( $padding_size_min );

		$padding_size_vw = pod_vw( $padding_size_em, $padding_size_min, $screen_resolution );

		return 'calc( ' . $padding_size_min . 'rem + ' . $padding_size_vw . 'vw )';
	}
}


/**
 * Returns specified Google Font property.
 *
 * @since 1.8.7
 * @return string $output - Google Font property.
 */
if( ! function_exists( 'pod_get_googlefont_property' ) ){
	function pod_get_googlefont_property( $fontarray=array(), $property='', $default='' ) {
		$output = ! empty( $fontarray[$property] ) ? $fontarray[$property] : $default;
		return $output;
	}
}

/**
 * Calculates font size in vw.
 *
 * @since 1.8.7
 * @return string $font_size_vw - Font size in vw
 */
if( ! function_exists( 'pod_calc_responsive_font_size' ) ){
	function pod_calc_responsive_font_size( $font_size=0, $font_size_default=0, $font_size_min=0, $unit="px", $screen_resolution="1920") {
		$font_size_int = (int) str_replace( $unit, "", $font_size );
		$font_size_int = !empty( $font_size_int ) ? $font_size_int : $font_size_default;
		
		$font_size_int = pod_px_to_em( $font_size_int );
		$font_size_min = pod_px_to_em( $font_size_min );

		$font_size_vw = pod_vw( $font_size_int, $font_size_min, $screen_resolution );

		return $font_size_vw;
	}
}


/*
 *
 * CSS BODY CLASSES
 *-------------------------------------------------------*/


/**
 * Apply custom body classes.
 *
 * @since 1.6.2
 * @return array $classes - Array containing custom classes.
 */
if( ! function_exists( 'pod_body_classes' ) ){
	function pod_body_classes($classes) {

		if( is_page_template( 'page/page-frontpage.php' ) ) {
			$classes[] = 'has-front-page-template';
		}

		if( is_page_template( 'page/page-frontpage-new.php' ) || is_page_template( 'page/page-frontpage-sections.php' ) ) {
			$classes[] = 'front-page-indigo has-front-page-template';
		}

		if( is_page_template( 'page/page-frontpage-blog.php' ) || is_page_template( 'page/page-frontpage-blog-right.php' ) || is_page_template( 'page/page-frontpage-blog-left.php' ) ) {
			$classes[] = 'front-page-blog-template has-front-page-template';
		}

		if( is_page_template( 'page/page-frontpage.php' ) || is_page_template( 'page/page-frontpage-right.php' ) || is_page_template( 'page/page-frontpage-left.php' ) ) {
			$classes[] = 'front-page-classic-template has-front-page-template';
		}


		if( is_page_template( 'page/page-podcastarchive.php' ) ) {
			$classes[] = 'pod-is-podcast-archive-legacy';
		}

		if( is_page_template( 'page/page-podcastarchive-grid.php' ) || is_page_template( 'page/page-podcastarchive-list.php' ) || is_page_template( 'page/page-podcastarchive-grid-classic.php' ) || is_page_template( 'page/page-podcastarchive-list-classic.php' ) ) {
			$classes[] = 'pod-is-podcast-archive';
		}

	    return $classes;
	}
}
add_filter('body_class', 'pod_body_classes');





/*
 *
 * GENERAL FUNCTIONS
 *-------------------------------------------------------*/

/**
 * Get logo set in WordPress default customizer. 
 *
 * @since 1.6.2
 * @return string $o - Logo as HTML
 */
if( ! function_exists( 'pod_custom_logo' ) ){
	function pod_custom_logo( $classes='' ) {

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		$o = '';

		if ( has_custom_logo() ) {
		    $o .= '<img class="' . $classes . '" src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
		}

		return $o;
	}
}


/**
 * pod_the_blog_content()
 * Custom Excerpt Length for the featured header (set in post).
 *
 * @param string $post_id - ID of given post. 
 * @param string $limit - Default value for the excerpt length.
 * @return string $excerpt - Excerpt with length set to custom value.
 * @since Podcaster 1.5.3
 */
if( ! function_exists( 'pod_the_blog_content' ) ) {
	function pod_the_blog_content() {
		$pod_the_blog_content = pod_theme_option( 'pod-blog-excerpts', 'force' );
		$pod_blog_rm_text = pod_theme_option( 'pod-blog-read-more-text', 'Continue reading →' );

		$output = '';
		if( $pod_the_blog_content == 'force' ) {
			$output .= get_the_excerpt() . '<p><a class="more-link" href="'. get_the_permalink() .'">' . esc_attr( $pod_blog_rm_text ) . '</a></p>';
		} elseif( $pod_the_blog_content == 'set_in_post' ) {
			$content = get_the_content( $pod_blog_rm_text );
			$content = apply_filters('the_content', $content);
			$output = $content;
		} else {
			$content = get_the_content( $pod_blog_rm_text );
			$content = apply_filters('the_content', $content);
			$output = $content;
		}
		$output .= "<div style='clear:both;'></div>";
		return $output;
	}
}


/**
 * pod_loading_spinner()
 * Function that displays spinner
 *
 * @param string $state - state of the spinner.
 * @return string $output - Loading spinner.
 * @since 1.8.7
 */
if( ! function_exists( 'pod_loading_spinner' ) ){
	function pod_loading_spinner( $state='' ) {

		$output = '<div id="loading_bg" class="' . $state . '">
		<div class="circle-spinner"><div class="line"></div></div>
		</div>';

		return $output;
	}
}


/**
 * pod_explicit_post()
 * Explicit marker displayed when oist has been marked as such.
 *
 * @param string $post_id - ID of given post. 
 * @return string $excerpt - Explicit marker.
 * @since Podcaster 1.5
 */
if( !function_exists('pod_explicit_post') ){
	function pod_explicit_post($post_id) {
		$plugin_inuse = pod_get_plugin_active();
		$output = '';

		if( $plugin_inuse == 'ssp' ) {
			$ep_explicit = get_post_meta( $post_id , 'explicit' , true );
			$ep_explicit && $ep_explicit == 'on' ? $explicit_flag = 'Yes' : $explicit_flag = 'No';
				
			if( $explicit_flag == 'Yes' ) {
			    $output .= '<span class="mini-ex">' . __('Explicit', 'podcaster') .'</span>';
			} else {
				$output .= '';
			}
		} else {
			$post_format = get_post_format( $post_id );
			$ep_explicit_au = get_post_meta( $post_id, 'cmb_thst_audio_explicit', true );
			$ep_explicit_vi = get_post_meta( $post_id, 'cmb_thst_video_explicit', true );
			$ep_explicit_au || $ep_explicit_vi == 'on' ? $explicit_flag = 'Yes' : $explicit_flag = 'No';

			if( $post_format == 'audio' ) {
				if( $ep_explicit_au != '' ){
			    	$output .= '<span class="mini-ex">' . __('Explicit', 'podcaster') .'</span>';
			    	$output .= '<span class="mini-ex small-ex">' . __('E', 'podcaster') .'</span>';
			    } else {
			    	$output .= '';
			    }
			} elseif( $post_format == 'video' ) {
				if( $ep_explicit_vi != '' ){
			    	$output .= '<span class="mini-ex">' . __('Explicit', 'podcaster') .'</span>';
			    	$output .= '<span class="mini-ex small-ex">' . __('E', 'podcaster') .'</span>';
			    } else {
			    	$output .= '';
			    }
			}
			
		}
		return $output;
	}
}

/**
 * Checks if the current page has a pagination
 *
 * @since 1.5.8
 *
 * @return boolean - Active or not.
 */
if( ! function_exists( 'pod_has_pagination' ) ) {
	function pod_has_pagination( $pages ) {
		if( $pages == 1 ) {
	    	return "not-paginated";
	    } elseif( $pages > 1 ) {
	    	return "are-paginated";
	    }
	}
}


/*
 *
 * MEDIA & PLAYERS
 *-------------------------------------------------------*/

/**
 * pod_get_media_type()
 * Function to get media type of a post
 *
 * @param -
 * @return string $excerpt - Audio or video player.
 * @since Podcaster 1.5
 */
if( ! function_exists( 'pod_get_media_type' ) ){
	function pod_get_media_type( $post_id ) {

		if ( function_exists( 'pod_media_get_media_type' ) ) { 
			return pod_media_get_media_type( $post_id );
		}

		$format = get_post_format( $post_id );
		
		if( $format == "audio" ){
			$audio_type = get_post_meta( $post_id, 'cmb_thst_audio_type', true );
			return $audio_type;
			
		} elseif( $format == "video" ) {
			$video_type = get_post_meta( $post_id, 'cmb_thst_video_type', true );
			return $video_type;
		}
	}
}

/**
 * pod_get_featured_audio_type_raw()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio player (by URL).
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_audio_type_raw' ) ){
	function pod_get_featured_audio_type_raw( $post_id='' ) {
		$audiotype = get_post_meta( $post_id, 'cmb_thst_audio_type', true );

		return $audiotype;
	}
}


/**
 * pod_get_featured_audio_type()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio player (by URL).
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_audio_type' ) ){
	function pod_get_featured_audio_type( $post_id='' ) {
		$output = '';
		$type = get_post_meta( $post_id, 'cmb_thst_audio_type', true );
		
		
		switch ( $type ) {
			case 'audio-url':
				$output = 'regular-player';
				break;
			case 'audio-embed-url':
				$output = 'au_oembed';
				break;
			case 'audio-embed-code':
				$output = 'embed_code';
				break;			
			default:
				break;
		}
		
		return $output;
	}
}


/**
 * pod_get_featured_player_url()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio player (by URL).
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_player_url' ) ){
	function pod_get_featured_player_url( $post_id='' ) {
		$format = get_post_format( $post_id );
		$player_style = pod_theme_option('pod-players-style');

		if( $format == "audio" ) {
			$file = get_post_meta( $post_id, 'cmb_thst_audio_url', true );
			$pod_players_preload = pod_theme_option('pod-players-preload', 'none');
			$shortcode_attr = array('src' => $file, 'loop' => '', 'autoplay' => '', 'preload' => $pod_players_preload );
			$player = wp_audio_shortcode( $shortcode_attr );
			$output = $player;
			
			/*if( $player_style == "players-style-large" ) {
				$output = pod_get_large_player_url( $file, $player );
			} else {
				$output = $player;
			}*/

			


		} elseif( $format == "video" ) {
			$videourl = get_post_meta( $post_id, 'cmb_thst_video_url', true );
			$videothumb = get_post_meta( $post_id, 'cmb_thst_video_thumb',true );
			$video_shortcode_attr = array( 'src' => $videourl, 'poster' => $videothumb );
			$output =  wp_video_shortcode( $video_shortcode_attr );

		}

		return $output;
	}
}

function pod_get_audio_attachment_default_art( $att_id ) {
	$output = '';
	$img = '';

	if( $att_id == 0 ) {
		return false;
	}

	$img_url = get_the_post_thumbnail_url($att_id, 'square');

	return $img_url;
	
}

function pod_get_audio_attachment_default_title( $att_id ) {
	$output = '';
	$title = '';

	if( $att_id == 0 ) {
		return false;
	}

	$title = get_the_title($att_id);

	return $title;
	
}

if( ! function_exists('pod_get_large_player_url') ) {
	function pod_get_large_player_url( $audio_url, $audio_shortcode_output ) { 

		$att_id = attachment_url_to_postid( $audio_url );
		$episode_art = pod_get_audio_attachment_default_art( $att_id );
		$episode_art_css = ( $episode_art ) ? "has-ep-art" : "no-ep-art";
		$output = '';
		
		$output .= '<div class="pod-player-wrapper ' . $episode_art_css . '">';
			if( $episode_art ) {
			
				$output .= '<div class="pod-player-image">';
					$output .= '<img src="' . $episode_art . '">';
				$output .= '</div>';
			}

			$output .= '<div class="pod-player-content">
				<div class="pod-player-meta">
					
					<h2>' . pod_get_audio_attachment_default_title( $att_id ) . '</h2>
					<ul>
						<li>Podcast Name</li>
						<li>Episode 532</li>
						<li>Season 9</li>
					</ul>
				</div>

				<div class="pod-player-media">';
					
					$output .= $audio_shortcode_output;

				$output .= '</div>
			</div>
		</div>';
		
		return $output;

	}
}


/**
 * pod_get_featured_player_oembed()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio player (by oEmbed URL).
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_player_oembed' ) ){
	function pod_get_featured_player_oembed( $post_id ) {
		$format = get_post_format( $post_id );

		if( $format == "audio" ){
			$oembedurl = get_post_meta( $post_id, 'cmb_thst_audio_embed', true );
			$file_parts = wp_check_filetype( $oembedurl );
		
			if( $file_parts["ext"] != '' ) {
				$audioembed ='';
				$output = "<p>Please use a valid embed URL. Make sure it doesn't have a file extension, such as *.mp3.</p>";
			} else {
				$output = wp_oembed_get( $oembedurl );
			}
		} elseif( $format == "video" ){
			$videoembedurl = get_post_meta( $post_id, 'cmb_thst_video_embed', true );
			$file_parts = wp_check_filetype( $videoembedurl );
		
			if( $file_parts["ext"] != '' ) {
				$videoembed ='';
				$output = "<p>Please use a valid embed URL. Make sure it doesn't have a file extension, such as *.mp3.</p>";
			} else {
				$output = wp_oembed_get( $videoembedurl );
			}
		}

		return $output;
	}
}


/**
 * pod_get_featured_player_embed_code()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio player (by oEmbed URL).
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_player_embed_code' ) ){
	function pod_get_featured_player_embed_code( $post_id ) {
		$format = get_post_format( $post_id );
		$embedcode = '';

		if( $format == "audio" ) {
			$embedcode = get_post_meta( $post_id, 'cmb_thst_audio_embed_code', true );
		} elseif( $format == "video" ) {
			$embedcode = get_post_meta( $post_id, 'cmb_thst_video_embed_code', true );
		}
		return $embedcode;
	}
}


/**
 * pod_get_featured_player_playlist()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio or video player (playlist).
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_player_playlist' ) ){
	function pod_get_featured_player_playlist( $post_id ) {
		$format = get_post_format( $post_id );

		if( $format == "audio" ) {
			$plists = get_post_meta( $post_id, 'cmb_thst_audio_playlist', true );

			if( is_array( $plists ) ) {
				$playlist_ids = implode( ',', array_keys( $plists ) );
			} else {
				$playlist_ids = '';
			}
			$playlist_shortcode_attr = array( 'type' => 'audio', 'ids' => $playlist_ids );

			$playlist = do_shortcode( '[playlist type="audio", ids="' . $playlist_ids . '"]' );
		} elseif( $format == "video" ) {

			$videoplists = get_post_meta( $post_id, 'cmb_thst_video_playlist', true );
			$video_playlist_ids = implode( ',', array_keys( $videoplists ) );
			$video_shortcode_attr = array( 'type' => 'video', 'ids' => $video_playlist_ids );

			$playlist =  '<div class="video_player">' . wp_playlist_shortcode( $video_shortcode_attr ) . '</div>';
		}

		return $playlist;
	}
}


/**
 * pod_get_featured_player_podm()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio player.
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_player_podm' ) ){
	function pod_get_featured_player_podm( $post_id ) {
		$format = get_post_format( $post_id );

		$player = '';
		if( $format == "audio" ){
			$player_type = get_post_meta( $post_id, 'cmb_thst_audio_type', true );
		} elseif( $format == "video" ) {
			$player_type = get_post_meta( $post_id, 'cmb_thst_video_type', true );
		}


		switch ( true ) {
			case ( $player_type == 'audio-url' || $player_type == 'video-url' ):
				$player = pod_get_featured_player_url( $post_id );
				break;

			case ( $player_type == 'audio-embed-url' || $player_type == 'video-oembed' ):
				$player = pod_get_featured_player_oembed( $post_id );
				break;

			case ( $player_type == 'audio-embed-code' || $player_type == 'video-embed-url' ):
				$player = pod_get_featured_player_embed_code( $post_id );
				break;

			case ( $player_type == 'audio-playlist' || $player_type == 'video-playlist' ):
				$player = pod_get_featured_player_playlist( $post_id );
				break;
			
			default:
				$player = '';
				break;
		}


		return $player;
	}
}


/**
 * pod_get_featured_player_ssp()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio player.
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_player_ssp' ) ){
	function pod_get_featured_player_ssp( $post_id ) {
		$output = '';
		$format = pod_ssp_get_format( $post_id );
		$file = pod_ssp_get_media_file( $post_id );

		if( $format == "audio" ) {
			$pod_players_preload = pod_theme_option('pod-players-preload', 'none');
			
			$shortcode_attr = array('src' => $file, 'loop' => '', 'autoplay' => '', 'preload' => $pod_players_preload );
			$output = wp_audio_shortcode( $shortcode_attr );
			//$output .= do_shortcode('[podcast_episode episode="'. $post_id . '" content="player"]');

		} elseif( $format == "video" ) {
			$poster = get_the_post_thumbnail_url( $post_id, 'regular-large' );
			
			$shortcode_attr = array('src' => $file, 'poster' => $poster );
			$output = wp_video_shortcode( $shortcode_attr );
			//$output .= do_shortcode('[podcast_episode episode="'. $post_id . '" content="player"]');
			
		}
		return $output;
	}
}

/**
 * pod_get_featured_player_bpp()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio player.
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_player_bpp' ) ){
	function pod_get_featured_player_bpp( $post_id ) {
		$output = '';
		$bpp_settings = get_option('powerpress_general');
		$bpp_disable_appearance = isset( $bpp_settings['disable_appearance'] ) ? $bpp_settings['disable_appearance'] : false;
			
		if( $bpp_disable_appearance == false ){
			$output .= get_the_powerpress_content();
		}

		return $output;
	}
}


/**
 * pod_get_featured_player()
 * Function to get the featured audio player from a post
 *
 * @param - string $post_id - Post ID
 * @return string $output - Audio player.
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_get_featured_player' ) ){
	function pod_get_featured_player( $post_id, $container = false ) {
		$format = get_post_format( $post_id );
		$plugin_inuse = pod_get_plugin_active();

		if( $plugin_inuse == "ssp" ) {
			$format = pod_ssp_get_format( $post_id );
		}

		$player = '';
		$output = '';
		$type = '';

		switch ( $plugin_inuse ) {
			case 'ssp':
				$player = pod_get_featured_player_ssp( $post_id );
				if( $format == "audio" ){
					$type = 'regular-player';
				}
				break;

			case 'bpp':
				$player = pod_get_featured_player_bpp( $post_id );
				if( $format == "audio" ){
					$type = 'regular-player';
				}
				break;

			case 'podm':
				$player = pod_get_featured_player_podm( $post_id );
				if( $format == "audio" ){
					$type = pod_get_featured_audio_type( $post_id );
				}
				break;

			default:
				$player = '';
				break;
		}


		if( $container == true ) {
			$output .= '<div class="audio-player-container">';
		}
			$output .= '<div class="' . $format . '_player ' . $type . '">';
				$output .= $player;
			$output .= '</div>';

		if( $container == true ) {
			$output .= '</div>';
		}
		return $output;

	}
}



/*
 *
 * NAVIGATION
 *-------------------------------------------------------*/
if( ! function_exists('pod_nav_search_bar') ) {
	function pod_nav_search_bar() {
		$pod_nav_search = pod_theme_option( 'pod-nav-search', false );
		$pod_nav_search_style = pod_theme_option( 'pod-nav-search-style', 'search-style-mini' );

		if ( $pod_nav_search == true ) : ?>
			<div class="nav-search-form <?php echo esc_attr( $pod_nav_search_style ); ?>">
				<a class="open-search-bar" href="#"><span class="fa fa-search"></span></a>
				<div class="search-form-drop">
					<form role="search" method="get" id="searchform-nav" action="<?php echo home_url( '/' ); ?>">
					    <div class="search-container">
					        <input type="text" value="" placeholder="<?php echo esc_attr( __( "Type and press enter...", "podcaster" ) ); ?>" name="s" id="s-nav" />
					        <input type="submit" id="searchsubmit-nav" />
					    </div>
					</form>
				</div>
			</div>
		<?php endif;
	}
}

/*
 *
 * FRONT PAGE HEADER
 *-------------------------------------------------------*/

/**
 * pod_next_week()
 * Next week/scheduled posts.
 *
 * @return string $output - The next week <div> that is displayed under the player on the front page.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_next_week')) {
	function pod_next_week() {

		/* Theme Option Values */
		$arch_category = pod_theme_option( 'pod-recordings-category', '' );
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';
		$pod_preview_title = pod_theme_option( 'pod-preview-title', 'Next Time on Podcaster' );
		$pod_preview_heading = pod_theme_option( 'pod-preview-heading', 'Episode 12: Let\'s go hiking!' );
		$pod_scheduled_posts = pod_theme_option( 'pod-scheduling', false );
		$pod_next_week = pod_theme_option( 'pod-frontpage-nextweek', 'show' );
		$pod_subscribe_buttons = pod_theme_option( 'pod-subscribe-buttons', true );
		
		$pod_butn_one = pod_theme_option( 'pod-subscribe1', 'Subscribe with Apple Podcasts' );
		$pod_butn_one_url = pod_theme_option( 'pod-subscribe1-url', '#' );

		$pod_butn_two = pod_theme_option( 'pod-subscribe2', 'Subscribe with RSS' );
		$pod_butn_two_url = pod_theme_option( 'pod-subscribe2-url', '#' );
		
		$plugin_inuse = pod_get_plugin_active();
		$output = '';
		$output .= '<div class="next-week next-week-'  . $pod_next_week . '">
				<div class="row">';
				if( $pod_next_week == 'show' ) {
					if ( $pod_subscribe_buttons == true ) {
		   				$output .= '<div class="col-lg-6 col-md-6">';
		   			} else {
		   				$output .= '<div class="col-lg-12 col-md-12">';
		   			}

					$output .= '<div class="content scheduled">
					<span class="mini-title">';
						if( $pod_preview_title != '') { 
		   					$output .= $pod_preview_title; 
		   				} 
		   			$output .= '</span>';

                    if( $pod_scheduled_posts  == true ) {
	                    if ( $plugin_inuse == 'ssp' ) {
	                    	$ssp_post_types = ssp_post_types();
				   			$sched_args = array( 
				   				'post_type' => $ssp_post_types, 
				   				'posts_per_page' => 1,  
				   				'ignore_sticky_posts' => true,
				   				'post_status' => 'future',
				   				'order' => 'ASC',
				   			);	
			   			} else {
			   				$sched_args = array( 
				   				'post_type' => 'post', 
				   				'posts_per_page' => 1,  
				   				'ignore_sticky_posts' => true,
				   				'post_status' => 'future',
				   				'order' => 'ASC',
				   			);
			   			} 							   			

						$sched_q = new WP_Query($sched_args);
						if( !($sched_q->have_posts()) ) {
							$output .=  '<p class="schedule-message">' . __('Please schedule a podcast post, to make it visible here.', 'podcaster') . '</p>';
						} else {
							while( $sched_q->have_posts() ) : $sched_q->the_post();
							$output .= '<h3>' . get_the_title() .'</h3>';
							endwhile;
							wp_reset_postdata();
						}
                    } else {
			   			$output .= '<h3>';
			   			if( $pod_preview_heading != '') { 
			   				$output .= $pod_preview_heading;
			   			} 
			   			$output .= '</h3>';
			   		}
				   	$output .= '</div><!-- .content -->
			   			</div><!-- .col -->';
			   		}
			   		if( $pod_subscribe_buttons == true ){
			   			if ( $pod_next_week == 'show' ) {
			   				$output .= '<div class="col-lg-6 col-md-6">';
			   			} else {
			   				$output .= '<div class="col-lg-12 col-md-12">';
			   			}

			   			$output .= '<div class="content buttons">';
			   				if( $pod_butn_one != '' ) {
			   					$output .= '<a href="' . $pod_butn_one_url . '" class="butn small" target="_blank">' . $pod_butn_one . '</a>';
			   				} 
			   				if( $pod_butn_two != '' ) {
			   					$output .= '<a href="' . $pod_butn_two_url .'" class="butn small" target="_blank">' . $pod_butn_two .'</a>';
			   				} 
			   			$output .= '</div><!-- .content -->
			   		</div><!-- .col -->';
			   		}
			   	$output .='</div><!-- .row -->
		</div><!-- .next-week -->';
		return $output;
	}
}

if( ! function_exists( 'pod_embed_width' ) ) {
	function pod_embed_width( $width_type = '') {
		$pod_embed_widths = pod_theme_option( 'pod-embed-widths', 'wide' );
		$pod_embed_style = pod_theme_option( 'pod-embed-style', 'left' );
		$t_width = '';
		$m_width = '';

		if( $pod_embed_widths == 'narrow' ) {
			$t_width = '8';
			$m_width = '4';
			if( $pod_embed_style == "center" ) {
				$m_width = '6';
				$t_width = '12';
			}
		} elseif( $pod_embed_widths == 'equal' ) {
			$t_width = '6';
			$m_width = '6';
			if( $pod_embed_style == "center" ) {
				$m_width = '8';
				$t_width = '12';
			}
		} elseif( $pod_embed_widths == 'wide' ) {
			$t_width = '4';
			$m_width = '8';
			if( $pod_embed_style == "center" ) {
				$m_width = '10';
				$t_width = '12';
			}
		} elseif( $pod_embed_widths == 'full'  ) {
			$t_width = '4';
			$m_width = '8';
			if( $pod_embed_style == "center" ) {
				$m_width = '12';
				$t_width = '12';
			}
		}

		if( $width_type == "t-width" ) {
			return $t_width;
		} elseif ( $width_type == "m-width" ) {
			return $m_width;
		}
	}
}

if( ! function_exists( 'pod_embed_text_alignment' ) ) {
	function pod_embed_text_alignment($post_id="") {
		$pod_featured_header_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		$pod_slideshow_in_post = pod_theme_option( 'pod-featured-header-slides-in-post', false );
		$align = '';

		if( $pod_featured_header_type == 'static' ) {
			$pod_featured_header_alignment = pod_theme_option( 'pod-audio-player-aligment', 'fh-audio-player-left' );
			$pod_featured_header_alignment_output = str_replace( "fh-audio-player-", "", $pod_featured_header_alignment );
			$pod_embed_alignment = $pod_featured_header_alignment_output;

			$align = 'align-' . $pod_embed_alignment;

		} elseif( $pod_featured_header_type == 'static-posts' ) {
			$align_from_post = get_post_meta( $post_id, 'cmb_thst_feature_post_align', true );
			$align_from_post = str_replace( array( "text-align:", ";" ), array( "", "" ), $align_from_post );
			$align = 'align-' . $align_from_post;

		} elseif( $pod_featured_header_type == 'slideshow' ) {
			/* TO DO: Global alignment */
			$align_from_post = pod_theme_option( 'pod-slideshow-global-alignment' );	

			if( $pod_slideshow_in_post == false ) {
				$align_from_post = get_post_meta( $post_id, 'cmb_thst_feature_post_align', true );
			}

			$align_from_post = str_replace( array( "text-align:", ";" ), array( "", "" ), $align_from_post );
			$align = 'align-' . $align_from_post;

		} else {
			$align = '';

		}

		return $align;
	}
}


if( ! function_exists( 'pod_embed_text_raw_alignment' ) ) {
	function pod_embed_text_raw_alignment( $post_id ) {
		$pod_featured_header_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		$pod_slideshow_in_post = pod_theme_option( 'pod-featured-header-slides-in-post', false );
		
		$align_raw = '';

		/* Text Alignment (Raw) */
		if( $pod_featured_header_type == 'static' ) {
			$pod_featured_header_alignment = pod_theme_option( 'pod-audio-player-aligment', 'fh-audio-player-left' );
			$pod_featured_header_alignment_output = str_replace( "fh-audio-player-", "", $pod_featured_header_alignment );
			$pod_embed_alignment = $pod_featured_header_alignment_output;
			$align_raw = $pod_embed_alignment;

		} elseif( $pod_featured_header_type == 'static-posts') {
			$align_from_raw_post = get_post_meta( $post_id, 'cmb_thst_feature_post_align', true );
			$align_from_raw_post = str_replace( array( "text-align:", ";" ), array( "", "" ), $align_from_raw_post );
			$align_raw = $align_from_raw_post;

		} elseif( $pod_featured_header_type == 'slideshow' ) {
			$align_from_raw_post = pod_theme_option( 'pod-slideshow-global-alignment' );	

			if( $pod_slideshow_in_post == false ) {
				$align_from_raw_post = get_post_meta( $post_id, 'cmb_thst_feature_post_align', true );
			}

			$align_from_raw_post = str_replace( array( "text-align:", ";" ), array( "", "" ), $align_from_raw_post );
			$align_raw = $align_from_raw_post;

		} else {
			$align_raw = '';

		}

		return $align_raw;
	}
}

/**
 * pod_the_embed()
 * Featured embedded content style.
 *
 * @param -
 * @return string $output - Audio or video player.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_the_embed' ) ) {
	function pod_the_embed( $post_id, $heading="", $text="", $multimedia="", $has_media="" ){

		/* Theme Option Values */
		$pod_featured_header_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		$pod_embed_style = pod_theme_option( 'pod-embed-style', 'left' );
		$pod_slideshow_in_post = pod_theme_option( 'pod-featured-header-slides-in-post' );
		$pod_fp_ex = pod_theme_option('pod-frontpage-fetured-ex', true);
		$pod_fp_ex_posi = pod_theme_option( 'pod-frontpage-featured-ex-posi', 'below' );

		// Player settings
		$pod_frontpage_header_show_players = pod_theme_option( 'pod-front-page-media-players-activate', true );
		$pod_frontpage_header_show_players_output = ($pod_frontpage_header_show_players) ? "players-active" : "players-inactive";

		/* TO DO: Handle excerpts for slideshows? */
		$has_excerpt = pod_theme_option( 'pod-slideshow-global-excerpt', true );
		if( $pod_slideshow_in_post == false ) {
			$has_excerpt = get_post_meta( $post_id, 'cmb_thst_feature_post_excerpt', true );
		}

		/* Text Alignment */
		$align = pod_embed_text_alignment($post_id);

		/* Text Alignment (Raw) */
		$align_raw = pod_embed_text_raw_alignment($post_id);

		/* Embed widths */
		$t_width = pod_embed_width( "t-width" );
		$m_width = pod_embed_width( "m-width");

		/* Handles players if turned off*/
		if( $pod_frontpage_header_show_players == false ) {
			$multimedia = '';
		}
		

		$output = '';
		$output .= '<div class="embed-container ' . $pod_frontpage_header_show_players_output . ' embed-alignment-' .$pod_embed_style . ' text-alignment-' . $align_raw . ' header-excerpt-' .$pod_fp_ex_posi. '">';

			if( $pod_frontpage_header_show_players ) {

				if( $pod_embed_style == "center" ) {
					$output .= '<div class="embed-col embed-col-text embed-col-text-heading ' .$align. ' col-lg-' .$t_width. ' video-text heading heading-' .$pod_fp_ex_posi. '">' 
						.$heading;
					$output .= '</div>';

					if(  $pod_fp_ex == true && $pod_fp_ex_posi == "above" ) {
						$output .= '<div class="embed-col embed-col-text embed-col-text ' .$align. ' col-lg-' .$t_width. ' video-text excerpt-' .$pod_fp_ex_posi. ' content">' 
							.$text. 
						'</div>';
					}

					$output .= '<div class="embed-col embed-col-media col-lg-' .$m_width. '">';
						if( $has_media !='' ) {
							$output .= $multimedia;
						}
					$output .= '</div>';
					
					if( $pod_fp_ex == true && $pod_fp_ex_posi == "below" ) {
						$output .= '<div class="embed-col embed-col-text-with-position ' .$align. ' col-lg-' .$t_width. ' video-text excerpt-' .$pod_fp_ex_posi. ' content">'
							.$text. 
						'</div>';
					}
					$output .= pod_front_page_custom_button_container( $post_id );
				} else {
					$output .= '<div class="embed-col embed-col-text col-lg-' .$t_width. '">' 
						. $heading;
						if( $pod_fp_ex == true ) {
							$output .= $text;
						}
						$output .= pod_front_page_custom_button_container( $post_id );
					$output .= '</div>';

					$output .= '<div class="embed-col embed-col-media col-lg-' .$m_width. '">';
						if( $has_media !='' ) {
							$output .= $multimedia;
						}
					$output .= '</div>';
				}
			} else {
				$output .= '<div class="embed-col embed-col-text col-lg-12">' 
					. $heading;
					if( $pod_fp_ex == true ) {
						$output .= $text;
					}

					$output .= pod_front_page_custom_button_container( $post_id );
				$output .= '</div>';

			}



		$output .= '</div>'; // END .embed-container 


		return $output;
	}
}



/**
 * pod_text_the_embed()
 * Featured embedded content style.
 *
 * @param -
 * @return string $output - Audio or video player.
 * @since Podcaster 2.2
 */
if( ! function_exists('pod_text_the_embed' ) ) {
	function pod_text_the_embed( $heading="", $text="", $multimedia="", $has_media="" ){

		/* Theme Option Values */
		$pod_featured_header_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		$pod_embed_style = pod_theme_option( 'pod-embed-style', 'left' );
		$pod_slideshow_in_post = pod_theme_option( 'pod-featured-header-slides-in-post' );
		$pod_fp_ex = pod_theme_option('pod-frontpage-fetured-ex', true);
		$pod_fp_ex_posi = pod_theme_option( 'pod-frontpage-featured-ex-posi', 'below' );

		// Player settings
		$pod_frontpage_header_show_players = pod_theme_option( 'pod-front-page-media-players-activate', true );
		$pod_frontpage_header_show_players_output = ($pod_frontpage_header_show_players) ? "players-active" : "players-inactive";

		/* TO DO: Handle excerpts for slideshows? */
		$has_excerpt = pod_theme_option( 'pod-slideshow-global-excerpt', true );

		/* Text Alignment */
		$align_to = pod_theme_option( "pod-audio-player-aligment", "fh-audio-player-left" );
		$align = 'align-' . str_replace('fh-audio-player-', '', $align_to);

		/* Text Alignment (Raw) */
		$align_raw =  str_replace('fh-audio-player-', '', $align_to);

		/* Embed widths */
		$t_width = pod_embed_width( "t-width" );
		$m_width = pod_embed_width( "m-width");


		/* Handles players if turned off*/
		if( $pod_frontpage_header_show_players == false ) {
			$multimedia = '';
		}
		

		$output = '';
		$output .= '<div class="embed-container ' . $pod_frontpage_header_show_players_output . ' embed-alignment-' .$pod_embed_style . ' text-alignment-' . $align_raw . ' header-excerpt-' .$pod_fp_ex_posi. '">';

			if( $pod_frontpage_header_show_players ) {

				
				if( $pod_embed_style == "center" ) {
					$output .= '<div class="embed-col embed-col-text embed-col-text-heading ' .$align. ' col-lg-' .$t_width. ' video-text heading heading-' .$pod_fp_ex_posi. '">' 
						.$heading;
					$output .= '</div>';

					if(  $pod_fp_ex == true && $pod_fp_ex_posi == "above" ) {
						$output .= '<div class="embed-col embed-col-text embed-col-text ' .$align. ' col-lg-' .$t_width. ' video-text excerpt-' .$pod_fp_ex_posi. ' content">' 
							.$text. 
						'</div>';
					}

					$output .= '<div class="embed-col embed-col-media col-lg-' .$m_width. '">';
						if( $has_media !='' ) {
							$output .= $multimedia;
						}
					$output .= '</div>';
					
					if( $pod_fp_ex == true && $pod_fp_ex_posi == "below" ) {
						$output .= '<div class="embed-col embed-col-text-with-position ' .$align. ' col-lg-' .$t_width. ' video-text excerpt-' .$pod_fp_ex_posi. ' content">'
							.$text. 
						'</div>';
					}

					$output .= pod_front_page_custom_button_container();

				} else {
					$output .= '<div class="embed-col embed-col-text col-lg-' .$t_width. '">' 
						. $heading;
						if( $pod_fp_ex == true ) {
							$output .= $text;
						}
						$output .= pod_front_page_custom_button_container();
					$output .= '</div>';

					$output .= '<div class="embed-col embed-col-media col-lg-' .$m_width. '">';
						if( $has_media !='' ) {
							$output .= $multimedia;
						}
					$output .= '</div>';
				}
			} else {
				$output .= '<div class="embed-col embed-col-text col-lg-12">' 
					. $heading;
					if( $pod_fp_ex == true ) {
						$output .= $text;
					}
					$output .= pod_front_page_custom_button_container();
				$output .= '</div>';

			}

		$output .= '</div> <!-- .embed-container -->'; // END .embed-container 


		return $output;
	}
}



/**
 * pod_get_excerpt()
 * Retrieve an excerpt of a post, by id and filtered for length.
 *
 * @param int $post_id - Id of the post
 * @param int $excerpt_count - word count of excerpt
 * @return string $post_excerpt - Excerpt that has been filtered for length.
 * @see pod_front_page_ep_excerpts()
 * @since 2.3
 */
if( ! function_exists( 'pod_get_excerpt' ) ) {
	function pod_get_excerpt( $post_id, $excerpt_count=55 ) {

		$post_object = get_post( $post_id );
		$post_text_rich = $post_object->post_content;
		$post_excerpt = '';

		if( has_excerpt($post_id) ) {
			//echo "Hello!!!";
			$post_excerpt = get_the_excerpt();
		} else {
			//echo "Bye!!!";
			if( $post_object->post_content ) {
				if( $excerpt_count > 0 ) {
					$post_excerpt = wp_trim_words( $post_text_rich, $excerpt_count );
				}
			} 
		}

		return $post_excerpt;
	}
}



/**
 * pod_featured_excerpt()
 * Display a featured excerpt for the post featured on the front page header.
 *
 * @param - $podt_id - The id of the post being displayed.
 * @return string $post_excerpt - The excerpt.
 * @since 1.8.9
 * @see pod_featured_multimedia(), pod_featured_header_static_posts()*, pod_featured_header_slideshow()*
 */
if( ! function_exists('pod_featured_excerpt' ) ) {
	function pod_featured_excerpt( $post_id = 0 ) {

		// Theme Option Data
		$fheader_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		$pod_excerpt_link = pod_theme_option( 'pod-frontpage-featured-read-more', 'show' );
		
		$pod_ex = pod_theme_option( 'pod-frontpage-fetured-ex', false );
		$pod_ex_posi = pod_theme_option( 'pod-frontpage-featured-ex-posi', 'below' );
		$pod_ex_length = pod_theme_option( 'pod-frontpage-featured-excerpt-length', 35);
		
		$pod_featured_excerpt_style = pod_theme_option( 'pod-frontpage-featured-ex-style', 'style-2' );
		$pod_featured_excerpt_width = pod_theme_option( 'pod-excerpt-width', 'excerpt-full' );

		$post_format = get_post_format( $post_id );

		/* Check the type of header and retrieve excerpt length from post */
		if( $fheader_type == "static" ) {
			$post_excerpt = pod_get_excerpt( $post_id, $pod_ex_length );

		} elseif( $fheader_type == "static-posts" || $fheader_type == "slideshow" ) {
			$has_excerpt = get_post_meta( $post_id, 'cmb_thst_feature_post_excerpt', true);

			if( $has_excerpt ) {
				$excerpt_count = get_post_meta( $post_id, 'cmb_thst_featured_post_excerpt_count', true);
				$excerpt_count = ! empty( $excerpt_count ) ? $excerpt_count : 55;
				$post_excerpt = pod_get_excerpt( $post_id, $excerpt_count );
			} else {
				$post_excerpt = '';
			}

		}
		

		/* Check if the excerpt is empty. */
		if( $pod_ex == false ) {

			$post_excerpt = '';

		} elseif( $post_excerpt == '' ) {

			$post_excerpt = '';
		
		} else {

			/* Check if exceprt link is active. */
			if( $pod_excerpt_link == 'show') {

				$pod_read_more = '<a class="more-link" href="' . get_permalink( $post_id ) . '">' . __('Read More', 'podcaster') . '</a>';

			} else {
				$pod_read_more = '';
			}

			$post_excerpt = '<div class="featured-excerpt ' . $post_format .' ' . $pod_featured_excerpt_style . ' ' . $pod_featured_excerpt_width . ' excerpt-position-' . $pod_ex_posi . '"><p>' . $post_excerpt . ' ' .$pod_read_more . '</p></div>';
		}

		
		
		return $post_excerpt;
	}
}


/**
 * pod_flexible_excerpt()
 * Custom Excerpt Length for the featured header (set in post).
 *
 * @param string $post_id - ID of given post. 
 * @param string $limit - Default value for the excerpt length.
 * @return string $excerpt - Excerpt with length set to custom value.
 * @since 1.5
 * @see not used anywhere
 */
if( ! function_exists('pod_flexible_excerpt') ) {
	function pod_flexible_excerpt($post_id, $limit='25') {
		$post_format = get_post_format($post_id);
		if( $limit == '') $limit = 25;
		$limit = intval($limit);
		$post_object = get_post( $post_id );

		$get_content = $post_object->post_content;
		$excerpt = explode(' ', $get_content, $limit);

		if (count($excerpt)>=$limit) {
		    array_pop($excerpt);
		    $excerpt = implode(" ",$excerpt).' ...';
		} else {
		    $excerpt = implode(" ",$excerpt);
		}	
		
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	  	
	  	return $excerpt;
	}
}


/**
 * pod_featured_multimedia()
 * Featured multimedia for the front page.
 *
 * @param string $post_id - ID of given post. 
 * @return string $excerpt - Audio or video player.
 * @since Podcaster 1.5
 */
if( ! function_exists( 'pod_featured_multimedia' ) ) {
	function pod_featured_multimedia( $post_id='' ) {
		global $post;
		
		$plugin_inuse = pod_get_plugin_active();

		/* Theme Option Settings */
		$fheader_type = pod_theme_option( 'pod-featured-header-type', 'static' );

		$pod_fh_heading = pod_theme_option( 'pod-featured-heading', '' );
		$pod_featured_excerpt = pod_theme_option( 'pod-frontpage-fetured-ex', true );
		$pod_ex_posi = pod_theme_option( 'pod-frontpage-featured-ex-posi', 'below' );
		$pod_excerpt_link = pod_theme_option( 'pod-frontpage-featured-read-more', 'show' );
		$pod_featured_excerpt_style = pod_theme_option( 'pod-frontpage-featured-ex-style', 'style-2' );
		$pod_featured_excerpt_width = pod_theme_option( 'pod-excerpt-width', 'excerpt-full' );
		$pod_players_preload = pod_theme_option('pod-players-preload', 'none');

		/* Post Meta */
		$post_format = get_post_format( $post_id );
		

		// Player settings
		$pod_frontpage_header_show_players = pod_theme_option( 'pod-front-page-media-players-activate', true );


		/* Text Alignment */
		$align = pod_embed_text_alignment($post_id);
		$post_excerpt = pod_featured_excerpt( $post_id );
		$explicit_post = pod_explicit_post( $post_id );

		$output = '';

		$title_output = '';
		if( $pod_fh_heading != ''  || $explicit_post != '' ) {
			$title_output .= '<div class="mini-title-container">';
			$title_output .= '<span class="mini-title">' . $pod_fh_heading . '</span>';
			$title_output .= $explicit_post;
			$title_output .= '</div>';
		}
		$title_output .= '<h2><a href="' . get_permalink() .'">' . get_the_title() . '</a></h2>';

		/* If Seriously Simple Podcasting Plugin is active */
		if( $plugin_inuse == 'ssp' ) {

			$attachment_id = get_post_thumbnail_id( $post->ID );
			$image_attributes = wp_get_attachment_image_src( $attachment_id, 'original' ); // returns an array
			$thumb_back = ! empty( $image_attributes[0] ) ? $image_attributes[0] : '';

			/* Checks for SSP post format/episode type */
			$format = pod_ssp_get_format( $post_id );
			$file = pod_ssp_get_media_file( $post_id );

			if( $file != '' ) {

				if( $format == "video" ) {

					$output .= '<div class="row ' . $align . '">';
						$videoplayer = pod_get_featured_player( $post_id, true );
						$output .= pod_the_embed( $post_id, $title_output, $post_excerpt, $videoplayer, $videoplayer );

					$output .= '</div><!-- .row -->';

				} else {

					$output .= $title_output;										
					
					if ( $pod_ex_posi == 'above' ) { 
						$output .= $post_excerpt;
					}

					if( $pod_frontpage_header_show_players ) {
						$output .=  pod_get_featured_player( $post_id, true );

					}
					
					if ( $pod_ex_posi == 'below' ) { 
						$output .= $post_excerpt;
					}

					$output .= pod_front_page_custom_button_container( $post_id );
				}
			} else {
				$output .= $title_output;
			}
			

		/* If BluBrry PowerPress Plugin is active */
		} elseif( $plugin_inuse == 'bpp'){
			$bpp_settings = get_option('powerpress_general');
			$bpp_disable_appearance = isset( $bpp_settings['disable_appearance'] ) ? $bpp_settings['disable_appearance'] : false;
			
			if( $post_format == "video" ) {

				$videoplayer = pod_get_featured_player( $post_id, true );
				$output .= '<div class="row ' . $align . '">';
					$output .= pod_the_embed( $post_id, $title_output, $post_excerpt, $videoplayer, true );
				$output .= '</div><!-- .row -->';

			} else {	

				$explicit_post = pod_explicit_post( $post_id );

				if( $pod_fh_heading != '' || $explicit_post != '' ){
					$output .= '<div class="mini-title-container">';
					$output .= '<span class="mini-title">' . $pod_fh_heading . '</span>';
					$output .= $explicit_post;
					$output .= '</div>';
				}
				
				$output .= '<h2><a href="' . get_permalink() .'">' . get_the_title() . '</a></h2>';										
				
				if ( $pod_ex_posi == 'above' ) { 
					$output .= $post_excerpt;
				}

				if( $pod_frontpage_header_show_players ) {
					$output .= pod_get_featured_player( $post_id, true );

				}

				if ( $pod_ex_posi == 'below' ) { 
					$output .= $post_excerpt;
				}

				$output .= pod_front_page_custom_button_container( $post_id );
			}

		/* If Podcaster Media is active */
		} else {
			
			/* If a the post format is "audio" */
			if( $post_format == 'audio' ){

				$audiotype = get_post_meta( $post_id, 'cmb_thst_audio_type', true );
				$audiocapt = get_post_meta( $post_id, 'cmb_thst_audio_capt', true );
				$audioex = get_post_meta( $post_id, 'cmb_thst_audio_explicit', true );

				if( $audiotype == 'audio-url' ) {
					$audioplayer = pod_get_featured_player( $post_id, true );

					$output .= $title_output;

					if ( $pod_ex_posi == 'above' ) { 
						$output .= $post_excerpt;
					}
						if( $pod_frontpage_header_show_players ) {
							$output .= $audioplayer;
						}

					if ( $pod_ex_posi == 'below' ) { 
						$output .= $post_excerpt;
					}

					$output .= pod_front_page_custom_button_container( $post_id );

				/* If a the featured audio type is *.mp3 playlist */
				} elseif( $audiotype == 'audio-embed-url' || $audiotype == 'audio-embed-code' || $audiotype == 'audio-playlist' ) {
					$audioplayer = pod_get_featured_player( $post_id );
					$output .= '<div class="row">' . pod_the_embed( $post_id, $title_output, $post_excerpt, $audioplayer, $audioplayer ). '</div>';
				} else {
					$output .= $title_output;
					$output .= $post_excerpt;
					$output .= pod_front_page_custom_button_container( $post_id );
				}
				
			/* If a the post format is "video" */
			} elseif( $post_format == 'video' ) {

				$post_object = get_post( $post_id );
				$post_text_rich = $post_object->post_content;

				$videotype = get_post_meta( $post->ID, 'cmb_thst_video_type', true );
				$videocapt = get_post_meta( $post_id, 'cmb_thst_video_capt', true );
				$videoex = get_post_meta( $post_id, 'cmb_thst_video_explicit', true );

				$output .= '<div class="row ' . $align . '">';

					if( $videotype == 'video-oembed' || $videotype == 'video-url' || $videotype == 'video-playlist' || $videotype == 'video-embed-url' ) {
						$videoplayer = pod_get_featured_player( $post_id );
						$output .= pod_the_embed( $post_id, $title_output, $post_excerpt, $videoplayer, $videoplayer );

					} else {
						$output .= pod_the_embed( $post_id, $title_output, $post_excerpt, '', '' );

					}
				$output .= '</div>';

			/* If the post format is neither audio nor video */
			} else {
				$pod_fh_heading = pod_theme_option('pod-featured-heading', 'Featured Episode');
				
				$output .= '<div class="row">
					<div class="col-lg-12">';

						if( $pod_fh_heading != '' ) { 
							$output .= '<div class="mini-title-container">
								<span class="mini-title">' . $pod_fh_heading . '</span>
							</div>';
						}

						$output .= '<h2><a href="' . get_permalink( $post_id ) . '">' . get_the_title( $post_id ) . '</a></h2>';
						$output .= $post_excerpt;
					$output .= '</div>
				</div>';
			
			}
		}

		

		return $output;
	}
}

/**
 * pod_has_featured_header_posts()
 * Check to find out if posts are being/have been selected to be featured.
 *
 * @param - 
 * @return boolean - whether or not the query has posts.
 * @since Podcaster 1.8.9
 */
if( ! function_exists( 'pod_has_featured_header_posts' ) ){
	function pod_has_featured_header_posts() {
		$plugin_inuse = pod_get_plugin_active();
		
		// Check for static post featured posts
		$arch_category = pod_theme_option( 'pod-recordings-category', '' );
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';
		$pod_fh_content = pod_theme_option( 'pod-featured-header-content', 'newest' );
		$header_type = pod_theme_option('pod-featured-header-type', 'static');

		$is_featured = '';

		if( ( $header_type == "static-posts"  || $header_type == "slideshow" ) && $pod_fh_content == 'featured' ){
			$is_featured = array(
				array(
					'key' => 'cmb_thst_feature_post',
					'value' => 'on',
				)
			);
		} 

		if( $plugin_inuse == 'ssp' ) {
			$pod_cat = pod_ssp_active_cats( "default" );
			$ssp_cat = pod_ssp_active_cats( "ssp" );

			$ssp_post_types = ssp_post_types();
			$args = array(
				'posts_per_page'   => 1,
				'post_type'        => $ssp_post_types,
				'meta_query'	   => $is_featured,
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $pod_cat,
					),
					array(
						'taxonomy' => 'series',
						'field'    => 'term_id',
						'terms'    => $ssp_cat,
					),
				),
			);
		} else {
			$args = array(
				'posts_per_page'   => 1,
				'cat'         => $arch_category,
				'post_type'        => 'post',
				'meta_query'	   => $is_featured,
			);
		}
		$the_query = new WP_Query( $args );
		
		return $the_query->have_posts();		
	}
}

/**
 * pod_has_featured_header_posts_img()
 * Check to find out if posts are being/have been selected to be featured also have featured images set.
 *
 * @param - 
 * @return boolean - whether or not the posts have an image set.
 * @since Podcaster 1.8.9
 */
if( ! function_exists( 'pod_has_featured_header_posts_img' ) ){
	function pod_has_featured_header_posts_img() {
		$plugin_inuse = pod_get_plugin_active();
		
		// Check for static post featured posts
		$arch_category = pod_theme_option( 'pod-recordings-category', '' );
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';
		$pod_fh_content = pod_theme_option( 'pod-featured-header-content', 'newest' );
		$header_type = pod_theme_option('pod-featured-header-type', 'static');

		$is_featured = '';

		if( ( $header_type == "static-posts"  || $header_type == "slideshow" ) && $pod_fh_content == 'featured' ){
			$is_featured = array(
				array(
					'key' => 'cmb_thst_feature_post',
					'value' => 'on',
					)
				);
		} 

		if( $plugin_inuse == 'ssp' ) {
			$pod_cat = pod_ssp_active_cats( "default" );
			$ssp_cat = pod_ssp_active_cats( "ssp" );

			$ssp_post_types = ssp_post_types();
			$args = array(
				'posts_per_page'   => 1,
				'post_type'        => $ssp_post_types,
				'meta_query'	   => $is_featured,
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $pod_cat,
					),
					array(
						'taxonomy' => 'series',
						'field'    => 'term_id',
						'terms'    => $ssp_cat,
					),
				),
			);
		} else {
			$args = array(
				'posts_per_page'   => 1,
				'cat'         => $arch_category,
				'post_type'        => 'post',
				'meta_query'	   => $is_featured,
			);
		}
		$the_query = new WP_Query( $args );

		return $the_query->have_posts();		
	}
}

/**
 * pod_has_featured_image()
 * Checks if post has a featured image set.
 *
 * @return string $output - custom class depending on whether post has a featured image or not.
 */
if( ! function_exists('pod_has_featured_image') ) {
	function pod_has_featured_image() {
		$plugin_inuse = pod_get_plugin_active();


	
		// Check for posts
		$check_fh_posts = pod_has_featured_header_posts();
		$check_fh_posts_img = pod_has_featured_header_posts_img();


		$audio_header_type = pod_theme_option('pod-single-header-display', 'has-thumbnail');
		$video_bg_active = pod_theme_option('pod-single-video-bg', false);
		$gradient_active = pod_theme_option('pod-fh-bg-mode', 'background-solid');
		$gradient_active_val = pod_theme_option('pod-fh-bg-mode', 'background-solid');
		$gradient_active = ( $gradient_active_val == "background-gradient" ) ? true : false;

		$output = '';


		if( is_front_page() && ! is_home() ) {

			/* Used on Front Page */
			$header_type = pod_theme_option('pod-featured-header-type', 'static');
			$header_bg_active = pod_theme_option('pod-frontpage-header-bg-activate', false);
			$paged_static = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;


			if( $header_type == "text" || $header_type == "static" ) {
				$header_from_page = pod_theme_option( 'pod-page-image', false );

				$featured_header_img = pod_theme_option('pod-upload-frontpage-header');
				$featured_header_img_url = ! empty( $featured_header_img['url'] ) ? $featured_header_img['url'] : '';

				// Check if image is being loaded from featured image of page
				if( $header_from_page ) {
					$page_id = get_the_ID();
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $page_id ), '' );
					$featured_header_img_url = ! empty( $image[0] ) ? $image[0] : '';
				}


				if( ( ( ( $featured_header_img_url != '' && $check_fh_posts )  && $header_bg_active ) || $gradient_active ) && $paged_static == 1 ) {
					$output = 'has-featured-image';
				} else {
					$output = 'no-featured-image';
				}

			} elseif( $header_type == "static-posts" || $header_type == "slideshow" && $paged_static == 1 ) {

				if( ( $check_fh_posts && $check_fh_posts_img && $header_bg_active ) || $gradient_active ) {
					$output = 'has-featured-image';
				} else {
					$output = 'no-featured-image';
				}
			} elseif( $header_type == "video-bg" ) {
				$header_video_bg_active = pod_theme_option('pod-frontpage-header-bg-video-activate', true);
				$featured_header_video = pod_theme_option('pod-upload-frontpage-header-video-file');
				$featured_header_video_url = ! empty( $featured_header_video['url'] ) ? $featured_header_video['url'] : '';

				if( ( ( ( $featured_header_video_url != '' && $check_fh_posts ) && $header_video_bg_active) || $gradient_active ) && $paged_static == 1 ) {
					$output = 'has-featured-image';
				} else {
					$output = 'no-featured-image';
				}
			}

		} elseif ( ! is_front_page() && is_home() ) {

			/* Used on Blog Page */
			$blog_header_img = pod_theme_option('pod-blog-header');
			$blog_header_img_active = ! empty( $blog_header_img['url'] ) ? true : false;

			if( $blog_header_img_active ) {
				$output = 'has-featured-image';
			} else {
				$output = 'no-featured-image';
			}

		} elseif( is_single() ) {

			$post_id = get_the_ID();
			$format = get_post_format( $post_id );

			// Check for SSP format
			if( $plugin_inuse == "ssp" ) {
				$format = pod_ssp_get_format( $post_id );
			}

			/* Used on Single Page*/
			if( $format == "video" && $video_bg_active == true ) {

				if( has_post_thumbnail( $post_id ) ) {
					$output = 'has-featured-image';
				} else {
					$output = 'no-featured-image';
				}

			} elseif( $format == "audio" && $audio_header_type == 'has-background' ) {

				if( has_post_thumbnail( $post_id ) ){
					$output = 'has-featured-image';
				} else {
					$output = 'no-featured-image';
				}

			} else {
				$output = 'no-featured-image';
			}
		} elseif( is_page() ) {

			$post_id = get_the_ID();

			if( is_page_template( 'page/page-podcastarchive-grid.php' ) || is_page_template( 'page/page-podcastarchive-list.php' ) || is_page_template( 'page/page-podcastarchive-grid-classic.php' ) || is_page_template( 'page/page-podcastarchive-list-classic.php' ) ) {

				$pod_archive_img_use = get_post_meta( $post_id, 'cmb_thst_podcast_image_use', true);
				$pod_archive_img_use = ($pod_archive_img_use == "") ? 'pod-archive-img-thumbnail' : $pod_archive_img_use;

				if( has_post_thumbnail( $post_id ) && $pod_archive_img_use == "pod-archive-img-thumbnail" ){
					$output = ' no-featured-image has-featured-thumbnail-image';
				} elseif( has_post_thumbnail( $post_id ) && $pod_archive_img_use == "pod-archive-img-background" ){
					$output = ' has-featured-image has-featured-thumbnail-image';
				} else {
					$output = ' no-featured-image no-featured-thumbnail-image';
				}

			} else {

				if( has_post_thumbnail( $post_id ) ){
					$output = 'has-featured-image';
				} else {
					$output = 'no-featured-image';
				}

			}
		} else {
			$output = 'no-featured-image';
		}

		return $output;
	}
}


/**
 * pod_featured_header_main_post()
 * Featured header main content.
 *
 * @return string $output - Featured header main content.
 * @since Podcaster 1.8.9
 */
if( ! function_exists('pod_featured_header_main_post') ){
	function pod_featured_header_main_post( $format="", $post_id="", $header_type="" ){

		$main_post_class = '';
		$style = '';
		$format_specific = '';
		$fh_img_art_active = pod_theme_option("pod-featured-header-audio-art-active", false);
		$fh_img_art_is_active = ($fh_img_art_active) ? ' audio-thumbnails-active '  : ' audio-thumbnails-inactive ';
		$fh_img_art_align = pod_theme_option("pod-audio-art-alignment", 'fh-audio-art-left');
		$pod_circle_active = pod_theme_option( 'pod-audio-art-circle-bg-active', false );
		$pod_circle_active_out = ($pod_circle_active == true ) ? "has-shapes" : "no-shapes";

		$has_featured_image = has_post_thumbnail() ? "has-post-thumbnail" : "no-post-thumbnail";

		// Player settings
		$pod_frontpage_header_show_players = pod_theme_option( 'pod-front-page-media-players-activate', true );

		$pod_slideshow_in_post = pod_theme_option( 'pod-featured-header-slides-in-post', false );



		$format = get_post_format( $post_id );
		$plugin_active = pod_get_plugin_active();	

		if( $plugin_active == "ssp" ) {
			$format = pod_ssp_get_format( $post_id );
			if( $format == "audio" ){
				$format_specific = $format . ' audio-url';
			} elseif( $format == "video" ){
				$format_specific = $format;
			}

		} elseif( $plugin_active == "bpp" ) {
			if( $format == "audio" ){
				$format_specific = $format . ' audio-url';
			} elseif( $format == "video" ){
				$format_specific = $format;
			}

		} elseif( $plugin_active == "podm" ) {
			$format_specific = $format . ' ' . pod_get_media_type( $post_id );

		} else {
			if( $format == "audio" ){
				$format_specific = $format . ' audio-url';
			} elseif( $format == "video" ){
				$format_specific = $format;
			}
							
		}


		if( $header_type == "static" ){

			$main_post_class = 'main-featured-post text ';

		} elseif( $header_type == "static-posts" ){
			$main_post_class = 'main-featured-post text';
			$post_align = get_post_meta( $post_id, 'cmb_thst_feature_post_align', true);

			if( $post_align != "" ) {
				$style = 'style="' . esc_html( $post_align ) .'"';
			}

		} elseif( $header_type == "slideshow" ){
			$main_post_class = 'main-featured-post text ';
			$post_align = pod_theme_option( 'pod-slideshow-global-aligment', 'text-align:left' );
			
			if( $pod_slideshow_in_post == false ) {
				$post_align = get_post_meta( $post_id, 'cmb_thst_feature_post_align', true);
			}

			if( $post_align != "" ) {
				$style = 'style="' . esc_html( $post_align ) .'"';
			}

		}

		$output = '';

		if( $fh_img_art_active && $format == "audio" && pod_featured_header_album_art( $post_id ) != '' ){
			$output .= '<div class="main-featured-container ' . esc_attr( $fh_img_art_align ) . ' ' . esc_attr( $has_featured_image ) . ' ' . esc_attr( $pod_circle_active_out) . '">';
		} 

			$output .= '<div class="' . esc_attr( $main_post_class ) . ' ' . esc_attr( $format_specific ) . ' clearfix ' . $fh_img_art_is_active . '"' . $style . '>';	
				$output .= pod_featured_multimedia( $post_id );
			$output .= '</div><!-- .main-featured-posts -->';

		
		if( $fh_img_art_active && $format == "audio" && pod_featured_header_album_art( $post_id ) != '' ) {
			$output .= pod_featured_header_album_art( $post_id );
			$output .= '</div>';

		}


		return $output;

	}
}


if( ! function_exists( 'pod_svg_waves' ) ){
	function pod_svg_waves() {

		$pod_fph_seperator_active = pod_theme_option( 'pod-featured-header-seperator-active', false );
		if( $pod_fph_seperator_active == false) {
			return;
		}

		$pod_fph_seperator_style = pod_theme_option( 'pod-featured-header-seperator-style', 'sep-style-wave-1' );

		$output = '';

		$output .= '<div class="pod-wave ' .$pod_fph_seperator_style. '">';
		$output .= '<div class="divider-wrapper">';


		if( $pod_fph_seperator_style == "sep-style-wave-1" ) {
				$output .= '
					<div class="wave-svg wave-1">
						
							<svg 
				 xmlns="http://www.w3.org/2000/svg"
				 xmlns:xlink="http://www.w3.org/1999/xlink"
				 width="1920px" height="151px">
				<path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
				 d="M0.000,64.000 C0.000,64.000 122.557,5.378 304.000,1.000 C458.231,-2.721 566.324,66.451 770.000,72.000 C900.302,75.550 1019.739,21.495 1154.000,20.000 C1296.402,18.414 1416.278,98.901 1537.000,104.000 C1749.952,112.994 1920.000,50.000 1920.000,50.000 L1920.000,151.000 L0.000,151.000 "/>
				</svg>


				  		</div>
				  		<div class="wave-svg wave-2">
				  			<svg 
				 xmlns="http://www.w3.org/2000/svg"
				 xmlns:xlink="http://www.w3.org/1999/xlink"
				 width="1921px" height="128px">
				<path fill-rule="evenodd"  opacity="0.749" fill="rgb(255, 255, 255)"
				 d="M0.000,3.000 C0.000,3.000 69.350,40.984 128.000,43.000 C189.061,45.099 265.738,-1.031 369.000,1.000 C447.906,2.552 518.216,70.811 612.000,74.000 C712.144,77.405 785.413,0.991 893.000,2.000 C1007.163,3.071 1113.734,76.129 1226.000,82.000 C1308.500,86.314 1382.822,20.928 1458.000,21.000 C1556.861,21.095 1602.341,92.409 1677.000,88.000 C1734.207,84.621 1789.036,19.572 1827.000,14.000 C1874.201,7.072 1921.000,69.000 1921.000,69.000 L1921.000,128.000 C1921.000,128.000 193.159,128.000 17.000,128.000 C7.541,128.000 1.000,128.000 1.000,128.000 "/>
				</svg>
				  		</div>
				  		<div class="wave-svg wave-3">
				  			<svg 
				 xmlns="http://www.w3.org/2000/svg"
				 xmlns:xlink="http://www.w3.org/1999/xlink"
				 width="1920px" height="128px">
				<path fill-rule="evenodd"  opacity="0.4" fill="rgb(255, 255, 255)"
				 d="M1920.000,105.000 C1920.000,105.000 1796.779,50.800 1653.000,44.000 C1596.810,41.342 1467.937,87.230 1399.000,85.000 C1334.194,82.904 1240.556,19.886 1170.000,17.000 C1047.722,11.998 916.381,88.481 793.000,87.000 C721.737,86.144 640.001,4.811 573.000,1.000 C445.315,-6.263 334.374,68.893 241.000,72.000 C61.040,77.989 0.000,14.000 0.000,14.000 L0.000,128.000 L1920.000,128.000 "/>
				</svg>
				  		</div>';
			} elseif( $pod_fph_seperator_style == "sep-style-gentle-wave" ) {
				$output .= '<div class="wave-svg wave-1"><svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="1906px" height="160px">
		<path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
		 d="M-0.000,22.000 C-0.000,22.000 140.946,-4.604 407.000,1.000 C704.193,7.260 1113.002,106.177 1404.000,125.000 C1663.391,141.778 1906.000,105.000 1906.000,105.000 L1906.000,159.000 L1.000,160.000 "/>
		</svg></div>';
		$output .= '<div class="wave-svg wave-2"><svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="1906px" height="160px">
		<path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
		 d="M-0.000,22.000 C-0.000,22.000 140.946,-4.604 407.000,1.000 C704.193,7.260 1113.002,106.177 1404.000,125.000 C1663.391,141.778 1906.000,105.000 1906.000,105.000 L1906.000,159.000 L1.000,160.000 "/>
		</svg></div>';
			} elseif( $pod_fph_seperator_style == "sep-style-wave-2" ) {
				$output .= '<div class="wave-svg wave-1">
					<svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="2000px" height="37px">
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M-0.000,15.000 C-0.000,15.000 10.854,-0.026 25.000,0.000 C40.847,0.029 58.218,30.005 75.000,30.000 C89.862,29.995 100.000,14.997 100.000,15.000 L100.000,37.000 L-0.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M100.000,15.000 C100.000,15.000 110.854,-0.026 125.000,0.000 C140.847,0.029 158.218,30.005 175.000,30.000 C189.862,29.995 200.000,14.997 200.000,15.000 L200.000,37.000 L100.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M200.000,15.000 C200.000,15.000 210.854,-0.026 225.000,0.000 C240.847,0.029 258.218,30.005 275.000,30.000 C289.862,29.995 300.000,14.997 300.000,15.000 L300.000,37.000 L200.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M300.000,15.000 C300.000,15.000 310.854,-0.026 325.000,0.000 C340.847,0.029 358.218,30.005 375.000,30.000 C389.862,29.995 400.000,14.997 400.000,15.000 L400.000,37.000 L300.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M400.000,15.000 C400.000,15.000 410.854,-0.026 425.000,0.000 C440.847,0.029 458.218,30.005 475.000,30.000 C489.862,29.995 500.000,14.997 500.000,15.000 L500.000,37.000 L400.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M500.000,15.000 C500.000,15.000 510.854,-0.026 525.000,0.000 C540.847,0.029 558.218,30.005 575.000,30.000 C589.862,29.995 600.000,14.997 600.000,15.000 L600.000,37.000 L500.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M600.000,15.000 C600.000,15.000 610.854,-0.026 625.000,0.000 C640.847,0.029 658.218,30.005 675.000,30.000 C689.862,29.995 700.000,14.997 700.000,15.000 L700.000,37.000 L600.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M700.000,15.000 C700.000,15.000 710.854,-0.026 725.000,0.000 C740.847,0.029 758.218,30.005 775.000,30.000 C789.862,29.995 800.000,14.997 800.000,15.000 L800.000,37.000 L700.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M800.000,15.000 C800.000,15.000 810.854,-0.026 825.000,0.000 C840.847,0.029 858.218,30.005 875.000,30.000 C889.862,29.995 900.000,14.997 900.000,15.000 L900.000,37.000 L800.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M900.000,15.000 C900.000,15.000 910.854,-0.026 925.000,0.000 C940.847,0.029 958.218,30.005 975.000,30.000 C989.862,29.995 1000.000,14.997 1000.000,15.000 L1000.000,37.000 L900.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1000.000,15.000 C1000.000,15.000 1010.854,-0.026 1025.000,0.000 C1040.847,0.029 1058.218,30.005 1075.000,30.000 C1089.862,29.995 1100.000,14.997 1100.000,15.000 L1100.000,37.000 L1000.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1100.000,15.000 C1100.000,15.000 1110.854,-0.026 1125.000,0.000 C1140.847,0.029 1158.218,30.005 1175.000,30.000 C1189.862,29.995 1200.000,14.997 1200.000,15.000 L1200.000,37.000 L1100.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1200.000,15.000 C1200.000,15.000 1210.854,-0.026 1225.000,0.000 C1240.847,0.029 1258.218,30.005 1275.000,30.000 C1289.862,29.995 1300.000,14.997 1300.000,15.000 L1300.000,37.000 L1200.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1300.000,15.000 C1300.000,15.000 1310.854,-0.026 1325.000,0.000 C1340.847,0.029 1358.218,30.005 1375.000,30.000 C1389.862,29.995 1400.000,14.997 1400.000,15.000 L1400.000,37.000 L1300.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1400.000,15.000 C1400.000,15.000 1410.854,-0.026 1425.000,0.000 C1440.847,0.029 1458.218,30.005 1475.000,30.000 C1489.862,29.995 1500.000,14.997 1500.000,15.000 L1500.000,37.000 L1400.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1500.000,15.000 C1500.000,15.000 1510.854,-0.026 1525.000,0.000 C1540.847,0.029 1558.218,30.005 1575.000,30.000 C1589.862,29.995 1600.000,14.997 1600.000,15.000 L1600.000,37.000 L1500.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1600.000,15.000 C1600.000,15.000 1610.854,-0.026 1625.000,0.000 C1640.847,0.029 1658.218,30.005 1675.000,30.000 C1689.862,29.995 1700.000,14.997 1700.000,15.000 L1700.000,37.000 L1600.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1700.000,15.000 C1700.000,15.000 1710.854,-0.026 1725.000,0.000 C1740.847,0.029 1758.218,30.005 1775.000,30.000 C1789.862,29.995 1800.000,14.997 1800.000,15.000 L1800.000,37.000 L1700.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1800.000,15.000 C1800.000,15.000 1810.854,-0.026 1825.000,0.000 C1840.847,0.029 1858.218,30.005 1875.000,30.000 C1889.862,29.995 1900.000,14.997 1900.000,15.000 L1900.000,37.000 L1800.000,37.000 "/>
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1900.000,15.000 C1900.000,15.000 1910.854,-0.026 1925.000,0.000 C1940.847,0.029 1958.218,30.005 1975.000,30.000 C1989.862,29.995 2000.000,14.997 2000.000,15.000 L2000.000,37.000 L1900.000,37.000 "/>
		</svg>
				</div>';
				$output .= '<div class="wave-svg wave-2">
					<svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="2000px" height="37px">
		<path fill-rule="evenodd"  fill="rgb(31, 206, 222)"
		 d="M1900.000,37.000 L1800.000,37.000 L1700.000,37.000 L1600.000,37.000 L1500.000,37.000 L1400.000,37.000 L1300.000,37.000 L1200.000,37.000 L1100.000,37.000 L1000.000,37.000 L900.000,37.000 L800.000,37.000 L700.000,37.000 L600.000,37.000 L500.000,37.000 L400.000,37.000 L300.000,37.000 L200.000,37.000 L100.000,37.000 L0.000,37.000 L0.000,15.000 C0.000,15.000 10.854,-0.026 25.000,0.000 C40.847,0.029 58.218,30.005 75.000,30.000 C89.862,29.995 100.000,14.997 100.000,15.000 C100.000,15.000 110.854,-0.026 125.000,0.000 C140.847,0.029 158.218,30.005 175.000,30.000 C189.862,29.995 200.000,14.997 200.000,15.000 C200.000,15.000 210.854,-0.026 225.000,0.000 C240.847,0.029 258.218,30.005 275.000,30.000 C289.862,29.995 300.000,14.997 300.000,15.000 C300.000,15.000 310.854,-0.026 325.000,0.000 C340.847,0.029 358.218,30.005 375.000,30.000 C389.862,29.995 400.000,14.997 400.000,15.000 C400.000,15.000 410.854,-0.026 425.000,0.000 C440.847,0.029 458.218,30.005 475.000,30.000 C489.862,29.995 500.000,14.997 500.000,15.000 C500.000,15.000 510.854,-0.026 525.000,0.000 C540.847,0.029 558.218,30.005 575.000,30.000 C589.862,29.995 600.000,14.997 600.000,15.000 C600.000,15.000 610.854,-0.026 625.000,0.000 C640.847,0.029 658.218,30.005 675.000,30.000 C689.862,29.995 700.000,14.997 700.000,15.000 C700.000,15.000 710.854,-0.026 725.000,0.000 C740.847,0.029 758.218,30.005 775.000,30.000 C789.862,29.995 800.000,14.997 800.000,15.000 C800.000,15.000 810.854,-0.026 825.000,0.000 C840.847,0.029 858.218,30.005 875.000,30.000 C889.862,29.995 900.000,14.997 900.000,15.000 C900.000,15.000 910.854,-0.026 925.000,0.000 C940.847,0.029 958.218,30.005 975.000,30.000 C989.862,29.995 1000.000,14.997 1000.000,15.000 C1000.000,15.000 1010.854,-0.026 1025.000,0.000 C1040.847,0.029 1058.218,30.005 1075.000,30.000 C1089.862,29.995 1100.000,14.997 1100.000,15.000 C1100.000,15.000 1110.854,-0.026 1125.000,0.000 C1140.847,0.029 1158.218,30.005 1175.000,30.000 C1189.862,29.995 1200.000,14.997 1200.000,15.000 C1200.000,15.000 1210.854,-0.026 1225.000,0.000 C1240.847,0.029 1258.218,30.005 1275.000,30.000 C1289.862,29.995 1300.000,14.997 1300.000,15.000 C1300.000,15.000 1310.854,-0.026 1325.000,0.000 C1340.847,0.029 1358.218,30.005 1375.000,30.000 C1389.862,29.995 1400.000,14.997 1400.000,15.000 C1400.000,15.000 1410.854,-0.026 1425.000,0.000 C1440.847,0.029 1458.218,30.005 1475.000,30.000 C1489.862,29.995 1500.000,14.997 1500.000,15.000 C1500.000,15.000 1510.854,-0.026 1525.000,0.000 C1540.847,0.029 1558.218,30.005 1575.000,30.000 C1589.862,29.995 1600.000,14.997 1600.000,15.000 C1600.000,15.000 1610.854,-0.026 1625.000,0.000 C1640.847,0.029 1658.218,30.005 1675.000,30.000 C1689.862,29.995 1700.000,14.997 1700.000,15.000 C1700.000,15.000 1710.854,-0.026 1725.000,0.000 C1740.847,0.029 1758.218,30.005 1775.000,30.000 C1789.862,29.995 1800.000,14.997 1800.000,15.000 C1800.000,15.000 1810.854,-0.026 1825.000,0.000 C1840.847,0.029 1858.218,30.005 1875.000,30.000 C1889.862,29.995 1900.000,14.997 1900.000,15.000 C1900.000,15.000 1910.854,-0.026 1925.000,0.000 C1940.847,0.029 1958.218,30.005 1975.000,30.000 C1989.862,29.995 2000.000,14.997 2000.000,15.000 L2000.000,37.000 L1900.000,37.000 Z"/>
		</svg>
				</div>';
			} elseif( $pod_fph_seperator_style == "sep-style-wave-3" ) {
				$output .= '<div class="wave-svg wave-1">
					<svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="1969px" height="22px">
		<path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
		 d="M1928.000,22.000 L1927.000,22.000 L1887.000,22.000 L1886.000,22.000 L1846.000,22.000 L1845.000,22.000 L1805.000,22.000 L1804.000,22.000 L1764.000,22.000 L1763.000,22.000 L1723.000,22.000 L1722.000,22.000 L1682.000,22.000 L1681.000,22.000 L1641.000,22.000 L1640.000,22.000 L1600.000,22.000 L1599.000,22.000 L1559.000,22.000 L1558.000,22.000 L1518.000,22.000 L1517.000,22.000 L1477.000,22.000 L1476.000,22.000 L1436.000,22.000 L1435.000,22.000 L1395.000,22.000 L1394.000,22.000 L1354.000,22.000 L1353.000,22.000 L1313.000,22.000 L1312.000,22.000 L1272.000,22.000 L1271.000,22.000 L1231.000,22.000 L1230.000,22.000 L1190.000,22.000 L1189.000,22.000 L1149.000,22.000 L1148.000,22.000 L1108.000,22.000 L1107.000,22.000 L1067.000,22.000 L1066.000,22.000 L1026.000,22.000 L1025.000,22.000 L985.000,22.000 L984.000,22.000 L944.000,22.000 L943.000,22.000 L903.000,22.000 L902.000,22.000 L862.000,22.000 L861.000,22.000 L821.000,22.000 L820.000,22.000 L780.000,22.000 L779.000,22.000 L739.000,22.000 L738.000,22.000 L698.000,22.000 L697.000,22.000 L657.000,22.000 L656.000,22.000 L616.000,22.000 L615.000,22.000 L575.000,22.000 L574.000,22.000 L534.000,22.000 L533.000,22.000 L493.000,22.000 L492.000,22.000 L452.000,22.000 L451.000,22.000 L411.000,22.000 L410.000,22.000 L370.000,22.000 L369.000,22.000 L329.000,22.000 L328.000,22.000 L288.000,22.000 L287.000,22.000 L247.000,22.000 L246.000,22.000 L206.000,22.000 L205.000,22.000 L165.000,22.000 L164.000,22.000 L124.000,22.000 L123.000,22.000 L83.000,22.000 L82.000,22.000 L42.000,22.000 L41.000,22.000 L-0.000,22.000 L-0.000,21.000 C-0.000,9.402 9.402,-0.000 21.000,-0.000 C31.027,-0.000 39.412,7.027 41.500,16.426 C43.588,7.027 51.973,-0.000 62.000,-0.000 C72.027,-0.000 80.412,7.027 82.500,16.426 C84.588,7.027 92.973,-0.000 103.000,-0.000 C113.027,-0.000 121.412,7.027 123.500,16.426 C125.588,7.027 133.973,-0.000 144.000,-0.000 C154.027,-0.000 162.412,7.027 164.500,16.426 C166.588,7.027 174.973,-0.000 185.000,-0.000 C195.027,-0.000 203.412,7.027 205.500,16.426 C207.588,7.027 215.973,-0.000 226.000,-0.000 C236.027,-0.000 244.412,7.027 246.500,16.426 C248.588,7.027 256.973,-0.000 267.000,-0.000 C277.027,-0.000 285.412,7.027 287.500,16.426 C289.588,7.027 297.973,-0.000 308.000,-0.000 C318.027,-0.000 326.412,7.027 328.500,16.426 C330.588,7.027 338.973,-0.000 349.000,-0.000 C359.027,-0.000 367.412,7.027 369.500,16.426 C371.588,7.027 379.973,-0.000 390.000,-0.000 C400.027,-0.000 408.412,7.027 410.500,16.426 C412.588,7.027 420.973,-0.000 431.000,-0.000 C441.027,-0.000 449.412,7.027 451.500,16.426 C453.588,7.027 461.973,-0.000 472.000,-0.000 C482.027,-0.000 490.412,7.027 492.500,16.426 C494.588,7.027 502.973,-0.000 513.000,-0.000 C523.027,-0.000 531.412,7.027 533.500,16.426 C535.588,7.027 543.973,-0.000 554.000,-0.000 C564.027,-0.000 572.412,7.027 574.500,16.426 C576.588,7.027 584.973,-0.000 595.000,-0.000 C605.027,-0.000 613.412,7.027 615.500,16.426 C617.588,7.027 625.973,-0.000 636.000,-0.000 C646.027,-0.000 654.412,7.027 656.500,16.426 C658.588,7.027 666.973,-0.000 677.000,-0.000 C687.027,-0.000 695.412,7.027 697.500,16.426 C699.588,7.027 707.973,-0.000 718.000,-0.000 C728.027,-0.000 736.412,7.027 738.500,16.426 C740.588,7.027 748.973,-0.000 759.000,-0.000 C769.027,-0.000 777.412,7.027 779.500,16.426 C781.588,7.027 789.973,-0.000 800.000,-0.000 C810.027,-0.000 818.412,7.027 820.500,16.426 C822.588,7.027 830.973,-0.000 841.000,-0.000 C851.027,-0.000 859.412,7.027 861.500,16.426 C863.588,7.027 871.973,-0.000 882.000,-0.000 C892.027,-0.000 900.412,7.027 902.500,16.426 C904.588,7.027 912.973,-0.000 923.000,-0.000 C933.027,-0.000 941.412,7.027 943.500,16.426 C945.588,7.027 953.973,-0.000 964.000,-0.000 C974.027,-0.000 982.412,7.027 984.500,16.426 C986.588,7.027 994.973,-0.000 1005.000,-0.000 C1015.027,-0.000 1023.412,7.027 1025.500,16.426 C1027.588,7.027 1035.973,-0.000 1046.000,-0.000 C1056.027,-0.000 1064.412,7.027 1066.500,16.426 C1068.588,7.027 1076.973,-0.000 1087.000,-0.000 C1097.027,-0.000 1105.412,7.027 1107.500,16.426 C1109.588,7.027 1117.973,-0.000 1128.000,-0.000 C1138.027,-0.000 1146.412,7.027 1148.500,16.426 C1150.588,7.027 1158.973,-0.000 1169.000,-0.000 C1179.027,-0.000 1187.412,7.027 1189.500,16.426 C1191.588,7.027 1199.973,-0.000 1210.000,-0.000 C1220.027,-0.000 1228.412,7.027 1230.500,16.426 C1232.588,7.027 1240.973,-0.000 1251.000,-0.000 C1261.027,-0.000 1269.412,7.027 1271.500,16.426 C1273.588,7.027 1281.973,-0.000 1292.000,-0.000 C1302.027,-0.000 1310.412,7.027 1312.500,16.426 C1314.588,7.027 1322.973,-0.000 1333.000,-0.000 C1343.027,-0.000 1351.412,7.027 1353.500,16.426 C1355.588,7.027 1363.973,-0.000 1374.000,-0.000 C1384.027,-0.000 1392.412,7.027 1394.500,16.426 C1396.588,7.027 1404.973,-0.000 1415.000,-0.000 C1425.027,-0.000 1433.412,7.027 1435.500,16.426 C1437.588,7.027 1445.973,-0.000 1456.000,-0.000 C1466.027,-0.000 1474.412,7.027 1476.500,16.426 C1478.588,7.027 1486.973,-0.000 1497.000,-0.000 C1507.027,-0.000 1515.412,7.027 1517.500,16.426 C1519.588,7.027 1527.973,-0.000 1538.000,-0.000 C1548.027,-0.000 1556.412,7.027 1558.500,16.426 C1560.588,7.027 1568.973,-0.000 1579.000,-0.000 C1589.027,-0.000 1597.412,7.027 1599.500,16.426 C1601.588,7.027 1609.973,-0.000 1620.000,-0.000 C1630.027,-0.000 1638.412,7.027 1640.500,16.426 C1642.588,7.027 1650.973,-0.000 1661.000,-0.000 C1671.027,-0.000 1679.412,7.027 1681.500,16.426 C1683.588,7.027 1691.973,-0.000 1702.000,-0.000 C1712.027,-0.000 1720.412,7.027 1722.500,16.426 C1724.588,7.027 1732.973,-0.000 1743.000,-0.000 C1753.027,-0.000 1761.412,7.027 1763.500,16.426 C1765.588,7.027 1773.973,-0.000 1784.000,-0.000 C1794.027,-0.000 1802.412,7.027 1804.500,16.426 C1806.588,7.027 1814.973,-0.000 1825.000,-0.000 C1835.027,-0.000 1843.412,7.027 1845.500,16.426 C1847.588,7.027 1855.973,-0.000 1866.000,-0.000 C1876.027,-0.000 1884.412,7.027 1886.500,16.426 C1888.588,7.027 1896.973,-0.000 1907.000,-0.000 C1917.027,-0.000 1925.412,7.027 1927.500,16.426 C1929.588,7.027 1937.973,-0.000 1948.000,-0.000 C1959.598,-0.000 1969.000,9.402 1969.000,21.000 L1969.000,22.000 L1928.000,22.000 Z"/>
		</svg>
				</div>';
			$output .= '<div class="wave-svg wave-2">
					<svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="1969px" height="22px">
		<path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
		 d="M1928.000,22.000 L1927.000,22.000 L1887.000,22.000 L1886.000,22.000 L1846.000,22.000 L1845.000,22.000 L1805.000,22.000 L1804.000,22.000 L1764.000,22.000 L1763.000,22.000 L1723.000,22.000 L1722.000,22.000 L1682.000,22.000 L1681.000,22.000 L1641.000,22.000 L1640.000,22.000 L1600.000,22.000 L1599.000,22.000 L1559.000,22.000 L1558.000,22.000 L1518.000,22.000 L1517.000,22.000 L1477.000,22.000 L1476.000,22.000 L1436.000,22.000 L1435.000,22.000 L1395.000,22.000 L1394.000,22.000 L1354.000,22.000 L1353.000,22.000 L1313.000,22.000 L1312.000,22.000 L1272.000,22.000 L1271.000,22.000 L1231.000,22.000 L1230.000,22.000 L1190.000,22.000 L1189.000,22.000 L1149.000,22.000 L1148.000,22.000 L1108.000,22.000 L1107.000,22.000 L1067.000,22.000 L1066.000,22.000 L1026.000,22.000 L1025.000,22.000 L985.000,22.000 L984.000,22.000 L944.000,22.000 L943.000,22.000 L903.000,22.000 L902.000,22.000 L862.000,22.000 L861.000,22.000 L821.000,22.000 L820.000,22.000 L780.000,22.000 L779.000,22.000 L739.000,22.000 L738.000,22.000 L698.000,22.000 L697.000,22.000 L657.000,22.000 L656.000,22.000 L616.000,22.000 L615.000,22.000 L575.000,22.000 L574.000,22.000 L534.000,22.000 L533.000,22.000 L493.000,22.000 L492.000,22.000 L452.000,22.000 L451.000,22.000 L411.000,22.000 L410.000,22.000 L370.000,22.000 L369.000,22.000 L329.000,22.000 L328.000,22.000 L288.000,22.000 L287.000,22.000 L247.000,22.000 L246.000,22.000 L206.000,22.000 L205.000,22.000 L165.000,22.000 L164.000,22.000 L124.000,22.000 L123.000,22.000 L83.000,22.000 L82.000,22.000 L42.000,22.000 L41.000,22.000 L-0.000,22.000 L-0.000,21.000 C-0.000,9.402 9.402,-0.000 21.000,-0.000 C31.027,-0.000 39.412,7.027 41.500,16.426 C43.588,7.027 51.973,-0.000 62.000,-0.000 C72.027,-0.000 80.412,7.027 82.500,16.426 C84.588,7.027 92.973,-0.000 103.000,-0.000 C113.027,-0.000 121.412,7.027 123.500,16.426 C125.588,7.027 133.973,-0.000 144.000,-0.000 C154.027,-0.000 162.412,7.027 164.500,16.426 C166.588,7.027 174.973,-0.000 185.000,-0.000 C195.027,-0.000 203.412,7.027 205.500,16.426 C207.588,7.027 215.973,-0.000 226.000,-0.000 C236.027,-0.000 244.412,7.027 246.500,16.426 C248.588,7.027 256.973,-0.000 267.000,-0.000 C277.027,-0.000 285.412,7.027 287.500,16.426 C289.588,7.027 297.973,-0.000 308.000,-0.000 C318.027,-0.000 326.412,7.027 328.500,16.426 C330.588,7.027 338.973,-0.000 349.000,-0.000 C359.027,-0.000 367.412,7.027 369.500,16.426 C371.588,7.027 379.973,-0.000 390.000,-0.000 C400.027,-0.000 408.412,7.027 410.500,16.426 C412.588,7.027 420.973,-0.000 431.000,-0.000 C441.027,-0.000 449.412,7.027 451.500,16.426 C453.588,7.027 461.973,-0.000 472.000,-0.000 C482.027,-0.000 490.412,7.027 492.500,16.426 C494.588,7.027 502.973,-0.000 513.000,-0.000 C523.027,-0.000 531.412,7.027 533.500,16.426 C535.588,7.027 543.973,-0.000 554.000,-0.000 C564.027,-0.000 572.412,7.027 574.500,16.426 C576.588,7.027 584.973,-0.000 595.000,-0.000 C605.027,-0.000 613.412,7.027 615.500,16.426 C617.588,7.027 625.973,-0.000 636.000,-0.000 C646.027,-0.000 654.412,7.027 656.500,16.426 C658.588,7.027 666.973,-0.000 677.000,-0.000 C687.027,-0.000 695.412,7.027 697.500,16.426 C699.588,7.027 707.973,-0.000 718.000,-0.000 C728.027,-0.000 736.412,7.027 738.500,16.426 C740.588,7.027 748.973,-0.000 759.000,-0.000 C769.027,-0.000 777.412,7.027 779.500,16.426 C781.588,7.027 789.973,-0.000 800.000,-0.000 C810.027,-0.000 818.412,7.027 820.500,16.426 C822.588,7.027 830.973,-0.000 841.000,-0.000 C851.027,-0.000 859.412,7.027 861.500,16.426 C863.588,7.027 871.973,-0.000 882.000,-0.000 C892.027,-0.000 900.412,7.027 902.500,16.426 C904.588,7.027 912.973,-0.000 923.000,-0.000 C933.027,-0.000 941.412,7.027 943.500,16.426 C945.588,7.027 953.973,-0.000 964.000,-0.000 C974.027,-0.000 982.412,7.027 984.500,16.426 C986.588,7.027 994.973,-0.000 1005.000,-0.000 C1015.027,-0.000 1023.412,7.027 1025.500,16.426 C1027.588,7.027 1035.973,-0.000 1046.000,-0.000 C1056.027,-0.000 1064.412,7.027 1066.500,16.426 C1068.588,7.027 1076.973,-0.000 1087.000,-0.000 C1097.027,-0.000 1105.412,7.027 1107.500,16.426 C1109.588,7.027 1117.973,-0.000 1128.000,-0.000 C1138.027,-0.000 1146.412,7.027 1148.500,16.426 C1150.588,7.027 1158.973,-0.000 1169.000,-0.000 C1179.027,-0.000 1187.412,7.027 1189.500,16.426 C1191.588,7.027 1199.973,-0.000 1210.000,-0.000 C1220.027,-0.000 1228.412,7.027 1230.500,16.426 C1232.588,7.027 1240.973,-0.000 1251.000,-0.000 C1261.027,-0.000 1269.412,7.027 1271.500,16.426 C1273.588,7.027 1281.973,-0.000 1292.000,-0.000 C1302.027,-0.000 1310.412,7.027 1312.500,16.426 C1314.588,7.027 1322.973,-0.000 1333.000,-0.000 C1343.027,-0.000 1351.412,7.027 1353.500,16.426 C1355.588,7.027 1363.973,-0.000 1374.000,-0.000 C1384.027,-0.000 1392.412,7.027 1394.500,16.426 C1396.588,7.027 1404.973,-0.000 1415.000,-0.000 C1425.027,-0.000 1433.412,7.027 1435.500,16.426 C1437.588,7.027 1445.973,-0.000 1456.000,-0.000 C1466.027,-0.000 1474.412,7.027 1476.500,16.426 C1478.588,7.027 1486.973,-0.000 1497.000,-0.000 C1507.027,-0.000 1515.412,7.027 1517.500,16.426 C1519.588,7.027 1527.973,-0.000 1538.000,-0.000 C1548.027,-0.000 1556.412,7.027 1558.500,16.426 C1560.588,7.027 1568.973,-0.000 1579.000,-0.000 C1589.027,-0.000 1597.412,7.027 1599.500,16.426 C1601.588,7.027 1609.973,-0.000 1620.000,-0.000 C1630.027,-0.000 1638.412,7.027 1640.500,16.426 C1642.588,7.027 1650.973,-0.000 1661.000,-0.000 C1671.027,-0.000 1679.412,7.027 1681.500,16.426 C1683.588,7.027 1691.973,-0.000 1702.000,-0.000 C1712.027,-0.000 1720.412,7.027 1722.500,16.426 C1724.588,7.027 1732.973,-0.000 1743.000,-0.000 C1753.027,-0.000 1761.412,7.027 1763.500,16.426 C1765.588,7.027 1773.973,-0.000 1784.000,-0.000 C1794.027,-0.000 1802.412,7.027 1804.500,16.426 C1806.588,7.027 1814.973,-0.000 1825.000,-0.000 C1835.027,-0.000 1843.412,7.027 1845.500,16.426 C1847.588,7.027 1855.973,-0.000 1866.000,-0.000 C1876.027,-0.000 1884.412,7.027 1886.500,16.426 C1888.588,7.027 1896.973,-0.000 1907.000,-0.000 C1917.027,-0.000 1925.412,7.027 1927.500,16.426 C1929.588,7.027 1937.973,-0.000 1948.000,-0.000 C1959.598,-0.000 1969.000,9.402 1969.000,21.000 L1969.000,22.000 L1928.000,22.000 Z"/>
		</svg>
				</div>';
			} elseif( $pod_fph_seperator_style == "sep-style-cloud" ) {
				$output .= '<div class="wave-svg wave-1"><svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="1989px" height="508px">
		<path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
		 d="M1775.500,500.000 C1696.856,500.000 1628.147,457.477 1591.102,394.170 C1573.773,414.273 1548.123,427.000 1519.500,427.000 C1480.391,427.000 1446.831,403.242 1432.464,369.371 C1423.720,421.376 1378.491,461.000 1324.000,461.000 C1271.349,461.000 1227.345,424.006 1216.545,374.594 C1214.066,374.860 1211.550,375.000 1209.000,375.000 C1191.212,375.000 1174.977,368.362 1162.628,357.432 C1157.551,425.418 1100.784,479.000 1031.500,479.000 C977.399,479.000 930.937,446.325 910.750,399.637 C894.150,416.524 871.050,427.000 845.500,427.000 C809.885,427.000 779.025,406.651 763.906,376.947 C733.669,411.310 689.370,433.000 640.000,433.000 C614.693,433.000 590.721,427.295 569.287,417.113 C544.354,459.526 498.256,488.000 445.500,488.000 C410.523,488.000 378.473,475.480 353.575,454.685 C318.788,487.724 271.763,508.000 220.000,508.000 C112.857,508.000 26.000,421.143 26.000,314.000 C26.000,301.661 27.167,289.597 29.373,277.899 C12.084,270.330 0.000,253.080 0.000,233.000 C0.000,220.439 4.732,208.987 12.503,200.315 C4.476,182.524 0.000,162.787 0.000,142.000 C0.000,63.576 63.576,-0.000 142.000,-0.000 C216.605,-0.000 277.767,57.535 283.549,130.653 C326.684,145.604 362.910,175.344 386.155,213.812 C404.242,205.585 424.335,201.000 445.500,201.000 C459.803,201.000 473.613,203.103 486.649,206.998 C510.908,146.069 570.422,103.000 640.000,103.000 C726.323,103.000 797.151,169.293 804.380,253.744 C816.744,247.513 830.711,244.000 845.500,244.000 C875.292,244.000 901.755,258.242 918.463,280.285 C941.401,241.792 983.436,216.000 1031.500,216.000 C1079.120,216.000 1120.827,241.313 1143.903,279.217 C1154.170,253.317 1179.445,235.000 1209.000,235.000 C1230.436,235.000 1249.617,244.638 1262.458,259.814 C1280.022,247.937 1301.201,241.000 1324.000,241.000 C1371.244,241.000 1411.526,270.786 1427.106,312.601 C1436.244,269.967 1474.136,238.000 1519.500,238.000 C1536.060,238.000 1551.621,242.264 1565.156,249.747 C1582.576,149.349 1670.120,73.000 1775.500,73.000 C1893.413,73.000 1989.000,168.587 1989.000,286.500 C1989.000,404.413 1893.413,500.000 1775.500,500.000 Z"/>
		</svg></div>';
				$output .= '<div class="wave-svg wave-2"><svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="1989px" height="508px">
		<path fill-rule="evenodd"  opacity="0.51" fill="rgb(255, 255, 255)"
		 d="M1989.000,233.000 C1989.000,253.080 1976.916,270.330 1959.627,277.899 C1961.833,289.597 1963.000,301.661 1963.000,314.000 C1963.000,421.143 1876.143,508.000 1769.000,508.000 C1717.237,508.000 1670.212,487.724 1635.425,454.685 C1610.527,475.480 1578.477,488.000 1543.500,488.000 C1490.744,488.000 1444.646,459.526 1419.713,417.113 C1398.279,427.295 1374.307,433.000 1349.000,433.000 C1299.630,433.000 1255.331,411.310 1225.094,376.947 C1209.975,406.651 1179.115,427.000 1143.500,427.000 C1117.950,427.000 1094.850,416.524 1078.250,399.637 C1058.063,446.325 1011.601,479.000 957.500,479.000 C888.216,479.000 831.449,425.418 826.372,357.432 C814.023,368.362 797.788,375.000 780.000,375.000 C777.450,375.000 774.934,374.860 772.455,374.594 C761.655,424.006 717.651,461.000 665.000,461.000 C610.509,461.000 565.280,421.376 556.536,369.371 C542.169,403.242 508.609,427.000 469.500,427.000 C440.877,427.000 415.227,414.273 397.898,394.170 C360.853,457.477 292.144,500.000 213.500,500.000 C95.587,500.000 0.000,404.413 0.000,286.500 C0.000,168.587 95.587,73.000 213.500,73.000 C318.880,73.000 406.424,149.349 423.844,249.747 C437.379,242.264 452.940,238.000 469.500,238.000 C514.864,238.000 552.756,269.967 561.894,312.601 C577.474,270.786 617.756,241.000 665.000,241.000 C687.799,241.000 708.978,247.937 726.542,259.814 C739.383,244.638 758.564,235.000 780.000,235.000 C809.555,235.000 834.830,253.317 845.097,279.217 C868.173,241.313 909.880,216.000 957.500,216.000 C1005.564,216.000 1047.599,241.792 1070.537,280.285 C1087.245,258.242 1113.708,244.000 1143.500,244.000 C1158.289,244.000 1172.256,247.513 1184.620,253.744 C1191.849,169.293 1262.677,103.000 1349.000,103.000 C1418.578,103.000 1478.092,146.069 1502.351,206.998 C1515.387,203.103 1529.197,201.000 1543.500,201.000 C1564.665,201.000 1584.758,205.585 1602.845,213.812 C1626.090,175.344 1662.316,145.604 1705.451,130.653 C1711.233,57.535 1772.395,-0.000 1847.000,-0.000 C1925.424,-0.000 1989.000,63.576 1989.000,142.000 C1989.000,162.787 1984.524,182.524 1976.497,200.315 C1984.268,208.987 1989.000,220.439 1989.000,233.000 Z"/>
		</svg></div>';
			} elseif( $pod_fph_seperator_style == "sep-style-zigzag" ) {
				$output .= '<div class="wave-svg wave-1"><svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="1921px" height="22px">
		<path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
		 d="M1920.781,22.000 L1896.781,22.000 L1896.406,22.000 L1872.781,22.000 L1872.406,22.000 L1848.781,22.000 L1848.406,22.000 L1824.781,22.000 L1824.406,22.000 L1800.781,22.000 L1800.406,22.000 L1776.781,22.000 L1776.406,22.000 L1752.781,22.000 L1752.406,22.000 L1728.781,22.000 L1728.406,22.000 L1704.781,22.000 L1704.406,22.000 L1680.781,22.000 L1680.406,22.000 L1656.781,22.000 L1656.406,22.000 L1632.781,22.000 L1632.406,22.000 L1608.781,22.000 L1608.406,22.000 L1584.781,22.000 L1584.406,22.000 L1560.781,22.000 L1560.406,22.000 L1536.781,22.000 L1536.406,22.000 L1512.781,22.000 L1512.406,22.000 L1488.781,22.000 L1488.406,22.000 L1464.781,22.000 L1464.406,22.000 L1440.781,22.000 L1440.406,22.000 L1416.781,22.000 L1416.406,22.000 L1392.781,22.000 L1392.406,22.000 L1368.781,22.000 L1368.406,22.000 L1344.781,22.000 L1344.406,22.000 L1320.781,22.000 L1320.406,22.000 L1296.781,22.000 L1296.406,22.000 L1272.781,22.000 L1272.406,22.000 L1248.781,22.000 L1248.406,22.000 L1224.781,22.000 L1224.406,22.000 L1200.781,22.000 L1200.406,22.000 L1176.781,22.000 L1176.406,22.000 L1152.781,22.000 L1152.406,22.000 L1128.781,22.000 L1128.406,22.000 L1104.781,22.000 L1104.406,22.000 L1080.781,22.000 L1080.406,22.000 L1056.781,22.000 L1056.406,22.000 L1032.781,22.000 L1032.406,22.000 L1008.781,22.000 L1008.406,22.000 L984.781,22.000 L984.406,22.000 L960.781,22.000 L960.406,22.000 L936.781,22.000 L936.406,22.000 L912.781,22.000 L912.406,22.000 L888.781,22.000 L888.406,22.000 L864.781,22.000 L864.406,22.000 L840.781,22.000 L840.406,22.000 L816.781,22.000 L816.406,22.000 L792.781,22.000 L792.406,22.000 L768.781,22.000 L768.406,22.000 L744.781,22.000 L744.406,22.000 L720.781,22.000 L720.406,22.000 L696.781,22.000 L696.406,22.000 L672.781,22.000 L672.406,22.000 L648.781,22.000 L648.406,22.000 L624.781,22.000 L624.406,22.000 L600.781,22.000 L600.406,22.000 L576.781,22.000 L576.406,22.000 L552.781,22.000 L552.406,22.000 L528.781,22.000 L528.406,22.000 L504.781,22.000 L504.406,22.000 L480.781,22.000 L480.406,22.000 L456.781,22.000 L456.406,22.000 L432.781,22.000 L432.406,22.000 L408.781,22.000 L408.406,22.000 L384.781,22.000 L384.406,22.000 L360.781,22.000 L360.406,22.000 L336.781,22.000 L336.406,22.000 L312.781,22.000 L312.406,22.000 L288.781,22.000 L288.406,22.000 L264.781,22.000 L264.406,22.000 L240.781,22.000 L240.406,22.000 L216.781,22.000 L216.406,22.000 L192.781,22.000 L192.406,22.000 L168.781,22.000 L168.406,22.000 L144.781,22.000 L144.406,22.000 L120.781,22.000 L120.406,22.000 L96.781,22.000 L96.406,22.000 L72.781,22.000 L72.406,22.000 L48.781,22.000 L48.406,22.000 L24.781,22.000 L24.406,22.000 L0.406,22.000 L12.594,0.906 L24.594,21.675 L36.594,0.906 L48.594,21.675 L60.594,0.906 L72.594,21.675 L84.594,0.906 L96.594,21.675 L108.594,0.906 L120.594,21.675 L132.594,0.906 L144.594,21.675 L156.594,0.906 L168.594,21.675 L180.594,0.906 L192.594,21.675 L204.594,0.906 L216.594,21.675 L228.594,0.906 L240.594,21.675 L252.594,0.906 L264.594,21.675 L276.594,0.906 L288.594,21.675 L300.594,0.906 L312.594,21.675 L324.594,0.906 L336.594,21.675 L348.594,0.906 L360.594,21.675 L372.594,0.906 L384.594,21.675 L396.594,0.906 L408.594,21.675 L420.594,0.906 L432.594,21.675 L444.594,0.906 L456.594,21.675 L468.594,0.906 L480.594,21.675 L492.594,0.906 L504.594,21.675 L516.594,0.906 L528.594,21.675 L540.594,0.906 L552.594,21.675 L564.594,0.906 L576.594,21.675 L588.594,0.906 L600.594,21.675 L612.594,0.906 L624.594,21.675 L636.594,0.906 L648.594,21.675 L660.594,0.906 L672.594,21.675 L684.594,0.906 L696.594,21.675 L708.594,0.906 L720.594,21.675 L732.594,0.906 L744.594,21.675 L756.594,0.906 L768.594,21.675 L780.594,0.906 L792.594,21.675 L804.594,0.906 L816.594,21.675 L828.594,0.906 L840.594,21.675 L852.594,0.906 L864.594,21.675 L876.594,0.906 L888.594,21.675 L900.594,0.906 L912.594,21.675 L924.594,0.906 L936.594,21.675 L948.594,0.906 L960.594,21.675 L972.594,0.906 L984.594,21.675 L996.594,0.906 L1008.594,21.675 L1020.594,0.906 L1032.594,21.675 L1044.594,0.906 L1056.594,21.675 L1068.594,0.906 L1080.594,21.675 L1092.594,0.906 L1104.594,21.675 L1116.594,0.906 L1128.594,21.675 L1140.594,0.906 L1152.594,21.675 L1164.594,0.906 L1176.594,21.675 L1188.594,0.906 L1200.594,21.675 L1212.594,0.906 L1224.594,21.675 L1236.594,0.906 L1248.594,21.675 L1260.594,0.906 L1272.594,21.675 L1284.594,0.906 L1296.594,21.675 L1308.594,0.906 L1320.594,21.675 L1332.594,0.906 L1344.594,21.675 L1356.594,0.906 L1368.594,21.675 L1380.594,0.906 L1392.594,21.675 L1404.594,0.906 L1416.594,21.675 L1428.594,0.906 L1440.594,21.675 L1452.594,0.906 L1464.594,21.675 L1476.594,0.906 L1488.594,21.675 L1500.594,0.906 L1512.594,21.675 L1524.594,0.906 L1536.594,21.675 L1548.594,0.906 L1560.594,21.675 L1572.594,0.906 L1584.594,21.675 L1596.594,0.906 L1608.594,21.675 L1620.594,0.906 L1632.594,21.675 L1644.594,0.906 L1656.594,21.675 L1668.594,0.906 L1680.594,21.675 L1692.594,0.906 L1704.594,21.675 L1716.594,0.906 L1728.594,21.675 L1740.594,0.906 L1752.594,21.675 L1764.594,0.906 L1776.594,21.675 L1788.594,0.906 L1800.594,21.675 L1812.594,0.906 L1824.594,21.675 L1836.594,0.906 L1848.594,21.675 L1860.594,0.906 L1872.594,21.675 L1884.594,0.906 L1896.594,21.675 L1908.594,0.906 L1920.781,22.000 Z"/>
		</svg></div>';
				$output .= '<div class="wave-svg wave-2"><svg 
		 xmlns="http://www.w3.org/2000/svg"
		 xmlns:xlink="http://www.w3.org/1999/xlink"
		 width="1921px" height="22px">
		<path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
		 d="M1920.781,22.000 L1896.781,22.000 L1896.406,22.000 L1872.781,22.000 L1872.406,22.000 L1848.781,22.000 L1848.406,22.000 L1824.781,22.000 L1824.406,22.000 L1800.781,22.000 L1800.406,22.000 L1776.781,22.000 L1776.406,22.000 L1752.781,22.000 L1752.406,22.000 L1728.781,22.000 L1728.406,22.000 L1704.781,22.000 L1704.406,22.000 L1680.781,22.000 L1680.406,22.000 L1656.781,22.000 L1656.406,22.000 L1632.781,22.000 L1632.406,22.000 L1608.781,22.000 L1608.406,22.000 L1584.781,22.000 L1584.406,22.000 L1560.781,22.000 L1560.406,22.000 L1536.781,22.000 L1536.406,22.000 L1512.781,22.000 L1512.406,22.000 L1488.781,22.000 L1488.406,22.000 L1464.781,22.000 L1464.406,22.000 L1440.781,22.000 L1440.406,22.000 L1416.781,22.000 L1416.406,22.000 L1392.781,22.000 L1392.406,22.000 L1368.781,22.000 L1368.406,22.000 L1344.781,22.000 L1344.406,22.000 L1320.781,22.000 L1320.406,22.000 L1296.781,22.000 L1296.406,22.000 L1272.781,22.000 L1272.406,22.000 L1248.781,22.000 L1248.406,22.000 L1224.781,22.000 L1224.406,22.000 L1200.781,22.000 L1200.406,22.000 L1176.781,22.000 L1176.406,22.000 L1152.781,22.000 L1152.406,22.000 L1128.781,22.000 L1128.406,22.000 L1104.781,22.000 L1104.406,22.000 L1080.781,22.000 L1080.406,22.000 L1056.781,22.000 L1056.406,22.000 L1032.781,22.000 L1032.406,22.000 L1008.781,22.000 L1008.406,22.000 L984.781,22.000 L984.406,22.000 L960.781,22.000 L960.406,22.000 L936.781,22.000 L936.406,22.000 L912.781,22.000 L912.406,22.000 L888.781,22.000 L888.406,22.000 L864.781,22.000 L864.406,22.000 L840.781,22.000 L840.406,22.000 L816.781,22.000 L816.406,22.000 L792.781,22.000 L792.406,22.000 L768.781,22.000 L768.406,22.000 L744.781,22.000 L744.406,22.000 L720.781,22.000 L720.406,22.000 L696.781,22.000 L696.406,22.000 L672.781,22.000 L672.406,22.000 L648.781,22.000 L648.406,22.000 L624.781,22.000 L624.406,22.000 L600.781,22.000 L600.406,22.000 L576.781,22.000 L576.406,22.000 L552.781,22.000 L552.406,22.000 L528.781,22.000 L528.406,22.000 L504.781,22.000 L504.406,22.000 L480.781,22.000 L480.406,22.000 L456.781,22.000 L456.406,22.000 L432.781,22.000 L432.406,22.000 L408.781,22.000 L408.406,22.000 L384.781,22.000 L384.406,22.000 L360.781,22.000 L360.406,22.000 L336.781,22.000 L336.406,22.000 L312.781,22.000 L312.406,22.000 L288.781,22.000 L288.406,22.000 L264.781,22.000 L264.406,22.000 L240.781,22.000 L240.406,22.000 L216.781,22.000 L216.406,22.000 L192.781,22.000 L192.406,22.000 L168.781,22.000 L168.406,22.000 L144.781,22.000 L144.406,22.000 L120.781,22.000 L120.406,22.000 L96.781,22.000 L96.406,22.000 L72.781,22.000 L72.406,22.000 L48.781,22.000 L48.406,22.000 L24.781,22.000 L24.406,22.000 L0.406,22.000 L12.594,0.906 L24.594,21.675 L36.594,0.906 L48.594,21.675 L60.594,0.906 L72.594,21.675 L84.594,0.906 L96.594,21.675 L108.594,0.906 L120.594,21.675 L132.594,0.906 L144.594,21.675 L156.594,0.906 L168.594,21.675 L180.594,0.906 L192.594,21.675 L204.594,0.906 L216.594,21.675 L228.594,0.906 L240.594,21.675 L252.594,0.906 L264.594,21.675 L276.594,0.906 L288.594,21.675 L300.594,0.906 L312.594,21.675 L324.594,0.906 L336.594,21.675 L348.594,0.906 L360.594,21.675 L372.594,0.906 L384.594,21.675 L396.594,0.906 L408.594,21.675 L420.594,0.906 L432.594,21.675 L444.594,0.906 L456.594,21.675 L468.594,0.906 L480.594,21.675 L492.594,0.906 L504.594,21.675 L516.594,0.906 L528.594,21.675 L540.594,0.906 L552.594,21.675 L564.594,0.906 L576.594,21.675 L588.594,0.906 L600.594,21.675 L612.594,0.906 L624.594,21.675 L636.594,0.906 L648.594,21.675 L660.594,0.906 L672.594,21.675 L684.594,0.906 L696.594,21.675 L708.594,0.906 L720.594,21.675 L732.594,0.906 L744.594,21.675 L756.594,0.906 L768.594,21.675 L780.594,0.906 L792.594,21.675 L804.594,0.906 L816.594,21.675 L828.594,0.906 L840.594,21.675 L852.594,0.906 L864.594,21.675 L876.594,0.906 L888.594,21.675 L900.594,0.906 L912.594,21.675 L924.594,0.906 L936.594,21.675 L948.594,0.906 L960.594,21.675 L972.594,0.906 L984.594,21.675 L996.594,0.906 L1008.594,21.675 L1020.594,0.906 L1032.594,21.675 L1044.594,0.906 L1056.594,21.675 L1068.594,0.906 L1080.594,21.675 L1092.594,0.906 L1104.594,21.675 L1116.594,0.906 L1128.594,21.675 L1140.594,0.906 L1152.594,21.675 L1164.594,0.906 L1176.594,21.675 L1188.594,0.906 L1200.594,21.675 L1212.594,0.906 L1224.594,21.675 L1236.594,0.906 L1248.594,21.675 L1260.594,0.906 L1272.594,21.675 L1284.594,0.906 L1296.594,21.675 L1308.594,0.906 L1320.594,21.675 L1332.594,0.906 L1344.594,21.675 L1356.594,0.906 L1368.594,21.675 L1380.594,0.906 L1392.594,21.675 L1404.594,0.906 L1416.594,21.675 L1428.594,0.906 L1440.594,21.675 L1452.594,0.906 L1464.594,21.675 L1476.594,0.906 L1488.594,21.675 L1500.594,0.906 L1512.594,21.675 L1524.594,0.906 L1536.594,21.675 L1548.594,0.906 L1560.594,21.675 L1572.594,0.906 L1584.594,21.675 L1596.594,0.906 L1608.594,21.675 L1620.594,0.906 L1632.594,21.675 L1644.594,0.906 L1656.594,21.675 L1668.594,0.906 L1680.594,21.675 L1692.594,0.906 L1704.594,21.675 L1716.594,0.906 L1728.594,21.675 L1740.594,0.906 L1752.594,21.675 L1764.594,0.906 L1776.594,21.675 L1788.594,0.906 L1800.594,21.675 L1812.594,0.906 L1824.594,21.675 L1836.594,0.906 L1848.594,21.675 L1860.594,0.906 L1872.594,21.675 L1884.594,0.906 L1896.594,21.675 L1908.594,0.906 L1920.781,22.000 Z"/>
		</svg></div>';

		
		}

		$output .= '</div>';

		$output .= '<div class="divider-buffer"></div>';

		$output .= '</div>';

	return $output;
	}
}


/**
 * pod_featured_header_album_art()
 * Featured header album art (pulled from the featured image of a post)
 *
 * @return string $output - Div with image.
 * @since Podcaster 1.9.9
 */
if( ! function_exists( 'pod_featured_header_album_art' ) ) {
	function pod_featured_header_album_art( $post_id ) {

		$output = '';
		$album_art_rounded = pod_theme_option( "pod-audio-art-rounded-corners", "fh-audio-art-no-radius" );
		$pod_display_button = pod_theme_option( "pod-audio-art-play-button-active", false );
		$pod_circle_active = pod_theme_option( 'pod-audio-art-circle-bg-active', false );
		$pod_circle_active_out = ($pod_circle_active == true ) ? "has-shapes" : "no-shapes";

				if( has_post_thumbnail() ) :
					$output .= '<div class="img ' . $album_art_rounded . ' ' . $pod_circle_active_out . '">';

						$output .= '<div class="img-container">';
						$output .= '<a href="' . get_the_permalink( $post_id ) . '">';
							
								$output .= get_the_post_thumbnail( $post_id, "square-large" );
							
						$output .= '</a>';
						$output .= '</div>';

						if( $pod_display_button == true ) {
								$output .= '<a href="' . get_the_permalink() . '"><div class="play-button">
									<a href="' . get_the_permalink() . '"><span class="fa-play fa icon"></span></a>
								</div></a>';
							}

							if( $pod_circle_active == true ) {
								$output .= '<div class="circle-container">';

								$output .= '<div class="circle-1 shape"></div>';
								$output .= '<div class="circle-2 shape"></div>';
								$output .= '<div class="circle-3 shape"></div>';	
								$output .= '</div>';
							}		

					$output .= '</div>';
				endif;

		return $output;
	}
}

/**
 * pod_featured_header_text_album_art()
 * Featured header album art 
 *
 * @return string $output - Div with image.
 * @since Podcaster 2.2
 */
if( ! function_exists( 'pod_featured_header_text_album_art' ) ) {
	function pod_featured_header_text_album_art( $img_url, $url='' ) {

		$output = '';
		$album_art_rounded = pod_theme_option( "pod-audio-art-rounded-corners", "fh-audio-art-no-radius" );
		$pod_display_button = pod_theme_option( "pod-audio-art-play-button-active", false );
		$pod_circle_active = pod_theme_option( 'pod-audio-art-circle-bg-active', false );
		$pod_circle_active_out = ($pod_circle_active == true ) ? "has-shapes" : "no-shapes";

				if( $img_url ) :
					$output .= '<div class="img ' . $album_art_rounded . ' ' . $pod_circle_active_out . '">';

						$output .= '<div class="img-container">';
						$output .= '<a href="' . $url . '">';
				
								$output .= '<img src="' . $img_url . '">';
							
						$output .= '</a>';
						$output .= '</div>';

						if( $pod_display_button == true ) {
								$output .= '<a href="' . $url . '"><div class="play-button">
									<a href="' . $url . '"><span class="fa-play fa icon"></span></a>
								</div></a>';
							}

							if( $pod_circle_active == true ) {
								$output .= '<div class="circle-container">';

								$output .= '<div class="circle-1 shape"></div>';
								$output .= '<div class="circle-2 shape"></div>';
								$output .= '<div class="circle-3 shape"></div>';	
								$output .= '</div>';
							}		

					$output .= '</div>';
				endif;

		return $output;
	}
}

/**
 * pod_featured_header_text()
 * Featured header when set to 'text'.
 *
 * @return string $output - Featured header.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_featured_header_text') ){
	function pod_featured_header_text() {

		$pod_frontpage_bg_color = pod_theme_option('pod-fh-bg', '#24292c');
		$pod_frontpage_bg_active = pod_theme_option('pod-frontpage-header-bg-activate', false);

		$pod_frontpage_header  = pod_theme_option('pod-upload-frontpage-header');
		$pod_frontpage_header_url = isset( $pod_frontpage_header['url'] ) ? $pod_frontpage_header['url'] : '';
		( $pod_frontpage_bg_active == false ) ? $pod_frontpage_header_url = '' : $pod_frontpage_header_url = $pod_frontpage_header_url;

		! empty($pod_frontpage_header_url) ? $header_state = 'has-header' : $header_state = '';

		$pod_fh_text = pod_theme_option('pod-featured-header-text', 'Welcome to Podcaster. Handcrafted WordPress themes for your podcasting project.');
		$pod_fh_blurb = pod_theme_option('pod-featured-header-blurb', 'This is a little blurb you can add to your text.');
		$pod_fh_text_url = pod_theme_option('pod-featured-header-text-url', '');
		$pod_frontpage_bg_style = pod_theme_option('pod-frontpage-bg-style', 'background-repeat:repeat;');
		$pod_next_week = pod_theme_option('pod-frontpage-nextweek', 'show');
		$pod_sub_buttons = pod_theme_option('pod-subscribe-buttons', true);
		$pod_sub_buttons_output = $pod_sub_buttons ? "subscribe-buttons-active" : "subscribe-buttons-inactive";
		$pod_next_week == 'hide' ? $pod_nextweek_state = 'nw-hidden' : $pod_nextweek_state = '';
		$pod_excerpt_width = pod_theme_option('pod-excerpt-width', 'excerpt-full');

		$pod_audio_player_align = pod_theme_option('pod-audio-player-aligment', 'fh-audio-player-left');
		$pod_audio_player_align = str_replace( 'fh-audio-player-', 'fh-alignment-', $pod_audio_player_align );
	
		$output = '';
		$output .= '<div class="front-page-header text ' .$header_state. ' ' .pod_is_nav_sticky(). ' ' .pod_is_nav_transparent(). ' ' . $pod_audio_player_align . ' ' . $pod_excerpt_width . ' ' . $pod_sub_buttons_output . ' ' . $pod_nextweek_state . '" style="background-color:' .$pod_frontpage_bg_color.';">
						' . pod_header_parallax() . '
						<div class="inside">
							<div class="container">
								<div class="row">
									<div class="col-lg-12">	
										<div class="content-text">';
											if(! empty($pod_fh_text_url) ){
												$output .= '<a href="' .$pod_fh_text_url. '">';
											}
												if(! empty($pod_fh_text) ){
													$output .= '<h2>' .$pod_fh_text. '</h2>';
												}
											if(! empty($pod_fh_text_url) ){
												$output .= '</a>';
											}

											if( $pod_fh_blurb != '' ) {
												$output .= '<div class="content-blurb">';
												$output .= $pod_fh_blurb;
												$output .= '</div>';
											}
												$output .= pod_front_page_custom_button_container();
										$output .='</div><!-- .content-text -->';
										if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons == true ) ) { 
										  	$output .= pod_next_week(); 
										}
									$output .= '</div>
								</div>
							</div>
						</div>';
						$output .= pod_svg_waves();
					$output .= '</div>';
		return $output;		
	}
}



/**
 * pod_featured_header_text_with_media()
 * Featured header when set to 'text' + media activated
 *
 * @return string $output - Featured header.
 * @since Podcaster 2.2
 */
if( ! function_exists('pod_featured_header_text_with_media') ){
	function pod_featured_header_text_with_media() {

		$pod_frontpage_bg_color = pod_theme_option('pod-fh-bg', '#24292c');
		$pod_frontpage_bg_active = pod_theme_option('pod-frontpage-header-bg-activate', false);

		$pod_frontpage_header  = pod_theme_option('pod-upload-frontpage-header');
		$pod_frontpage_header_url = isset( $pod_frontpage_header['url'] ) ? $pod_frontpage_header['url'] : '';
		( $pod_frontpage_bg_active == false ) ? $pod_frontpage_header_url = '' : $pod_frontpage_header_url = $pod_frontpage_header_url;

		! empty($pod_frontpage_header_url) ? $header_state = 'has-header' : $header_state = '';

		$pod_fh_text = pod_theme_option('pod-featured-header-text', 'Welcome to Podcaster. Handcrafted WordPress themes for your podcasting project.');
		$pod_fh_blurb = pod_theme_option('pod-featured-header-blurb', 'This is a little blurb you can add to your text.');
		$pod_fh_text_url = pod_theme_option('pod-featured-header-text-url', '');
		$pod_frontpage_bg_style = pod_theme_option('pod-frontpage-bg-style', 'background-repeat:repeat;');
		$pod_next_week = pod_theme_option('pod-frontpage-nextweek');
		$pod_sub_buttons = pod_theme_option('pod-subscribe-buttons', true);
		$pod_sub_buttons_output = $pod_sub_buttons ? "subscribe-buttons-active" : "subscribe-buttons-inactive";
		$pod_excerpt_width = pod_theme_option('pod-excerpt-width', 'excerpt-full');
		$pod_next_week == 'hide' ? $pod_nextweek_state = 'nw-hidden' : $pod_nextweek_state = '';

		$pod_audio_player_align = pod_theme_option('pod-audio-player-aligment', 'fh-audio-player-left');
		$pod_audio_player_align = str_replace( 'fh-audio-player-', 'fh-alignment-', $pod_audio_player_align );

		$pod_frontpage_header_sc = pod_theme_option('pod-embed-soundcloud-player-style', 'fph-sc-classic-player');

		$media_type = pod_theme_option('pod-featured-header-text-media-type', 'audio-player');

		$output = '';
		$output .= '<div class="front-page-header text_static static ' .$header_state. ' ' .pod_is_nav_sticky(). ' ' .pod_is_nav_transparent(). ' ' . $pod_audio_player_align . ' ' . $pod_excerpt_width . ' ' . $pod_sub_buttons_output . ' ' . $pod_frontpage_header_sc . ' ' . $pod_nextweek_state . '" style="background-color:' .$pod_frontpage_bg_color.';">
						' . pod_header_parallax() . '
						<div class="inside">
							<div class="container">
								<div class="row">
									<div class="col-lg-12">';



										if( $media_type == "audio-player" ) {
											$output .= pod_featured_header_text_with_media_audio();
										} elseif( $media_type == "video-player" ) {
											$output .= pod_featured_header_text_with_media_video();
										} elseif( $media_type == "oembed-player" ) {	
													$output .= pod_featured_header_text_with_media_oembed();
										} elseif( $media_type == "embed-code-player" ) {
											$output .= pod_featured_header_text_with_media_embed_code();
										}


										if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons == true ) ) { 
										  	$output .= pod_next_week(); 
										}
									$output .= '</div><!-- .cols- -->
								</div><!-- .row -->
							</div><!--container -->
						</div><!-- .inside -->';
						$output .= pod_svg_waves();
					$output .= '</div><!-- .front-page-header -->';
		return $output;		

	}
}


/**
 * pod_featured_header_text_with_media_text()
 * Inner content of text header with audio player.
 *
 * @return string $output - Inner content
 * @since Podcaster 2.2
 */
if( ! function_exists('pod_featured_header_text_with_media_text') ){
	function pod_featured_header_text_with_media_text() {

		$pod_fh_text = pod_theme_option('pod-featured-header-text', 'Welcome to Podcaster. Handcrafted WordPress themes for your podcasting project.');
		$pod_fh_blurb = pod_theme_option('pod-featured-header-blurb', 'This is a little blurb you can add to your text.');
		
		$pod_fh_text_url = pod_theme_option('pod-featured-header-text-url', '');

		$output = '';

		if(! empty($pod_fh_text_url) ){
			$output .= '<a href="' .$pod_fh_text_url. '">';
		}
			if(! empty($pod_fh_text) ){
				$output .= '<h2>' .$pod_fh_text. '</h2>';
			}
		if(! empty($pod_fh_text_url) ){
			$output .= '</a>';
		}

		if( $pod_fh_blurb != '' ) {
			$output .= '<div class="content-blurb">';
			$output .= $pod_fh_blurb;
			$output .= '</div>';
		}
		$output .= pod_front_page_custom_button_container();

		return $output;
	}
}

/**
 * pod_featured_header_text_with_media_audio()
 * Inner content of text header with audio player.
 *
 * @return string $output - Inner content
 * @since Podcaster 2.2
 */
if( ! function_exists('pod_featured_header_text_with_media_audio') ){
	function pod_featured_header_text_with_media_audio() {

		/* Text */
		$pod_fh_text = pod_theme_option('pod-featured-header-text', 'Welcome to Podcaster. Handcrafted WordPress themes for your podcasting project.');
		$pod_fh_text_out = '<h2>' . $pod_fh_text . '</h2>';
		$pod_fh_blurb = pod_theme_option('pod-featured-header-blurb', 'This is a little blurb you can add to your text.');
		$pod_fh_text_url = pod_theme_option('pod-featured-header-text-url', '');
		/* Excerpt settings */
		$pod_ex_posi = pod_theme_option( 'pod-frontpage-featured-ex-posi', 'below' );
		$pod_featured_excerpt_style = pod_theme_option( 'pod-frontpage-featured-ex-style', 'style-2' );
		$pod_featured_excerpt_width = pod_theme_option( 'pod-excerpt-width', 'excerpt-full' );

		$pod_fh_blurb = '<div class="featured-excerpt audio ' . $pod_featured_excerpt_style . ' ' . $pod_featured_excerpt_width . ' excerpt-position-' . $pod_ex_posi . '"><p>' . $pod_fh_blurb . '</p></div>';
		if( $pod_fh_text_url != '' ){
			$pod_fh_text_out = '<h2><a href="' . $pod_fh_text_url . '">' . $pod_fh_text . '</a></h2>';
		}

		/* Audio file */
		$file = pod_theme_option('pod-featured-header-text-audio-file');
		$file = !empty($file['url']) ? $file['url'] : '';
		$art = pod_theme_option('pod-featured-header-text-audio-art');
		$art_id = !empty($art['id']) ? $art['id'] : '';
		$art = wp_get_attachment_image_src( $art_id, 'square-large' );
		$art = !empty($art['0']) ? $art['0'] : '';

		/* Text Alignment */
		$pod_featured_header_alignment = pod_theme_option( 'pod-audio-player-aligment', 'fh-audio-player-left' );
		$pod_embed_alignment = $pod_featured_header_alignment;
		$align = 'align-' . $pod_embed_alignment;


		$fh_img_art_active = pod_theme_option("pod-featured-header-audio-art-active", false);
		$fh_img_art_align = pod_theme_option("pod-audio-art-alignment", "fh-audio-art-left");
		$fh_img_art_is_active = pod_fph_text_media_post_thumbnail_active();
		$has_featured_image = ($art != '' ) ? "has-post-thumbnail" : "no-post-thumbnail";

		$pod_circle_active = pod_theme_option( 'pod-audio-art-circle-bg-active', false );
		$pod_circle_active_out = ($pod_circle_active == true ) ? "has-shapes" : "no-shapes";

		$main_post_class = 'main-featured-post ' . $fh_img_art_is_active . ' ';
		$format_specific = 'text audio audio-url';
		$style = '';
		$type = ' regular-player ';
		$format = 'audio';

		$pod_players_preload = '';


		$output = '';
		$player = '';


		$output .= '<div class="container front-page-inside">
			<div class="row ' . $align . '">
				<div class="col-lg-12">';


				if( $fh_img_art_active && $art != '' ){
					$output .= '<div class="main-featured-container ' . esc_attr( $fh_img_art_align ) . ' ' . esc_attr( $has_featured_image ) . ' ' . esc_attr( $pod_circle_active_out) . '">';
				} 

					$output .= '<div class="' . esc_attr( $main_post_class ) . ' ' . esc_attr( $format_specific ) . ' clearfix"' . $style . '>';
						
						$output .= $pod_fh_text_out;

						if( $pod_ex_posi == "above" ) {
							$output .= $pod_fh_blurb;
						}

						$output .= '<div class="audio-player-container excerpt-position-' . $pod_ex_posi . '">';

							$output .= '<div class="' . $format . '_player ' . $type . '">';
								$pod_players_preload = pod_theme_option('pod-players-preload', 'none');
								$shortcode_attr = array('src' => $file, 'loop' => '', 'autoplay' => '', 'preload' => $pod_players_preload );
								$player = wp_audio_shortcode( $shortcode_attr );

								$output .= $player;
							$output .= '</div>';

						$output .= '</div>';

						if( $pod_ex_posi == "below" ) {
							$output .= $pod_fh_blurb;
						}

						$output .= pod_front_page_custom_button_container();

					$output .= '</div><!-- .main-featured-posts -->';

				
				if( $fh_img_art_active && $art != '' ) {
					$output .= pod_featured_header_text_album_art( $art, $pod_fh_text_url );
					$output .= '</div>';

				}

				$output .='</div><!-- .col -->';


			$output .='</div><!-- .row -->';
		$output .='</div><!-- .container -->';

		return $output;
	}
}

/**
 * pod_featured_header_text_with_media_video()
 * Inner content of text header with video player.
 *
 * @return string $output - Inner content
 * @since Podcaster 2.2
 */
if( ! function_exists('pod_featured_header_text_with_media_video') ){
	function pod_featured_header_text_with_media_video() {
		/* Text */
		$pod_fh_text = pod_theme_option('pod-featured-header-text', 'Welcome to Podcaster. Handcrafted WordPress themes for your podcasting project.');
		$pod_fh_text_out = '<h2>' . $pod_fh_text . '</h2>';
		$pod_fh_blurb = pod_theme_option('pod-featured-header-blurb', 'This is a little blurb you can add to your text.');
		$pod_fh_text_url = pod_theme_option('pod-featured-header-text-url', '');

		/* Excerpt settings */
		$pod_ex_posi = pod_theme_option( 'pod-frontpage-featured-ex-posi', 'below' );
		$pod_featured_excerpt_style = pod_theme_option( 'pod-frontpage-featured-ex-style', 'style-2' );
		$pod_featured_excerpt_width = pod_theme_option( 'pod-excerpt-width', 'excerpt-full' );

		$pod_fh_blurb = '<div class="featured-excerpt video ' . $pod_featured_excerpt_style . ' ' . $pod_featured_excerpt_width . ' excerpt-position-' . $pod_ex_posi . '"><p>' . $pod_fh_blurb . '</p></div>';

		if( $pod_fh_text_url != '' ){
			$pod_fh_text_out = '<h2><a href="' . $pod_fh_text_url . '">' . $pod_fh_text . '</a></h2>';
		}

		/* Text Alignment */
		$pod_featured_header_alignment = pod_theme_option( 'pod-audio-player-aligment', 'fh-audio-player-left' );
		$pod_embed_alignment = $pod_featured_header_alignment;
		$align = 'align-' . $pod_embed_alignment;
		$embed_align = str_replace('-fh-audio-player', '', $align);

		$main_post_class = 'main-featured-post ';
		$format_specific = 'text video video-url';

		$style = '';


		/* Video player */
		$file = pod_theme_option('pod-featured-header-text-video-file');
		$file = ($file['url']) ? $file['url'] : '';
		$poster = pod_theme_option('pod-featured-header-text-video-poster');
		$poster = !empty($poster['url']) ? $poster['url'] : '';

		$output = '';

			$output .= '<div class="container front-page-inside">
			<div class="row ' . $align . '">';
				$output .= '<div class="col-lg-12">';

				$output .= '<div class="' . esc_attr( $main_post_class ) . ' ' . esc_attr( $format_specific ) . ' clearfix"' . $style . '>';
					$output .= '<div class="row ' . $embed_align . '">';

						$video_shortcode_attr = array( 'src' => $file, 'poster' => $poster );
						$player =  '<div class="video_player">' . wp_video_shortcode( $video_shortcode_attr ) . '</div>';

						$output .= pod_text_the_embed($pod_fh_text_out, $pod_fh_blurb, $player, $player);

					$output .= '</div><!-- .row.align -->';
				$output .= '</div><!-- .main-featured-post -->';

			$output .= '</div><!-- .cols- --> </div><!-- .row.align --> </div><!-- .container -->';


		return $output;
	}
}

/**
 * pod_featured_header_text_with_media_oembed()
 * Inner content of text header with oembed player.
 *
 * @return string $output - Inner content
 * @since Podcaster 2.2
 */
if( ! function_exists('pod_featured_header_text_with_media_oembed') ){
	function pod_featured_header_text_with_media_oembed() {

		/* Text */
		$pod_fh_text = pod_theme_option('pod-featured-header-text', 'Welcome to Podcaster. Handcrafted WordPress themes for your podcasting project.');
		$pod_fh_text_out = '<h2>' . $pod_fh_text . '</h2>';
		$pod_fh_blurb = pod_theme_option('pod-featured-header-blurb', 'This is a little blurb you can add to your text.');
		$pod_fh_text_url = pod_theme_option('pod-featured-header-text-url', '');

		/* Excerpt settings */
		$pod_ex_posi = pod_theme_option( 'pod-frontpage-featured-ex-posi', 'below' );
		$pod_featured_excerpt_style = pod_theme_option( 'pod-frontpage-featured-ex-style', 'style-2' );
		$pod_featured_excerpt_width = pod_theme_option( 'pod-excerpt-width', 'excerpt-full' );
		$format = pod_theme_option('pod-featured-header-text-embed-format', 'audio');
		$pod_fh_blurb = '<div class="featured-excerpt ' . $format . ' ' . $pod_featured_excerpt_style . ' ' . $pod_featured_excerpt_width . ' excerpt-position-' . $pod_ex_posi . '"><p>' . $pod_fh_blurb . '</p></div>';

		if( $pod_fh_text_url != '' ){
			$pod_fh_text_out = '<h2><a href="' . $pod_fh_text_url . '">' . $pod_fh_text . '</a></h2>';
		}


		/* Text Alignment */
		$pod_featured_header_alignment = pod_theme_option( 'pod-audio-player-aligment', 'fh-audio-player-left' );
		$pod_embed_alignment = $pod_featured_header_alignment;
		$align = 'align-' . $pod_embed_alignment;
		$embed_align = str_replace('-fh-audio-player', '', $align);

		
		if( $format == "audio" ) {
			$fh_img_art_is_active = pod_fph_text_media_post_thumbnail_active();
			$format_specific = 'text audio au_oembed';
			$type = 'au_oembed';
		} elseif( $format == "video" ) {
			$fh_img_art_is_active = '';
			$format_specific = 'text video video-oembed';
			$type = '';
		} else {
			$fh_img_art_is_active = '';
			$format_specific = '';
			$type = '';
		}
		
		/* Album Art */
		$art = pod_theme_option('pod-featured-header-text-audio-art');
		$art_id = !empty($art['id']) ? $art['id'] : '';
		$art = wp_get_attachment_image_src( $art_id, 'square-large' );
		$art = !empty($art['0']) ? $art['0'] : '';

		$fh_img_art_active = pod_theme_option("pod-featured-header-audio-art-active", false);
		$fh_img_art_align = pod_theme_option("pod-audio-art-alignment", "fh-audio-art-left");
		$has_featured_image = ($art != '') ? "has-post-thumbnail" : "no-post-thumbnail";
		$pod_circle_active = pod_theme_option( 'pod-audio-art-circle-bg-active', false );
		$pod_circle_active_out = ($pod_circle_active == true ) ? "has-shapes" : "no-shapes";

		$main_post_class = 'main-featured-post ' . $fh_img_art_is_active . ' ';

	
		$style = '';


		/* oEmbed player */
		$oembedplayer = '';
		$oembedurl = pod_theme_option('pod-featured-header-text-oembed', '');
		$file_parts = wp_check_filetype( $oembedurl );
		if( $file_parts["ext"] != '' ) {
			$audioembed ='';
			$oembedplayer = "<p>Please use a valid embed URL. Make sure it doesn't have a file extension, such as *.mp3.</p>";
		} else {
			$oembedplayer .=  '<div class="' . $format . '_player ' . $type . '">';
			$oembedplayer .= wp_oembed_get( $oembedurl );
			$oembedplayer .= '</div>';
		}

		$output = '';

		$output .= '<div class="container front-page-inside">
			<div class="row ' . $align . '">';
				$output .= '<div class="col-lg-12">';

				if( $fh_img_art_active && $format == "audio" &&  pod_featured_header_text_album_art( $art, $pod_fh_text_url ) != '') {
					$output .= '<div class="main-featured-container ' . esc_attr( $fh_img_art_align ) . ' ' . esc_attr( $has_featured_image ) . ' ' . esc_attr( $pod_circle_active_out) . '">';
				}

					$output .= '<div class="' . esc_attr( $main_post_class ) . ' ' . esc_attr( $format_specific ) . ' clearfix"' . $style . '>';
						$output .= '<div class="row ' . $embed_align . '">';

							$output .= '<div class="row">';
								$output .= pod_text_the_embed( $pod_fh_text_out, $pod_fh_blurb, $oembedplayer, $oembedplayer );
							$output .= '</div>';

						$output .= '</div><!-- .row.align -->';
					$output .= '</div><!-- .main-featured-post -->';

				if( $fh_img_art_active && $format == "audio" &&  pod_featured_header_text_album_art( $art, $pod_fh_text_url ) != '' ) {
					$output .= pod_featured_header_text_album_art( $art, $pod_fh_text_url );
					$output .= '</div>';
				}

			$output .= '</div><!-- .cols- --> </div><!-- .row.align --> </div><!-- .container -->';

		return $output;
	}
}

/**
 * pod_featured_header_text_with_media_embed_code()
 * Inner content of text header with oembed player.
 *
 * @return string $output - Inner content
 * @since Podcaster 2.2
 */
if( ! function_exists('pod_featured_header_text_with_media_embed_code') ){
	function pod_featured_header_text_with_media_embed_code() {
		/* Text */
		$pod_fh_text = pod_theme_option('pod-featured-header-text', 'Welcome to Podcaster. Handcrafted WordPress themes for your podcasting project.');
		$pod_fh_text_out = '<h2>' . $pod_fh_text . '</h2>';
		$pod_fh_blurb = pod_theme_option('pod-featured-header-blurb', 'This is a little blurb you can add to your text.');
		$pod_fh_text_url = pod_theme_option('pod-featured-header-text-url', '');

		/* Excerpt settings */
		$pod_ex_posi = pod_theme_option( 'pod-frontpage-featured-ex-posi', 'below' );
		$pod_featured_excerpt_style = pod_theme_option( 'pod-frontpage-featured-ex-style', 'style-2' );
		$pod_featured_excerpt_width = pod_theme_option( 'pod-excerpt-width', 'excerpt-full' );
		$format = pod_theme_option('pod-featured-header-text-embed-format', 'audio');
		$pod_fh_blurb = '<div class="featured-excerpt ' .$format . ' ' . $pod_featured_excerpt_style . ' ' . $pod_featured_excerpt_width . ' excerpt-position-' . $pod_ex_posi . '"><p>' . $pod_fh_blurb . '</p></div>';

		if( $pod_fh_text_url != '' ){
			$pod_fh_text_out = '<h2><a href="' . $pod_fh_text_url . '">' . $pod_fh_text . '</a></h2>';
		}

		/* Text Alignment */
		$pod_featured_header_alignment = pod_theme_option( 'pod-audio-player-aligment', 'fh-audio-player-left' );
		$pod_embed_alignment = $pod_featured_header_alignment;
		$align = 'align-' . $pod_embed_alignment;
		$embed_align = str_replace('-fh-audio-player', '', $align);

		
		if( $format == "audio" ) {
			$fh_img_art_is_active = pod_fph_text_media_post_thumbnail_active();
			$format_specific = 'text audio audio-embed-code';
			$type = 'embed_code';
		} elseif( $format == "video" ) {
			$fh_img_art_is_active = '';
			$format_specific = 'text video video-embed-code';
			$type = '';
		} else {
			$fh_img_art_is_active = '';
			$format_specific = '';
			$type = '';
		}

		$main_post_class = 'main-featured-post ' . $fh_img_art_is_active . ' ';

		/* Album Art */
		$art = pod_theme_option('pod-featured-header-text-audio-art');
		$art_id = !empty($art['id']) ? $art['id'] : '';
		$art = wp_get_attachment_image_src( $art_id, 'square-large' );
		$art = !empty($art['0']) ? $art['0'] : '';

		$fh_img_art_active = pod_theme_option("pod-featured-header-audio-art-active", false);
		$fh_img_art_align = pod_theme_option("pod-audio-art-alignment", "fh-audio-art-left");
		$has_featured_image = ($art != '') ? "has-post-thumbnail" : "no-post-thumbnail";
		$pod_circle_active = pod_theme_option( 'pod-audio-art-circle-bg-active', false );
		$pod_circle_active_out = ($pod_circle_active == true ) ? "has-shapes" : "no-shapes";

		$style = '';


		/* oEmbed player */
		$embedplayer = '';
		
		$embedurl = pod_theme_option('pod-featured-header-text-embed-code', '');
		$embedplayer .=  '<div class="' . $format . '_player ' . $type . '">';
		$embedplayer .= $embedurl;
		$embedplayer .= '</div>';

		$output = '';

		$output .= '<div class="container front-page-inside">
			<div class="row ' . $align . '">';
				$output .= '<div class="col-lg-12">';

				if( $fh_img_art_active && $format == "audio" &&  pod_featured_header_text_album_art( $art, $pod_fh_text_url ) != '') {
					$output .= '<div class="main-featured-container ' . esc_attr( $fh_img_art_align ) . ' ' . esc_attr( $has_featured_image ) . ' ' . esc_attr( $pod_circle_active_out) . '">';
				}

					$output .= '<div class="' . esc_attr( $main_post_class ) . ' ' . esc_attr( $format_specific ) . ' clearfix"' . $style . '>';
						$output .= '<div class="row ' . $embed_align . '">';

							$output .= '<div class="row">';
								$output .= pod_text_the_embed( $pod_fh_text_out, $pod_fh_blurb, $embedplayer, $embedplayer );
							$output .= '</div>';

						$output .= '</div><!-- .row.align -->';
					$output .= '</div><!-- .main-featured-post -->';

				if( $fh_img_art_active && $format == "audio" &&  pod_featured_header_text_album_art( $art, $pod_fh_text_url ) != '' ) {
					$output .= pod_featured_header_text_album_art( $art, $pod_fh_text_url );
					$output .= '</div>';
				}

			$output .= '</div><!-- .cols- --> </div><!-- .row.align --> </div><!-- .container -->';

		return $output;
	}
}


/**
 * pod_featured_header_static()
 * Featured header when set to 'static'.
 *
 * @return string $output - Featured header.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_featured_header_static') ){
	function pod_featured_header_static(){
		//For the custom loop

		$pod_frontpage_bg_active = pod_theme_option('pod-frontpage-header-bg-activate', false);

		/* Page */
		$page_attachment_id = get_post_thumbnail_id();
		$page_img_attributes = wp_get_attachment_image_src( $page_attachment_id, 'original' ); // returns an array
		$page_img_url = ! empty( $page_img_attributes[0] ) ? $page_img_attributes[0] : '';
		( $pod_frontpage_bg_active == false ) ? $page_img_url = '' : $page_img_url = $page_img_url;

		$arch_category = pod_theme_option( 'pod-recordings-category', '' );
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';
		$pod_frontpage_header = pod_theme_option( 'pod-upload-frontpage-header' );
		$pod_frontpage_header_url = isset( $pod_frontpage_header['url'] ) ? $pod_frontpage_header['url'] : '';
		( $pod_frontpage_bg_active == false ) ? $pod_frontpage_header_url = '' : $pod_frontpage_header_url = $pod_frontpage_header_url;

		$pod_frontpage_bg_color = pod_theme_option( 'pod-fh-bg', '#24292c' );
		$pod_frontpage_bg_style = pod_theme_option( 'pod-frontpage-bg-style', 'background-size:cover;' );

		$pod_next_week = pod_theme_option( 'pod-frontpage-nextweek', 'show' );
		$pod_sub_buttons = pod_theme_option( 'pod-subscribe-buttons', true );
		$pod_sub_buttons_output = $pod_sub_buttons ? "subscribe-buttons-active" : "subscribe-buttons-inactive";
		$pod_next_week == 'hide' ? $pod_nextweek_state = 'nw-hidden' : $pod_nextweek_state = '';

		// Player settings
		$pod_frontpage_header_show_players = pod_theme_option( 'pod-front-page-media-players-activate', true );
		$pod_frontpage_header_sc = pod_theme_option('pod-embed-soundcloud-player-style', 'fph-sc-classic-player');

		// Video Settings
		$pod_page_image = pod_theme_option( 'pod-page-image', false );

		// Active Plugins
		$plugin_inuse = pod_get_plugin_active();	

		// Embed Alignment
		$pod_featured_header_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		
		/* Text Alignment */
		if( $pod_featured_header_type == 'static' ) {
			$pod_featured_header_alignment = pod_theme_option( 'pod-audio-player-aligment', 'fh-audio-player-left' );
			$pod_embed_alignment = $pod_featured_header_alignment;

			$align = 'align-' . $pod_embed_alignment;

		} elseif( $pod_featured_header_type == 'static-posts' || $pod_featured_header_type == 'slideshow' ) {
			$align_from_post = get_post_meta( $post_id, 'cmb_thst_feature_post_align', true );
			$align_from_post = str_replace( array( "text-align:", ";" ), array( "", "" ), $align_from_post );
			$align = 'align-' . $align_from_post;

		} else {
			$align = '';

		}
		
		if( $plugin_inuse == 'ssp' ) {
			$pod_cat = pod_ssp_active_cats( "default" );
			$ssp_cat = pod_ssp_active_cats( "ssp" );

			$ssp_post_types = ssp_post_types();
			$args = array(
				'posts_per_page'   => 1,
				'post_type'        => $ssp_post_types,
				'ignore_sticky_posts' => true,
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $pod_cat,
					),
					array(
						'taxonomy' => 'series',
						'field'    => 'term_id',
						'terms'    => $ssp_cat,
					),
				),
			);			
		} else {
			$args = array(
				'posts_per_page'   => 1,
				'cat'         => $arch_category,
				'ignore_sticky_posts' => true,
				'post_type'        => 'post',
			);
		}
		$the_query = new WP_Query( $args );
		$output = '';

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;
				
				$format = get_post_format( $post->ID );
				$plugin_active = pod_get_plugin_active();

				if( $plugin_active == "ssp" ) {
					$format = pod_ssp_get_format( $post->ID );
					if( $format == "audio" ){
						$format .= ' audio-url';
					}

				} elseif( $plugin_active == "bpp" ) {
					if( $format == "audio" ){
						$format .= ' audio-url';
					}

				} elseif( $plugin_active == "podm" ) {
					$format .= ' ' . pod_get_media_type( $post->ID );

				} else {
					if( $format == "audio" ){
						$format .= ' audio-url';
					}		
				}

				$post_title = get_the_title($post->ID);
				$post_permalink = get_permalink($post->ID);

				$output = '<div class="front-page-header static latest-episode front-header ' .pod_is_nav_transparent(). ' ' .pod_is_nav_sticky(). ' ' . $pod_sub_buttons_output . ' ' . $pod_frontpage_header_sc . ' ' . $pod_nextweek_state . '" style="background-color:' .$pod_frontpage_bg_color.';">';

				$output .= pod_loading_spinner();
				$output .= pod_header_parallax();

				if ( $pod_frontpage_header_url != '' || ( $pod_page_image == true && $page_img_url != '' ) ) { 
					$output .= '<div class="translucent">';
				}
				$output .= '<div class="container front-page-inside">
								<div class="row ' . $align . '">
									<div class="col-lg-12">';

									$output .= pod_featured_header_main_post( $format, $post->ID, $pod_featured_header_type );
									  	
									  	if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons == true ) ) { 
									  		$output .= pod_next_week(); 
									  	}
									  	$output .='</div><!-- .col -->';


									$output .='</div><!-- .row -->';
								$output .='</div><!-- .container -->';
					wp_reset_postdata();
					if ( $pod_frontpage_header_url != '' || ( $pod_page_image == true && $page_img_url != '' )  ) {
					$output .= '</div><!-- .translucent -->';
					}

					$output .= pod_svg_waves();

				$output .='</div>';
			}
		}
		return $output;
	}
}


/**
 * pod_featured_header_static_posts()
 * Featured header when set to 'static (posts)'.
 *
 * @return string $output - Featured header.
 * @since Podcaster 1.5
 */
if( ! function_exists( 'pod_featured_header_static_posts' ) ){
	function pod_featured_header_static_posts( $type = 'newest' ) {

		/* Theme Option Values */
		$pod_frontpage_bg_active = pod_theme_option('pod-frontpage-header-bg-activate', false);
		$pod_fh_type = pod_theme_option( 'pod-featured-header-type', 'static' );
		$pod_fh_content = pod_theme_option( 'pod-featured-header-content', 'newest' );
		$pod_fh_heading = pod_theme_option( 'pod-featured-heading', 'Featured Episode' );
		$pod_frontpage_bg_color = pod_theme_option( 'pod-fh-bg', '#24292c' );
		$pod_frontpage_header_sc = pod_theme_option('pod-embed-soundcloud-player-style', 'fph-sc-classic-player');

		if( $pod_fh_content == 'featured' ){
			$is_featured = array(
				array(
					'key' => 'cmb_thst_feature_post',
					'value' => 'on'
					)
				);
		} else {
			$is_featured = '';
		}
		$arch_category = pod_theme_option( 'pod-recordings-category', '' );
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';
		$pod_next_week = pod_theme_option( 'pod-frontpage-nextweek', 'show' );
		$pod_sub_buttons = pod_theme_option( 'pod-subscribe-buttons', true );
		$pod_sub_buttons_output = $pod_sub_buttons ? "subscribe-buttons-active" : "subscribe-buttons-inactive";

		$pod_excerpt_type = pod_theme_option( 'pod-excerpts-type', 'force_excerpt' );
	
		$pod_next_week == 'hide' ? $pod_nextweek_state = 'nw-hidden' : $pod_nextweek_state = '';
		
		$plugin_inuse = pod_get_plugin_active();
		
		if( $plugin_inuse == 'ssp' ) {
			$pod_cat = pod_ssp_active_cats( "default" );
			$ssp_cat = pod_ssp_active_cats( "ssp" );

			$ssp_post_types = ssp_post_types();
			$args = array(
				'posts_per_page'   => 1,
				'post_type'        => $ssp_post_types,
				'meta_query'	   => $is_featured,
				'ignore_sticky_posts' => true,
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $pod_cat,
					),
					array(
						'taxonomy' => 'series',
						'field'    => 'term_id',
						'terms'    => $ssp_cat,
					),
				),
			);
		} else {
			$args = array(
				'posts_per_page'   => 1,
				'cat'         => $arch_category,
				'post_type'        => 'post',
				'meta_query'	   => $is_featured,
				'ignore_sticky_posts' => true,
			);
		}
		$the_query = new WP_Query( $args );
		$output = '';

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;

			/* Post Values */
			$format = get_post_format( $post->ID );

			$plugin_active = pod_get_plugin_active();
			if( $plugin_active == "ssp" ) {
				$format = pod_ssp_get_format( $post->ID );
			}


			$post_title = get_the_title($post->ID);
			$post_permalink = get_permalink($post->ID);
			
			$is_featured = get_post_meta( $post->ID, 'cmb_thst_feature_post', true );
			$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			$featured_img = !empty($featured_img[0]) ? $featured_img[0] : '';
			$header_img = get_post_meta( $post->ID, 'cmb_thst_feature_post_img', true );
	
			
			$bg_style = get_post_meta( $post->ID, 'cmb_thst_page_header_bgstyle', true);
			$has_excerpt = get_post_meta( $post->ID, 'cmb_thst_feature_post_excerpt', true);
			$excerpt_count = get_post_meta( $post->ID, 'cmb_thst_featured_post_excerpt_count', true);
			$post_align = get_post_meta( $post->ID, 'cmb_thst_feature_post_align', true);
			$post_align_output = str_replace( array( "text-align:", ";" ), array( "", "" ), $post_align );


			$bg_parallax = get_post_meta( $post->ID, 'cmb_thst_feature_post_para', true );
			$bg_parallax = ($bg_parallax) ? "on" : "off";


			$header_img_url = ! empty( $header_img ) ? $header_img : $featured_img;
			( $pod_frontpage_bg_active == false ) ? $header_img_url = '' : $header_img_url = $header_img_url;
			! empty( $header_img_url ) ? $header_state = 'has-header' : $header_state = '';

			$output .= '<div class="front-page-header static ' . pod_is_nav_transparent() . ' ' . $type . ' ' . pod_is_nav_sticky() . ' ' . $header_state . ' ' . $pod_nextweek_state .' fh-alignment-' . $post_align_output . ' ' . $pod_sub_buttons_output . ' ' . $pod_frontpage_header_sc . '" style="background-color:' .$pod_frontpage_bg_color.';">';

				$output .= pod_loading_spinner();
				$output .= '<div class="background_image"><div class="parallax parallax_' . $bg_parallax . '" style="background-image: url(' . $header_img_url . '); ' . $bg_style . '"></div></div>';

					$output .= '<div class="inside">
						<div class="container">
							<div class="row">
								<div class="col-lg-12">';

									$output .= pod_featured_header_main_post( $format, $post->ID, $pod_fh_type );

									if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons == true ) ) { $output .= pod_next_week(); }
								$output .= '</div>
							</div>
						</div>
					</div><!-- .inside -->
				<!--</div>-->';
				$output .= pod_svg_waves();
			$output .= '</div>';
			}
		}
		wp_reset_postdata();

		return $output;
	}
}

/**
 * pod_featured_header_slideshow()
 * Featured header when set to 'slideshow'.
 *
 * @return string $output - Featured header.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_featured_header_slideshow') ){
	function pod_featured_header_slideshow() {

		/* Theme Option Values */
		$pod_frontpage_bg_active = pod_theme_option('pod-frontpage-header-bg-activate', false);
		$pod_fh_type = pod_theme_option('pod-featured-header-type', 'static');
		$pod_fh_content = pod_theme_option('pod-featured-header-content', 'newest');
		$pod_fh_heading = pod_theme_option('pod-featured-heading', 'Featured Episode');

		$pod_frontpage_bg_color = pod_theme_option('pod-fh-bg', '#24292c');
		$pod_slideshow_in_post = pod_theme_option( 'pod-featured-header-slides-in-post', false );
		$pod_frontpage_header_sc = pod_theme_option('pod-embed-soundcloud-player-style', 'fph-sc-classic-player');

		/* TO DO: Global slideshow settings */
		$post_align = pod_theme_option( 'pod-slideshow-global-aligment' );
		$post_align_output = str_replace( array( "text-align:", ";" ), array( "", "" ), $post_align );
		$bg_style = pod_theme_option( 'pod-slideshow-global-background-style' );
		$has_excerpt = pod_theme_option( 'pod-slideshow-global-excerpt' );			
		$excerpt_count = pod_theme_option( 'pod-slideshow-global-excerpt-length' );
		$bg_parallax = pod_theme_option( 'pod-slideshow-global-parallax' );
		$bg_parallax = ($bg_parallax) ? "on" : "off";

		if( $pod_fh_content == 'featured' ){
			$is_featured = array(
				array(
					'key' => 'cmb_thst_feature_post',
					'value' => 'on',
					)
				);
		} else {
			$is_featured = '';
		}
		$pod_fh_slides_amount = pod_theme_option( 'pod-featured-header-slides-amount', 5 );
		$pod_fh_slides_arrow_color = pod_theme_option( 'pod-featured-header-slides-arrow-color', 'light-arrows' );
		$arch_category = pod_theme_option( 'pod-recordings-category', '' );
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';
		$pod_next_week = pod_theme_option( 'pod-frontpage-nextweek', 'show' );
		$pod_sub_buttons = pod_theme_option( 'pod-subscribe-buttons', true );
		$pod_sub_buttons_output = $pod_sub_buttons ? "subscribe-buttons-active" : "subscribe-buttons-inactive";
		$pod_excerpt_type = pod_theme_option( 'pod-excerpts-type', 'force_excerpt' );
	
		if( $pod_next_week == 'hide' && $pod_sub_buttons == false ){
			$pod_nextweek_state = 'nw-hidden';
		} else {
			$pod_nextweek_state = '';
		}
		
		$plugin_inuse = pod_get_plugin_active();
		
		if( $plugin_inuse == 'ssp' ) {

			$pod_cat = pod_ssp_active_cats( "default" );
			$ssp_cat = pod_ssp_active_cats( "ssp" );

			$ssp_post_types = ssp_post_types();
			$args = array(
				'posts_per_page'   => $pod_fh_slides_amount,
				'post_type'        => $ssp_post_types,
				'meta_query'	   => $is_featured,
				'ignore_sticky_posts' => true,
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $pod_cat,
					),
					array(
						'taxonomy' => 'series',
						'field'    => 'term_id',
						'terms'    => $ssp_cat,
					),
				),
			);
		} else {
			$args = array(
			'posts_per_page'   => $pod_fh_slides_amount,
			'cat'         => $arch_category,
			'post_type'        => 'post',
			'meta_query'	   => $is_featured,
			'ignore_sticky_posts' => true,
			);
		}
		$the_query = new WP_Query( $args );
		$output = '';

		if ( $the_query->have_posts() ) {
		$output .= '<div class="flexslider-container">';
		$output .= pod_loading_spinner();
			$output .= '<div class="front-page-header slideshow loading_featured flexslider ' . $pod_fh_slides_arrow_color . ' ' . pod_is_nav_transparent() . ' ' . pod_is_nav_sticky() . ' ' . $pod_nextweek_state .' ' . $pod_sub_buttons_output . ' ' . $pod_frontpage_header_sc . '">';

			$output .= '<div class="slides">';
			
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;

				/* Post Values */
				$format = get_post_format( $post->ID );

				$plugin_active = pod_get_plugin_active();
				if( $plugin_active == "ssp" ) {
					$format = pod_ssp_get_format( $post->ID );
				}

				$post_title = get_the_title($post->ID);
				$is_featured = get_post_meta( $post->ID, 'cmb_thst_feature_post', true );
				$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
				$featured_img_url = !empty( $featured_img ) ? $featured_img[0] : '';
				$header_img = get_post_meta( $post->ID, 'cmb_thst_feature_post_img', true );
				$post_permalink = get_permalink($post->ID);


				if( $pod_slideshow_in_post == false ) {
					$post_align = get_post_meta( $post->ID, 'cmb_thst_feature_post_align', true);
					$post_align_output = str_replace( array( "text-align:", ";" ), array( "", "" ), $post_align );
					$bg_style = get_post_meta( $post->ID, 'cmb_thst_page_header_bgstyle', true);
					$has_excerpt = get_post_meta( $post->ID, 'cmb_thst_feature_post_excerpt', true);			
					$excerpt_count = get_post_meta( $post->ID, 'cmb_thst_featured_post_excerpt_count', true);
					$bg_parallax = get_post_meta( $post->ID, 'cmb_thst_feature_post_para', true);
					$bg_parallax = ($bg_parallax) ? "on" : "off";				
				}

				$post_thumbnail_active = pod_fph_post_thumbnail_active( $post->ID );

				$post_object = get_post( $post->ID );
				$post_text_rich = $post_object->post_content;

				$header_img_url = ! empty( $header_img ) ? $header_img : $featured_img_url;
				( $pod_frontpage_bg_active == false ) ? $header_img_url = '' : $header_img_url = $header_img_url;
				! empty( $header_img_url ) ? $header_state = 'has-header' : $header_state = '';

			
				$output .= '<div class="slide ' . $post_thumbnail_active . ' ' . $header_state . ' fh-alignment-' . $post_align_output . '" style="background-color:' .$pod_frontpage_bg_color.';">';

					$output .= '<div class="background_image"><div class="parallax parallax_' . $bg_parallax . '" style="background-image: url(' . $header_img_url . '); ' . $bg_style . '"></div></div>';

						$output .= '<div class="inside inside_parallax_' . $bg_parallax . '">
							<div class="container">
								<div class="row">
									<div class="col-lg-12">';

										$output .= pod_featured_header_main_post( $format, $post->ID, $pod_fh_type );
										
									$output .= '</div>
								</div>
							</div>
						</div><!-- .inside -->';
					if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons ) ) { 
						$output .= pod_next_week(); 
					}
					$output .= '</div><!-- .slide -->';			

				}
			$output .= '</div><!-- .slides -->';
			$output .= '</div>';

			$output .= pod_svg_waves();
		$output .= '</div>';
		} else {
			$output .= '<div class="front-page-header slideshow-empty"><div class="empty-slideshow container">';
			$output .= '<div class="row">';
			$output .= '<div class="col-lg-12">';
			$output .= '<div class="placeholder inside">';
			$output .= '<p>'. __('Please mark your post(s) as featured for them to appear here.', 'podcaster') .'</p>';
			$output .= '</div>';
			if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons ) ) { 
				$output .= pod_next_week(); 
			}
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';

			$output .= pod_svg_waves();

			$output .= '</div>';
		}
		wp_reset_postdata();
		return $output;
	}
}

/**
 * pod_featured_header_video_background()
 * Featured header when set to 'video background'.
 *
 * @return string $output - Featured header.
 * @since Podcaster 2.2
 */
if( ! function_exists('pod_featured_header_video_background') ){
	function pod_featured_header_video_background() {

		/* Theme Option Values */
		$pod_frontpage_vid_bg_active = pod_theme_option('pod-frontpage-header-bg-video-activate', true);

		//$pod_nav_trans = pod_theme_option('pod-nav-bg');
		$pod_fh_type = pod_theme_option('pod-featured-header-type', 'static');
		$pod_fh_content = pod_theme_option('pod-featured-header-content', 'newest');
		$pod_fh_heading = pod_theme_option('pod-featured-heading', 'Featured Episode');
		$pod_next_week = pod_theme_option('pod-frontpage-nextweek', 'show');
		$pod_frontpage_bg_color = pod_theme_option('pod-fh-bg', '#24292c');
		$pod_sub_buttons = pod_theme_option('pod-subscribe-buttons', true);

		//Static Text
		$pod_fh_static_heading = pod_theme_option('pod-featured-header-text', 'Welcome to Podcaster. Handcrafted WordPress themes for your podcasting project.');
		$pod_fh_static_blurb = pod_theme_option('pod-featured-header-blurb', 'This is a little blurb you can add to your text.');
		$pod_fh_static_url = pod_theme_option('pod-featured-header-text-url', '');

		//Video
		$pod_fh_video_file = pod_theme_option('pod-upload-frontpage-header-video-file');
		$pod_fh_video_file_url = ! empty($pod_fh_video_file['url']) ? $pod_fh_video_file['url'] : '';
		$pod_fh_video_file_id = ! empty($pod_fh_video_file['id']) ? $pod_fh_video_file['id'] : '';
		$pod_fh_video_file_poster = wp_get_attachment_image_src($pod_fh_video_file_id, 'slideshow');
		if( ! $pod_fh_video_file_poster ) {
			$pod_fh_video_file_poster = get_the_post_thumbnail_url($pod_fh_video_file_id);
		}
		$pod_fh_video_file_poster_out = 'poster="' . $pod_fh_video_file_poster . '"';

		$pod_fh_video_playpause_button = pod_theme_option('pod-frontpage-header-video-button', true);
		$pod_fh_video_autoplay = pod_theme_option('pod-frontpage-header-video-autoplay', true);
		$pod_fh_video_autoplay_out = ($pod_fh_video_autoplay) ? 'autoplay' : '';
		$pod_fh_video_loop = pod_theme_option('pod-frontpage-header-video-loop', true);
		$pod_fh_video_loop_out = ( $pod_fh_video_loop ) ? 'loop' : '';
		$pod_fh_video_mute = pod_theme_option('pod-frontpage-header-video-mute', true);
		$pod_fh_video_mute_out = ( $pod_fh_video_mute ) ? 'muted' : '';

		$pod_fh_video_parallax = pod_theme_option('pod-frontpage-header-video-par', false);
		$pod_fh_video_parallax_out = ($pod_fh_video_parallax ) ? "parallax_on" : "parallax_off";

		$pod_audio_player_align = pod_theme_option('pod-audio-player-aligment', 'fh-audio-player-left');
		$pod_audio_player_align = str_replace( 'fh-audio-player-', 'fh-alignment-', $pod_audio_player_align );
		$pod_excerpt_width = pod_theme_option('pod-excerpt-width', 'excerpt-full');

		$output = '';

		$output .= '<div class="front-page-header front-page-header-video-background ' . $pod_audio_player_align . ' ' . $pod_fh_video_parallax_out . ' ' . $pod_excerpt_width .'" style="background-color:' .$pod_frontpage_bg_color.';">';
						$output .= '<div class="inside">';

						if( $pod_frontpage_vid_bg_active == true && $pod_fh_video_file_url != '' ) {
							$output .= '<div class="video-bg">
								<div class="screen"></div>
								<video id="videobg" playsinline ' . $pod_fh_video_autoplay_out . ' ' . $pod_fh_video_loop_out . ' ' . $pod_fh_video_mute_out . ' ' . $pod_fh_video_file_poster_out .'>
									<source src="' . $pod_fh_video_file_url . '" type="video/mp4">
									Your browser does not support the video tag.
								</video>
								
							</div>';
						}

							$output .= '<div class="container">
								<div class="row">
									<div class="col-lg-12">	
										<div class="content-text">';

											if( $pod_fh_static_heading != '' || $pod_fh_static_url ) { 
												if( $pod_fh_static_url != '' ) {
													$output .= '<a href="' . $pod_fh_static_url . '">';
												}
													
													if( $pod_fh_static_heading != '' ) {
														$output .= '<h2>' . $pod_fh_static_heading .'</h2>';
													}

												if( $pod_fh_static_url != '' ) {
													$output .= '</a>';
												}
											}

											if( $pod_fh_static_blurb != '' ) {
												$output .= '<div class="content-blurb">';
													$output .= '<p>' . $pod_fh_static_blurb . '</p>';
												$output .= '</div>';
											}

											if( $pod_fh_video_playpause_button == true ){
												$output .= '<div id="video-controls" class="pod-video-bg-controls" data-state="hidden" data-state-button="button-play">
												   <button id="playpause" type="button" data-state="play"><span class="label">Play/Pause</span></button>
												</div>';
											}

											$output .= pod_front_page_custom_button_container();
											
										$output .='</div><!-- .content-text -->';
										
										if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons == true ) ) { 
										  	$output .= pod_next_week(); 
										}
									$output .= '</div>
								</div>
							</div>
						</div>';
						$output .= pod_svg_waves();

					$output .= '</div>';
		return $output;		
	}
}


/**
 * pod_featured_header_container()
 * Filters through selected front page header type and returns it
 *
 * @return string $output - Selected featured header.
 * @since Podcaster 2.2
 */
if( ! function_exists( 'pod_featured_header_container' ) ) {
	function pod_featured_header_container() {

		$pod_fh_type = pod_theme_option('pod-featured-header-type', 'static');
		$pod_fh_t_media = pod_theme_option('pod-featured-header-text-media-activate', false);


		$output = '';
		if( $pod_fh_type == 'slideshow' ) {
			if( function_exists( 'pod_featured_header_slideshow') ) { $output .= pod_featured_header_slideshow(); } 	
		
		} elseif( $pod_fh_type == 'static-posts' ) {
			if( function_exists( 'pod_featured_header_static_posts') ) { $output .= pod_featured_header_static_posts(); }

		} elseif( $pod_fh_type == 'static' ) {
			if( function_exists( 'pod_featured_header_static') ) { $output .= pod_featured_header_static(); }

		} elseif( $pod_fh_type == 'video-bg' ){
			if( function_exists( 'pod_featured_header_video_background' ) ) { $output .= pod_featured_header_video_background(); }
		
		} elseif( $pod_fh_type == 'text' ) {
			if( function_exists( 'pod_featured_header_text') ) { 

				if( $pod_fh_t_media ){
					$output .= pod_featured_header_text_with_media(); 
				} else {
					$output .= pod_featured_header_text(); 
				}
				
			}
		}

		return $output;
	}
}

if( ! function_exists( 'pod_front_page_custom_button_container' ) ) {
	function pod_front_page_custom_button_container($post_id=0) {

		$buttons_active = pod_theme_option('pod-frontpage-header-custom-buttons-activate', false);
		if( $buttons_active != true ) {
			return;
		}

		$button_1_txt = pod_theme_option('pod-featured-header-custom-button-1-text', '');
		$button_1_url = pod_theme_option('pod-featured-header-custom-button-1-url','');
		$button_1_url_type = pod_theme_option('pod-featured-header-custom-button-1-type', 'permalink-url');
		if( $button_1_url_type == "permalink-url" && $post_id != 0 ) {
			$button_1_url =  get_the_permalink($post_id);
		}

		$button_2_txt = pod_theme_option('pod-featured-header-custom-button-2-text', '');
		$button_2_url = pod_theme_option('pod-featured-header-custom-button-2-url', '');
		$button_2_url_type = pod_theme_option('pod-featured-header-custom-button-2-type', 'custom-url');
		if( $button_2_url_type == "permalink-url" && $post_id != 0 ) {
			$button_2_url =  get_the_permalink($post_id);
		}

		$button_1 = pod_front_page_custom_button( $button_1_txt, $button_1_url );
		$button_2 = pod_front_page_custom_button( $button_2_txt, $button_2_url );

		$output = '';
		$output .= '<div class="button-container">';
			$output .= $button_1;
			$output .= $button_2;
		$output .= '</div>';

		return $output;
	}
}


if( ! function_exists( 'pod_front_page_custom_button' ) ) {
	function pod_front_page_custom_button( $text='', $url='' ) {
		if( $text == '' ) {
			return;
		}

		$output = '';
		$output = '<a class="butn medium" href="' . $url . '">' . $text . '</a>';

		return $output;
	}
}

if( ! function_exists( 'pod_fph_post_thumbnail_active' ) ) {
	function pod_fph_post_thumbnail_active( $post_id ) {
		$audio_thumbnail_active = pod_theme_option( 'pod-featured-header-audio-art-active', false );
		$output = '';

		if( $audio_thumbnail_active ) {
			$output .= ' audio-thumbnails-active';
		} else {
			$output .= ' audio-thumbnails-inactive';
		}
		if( has_post_thumbnail( $post_id ) && $audio_thumbnail_active ) {
			$output .= ' has-post-thumbnail ';
		} else {
			$output .= ' no-post-thumbnail ';
		}
		
		return $output;
	}
}

if( ! function_exists( 'pod_fph_text_media_post_thumbnail_active' ) ) {
	function pod_fph_text_media_post_thumbnail_active() {
		$audio_thumbnail_active = pod_theme_option( 'pod-featured-header-audio-art-active', false );
		$art = pod_theme_option('pod-featured-header-text-audio-art');
		$art_id = !empty($art['id']) ? $art['id'] : '';
		$art = wp_get_attachment_image_src( $art_id, 'square-large' );
		$art = !empty($art['0']) ? $art['0'] : '';


		$output = '';

		if( $audio_thumbnail_active ) {
			$output .= ' audio-thumbnails-active';
		} else {
			$output .= ' audio-thumbnails-inactive';
		}
		if( $art && $audio_thumbnail_active ) {
			$output .= ' has-post-thumbnail ';
		} else {
			$output .= ' no-post-thumbnail ';
		}
		
		return $output;
	}
}


/*
 *
 * FRONT PAGE EPISODES
 *-------------------------------------------------------*/

if( ! function_exists( 'pod_front_page_ep_cats' ) ) {
	function pod_front_page_ep_cats( $post_id='' ) {
		$active_plugin = pod_get_plugin_active();
		$pod_display_cats = pod_theme_option( 'pod-front-page-post-categories', true );

		if( ! $pod_display_cats ) {
			return;
		}

		$output = '';
		$output .= '<ul>';
		
		if( $active_plugin == "ssp" ) {
			$ssp_categories = pod_get_ssp_series_cats($post_id, '<li>', '</li>', '</li><li>', true);
			$output .= $ssp_categories;
		} else {
			$categories = get_the_category( $post_id );

			if( has_category() ) {
				if( $categories ) {
					foreach ($categories as $category) {
						$output .= '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
					}
				}
			}
			$output .= '<li>' . pod_explicit_post( $post_id ) . '</li>';

		}
		$output .= '</ul>';

		return $output;
	}
}

if( ! function_exists( 'pod_front_page_ep_excerpts' ) ) {
	function pod_front_page_ep_excerpts( $post_id=0 ) {

		$pod_display_excerpt = pod_theme_option( 'pod-front-page-post-excerpts', true );
		
		if( $pod_display_excerpt != true ) {
			return;
		}

		$pod_ep_excerpt_count = pod_theme_option( 'pod-front-page-post-excerpt-length', 35);
		$pod_excerpt_type = pod_theme_option( 'pod-excerpts-type', 'force_excerpt' );
		$pod_read_more_text = pod_theme_option( 'pod-front-page-read-more-text', 'Read more' );

		$output = '';

		if ( $pod_excerpt_type == 'force_excerpt' || $pod_excerpt_type == '' ) {
			$output .= pod_get_excerpt( $post_id, $pod_ep_excerpt_count );
			$output .= '<a href="' . get_permalink() . '" class="more-link">' . esc_attr( $pod_read_more_text ) . '<span class="meta-nav"></span></a>';
		} elseif ( $pod_excerpt_type == 'set_in_post' ) { 
			global $more;
			$output .= get_the_content( $pod_read_more_text );
		} else {
			$output .= the_content( $pod_read_more_text );
		}

		return $output;
	}
}

if( ! function_exists( 'pod_front_page_episodes_classes' ) ) {
	function pod_front_page_episodes_classes() {
		$pod_excerpt_type = pod_theme_option('pod-excerpts-type', 'force_excerpt');
		$pod_entries_corners = pod_theme_option('pod-front-page-entries-corners', 'entries-round-corners');
		$pod_entries_corners_opts = pod_theme_option('pod-front-page-entries-corners-opts', 'entries-corners-entire');
		$pod_resp_layout = pod_theme_option('pod-responsive-layout', 'fp-resp-grid');
		$pod_sidebar_corners = pod_theme_option('pod-front-page-sidebar-corners');
		$pod_is_sidebar_active = is_active_sidebar( 'sidebar_front' ) ? "pod-is-sidebar-active" : "pod-is-sidebar-inactive";
		$pod_play_icon_style = pod_theme_option( 'pod-front-page-entries-play-button', 'episodes-play-icon-style-1');

		// Get page template
		$pod_fp_id = get_option( 'page_on_front' );
		$pod_fp_current_template = get_page_template_slug( $pod_fp_id );


		$ep_classes = '';
		$classes = array();

		if( $pod_fp_current_template == "page/page-frontpage-left.php" || $pod_fp_current_template == "page/page-frontpage-right.php" ) {
			$classes[] = "front-has-sidebar";
			$classes[] = $pod_sidebar_corners;
			$classes[] = $pod_is_sidebar_active;
		} 
		
		if($pod_fp_current_template == "page/page-frontpage-left.php") {
			$classes[] = "front-sidebar-left";
		} elseif($pod_fp_current_template == "page/page-frontpage-right.php") {
			$classes[] = "front-sidebar-right";
		}

		$classes[] = $pod_excerpt_type;
		$classes[] = $pod_entries_corners;
		$classes[] = $pod_entries_corners_opts;
		$classes[] = $pod_resp_layout;
		$classes[] = $pod_play_icon_style;

		$classes_output = implode(' ', $classes);

		return $classes_output;
	}
}

if( ! function_exists( 'pod_front_page_episodes_cols_cont_classes' ) ) {
	function pod_front_page_episodes_cols_cont_classes() {
		$temp_width = pod_theme_option('pod-general-tempalte-width', 'template-width-fixed');

		$cols = '';

		if( $temp_width == 'template-width-fixed' ) {
			$cols = 'col-lg-8 col-md-8 col-sm-12';
		} elseif( $temp_width == 'template-width-full' ) {
			$cols = 'col-lg-9 col-md-9 col-sm-12';
		}

		return $cols;
	}
}

if( ! function_exists( 'pod_front_page_episodes_cols_side_classes' ) ) {
	function pod_front_page_episodes_cols_side_classes() {
		$temp_width = pod_theme_option('pod-general-tempalte-width', 'template-width-fixed');

		$cols = '';

		if( $temp_width == 'template-width-fixed' ) {
			$cols = 'col-lg-4 col-md-4 ';
		} elseif( $temp_width == 'template-width-full' ) {
			$cols = 'col-lg-3 col-md-3 ';
		}

		return $cols;
	}
}


if( ! function_exists( 'pod_front_page_episodes_query_args' ) ) {
	function pod_front_page_episodes_query_args() {
		$active_plugin = pod_get_plugin_active();
		$pod_fh_type = pod_theme_option('pod-featured-header-type', 'static');
		$featured_content = pod_theme_option('pod-featured-header-content', 'newest');
		$paged_static = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;
		$pod_front_num_posts = pod_theme_option('pod-front-posts', 9);
		$arch_category = pod_theme_option('pod-recordings-category', '');
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';

		if( $pod_fh_type == 'text' || $pod_fh_type == 'video-bg' || $pod_fh_type == 'hide' ){
			$offset = 0;
		} else {
			if( $featured_content == 'featured' && ( $pod_fh_type == 'static-posts' || $pod_fh_type == 'slideshow' )){
				$offset = 0;
			} else {
				$offset = 1;
			}
		}

		$output = '';

		if( $active_plugin == 'ssp' ) {
			$output = pod_front_page_episodes_ssp_query_args($arch_category, $pod_front_num_posts, $offset, $paged_static);
		} else {
			$output = pod_front_page_episodes_general_query_args($arch_category, $pod_front_num_posts, $offset, $paged_static);
		}

		return $output;
	}
}

if( ! function_exists( 'pod_front_page_episodes_general_query_args' ) ) {
	function pod_front_page_episodes_general_query_args($cat='', $num='', $offset='', $paged='') {
		if ( isset( $num ) &&  $cat != '' ) { 
				$args = array( 
					'cat' => $cat, 
					'posts_per_page' =>  $num,
					'paged' => $paged,
					'ignore_sticky_posts' => true,
					'offset' => $offset,
				);
	  	} else { 
	  		$args = array( 
	  			//'cat' => 'uncategorized', 
	  			'posts_per_page' => $num, 
	  			'paged' => $paged,
				'ignore_sticky_posts' => true,
	  			'offset' => $offset,
	  		);
	  	}

	  	return $args;
	}
}

if( ! function_exists( 'pod_front_page_episodes_ssp_query_args' ) ) {
	function pod_front_page_episodes_ssp_query_args($cat='', $num='', $offset='', $paged='') {
		$ssp_arch_category = pod_ssp_active_cats("ssp");
		$ssp_post_types = ssp_post_types();

		$args = array();

		if ( isset( $num ) && ( $ssp_arch_category != '' || $cat != '' ) ) { 
			$args = array( 
				'post_type' => $ssp_post_types,
				'posts_per_page' => $num, 
				'paged' => $paged, 
				'ignore_sticky_posts' => true,
				'offset' => $offset,
				'tax_query' => array(
	                'relation' => 'OR',
	                array(
	                    'taxonomy' => 'category',
	                    'field'    => 'term_id',
	                    'terms'    => $cat,
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
				'posts_per_page' => $num, 
				'paged' => $paged, 
				'ignore_sticky_posts' => true,
				'offset' => $offset,
			);
		}

		return $args;
	}
}

if( ! function_exists( "pod_front_page_episodes_featured_image" ) ) {
	function pod_front_page_episodes_featured_image( $post_id='', $default='square', $legacy=false ) {

		$pod_fp_cols_style = pod_theme_option('pod-front-style','front-page-list');
		$pod_fp_cols_ori = pod_theme_option('pod-front-cols-orientation', 'front-page-cols-square');
		$pod_fp_cols_cols = pod_theme_option('pod-front-style-cols', 'front-page-cols-3');

		$output = '';

		$output .= '<div class="featured-image">';
				
			if( $pod_fp_cols_style == 'front-page-grid' || $pod_fp_cols_style == 'front-page-fit-grid' ) {
				if( $pod_fp_cols_ori == 'front-page-cols-horizontal' ) {
					$output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post_id, "audio-thumb", array( "sizes" => "(max-width:375px) 400px, (max-width:768px) 550px, 700px" ) ) . '</a>';
				
				} elseif( $pod_fp_cols_ori == 'front-page-cols-vertical' ) {
					if( $pod_fp_cols_cols == "front-page-cols-2" ){
						$output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post_id, "audio-thumb-vert-large", array( "sizes" => "(max-width:375px) 400px, (max-width:768px) 550px, 700px" ) ) . '</a>';
					} else {
						$output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post_id, "audio-thumb-2", array( "sizes" => "(max-width:375px) 400px, (max-width:768px) 550px, 700px" ) ) . '</a>';
					}

				} elseif( $pod_fp_cols_ori == 'front-page-cols-square' ) {
					$output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post_id, $default, array( "sizes" => "(max-width:375px) 400px, (max-width:768px) 550px, 700px" ) ) . '</a>';

				}

			} else {
				$output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post_id, $default, array( "sizes" => "(max-width:375px) 400px, (max-width:768px) 550px, 700px" ) ) . '</a>';
			}

			if( $legacy ) {
				$output .= '<div class="hover">
					<a href="' . get_permalink() . '" class="icon">
						<span class="fa fa-play"></span>
					</a>
				</div><!-- .hover -->';
			} else {
				$output .= '<div class="hover">
					<div class="new-icon">
						<a href="' . get_the_permalink() . '">
							<span class="fa fa-play"></span>
						</a>
					</div>
				</div><!-- .hover -->';
			}

		$output .= '</div><!-- .featured-image -->';
		

		return $output;
	}
}

if( ! function_exists( 'pod_front_page_episodes_pagination' ) ) {
	function pod_front_page_episodes_pagination($query) {
		$pod_list_of_posts_button = pod_theme_option('pod-front-page-button-type', 'list-of-posts-none');
		$pod_ajax_button_text = pod_theme_option('pod-ajax-link-txt', 'Load More');
		$pod_archive_link = pod_theme_option('pod-archive-link', '');
		$pod_archive_link_txt = pod_theme_option('pod-archive-link-txt', 'Podcast Archive');

		$output = '';

		if ( $query->max_num_pages > 1 && $pod_list_of_posts_button == "list-of-posts-ajax" ) { 

			$output .= '<div class="pod_loadmore">' . esc_html( $pod_ajax_button_text ) . '</div>';

		} elseif( $pod_list_of_posts_button == "list-of-posts-pagination" ) { 						

			$output .= '<div class="pagination clearfix">';
				 
					$big = 999999999; // need an unlikely integer

					$output .= paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('page') ),
						'total' => $query->max_num_pages,
					
					)); 
		 
			$output .= '</div><!-- pagination -->';

		} elseif( $pod_list_of_posts_button == "list-of-posts-custom" ) {
			$output .= '<a class="butn small archive-link-button" href="' .  esc_url( $pod_archive_link ) .'">' . esc_html( $pod_archive_link_txt ) . '</a>';
		}

		return $output;
	}
}




/*
 *
 * FRONT PAGE SECTIONS
 *-------------------------------------------------------*/
/**
 * get_pod_host()
 * Get a user and add to host box/layout.
 *
 * @return string $output - box.
 * @since Podcaster 1.8.1
 */
if( ! function_exists( 'get_pod_host' ) ) {
	function get_pod_host( $user_id='', $user_img='', $user_desc='', $user_link='', $user_url='', $user_img_raw = false ) {

		if( $user_img_raw == false ) {
			$user_img_url = ! empty( $user_img['url'] ) ? $user_img['url'] : '';
		} else {
			$user_img_url = $user_img;
		}

		if( $user_id == '' ) {
	 		return;
	 	}

		if( $user_link == 'host-link-default' ){
			$host_url = get_author_posts_url( $user_id );
		} elseif( $user_link == 'host-link-custom' ) {
			$host_url = $user_url;
		} else {
			$host_url = '';
		}
	 	

	 	$output = '';

	 		$output .= '<div id="host-' . $user_id . '" class="host">';
	 			$output .= '<div class="host-inner">';

	 			if( $user_img_url != '' ) {
	 				if( $host_url != '' ) {
						$output .= '<a href="' . $host_url . '" class="img-profile">';
	 				}
					
					$output .= '<div class="host-image">';
						if($user_img_raw == false) {
							$user_img = ( array ) $user_img;
							$id = isset($user_img['id']) ? $user_img['id'] : '';

							if( $id ) {
								$output .= wp_get_attachment_image( $id, "square" );
							}
						} else {
							$output .= '<img src="' . $user_img_url . '">';
						}
					$output .= '</div><!-- .host-image -->';
				
					if( $host_url != '' ) {
						$output .= '</a>';
					}

				}
				
				if( $user_id  != "" ) {
					$user_data = $user_id;
					$user_1_facebook = get_the_author_meta('user_facebook', $user_data);
					$user_1_twitter = get_the_author_meta('user_twitter', $user_data);
					$user_1_google = get_the_author_meta('user_googleplus', $user_data);
					$user_1_instagram = get_the_author_meta('user_instagram', $user_data);
					$user_1_snapchat = get_the_author_meta('user_snapchat', $user_data);
					$user_1_pinterest = get_the_author_meta('user_pinterest', $user_data);
					$user_1_tumblr = get_the_author_meta('user_tumblr', $user_data);

					$user_1_apple = get_the_author_meta('user_itunes', $user_data);
					$user_1_spotify = get_the_author_meta('user_spotify', $user_data);
					$user_1_mixcloud = get_the_author_meta('user_mixcloud', $user_data);

					$user_1_youtube = get_the_author_meta('user_youtube', $user_data);
					$user_1_vimeo = get_the_author_meta('user_vimeo',$user_data);
					$user_1_twitch = get_the_author_meta('user_twitch', $user_data);

					$user_1_dribbble = get_the_author_meta('user_dribble', $user_data);
					$user_1_flickr = get_the_author_meta('user_flickr', $user_data);

					$user_1_xing = get_the_author_meta('user_xing', $user_data);
					$user_1_linkedin = get_the_author_meta('user_linkedin', $user_data);
					$user_1_github = get_the_author_meta('user_github', $user_data);
					$user_1_stackex = get_the_author_meta('user_stackex', $user_data);

					$user_1_skype = get_the_author_meta('user_skype', $user_data);
				

					$output .= '<ul class="host-social">';

						$output .= pod_get_social_media_user( $user_data ); 

					$output .= '</ul>';
					if( $user_id != '' ) {
						$output .= '<h3>' . get_the_author_meta( 'display_name', $user_data ) . '</h3>';
					}
					
					if( $user_id != '' ) {
						$output .= '<span class="host-position">' . get_the_author_meta( 'user_position', $user_data ) . '</span>';
					}
					

					if( $user_desc != '' ) {
						$output .= '<div class="host-content">';
							$output .= esc_html( $user_desc ); 						
						$output .= '</div><!-- .host-content -->';
					}	
				}
				$output .= '</div><!-- .host-inner -->';
			$output .= '</div><!-- .host -->';




	 	return $output;

	}
}

if( ! function_exists( "pod_call_to_action_section" ) ){
	function pod_call_to_action_section() {

		/* Donate Button */
		$pod_front_donate = pod_theme_option( 'pod-frontpage-donate-active', false );
		if( ! $pod_front_donate ) {
			return;
		}

		$pod_front_donate_title = pod_theme_option('pod-frontpage-donate-title', 'Support the show on Patreon');
		$pod_front_donate_blurb = pod_theme_option('pod-frontpage-donate-blurb', 'Enter a blurb for your section.');
		$pod_front_donate_button_type = pod_theme_option('pod-frontpage-donate-button-type', 'button-theme-default');
		$pod_front_donate_button_custom_code = pod_theme_option('pod-frontpage-donate-button-custom-code', '');
		$pod_front_donate_button_text = pod_theme_option('pod-frontpage-donate-button-text', 'Donate via Patreon');
		$pod_front_donate_button_url = pod_theme_option('pod-frontpage-donate-button-url', '');
		$pod_front_donate_button_icon = pod_theme_option('pod-frontpage-donate-button-icon', 'no-icon');


		$output = '';

		$output .= '<div class="call-to-action-container">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							
							<div class="call-to-action-content">
								
								<div class="call-to-action-text">';

									if( $pod_front_donate_title ) :
										$output .= '<h2>' . esc_html( $pod_front_donate_title ) . '</h2>';
									endif;

									if( $pod_front_donate_blurb ) :
										$output .= '<p>' . esc_html( $pod_front_donate_blurb ) . '</p>';
									endif;
								$output .= '</div>
							
							
								<div class="call-to-action-form-container">
									<div class="call-to-action-form">';

										if( $pod_front_donate_button_type == "button-theme-default" ) :

										$output .= '<a class="butn medium" href="' . esc_attr( $pod_front_donate_button_url ) . '" target="_blank">';
											if( $pod_front_donate_button_icon != 'no-icon' ) : 
												$output .= '<span class="' . esc_attr( $pod_front_donate_button_icon ) . '"></span>';
											endif;
											
											$output .= esc_html( $pod_front_donate_button_text ) . '</a>';
										
										else :

											$output .= $pod_front_donate_button_custom_code;
										
										endif;
									$output .= '</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';


		return $output;
	}
}

if( ! function_exists("pod_from_the_blog_columns") ){
	function pod_from_the_blog_columns() { 
		/* Blog Excerpts */
		$pod_exceprts_title = pod_theme_option('pod-excerpts-section-title', 'From the Blog');
		$pod_excerpt_type = pod_theme_option('pod-excerpts-type', 'force_excerpt');
		$arch_category = pod_theme_option('pod-recordings-category', '');
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : 0;
		/* TO DO: From blog category */
		$b_category = pod_theme_option('pod-blog-excerpts-category');
		?>

		<div class="fromtheblog">
		 	<div class="container">
		 		<div class="row">
		 			<div class="col-lg-12">
		 				<?php
					 		if( ( $pod_exceprts_title != '' ) ) {
					 		echo '<h2 class="title">' . $pod_exceprts_title . '</h2>'; 
					 	} ?>
		 				<div class="row">

			 				<?php 
			 				if( $arch_category != '' ) {
			 					$args = array( 'cat' => -$arch_category, 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true);
			 				} else {
			 					$args = array( 'category__in' => $b_category, 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );
			 				}
				  			$fromblog_posts = new WP_Query($args);

				   			if( $fromblog_posts->have_posts() ) : while( $fromblog_posts->have_posts() ) : $fromblog_posts->the_post(); ?>
				   			<article <?php post_class('col-lg-3 col-md-3 col-sm-3 col-xs-4 col-xxs-6'); ?>>
				   				<div class="featured-image">
				   					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('square'); ?></a>
				   				</div><!-- .featured-image -->
								<div class="inside">		   					
					   				<div class="post-header">
					   					<?php if( has_category() ) : ?>
					   					<ul>
					   						<li><?php the_category('</li><li> '); ?></li>
					   					</ul>
					   					<?php endif ; ?>
					   					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

					   				</div><!-- .post-header -->
									<div class="post-content">
										<?php if ( $pod_excerpt_type == 'force_excerpt' ) : ?>
											<?php the_excerpt(); ?>
										<?php else : ?>
											<?php global $more;	$more = 0; the_content(''); ?>
										<?php endif; ?>
									</div>
									<div class="post-footer clearfix">
										<a href="<?php the_permalink(); ?>"><?php echo __('Read More', 'podcaster') ?></a>
									</div><!-- .post-footer -->
								</div><!-- .inside -->
							</article>
				   			<?php endwhile; ?>
			   			<?php endif; wp_reset_query(); ?>
		   			</div><!-- .col-->
		 			</div><!-- .col -->
		 		</div><!-- .row -->
		 	</div><!-- .container -->
		 </div><!-- .fromtheblog -->

	<?php }
}

if( ! function_exists("pod_from_the_blog_columns_2") ){
	function pod_from_the_blog_columns_2() {

		/* Blog Excerpts */
		$pod_exceprts_title = pod_theme_option('pod-excerpts-section-title', 'From the Blog');
		$pod_excerpt_type = pod_theme_option('pod-excerpts-type', 'force_excerpt');
		$arch_category = pod_theme_option('pod-recordings-category', '');
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : 0;
		$pod_excerpts_desc = pod_theme_option('pod-excerpts-section-desc', 'Your description here. Vivamus viverra sem nulla, ac sollicitudin ipsum lacinia et. Aliquam vitae neque nec sapien lobortis dapibus non vel augue.');
		$pod_excerpts_button = pod_theme_option('pod-excerpts-section-button', 'Go to Blog');



		?>

		<div class="fromtheblog">
		 	<div class="container">
		 		<div class="row">
		 			<div class="col-lg-12">
		 				<div class="row">
		 					<div class="post description col-lg-3 col-md-3 col-sm-3 col-xs-6 col-xxs-6">
								<?php
							 		if( ( $pod_exceprts_title != '' ) ) {
							 		echo '<h2 class="title">' . $pod_exceprts_title . '</h2>'; 
							 	} ?>
							 	<?php if( $pod_excerpts_desc != '' ) { ?>
								<p><?php echo esc_html( $pod_excerpts_desc ); ?></p>
		 						<?php } ?>
		 						<?php if( get_option( 'show_on_front' ) == 'page' && $pod_excerpts_button != '' ) { ?>
					   				<div class="button-container">
						   				<a class="butn small" href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>"><?php echo esc_html( $pod_excerpts_button ); ?></a>
						   			</div>
					   			<?php } ?>
		 					</div><!--description-->
			 				<?php 
			 				if( $arch_category != '' ) {
			 					$args = array( 'cat' => -$arch_category, 'posts_per_page' => 3, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true);
			 				} else {
			 					$args = array( 'posts_per_page' => 3, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );
			 				}

				  			$fromblog_posts = new WP_Query($args);

				   			if( $fromblog_posts->have_posts() ) : while( $fromblog_posts->have_posts() ) : $fromblog_posts->the_post(); ?>
				   			<article <?php post_class('col-lg-3 col-md-3 col-sm-3 col-xs-4 col-xxs-6'); ?>>
				   				<div class="featured-image">
				   					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('square'); ?></a>
				   				</div><!-- .featured-image -->
								<div class="inside">		   					
					   				<div class="post-header">
					   					<?php if( has_category() ) : ?>
					   					<ul>
					   						<li><?php the_category('</li><li> '); ?></li>
					   					</ul>
					   					<?php endif ; ?>
					   					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

					   				</div><!-- .post-header -->
									<div class="post-content">
										<?php if ( $pod_excerpt_type == 'force_excerpt' ) : ?>
											<?php the_excerpt(); ?>
										<?php else : ?>
											<?php global $more;	$more = 0; the_content(''); ?>
										<?php endif; ?>
									</div>
									<div class="post-footer clearfix">
										<a href="<?php the_permalink(); ?>"><?php echo __('Read More', 'podcaster') ?></a>
									</div><!-- .post-footer -->
								</div><!-- .inside -->
							</article>
				   			<?php endwhile; ?>
			   			<?php endif; wp_reset_query(); ?>
		   			</div><!-- .col-->
		 			</div><!-- .col -->
		 		</div><!-- .row -->
		 	</div><!-- .container -->
		 </div><!-- .fromtheblog -->

	<?php }
}

if( ! function_exists("pod_from_the_blog_list") ){
	function pod_from_the_blog_list() { 

		/* Blog Excerpts */
		$pod_exceprts_title = pod_theme_option('pod-excerpts-section-title', 'From the Blog');
		$pod_excerpt_type = pod_theme_option('pod-excerpts-type', 'force_excerpt');
		$arch_category = pod_theme_option('pod-recordings-category', '');
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : 0;
		$pod_excerpts_button = pod_theme_option('pod-excerpts-section-button', 'Go to Blog');

		$pod_avtr_frnt = pod_theme_option('pod-avatar-front', true);
		$show_avtrs = get_option('show_avatars');


		?>

		<div class="fromtheblog list">
		 	<div class="container">
		 		<div class="row">
		 			<div class="col-lg-12">
		 				<?php
					 		if( ( $pod_exceprts_title != '' ) ) {
					 		echo '<h2 class="title">' . $pod_exceprts_title . '</h2>'; 
					 	} ?>

			 				<?php 
			 				if ( $arch_category != '' ) {
			 					$args = array( 'cat' => -$arch_category , 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );
			 				} else {
			 					$args = array( 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );
				  			}
				  			$fromblog_posts = new WP_Query($args);

				   			if( $fromblog_posts->have_posts() ) : while( $fromblog_posts->have_posts() ) : $fromblog_posts->the_post(); ?>
				   			<article <?php post_class(); ?>>
				   				<div class="inside clearfix">		   					
					   				<div class="cont post-header">
					   					<?php if( $show_avtrs == true && $pod_avtr_frnt == true ) : ?>
					   					<a class="user_img_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">	
					   						<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
										</a>
										<?php endif; ?>
					   					<span><?php the_author(); ?></span>
					   				</div>
					   				<div class="cont_large post-content">
					   					<span class="cats"><?php the_category('</span> <span class="cats"> '); ?></span>
					   					<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
					   				</div><!-- .post-header -->
									
									<div class="cont date post-footer">
										<span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span>
									</div><!-- .post-footer -->
								</div><!-- .inside -->
							</article>
				   			<?php endwhile; ?>
			   			<?php endif; wp_reset_query(); ?>

			   			<?php if( get_option( 'show_on_front' ) == 'page' ) { ?>
			   				<div class="button-container">
				   				<a class="butn small" href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>"><?php echo esc_html( $pod_excerpts_button ); ?></a>
				   			</div>
			   			<?php } ?>
		 			</div><!-- .col -->
		 		</div><!-- .row -->
		 	</div><!-- .container -->
		</div>
	<?php }
}

if( ! function_exists( "pod_from_the_blog_text_horizontal" ) ) {
	function pod_from_the_blog_text_horizontal(){ 

		/* Blog Excerpts */
		$pod_exceprts_title = pod_theme_option('pod-excerpts-section-title', 'From the Blog');
		$pod_excerpt_type = pod_theme_option('pod-excerpts-type', 'force_excerpt');
		$arch_category = pod_theme_option('pod-recordings-category', '');
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : 0;
		$pod_excerpts_button = pod_theme_option('pod-excerpts-section-button', 'Go to Blog');


		$pod_avtr_frnt = pod_theme_option('pod-avatar-front', true);
		$pod_excerpts_amount = pod_theme_option( 'pod-excerpts-amount', 4 );
		$show_avtrs = get_option('show_avatars');



		/* WP Query */
		if ( $arch_category != '' ) {
			$args = array( 
				'cat' =>  - (int) $arch_category,
				'posts_per_page' => $pod_excerpts_amount,
				'paged' => get_query_var( 'paged' ),
				'ignore_sticky_posts' => true
			);
		} else { 
			$args = array( 
				'posts_per_page' => $pod_excerpts_amount,
				'paged' => get_query_var( 'paged' ),
				'ignore_sticky_posts' => true
			);
		}

		?>

		<div class="fromtheblog horizontal">
			<div class="container">
		 		<div class="row">
		 			<div class="col-lg-12">

		 				<?php
					 		if( ( $pod_exceprts_title != '' ) ) {
					 		echo '<h2 class="title">' . $pod_exceprts_title . '</h2>'; 
					 	} ?>

						<?php 
				  			$fromblog_posts = new WP_Query($args);


				   			if( $fromblog_posts->have_posts() ) : while( $fromblog_posts->have_posts() ) : $fromblog_posts->the_post(); ?>

				   			<article <?php post_class(); ?>>			
								<div class="inside">		   					
					   				<div class="post-header">
					   					<?php if( has_category() ) : ?>
					   					<ul>
					   						<li><?php the_category('</li><li> '); ?></li>
					   					</ul>
					   					<?php endif ; ?>
					   					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

					   				</div><!-- .post-header -->
									<div class="post-content">

										<?php the_excerpt(); ?>
										<a href="<?php the_permalink(); ?>"><?php echo __('Read More', 'podcaster') ?></a>

									</div>
								</div><!-- .inside -->
							</article>

				   			<?php endwhile; ?>
			   			<?php endif; wp_reset_query(); ?>

			   			<?php if( get_option( 'show_on_front' ) == 'page' ) { ?>
			   				<div class="button-container">
				   				<a class="butn small" href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>"><?php echo esc_html( $pod_excerpts_button ); ?></a>
				   			</div>
			   			<?php } ?>
			   		</div>
			   	</div>
			</div>		 	
		 </div>

	<?php }
}


if( ! function_exists( "pod_from_the_blog_thumb_overlay_post" ) ) {
	function pod_from_the_blog_thumb_overlay_post(){ 

		/* Blog Excerpts */
		$pod_exceprts_title = pod_theme_option('pod-excerpts-section-title', 'From the Blog');
		$pod_excerpt_type = pod_theme_option('pod-excerpts-type', 'force_excerpt');
		$arch_category = pod_theme_option('pod-recordings-category', '');
		$arch_category = ( $arch_category != '' ) ? (int) $arch_category : 0;
		$pod_excerpts_button = pod_theme_option('pod-excerpts-section-button', 'Go to Blog');
		$pod_excerpts_cols = pod_theme_option( 'pod-excerpts-image-overlay-columns', 'cols-4' );
		$pod_excerpts_rounded = pod_theme_option( 'pod-excerpts-image-overlay-rounded-borders', 'straight-borders' );
		$pod_excerpts_amount = pod_theme_option( 'pod-excerpts-amount', 4 );
		$pod_avtr_frnt = pod_theme_option('pod-avatar-front', true);
		$show_avtrs = get_option('show_avatars');


		/* WP Query */
		if ( $arch_category != '' ) {
			$args = array( 
				'cat' =>  - (int) $arch_category,
				'posts_per_page' => $pod_excerpts_amount,
				'paged' => get_query_var( 'paged' ),
				'ignore_sticky_posts' => true
			);
		} else { 
			$args = array( 
				'posts_per_page' => $pod_excerpts_amount,
				'paged' => get_query_var( 'paged' ),
				'ignore_sticky_posts' => true
			);
		}

		?>

		<div class="fromtheblog img-overlay <?php echo esc_attr( $pod_excerpts_cols ); ?> <?php echo esc_attr( $pod_excerpts_rounded ); ?>">
			<div class="container">
		 		<div class="row">
		 			<div class="col-lg-12">
		 				
		 				<?php
					 		if( ( $pod_exceprts_title != '' ) ) {
					 		echo '<h2 class="title">' . $pod_exceprts_title . '</h2>'; 
					 	} ?>

						 <div class="blog-posts">

							<?php 
					  			$fromblog_posts = new WP_Query($args);


					   			if( $fromblog_posts->have_posts() ) : while( $fromblog_posts->have_posts() ) : $fromblog_posts->the_post(); ?>

					   			<article <?php post_class(); ?>>			
									<div class="inside">
										

										<div class="post-featured-image">
											<?php if( has_post_thumbnail() ) { ?>
												<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('square-large'); ?></a>
											<?php } else { ?>
												<img class="placeholder" src="<?php echo get_template_directory_uri(); ?>/img/placeholder-square.png" alt="This is a blank placeholder">
											<?php } ?>
										</div><!-- .post-featured-image -->


						   				<div class="post-header">
						   					<?php if( has_category() ) : ?>
						   					<ul>
						   						<li><?php the_category('</li><li> '); ?></li>
						   					</ul>
						   					<?php endif ; ?>
						   					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

						   					<a class="post-permalink" href="<?php the_permalink(); ?>"><?php echo __("Read Our Story", "podcaster"); ?></a>

						   				</div><!-- .post-header -->
										
									</div><!-- .inside -->
								</article>

					   			<?php endwhile; ?>
				   			<?php endif; wp_reset_query(); ?>
				   		</div><!-- .blog-posts -->

				   			<?php if( get_option( 'show_on_front' ) == 'page' ) { ?>
				   				<div class="button-container">
					   				<a class="butn small" href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>"><?php echo esc_html( $pod_excerpts_button ) ?></a>
					   			</div>
				   			<?php } ?>

			   		</div>
			   	</div>
			</div>		 	
		 </div>

	<?php }
}

if( ! function_exists( "pod_from_the_blog" ) ){
	function pod_from_the_blog() {

		$pod_excerpts_style  = pod_theme_option('pod-excerpts-style', 'list');


		switch ( $pod_excerpts_style ) {
			case 'columns':
				pod_from_the_blog_columns();
				break;

			case 'columns-2':
				pod_from_the_blog_columns_2();
				break;

			case 'list':
				pod_from_the_blog_list();
				break;

			case 'text-horizontal':
				pod_from_the_blog_text_horizontal();
				break;

			case 'image-overlay':
			pod_from_the_blog_thumb_overlay_post();
			
			default:
				// Do nothing.
				break;
		}

	}
}

if( ! function_exists( "pod_host_section" ) ) {
	function pod_host_section() {
		$pod_front_hosts = pod_theme_option('pod-frontpage-hosts-active', false);

		if( ! $pod_front_hosts ) {
			return;
		}

		$pod_front_hosts_title = pod_theme_option('pod-frontpage-hosts-title', 'Hosts');
		$pod_front_hosts_blurb = pod_theme_option('pod-frontpage-hosts-blurb', '');
		$pod_front_hosts_cols = pod_theme_option('pod-frontpage-hosts-cols', 'hosts-cols-3');
		$pod_front_hosts_align = pod_theme_option('pod-frontpage-hosts-align', 'hosts-align-left');

		$output ='';

		$output .= '<div class="hosts-container">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">';

					$output .= '<div class="hosts-inner ' . $pod_front_hosts_align . '">';

					if( $pod_front_hosts_title != '' || $pod_front_hosts_blurb != '' ) :
					$output .= '<div class="hosts-description">';
						
						if( $pod_front_hosts_title != '' ) :
							$output .= '<h2>' . esc_html( $pod_front_hosts_title ) .  '</h2>';
						endif;
						
						if( $pod_front_hosts_blurb != '' ) :
							$output .= '<p>' . esc_html( $pod_front_hosts_blurb ) . '</p>';
						endif;
					$output .= '</div>';
		
					endif;


				$output .= '<div class="hosts-content ' . esc_attr( $pod_front_hosts_cols ) . '">';

					
					$pod_host_1_active = pod_theme_option('pod-frontpage-host-1-active', true);
					$pod_host_2_active = pod_theme_option('pod-frontpage-host-2-active', true);
					$pod_host_3_active = pod_theme_option('pod-frontpage-host-3-active', false);
					$pod_host_4_active = pod_theme_option('pod-frontpage-host-4-active', false);
					$pod_host_5_active = pod_theme_option('pod-frontpage-host-5-active', false);
					$pod_host_6_active = pod_theme_option('pod-frontpage-host-6-active', false);

					if( $pod_host_1_active == true ) : 
						$pod_host_1_user = pod_theme_option('pod-frontpage-host-1-user', "1");
						$pod_host_1_img = pod_theme_option('pod-frontpage-host-1-image');
						$pod_host_1_desc = pod_theme_option('pod-frontpage-host-1-description');
						$pod_host_1_link = pod_theme_option('pod-frontpage-host-1-link', 'host-link-default');
						$pod_host_1_url = pod_theme_option('pod-frontpage-host-1-url');

						$output .= get_pod_host( $pod_host_1_user, $pod_host_1_img, $pod_host_1_desc, $pod_host_1_link, $pod_host_1_url );
						
					endif;


					if( $pod_host_2_active == true ) : 
						$pod_host_2_user = pod_theme_option('pod-frontpage-host-2-user', "1");
						$pod_host_2_img = pod_theme_option('pod-frontpage-host-2-image');
						$pod_host_2_desc = pod_theme_option('pod-frontpage-host-2-description');
						$pod_host_2_link = pod_theme_option('pod-frontpage-host-2-link', 'host-link-default');
						$pod_host_2_url = pod_theme_option('pod-frontpage-host-2-url');

						$output .= get_pod_host( $pod_host_2_user, $pod_host_2_img, $pod_host_2_desc, $pod_host_2_link, $pod_host_2_url );
						
					endif;


					if( $pod_host_3_active == true ) : 
						$pod_host_3_user = pod_theme_option('pod-frontpage-host-3-user', "1");
						$pod_host_3_img = pod_theme_option('pod-frontpage-host-3-image');
						$pod_host_3_desc = pod_theme_option('pod-frontpage-host-3-description');
						$pod_host_3_link = pod_theme_option('pod-frontpage-host-3-link', 'host-link-default');
						$pod_host_3_url = pod_theme_option('pod-frontpage-host-3-url');

						$output .= get_pod_host( $pod_host_3_user, $pod_host_3_img, $pod_host_3_desc, $pod_host_3_link, $pod_host_3_url );
						
					endif;


					if( $pod_host_4_active == true ) : 
						$pod_host_4_user = pod_theme_option('pod-frontpage-host-4-user', "1");
						$pod_host_4_img = pod_theme_option('pod-frontpage-host-4-image');
						$pod_host_4_desc = pod_theme_option('pod-frontpage-host-4-description');
						$pod_host_4_link = pod_theme_option('pod-frontpage-host-4-link', 'host-link-default');
						$pod_host_4_url = pod_theme_option('pod-frontpage-host-4-url');

						$output .= get_pod_host( $pod_host_4_user, $pod_host_4_img, $pod_host_4_desc, $pod_host_4_link, $pod_host_4_url );
					
					endif;


					if( $pod_host_5_active == true ) : 
						$pod_host_5_user = pod_theme_option('pod-frontpage-host-5-user', "1");
						$pod_host_5_img = pod_theme_option('pod-frontpage-host-5-image');
						$pod_host_5_desc = pod_theme_option('pod-frontpage-host-5-description');
						$pod_host_5_link = pod_theme_option('pod-frontpage-host-5-link', 'host-link-default');
						$pod_host_5_url = pod_theme_option('pod-frontpage-host-5-url');

						$output .= get_pod_host( $pod_host_5_user, $pod_host_5_img, $pod_host_5_desc, $pod_host_5_link, $pod_host_5_url );
					
					endif;


					if( $pod_host_6_active == true ) : 
						$pod_host_6_user = pod_theme_option('pod-frontpage-host-6-user', "1");
						$pod_host_6_img = pod_theme_option('pod-frontpage-host-6-image');
						$pod_host_6_desc = pod_theme_option('pod-frontpage-host-6-description');
						$pod_host_6_link = pod_theme_option('pod-frontpage-host-6-link', 'host-link-default');
						$pod_host_6_url = pod_theme_option('pod-frontpage-host-6-url');

						$output .= get_pod_host( $pod_host_6_user, $pod_host_6_img, $pod_host_6_desc, $pod_host_6_link, $pod_host_6_url );
					
					endif;


				$output .= '</div>'; //.hosts-content
				$output .= '</div>'; //.hosts-inner
				$output .= '</div>
					</div>
				</div>
			</div>';

		return $output;
	}
}

if( ! function_exists( 'pod_front_page_newsletter_section' ) ) {
	function pod_front_page_newsletter_section() {

		/* Newsletter */
		$pod_front_newsletter = pod_theme_option( 'pod-frontpage-newsletter-active', false );
		$pod_front_newsletter_title = pod_theme_option('pod-frontpage-newsletter-title', 'Stay in touch. Sign up for our newsletter!');
		$pod_front_newsletter_blurb = pod_theme_option('pod-frontpage-newsletter-blurb', 'Get notified about updates and be the first to get early access to new episodes.');
		$pod_front_newsletter_type = pod_theme_option('pod-frontpage-newsletter-type', 'newsletter-shortcode');
		$pod_front_newsletter_shortcode = pod_theme_option('pod-frontpage-newsletter-shortcode', '');
		$pod_front_newsletter_code = pod_theme_option('pod-frontpage-newsletter-custom-code', '');

		$output = '';



		if( $pod_front_newsletter == true ) {
			$output .= '<div class="newsletter-container ' . esc_attr( $pod_front_newsletter_type ) . '">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								
								<div class="newsletter-content">
									
									<div class="newsletter-text">';
										if( $pod_front_newsletter_title != '' || $pod_front_newsletter_blurb != '' ) {
											
											if( $pod_front_newsletter_title != '' ) {
												$output .= '<h2>' . esc_html( $pod_front_newsletter_title ) . '</h2>';
											}
											
											if( $pod_front_newsletter_blurb != '' ) {
												$output .= '<p>' . esc_html( $pod_front_newsletter_blurb ) . '</p>';
											}
											
										}
									$output .= '</div><!-- .newsletter-content -->
								
									<div class="newsletter-form-container">
										<div class="newsletter-form">';

											if( $pod_front_newsletter_type == "newsletter-shortcode" ) {
												$output .= do_shortcode( $pod_front_newsletter_shortcode );

											} else {

												$output .= $pod_front_newsletter_code;
											
											}

										$output .= '</div><!-- .newsletter-content -->
									</div><!-- .newsletter-content-container -->
										
								</div><!-- .newsletter-content -->
								
							</div><!-- .col -->
						</div><!-- .row -->
					</div><!-- .container -->
				</div><!-- .newsletter-container -->';
		}

		return $output;
	}
}






/*
 *
 * SINGLE 
 *-------------------------------------------------------*/
if( ! function_exists( 'pod_single_header_audio_ssp' ) ) {
	function pod_single_header_audio_ssp( $post_id ) {
		$pod_players_preload = pod_theme_option('pod-players-preload', 'none');
		$pod_single_header_display = pod_theme_option('pod-single-header-display', 'has-thumbnail');
		
		/* Player position */
		$pod_single_audio_player_position = pod_theme_option( 'pod-single-header-player-display', 'player-in-header' );

		$ssp_single_thumb_style = (has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail') ?  ' with_thumbnail' : '';


		global $ss_podcasting, $wp_query;

		$id = get_the_ID();
		$output_s_ssp_a = '';
		$file = get_post_meta( $id , "enclosure", true );
		$audio_file = get_post_meta( $id, "audio_file", true );
		$file = $audio_file ? $audio_file : $file;

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
		$ep_explicit = get_post_meta( get_the_ID() , 'explicit' , true );

		if( $ep_explicit && $ep_explicit == 'on' ) {
			$explicit_flag = 'Yes';
		} else {
			$explicit_flag = 'No';
		} ?>


		<?php if( has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail' ) { ?>
			<div class="album-art">
				<?php echo get_the_post_thumbnail($id, 'square-large'); ?>
			</div>

		<?php } ?>

	
	
		<div class="player_container <?php echo esc_attr( $ssp_single_thumb_style ); ?>">

			<span class="mini-title">
				<?php echo get_the_date(); ?> &bull; 
				<?php echo pod_get_ssp_series_cats($post_id, '', '', ',&nbsp;', true); ?>
			</span>
			
			<h2>
				<?php echo get_the_title(); ?>

				<?php if( $explicit_flag == 'Yes' ) { ?>
	   			<span class="mini-ex">
	       			<?php echo __('Explicit', 'podcaster'); ?>
  				</span>
				<?php } ?>
			</h2>
			

			<?php if( $file != '' ){
				echo '<div class="audio">';
					echo pod_get_featured_player( $post_id );

				echo '</div><!-- .audio -->';
			} ?>

		</div><!-- player_container -->

		
	<?php }
}

if( ! function_exists( 'pod_single_header_video_ssp' ) ) {
	function pod_single_header_video_ssp( $post_id ) {

		global $ss_podcasting, $wp_query;

		$id = get_the_ID();
		$output_s_ssp_a = '';
		$file = get_post_meta( $id , "enclosure", true );
		$audio_file = get_post_meta( $id, "audio_file", true );
		$file = $audio_file ? $audio_file : $file;
		$pod_players_preload = pod_theme_option('pod-players-preload', 'none');

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
		$ep_explicit = get_post_meta( $id , 'explicit' , true );

		if( $ep_explicit && $ep_explicit == 'on' ) {
			$explicit_flag = 'Yes';
		} else {
			$explicit_flag = 'No';
		} 

		
		if( $file != '' ){
			
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
			$featured_image_url = $featured_image[0];

			$video_shortcode_attr_ssp = array('src' => $file, 'loop' => '', 'autoplay' => '', 'preload' => $pod_players_preload, 'poster' => $featured_image_url );
			$video_shortcode = wp_video_shortcode( $video_shortcode_attr_ssp );
			$video_shortcode = pod_get_featured_player( $post_id );
			
			echo '<div class="video_player">' . $video_shortcode . '</div><!-- .video_player -->';

		} 
	}
}

if( ! function_exists( 'pod_single_header_audio_bpp' ) ) {
	function pod_single_header_audio_bpp( $post_id ) {

		$pod_sticky_header = pod_theme_option('pod-sticky-header', false);
		$pod_single_header_display = pod_theme_option('pod-single-header-display', 'has-thumbnail');
		
		/* Player position */
		$pod_single_audio_player_position = pod_theme_option( 'pod-single-header-player-display', 'player-in-header' );
		$pod_header_par = pod_theme_option('pod-single-header-par', false);

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), '' );
		$header_img = $image[0];

		$bpp_single_sticky = $pod_sticky_header == true ? 'sticky' : ''; 
		$bpp_single_header_bg = (has_post_thumbnail() && $pod_single_header_display == 'has-background') ? 'thumb_bg' : '';
		$bpp_single_bg_img = (has_post_thumbnail() &&  $pod_single_header_display == 'has-background') ? 'background-image: url(' . $header_img . ');' : '';
		$bpp_single_thumb_style = (has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail') ? ' with_thumbnail' : '';


		$bpp_settings = get_option('powerpress_general');
		$bpp_disable_appearance = isset( $bpp_settings['disable_appearance'] ) ? $bpp_settings['disable_appearance'] : '';
			
			/* PowerPress Files*/
			$pp_audio_str = get_post_meta( $post_id, 'enclosure', true );
			$pp_audiourl = strtok($pp_audio_str, "\n"); 
		?>
		


			<?php if( has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail' ) { ?>
				<div class="album-art">
					<?php echo get_the_post_thumbnail($post_id, 'square-large'); ?>
				</div>
			<?php } ?>

			<div class="player_container audio-container <?php echo esc_attr( $bpp_single_thumb_style ); ?>">
				<span class="mini-title"><?php echo get_the_date(); ?></span>
				<h2><?php echo get_the_title(); ?></h2>

				<?php if( $bpp_disable_appearance != true ) { ?>
				<div class="audio">
					<?php the_powerpress_content(); ?>
				</div><!-- audio -->
				<?php } ?>

			</div><!-- player_container -->

	<?php }
}

if( ! function_exists( 'pod_single_header_video_bpp' ) ) {
	function pod_single_header_video_bpp( $post_id ) { 
		$bpp_settings = get_option('powerpress_general');
		$bpp_disable_appearance = isset( $bpp_settings['disable_appearance'] ) ? $bpp_settings['disable_appearance'] : '';
			
		// PowerPress Files
		$pp_audio_str = get_post_meta( $post_id, 'enclosure', true );
		$pp_audiourl = strtok($pp_audio_str, "\n"); ?>

		<?php if( $bpp_disable_appearance != true ) { ?>
		<div class="video_player">
			<?php if( $pp_audiourl !='' ) { ?>
				<?php the_powerpress_content(); ?>
			<?php } ?>
		</div><!-- .video_player -->
		<?php } ?>

	<?php }
}

if( ! function_exists( 'pod_single_header_audio_podm' ) ) {
	function pod_single_header_audio_podm( $post_id ) {

		$pod_single_header_display = pod_theme_option('pod-single-header-display', 'has-thumbnail');
		$pod_single_header_thumb_embed = pod_theme_option('pod-single-header-thumbnail-audio-embed', true);
		$pod_single_header_thumb_playlist = pod_theme_option('pod-single-header-thumbnail-audio-playlist', true);
		$pod_players_preload = pod_theme_option('pod-players-preload', 'none');
		
		/* Player position */
		$pod_single_audio_player_position = pod_theme_option( 'pod-single-header-player-display', 'player-in-header' );

		$has_thumb = ( has_post_thumbnail( $post_id ) && $pod_single_header_display ) == 'has-thumbnail' ? ' with_thumbnail' : '';

		// Post Meta
		$audiotype = get_post_meta( $post_id, 'cmb_thst_audio_type', true );
		$audiourl = get_post_meta( $post_id, 'cmb_thst_audio_url', true );
		$audioembed = get_post_meta( $post_id, 'cmb_thst_audio_embed', true );
		$audioembedcode = get_post_meta( $post_id, 'cmb_thst_audio_embed_code', true );
		$audiocapt = get_post_meta( $post_id, 'cmb_thst_audio_capt', true );
		$audioplists = get_post_meta( $post_id, 'cmb_thst_audio_playlist', true );
		$audioex = get_post_meta( $post_id, 'cmb_thst_audio_explicit', true );


		if( $audiotype == "audio-embed-url" || $audiotype == "audio-embed-code" ) {
			$has_thumb_embed = ( $pod_single_header_thumb_embed ) ? "audio-embed-thumbnail-active" : "audio-embed-thumbnail-inactive" ;
		} else {
			$has_thumb_embed = "";
		}

		if( $audiotype == "audio-playlist" ) {
			$has_thumb_playlist = ( $pod_single_header_thumb_playlist ) ? "audio-playlist-thumbnail-active" : "audio-playlist-thumbnail-inactive";
		} else {
			$has_thumb_playlist = "";
		}


		if( has_post_thumbnail( $post_id ) &&  $pod_single_header_display == 'has-thumbnail' ) { ?>
									
			<?php if( ( $audiotype == "audio-embed-url" || $audiotype == "audio-embed-code" ) && $pod_single_header_thumb_embed == true ) { ?>
				<div class="album-art">
					<?php echo get_the_post_thumbnail( $post_id, 'square-large' ); ?>
				</div>
			<?php } elseif( ( $audiotype == "audio-playlist" ) && $pod_single_header_thumb_playlist == true ) { ?>
				<div class="album-art">
					<?php echo get_the_post_thumbnail( $post_id, 'square-large' ); ?>
				</div>
			<?php } elseif( $audiotype == "audio-url" ) { ?>
				<div class="album-art">
					<?php echo get_the_post_thumbnail( $post_id, 'square-large' ); ?>
				</div>
			<?php } ?>

		<?php } ?>

		<div class="player_container <?php echo esc_attr( $has_thumb ); ?> <?php echo esc_attr( $has_thumb_embed ); ?> <?php echo esc_attr( $has_thumb_playlist ); ?> <?php echo esc_attr( $audiotype ); ?>">

			<div class="player_container_text">
				<span class="mini-title"><?php echo get_the_date(); ?></span>
				
				<h2>
					<?php echo get_the_title(); ?>

					<?php if( $audioex == 'on' ) { ?>
				        <span class="mini-ex">
				            <?php echo  __('Explicit', 'podcaster'); ?>
				        </span>
				    <?php } ?>
				</h2>
			</div>

			<div class="audio">
				<?php echo pod_get_featured_player( $post_id ); ?>
	
			</div><!-- audio -->

		</div><!-- player_container -->

	<?php }
}

if( ! function_exists( 'pod_single_header_video_podm' ) ) {
	function pod_single_header_video_podm( $post_id ) { 

		$videotype = get_post_meta( $post_id, 'cmb_thst_video_type', true );		
		$videoembed = get_post_meta( $post_id, 'cmb_thst_video_embed', true );
		$videourl =  get_post_meta( $post_id, 'cmb_thst_video_url', true );
		$videocapt = get_post_meta( $post_id, 'cmb_thst_video_capt', true );
		$videothumb = get_post_meta( $post_id, 'cmb_thst_video_thumb',true );
		$videoplists = get_post_meta( $post_id, 'cmb_thst_video_playlist', true );
		$videoembedcode = get_post_meta( $post_id, 'cmb_thst_video_embed_code', true );
		$videoex = get_post_meta( $post_id, 'cmb_thst_video_explicit', true );
		$pod_players_preload = pod_theme_option('pod-players-preload', 'none');

		?>

		<?php if( $videotype == 'video-oembed' && $videoembed != '' ) {
			echo '<div class="video_player">' . wp_oembed_get($videoembed) . '</div><!--video_player-->';
		}
		if( $videotype == 'video-url' && $videourl != '' ) {

			$video_shortcode_attr = array('src' => $videourl, 'loop' => '', 'autoplay' => '', 'preload' => $pod_players_preload, 'poster' => $videothumb );
			echo '<div class="video_player">' . wp_video_shortcode( $video_shortcode_attr ) . '</div><!-- .video_player-->';

		}
		if( $videotype == 'video-playlist' && is_array( $videoplists ) ) {
			$video_playlist_ids = implode( ',', array_keys( $videoplists ) );

			$video_playlist_shortcode_attr = array( 'type' => 'video', 'ids' => $video_playlist_ids );
			echo wp_playlist_shortcode( $video_playlist_shortcode_attr );

		}
		if( $videotype == 'video-embed-url' && $videoembedcode !='' ) {
			echo  '<div class="video_player">' . $videoembedcode . '</div><!--video_player-->';									
		}

	}
}

if( ! function_exists( 'pod_single_header_caption_bpp') ) {
	function pod_single_header_caption_bpp( $post_id ) {

		$bpp_settings = get_option('powerpress_general');
		$bpp_settings_feeds = isset( $bpp_settings['custom_feeds'] ) ? $bpp_settings['custom_feeds'] : '';
		$bpp_settings_sub_links = ! empty( $bpp_settings['subscribe_links'] ) ? $bpp_settings['subscribe_links'] : '';
		$bpp_disable_appearance = isset( $bpp_settings[ 'disable_appearance' ] ) ? $bpp_settings[ 'disable_appearance' ] : '';
		$bpp_disable_player = isset( $bpp_settings['disable_player'] ) ? $bpp_settings['disable_player'] : '';

		$bpp_ep_data = powerpress_get_enclosure_data( $post_id, 'podcast' );
		$bpp_ep_data_url = ! empty( $bpp_ep_data['url'] ) ? $bpp_ep_data['url'] : '';
		$bpp_media_url = powerpress_add_flag_to_redirect_url( $bpp_ep_data_url, 'p' );
		$bpp_subscribe_links = powerpressplayer_link_subscribe_pre( ' ', $bpp_media_url, $bpp_ep_data );

		$format = get_post_format( $post_id );


		if( $bpp_disable_appearance != true ) { ?>
		
		
			<?php $bpp_ep_data = powerpress_get_enclosure_data( $post_id, 'podcast'); ?>
						
			<?php if( ! empty( $bpp_settings_feeds ) ) {
				$array_default_feed = array( "podcast" => "Podcast" );
				$bpp_settings_feeds = array_merge( $array_default_feed, $bpp_settings_feeds );
			?>
			

				<?php foreach ( $bpp_settings_feeds as  $key => $feed ) {
				    if ( ! empty($bpp_settings_feeds) ) {
				    	$bpp_ep_data_custom_feed = powerpress_get_enclosure_data( $post_id, $key );
				    	$bpp_ep_feed = $bpp_ep_data_custom_feed['feed'];


			    		if ( array_key_exists($bpp_ep_feed, $bpp_disable_player ) ) {
			    			$bpp_feed_custom_player_active = $bpp_disable_player[$bpp_ep_feed];
			    		} else {
			    			$bpp_feed_custom_player_active = false;
			    		}


				    	if( $bpp_ep_data_custom_feed != false && $bpp_feed_custom_player_active != true ){
					    	
					    	$bpp_media_url = powerpress_add_flag_to_redirect_url( $bpp_ep_data_custom_feed['url'], 'p' );
							$bpp_new_wind_link = powerpressplayer_link_pinw( '', $bpp_media_url, $bpp_ep_data_custom_feed );
							$bpp_download_link = powerpressplayer_link_download( '', $bpp_media_url, $bpp_ep_data_custom_feed );
							$bpp_embed_link = powerpressplayer_link_embed( '', $bpp_media_url, $bpp_ep_data_custom_feed );

							?>
							<div class="caption-container format-<?php echo esc_attr( $format ); ?>">
								<div class="container">
									<div class="row">
										<div class="col-lg-12">
											<div>
												<div class="featured audio">

												<?php if( $bpp_ep_data_custom_feed != false && ( $bpp_new_wind_link !='' || $bpp_download_link != '' || $bpp_embed_link != '' ) ) : ?>

													<p class="powerpress_embed_box" style="display: block;">
													<?php echo __('Podcast', 'podcaster') . ': '; ?>
													<?php 
														if ( !empty( $bpp_new_wind_link ) ) {

															echo powerpressplayer_link_pinw( '', $bpp_media_url, $bpp_ep_data_custom_feed );
															if( !empty( $bpp_download_link ) || !empty( $bpp_embed_link ) ) {
																echo ' | ';
															}
														}
														if ( !empty( $bpp_download_link ) ) {

															echo powerpressplayer_link_download( '', $bpp_media_url, $bpp_ep_data_custom_feed );
															if( !empty( $bpp_new_wind_link) || !empty( $bpp_embed_link ) ) {
																echo ' | ';
															}
														}
														if ( !empty( $bpp_embed_link ) ) {

															echo powerpressplayer_link_embed( '', $bpp_media_url, $bpp_ep_data_custom_feed );
														}
														?>

														<?php if( $bpp_settings_sub_links == true ) { ?>
															<span> 
																<?php echo __('Subscribe', 'podcaster') . ': '; ?>
																<?php echo powerpressplayer_link_subscribe_pre( ' ', $bpp_media_url, $bpp_ep_data ); ?>
															</span>
														<?php }	?>
														
													</p>
												<?php endif; ?>
												</div>
											</div><!-- next-week -->
										</div><!-- col -->
									</div><!-- row -->	 
								</div><!-- container -->  	
							</div><!-- caption-container -->
					<?php }
			    	}
				} ?>
									


			<?php } else {
				$bpp_ep_data_url = ! empty( $bpp_ep_data['url'] ) ? $bpp_ep_data['url'] : '';
				$bpp_media_url = powerpress_add_flag_to_redirect_url( $bpp_ep_data_url, 'p' ); 
				$bpp_new_wind_link = powerpressplayer_link_pinw('', $bpp_media_url, $bpp_ep_data );
				$bpp_download_link = powerpressplayer_link_download('', $bpp_media_url, $bpp_ep_data );
				$bpp_embed_link = powerpressplayer_link_embed('', $bpp_media_url, $bpp_ep_data );

			 ?>

				<?php if( $bpp_ep_data != false && ( $bpp_new_wind_link !='' || $bpp_download_link != '' || $bpp_embed_link != '' ) ) : ?>
				<div class="caption-container format-<?php echo esc_attr( $format ); ?>">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div>
									<div class="featured audio">
										<p class="powerpress_embed_box" style="display: block;">
										<?php echo __('Podcast', 'podcaster') . ': '; ?>
										<?php 
											if ( !empty( $bpp_new_wind_link ) ) {

												echo powerpressplayer_link_pinw('', $bpp_media_url, $bpp_ep_data );
												if( !empty( $bpp_download_link ) || !empty( $bpp_embed_link ) ) {
													echo ' | ';
												}
											}
											if ( !empty( $bpp_download_link ) ) {

												echo powerpressplayer_link_download('', $bpp_media_url, $bpp_ep_data );
												if( !empty( $bpp_new_wind_link) || !empty( $bpp_embed_link ) ) {
													echo ' | ';
												}
											}
											if ( !empty( $bpp_embed_link ) ) {

												echo powerpressplayer_link_embed('', $bpp_media_url, $bpp_ep_data );
											}
										?>
										</p>
									</div>
								</div><!-- next-week -->
							</div><!-- col -->
						</div><!-- row -->	 
					</div><!-- container -->  	
				</div><!-- caption-container -->
				<?php endif; ?>
			<?php } ?>
		<?php } ?>
	<?php }
}

if( ! function_exists( 'pod_single_header_caption_ssp' ) ) {
	function pod_single_header_caption_ssp( $post_id ) {

		$format = get_post_format( $post_id );
		$pod_ssp_meta = pod_theme_option('pod-ssp-meta-data', false);

		if( $pod_ssp_meta == true && ( $format == 'audio' || $format == 'video' ) ) : 
			global $ss_podcasting;
			$audio_meta = $ss_podcasting->episode_meta_details( $post_id ); ?>
		
			<div class="caption-container format-<?php echo esc_attr( $format ); ?>">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div>
								<div class="featured audio">

									<?php echo wp_kses_post( $audio_meta); ?>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php endif; ?>

	<?php }
}

if( ! function_exists( 'pod_single_header_caption_default' ) ) {
	function pod_single_header_caption_default( $post_id ) {

		$format = get_post_format( $post_id );
		$audiocapt = get_post_meta( $post_id, 'cmb_thst_audio_capt', true );
		$videocapt = get_post_meta( $post_id, 'cmb_thst_video_capt', true);
		$thump_cap = pod_the_post_thumbnail_caption();
		$gallerycapt = get_post_meta( $post_id, 'cmb_thst_gallery_capt', true);

		if( ( $format == "video" && $videocapt != '' ) || ( $format == "audio" && $audiocapt != '' ) || ( $format == "image" && $thump_cap != '' ) || ( $format == "gallery" && $gallerycapt != '' ) ) : ?>
		<div class="caption-container format-<?php echo esc_attr( $format ); ?>">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div>
					   		<?php if ( $format == "video" ) : ?>
								<?php echo '<div class="featured vid">' . $videocapt . '</div>'; ?>
							<?php endif; ?>

							<?php if ( $format == "audio" ) : ?>
								<?php echo '<div class="featured audio">' . $audiocapt . '</div>'; ?>
							<?php endif; ?>

							<?php if ( $format == "image" ) : ?>
								<?php echo '<div class="featured img">' . $thump_cap . '</div>'; ?>
							<?php endif; ?>

							<?php if ( $format == "gallery" ) : ?>
								<?php echo '<div class="featured img">' . $gallerycapt . '</div>'; ?>
							<?php endif; ?>
					   	</div><!-- next-week -->
					</div><!-- col -->
				</div><!-- row -->	 
			</div><!-- container -->  	
		</div>
		<?php endif; ?>
	<?php }
}

if( ! function_exists( 'pod_single_header_caption' ) ) {
	function pod_single_header_caption( $post_id ) {

		$pod_plugin_active = pod_get_plugin_active();

		if( $pod_plugin_active == "ssp" ) {
			pod_single_header_caption_ssp( $post_id );
		} elseif( $pod_plugin_active == "bpp" ) {
			pod_single_header_caption_bpp( $post_id );
		} else {
			pod_single_header_caption_default( $post_id );
		}

	}
}

if( ! function_exists( 'pod_single_header_audio' ) ) {
	function pod_single_header_audio( $post_id ) {

		$pod_plugin_active = pod_get_plugin_active();

		// Variables
		$pod_single_header_display = pod_theme_option('pod-single-header-display', 'has-thumbnail');
		$pod_single_header_bgstyle = pod_theme_option('pod-single-bg-style', 'background-repeat:repeat;');
		$pod_header_par = pod_theme_option('pod-single-header-par', false);
		$pod_header_thumb_size = pod_theme_option('pod-single-header-thumbnail-size', 'thumb-size-small');
		$pod_header_thumb_radius = pod_theme_option('pod-single-header-thumbnail-radius', 'straight-corners');
		$pod_single_bg_style = pod_theme_option('pod-single-bg-style', 'background-repeat:repeat;');

		// Single audio header img
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), '' );
		$header_img = $image[0];
		$pod_single_bg_img = ( has_post_thumbnail( $post_id ) &&  $pod_single_header_display == 'has-background') ?  'background-image: url(' . $header_img . ');' : '';
		

		if( has_post_thumbnail( $post_id ) && $pod_single_header_display == "has-background" ) { ?>

			<div class="single-featured <?php echo pod_is_nav_transparent(); ?> <?php echo esc_attr( $pod_header_thumb_size ); ?> <?php echo pod_audio_format_featured_image( $post_id ); ?> <?php echo pod_has_featured_image( $post_id ); ?> format-audio" style="<?php echo esc_attr( $pod_single_header_bgstyle ); ?> <?php echo esc_attr( $pod_single_bg_img ); ?>" >
				<?php echo pod_header_parallax( $post_id ); ?>	
				<div class="background translucent">
					
		<?php } else { ?>
			<div class="single-featured format-audio <?php echo pod_is_nav_transparent(); ?> <?php echo esc_attr( $pod_header_thumb_size); ?> <?php echo esc_attr( $pod_header_thumb_radius ); ?> <?php echo pod_has_featured_image($post_id); ?> <?php echo pod_audio_format_featured_image( $post_id ); ?>  " style="<?php echo esc_attr( $pod_single_header_bgstyle ); ?>" >	
				<div class="background translucent">
		<?php } ?>

					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="single-featured-audio-container">

									<?php if( $pod_plugin_active == "ssp" ){ ?>

										<?php echo pod_single_header_audio_ssp( $post_id ); ?>

									<?php } elseif( $pod_plugin_active == "bpp" ) { ?>

										<?php echo pod_single_header_audio_bpp( $post_id ); ?>

									<?php } elseif( $pod_plugin_active == "podm" ) { ?>

										<?php echo pod_single_header_audio_podm( $post_id ); ?>
										
									<?php } else { ?>
										
									<?php } ?>

								</div><!-- single-featured-container -->
							</div><!-- col -->
						</div><!-- row -->
					</div><!-- container -->

		
			<?php if( has_post_thumbnail( $post_id ) && $pod_single_header_display == 'has-background' ) { ?>
				</div>
			<?php } else { ?>
				</div>
			<?php } ?>

			</div><!-- single-featured -->

<?php }

}

if( ! function_exists( 'pod_single_header_video' ) ) {
	function pod_single_header_video( $post_id ) {

		$pod_plugin_active = pod_get_plugin_active();

		// Variables
		$pod_single_header_display = pod_theme_option('pod-single-header-display', 'has-thumbnail');
		$pod_single_header_bgstyle = pod_theme_option('pod-single-bg-style', 'background-repeat:repeat;');
		$pod_header_par = pod_theme_option('pod-single-header-par', false);
		$pod_single_video_bg = pod_theme_option('pod-single-video-bg', false);

		$pod_single_bg_img = (has_post_thumbnail() &&  $pod_single_header_display == 'has-background') ?  'background-image: url(' . $header_img . ');' : '';
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), '' );
		$header_img = $image[0];
		
		if( has_post_thumbnail( $post_id ) && $pod_single_video_bg == true ) { ?>

			<div class="single-featured format-video <?php echo pod_is_nav_transparent(); ?> <?php echo pod_audio_format_featured_image( $post_id ); ?> <?php echo pod_has_featured_image( $post_id ); ?>" style="<?php echo esc_html( $pod_single_header_bgstyle ); ?> background-image: url(' <?php echo esc_url( $header_img ); ?> ');" >	
				<div class="background translucent">
		<?php } else { ?>

			<div class="single-featured format-video <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image($post->ID); ?> <?php echo pod_audio_format_featured_image( $post->ID ); ?>" style="<?php echo esc_attr( $pod_single_header_bgstyle ); ?>" >	
				<div class="background translucent">

		<?php } ?>

		 			<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="single-featured-video-container">

									<?php if( $pod_plugin_active == "ssp" ) { ?>

										<?php echo pod_single_header_video_ssp( $post_id ); ?>

									<?php } elseif( $pod_plugin_active == "bpp" ) { ?>

										<?php echo pod_single_header_video_bpp( $post_id ); ?>

									<?php } elseif( $pod_plugin_active == "podm" ){ ?>

										<?php echo pod_single_header_video_podm( $post_id ); ?>

									<?php } ?>

								</div><!-- single-featured-container -->
							</div><!-- col -->
						</div><!-- row -->
					</div><!-- container -->


			<?php if( has_post_thumbnail() && $pod_single_header_display == 'has-background'  && ( $format == 'video' && $pod_single_video_bg == true) ) { ?>
				</div>
			<?php } else { ?>
				</div>
			<?php } ?>

			</div><!-- single-featured -->
	<?php }
}

if( ! function_exists( 'pod_single_header_image' ) ) {
	function pod_single_header_image( $post_id ) { ?>
		<div class="single-featured format-image <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image( $post_id ); ?> <?php echo pod_audio_format_featured_image( $post_id ); ?>">	
			<div class="background translucent">

				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="single-featured-image-container">
			
								<div class="image">
									<?php echo get_the_post_thumbnail( $post_id,'regular-large' ); ?>
								</div><!-- .image -->
							</div><!-- single-featured-container -->
						</div><!-- col -->
					</div><!-- row -->
				</div><!-- container -->

			</div><!-- .background -->
		</div><!-- single-featured -->

	<?php }
}

if( ! function_exists( 'pod_use_single_sticky_audio_player' ) ) {
	function pod_use_single_sticky_audio_player( $post_id ) {
		$format = get_post_format( $post_id );
		$plugin_inuse = pod_get_plugin_active();

		if( $plugin_inuse == "podm" ) {
			$audiotype = get_post_meta( $post_id, 'cmb_thst_audio_type', true );

			if( $format == "audio" && $audiotype == "audio-url" ) {
				return true;
			}

		} elseif( $plugin_inuse == "ssp" ) {
			$ssp_format = pod_ssp_get_format( $post_id );

			if( $ssp_format == "audio" ) {
				return true;
			}
		} else {
			if( $format == "audio" ) {
				return true;
			}
		}

		
	}
}
if( ! function_exists( 'pod_single_sticky_audio_player' ) ) {
	function pod_single_sticky_audio_player( $post_id ) {
		$format = get_post_format( $post_id );
		$pod_players_preload = pod_theme_option('pod-players-preload', 'none');
		$audiotype = get_post_meta( $post_id, 'cmb_thst_audio_type', true );
		$audiourl = get_post_meta( $post_id, 'cmb_thst_audio_url', true );
		$pod_use_sticky_player = pod_use_single_sticky_audio_player( $post_id );
		$audio_shortcode_attr = array('src' => $audiourl, 'loop' => '', 'autoplay' => '', 'preload' => $pod_players_preload );
		
		$output = '';

			$output .= '<div class="sticky-featured-audio-container">';
				$output .= '<div class="sticky-featured-audio-inner">';
					if( $pod_use_sticky_player ) {
						$output .= '<div class="sticky-meta">';

							if( has_post_thumbnail() ) {
								$output  .= '<div class="sticky-art">';
									$output .= get_the_post_thumbnail( $post_id, 'square' );
								$output  .= '</div>';
							}

							$output .= '<div class="sticky-meta-text">';
								$output .= '<ul>
									<li class="title"><h4>' . get_the_title( $post_id ) . '</h4></li>
									<!--<li class="season">Season 4</li>-->
								</ul>';
							$output .= '</div>';
						$output  .= '</div>';

						$output  .= '<div class="sticky-player">';
							$output .= pod_get_featured_player( $post_id );
						$output .= '</div>';

					}
				$output .='</div>';
			$output .='</div>';

		return $output;
	}
}

if( ! function_exists( 'pod_single_header_gallery' ) ) {
	function pod_single_header_gallery( $post_id ) {

		$gallerystyle = get_post_meta( $post_id, 'cmb_thst_post_gallery_style', true );
		$galleryimgs = get_post_meta( $post_id, 'cmb_thst_gallery_list', true );
		$gallerycapt = get_post_meta( $post_id, 'cmb_thst_gallery_capt', true );
		$gallerycol = get_post_meta( $post_id, 'cmb_thst_gallery_col', true );

		if ( $galleryimgs != ''  ) { ?>
			<div class="featured-gallery">
			<?php if ( $gallerystyle == "slideshow" ) { ?>
				<div class="gallery flexslider">
					<ul class="slides">
						<?php foreach ($galleryimgs as $galleryimgsKey => $galleryimg) { 
						$imgid = $galleryimgsKey; ?>
						<li>
					    <?php echo wp_get_attachment_image( $imgid, 'regular-large' ); ?>
					    </li>
						<?php } ?>
					</ul>
				</div><!-- gallery.flexslider -->
			<?php } else { ?>
				<div class="gallery grid clearfix <?php echo esc_attr( $gallerycol ); ?>">
					<?php foreach ( $galleryimgs as $galleryimgsKey => $galleryimg ) {
						$imgid = $galleryimgsKey; ?>
						<div class="gallery-item">
						<a href="<?php echo esc_attr( $galleryimg ); ?>" data-lightbox="lightbox">
						<?php echo wp_get_attachment_image( $imgid, 'square-large' ); ?>
						</a>
					</div>
					<?php } ?>
				</div><!-- gallery.grid -->
			<?php } ?>
			</div>
		<?php } 
	}
}

/*
 *
 * PLAYERS
 *-------------------------------------------------------*/

if( ! function_exists( 'pod_get_duration' ) ) {
	function pod_get_duration( $post_id='' ) {
		$pl_active = pod_get_plugin_active();
		$o = '';

		if( $pl_active == "bpp" ) {
			$bpp_episode_data = powerpress_get_enclosure_data($post_id, $feed_slug='podcast');
			$bpp_duration = isset($bpp_episode_data["duration"]) ? $bpp_episode_data["duration"] : '';
			$o = $bpp_duration;

		} elseif( $pl_active == "ssp" ) {
			$ssp_duration = get_post_meta( $post_id, 'duration', true );
			$o = $ssp_duration;

		} else {
			$pod_media_att_id = get_post_meta( $post_id, 'cmb_thst_audio_url_id', true );
			$pod_media_meta = wp_get_attachment_metadata( $pod_media_att_id, true );
			$pod_duration = isset($pod_media_meta["length_formatted"]) ? $pod_media_meta["length_formatted"] : '';
			$o = $pod_duration;
		}

		return $o;
	}
}

if( ! function_exists( 'pod_get_duration_minutes' ) ) {
	function pod_get_duration_minutes( $post_id='' ) {
		$pl_active = pod_get_plugin_active();

		if( $pl_active == "bpp" ) {

			$bpp_episode_data = powerpress_get_enclosure_data($post_id, $feed_slug='podcast');
			$bpp_duration = isset($bpp_episode_data["duration"]) ? $bpp_episode_data["duration"] : '';
			return pod_length_to_minutes( $bpp_duration );

		} elseif( $pl_active == "ssp" ){

			$ssp_duration = get_post_meta( $post_id, 'duration', true );
			return pod_length_to_minutes( $ssp_duration );

		} else {
			if( function_exists( "pod_media_duration" ) ) {
				return pod_length_to_minutes( pod_media_duration( $post_id ) );
			}
		}

		return false;
	}
}


if( ! function_exists('pod_human_filesize') ){
    function pod_human_filesize($bytes, $decimals = 2) {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $size[$factor];
    }
}

/**
 * Formats raw length into either minutes:seconds or hours:minutes:seconds.
 *
 * @since 1.0
 *
 * @param int $raw_length - raw length in seconds
 * @return string $length_formatted - Formatted length.
 */
if( !function_exists( 'pod_format_raw_length' ) ) {
	function pod_format_raw_length( $raw_length=0 ) {
		$length_formatted = '';

		if( $raw_length < 3600 ) {
			$length_formatted = gmdate("i:s", $raw_length);
		} else {
			$length_formatted = gmdate("H:i:s", $raw_length);
		}

		return $length_formatted;
	}
}

/**
 * Formats length into either rounded off amount of minutes.
 *
 * @since 1.0
 *
 * @param int $length - length, already preformatted into minutes:seconds or hours:minutes:seconds
 * @return string $length_in_minutes - Formatted length.
 */
if( !function_exists( 'pod_length_to_minutes' ) ) {
	function pod_length_to_minutes( $length ) {

		/* Patterns to search for */
		$hms = '/^[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$/';
        $ms = '/^[0-9]{1,2}:[0-9]{1,2}$/';

        if ( preg_match( $hms, $length ) ) {
            $strlength = sscanf($length, "%d:%d:%d", $hours, $minutes, $seconds);

            if( $seconds >= 30 ) {
                $length_in_minutes = $hours * 60 + $minutes + 1;
            } else {
                $length_in_minutes = $hours * 60 + $minutes;
            }
        } elseif ( preg_match( $ms, $length ) ) {
            $strlength = sscanf($length, "%d:%d", $minutes, $seconds);
            
            if( $seconds >= 30 ) {
                $length_in_minutes = $minutes + 1;
            } else {
                $length_in_minutes = $minutes;
            }
        } else {
            $length_in_minutes = 0;
        }
		
		if( $length_in_minutes == 1 ) {
			$length_in_minutes = $length_in_minutes . ' <span class="minute-label"> ' . __('minute', 'podcaster') . '</span>';
		} elseif( $length_in_minutes > 1 ) {
			$length_in_minutes = $length_in_minutes . ' <span class="minute-label"> ' . __('minutes', 'podcaster') . '</span>';
		} else {
			$length_in_minutes = $length_in_minutes . ' <span class="minute-label"> ' . __('minutes', 'podcaster') . '</span>';
		}

        return $length_in_minutes;
	}
}

if( ! function_exists( 'pod_get_size' ) ) {
	function pod_get_size( $post_id='' ){
		$pl_active = pod_get_plugin_active();
		$o = '';

		if( $pl_active == "bpp" ) {
			$bpp_episode_data = powerpress_get_enclosure_data($post_id, $feed_slug='podcast');
			$bpp_size_bytes = isset($bpp_episode_data["size"]) ? $bpp_episode_data["size"] : '';
			$bpp_size_human = pod_human_filesize($bpp_size_bytes);
			$o = $bpp_size_human;

		} elseif( $pl_active == "ssp" ) {
			$ssp_size = get_post_meta( $post_id, 'filesize', true );
			$o = $ssp_size;

		} else {
			$pod_media_att_id = get_post_meta( $post_id, 'cmb_thst_audio_url_id', true );
			$pod_media_meta = wp_get_attachment_metadata( $pod_media_att_id, true );
			$pod_size_bytes = isset($pod_media_meta["filesize"]) ? $pod_media_meta["filesize"] : '';
			$pod_size_human = pod_human_filesize($pod_size_bytes);
			$o = $pod_size_human;
		}

		return $o;
	}
}








/*
 *
 * ICONS
 *-------------------------------------------------------*/
if( ! function_exists( "social_media_icon_a_p" ) ) {
	function social_media_icon_a_p() {
		return '<span class="svg_icon"><svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Apple Podcasts</title><path d="M5.34 0A5.328 5.328 0 000 5.34v13.32A5.328 5.328 0 005.34 24h13.32A5.328 5.328 0 0024 18.66V5.34A5.328 5.328 0 0018.66 0zm6.525 2.568c2.336 0 4.448.902 6.056 2.587 1.224 1.272 1.912 2.619 2.264 4.392.12.59.12 2.2.007 2.864a8.506 8.506 0 01-3.24 5.296c-.608.46-2.096 1.261-2.336 1.261-.088 0-.096-.091-.056-.46.072-.592.144-.715.48-.856.536-.224 1.448-.874 2.008-1.435a7.644 7.644 0 002.008-3.536c.208-.824.184-2.656-.048-3.504-.728-2.696-2.928-4.792-5.624-5.352-.784-.16-2.208-.16-3 0-2.728.56-4.984 2.76-5.672 5.528-.184.752-.184 2.584 0 3.336.456 1.832 1.64 3.512 3.192 4.512.304.2.672.408.824.472.336.144.408.264.472.856.04.36.03.464-.056.464-.056 0-.464-.176-.896-.384l-.04-.03c-2.472-1.216-4.056-3.274-4.632-6.012-.144-.706-.168-2.392-.03-3.04.36-1.74 1.048-3.1 2.192-4.304 1.648-1.737 3.768-2.656 6.128-2.656zm.134 2.81c.409.004.803.04 1.106.106 2.784.62 4.76 3.408 4.376 6.174-.152 1.114-.536 2.03-1.216 2.88-.336.43-1.152 1.15-1.296 1.15-.023 0-.048-.272-.048-.603v-.605l.416-.496c1.568-1.878 1.456-4.502-.256-6.224-.664-.67-1.432-1.064-2.424-1.246-.64-.118-.776-.118-1.448-.008-1.02.167-1.81.562-2.512 1.256-1.72 1.704-1.832 4.342-.264 6.222l.413.496v.608c0 .336-.027.608-.06.608-.03 0-.264-.16-.512-.36l-.034-.011c-.832-.664-1.568-1.842-1.872-2.997-.184-.698-.184-2.024.008-2.72.504-1.878 1.888-3.335 3.808-4.019.41-.145 1.133-.22 1.814-.211zm-.13 2.99c.31 0 .62.06.844.178.488.253.888.745 1.04 1.259.464 1.578-1.208 2.96-2.72 2.254h-.015c-.712-.331-1.096-.956-1.104-1.77 0-.733.408-1.371 1.112-1.745.224-.117.534-.176.844-.176zm-.011 4.728c.988-.004 1.706.349 1.97.97.198.464.124 1.932-.218 4.302-.232 1.656-.36 2.074-.68 2.356-.44.39-1.064.498-1.656.288h-.003c-.716-.257-.87-.605-1.164-2.644-.341-2.37-.416-3.838-.218-4.302.262-.616.974-.966 1.97-.97z"/></svg></span>';
	}
}

if( ! function_exists( "social_media_icon_g_p" ) ) {
	function social_media_icon_g_p() {
		return '<span class="svg_icon"><svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Google Podcasts</title><path d="M1.5 9.68c-.83 0-1.5.67-1.5 1.5V12.81a1.5 1.5 0 1 0 3 0v-1.63c0-.83-.67-1.5-1.5-1.5zM22.5 9.68c-.83 0-1.5.67-1.5 1.5V12.81a1.5 1.5 0 1 0 3 0v-1.63c0-.83-.67-1.5-1.5-1.5zM6.68 14.59c-.83 0-1.5.67-1.5 1.5V17.72a1.5 1.5 0 1 0 3 0V16.1c0-.83-.67-1.5-1.5-1.5zM6.68 4.77c-.83 0-1.5.67-1.5 1.5V11.63a1.5 1.5 0 0 0 3 0V6.26c0-.83-.67-1.5-1.5-1.5zM17.32 4.77c-.83 0-1.5.67-1.5 1.5V7.91a1.5 1.5 0 0 0 3 0V6.27c0-.83-.67-1.5-1.5-1.5zM12 0c-.83 0-1.5.67-1.5 1.5v1.63a1.5 1.5 0 1 0 3 0V1.5C13.5.67 12.83 0 12 0zM12 19.36c-.83 0-1.5.67-1.5 1.5V22.5a1.5 1.5 0 1 0 3 .01v-1.64c0-.82-.67-1.5-1.5-1.5zM17.32 10.9c-.83 0-1.5.68-1.5 1.5v5.33a1.5 1.5 0 0 0 3 0V12.4c0-.83-.67-1.5-1.5-1.5zM12 6.13c-.83 0-1.5.68-1.5 1.5v8.73a1.5 1.5 0 0 0 3 0V7.64c0-.83-.67-1.5-1.5-1.5z"/></svg></span>';
	}
}

if( ! function_exists( "social_media_icon_s" ) ) {
	function social_media_icon_s() {
		return '<span class="svg_icon"><svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Stitcher</title><path d="M19.59 8.516H24v6.928h-4.41zM0 8.854h4.41v7.803H0zm4.914-1.328h4.388v8.572H4.914zm4.892.725h4.388v8.81H9.806zm4.892-1.312h4.388v9.158h-4.388Z"/></svg></span>';
	}
}

if( ! function_exists( "social_media_icon_p_c" ) ) {
	function social_media_icon_p_c() {
		return '<span class="svg_icon"><svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Pocket Casts</title><path d="M12,0C5.372,0,0,5.372,0,12c0,6.628,5.372,12,12,12c6.628,0,12-5.372,12-12 C24,5.372,18.628,0,12,0z M15.564,12c0-1.968-1.596-3.564-3.564-3.564c-1.968,0-3.564,1.595-3.564,3.564 c0,1.968,1.595,3.564,3.564,3.564V17.6c-3.093,0-5.6-2.507-5.6-5.6c0-3.093,2.507-5.6,5.6-5.6c3.093,0,5.6,2.507,5.6,5.6H15.564z M19,12c0-3.866-3.134-7-7-7c-3.866,0-7,3.134-7,7c0,3.866,3.134,7,7,7v2.333c-5.155,0-9.333-4.179-9.333-9.333 c0-5.155,4.179-9.333,9.333-9.333c5.155,0,9.333,4.179,9.333,9.333H19z"/></svg></span>';
	}
}

if( ! function_exists( "social_media_icon_ihr" ) ) {
	function social_media_icon_ihr() {
		return '<span class="svg_icon"><svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>iHeartRadio</title><path d="M4.403 21.983c.597 0 1.023-.306 1.023-.817v-.012c0-.489-.375-.784-1.017-.784H3.182v1.613zm-1.67-1.8c0-.125.102-.228.221-.228h1.489c.488 0 .88.148 1.13.398.193.193.307.472.307.784v.011c0 .654-.443 1.034-1.062 1.154l.988 1.272c.046.051.074.102.074.164 0 .12-.114.222-.227.222-.091 0-.16-.05-.21-.12l-1.12-1.453H3.183v1.346a.228.228 0 01-.228.227.227.227 0 01-.221-.227v-3.55m6.674 2.29l-.914-2.035-.915 2.034zm-2.812 1.164l1.614-3.528c.056-.125.142-.2.284-.2h.022c.137 0 .228.075.279.2l1.613 3.522a.31.31 0 01.029.113c0 .12-.097.216-.216.216-.108 0-.182-.074-.222-.165l-.415-.914H7.402l-.415.926c-.04.097-.113.153-.216.153a.204.204 0 01-.204-.204.26.26 0 01.028-.12m6.078-.118c1.005 0 1.647-.682 1.647-1.563v-.011c0-.88-.642-1.574-1.647-1.574h-.932v3.148zm-1.38-3.335c0-.125.102-.228.221-.228h1.16c1.249 0 2.112.858 2.112 1.977v.012c0 1.119-.863 1.988-2.113 1.988h-1.159a.226.226 0 01-.221-.227v-3.522m4.481-.029c0-.124.103-.227.222-.227.125 0 .227.103.227.227v3.579a.228.228 0 01-.227.227.227.227 0 01-.222-.227v-3.579m5.027 1.801v-.011c0-.904-.659-1.642-1.568-1.642s-1.556.727-1.556 1.63v.012c0 .903.659 1.642 1.567 1.642.91 0 1.557-.728 1.557-1.631zm-3.59 0v-.011c0-1.097.824-2.057 2.033-2.057 1.21 0 2.023.949 2.023 2.045v.012c0 1.096-.824 2.056-2.034 2.056s-2.022-.949-2.022-2.045m2.03-17.192c0 1.397-.754 2.773-2.242 4.092a.345.345 0 01-.458-.517c1.333-1.182 2.01-2.385 2.01-3.575v-.016c0-.966-.606-2.103-1.38-2.588a.345.345 0 11.367-.586c.97.61 1.703 1.974 1.703 3.174zM14.76 7.677a.345.345 0 11-.337-.602c.799-.448 1.336-1.318 1.339-2.167a2.096 2.096 0 00-1.124-1.855.345.345 0 11.321-.611 2.785 2.785 0 011.493 2.46v.011c-.004 1.09-.683 2.199-1.692 2.764zm-2.772-1.015a1.498 1.498 0 11.001-2.997 1.498 1.498 0 01-.001 2.997zm-2.303.882a.345.345 0 01-.47.133c-1.009-.565-1.688-1.674-1.692-2.764v-.01a2.785 2.785 0 011.493-2.461.346.346 0 01.321.611 2.096 2.096 0 00-1.124 1.855c.003.849.54 1.719 1.34 2.166a.345.345 0 01.132.47zM7.464 8.825a.344.344 0 01-.488.03C5.49 7.536 4.734 6.16 4.734 4.763v-.016c0-1.2.732-2.564 1.703-3.174a.346.346 0 01.367.586c-.774.485-1.38 1.622-1.38 2.588v.016c0 1.19.677 2.393 2.01 3.575a.345.345 0 01.03.487zM16.152 0c-1.727 0-3.27.915-4.164 2.252C11.094.915 9.55 0 7.823 0A4.982 4.982 0 002.84 4.983c0 1.746 1.106 3.005 2.261 4.17l4.518 4.272a.371.371 0 00.626-.27V9.827c0-.963.78-1.743 1.743-1.745a1.745 1.745 0 011.742 1.745v3.328c0 .326.39.493.626.27l4.518-4.272c1.155-1.165 2.261-2.424 2.261-4.17A4.982 4.982 0 0016.152 0M4.582 14.766h1.194v1.612h1.532v-1.612H8.5v4.307H7.308v-1.637H5.776v1.637H4.582v-4.307m6.527 2.353a.563.563 0 00-.578-.587c-.308 0-.55.238-.578.587zm-2.264.305v-.012c0-.972.696-1.741 1.68-1.741 1.15 0 1.68.842 1.68 1.82 0 .075 0 .16-.007.24H9.971c.093.364.357.549.72.549.277 0 .498-.105.738-.34l.647.536c-.32.406-.782.677-1.447.677-1.045 0-1.784-.695-1.784-1.729m7.29-1.68h1.17v.67c.19-.454.498-.75 1.051-.725v1.23h-.098c-.609 0-.954.351-.954 1.12v1.034h-1.168v-3.329m2.95 2.295v-1.353h-.393v-.942h.393v-.842h1.17v.842h.775v.942h-.775v1.126c0 .234.105.332.32.332.153 0 .301-.043.442-.11v.916c-.209.117-.485.19-.812.19-.7 0-1.12-.307-1.12-1.1m-15.65-3.584a.62.62 0 100 1.24.62.62 0 000-1.24m10.502 3.952c-.303.013-.483-.161-.483-.371 0-.203.16-.307.454-.307h.667v.036c-.004.137-.06.617-.638.642zm1.746-1.008c0-1.033-.739-1.729-1.784-1.729-.665 0-1.126.271-1.447.677l.647.536c.24-.234.461-.34.738-.34.359 0 .621.182.716.537l.001.025-.77.003c-.956.013-1.458.37-1.458 1.045 0 .65.464.999 1.262.999.432 0 .764-.17.987-.401v.32h1.106v-1.628l.002-.032V17.4M3.458 15.99h-.043a.61.61 0 00-.61.61v2.474h1.263v-2.474a.61.61 0 00-.61-.61"/></svg></span>';
	}
}