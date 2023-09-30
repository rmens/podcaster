<?php

/**
 * Apply custom body classes including values from the theme options.
 *
 * @since 1.6.2
 * @return array $classes - Array containing custom classes.
 */
if( ! function_exists( 'pod_body_classes_theme_options' ) ){
	function pod_body_classes_theme_options($classes) {
		$post_id = get_the_ID();
		$pod_res_style = pod_theme_option('pod-responsive-style', 'toggle');
		$pod_filter_active = pod_theme_option('pod-filter-active', true);
		$pod_transparent_single_audio_player = pod_theme_option('pod-single-audio-transparent-active', true);
		$pod_custom_single_audio_colors_player = pod_theme_option('pod-single-audio-color-activate', false);

		// Menu
		$pod_is_menu_transparent = pod_is_nav_transparent();
	
		/* Social Media active */
		$pod_social_media_header_active =  pod_theme_option('pod-social-nav', true);

		/* Template width */
		$pod_template_width = pod_theme_option('pod-general-tempalte-width', 'template-width-fixed');

		/* Dark Theme */
		$pod_templ_color = pod_theme_option('pod-color-darklight', 'classic');
		$pod_templ_color_output = ( $pod_templ_color == "dark" ) ? "dark-template-active" : "light-template-active";

		/* Single & Page Alignment */
		$pod_alignment_no_sidebar = pod_theme_option('pod-alignment-no-sidebar', 'align-content-left');

		/* Player Settings */
		$pod_audio_player_volume = pod_theme_option('pod-audio-players-volume', 'horizontal');
		$pod_players_corner_style = pod_theme_option( 'pod-players-corners','players-corners-round' );
		$pod_players_style = pod_theme_option( 'pod-players-style', 'players-style-classic' );

		/* Soundcloud settings */
		$pod_sc_player = pod_theme_option('pod-audio-soundcloud-player-style', 'sc-classic-player');


		$classes[] = 'responsive-menu-' . $pod_res_style;
		$classes[] = $pod_templ_color_output;
		$classes[] = $pod_alignment_no_sidebar;
		$classes[] = $pod_players_style;
		$classes[] = $pod_players_corner_style;

		$classes[] = $pod_sc_player;

		$classes[] = $pod_template_width;
		
	
		if( ! has_nav_menu( 'header-menu' ) ) {
			$classes[] = "header-menu-inactive";
		}

		if( $pod_filter_active == true ){
			$classes[] = 'header-filter-active';
		}

		if( $pod_social_media_header_active == true ) {
			$classes[] = 'social-media-nav-active';
		}

		if( $pod_audio_player_volume == "vertical") {
			$classes[] = 'vertical-audio-vol-active';
		}

		//check if transparent navigation menu is active
		$classes[] = $pod_is_menu_transparent;


		// Single audio/video color and transparency settings
		$format = get_post_format();
		$plugin_active = pod_get_plugin_active();

		if( $plugin_active == "ssp" ) {
			$format = pod_ssp_get_format( $post_id );
		}

		if( is_single() && ( $format == "audio" || $format == "video" ) ) {
			if($pod_transparent_single_audio_player == true ) {
				$classes[] = "single-transparent-audio-active";
			} else {
				$classes[] = "single-transparent-audio-inactive";
			}

			if( $pod_custom_single_audio_colors_player == true ) {
				$classes[] = "single-custom-color-audio-active";
			} else {
				$classes[] = "single-custom-color-audio-inactive";
			}
		}

	    return $classes;
	}
}
add_filter('body_class', 'pod_body_classes_theme_options');

if ( ! function_exists( 'pod_body_classes_front_page_classes' ) ) {
	function pod_body_classes_front_page_classes($classes) {
		

		/* Front Page Header */
		$pod_audio_player_width = pod_theme_option('pod-audio-player-width', 'fh-audio-player-full');
		$pod_audio_player_align = pod_theme_option('pod-audio-player-aligment', 'fh-audio-player-left');
		$pod_heading_width = pod_theme_option( 'pod-fh-heading-width', 'fh-heading-full' );
		$pod_content_position = pod_theme_option('pod-front-page-content-position', 'content-above-episodes');
		$pod_nextweek_style = pod_theme_option( 'pod-frontpage-nextweek-style', 'nextweek-background' );
		$pod_nextweek_corners = pod_theme_option( 'pod-color-advanced-scheduled-corners', 'next-week-corners-round' );


		$pod_fp_style = pod_theme_option('pod-front-style', 'front-page-list');
		$pod_fp_cols = pod_theme_option('pod-front-style-cols', 'front-page-cols-3');
		if( $pod_fp_style == "front-page-fit-grid") {
			$pod_fp_style .= " front-page-grid ";
		}

		$pod_custom_front_page_audio_colors_player = pod_theme_option('pod-front-page-audio-color-activate', false);
		$pod_custom_front_page_audio_transparent_player = pod_theme_option('pod-front-page-audio-transparent-active', true);

		$pod_fph_seperator_active = pod_theme_option( 'pod-featured-header-seperator-active', false );
		$pod_fph_seperator_style = pod_theme_option( 'pod-featured-header-seperator-style', 'sep-style-wave-1' );




		if( ! is_home() && is_front_page() ) {
			$pod_fp_image = pod_has_featured_image();
			$classes[] = $pod_fp_image;
			$classes[] = $pod_fp_style;
			$classes[] = $pod_fp_cols;

			if( $pod_custom_front_page_audio_transparent_player == true && $pod_custom_front_page_audio_colors_player == true ) {
				$classes[] = "front-page-transparent-audio-active";
			} else {
				$classes[] = "front-page-transparent-audio-inactive";
			}

			if( $pod_custom_front_page_audio_colors_player == true ) {
				$classes[] = "front-page-custom-color-audio-active";
			} else {
				$classes[] = "front-page-custom-color-audio-inactive";
			}

			$classes[] = $pod_audio_player_width;
			$classes[] = $pod_audio_player_align;
			$classes[] = $pod_heading_width;

			$classes[] = 'front-page-' . $pod_content_position;
			$classes[] = $pod_nextweek_style;
			$classes[] = $pod_nextweek_corners;

			if( $pod_fph_seperator_active ) {
				$classes[] = 'header-divider-active ' . $pod_fph_seperator_style;
			}

		}

		return $classes;
	}
}
add_filter('body_class', 'pod_body_classes_front_page_classes');

if( ! function_exists( 'pod_body_classes_single_audio' ) ) {
	function pod_body_classes_single_audio($classes) {
		

		/* Single Audio Sticky */
		$pod_single_sticky_audio_player = pod_theme_option( 'pod-single-header-player-display', 'player-in-header' );
		$pod_single_sticky_audio_player_output = ( $pod_single_sticky_audio_player == "player-in-footer" ) ? 'sticky-featured-audio-active' : 'sticky-featured-audio-inactive';

		if( is_single() && get_post_format() == "audio" ) {
			$classes[] = $pod_single_sticky_audio_player_output;
		}
		return $classes;
	}
}
add_filter('body_class', 'pod_body_classes_single_audio');

if( ! function_exists( 'pod_body_classes_podcast_archive' ) ) {
	function pod_body_classes_podcast_archive( $classes ) {

		/* Podcast Archive Pages */
		$pod_arch_corners = pod_theme_option( 'pod-archive-rounded-corners', 'pod-archive-corners-straight' );
		
		if( is_page_template( 'page/page-podcastarchive-grid.php' ) || is_page_template( 'page/page-podcastarchive-list.php' ) || is_page_template( 'page/page-podcastarchive-grid-classic.php' ) || is_page_template( 'page/page-podcastarchive-list-classic.php' ) || is_page_template( 'page/page-podcastarchive.php' ) ) {
			$classes[] = $pod_arch_corners;
		}
		return $classes;
	}
}
add_filter('body_class', 'pod_body_classes_podcast_archive');


/*
 *
 * THEME OPTIONS: General
 *-------------------------------------------------------*/
/**
 * pod_is_nav_transparent()
 * Checks if the navigation bar is set to transparent in the theme options.
 *
 * @return string $output - custom class depending on whether the navigation bar is transparent or not.
 */
if( ! function_exists('pod_is_nav_transparent') ) {
	function pod_is_nav_transparent() {
		$is_transparent = pod_theme_option('pod-nav-bg', '#282d31');

		if( $is_transparent == 'transparent' ) {
			$output = 'nav-transparent';
		} else {
			$output = 'nav-solid';
		}
		return $output;
	}
}

/**
 * pod_is_nav_sticky()
 * Checks if the navigation bar is set to "sticky" in the theme options.
 *
 * @return string $output - custom class depending on whether the navigation bar is sticky or not.
 */
if( ! function_exists( 'pod_is_nav_sticky' ) ) {
	function pod_is_nav_sticky( $classes = "" ) {

		$is_sticky = pod_theme_option( 'pod-sticky-header', false );

		if( $is_sticky == true ) {
			$output = 'nav-sticky ' . $classes;
		} else {
			$output = 'nav-not-sticky';
		}

		return $output;
	}
}

/**
 * pod_audio_format_featured_image()
 * Checks if the featured image is to be displayed as thumbnail or background in an audio post.
 *
 * @return string $output - custom class depending on whether the featured image is set to thumbnail or background.
 */
if( ! function_exists('pod_audio_format_featured_image') ) {
	function pod_audio_format_featured_image( $post_id=NULL ) {
		$audio_featured_img = pod_theme_option('pod-single-header-display', 'has-thumbnail');
		$format = get_post_format( $post_id );
		$is_single = is_single( $post_id );

		$plugin_active = pod_get_plugin_active();
		if( $plugin_active == "ssp" ) {
			$format = pod_ssp_get_format( $post_id );
		}


		if( $is_single && $format =='audio' ) {

			if( $audio_featured_img == 'has-background' ) {
				$output = 'media-featured-image-background audio-featured-image-background';
			} elseif( $audio_featured_img == 'has-thumbnail' ) {
				$output = 'audio-featured-image-thumbnail';
			} else {
				$output = '';
			}

		} elseif( $is_single && $format =='video' ) {

			$output = 'media-featured-image-background video-featured-image-background';

		} else {

			$output = '';

		}

		return $output;
	}
}


/*
 *
 * THEME OPTIONS: TYPOGRAPHY
 *-------------------------------------------------------*/

/* Functions for the improved featured header for the front page */
if( ! function_exists( 'pod_themeoption_typekit' ) ) {
	function pod_themeoption_typekit() {
		$pod_typekit_code = pod_theme_option('pod-typekit-code', '');

		if( $pod_typekit_code != '') {
			$code = $pod_typekit_code;
			echo wp_kses( $code, array( "link" => array( "rel" => array(), "href" => array(), "type" => array() ), "script" => array( "src" => array() ) ) );
		}
	}
}
add_action('wp_head','pod_themeoption_typekit');

if( ! function_exists( 'pod_themeoption_css' ) ) {
	function pod_themeoption_css() {

		$themePrimary = pod_theme_option('pod-color-primary');
		$themeNavBg = pod_theme_option('pod-nav-bg');
		$themeNavText = pod_theme_option('pod-nav-color', '#1e7ce8');
		$themeNavTextHover = pod_theme_option('pod-nav-hover-color', '#ffffff');
		$themeNavBgIfTransparent = pod_theme_option('pod-nav-bg-if-transparent', '#282d31');

		
		$css = '<style>';

			$css .='/* Media Queries */
			/* Larger than 1024px width */
			@media screen and (min-width: 1025px) {
				nav .thst-menu li:hover > .sub-menu {
					background:'. $themePrimary . ';
				}

				nav .thst-menu li > .sub-menu li a:link,
				nav .thst-menu li > .sub-menu li a:visited {
					background-color:'. $themePrimary .';
				}
			}

			/* Smaller than 1024px width */
			@media screen and (max-width: 1200px) {
				nav .thst-menu li > .sub-menu li a:link,
				nav .thst-menu li > .sub-menu li a:visited {
					background-color: transparent;
				}
				.responsive-sidebar .sidebar {
			        color:'. $themePrimary . ';
			    }
			}

			@media screen and (max-width: 1024px) {
				header .main-title a {
					background-position: center;
				}
				.above.toggle,
				.above.transparent.large_nav.toggle,
				.above.large_nav.toggle,
				.above.transparent.small_nav.toggle,
			  	.above.small_nav.toggle  {
			  		background-color:'. $themeNavBg . ';
				}
				#nav.drop .thst-menu li.menu-item-has-children > .sub-menu li a:link,
				#nav.drop .thst-menu li.menu-item-has-children > .sub-menu li a:visited {
					background-color:'. $themeNavBg . ';
				}
				#nav .thst-menu li > .sub-menu li a:link,
                #nav .thst-menu li > .sub-menu li a:visited,
                #nav.toggle .thst-menu li > .sub-menu li a:link,
                #nav.toggle .thst-menu li > .sub-menu li a:visited {
					color:' . $themeNavText . ';
				}
				.nav-solid #nav.toggle,
				.nav-solid #nav.drop {
					background-color:'. $themeNavBg . ';
				}
				.nav-transparent #nav.toggle,
				.nav-transparent #nav.drop {
					background-color:'. $themeNavBgIfTransparent . ';
				}

				/* Transparent menu when forced to be static*/
				.above.nav-transparent.has-featured-image.nav-not-sticky,
				.above.nav-transparent.has-featured-image.large_nav {
					background:'. $themeNavBgIfTransparent . ' !important;
				}
				.above.nav-transparent.has-featured-image.nav-not-sticky header .main-title a:link,
				.above.nav-transparent.has-featured-image.nav-not-sticky header .main-title a:visited,
				.above.nav-transparent.has-featured-image.large_nav header .main-title a:link, 
				.above.nav-transparent.has-featured-image.large_nav header .main-title a:visited, 
				.above.nav-transparent.has-featured-image.nav-not-sticky #nav .thst-menu > li > a:link, 
				.above.nav-transparent.has-featured-image.nav-not-sticky #nav .thst-menu > li > a:visited, 
				.above.nav-transparent.has-featured-image.large_nav #nav .thst-menu > li > a:link, 
				.above.nav-transparent.has-featured-image.large_nav #nav .thst-menu > li > a:visited, 
				.above.nav-transparent.has-featured-image.nav-not-sticky .nav-search-form .open-search-bar .fa, 
				.above.nav-transparent.has-featured-image.large_nav .nav-search-form .open-search-bar .fa,
				.dark-icons .above.nav-transparent.has-featured-image.nav-not-sticky .social_icon::before, 
				.dark-icons .above.nav-transparent.has-featured-image.large_nav .social_icon::before, 
				.light-icons .above.nav-transparent.has-featured-image.nav-not-sticky .social_icon::before, 
				.light-icons .above.nav-transparent.has-featured-image.large_nav .social_icon::before {
					color: ' . $themeNavText . ';
				}
				.dark-icons .above.nav-transparent.has-featured-image.large_nav .svg_icon_cont svg, 
				.light-icons .above.nav-transparent.has-featured-image.large_nav .svg_icon_cont svg, 
				.dark-icons .above.nav-transparent.has-featured-image.nav-not-sticky .svg_icon_cont svg, 
				.light-icons .above.nav-transparent.has-featured-image.nav-not-sticky .svg_icon_cont svg {
					fill: ' . $themeNavText . ';
				}
				.above.nav-transparent.has-featured-image.nav-not-sticky header .main-title a:hover,
                    .above.nav-transparent.has-featured-image.large_nav header .main-title a:hover,
                    .above.nav-transparent.has-featured-image.nav-not-sticky #nav .thst-menu > li > a:hover,
                    .above.nav-transparent.has-featured-image.large_nav #nav .thst-menu > li > a:hover,
                    .above.nav-transparent.has-featured-image.large_nav .nav-search-form .open-search-bar .fa:hover {
                    	color: ' . $themeNavTextHover . ';
                    }
				#nav .thst-menu li.menu-item-has-children a:hover,
				#nav .thst-menu li.menu-item-has-children > .sub-menu li a:hover {
					background:rgba(0,0,0,0.2);
				}
			}';

		$css .= '</style>';


		$css = str_replace(PHP_EOL, '', $css);
		$css = trim(preg_replace('!\s+!', ' ', $css));
		echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));
	}
}
add_action("wp_head", "pod_themeoption_css", 1000, 0);

if( ! function_exists( 'pod_themeoption_typography_css' ) ) {
	function pod_themeoption_typography_css() {

		/* Typography */
		$pod_typography = pod_theme_option('pod-typography', 'sans-serif');
		$pod_typo_featured_text = pod_theme_option('pod-typo-featured-text');


			$css = '<style>';
			if ( $pod_typography == "serif" ) {
				$css .= 'body {
					font-family: "Lora", "Georgia", serif;
				}
				h1, h2, h3, h4, h5, h6 {
					font-family: "Lora", "Georgia", serif;
				}
				input[type="text"],
				input[type="email"] {
					font-family: "Lora", "Georgia", serif;
				}
				textarea {
					font-family: "Lora", "Georgia", serif;
				}
				input[type="submit"],
				.form-submit #submit,
				#respond #commentform #submit,
				a.butn:link,
				a.butn:visited,
				.butn {
					font-family: "Lora", "Georgia", serif;
				}
				#respond #commentform #submit {
					font-family: "Lora", "Georgia", serif;
				}
				input.secondary[type="submit"],
				#respond #cancel-comment-reply-link:link,
				#respond #cancel-comment-reply-link:visited,
				#comments .commentlist li .comment-body .reply a:link,
				#comments .commentlist li .comment-body .reply a:visited {
					font-family: "Lora", "Georgia", serif;
				}
				.header header .main-title a {
					font-family: "Lora", "Georgia", serif;
				}
				.singlep_pagi {
					font-family: "Lora", "Georgia", serif;
				}
				.page .reg .heading h1,
				.podcast-archive .reg .heading h1 {
					font-family: "Lora", "Georgia", serif;
				}
				.arch_searchform #ind_searchform div #ind_s {
					font-family: "Lora", "Georgia", serif;
				}
				a.thst-button,
				a.thst-button:visited {
					font-family: "Lora", "Georgia", serif;
				}';
			}
			$css .= '</style>';


			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));
			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_themeoption_typography_css", 1000, 0);

if( ! function_exists( 'pod_themeoption_transparent_headers_css' ) ) {
	function pod_themeoption_transparent_headers_css() {
		
		$pod_head_transparent_active = pod_theme_option('pod-nav-bg-is-transparent', false);
		$pod_head_transparent_bg_rgba = pod_theme_option('pod-nav-bg-transparent-color', 'rgba(0,0,0,0.15)');
		$pod_nav_hover_bg_rgba = pod_theme_option('pod-nav-hover-bg-color', 'rgba(0,0,0,0.5)');
		$pod_head_transparent_active = pod_theme_option('pod-nav-bg', '#282d31');
		$pod_head_transparent_active = ( $pod_head_transparent_active == "transparent" ) ? true : false;
		
		/* Transparent Headers */
		$pod_head_transparent_bg = pod_theme_option('pod-nav-bg-transparent-color');
		$pod_head_transparent_bg_rgba = isset( $pod_head_transparent_bg['rgba'] ) ? $pod_head_transparent_bg['rgba'] : '';
		$pod_head_transparent_bg_color = isset( $pod_head_transparent_bg['color'] ) ? $pod_head_transparent_bg['color'] : '';
		$pod_head_transparent_bg_alpha = isset( $pod_head_transparent_bg['alpha'] ) ? $pod_head_transparent_bg['alpha'] : 1;
		$pod_head_transparent_bg_opacity = 1.0 - $pod_head_transparent_bg_alpha;

		/* Transparent Hover (Navigation) */ 
		$pod_nav_hover_bg = pod_theme_option('pod-nav-hover-bg-color');
		$pod_nav_hover_bg_rgba = isset( $pod_nav_hover_bg['rgba'] ) ? $pod_nav_hover_bg['rgba'] : '';
		$pod_nav_hover_bg_color = isset( $pod_nav_hover_bg['color'] ) ? $pod_nav_hover_bg['color'] : '';
		$pod_nav_hover_bg_alpha = isset( $pod_nav_hover_bg['alpha'] ) ? $pod_nav_hover_bg['alpha'] : 1;
		$pod_nav_hover_bg_opacity = 1.0 - $pod_nav_hover_bg_alpha;
		
		
		$css = '<style>';

		if( $pod_head_transparent_active == true ) {
			/* Transparent Navigation
			 * Check if transparent menu is active, if yes, then load the following CSS */
			
				$css .='.above.nav-transparent.has-featured-image.nav-not-sticky, .above.nav-transparent.has-featured-image.large_nav {
					background: ' . $pod_head_transparent_bg_rgba . ';
				}';
			}

			$css .='#nav .thst-menu li:hover {
					background: ' . $pod_nav_hover_bg_rgba . ';
				}';
		
		$css .= '</style>';


		$css = str_replace(PHP_EOL, '', $css);
		$css = trim(preg_replace('!\s+!', ' ', $css));
		echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_themeoption_transparent_headers_css", 1000, 0);


if( ! function_exists( 'pod_themeoption_custom_typography_css' ) ) {
	function pod_themeoption_custom_typography_css() {

		$pod_typography = pod_theme_option('pod-typography', 'sans-serif');
		$pod_custom_css = pod_theme_option('pod-typekit-css-code', '');
		
		$css = '<style>';
			if( $pod_custom_css != '' && $pod_typography == 'custom-typekit' ) {
				$css .= $pod_custom_css;
			}
		$css .= '</style>';


		$css = str_replace(PHP_EOL, '', $css);
		$css = trim(preg_replace('!\s+!', ' ', $css));
		echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_themeoption_typography_css", 1000, 0);


if( ! function_exists( 'pod_themeoption_fp_grid_css' ) ) {
	function pod_themeoption_fp_grid_css() {

		//Front page grid
		$screen_resolution = 1920;
		$pod_fp_cols = pod_theme_option('pod-front-style-cols', 'front-page-cols-3');
		$pod_fp_cols_gutter = pod_theme_option('pod-front-cols-gutter', 32);
		$pod_fp_cols_gutter_vw = pod_calc_responsive_padding_size( $pod_fp_cols_gutter, 24, $screen_resolution );

		$css = '<style>';
			$css .= ' .front-page-grid.front-page-fit-grid .list-of-episodes .row.masonry-container, .front-page-grid.front-page-fit-grid.front-page-indigo .list-of-episodes .row.masonry-container {
					column-gap: ' . $pod_fp_cols_gutter_vw . ';
					grid-column-gap: ' . $pod_fp_cols_gutter_vw . ';
					row-gap: ' . $pod_fp_cols_gutter_vw . ';
					grid-row-gap: ' . $pod_fp_cols_gutter_vw . ';
			}';

			if( $pod_fp_cols == "front-page-cols-3" ) {
				$css .= '.front-page-grid .list-of-episodes .row.masonry-container .gutter-sizer {
					width: ' . $pod_fp_cols_gutter_vw. ';
				}
				.front-page-grid .list-of-episodes .row.masonry-container .grid-sizer {
				  width: calc( calc(100% / 3) - calc( (' . $pod_fp_cols_gutter_vw . ' * 2) / 3) );
				}
				.front-page-grid .list-of-episodes .masonry-container article {
				  width: calc( calc(100% / 3) - calc( (' . $pod_fp_cols_gutter_vw . ' * 2) / 3) );
				  margin-top: ' . $pod_fp_cols_gutter_vw . ';
				}				
				.front-page-grid .list-of-episodes .masonry-container article:nth-child(-n + 5) {
				  margin-top: 0;
				}
				@media screen and (max-width: 768px) {
					.front-page-grid.front-page-cols-3 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: calc( calc(100% / 2) - calc( (' . $pod_fp_cols_gutter_vw . ' * 1) / 2) );
					}
					.front-page-grid.front-page-cols-3 .list-of-episodes .row.masonry-container .gutter-sizer {
					  width: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-3 .list-of-episodes .masonry-container article {
					  width: calc( calc(100% / 2) - calc( (' . $pod_fp_cols_gutter_vw . ' * 1) / 2) );
					}
					.front-page-grid.front-page-cols-3 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-3 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: 0;
					}

					/* Grid, not masonry */
					.front-page-grid.front-page-fit-grid.front-page-cols-3 .list-of-episodes .masonry-container, 
					.front-page-grid.front-page-fit-grid.front-page-cols-3.front-page-indigo .list-of-episodes .row.masonry-container {
						grid-template-columns: 1fr 1fr;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-3 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-3 .list-of-episodes .masonry-container article {
						width: 100%;
						margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-3 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-3 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: 0;
					}
				}
				@media screen and (max-width: 480px) {
					.front-page-grid.front-page-cols-3 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: 100%;
					}
					.front-page-grid.front-page-cols-3 .list-of-episodes .row.masonry-container .gutter-sizer {
					  width: 0;
					}
					.front-page-grid.front-page-cols-3 .list-of-episodes .masonry-container article {
					  width: 100%;
					}
					.front-page-grid.front-page-cols-3 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-3 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: : ' . $pod_fp_cols_gutter_vw . ';
					}


					/* Grid, not masonry */
					.front-page-grid.front-page-fit-grid.front-page-cols-3 .list-of-episodes .masonry-container, 
					.front-page-grid.front-page-fit-grid.front-page-cols-3.front-page-indigo .list-of-episodes .row.masonry-container {
						grid-template-columns: 1fr;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-3 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-3 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-3 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: 0;
					}		
				}';
			}

			if( $pod_fp_cols == "front-page-cols-2" ) {
				$css .= '
				.front-page-grid.front-page-cols-2 .list-of-episodes .row.masonry-container .grid-sizer {
				  width: calc( calc(100% / 2) - calc( (' . $pod_fp_cols_gutter_vw . ' * 1) / 2) );
				}
				.front-page-grid.front-page-cols-2 .list-of-episodes .row.masonry-container .gutter-sizer {
				  width: ' . $pod_fp_cols_gutter_vw . ';
				}
				.front-page-grid.front-page-cols-2 .list-of-episodes .masonry-container article {
				  width: calc( calc(100% / 2) - calc( (' . $pod_fp_cols_gutter_vw . ' * 1) / 2) );
				  margin-top: ' . $pod_fp_cols_gutter_vw . ';
				}
				.front-page-grid.front-page-cols-2 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
				  margin-top: ' . $pod_fp_cols_gutter_vw . ';
				}
				.front-page-grid.front-page-cols-2 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
				  margin-top: 0;
				}	


				/* Grid, not masonry */
				.front-page-grid.front-page-fit-grid.front-page-cols-2 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
				  margin-top: 0;
				}

				@media screen and (max-width: 480px) {
					.front-page-grid.front-page-cols-2 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: 100%;
					}
					.front-page-grid.front-page-cols-2 .list-of-episodes .row.masonry-container .gutter-sizer {
					  width: 0;
					}
					.front-page-grid.front-page-cols-2 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-2 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: : ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-2 .list-of-episodes .masonry-container article {
					  width: 100%;
					}

					/* Grid, not masonry */
					.front-page-grid.front-page-fit-grid.front-page-cols-2 .list-of-episodes .masonry-container, 
					.front-page-grid.front-page-fit-grid.front-page-cols-2.front-page-indigo .list-of-episodes .row.masonry-container {
						grid-template-columns: 1fr;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-2 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-2 .list-of-episodes .masonry-container article {
						width: 100%;
						margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-2 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-2 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: 0;
					}
				}


				';
			}

			if( $pod_fp_cols == "front-page-cols-4" ) {
				$css .= '.front-page-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .grid-sizer {
				  width: calc( calc(100% / 4) - calc( (' . $pod_fp_cols_gutter_vw . ' * 3) / 4) );
				}
				.front-page-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .gutter-sizer {
				  width: ' . $pod_fp_cols_gutter_vw . ';
				}
				.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article {
				  width: calc( calc(100% / 4) - calc( (' . $pod_fp_cols_gutter_vw . ' * 3) / 4) );
				}
				.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
				  margin-top: ' . $pod_fp_cols_gutter_vw . ';
				}
				.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 6) {
				  margin-top: 0;
				}

				/* Grid, not masonry */
				.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
				  margin-top: 0;
				}
				@media screen and (max-width: 1024px) {
					.front-page-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .gutter-sizer {
						width: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: calc( calc(100% / 3) - calc( (' . $pod_fp_cols_gutter_vw . ' * 2) / 3) );
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article {
					  width: calc( calc(100% / 3) - calc( (' . $pod_fp_cols_gutter_vw . ' * 2) / 3) );
					  margin-top: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 6) {
						margin-top: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: 0;
					}


					/* Grid, not masonry */
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container, 
					.front-page-grid.front-page-fit-grid.front-page-cols-4.front-page-indigo .list-of-episodes .row.masonry-container {
						grid-template-columns: 1fr 1fr 1fr;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article {
						width: 100%;
						margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 6) {
					  margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: 0;
					}
				}
				@media screen and (max-width: 768px) {
					.front-page-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: calc( calc(100% / 2) - calc( (' . $pod_fp_cols_gutter_vw . ' * 1) / 2) );
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .gutter-sizer {
					  width: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article {
					  width: calc( calc(100% / 2) - calc( (' . $pod_fp_cols_gutter_vw . ' * 1) / 2) );
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: 0;
					}

					/* Grid, not masonry */
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container, 
					.front-page-grid.front-page-fit-grid.front-page-cols-4.front-page-indigo .list-of-episodes .row.masonry-container {
						grid-template-columns: 1fr 1fr;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article {
						width: 100%;
						margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: 0;
					}
				}
				@media screen and (max-width: 480px) {
					.front-page-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: 100%;
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .gutter-sizer {
					  width: 0;
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article {
					  width: 100%;
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: ' . $pod_fp_cols_gutter_vw . ';
					}
					.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: : ' . $pod_fp_cols_gutter_vw . ';
					}

					/* Grid, not masonry */
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container, 
					.front-page-grid.front-page-fit-grid.front-page-cols-4.front-page-indigo .list-of-episodes .row.masonry-container {
						grid-template-columns: 1fr;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .row.masonry-container .grid-sizer {
					  width: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article {
						width: 100%;
						margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 5) {
					  margin-top: 0;
					}
					.front-page-grid.front-page-fit-grid.front-page-cols-4 .list-of-episodes .masonry-container article:nth-child(-n + 4) {
					  margin-top: 0;
					}
				}';
			}
		
		$css .= '</style>';


		$css = str_replace(PHP_EOL, '', $css);
		$css = trim(preg_replace('!\s+!', ' ', $css));
		echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_themeoption_fp_grid_css", 1000, 0);


if( ! function_exists( 'pod_themeoption_minmax_logo_css' ) ) {
	function pod_themeoption_minmax_logo_css() {

		/* Min-Max Logo */
		$pod_logo_max_height = pod_theme_option('pod-logo-max-height', 90);
		$pod_logo_max_width = pod_theme_option('pod-logo-max-width', 260);

		$pod_logo_sticky_max_height = pod_theme_option('pod-logo-sticky-max-height', 70);
		$pod_logo_sticky_max_width = pod_theme_option('pod-logo-sticky-max-width', 130);

		$pod_logo_responsive_max_height = pod_theme_option('pod-logo-responsive-max-height', 50);
		$pod_logo_responsive_max_width = pod_theme_option('pod-logo-responsive-max-width', 150);


		$css = '<style>';

			$css .= '.above .logo.with-img img {
				max-height:'. $pod_logo_max_height .'px;
				max-width:'. $pod_logo_max_width .'px;
			}
			.above.small_nav .logo.with-img img.sticky{
				max-height:'. $pod_logo_sticky_max_height .'px;
				max-width:'. $pod_logo_sticky_max_width .'px;
			}
			.above .logo.with-img img.retina {
				max-height:'. $pod_logo_responsive_max_height .'px;
				max-width:'. $pod_logo_responsive_max_width .'px;
			}';

		$css .= '</style>';


		$css = str_replace(PHP_EOL, '', $css);
		$css = trim(preg_replace('!\s+!', ' ', $css));
		echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_themeoption_minmax_logo_css", 1000, 0);


if( ! function_exists( 'pod_themeoption_fp_text_header_css' ) ) {
	function pod_themeoption_fp_text_header_css() {

		/* Header Text Padding */
		$header_text_padd = pod_theme_option('pod-fh-padding', array('padding-top' => '75px','padding-bottom' => '75px'));
		$header_text_padd_top = !empty( $header_text_padd['padding-top'] ) ? $header_text_padd['padding-top'] : '32';
		$header_text_padd_bottom = !empty( $header_text_padd['padding-bottom'] ) ? $header_text_padd['padding-bottom'] : '32';
		$header_text_padd_top =  (int) str_replace("px", "", $header_text_padd_top);
		$header_text_padd_bottom = (int) str_replace("px", "", $header_text_padd_bottom);
		$header_text_padd_top_has_img = 110 + $header_text_padd_top;
		$header_text_padd_bott_vid_bg = 110 + $header_text_padd_bottom;

		$css = '<style>';



			$css .= '
			@media screen and (min-width: 1025px) {
				.front-page-header.text .content-text, .front-page-header.text.nav-transparent .content-text {
					padding-top:' . $header_text_padd_top . 'px;
					padding-bottom:' . $header_text_padd_bottom . 'px;
				}
				.front-page-header.text_static .main-featured-container {
					margin-top:' . $header_text_padd_top . 'px;
					margin-bottom:' . $header_text_padd_bottom . 'px;
				}
				.has-featured-image  .front-page-header.text.nav-transparent .content-text {
					padding-top:' . $header_text_padd_top_has_img . 'px;
					padding-bottom:' . $header_text_padd_bottom . 'px;
				}
				.has-featured-image .front-page-header.text_static.nav-transparent .main-featured-container {
					margin-top:' . $header_text_padd_top_has_img . 'px;
					margin-bottom:' . $header_text_padd_bottom . 'px;
				}
				.front-page-header.front-page-header-video-background .content-text {
					padding-top:' . $header_text_padd_top . 'px;
					padding-bottom:' . $header_text_padd_bott_vid_bg . 'px;
				}
				.nav-transparent.has-featured-image .front-page-header.front-page-header-video-background .content-text {
					padding-top:' . $header_text_padd_top_has_img . 'px;
					padding-bottom:' . $header_text_padd_bott_vid_bg . 'px;
				}
			}
			
			@media screen and (max-width: 1024px) {
				.has-featured-image .front-page-header.text.nav-transparent .content-text {
					padding-top:' . $header_text_padd_top . 'px;
				}
				.has-featured-image .front-page-header.text_static.nav-transparent .main-featured-container {
					margin-top:' . $header_text_padd_top . 'px;
				}
				.nav-transparent.has-featured-image .front-page-header.front-page-header-video-background .content-text {
					padding-top:' . $header_text_padd_top . 'px;
				}

				.nav-transparent.has-featured-image .front-page-header.front-page-header-video-background .content-text {
					padding-bottom: calc(190px + ' . $header_text_padd_bottom . 'px );
				}
				.front-page-header.front-page-header-video-background .content-text {
					padding-bottom: calc(190px + ' . $header_text_padd_bottom . 'px );
				}
				
			}
			@media screen and (max-width: 768px) {
				.nav-transparent.has-featured-image .front-page-header.front-page-header-video-background .content-text {
					padding-bottom: calc(260px + ' . $header_text_padd_bottom . 'px );
				}
				.front-page-header.front-page-header-video-background .content-text {
					padding-bottom: calc(260px + ' . $header_text_padd_bottom . 'px );
				}

			}
			@media screen and (max-width: 375px) {
				.nav-transparent.has-featured-image .front-page-header.front-page-header-video-background .content-text {
					padding-bottom: calc(280px + ' . $header_text_padd_bottom . 'px );
				}
				.front-page-header.front-page-header-video-background .content-text {
					padding-bottom: calc(280px + ' . $header_text_padd_bottom . 'px );
				}
			}';
		
		$css .= '</style>';


		$css = str_replace(PHP_EOL, '', $css);
		$css = trim(preg_replace('!\s+!', ' ', $css));
		echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_themeoption_fp_text_header_css", 1000, 0);



if( ! function_exists( 'pod_themeoption_typography_css' ) ) {
	function pod_themeoption_typography_css() {

		
		$css = '<style>';
		
		$css .= '</style>';


		$css = str_replace(PHP_EOL, '', $css);
		$css = trim(preg_replace('!\s+!', ' ', $css));
		echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_themeoption_typography_css", 1000, 0);


/**
 * Custom colors for the responsive menu hamburger and search button and social media menu.
 *
 * @since 1.8.9
 * @return string $css - CSS code
 */
if( ! function_exists( 'pod_responsive_nav_css' ) ) {
	function pod_responsive_nav_css() {

			$customresponsiveCol = pod_theme_option('pod-nav-responsive-custom-color-settings', false);
			$hamburgersearchBg = pod_theme_option('pod-nav-responsive-hamburger-search-bg', '#0b0d0d');
			$hamburgersearchLin = pod_theme_option('pod-nav-responsive-hamburger-search', '#fafafa');
			$hamburgersearchHov = pod_theme_option('pod-nav-responsive-hamburger-search-hover', '#199fdd');

        	$socialmediaBg = pod_theme_option('pod-nav-responsive-social-media-bg', '#424545');
        	$socialmediaLin = pod_theme_option('pod-nav-responsive-social-media-links', '#ffffff');
        	$socialmediaHov = pod_theme_option('pod-nav-responsive-social-media-hover', '#199fdd');

			if( $customresponsiveCol == false ) {
				return;
			}

			$css = '<style>
				@media screen and (max-width: 1024px) {
					.header-inner.social_container, .above.small_nav .header-inner.social_container {
						background: ' . $socialmediaBg . ';
					}
					.open-menu:link, .open-menu:visited, .nav-search-form .open-search-bar .fa, .above.nav-transparent.has-featured-image.large_nav .nav-search-form .open-search-bar .fa {
						color: ' . $hamburgersearchLin . ';
					}
					.open-menu:hover, .nav-search-form .open-search-bar:hover .fa, .above.nav-transparent.has-featured-image.large_nav .nav-search-form .open-search-bar .fa:hover {
						color: ' . $hamburgersearchHov . ';
					}

					.open-menu, .nav-search-form {
						background: ' . $hamburgersearchBg . ';
					}
					.dark-icons .above .social_icon::before, 
					.light-icons .above .social_icon::before, 
					.dark-icons .above.nav-transparent.has-featured-image.nav-not-sticky .social_icon::before, 
					.dark-icons .above.nav-transparent.has-featured-image.large_nav .social_icon::before, 
					.light-icons .above.nav-transparent.has-featured-image.nav-not-sticky .social_icon::before, 
					.light-icons .above.nav-transparent.has-featured-image.large_nav .social_icon::before {
						color: ' . $socialmediaLin . ';
					}
					.dark-icons .above .svg_icon_cont svg,
					.light-icons .above .svg_icon_cont svg,
					.dark-icons .above.nav-transparent.has-featured-image.nav-not-sticky .svg_icon_cont svg,
					.dark-icons .above.nav-transparent.has-featured-image.large_nav .svg_icon_cont svg,
					.light-icons .above.nav-transparent.has-featured-image.nav-not-sticky .svg_icon_cont svg,
					.light-icons .above.nav-transparent.has-featured-image.large_nav .svg_icon_cont svg {
						fill: ' . $socialmediaLin . ';
					}
					.above .email.social_icon:hover::before, .above.nav-transparent.has-featured-image.large_nav .email.social_icon:hover::before {
						color: ' . $socialmediaHov . ';
					}
				}
			';
			$css .= '</style>';


			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));
			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_responsive_nav_css", 1001);


/**
 * Custom colors for the header.
 *
 * @since 1.9.8
 * @return string $css - CSS code
 */
if( ! function_exists( 'pod_front_header_css' ) ) {
	function pod_front_header_css() {

		$pod_color_scheduled_bg = pod_theme_option('pod-color-scheduled-bg', 'rgba(0,0,0,0.25)');
		$pod_color_scheduled_bg_rgba = !empty( $pod_color_scheduled_bg['rgba'] ) ? $pod_color_scheduled_bg['rgba'] : '';
		
		$css = '<style>
				.next-week {
					background: ' . $pod_color_scheduled_bg_rgba . ';
				}
		';
		$css .= '</style>';

		$css = str_replace(PHP_EOL, '', $css);
		$css = trim(preg_replace('!\s+!', ' ', $css));
		echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_front_header_css", 176);

/**
 * Custom gradient color
 *
 * @since 2.2
 * @return string $css - CSS code
 */
if( ! function_exists( 'pod_front_header_gradient_css' ) ) {
	function pod_front_header_gradient_css() {

			$pod_bg_mode = pod_theme_option('pod-fh-bg-mode', 'background-solid');
			if( $pod_bg_mode == "background-solid" ) {
				return;
			}

			$pod_bg_grad_mode = pod_theme_option('pod-fh-bg-grad-mode', 'background-grad-linear');
			$pod_bg_grad_angle = pod_theme_option('pod-fh-bg-grad-angle', 0);
			$pod_grad_1 = pod_theme_option('pod-fh-grad-color-1', '#24292c');
			$pod_grad_2 = pod_theme_option('pod-fh-grad-color-2', '#24292c');
			$pod_grad_3 = pod_theme_option('pod-fh-grad-color-3', '#24292c');

			$css = '<style>
					.latest-episode.front-header,
					.front-page-header.front-header,
					.front-page-header.front-page-header-video-background,
					.front-page-header.slideshow,
					.front-page-header.static,
					.front-page-header.text {';

					if( $pod_bg_grad_mode == "background-grad-linear" ) {

						$css .= 'background: ' . $pod_grad_1 . ';
						background: -moz-linear-gradient(' . $pod_bg_grad_angle . 'deg,' . $pod_grad_3  . ' 0%,' . $pod_grad_2 . ' 50%,' . $pod_grad_1 . ' 100%);
						background: -webkit-linear-gradient(' . $pod_bg_grad_angle . 'deg,' . $pod_grad_3  . ' 0%,' . $pod_grad_2 . ' 50%,' . $pod_grad_1 . ' 100%);
						background: linear-gradient(' . $pod_bg_grad_angle . 'deg,' . $pod_grad_3  . ' 0%,' . $pod_grad_2 . ' 50%,' . $pod_grad_1 . ' 100%);
						filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="' . $pod_grad_1 . '",endColorstr="' . $pod_grad_2 . '",GradientType=1);';
					
					} elseif( $pod_bg_grad_mode == "background-grad-radial" ) {

						$css .= ' background: ' . $pod_grad_1 . ';
						background: -moz-radial-gradient(circle, ' . $pod_grad_1  . ' 0%, ' . $pod_grad_2  . ' 50%, ' . $pod_grad_3  . ' 100%);
						background: -webkit-radial-gradient(circle, ' . $pod_grad_1  . ' 0%, ' . $pod_grad_2  . ' 50%, ' . $pod_grad_3  . ' 100%);
						background: radial-gradient(circle, ' . $pod_grad_1  . ' 0%, ' . $pod_grad_2  . ' 50%, ' . $pod_grad_3  . ' 100%);
						filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="' . $pod_grad_1  . '",endColorstr="' . $pod_grad_2  . '",GradientType=1);';
					
					}

					$css .= '}
					.front-page-header.slideshow .slides .slide {
						background: transparent !important;
					}
			';
			$css .= '</style>';

			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));
			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));

	}
}
add_action("wp_head", "pod_front_header_gradient_css", 176);

if( ! function_exists( 'pod_themeoption_padding_css' ) ) {
	function pod_themeoption_padding_css() {
		$screen_resolution = 1920;

		// Front Page Entries
		$pod_front_page_posts_padding = pod_theme_option('pod-front-page-entries-padding', array('padding-top'    => '42px', 'padding-right'  => '42px', 'padding-bottom' => '42px', 'padding-left'   => '42px'));
		$pod_front_page_posts_padding_top = isset( $pod_front_page_posts_padding['padding-top'] ) ? $pod_front_page_posts_padding['padding-top'] : '32';
		$pod_front_page_posts_padding_left = isset( $pod_front_page_posts_padding['padding-left'] ) ? $pod_front_page_posts_padding['padding-left'] : '32';
		$pod_front_page_posts_padding_right = isset( $pod_front_page_posts_padding['padding-right'] ) ? $pod_front_page_posts_padding['padding-right'] : '32';
		$pod_front_page_posts_padding_bottom = isset( $pod_front_page_posts_padding['padding-bottom'] ) ? $pod_front_page_posts_padding['padding-bottom'] : '32';
		$pod_front_page_posts_padding_top_vw = pod_calc_responsive_padding_size( $pod_front_page_posts_padding_top, 24, $screen_resolution );
		$pod_front_page_posts_padding_left_vw = pod_calc_responsive_padding_size( $pod_front_page_posts_padding_left, 24, $screen_resolution );
		$pod_front_page_posts_padding_right_vw = pod_calc_responsive_padding_size( $pod_front_page_posts_padding_right, 24, $screen_resolution );
		$pod_front_page_posts_padding_bottom_vw = pod_calc_responsive_padding_size( $pod_front_page_posts_padding_bottom, 24, $screen_resolution );


		// Hosts
		$pod_front_page_hosts_padding = pod_theme_option('pod-frontpage-hosts-padding', array('padding-top'    => '32px', 'padding-right'  => '32px', 'padding-bottom' => '32px','padding-left'   => '32px'
        ));
		$pod_front_page_hosts_padding_top = isset( $pod_front_page_hosts_padding['padding-top'] ) ? $pod_front_page_hosts_padding['padding-top'] : '32';
		$pod_front_page_hosts_padding_left = isset( $pod_front_page_hosts_padding['padding-left'] ) ? $pod_front_page_hosts_padding['padding-left'] : '32';
		$pod_front_page_hosts_padding_right = isset( $pod_front_page_hosts_padding['padding-right'] ) ? $pod_front_page_hosts_padding['padding-right'] : '32';
		$pod_front_page_hosts_padding_bottom = isset( $pod_front_page_hosts_padding['padding-bottom'] ) ? $pod_front_page_hosts_padding['padding-bottom'] : '32';
		$pod_front_page_hosts_padding_top_vw = pod_calc_responsive_padding_size( $pod_front_page_hosts_padding_top, 16, $screen_resolution );
		$pod_front_page_hosts_padding_left_vw = pod_calc_responsive_padding_size( $pod_front_page_hosts_padding_left, 16, $screen_resolution );
		$pod_front_page_hosts_padding_right_vw = pod_calc_responsive_padding_size( $pod_front_page_hosts_padding_right, 16, $screen_resolution );
		$pod_front_page_hosts_padding_bottom_vw = pod_calc_responsive_padding_size( $pod_front_page_hosts_padding_bottom, 16, $screen_resolution );



		// Donate Button
		$pod_front_page_donate_padding = pod_theme_option('pod-front-page-donate-padding', array('padding-top'    => '72px','padding-right'  => '42px','padding-bottom' => '72px','padding-left'   => '42px'));
		$pod_front_page_donate_padding_top = isset( $pod_front_page_donate_padding['padding-top'] ) ? $pod_front_page_donate_padding['padding-top'] : '72';
		$pod_front_page_donate_padding_left = isset( $pod_front_page_donate_padding['padding-left'] ) ? $pod_front_page_donate_padding['padding-left'] : '42';
		$pod_front_page_donate_padding_right = isset( $pod_front_page_donate_padding['padding-right'] ) ? $pod_front_page_donate_padding['padding-right'] : '42';
		$pod_front_page_donate_padding_bottom = isset( $pod_front_page_donate_padding['padding-bottom'] ) ? $pod_front_page_donate_padding['padding-bottom'] : '72';
		$pod_front_page_donate_padding_top_vw = pod_calc_responsive_padding_size( $pod_front_page_donate_padding_top, 24, $screen_resolution );
		$pod_front_page_donate_padding_left_vw = pod_calc_responsive_padding_size( $pod_front_page_donate_padding_left, 24, $screen_resolution );
		$pod_front_page_donate_padding_right_vw = pod_calc_responsive_padding_size( $pod_front_page_donate_padding_right, 24, $screen_resolution );
		$pod_front_page_donate_padding_bottom_vw = pod_calc_responsive_padding_size( $pod_front_page_donate_padding_bottom, 24, $screen_resolution );


		// Newsletter
		$pod_front_page_newsletter_padding = pod_theme_option('pod-frontpage-newsletter-padding', array('padding-top' => '72px', 'padding-right' => '42px', 'padding-bottom' => '72px', 'padding-left' => '42px'));
		$pod_front_page_newsletter_padding_top = isset( $pod_front_page_newsletter_padding['padding-top'] ) ? $pod_front_page_newsletter_padding['padding-top'] : '72';
		$pod_front_page_newsletter_padding_left = isset( $pod_front_page_newsletter_padding['padding-left'] ) ? $pod_front_page_newsletter_padding['padding-left'] : '42';
		$pod_front_page_newsletter_padding_right = isset( $pod_front_page_newsletter_padding['padding-right'] ) ? $pod_front_page_newsletter_padding['padding-right'] : '72';
		$pod_front_page_newsletter_padding_bottom = isset( $pod_front_page_newsletter_padding['padding-bottom'] ) ? $pod_front_page_newsletter_padding['padding-bottom'] : '42';
		$pod_front_page_newsletter_padding_top_vw = pod_calc_responsive_padding_size( $pod_front_page_newsletter_padding_top, 24, $screen_resolution );
		$pod_front_page_newsletter_padding_left_vw = pod_calc_responsive_padding_size( $pod_front_page_newsletter_padding_left, 24, $screen_resolution );
		$pod_front_page_newsletter_padding_right_vw = pod_calc_responsive_padding_size( $pod_front_page_newsletter_padding_right, 24, $screen_resolution );
		$pod_front_page_newsletter_padding_bottom_vw = pod_calc_responsive_padding_size( $pod_front_page_newsletter_padding_bottom, 24, $screen_resolution );

		// Blog
		$pod_blog_post_padding = pod_theme_option('pod-blog-posts-padding', array('padding-top' => '32px','padding-right' => '32px', 'padding-bottom' => '32px', 'padding-left' => '32px'));
		$pod_blog_post_padding_top = isset( $pod_blog_post_padding['padding-top'] ) ? $pod_blog_post_padding['padding-top'] : '32';
		$pod_blog_post_padding_left = isset( $pod_blog_post_padding['padding-left'] ) ? $pod_blog_post_padding['padding-left'] : '32';
		$pod_blog_post_padding_right = isset( $pod_blog_post_padding['padding-right'] ) ? $pod_blog_post_padding['padding-right'] : '32';
		$pod_blog_post_padding_bottom = isset( $pod_blog_post_padding['padding-bottom'] ) ? $pod_blog_post_padding['padding-bottom'] : '32';
		$pod_blog_post_padding_top_vw = pod_calc_responsive_padding_size( $pod_blog_post_padding_top, 24, $screen_resolution );
		$pod_blog_post_padding_left_vw = pod_calc_responsive_padding_size( $pod_blog_post_padding_left, 24, $screen_resolution );
		$pod_blog_post_padding_right_vw = pod_calc_responsive_padding_size( $pod_blog_post_padding_right, 24, $screen_resolution );
		$pod_blog_post_padding_bottom_vw = pod_calc_responsive_padding_size( $pod_blog_post_padding_bottom, 24, $screen_resolution );

		// Blog Sidebar widgets
		$pod_blog_widgets_padding = pod_theme_option('pod-blog-widgets-padding', array( 'padding-top' => '24px', 'padding-right' => '24px', 'padding-bottom' => '24px', 'padding-left' => '24px' ));
		$pod_blog_widgets_padding_top = isset( $pod_blog_widgets_padding['padding-top'] ) ? $pod_blog_widgets_padding['padding-top'] : '24';
		$pod_blog_widgets_padding_left = isset( $pod_blog_widgets_padding['padding-left'] ) ? $pod_blog_widgets_padding['padding-left'] : '24';
		$pod_blog_widgets_padding_right = isset( $pod_blog_widgets_padding['padding-right'] ) ? $pod_blog_widgets_padding['padding-right'] : '24';
		$pod_blog_widgets_padding_bottom = isset( $pod_blog_widgets_padding['padding-bottom'] ) ? $pod_blog_widgets_padding['padding-bottom'] : '24';
		$pod_blog_widgets_padding_top_vw = pod_calc_responsive_padding_size( $pod_blog_widgets_padding_top, 16, $screen_resolution );
		$pod_blog_widgets_padding_left_vw = pod_calc_responsive_padding_size( $pod_blog_widgets_padding_left, 16, $screen_resolution );
		$pod_blog_widgets_padding_right_vw = pod_calc_responsive_padding_size( $pod_blog_widgets_padding_right, 16, $screen_resolution );
		$pod_blog_widgets_padding_bottom_vw = pod_calc_responsive_padding_size( $pod_blog_widgets_padding_bottom, 16, $screen_resolution );

			$css = '<style>
				.front-page-indigo .list-of-episodes article .inside,
				.front-page-indigo .list-of-episodes article .post-content .inside,
				.front-page-indigo .list-of-episodes article.has-post-thumbnail .inside,
				.list-of-episodes article .post-content .inside,
				.front-page-grid .list-of-episodes .masonry-container article .inside,
				.front-page-grid .list-of-episodes .masonry-container article .post-content .inside,
				.front-page-grid .list-of-episodes .masonry-container article.has-post-thumbnail .inside,
				.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article .inside,
				.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article .post-content .inside,
				.front-page-grid.front-page-cols-4 .list-of-episodes .masonry-container article.has-post-thumbnail .inside {
					padding-top: ' . $pod_front_page_posts_padding_top . ' ;
					padding-top: ' . $pod_front_page_posts_padding_top_vw . ' ;
					padding-left: ' . $pod_front_page_posts_padding_left . ' ;
					padding-left: ' . $pod_front_page_posts_padding_left_vw . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right_vw . ' ;
					padding-bottom: ' . $pod_front_page_posts_padding_bottom . ' ;
					padding-bottom: ' . $pod_front_page_posts_padding_bottom_vw . ' ;
				}
				.blog-front-page .post .entry-header .title-container {
					padding-top: ' . $pod_front_page_posts_padding_top . ' ;
					padding-top: ' . $pod_front_page_posts_padding_top_vw . ' ;
					padding-left: ' . $pod_front_page_posts_padding_left . ' ;
					padding-left: ' . $pod_front_page_posts_padding_left_vw . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right_vw . ' ;
				}
				.blog-front-page .post.format-audio .featured-media .audio-caption,
				.blog-front-page .post.format-video .video-caption,
				.blog-front-page .post.format-image .entry-featured .image-caption,
				.blog-front-page .post.format-gallery .featured-gallery .gallery-caption {
					padding-left: ' . $pod_front_page_posts_padding_left . ' ;
					padding-left: ' . $pod_front_page_posts_padding_left_vw . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right_vw . ' ;
				}
				.page.page-template .main-content.blog-front-page .post .entry-content,
				.blog-front-page .post .pagination {
					padding-left: ' . $pod_front_page_posts_padding_left . ' ;
					padding-left: ' . $pod_front_page_posts_padding_left_vw . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right_vw . ' ;
				}
				.blog-front-page .post.format-link .entry-content p {
					margin-left: ' . $pod_front_page_posts_padding_left . ' ;
					margin-left: ' . $pod_front_page_posts_padding_left_vw . ' ;
					margin-right: ' . $pod_front_page_posts_padding_right . ' ;
					margin-right: ' . $pod_front_page_posts_padding_right_vw . ' ;
				}
				.blog-front-page .post .entry-meta {
					padding-left: ' . $pod_front_page_posts_padding_left . ' ;
					padding-left: ' . $pod_front_page_posts_padding_left_vw . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right . ' ;
					padding-right: ' . $pod_front_page_posts_padding_right_vw . ' ;
					padding-bottom: ' . $pod_front_page_posts_padding_bottom . ' ;
					padding-bottom: ' . $pod_front_page_posts_padding_bottom_vw . ' ;
				}

				@media screen and (max-width: 1280px) {
					.front-page-list.front-page-indigo .list-of-episodes.fp-resp-grid article .inside,
					.front-page-list.front-page-indigo .list-of-episodes.fp-resp-grid article .post-content .inside,
					.front-page-list.front-page-indigo .list-of-episodes.fp-resp-grid article.has-post-thumbnail .inside,
					.front-page-list .list-of-episodes.fp-resp-grid article .post-content .inside {
						padding-right: ' . $pod_front_page_posts_padding_top . ' ;
						padding-right: ' . $pod_front_page_posts_padding_top_vw . ' ;
						padding-top: ' . $pod_front_page_posts_padding_left . ' ;
						padding-top: ' . $pod_front_page_posts_padding_left_vw . ' ;
						padding-bottom: ' . $pod_front_page_posts_padding_right . ' ;
						padding-bottom: ' . $pod_front_page_posts_padding_right_vw . ' ;
						padding-left: ' . $pod_front_page_posts_padding_bottom . ' ;
						padding-left: ' . $pod_front_page_posts_padding_bottom_vw . ' ;
					}

				}
				@media screen and (max-width: 768px) {
					.front-page-list.front-page-indigo .list-of-episodes.fp-resp-list article .inside,
					.front-page-list.front-page-indigo .list-of-episodes.fp-resp-list article .post-content .inside,
					.front-page-list.front-page-indigo .list-of-episodes.fp-resp-list article.has-post-thumbnail .inside,
					.front-page-list .list-of-episodes.fp-resp-list article .post-content .inside {
						padding-right: ' . $pod_front_page_posts_padding_top . ' ;
						padding-right: ' . $pod_front_page_posts_padding_top_vw . ' ;
						padding-top: ' . $pod_front_page_posts_padding_left . ' ;
						padding-top: ' . $pod_front_page_posts_padding_left_vw . ' ;
						padding-bottom: ' . $pod_front_page_posts_padding_right . ' ;
						padding-bottom: ' . $pod_front_page_posts_padding_right_vw . ' ;
						padding-left: ' . $pod_front_page_posts_padding_bottom . ' ;
						padding-left: ' . $pod_front_page_posts_padding_bottom_vw . ' ;
					}
				}

				.hosts-container .hosts-content .host .host-inner {
					padding-top: ' . $pod_front_page_hosts_padding_top . ' ;
					padding-top: ' . $pod_front_page_hosts_padding_top_vw . ';
					padding-left: ' . $pod_front_page_hosts_padding_left . ' ;
					padding-left: ' . $pod_front_page_hosts_padding_left_vw . ';
					padding-right: ' . $pod_front_page_hosts_padding_right . ' ;
					padding-right: ' . $pod_front_page_hosts_padding_right_vw . ';
					padding-bottom: ' . $pod_front_page_hosts_padding_bottom . ' ;
					padding-bottom: ' . $pod_front_page_hosts_padding_bottom_vw . ';
				}


				.call-to-action-container .call-to-action-content {
					padding-top: ' . $pod_front_page_donate_padding_top . ' ;
					padding-top: ' . $pod_front_page_donate_padding_top_vw . ';
					padding-left: ' . $pod_front_page_donate_padding_left . ' ;
					padding-left: ' . $pod_front_page_donate_padding_left_vw . ';
					padding-right: ' . $pod_front_page_donate_padding_right . ' ;
					padding-right: ' . $pod_front_page_donate_padding_right_vw . ';
					padding-bottom: ' . $pod_front_page_donate_padding_bottom . ' ;
					padding-bottom: ' . $pod_front_page_donate_padding_bottom_vw . ';
				}


				.newsletter-container .newsletter-content {
					padding-top: ' . $pod_front_page_newsletter_padding_top . ' ;
					padding-top: ' . $pod_front_page_newsletter_padding_top_vw . ';
					padding-left: ' . $pod_front_page_newsletter_padding_left . ' ;
					padding-left: ' . $pod_front_page_newsletter_padding_left_vw . ';
					padding-right: ' . $pod_front_page_newsletter_padding_right . ' ;
					padding-right: ' . $pod_front_page_newsletter_padding_right_vw . ';
					padding-bottom: ' . $pod_front_page_newsletter_padding_bottom . ' ;
					padding-bottom: ' . $pod_front_page_newsletter_padding_bottom_vw . ';
				}


				.blog .post .entry-header .title-container,
				.archive .post .entry-header .title-container,
				.search .post .entry-header .title-container {
					padding-top: ' . $pod_blog_post_padding_top . ' ;
					padding-top: ' . $pod_blog_post_padding_top_vw . ';
					padding-left: ' . $pod_blog_post_padding_left . ' ;
					padding-left: ' . $pod_blog_post_padding_left_vw . ';
					padding-right: ' . $pod_blog_post_padding_right . ' ;
					padding-right: ' . $pod_blog_post_padding_right_vw . ';
				}
				.blog .post.format-audio .featured-media .audio-caption,
				.blog .post.format-video .video-caption,
				.blog .post.format-image .entry-featured .image-caption,
				.blog .post.format-gallery .featured-gallery .gallery-caption,
				.archive .post.format-audio .featured-media .audio-caption,
				.archive .post.format-video .video-caption,
				.archive .post.format-image .entry-featured .image-caption,
				.archive .post.format-gallery .featured-gallery .gallery-caption,
				.search .post.format-audio .featured-media .audio-caption,
				.search .post.format-video .video-caption,
				.search .post.format-image .entry-featured .image-caption,
				.search .post.format-gallery .featured-gallery .gallery-caption {
					padding-left: ' . $pod_blog_post_padding_left . ' ;
					padding-left: ' . $pod_blog_post_padding_left_vw . ';
					padding-right: ' . $pod_blog_post_padding_right . ' ;
					padding-right: ' . $pod_blog_post_padding_right_vw . ';
				}
				.blog .post .entry-content,
				.archive .post .entry-content,
				.blog .post .entry-summary,
				.archive .post .entry-summary,
				.search .post .entry-summary,
				.blog .post .pagination,
				.archive .post .pagination,
				.search .post .pagination {
					padding-left: ' . $pod_blog_post_padding_left . ' ;
					padding-left: ' . $pod_blog_post_padding_left_vw . ';
					padding-right: ' . $pod_blog_post_padding_right . ' ;
					padding-right: ' . $pod_blog_post_padding_right_vw . ';
				}
				.post.format-link .entry-content p {
					margin-left: ' . $pod_blog_post_padding_left . ' ;
					margin-left: ' . $pod_blog_post_padding_left_vw . ';
					margin-right: ' . $pod_blog_post_padding_right . ' ;
					margin-right: ' . $pod_blog_post_padding_right_vw . ';
				}
				.blog .post .entry-meta,
				.archive .post .entry-meta,
				.search .post .entry-meta {
					padding-left: ' . $pod_blog_post_padding_left . ' ;
					padding-left: ' . $pod_blog_post_padding_left_vw . ';
					padding-right: ' . $pod_blog_post_padding_right . ' ;
					padding-right: ' . $pod_blog_post_padding_right_vw . ';
					padding-bottom: ' . $pod_blog_post_padding_bottom . ' ;
					padding-bottom: ' . $pod_blog_post_padding_bottom_vw . ';
				}
				.sidebar .widget:not(.widget_search):not(.thst_highlight_category_widget):not(.thst_recent_blog_widget):not(.thst_recent_comments_widget):not(.widget_product_search) {
					padding-top: ' . $pod_blog_widgets_padding_top . ' ;
					padding-top: ' . $pod_blog_widgets_padding_top_vw . ';
					padding-left: ' . $pod_blog_widgets_padding_left . ' ;
					padding-left: ' . $pod_blog_widgets_padding_left_vw . ';
					padding-right: ' . $pod_blog_widgets_padding_right . ' ;
					padding-right: ' . $pod_blog_widgets_padding_right_vw . ';
					padding-bottom: ' . $pod_blog_widgets_padding_bottom . ' ;
					padding-bottom: ' . $pod_blog_widgets_padding_bottom_vw . ';
				}
				.sidebar .widget.thst_recent_comments_widget {
					padding-top: ' . $pod_blog_widgets_padding_top . ' ;
					padding-top: ' . $pod_blog_widgets_padding_top_vw . ';
					padding-bottom: ' . $pod_blog_widgets_padding_bottom . ' ;
					padding-bottom: ' . $pod_blog_widgets_padding_bottom_vw . ';
				}
				.sidebar .widget.thst_recent_comments_widget h3:not(.widget thst_recent_comments_widget) {
					padding-left: ' . $pod_blog_widgets_padding_left . ' ;
					padding-left: ' . $pod_blog_widgets_padding_left_vw . ';
					padding-right: ' . $pod_blog_widgets_padding_right . ' ;
					padding-right: ' . $pod_blog_widgets_padding_right_vw . ';
				}
				.sidebar .widget.thst_recent_comments_widget ul li.recentcomments {
					padding-left: ' . $pod_blog_widgets_padding_left . ' ;
					padding-left: ' . $pod_blog_widgets_padding_left_vw . ';
					padding-right: ' . $pod_blog_widgets_padding_right . ' ;
					padding-right: ' . $pod_blog_widgets_padding_right_vw . ';
				}
				';


			$css .= '</style>';


			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));
			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));
	}
}
add_action("wp_head", "pod_themeoption_padding_css", 175, 0);

add_action('wp_enqueue_scripts', 'pod_googlefonts_css');
if( ! function_exists('pod_googlefonts_css') ) {
	function pod_googlefonts_css() {

		//Google Custom CSS
   		$pod_typography = pod_theme_option('pod-typography', 'sans-serif');

   		// Google | Headings
		$pod_google_general_headings = pod_theme_option('pod-typo-headings', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '33px',
			'font-weight'	 => '600']);
		$pod_google_general_text = pod_theme_option('pod-typo-text', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '400']);

		// Google | Logo
		$pod_google_logo_heading = pod_theme_option('pod-typo-main-heading', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-weight'	 => '400']);
		$pod_google_logo_menu_link = pod_theme_option('pod-typo-menu-links', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-weight'	 => '600']);

		// Google | Featured Heading
		$pod_google_feat_heading = pod_theme_option('pod-typo-featured-heading', [
			'font-family'    => 'Playfair Display',
			'variant'        => 'regular',
			'font-size'      => '42px',
			'font-weight'	 => '600',
			'line-height'    => '50px']);
		$pod_google_feat_text = pod_theme_option('pod-typo-featured-text', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '16px',
			'font-weight'	 => '400']);
		$pod_google_feat_mini_title = pod_theme_option('pod-typo-featured-mini-title', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '14px',
			'font-weight'	 => '700',
			'line-height'    => '24px']);
		$pod_google_feat_sched_mini_title = pod_theme_option('pod-typo-featured-scheduled-mini-title',[
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '12px',
			'font-weight'	 => '600',
			'line-height'    => '24px',
			'letter-spacing' => '2px',
			'text-transform' => 'uppercase']);
		$pod_google_feat_sched_heading = pod_theme_option('pod-typo-featured-scheduled-heading', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '600',
			'line-height'    => '32px',
			'letter-spacing' => '2px',
			'text-transform' => 'uppercase']);


		// Google | Front Page Posts
		$pod_google_front_posts_heading = pod_theme_option('pod-typo-frontpage-heading', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '32px',
			'font-weight'	 => '700',
			'line-height'    => '40px']);
		$pod_google_front_posts_text = pod_theme_option('pod-typo-frontpage-text', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '400',
			'line-height'    => '32px']);
		$pod_google_front_posts_cats = pod_theme_option('pod-typo-frontpage-cats', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '13px',
			'font-weight'	 => '700',
			'line-height'    => '24px',
			'text-transform' => 'uppercase']);
		$pod_google_front_posts_read_more = pod_theme_option('pod-typo-frontpage-read-more', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '700',
			'line-height'    => '32px']);

		// Google | Single
		$pod_google_single_heading = pod_theme_option('pod-typo-single-heading', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '42px',
			'font-weight'	 => '600',
			'line-height'    => '46px']);
		$pod_google_single_text = pod_theme_option('pod-typo-single-text',[
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '400',
			'line-height'    => '32px']);

		// Google | Page
		$pod_google_page_heading = pod_theme_option('pod-typo-page-heading', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '42px',
			'font-weight'	 => '600',
			'line-height'    => '46px']);
		$pod_google_page_text = pod_theme_option('pod-typo-page-text', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '400',
			'line-height'    => '32px']);

		// Google | Blog Heading
		$pod_google_blog_heading = pod_theme_option('pod-typo-blog-heading', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '42px',
			'font-weight'	 => '600',
			'line-height'    => '54px']);
		$pod_google_blog_text = pod_theme_option('pod-typo-blog-text', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '400',
			'line-height'    => '32px']);



		$pod_gg_head_ff = pod_get_googlefont_property($pod_google_general_headings, 'font-family');
		$pod_gg_head_al = pod_get_googlefont_property($pod_google_general_headings, 'text-align', "left");
		$pod_gg_head_fw = pod_get_googlefont_property($pod_google_general_headings, 'font-weight');
		$pod_gg_head_fs = pod_get_googlefont_property($pod_google_general_headings, 'font-style', "normal");
		$pod_gg_head_fsi = pod_get_googlefont_property($pod_google_general_headings, 'font-size');
		$pod_gg_head_vw = pod_calc_responsive_font_size($pod_gg_head_fsi, 34, 20);

		$pod_gg_txt_ff = pod_get_googlefont_property($pod_google_general_text, "font-family");
		$pod_gg_txt_fw = pod_get_googlefont_property($pod_google_general_text, "font-weight");
		$pod_gg_txt_al = pod_get_googlefont_property($pod_google_general_text, "text-align", "left");
		$pod_gg_txt_fs = pod_get_googlefont_property($pod_google_general_text, "font-style", "normal");
		$pod_gg_txt_fsi = pod_get_googlefont_property($pod_google_general_text, "font-size");
		$pod_gg_txt_vw = pod_calc_responsive_font_size($pod_gg_txt_fsi, 18, 14);


		/* Logo */
		$pod_gg_logo_h_ff = pod_get_googlefont_property( $pod_google_logo_heading, "font-family" );
		$pod_gg_logo_h_fw = pod_get_googlefont_property( $pod_google_logo_heading, "font-weight" );
		$pod_gg_logo_h_fs = pod_get_googlefont_property( $pod_google_logo_heading, "font-style", "normal" );
		$pod_gg_logo_h_fsi = pod_get_googlefont_property( $pod_google_logo_heading, "font-size" );
		$pod_gg_logo_h_vw = pod_calc_responsive_font_size($pod_gg_logo_h_fsi, 24, 16);

		$pod_gg_logo_l_ff = pod_get_googlefont_property( $pod_google_logo_menu_link, "font-family" );
		$pod_gg_logo_l_fw = pod_get_googlefont_property( $pod_google_logo_menu_link, "font-weight" );
		$pod_gg_logo_l_fs = pod_get_googlefont_property( $pod_google_logo_menu_link, "font-style", "normal" );


		/* Front Page Header */
		$pod_gg_feat_h_ff = pod_get_googlefont_property( $pod_google_feat_heading, "font-family" );
		$pod_gg_feat_h_tt = pod_get_googlefont_property( $pod_google_feat_heading, "text-transform", "none" );
		$pod_gg_feat_h_fw = pod_get_googlefont_property( $pod_google_feat_heading, "font-weight" );
		$pod_gg_feat_h_lh = pod_get_googlefont_property( $pod_google_feat_heading, "line-height" );
		$pod_gg_feat_h_lh_vw = pod_calc_responsive_font_size($pod_gg_feat_h_lh, 48, 36);
		$pod_gg_feat_h_fs = pod_get_googlefont_property( $pod_google_feat_heading, "font-style", "normal" );
		$pod_gg_feat_h_fsi = pod_get_googlefont_property( $pod_google_feat_heading, "font-size" );
		$pod_gg_feat_h_vw = pod_calc_responsive_font_size($pod_gg_feat_h_fsi, 54, 32);

		$pod_gg_feat_t_ff = pod_get_googlefont_property( $pod_google_feat_text, "font-family" );
		$pod_gg_feat_t_fw = pod_get_googlefont_property( $pod_google_feat_text, "font-weight" );
		$pod_gg_feat_t_fs = pod_get_googlefont_property( $pod_google_feat_text, "font-style", "normal" );
		$pod_gg_feat_t_fsi = pod_get_googlefont_property( $pod_google_feat_text, "font-size" );
		$pod_gg_feat_t_vw = pod_calc_responsive_font_size($pod_gg_feat_t_fsi, 18, 16);

		$pod_gg_feat_mt_ff = pod_get_googlefont_property( $pod_google_feat_mini_title, "font-family" );
		$pod_gg_feat_mt_fw = pod_get_googlefont_property( $pod_google_feat_mini_title, "font-weight" );
		$pod_gg_feat_mt_fs = pod_get_googlefont_property( $pod_google_feat_mini_title, "font-style", "normal" );
		$pod_gg_feat_mt_fsi = pod_get_googlefont_property( $pod_google_feat_mini_title, "font-size" );
		$pod_gg_feat_mt_tt = pod_get_googlefont_property( $pod_google_feat_mini_title, "text-transform" );
		$pod_gg_feat_mt_vw = pod_calc_responsive_font_size($pod_gg_feat_mt_fsi, 14, 12);
		$pod_gg_feat_mt_lh = pod_get_googlefont_property( $pod_google_feat_mini_title, "line-height" );
		$pod_gg_feat_mt_lh_vw = pod_calc_responsive_font_size($pod_gg_feat_mt_lh, 24, 16);

		$pod_gg_feat_smt_ff = pod_get_googlefont_property( $pod_google_feat_sched_mini_title, "font-family" );
		$pod_gg_feat_smt_fw = pod_get_googlefont_property( $pod_google_feat_sched_mini_title, "font-weight" );
		$pod_gg_feat_smt_fs = pod_get_googlefont_property( $pod_google_feat_sched_mini_title, "font-style", "normal" );
		$pod_gg_feat_smt_tt = pod_get_googlefont_property( $pod_google_feat_sched_mini_title, "text-transform" );
		$pod_gg_feat_smt_ls = pod_get_googlefont_property( $pod_google_feat_sched_mini_title, "letter-spacing" );
		$pod_gg_feat_smt_fsi = pod_get_googlefont_property( $pod_google_feat_sched_mini_title, "font-size" );
		$pod_gg_feat_smt_vw = pod_calc_responsive_font_size($pod_gg_feat_smt_fsi, 12, 11);
		$pod_gg_feat_smt_lh = pod_get_googlefont_property( $pod_google_feat_sched_mini_title, "line-height" );
		$pod_gg_feat_smt_lh_vw = pod_calc_responsive_font_size($pod_gg_feat_smt_lh, 20, 15);

		$pod_gg_feat_sh_ff = pod_get_googlefont_property( $pod_google_feat_sched_heading, "font-family" );
		$pod_gg_feat_sh_fw = pod_get_googlefont_property( $pod_google_feat_sched_heading, "font-weight" );
		$pod_gg_feat_sh_fs = pod_get_googlefont_property( $pod_google_feat_sched_heading, "font-style", "normal" );
		$pod_gg_feat_sh_fsi = pod_get_googlefont_property( $pod_google_feat_sched_heading, "font-size" );
		$pod_gg_feat_sh_vw = pod_calc_responsive_font_size($pod_gg_feat_sh_fsi, 18, 14);
		$pod_gg_feat_sh_lh = pod_get_googlefont_property( $pod_google_feat_sched_heading, "line-height" );
		$pod_gg_feat_sh_lh_vw = pod_calc_responsive_font_size($pod_gg_feat_sh_lh, 32, 24);
		


		/* Front Page Posts */
		$pod_gg_frp_h_ff = pod_get_googlefont_property( $pod_google_front_posts_heading, "font-family" );
		$pod_gg_frp_h_fw = pod_get_googlefont_property( $pod_google_front_posts_heading, "font-weight" );
		$pod_gg_frp_h_lh = pod_get_googlefont_property( $pod_google_front_posts_heading, "line-height" );
		$pod_gg_frp_h_lh_vw = pod_calc_responsive_font_size($pod_gg_frp_h_lh, 36, 32);
		$pod_gg_frp_h_al = pod_get_googlefont_property( $pod_google_front_posts_heading, "text-align", "left" );
		$pod_gg_frp_h_fs = pod_get_googlefont_property( $pod_google_front_posts_heading, "font-style", "normal" );
		$pod_gg_frp_h_fsi = pod_get_googlefont_property( $pod_google_front_posts_heading, "font-size" );
		$pod_gg_frp_h_vw = pod_calc_responsive_font_size($pod_gg_frp_h_fsi, 32, 24);

		$pod_gg_frp_t_ff = pod_get_googlefont_property( $pod_google_front_posts_text, "font-family" );
		$pod_gg_frp_t_fw = pod_get_googlefont_property( $pod_google_front_posts_text, "font-weight" );
		$pod_gg_frp_t_lh = pod_get_googlefont_property( $pod_google_front_posts_text, "line-height" );
		$pod_gg_frp_t_lh_vw = pod_calc_responsive_font_size($pod_gg_frp_t_lh, 24, 20);
		$pod_gg_frp_t_al = pod_get_googlefont_property( $pod_google_front_posts_text, "text-align", "left" );
		$pod_gg_frp_t_fs = pod_get_googlefont_property( $pod_google_front_posts_text, "font-style", "normal" );
		$pod_gg_frp_t_fsi = pod_get_googlefont_property( $pod_google_front_posts_text, "font-size" );
		$pod_gg_frp_t_vw = pod_calc_responsive_font_size($pod_gg_frp_t_fsi, 18, 14);

		$pod_gg_frp_c_ff = pod_get_googlefont_property( $pod_google_front_posts_cats, "font-family" );
		$pod_gg_frp_c_fw = pod_get_googlefont_property( $pod_google_front_posts_cats, "font-weight" );
		$pod_gg_frp_c_lh = pod_get_googlefont_property( $pod_google_front_posts_cats, "line-height" );
		$pod_gg_frp_c_tt = pod_get_googlefont_property( $pod_google_front_posts_cats, "text-transform" );
		$pod_gg_frp_c_lh_vw = pod_calc_responsive_font_size($pod_gg_frp_c_lh, 24, 20);
		$pod_gg_frp_c_al = pod_get_googlefont_property( $pod_google_front_posts_cats, "text-align", "left" );
		$pod_gg_frp_c_fs = pod_get_googlefont_property( $pod_google_front_posts_cats, "font-style", "normal" );
		$pod_gg_frp_c_fsi = pod_get_googlefont_property( $pod_google_front_posts_cats, "font-size" );
		$pod_gg_frp_c_vw = pod_calc_responsive_font_size($pod_gg_frp_c_fsi, 18, 14);

		$pod_gg_frp_r_ff = pod_get_googlefont_property( $pod_google_front_posts_read_more, "font-family" );
		$pod_gg_frp_r_fw = pod_get_googlefont_property( $pod_google_front_posts_read_more, "font-weight" );
		$pod_gg_frp_r_lh = pod_get_googlefont_property( $pod_google_front_posts_read_more, "line-height" );
		$pod_gg_frp_r_lh_vw = pod_calc_responsive_font_size($pod_gg_frp_r_lh, 24, 20);
		$pod_gg_frp_r_al = pod_get_googlefont_property( $pod_google_front_posts_read_more, "text-align", "left" );
		$pod_gg_frp_r_fs = pod_get_googlefont_property( $pod_google_front_posts_read_more, "font-style", "normal" );
		$pod_gg_frp_r_fsi = pod_get_googlefont_property( $pod_google_front_posts_read_more, "font-size" );
		$pod_gg_frp_r_vw = pod_calc_responsive_font_size($pod_gg_frp_r_fsi, 18, 14);


		/* Single Post */
		$pod_gg_sin_h_ff = pod_get_googlefont_property( $pod_google_single_heading, "font-family" );
		$pod_gg_sin_h_fw = pod_get_googlefont_property( $pod_google_single_heading, "font-weight" );
		$pod_gg_sin_h_lh = pod_get_googlefont_property( $pod_google_single_heading, "line-height" );
		$pod_gg_sin_h_lh_vw = pod_calc_responsive_font_size($pod_gg_sin_h_lh, 48, 32);
		$pod_gg_sin_h_al = pod_get_googlefont_property( $pod_google_single_heading, "text-align", "left" );
		$pod_gg_sin_h_fs = pod_get_googlefont_property( $pod_google_single_heading, "font-style", "normal" );
		$pod_gg_sin_h_fsi = pod_get_googlefont_property( $pod_google_single_heading, "font-size" );
		$pod_gg_sin_h_vw = pod_calc_responsive_font_size($pod_gg_sin_h_fsi, 42, 24);

		$pod_gg_sin_t_ff = pod_get_googlefont_property( $pod_google_single_text, "font-family" );
		$pod_gg_sin_t_fw = pod_get_googlefont_property( $pod_google_single_text, "font-weight" );
		$pod_gg_sin_t_lh = pod_get_googlefont_property( $pod_google_single_text, "line-height" );
		$pod_gg_sin_t_lh_vw = pod_calc_responsive_font_size($pod_gg_sin_t_lh, 24, 20);
		$pod_gg_sin_t_al = pod_get_googlefont_property( $pod_google_single_text, "text-align", "left" );
		$pod_gg_sin_t_fs = pod_get_googlefont_property( $pod_google_single_text, "font-style", "normal" );
		$pod_gg_sin_t_fsi = pod_get_googlefont_property( $pod_google_single_text, "font-size" );
		$pod_gg_sin_t_vw = pod_calc_responsive_font_size($pod_gg_sin_t_fsi, 18, 16);


		/* Page Post */
		$pod_gg_pag_h_ff = pod_get_googlefont_property( $pod_google_page_heading, "font-family" );
		$pod_gg_pag_h_fw = pod_get_googlefont_property( $pod_google_page_heading, "font-weight" );
		$pod_gg_pag_h_lh = pod_get_googlefont_property( $pod_google_page_heading, "line-height" );
		$pod_gg_pag_h_lh_vw = pod_calc_responsive_font_size($pod_gg_pag_h_lh, 48, 32);
		$pod_gg_pag_h_fs = pod_get_googlefont_property( $pod_google_page_heading, "font-style", "normal" );
		$pod_gg_pag_h_fsi = pod_get_googlefont_property( $pod_google_page_heading, "font-size" );
		$pod_gg_pag_h_vw = pod_calc_responsive_font_size($pod_gg_pag_h_fsi, 42, 24);

		$pod_gg_pag_t_ff = pod_get_googlefont_property( $pod_google_page_text, "font-family" );
		$pod_gg_pag_t_fw = pod_get_googlefont_property( $pod_google_page_text, "font-weight" );
		$pod_gg_pag_t_lh = pod_get_googlefont_property( $pod_google_page_text, "line-height" );
		$pod_gg_pag_t_lh_vw = pod_calc_responsive_font_size($pod_gg_pag_t_lh, 24, 20);
		$pod_gg_pag_t_fs = pod_get_googlefont_property( $pod_google_page_text, "font-style", "normal" );
		$pod_gg_pag_t_fsi = pod_get_googlefont_property( $pod_google_page_text, "font-size" );
		$pod_gg_pag_t_vw = pod_calc_responsive_font_size($pod_gg_pag_t_fsi, 18, 16);


		/* Blog */
		$pod_gg_blo_h_ff = pod_get_googlefont_property( $pod_google_blog_heading, "font-family" );
		$pod_gg_blo_h_fw = pod_get_googlefont_property( $pod_google_blog_heading, "font-weight" );
		$pod_gg_blo_h_lh = pod_get_googlefont_property( $pod_google_blog_heading, "line-height" );
		$pod_gg_blo_h_lh_vw = pod_calc_responsive_font_size($pod_gg_blo_h_lh, 48, 32);
		$pod_gg_blo_h_al = pod_get_googlefont_property( $pod_google_blog_heading, "text-align", "left" );
		$pod_gg_blo_h_fs = pod_get_googlefont_property( $pod_google_blog_heading, "font-style", "normal" );
		$pod_gg_blo_h_fsi = pod_get_googlefont_property( $pod_google_blog_heading, "font-size" );
		$pod_gg_blo_h_vw = pod_calc_responsive_font_size($pod_gg_blo_h_fsi, 42, 24);

		$pod_gg_blo_t_ff = pod_get_googlefont_property( $pod_google_blog_text, "font-family" );
		$pod_gg_blo_t_fw = pod_get_googlefont_property( $pod_google_blog_text, "font-weight" );
		$pod_gg_blo_t_lh = pod_get_googlefont_property( $pod_google_blog_text, "line-height" );
		$pod_gg_blo_t_lh_vw = pod_calc_responsive_font_size($pod_gg_blo_t_lh, 24, 20);
		$pod_gg_blo_t_al = pod_get_googlefont_property( $pod_google_blog_text, "text-align", "left" );
		$pod_gg_blo_t_fs = pod_get_googlefont_property( $pod_google_blog_text, "font-style", "normal" );
		$pod_gg_blo_t_fsi = pod_get_googlefont_property( $pod_google_blog_text, "font-size" );
		$pod_gg_blo_t_vw = pod_calc_responsive_font_size($pod_gg_blo_t_fsi, 18, 14);


	    $css = '<style>';

	    // Google | Headings
	    $css .= 'h1, h2, h3, h4, h5, h6, .fromtheblog h2.title, .fromtheblog article .post-header h2, .fromtheblog.list h2.title, .next-week h3 {
	    	font-family: "' . $pod_gg_head_ff . '";
	    	font-weight: ' . $pod_gg_head_fw . ';
	    	font-style: ' . $pod_gg_head_fs . ';
	    }
	    .pod-2-podcast-archive-list .podpost .right .post-excerpt .title,
	    .page-template-pagepage-archive-php .archive_cols h2,
	    .post.format-link .entry-content > p:first-of-type a:link,
	    .post.format-link .entry-content > p:first-of-type a:visited {
	    	font-weight: ' . $pod_gg_head_fw . ';
	    }';

	    // Google | Heading Text
	    $css .= '.post .entry-header .entry-title {
	    	font-family: "' . $pod_gg_head_ff . '";
	    	font-weight: ' . $pod_gg_head_fw . ';
	    	text-align: ' . $pod_gg_head_al . ';
	    	font-style: ' . $pod_gg_head_fs . ';
	    	font-size: ' . $pod_gg_head_fsi . ';
	    	font-size: calc( 20px + ' . $pod_gg_head_vw . 'vw );
	    }
	    body.podcaster-theme {
	    	font-family: "' . $pod_gg_txt_ff . '";
	    	font-weight: ' . $pod_gg_txt_fw . ';
	    	text-align: ' . $pod_gg_txt_al . ';
	    	font-style: ' . $pod_gg_txt_fs . ';
	    	font-size: ' . $pod_gg_txt_fsi . ';
	    	font-size: calc( 14px + ' . $pod_gg_txt_vw . 'vw );
	    }
	    .newsletter-container .newsletter-form input[type="name"],
	    .newsletter-container .newsletter-form input[type="text"],
	    .newsletter-container .newsletter-form input[type="email"] {
	    	font-family: "' . $pod_gg_txt_ff . '";
	    	font-weight: ' . $pod_gg_txt_fw . ';
	    	text-align: ' . $pod_gg_txt_al . ';
	    	font-style: ' . $pod_gg_txt_fs . ';
	    	font-size: ' . $pod_gg_txt_fsi . ';
	    	font-size: calc( 14px + ' . $pod_gg_txt_vw . 'vw );
	    }
	    input[type="text"],
	    input[type="email"],
	    input[type="password"],
	    textarea {
	    	font-family: "' . $pod_gg_txt_ff . '";
	    	font-weight: ' . $pod_gg_txt_fw . ';
	    	font-style: ' . $pod_gg_txt_fs . ';
	    }

	    /* Logo & Nav */
	    .above header .main-title a:link,
	    .above header .main-title a:visited {
	    	font-family: "' . $pod_gg_logo_h_ff . '";
	    	font-weight: ' . $pod_gg_logo_h_fw . ';
	    	font-style: ' . $pod_gg_logo_h_fs . ';
	    }

	    #nav .thst-menu, #nav .menu {
	    	font-family: "' . $pod_gg_logo_l_ff . '";
	    	font-weight: ' . $pod_gg_logo_l_fw . ';
	    	font-style: ' . $pod_gg_logo_l_fs . ';
		}


		/* Front Page */
		.front-page-header .text h2 a:link,
        .front-page-header .text h2 a:visited,
        .front-page-header .text h2,
        .front-page-header.text .content-text h2,
        .latest-episode .main-featured-post h2 a:link,
        .latest-episode .main-featured-post h2 a:visited,
        .front-page-header .text .pulls-right h2,
        .front-page-header .text .pulls-left h2,
        .latest-episode .main-featured-post .pulls-right h2,
        .latest-episode .main-featured-post .pulls-left h2,
        .front-page-header .text .pulls-right h2 a,
        .front-page-header .text .pulls-left h2 a,
        .latest-episode .main-featured-post .pulls-right h2 a,
        .latest-episode .main-featured-post .pulls-left h2 a,
        .front-page-header .text h1 a:link,
        .front-page-header .text h1 a:visited,
        .front-page-header .text h1,
        .front-page-header.text .content-text h1,
        .latest-episode .main-featured-post h1 a:link,
        .latest-episode .main-featured-post h1 a:visited,
        .front-page-header .text .pulls-right h1,
        .front-page-header .text .pulls-left h1,
        .latest-episode .main-featured-post .pulls-right h1,
        .latest-episode .main-featured-post .pulls-left h1,
        .front-page-header .text .pulls-right h1 a,
        .front-page-header .text .pulls-left h1 a,
        .latest-episode .main-featured-post .pulls-right h1 a,
        .latest-episode .main-featured-post .pulls-left h1 a,
        .front-page-header-video-background .content-text h2 {
        	font-family: "' . $pod_gg_feat_h_ff . '";
	    	font-weight: ' . $pod_gg_feat_h_fw . ';
	    	text-transform: ' . $pod_gg_feat_h_tt . ';
	    	font-style: ' . $pod_gg_feat_h_fs . ';
	    	font-size: ' . $pod_gg_feat_h_fsi . ';
	    	font-size: calc( 32px + ' . $pod_gg_feat_h_vw . 'vw );
	    	line-height: ' . $pod_gg_feat_h_lh . ';
	    	line-height: calc(36px + ' . $pod_gg_feat_h_lh_vw . 'vw );
        }
        .latest-episode .main-featured-post .featured-excerpt,
        .latest-episode .main-featured-post .featured-excerpt p,
        .front-page-header .text p,
        .front-page-header .featured-excerpt,
        .front-page-header.text .content-text .content-blurb,
        .front-page-header-video-background .content-text p {
        	font-family: "' . $pod_gg_feat_t_ff . '";
	    	font-weight: ' . $pod_gg_feat_t_fw . ';
	    	font-style: ' . $pod_gg_feat_t_fs . ';
	    	font-size: ' . $pod_gg_feat_t_fsi . ';
	    	font-size: calc( 16px + ' . $pod_gg_feat_t_vw . 'vw );
        }
        .latest-episode .main-featured-post .mini-title,
        .front-page-indigo .latest-episode .main-featured-post .mini-title, 
        .front-page-header .text .mini-title {
        	font-family: "' . $pod_gg_feat_mt_ff . '";
	    	font-weight: ' . $pod_gg_feat_mt_fw . ';
	    	font-style: ' . $pod_gg_feat_mt_fs . ';
	    	font-size: ' . $pod_gg_feat_mt_fsi . ';
	    	font-size: calc( 14px + ' . $pod_gg_feat_mt_vw . 'vw );
	    	line-height: ' . $pod_gg_feat_mt_lh . ';
	    	line-height: calc(24px + ' . $pod_gg_feat_mt_lh_vw . 'vw );
	    	text-transform: ' . $pod_gg_feat_mt_tt . ';
        }
        .next-week .mini-title {
        	font-family: "' . $pod_gg_feat_smt_ff . '";
	    	font-weight: ' . $pod_gg_feat_smt_fw . ';
	    	font-style: ' . $pod_gg_feat_smt_fs . ';
	    	font-size: ' . $pod_gg_feat_smt_fsi . ';
	    	font-size: calc( 12px + ' . $pod_gg_feat_smt_vw . 'vw );
	    	line-height: ' . $pod_gg_feat_smt_lh . ';
	    	line-height: calc(20px + ' . $pod_gg_feat_smt_lh_vw . 'vw );
	    	text-transform: ' . $pod_gg_feat_smt_tt . ';
	    	letter-spacing: ' . $pod_gg_feat_smt_ls . ';	
        }
        .next-week h3,
        .next-week .schedule-message {
        	font-family: "' . $pod_gg_feat_sh_ff . '";
	    	font-weight: ' . $pod_gg_feat_sh_fw . ';
	    	font-style: ' . $pod_gg_feat_sh_fs . ';
	    	font-size: ' . $pod_gg_feat_sh_fsi . ';
	    	font-size: calc( 14px + ' . $pod_gg_feat_sh_vw . 'vw );
	    	line-height: ' . $pod_gg_feat_sh_lh . ';
	    	line-height: calc(24px + ' . $pod_gg_feat_sh_lh_vw . 'vw );
        }


        /* Front Page Posts */
        .list-of-episodes article .post-header h2,
        .list-of-episodes article.list .post-header h2,
        .list-of-episodes.front-has-sidebar article .post-header h2,
        .main-content.blog-front-page .post .entry-header .entry-title {
        	font-family: "' . $pod_gg_frp_h_ff . '";
	    	font-weight: ' . $pod_gg_frp_h_fw . ';
	    	text-align: ' . $pod_gg_frp_h_al . ';
	    	line-height: ' . $pod_gg_frp_h_lh . ';
	    	line-height: calc(32px + ' . $pod_gg_frp_h_lh_vw . 'vw );
	    	font-style: ' . $pod_gg_frp_h_fs . ';
	    	font-size: ' . $pod_gg_frp_h_fsi . ';
	    	font-size: calc( 24px + ' . $pod_gg_frp_h_vw . 'vw );
        }
        .list-of-episodes article .post-content,
        .list-of-episodes.front-has-sidebar article .post-content,
        .front-page-indigo .list-of-episodes article .post-content {
        	font-family: "' . $pod_gg_frp_t_ff . '";
	    	font-weight: ' . $pod_gg_frp_t_fw . ';
	    	text-align: ' . $pod_gg_frp_t_al . ';
	    	line-height: ' . $pod_gg_frp_t_lh . ';
	    	line-height: calc( 20px + ' . $pod_gg_frp_t_lh_vw . 'vw );
	    	font-style: ' . $pod_gg_frp_t_fs . ';
	    	font-size: ' . $pod_gg_frp_t_fsi . ';
	    	font-size: calc( 14px + ' . $pod_gg_frp_t_vw . 'vw );
        }
        .list-of-episodes article .post-header ul {
        	font-family: "' . $pod_gg_frp_c_ff . '";
	    	font-weight: ' . $pod_gg_frp_c_fw . ';
	    	text-align: ' . $pod_gg_frp_c_al . ';
	    	line-height: ' . $pod_gg_frp_c_lh . ';
	    	line-height: calc( 20px + ' . $pod_gg_frp_c_lh_vw . 'vw );
	    	font-style: ' . $pod_gg_frp_c_fs . ';
	    	font-size: ' . $pod_gg_frp_c_fsi . ';
	    	font-size: calc( 14px + ' . $pod_gg_frp_c_vw . 'vw );
	    	text-transform: ' . $pod_gg_frp_c_tt . ';
        }
        .list-of-episodes article .more-link {
        	font-family: "' . $pod_gg_frp_r_ff . '";
	    	font-weight: ' . $pod_gg_frp_r_fw . ';
	    	text-align: ' . $pod_gg_frp_r_al . ';
	    	line-height: ' . $pod_gg_frp_r_lh . ';
	    	line-height: calc( 20px + ' . $pod_gg_frp_r_lh_vw . 'vw );
	    	font-style: ' . $pod_gg_frp_r_fs . ';
	    	font-size: ' . $pod_gg_frp_r_fsi . ';
	    	font-size: calc( 14px + ' . $pod_gg_frp_r_vw . 'vw );
        }


        /* Single Post */
        .single .single-featured h1,
        .single .single-featured h2,
        .single .post .entry-header .entry-title {
        	font-family: "' . $pod_gg_sin_h_ff . '";
	    	font-weight: ' . $pod_gg_sin_h_fw . ';
	    	text-align: ' . $pod_gg_sin_h_al . ';
	    	line-height: ' . $pod_gg_sin_h_lh . ';
	    	line-height: calc( 32px + ' . $pod_gg_sin_h_lh_vw . 'vw );
	    	font-style: ' . $pod_gg_sin_h_fs . ';
	    	font-size: ' . $pod_gg_sin_h_fsi . ';
	    	font-size: calc( 24px + ' . $pod_gg_sin_h_vw . 'vw );
        }
        .single .entry-container h1,
        .single .entry-container h2,
        .single .entry-container h3,
        .single .entry-container h4,
        .single .entry-container h5,
        .single .entry-container h6,
        .single .post.format-link .entry-content > p:first-of-type {
        	font-family: "' . $pod_gg_sin_h_ff . '";

        }
        .single .entry-content h1,
        .single .entry-content h2,
        .single .entry-content h3,
        .single .entry-content h4,
        .single .entry-content h5,
        .single .entry-content h6 {
			text-align: ' . $pod_gg_sin_h_al . ';
        }
        .single .entry-container,
        .single textarea,
        .single input[type="text"],
        .single input[type="email"],
        .single input[type="password"] {
        	font-family: "' . $pod_gg_sin_t_ff . '";
	    	font-weight: ' . $pod_gg_sin_t_fw . ';
	    	text-align: ' . $pod_gg_sin_t_al . ';
	    	font-style: ' . $pod_gg_sin_t_fs . ';
	    	font-size: ' . $pod_gg_sin_t_fsi . ';
	    	font-size: calc( 16px + ' . $pod_gg_sin_t_vw . 'vw );
        }
        /*.single .entry-container,*/
        .single textarea {
	    	line-height: ' . $pod_gg_sin_t_lh . ';
	    	line-height: calc(20px + ' . $pod_gg_sin_t_lh_vw . 'vw );
        }
        .single .caption-container,
        .single .single-featured span.mini-title,
        .single-featured.header-audio-type-style-1 .single-featured-audio-container .audio-single-header-title p {
        	font-family: "' . $pod_gg_sin_t_ff . '";
        	text-align: ' . $pod_gg_sin_t_al . ';
        }
        .single .mini-ex {
        	font-family: "' . $pod_gg_sin_t_ff . '";
        }


        /* Pages */
        .reg .heading h1,
        .reg .heading h2,
        .page .reg .heading h1,
        .page .reg .heading h2,
        .podcast-archive .reg .heading h1,
        .search .reg .heading h1,
        .archive .reg .heading h1,
        .archive .reg .heading h2 {
        	font-family: "' . $pod_gg_pag_h_ff . '";
	    	font-weight: ' . $pod_gg_pag_h_fw . ';
	    	line-height: ' . $pod_gg_pag_h_lh . ';
	    	line-height: calc( 32px + ' . $pod_gg_pag_h_lh_vw . 'vw );
	    	font-style: ' . $pod_gg_pag_h_fs . ';
	    	font-size: ' . $pod_gg_pag_h_fsi . ';
	    	font-size: calc( 24px + ' . $pod_gg_pag_h_vw . 'vw );
        }
        .page .reg .heading p {
        	font-family: ' . $pod_gg_pag_h_ff . ';
        }

		.page .entry-container h1,
        .page .entry-container h2,
        .page .entry-container h3,
        .page .entry-container h4,
        .page .entry-container h5,
        .page .entry-container h6 {
        	font-family: "' . $pod_gg_pag_h_ff . '";
        }
        .arch_searchform #ind_searchform div #ind_s,
        .page .entry-container,
        .page:not(.front-page-blog-template) .post .entry-content,
        .podcast-archive .post .entry-content,
        .page .reg .heading .title p,
        .archive .reg .heading .title p,
        .search .reg .heading .title p {
        	font-family: "' . $pod_gg_pag_t_ff . '";
	    	font-weight: ' . $pod_gg_pag_t_fw . ';
	    	line-height: ' . $pod_gg_pag_t_lh . ';
	    	line-height: calc( 20px + ' . $pod_gg_pag_t_lh_vw . 'vw );
	    	font-style: ' . $pod_gg_pag_t_fs . ';
	    	font-size: ' . $pod_gg_pag_t_fsi . ';
	    	font-size: calc( 16px + ' . $pod_gg_pag_t_vw . 'vw );
        }
        .page .caption-container {
        	font-family: "' . $pod_gg_pag_t_ff . '";
        	line-height: ' . $pod_gg_pag_t_lh . ';
        	line-height: calc( 20px + ' . $pod_gg_pag_t_lh_vw . 'vw );
        }


        /* Blog */
        .blog .static .heading .title h1 {
        	font-family: "' . $pod_gg_blo_h_ff . '";
	    	font-weight: ' . $pod_gg_blo_h_fw . ';
	    	text-align: ' . $pod_gg_blo_h_al . ';
	    	line-height: ' . $pod_gg_blo_h_lh . ';
	    	line-height: calc( 32px + ' . $pod_gg_blo_h_lh_vw . 'vw );
	    	font-style: ' . $pod_gg_blo_h_fs . ';
	    	font-size: ' . $pod_gg_blo_h_fsi . ';
	    	font-size: calc( 24px + ' . $pod_gg_blo_h_vw . 'vw );
        }
        .blog .static .heading .title p {
        	font-family: "' . $pod_gg_blo_t_ff . '";
	    	font-weight: ' . $pod_gg_blo_t_fw . ';
	    	text-align: ' . $pod_gg_blo_t_al . ';
	    	line-height: ' . $pod_gg_blo_t_lh . ';
	    	line-height: calc( 20px + ' . $pod_gg_blo_t_lh_vw . 'vw );
	    	font-style: ' . $pod_gg_blo_t_fs . ';
	    	font-size: ' . $pod_gg_blo_t_fsi . ';
	    	font-size: calc( 14px + ' . $pod_gg_blo_t_vw . 'vw );
        }';
	    $css .= '</style>';

	    
		if( $pod_typography == "custom" && pod_is_rf_active()) {
			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));
			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));
	    }

	}
}
add_action("wp_head", "pod_googlefonts_css", 175, 0);


//add_action('wp_enqueue_scripts', 'pod_ado_css');
if( ! function_exists('pod_ado_css') ) {
	function pod_ado_css() {
		
		// Typekit Custom CSS
   		$pod_typography = pod_theme_option('pod-typography');

   		// Typekit | Headings
		$pod_ado_general_headings = pod_theme_option('pod-typo-headings-typek');
		$pod_ado_general_text = pod_theme_option('pod-typo-text-typek');

		// Typekit | Logo
		$pod_ado_logo_heading = pod_theme_option('pod-typo-main-heading-typek');
		$pod_ado_logo_menu_link = pod_theme_option('pod-typo-menu-links-typek');

		// Typekit | Featured Heading
		$pod_ado_feat_heading = pod_theme_option('pod-typo-featured-heading-typek');
		$pod_ado_feat_text = pod_theme_option('pod-typo-featured-text-typek');

		// Typekit | Front Page Posts
		$pod_ado_front_posts_heading = pod_theme_option('pod-typo-frontpage-heading-typek');
		$pod_ado_front_posts_text = pod_theme_option('pod-typo-frontpage-text-typek');
		$pod_ado_front_posts_cats = pod_theme_option('pod-typo-frontpage-cats-typek');
		$pod_ado_front_posts_read_more = pod_theme_option('pod-typo-frontpage-read-more-typek');
		$pod_ado_feat_mini_title = pod_theme_option('pod-typo-featured-mini-title-typek');
		$pod_ado_feat_sched_mini_title = pod_theme_option('pod-typo-featured-scheduled-mini-title-typek');
		$pod_ado_feat_sched_heading = pod_theme_option('pod-typo-featured-scheduled-heading-typek');

		// Typekit | Single
		$pod_ado_single_heading = pod_theme_option('pod-typo-single-heading-typek');
		$pod_ado_single_text = pod_theme_option('pod-typo-single-text-typek');

		// Typekit | Page
		$pod_ado_page_heading = pod_theme_option('pod-typo-page-heading-typek');
		$pod_ado_page_text = pod_theme_option('pod-typo-page-text-typek');

		// Typekit | Blog Heading
		$pod_ado_blog_heading = pod_theme_option('pod-typo-blog-heading-typek');
		$pod_ado_blog_text = pod_theme_option('pod-typo-blog-text-typek');


		$pod_ado_head_ff = pod_get_googlefont_property($pod_ado_general_headings, 'font-family');
		$pod_ado_head_al = pod_get_googlefont_property($pod_ado_general_headings, 'text-align', "left");
		$pod_ado_head_fw = pod_get_googlefont_property($pod_ado_general_headings, 'font-weight');
		$pod_ado_head_fs = pod_get_googlefont_property($pod_ado_general_headings, 'font-style', "normal");
		$pod_ado_head_fsi = pod_get_googlefont_property($pod_ado_general_headings, 'font-size');
		$pod_ado_head_vw = pod_calc_responsive_font_size($pod_ado_head_fsi, 34, 20);

		$pod_ado_txt_ff = pod_get_googlefont_property($pod_ado_general_text, "font-family");
		$pod_ado_txt_fw = pod_get_googlefont_property($pod_ado_general_text, "font-weight");
		$pod_ado_txt_al = pod_get_googlefont_property($pod_ado_general_text, "text-align", "left");
		$pod_ado_txt_fs = pod_get_googlefont_property($pod_ado_general_text, "font-style", "normal");
		$pod_ado_txt_fsi = pod_get_googlefont_property($pod_ado_general_text, "font-size");
		$pod_ado_txt_vw = pod_calc_responsive_font_size($pod_ado_txt_fsi, 18, 14);


		/* Logo */
		$pod_ado_logo_h_ff = pod_get_googlefont_property( $pod_ado_logo_heading, "font-family" );
		$pod_ado_logo_h_fw = pod_get_googlefont_property( $pod_ado_logo_heading, "font-weight" );
		$pod_ado_logo_h_fs = pod_get_googlefont_property( $pod_ado_logo_heading, "font-style", "normal" );
		$pod_ado_logo_h_fsi = pod_get_googlefont_property( $pod_ado_logo_heading, "font-size" );
		$pod_ado_logo_h_vw = pod_calc_responsive_font_size($pod_ado_logo_h_fsi, 24, 16);

		$pod_ado_logo_l_ff = pod_get_googlefont_property( $pod_ado_logo_menu_link, "font-family" );
		$pod_ado_logo_l_fw = pod_get_googlefont_property( $pod_ado_logo_menu_link, "font-weight" );
		$pod_ado_logo_l_fs = pod_get_googlefont_property( $pod_ado_logo_menu_link, "font-style", "normal" );


		/* Front Page Header */
		$pod_ado_feat_h_ff = pod_get_googlefont_property( $pod_ado_feat_heading, "font-family" );
		$pod_ado_feat_h_tt = pod_get_googlefont_property( $pod_ado_feat_heading, "text-transform", "none" );
		$pod_ado_feat_h_fw = pod_get_googlefont_property( $pod_ado_feat_heading, "font-weight" );
		$pod_ado_feat_h_lh = pod_get_googlefont_property( $pod_ado_feat_heading, "line-height" );
		$pod_ado_feat_h_lh_vw = pod_calc_responsive_font_size($pod_ado_feat_h_lh, 48, 36);
		$pod_ado_feat_h_fs = pod_get_googlefont_property( $pod_ado_feat_heading, "font-style", "normal" );
		$pod_ado_feat_h_fsi = pod_get_googlefont_property( $pod_ado_feat_heading, "font-size" );
		$pod_ado_feat_h_vw = pod_calc_responsive_font_size($pod_ado_feat_h_fsi, 54, 32);

		$pod_ado_feat_t_ff = pod_get_googlefont_property( $pod_ado_feat_text, "font-family" );
		$pod_ado_feat_t_fw = pod_get_googlefont_property( $pod_ado_feat_text, "font-weight" );
		$pod_ado_feat_t_fs = pod_get_googlefont_property( $pod_ado_feat_text, "font-style", "normal" );
		$pod_ado_feat_t_fsi = pod_get_googlefont_property( $pod_ado_feat_text, "font-size" );
		$pod_ado_feat_t_vw = pod_calc_responsive_font_size($pod_ado_feat_t_fsi, 18, 16);

		$pod_ado_feat_mt_ff = pod_get_googlefont_property( $pod_ado_feat_mini_title, "font-family" );
		$pod_ado_feat_mt_fw = pod_get_googlefont_property( $pod_ado_feat_mini_title, "font-weight" );
		$pod_ado_feat_mt_fs = pod_get_googlefont_property( $pod_ado_feat_mini_title, "font-style", "normal" );
		$pod_ado_feat_mt_fsi = pod_get_googlefont_property( $pod_ado_feat_mini_title, "font-size" );
		$pod_ado_feat_mt_tt = pod_get_googlefont_property( $pod_ado_feat_mini_title, "text-transform" );
		$pod_ado_feat_mt_vw = pod_calc_responsive_font_size($pod_ado_feat_mt_fsi, 14, 12);
		$pod_ado_feat_mt_lh = pod_get_googlefont_property( $pod_ado_feat_mini_title, "line-height" );
		$pod_ado_feat_mt_lh_vw = pod_calc_responsive_font_size($pod_ado_feat_mt_lh, 24, 16);

		$pod_ado_feat_smt_ff = pod_get_googlefont_property( $pod_ado_feat_sched_mini_title, "font-family" );
		$pod_ado_feat_smt_fw = pod_get_googlefont_property( $pod_ado_feat_sched_mini_title, "font-weight" );
		$pod_ado_feat_smt_fs = pod_get_googlefont_property( $pod_ado_feat_sched_mini_title, "font-style", "normal" );
		$pod_ado_feat_smt_tt = pod_get_googlefont_property( $pod_ado_feat_sched_mini_title, "text-transform" );
		$pod_ado_feat_smt_ls = pod_get_googlefont_property( $pod_ado_feat_sched_mini_title, "letter-spacing" );
		$pod_ado_feat_smt_fsi = pod_get_googlefont_property( $pod_ado_feat_sched_mini_title, "font-size" );
		$pod_ado_feat_smt_vw = pod_calc_responsive_font_size($pod_ado_feat_smt_fsi, 12, 11);
		$pod_ado_feat_smt_lh = pod_get_googlefont_property( $pod_ado_feat_sched_mini_title, "line-height" );
		$pod_ado_feat_smt_lh_vw = pod_calc_responsive_font_size($pod_ado_feat_smt_lh, 20, 15);

		$pod_ado_feat_sh_ff = pod_get_googlefont_property( $pod_ado_feat_sched_heading, "font-family" );
		$pod_ado_feat_sh_fw = pod_get_googlefont_property( $pod_ado_feat_sched_heading, "font-weight" );
		$pod_ado_feat_sh_fs = pod_get_googlefont_property( $pod_ado_feat_sched_heading, "font-style", "normal" );
		$pod_ado_feat_sh_fsi = pod_get_googlefont_property( $pod_ado_feat_sched_heading, "font-size" );
		$pod_ado_feat_sh_vw = pod_calc_responsive_font_size($pod_ado_feat_sh_fsi, 18, 14);
		$pod_ado_feat_sh_lh = pod_get_googlefont_property( $pod_ado_feat_sched_heading, "line-height" );
		$pod_ado_feat_sh_lh_vw = pod_calc_responsive_font_size($pod_ado_feat_sh_lh, 32, 24);


		/* Front Page Posts */
		$pod_ado_frp_h_ff = pod_get_googlefont_property( $pod_ado_front_posts_heading, "font-family" );
		$pod_ado_frp_h_fw = pod_get_googlefont_property( $pod_ado_front_posts_heading, "font-weight" );
		$pod_ado_frp_h_lh = pod_get_googlefont_property( $pod_ado_front_posts_heading, "line-height" );
		$pod_ado_frp_h_lh_vw = pod_calc_responsive_font_size($pod_ado_frp_h_lh, 36, 32);
		$pod_ado_frp_h_al = pod_get_googlefont_property( $pod_ado_front_posts_heading, "text-align", "left" );
		$pod_ado_frp_h_fs = pod_get_googlefont_property( $pod_ado_front_posts_heading, "font-style", "normal" );
		$pod_ado_frp_h_fsi = pod_get_googlefont_property( $pod_ado_front_posts_heading, "font-size" );
		$pod_ado_frp_h_vw = pod_calc_responsive_font_size($pod_ado_frp_h_fsi, 32, 24);

		$pod_ado_frp_t_ff = pod_get_googlefont_property( $pod_ado_front_posts_text, "font-family" );
		$pod_ado_frp_t_fw = pod_get_googlefont_property( $pod_ado_front_posts_text, "font-weight" );
		$pod_ado_frp_t_lh = pod_get_googlefont_property( $pod_ado_front_posts_text, "line-height" );
		$pod_ado_frp_t_lh_vw = pod_calc_responsive_font_size($pod_ado_frp_t_lh, 24, 20);
		$pod_ado_frp_t_al = pod_get_googlefont_property( $pod_ado_front_posts_text, "text-align", "left" );
		$pod_ado_frp_t_fs = pod_get_googlefont_property( $pod_ado_front_posts_text, "font-style", "normal" );
		$pod_ado_frp_t_fsi = pod_get_googlefont_property( $pod_ado_front_posts_text, "font-size" );
		$pod_ado_frp_t_vw = pod_calc_responsive_font_size($pod_ado_frp_t_fsi, 18, 14);

		$pod_ado_frp_c_ff = pod_get_googlefont_property( $pod_ado_front_posts_cats, "font-family" );
		$pod_ado_frp_c_fw = pod_get_googlefont_property( $pod_ado_front_posts_cats, "font-weight" );
		$pod_ado_frp_c_lh = pod_get_googlefont_property( $pod_ado_front_posts_cats, "line-height" );
		$pod_ado_frp_c_tt = pod_get_googlefont_property( $pod_ado_front_posts_cats, "text-transform" );
		$pod_ado_frp_c_lh_vw = pod_calc_responsive_font_size($pod_ado_frp_c_lh, 24, 20);
		$pod_ado_frp_c_al = pod_get_googlefont_property( $pod_ado_front_posts_cats, "text-align", "left" );
		$pod_ado_frp_c_fs = pod_get_googlefont_property( $pod_ado_front_posts_cats, "font-style", "normal" );
		$pod_ado_frp_c_fsi = pod_get_googlefont_property( $pod_ado_front_posts_cats, "font-size" );
		$pod_ado_frp_c_vw = pod_calc_responsive_font_size($pod_ado_frp_c_fsi, 18, 14);

		$pod_ado_frp_r_ff = pod_get_googlefont_property( $pod_ado_front_posts_read_more, "font-family" );
		$pod_ado_frp_r_fw = pod_get_googlefont_property( $pod_ado_front_posts_read_more, "font-weight" );
		$pod_ado_frp_r_lh = pod_get_googlefont_property( $pod_ado_front_posts_read_more, "line-height" );
		$pod_ado_frp_r_lh_vw = pod_calc_responsive_font_size($pod_ado_frp_r_lh, 24, 20);
		$pod_ado_frp_r_al = pod_get_googlefont_property( $pod_ado_front_posts_read_more, "text-align", "left" );
		$pod_ado_frp_r_fs = pod_get_googlefont_property( $pod_ado_front_posts_read_more, "font-style", "normal" );
		$pod_ado_frp_r_fsi = pod_get_googlefont_property( $pod_ado_front_posts_read_more, "font-size" );
		$pod_ado_frp_r_vw = pod_calc_responsive_font_size($pod_ado_frp_r_fsi, 18, 14);


		/* Single Post */
		$pod_ado_sin_h_ff = pod_get_googlefont_property( $pod_ado_single_heading, "font-family" );
		$pod_ado_sin_h_fw = pod_get_googlefont_property( $pod_ado_single_heading, "font-weight" );
		$pod_ado_sin_h_lh = pod_get_googlefont_property( $pod_ado_single_heading, "line-height" );
		$pod_ado_sin_h_lh_vw = pod_calc_responsive_font_size($pod_ado_sin_h_lh, 48, 32);
		$pod_ado_sin_h_al = pod_get_googlefont_property( $pod_ado_single_heading, "text-align", "left" );
		$pod_ado_sin_h_fs = pod_get_googlefont_property( $pod_ado_single_heading, "font-style", "normal" );
		$pod_ado_sin_h_fsi = pod_get_googlefont_property( $pod_ado_single_heading, "font-size" );
		$pod_ado_sin_h_vw = pod_calc_responsive_font_size($pod_ado_sin_h_fsi, 42, 24);

		$pod_ado_sin_t_ff = pod_get_googlefont_property( $pod_ado_single_text, "font-family" );
		$pod_ado_sin_t_fw = pod_get_googlefont_property( $pod_ado_single_text, "font-weight" );
		$pod_ado_sin_t_lh = pod_get_googlefont_property( $pod_ado_single_text, "line-height" );
		$pod_ado_sin_t_lh_vw = pod_calc_responsive_font_size($pod_ado_sin_t_lh, 24, 20);
		$pod_ado_sin_t_al = pod_get_googlefont_property( $pod_ado_single_text, "text-align", "left" );
		$pod_ado_sin_t_fs = pod_get_googlefont_property( $pod_ado_single_text, "font-style", "normal" );
		$pod_ado_sin_t_fsi = pod_get_googlefont_property( $pod_ado_single_text, "font-size" );
		$pod_ado_sin_t_vw = pod_calc_responsive_font_size($pod_ado_sin_t_fsi, 18, 16);


		/* Page Post */
		$pod_ado_pag_h_ff = pod_get_googlefont_property( $pod_ado_page_heading, "font-family" );
		$pod_ado_pag_h_fw = pod_get_googlefont_property( $pod_ado_page_heading, "font-weight" );
		$pod_ado_pag_h_lh = pod_get_googlefont_property( $pod_ado_page_heading, "line-height" );
		$pod_ado_pag_h_lh_vw = pod_calc_responsive_font_size($pod_ado_pag_h_lh, 48, 32);
		$pod_ado_pag_h_fs = pod_get_googlefont_property( $pod_ado_page_heading, "font-style", "normal" );
		$pod_ado_pag_h_fsi = pod_get_googlefont_property( $pod_ado_page_heading, "font-size" );
		$pod_ado_pag_h_vw = pod_calc_responsive_font_size($pod_ado_pag_h_fsi, 42, 24);

		$pod_ado_pag_t_ff = pod_get_googlefont_property( $pod_ado_page_text, "font-family" );
		$pod_ado_pag_t_fw = pod_get_googlefont_property( $pod_ado_page_text, "font-weight" );
		$pod_ado_pag_t_lh = pod_get_googlefont_property( $pod_ado_page_text, "line-height" );
		$pod_ado_pag_t_lh_vw = pod_calc_responsive_font_size($pod_ado_pag_t_lh, 24, 20);
		$pod_ado_pag_t_fs = pod_get_googlefont_property( $pod_ado_page_text, "font-style", "normal" );
		$pod_ado_pag_t_fsi = pod_get_googlefont_property( $pod_ado_page_text, "font-size" );
		$pod_ado_pag_t_vw = pod_calc_responsive_font_size($pod_ado_pag_t_fsi, 18, 16);


		/* Blog */
		$pod_ado_blo_h_ff = pod_get_googlefont_property( $pod_ado_blog_heading, "font-family" );
		$pod_ado_blo_h_fw = pod_get_googlefont_property( $pod_ado_blog_heading, "font-weight" );
		$pod_ado_blo_h_lh = pod_get_googlefont_property( $pod_ado_blog_heading, "line-height" );
		$pod_ado_blo_h_lh_vw = pod_calc_responsive_font_size($pod_ado_blo_h_lh, 48, 32);
		$pod_ado_blo_h_al = pod_get_googlefont_property( $pod_ado_blog_heading, "text-align", "left" );
		$pod_ado_blo_h_fs = pod_get_googlefont_property( $pod_ado_blog_heading, "font-style", "normal" );
		$pod_ado_blo_h_fsi = pod_get_googlefont_property( $pod_ado_blog_heading, "font-size" );
		$pod_ado_blo_h_vw = pod_calc_responsive_font_size($pod_ado_blo_h_fsi, 42, 24);

		$pod_ado_blo_t_ff = pod_get_googlefont_property( $pod_ado_blog_text, "font-family" );
		$pod_ado_blo_t_fw = pod_get_googlefont_property( $pod_ado_blog_text, "font-weight" );
		$pod_ado_blo_t_lh = pod_get_googlefont_property( $pod_ado_blog_text, "line-height" );
		$pod_ado_blo_t_lh_vw = pod_calc_responsive_font_size($pod_ado_blo_t_lh, 24, 20);
		$pod_ado_blo_t_al = pod_get_googlefont_property( $pod_ado_blog_text, "text-align", "left" );
		$pod_ado_blo_t_fs = pod_get_googlefont_property( $pod_ado_blog_text, "font-style", "normal" );
		$pod_ado_blo_t_fsi = pod_get_googlefont_property( $pod_ado_blog_text, "font-size" );
		$pod_ado_blo_t_vw = pod_calc_responsive_font_size($pod_ado_blo_t_fsi, 18, 14);


	    $css = '<style>';

	    // Typekit | Headings
	    $css .= 'h1, h2, h3, h4, h5, h6, .fromtheblog h2.title, .fromtheblog article .post-header h2, .fromtheblog.list h2.title, .next-week h3 {
	    	font-family: "' . $pod_ado_head_ff . '";
	    	font-weight: ' . $pod_ado_head_fw . ';
	    	font-style: ' . $pod_ado_head_fs . ';
	    }
	    .pod-2-podcast-archive-list .podpost .right .post-excerpt .title,
	    .page-template-pagepage-archive-php .archive_cols h2,
	    .post.format-link .entry-content > p:first-of-type a:link,
	    .post.format-link .entry-content > p:first-of-type a:visited {
	    	font-weight: ' . $pod_ado_head_fw . ';
	    }';

	    // Typekit | Heading Text
	    $css .= '.post .entry-header .entry-title {
	    	font-family: "' . $pod_ado_head_ff . '";
	    	font-weight: ' . $pod_ado_head_fw . ';
	    	text-align: ' . $pod_ado_head_al . ';
	    	font-style: ' . $pod_ado_head_fs . ';
	    	font-size: ' . $pod_ado_head_fsi . ';
	    	font-size: calc( 20px + ' . $pod_ado_head_vw . 'vw );
	    }
	    body.podcaster-theme {
	    	font-family: "' . $pod_ado_txt_ff . '";
	    	font-weight: ' . $pod_ado_txt_fw . ';
	    	text-align: ' . $pod_ado_txt_al . ';
	    	font-style: ' . $pod_ado_txt_fs . ';
	    	font-size: ' . $pod_ado_txt_fsi . ';
	    	font-size: calc( 14px + ' . $pod_ado_txt_vw . 'vw );
	    }
	    .newsletter-container .newsletter-form input[type="name"],
	    .newsletter-container .newsletter-form input[type="email"] {
	    	font-family: "' . $pod_ado_txt_ff . '";
	    	font-weight: ' . $pod_ado_txt_fw . ';
	    	text-align: ' . $pod_ado_txt_al . ';
	    	font-style: ' . $pod_ado_txt_fs . ';
	    	font-size: ' . $pod_ado_txt_fsi . ';
	    	font-size: calc( 14px + ' . $pod_ado_txt_vw . 'vw );
	    }
	    input[type="text"],
	    input[type="email"],
	    input[type="password"],
	    textarea {
	    	font-family: "' . $pod_ado_txt_ff . '";
	    	font-weight: ' . $pod_ado_txt_fw . ';
	    	font-style: ' . $pod_ado_txt_fs . ';
	    }

	    /* Logo & Nav */
	    .above header .main-title a:link,
	    .above header .main-title a:visited {
	    	font-family: "' . $pod_ado_logo_h_ff . '";
	    	font-weight: ' . $pod_ado_logo_h_fw . ';
	    	font-style: ' . $pod_ado_logo_h_fs . ';
	    }

	    #nav .thst-menu, #nav .menu {
	    	font-family: "' . $pod_ado_logo_l_ff . '";
	    	font-weight: ' . $pod_ado_logo_l_fw . ';
	    	font-style: ' . $pod_ado_logo_l_fs . ';
		}


		/* Front Page */
		.front-page-header .text h2 a:link,
        .front-page-header .text h2 a:visited,
        .front-page-header .text h2,
        .front-page-header.text .content-text h2,
        .latest-episode .main-featured-post h2 a:link,
        .latest-episode .main-featured-post h2 a:visited,
        .front-page-header .text .pulls-right h2,
        .front-page-header .text .pulls-left h2,
        .latest-episode .main-featured-post .pulls-right h2,
        .latest-episode .main-featured-post .pulls-left h2,
        .front-page-header .text .pulls-right h2 a,
        .front-page-header .text .pulls-left h2 a,
        .latest-episode .main-featured-post .pulls-right h2 a,
        .latest-episode .main-featured-post .pulls-left h2 a,
        .front-page-header .text h1 a:link,
        .front-page-header .text h1 a:visited,
        .front-page-header .text h1,
        .front-page-header.text .content-text h1,
        .latest-episode .main-featured-post h1 a:link,
        .latest-episode .main-featured-post h1 a:visited,
        .front-page-header .text .pulls-right h1,
        .front-page-header .text .pulls-left h1,
        .latest-episode .main-featured-post .pulls-right h1,
        .latest-episode .main-featured-post .pulls-left h1,
        .front-page-header .text .pulls-right h1 a,
        .front-page-header .text .pulls-left h1 a,
        .latest-episode .main-featured-post .pulls-right h1 a,
        .latest-episode .main-featured-post .pulls-left h1 a,
        .front-page-header-video-background .content-text h2 {
        	font-family: "' . $pod_ado_feat_h_ff . '";
	    	font-weight: ' . $pod_ado_feat_h_fw . ';
	    	text-transform: ' . $pod_ado_feat_h_tt . ';
	    	font-style: ' . $pod_ado_feat_h_fs . ';
	    	font-size: ' . $pod_ado_feat_h_fsi . ';
	    	font-size: calc( 32px + ' . $pod_ado_feat_h_vw . 'vw );
	    	line-height: ' . $pod_ado_feat_h_lh . ';
	    	line-height: calc(36px + ' . $pod_ado_feat_h_lh_vw . 'vw );
        }
        .latest-episode .main-featured-post .featured-excerpt,
        .latest-episode .main-featured-post .featured-excerpt p,
        .front-page-header .text p,
        .front-page-header .featured-excerpt,
        .front-page-header.text .content-text .content-blurb,
        .front-page-header-video-background .content-text p {
        	font-family: "' . $pod_ado_feat_t_ff . '";
	    	font-weight: ' . $pod_ado_feat_t_fw . ';
	    	font-style: ' . $pod_ado_feat_t_fs . ';
	    	font-size: ' . $pod_ado_feat_t_fsi . ';
	    	font-size: calc( 16px + ' . $pod_ado_feat_t_vw . 'vw );
        }
        .latest-episode .main-featured-post .mini-title,
        .front-page-indigo .latest-episode .main-featured-post .mini-title, 
        .front-page-header .text .mini-title {
        	font-family: "' . $pod_ado_feat_mt_ff . '";
	    	font-weight: ' . $pod_ado_feat_mt_fw . ';
	    	font-style: ' . $pod_ado_feat_mt_fs . ';
	    	font-size: ' . $pod_ado_feat_mt_fsi . ';
	    	font-size: calc( 14px + ' . $pod_ado_feat_mt_vw . 'vw );
	    	line-height: ' . $pod_ado_feat_mt_lh . ';
	    	line-height: calc(24px + ' . $pod_ado_feat_mt_lh_vw . 'vw );
	    	text-transform: ' . $pod_ado_feat_mt_tt . ';
        }
        .next-week .mini-title {
        	font-family: "' . $pod_ado_feat_smt_ff . '";
	    	font-weight: ' . $pod_ado_feat_smt_fw . ';
	    	font-style: ' . $pod_ado_feat_smt_fs . ';
	    	font-size: ' . $pod_ado_feat_smt_fsi . ';
	    	font-size: calc( 12px + ' . $pod_ado_feat_smt_vw . 'vw );
	    	line-height: ' . $pod_ado_feat_smt_lh . ';
	    	line-height: calc(20px + ' . $pod_ado_feat_smt_lh_vw . 'vw );
	    	text-transform: ' . $pod_ado_feat_smt_tt . ';
	    	letter-spacing: ' . $pod_ado_feat_smt_ls . ';	
        }
        .next-week h3,
        .next-week .schedule-message {
        	font-family: "' . $pod_ado_feat_sh_ff . '";
	    	font-weight: ' . $pod_ado_feat_sh_fw . ';
	    	font-style: ' . $pod_ado_feat_sh_fs . ';
	    	font-size: ' . $pod_ado_feat_sh_fsi . ';
	    	font-size: calc( 14px + ' . $pod_ado_feat_sh_vw . 'vw );
	    	line-height: ' . $pod_ado_feat_sh_lh . ';
	    	line-height: calc(24px + ' . $pod_ado_feat_sh_lh_vw . 'vw );
        }


        /* Front Page Posts */
        .list-of-episodes article .post-header h2,
        .list-of-episodes article.list .post-header h2,
        .list-of-episodes.front-has-sidebar article .post-header h2,
        .main-content.blog-front-page .post .entry-header .entry-title {
        	font-family: "' . $pod_ado_frp_h_ff . '";
	    	font-weight: ' . $pod_ado_frp_h_fw . ';
	    	text-align: ' . $pod_ado_frp_h_al . ';
	    	line-height: ' . $pod_ado_frp_h_lh . ';
	    	line-height: calc(32px + ' . $pod_ado_frp_h_lh_vw . 'vw );
	    	font-style: ' . $pod_ado_frp_h_fs . ';
	    	font-size: ' . $pod_ado_frp_h_fsi . ';
	    	font-size: calc( 24px + ' . $pod_ado_frp_h_vw . 'vw );
        }
        .list-of-episodes article .post-content,
        .list-of-episodes.front-has-sidebar article .post-content,
        .front-page-indigo .list-of-episodes article .post-content,
        .list-of-episodes article .post-content p {
        	font-family: "' . $pod_ado_frp_t_ff . '";
	    	font-weight: ' . $pod_ado_frp_t_fw . ';
	    	text-align: ' . $pod_ado_frp_t_al . ';
	    	line-height: ' . $pod_ado_frp_t_lh . ';
	    	line-height: calc( 20px + ' . $pod_ado_frp_t_lh_vw . 'vw );
	    	font-style: ' . $pod_ado_frp_t_fs . ';
	    	font-size: ' . $pod_ado_frp_t_fsi . ';
	    	font-size: calc( 14px + ' . $pod_ado_frp_t_vw . 'vw );
        }
        .list-of-episodes article .post-header ul {
        	font-family: "' . $pod_ado_frp_c_ff . '";
	    	font-weight: ' . $pod_ado_frp_c_fw . ';
	    	text-align: ' . $pod_ado_frp_c_al . ';
	    	line-height: ' . $pod_ado_frp_c_lh . ';
	    	line-height: calc( 20px + ' . $pod_ado_frp_c_lh_vw . 'vw );
	    	font-style: ' . $pod_ado_frp_c_fs . ';
	    	font-size: ' . $pod_ado_frp_c_fsi . ';
	    	font-size: calc( 14px + ' . $pod_ado_frp_c_vw . 'vw );
	    	text-transform: ' . $pod_ado_frp_c_tt . ';
        }
        .list-of-episodes article .more-link {
        	font-family: "' . $pod_ado_frp_r_ff . '";
	    	font-weight: ' . $pod_ado_frp_r_fw . ';
	    	text-align: ' . $pod_ado_frp_r_al . ';
	    	line-height: ' . $pod_ado_frp_r_lh . ';
	    	line-height: calc( 20px + ' . $pod_ado_frp_r_lh_vw . 'vw );
	    	font-style: ' . $pod_ado_frp_r_fs . ';
	    	font-size: ' . $pod_ado_frp_r_fsi . ';
	    	font-size: calc( 14px + ' . $pod_ado_frp_r_vw . 'vw );
        }


        /* Single Post */
        .single .single-featured h1,
        .single .single-featured h2,
        .single .post .entry-header .entry-title {
        	font-family: "' . $pod_ado_sin_h_ff . '";
	    	font-weight: ' . $pod_ado_sin_h_fw . ';
	    	text-align: ' . $pod_ado_sin_h_al . ';
	    	line-height: ' . $pod_ado_sin_h_lh . ';
	    	line-height: calc( 32px + ' . $pod_ado_sin_h_lh_vw . 'vw );
	    	font-style: ' . $pod_ado_sin_h_fs . ';
	    	font-size: ' . $pod_ado_sin_h_fsi . ';
	    	font-size: calc( 24px + ' . $pod_ado_sin_h_vw . 'vw );
        }
        .single .entry-container h1,
        .single .entry-container h2,
        .single .entry-container h3,
        .single .entry-container h4,
        .single .entry-container h5,
        .single .entry-container h6,
        .single .post.format-link .entry-content > p:first-of-type {
        	font-family: "' . $pod_ado_sin_h_ff . '";
        }
        .single .entry-content h1,
        .single .entry-content h2,
        .single .entry-content h3,
        .single .entry-content h4,
        .single .entry-content h5,
        .single .entry-content h6 {
        	text-align: ' . $pod_ado_sin_h_al . ';
        }
        .single .entry-container,
        .single textarea,
        .single input[type="text"],
        .single input[type="email"],
        .single input[type="password"] {
        	font-family: "' . $pod_ado_sin_t_ff . '";
	    	font-weight: ' . $pod_ado_sin_t_fw . ';
	    	text-align: ' . $pod_ado_sin_t_al . ';
	    	font-style: ' . $pod_ado_sin_t_fs . ';
	    	font-size: ' . $pod_ado_sin_t_fsi . ';
	    	font-size: calc( 16px + ' . $pod_ado_sin_t_vw . 'vw );
        }
        .single textarea {
	    	line-height: ' . $pod_ado_sin_t_lh . ';
	    	line-height: calc(20px + ' . $pod_ado_sin_t_lh_vw . 'vw );
        }
        .single .caption-container,
        .single .single-featured span.mini-title,
        .single-featured.header-audio-type-style-1 .single-featured-audio-container .audio-single-header-title p {
        	font-family: "' . $pod_ado_sin_t_ff . '";
        	text-align: ' . $pod_ado_sin_t_al . ';
        }
        .single .mini-ex {
        	font-family: "' . $pod_ado_sin_t_ff . '";
        }


        /* Pages */
        .reg .heading h1,
        .reg .heading h2,
        .page .reg .heading h1,
        .page .reg .heading h2,
        .podcast-archive .reg .heading h1,
        .search .reg .heading h1,
        .archive .reg .heading h1,
        .archive .reg .heading h2 {
        	font-family: "' . $pod_ado_pag_h_ff . '";
	    	font-weight: ' . $pod_ado_pag_h_fw . ';
	    	line-height: ' . $pod_ado_pag_h_lh . ';
	    	line-height: calc( 32px + ' . $pod_ado_pag_h_lh_vw . 'vw );
	    	font-style: ' . $pod_ado_pag_h_fs . ';
	    	font-size: ' . $pod_ado_pag_h_fsi . ';
	    	font-size: calc( 24px + ' . $pod_ado_pag_h_vw . 'vw );
        }
        .page .reg .heading p {
        	font-family: ' . $pod_ado_pag_h_ff . ';
        }

		.page .entry-container h1,
        .page .entry-container h2,
        .page .entry-container h3,
        .page .entry-container h4,
        .page .entry-container h5,
        .page .entry-container h6 {
        	font-family: "' . $pod_ado_pag_h_ff . '";
        }
        .arch_searchform #ind_searchform div #ind_s,
        .page .entry-container,
        .page:not(.front-page-blog-template) .post .entry-content,
        .podcast-archive .post .entry-content,
        .page .reg .heading .title p,
        .archive .reg .heading .title p,
        .search .reg .heading .title p {
        	font-family: "' . $pod_ado_pag_t_ff . '";
	    	font-weight: ' . $pod_ado_pag_t_fw . ';
	    	line-height: ' . $pod_ado_pag_t_lh . ';
	    	line-height: calc( 20px + ' . $pod_ado_pag_t_lh_vw . 'vw );
	    	font-style: ' . $pod_ado_pag_t_fs . ';
	    	font-size: ' . $pod_ado_pag_t_fsi . ';
	    	font-size: calc( 16px + ' . $pod_ado_pag_t_vw . 'vw );
        }
        .page .caption-container {
        	font-family: "' . $pod_ado_pag_t_ff . '";
        	line-height: ' . $pod_ado_pag_t_lh . ';
        	line-height: calc( 20px + ' . $pod_ado_pag_t_lh_vw . 'vw );
        }


        /* Blog */
        .blog .static .heading .title h1 {
        	font-family: "' . $pod_ado_blo_h_ff . '";
	    	font-weight: ' . $pod_ado_blo_h_fw . ';
	    	text-align: ' . $pod_ado_blo_h_al . ';
	    	line-height: ' . $pod_ado_blo_h_lh . ';
	    	line-height: calc( 32px + ' . $pod_ado_blo_h_lh_vw . 'vw );
	    	font-style: ' . $pod_ado_blo_h_fs . ';
	    	font-size: ' . $pod_ado_blo_h_fsi . ';
	    	font-size: calc( 24px + ' . $pod_ado_blo_h_vw . 'vw );
        }
        .blog .static .heading .title p {
        	font-family: "' . $pod_ado_blo_t_ff . '";
	    	font-weight: ' . $pod_ado_blo_t_fw . ';
	    	text-align: ' . $pod_ado_blo_t_al . ';
	    	line-height: ' . $pod_ado_blo_t_lh . ';
	    	line-height: calc( 20px + ' . $pod_ado_blo_t_lh_vw . 'vw );
	    	font-style: ' . $pod_ado_blo_t_fs . ';
	    	font-size: ' . $pod_ado_blo_t_fsi . ';
	    	font-size: calc( 14px + ' . $pod_ado_blo_t_vw . 'vw );
        }';
	    $css .= '</style>';


		if( $pod_typography == "custom-typekit" && pod_is_rf_active()) {
			$css = str_replace(PHP_EOL, '', $css);
    		$css = trim(preg_replace('!\s+!', ' ', $css));
			echo str_replace( "&gt;", ">", wp_kses($css, array('style' => array())));
	    }
	}
}
add_action("wp_head", "pod_ado_css", 175, 0);


/**
 * Display Logo
 *
 * @since 1.6.2
 */
if( ! function_exists('pod_logo_img')) {
	function pod_logo_img() {

		$pod_upload_logo = pod_theme_option('pod-upload-logo');
		$pod_upload_logo_url = isset( $pod_upload_logo['url'] ) ? $pod_upload_logo['url'] : '';

		$pod_upload_logo_x2 = pod_theme_option('pod-upload-logo-ret');
		$pod_upload_logo_x2_url = isset( $pod_upload_logo_x2['url'] ) ? $pod_upload_logo_x2['url'] : '';

		$pod_upload_logo_sticky = pod_theme_option('pod-upload-logo-sticky');
		$pod_upload_logo_sticky_url = isset( $pod_upload_logo_sticky['url'] ) ? $pod_upload_logo_sticky['url'] : '';

		$pod_upload_logo_sticky_x2 = pod_theme_option('pod-upload-logo-ret-sticky');
		$pod_upload_logo_sticky_x2_url = isset( $pod_upload_logo_sticky_x2['url'] ) ? $pod_upload_logo_sticky_x2['url'] : '';

		$output = '';

		if( $pod_upload_logo_url != '' || has_custom_logo() ) {

			$output .= '<div class="logo with-img ">';
				$output .= '<a href="' . esc_url( home_url() ) . '">';

					if( $pod_upload_logo_url != "" ){
						$output .= '<img class="regular" alt="' .get_bloginfo('name'). '" src="' .$pod_upload_logo_url. '">';
					} else {
						$output .= pod_custom_logo( "regular" );
					}


					if( $pod_upload_logo_x2_url != "" ){
						$output .= '<img class="regular retina" alt="' .get_bloginfo('name'). '" src="' .$pod_upload_logo_x2_url. '">';
					} elseif( $pod_upload_logo_url != "" ) {
						$output .= '<img class="regular retina non-retina" alt="' .get_bloginfo('name'). '" src="' .$pod_upload_logo_url. '">';
					} else {
						$output .= pod_custom_logo( "regular retina non-retina" );
					}


					if( $pod_upload_logo_sticky_url != "" ){
						$output .= '<img class="sticky" alt="' .get_bloginfo('name'). '" src="' .$pod_upload_logo_sticky_url. '">';
					} elseif( $pod_upload_logo_url != '' ){ 
						$output .= '<img class="sticky non-sticky" alt="' .get_bloginfo('name'). '" src="' .$pod_upload_logo_url. '">';
					} else {
						$output .= pod_custom_logo( "sticky non-sticky" );
					}


					if( $pod_upload_logo_sticky_x2_url != "" ){
						$output .= '<img class="sticky retina" alt="' .get_bloginfo('name'). '" src="' .$pod_upload_logo_sticky_x2_url. '">';
					} elseif( $pod_upload_logo_sticky_url != "" ) {
						$output .= '<img class="sticky retina non-retina" alt="' .get_bloginfo('name'). '" src="' .$pod_upload_logo_sticky_url. '">';
					} elseif( $pod_upload_logo_x2_url != '' ) {
						$output .= '<img class="sticky retina" alt="' .get_bloginfo('name'). '" src="' .$pod_upload_logo_x2_url. '">';
					} elseif( $pod_upload_logo_url != '' ){ 
						$output .= '<img class="sticky retina non-retina" alt="' .get_bloginfo('name'). '" src="' .$pod_upload_logo_url. '">';
					} else {
						$output .= pod_custom_logo( "sticky retina non-retina" );
					}

				$output .= '</a>';
			$output .= '</div><!-- .logo -->';
		} else {
			$htag = 'h1';
			$htag = ( is_singular() ) ? 'p' : 'h1';
			$output .= '<' . $htag . ' class="main-title">
						<a href="' .esc_url( home_url() ). '" title="' . get_bloginfo('name') . '" rel="home">' .get_bloginfo('name'). '</a>
					</' . $htag . '>';
		}
        return $output;
	}
}

if( ! function_exists( 'pod_get_social_media_user' ) ) {
	function pod_get_social_media_user( $author_id ) {

		$email = get_the_author_meta( 'contact_email', $author_id );
		//$website = get_the_author_meta( 'user_website', $author_id );
		$website = get_the_author_meta( 'user_url', $author_id );
		$twitter = get_the_author_meta( 'user_twitter', $author_id );
		$position = get_the_author_meta( 'user_position', $author_id );
		$google = get_the_author_meta( 'user_googleplus', $author_id );
		$facebook = get_the_author_meta( 'user_facebook', $author_id );
		$skype = get_the_author_meta( 'user_skype', $author_id );
		$youtube = get_the_author_meta( 'user_youtube', $author_id );
		$vimeo = get_the_author_meta( 'user_vimeo', $author_id );
		$dribbble = get_the_author_meta( 'user_dribbble', $author_id );
		$flickr = get_the_author_meta( 'user_flickr', $author_id );
		$instagram = get_the_author_meta( 'user_instagram', $author_id );
		$tumblr = get_the_author_meta( 'user_tumblr', $author_id );
		$twitch = get_the_author_meta( 'user_twitch', $author_id );
		$soundcloud = get_the_author_meta( 'user_soundcloud', $author_id );
		$pinterest = get_the_author_meta( 'user_pinterest', $author_id );
		$xing = get_the_author_meta( 'user_xing', $author_id );
		$linkedin = get_the_author_meta( 'user_linkedin', $author_id );
		$github = get_the_author_meta( 'user_github', $author_id );
		$stackex = get_the_author_meta( 'user_stackex', $author_id );
		$rss = get_the_author_meta( 'user_rss', $author_id );
		$snapchat = get_the_author_meta( 'user_snapchat', $author_id );
		$spotify = get_the_author_meta( 'user_spotify', $author_id );
		$mixcloud = get_the_author_meta( 'user_mixcloud', $author_id );
		$itunes = get_the_author_meta( 'user_itunes', $author_id );
		$tiktok = get_the_author_meta( 'user_tiktok', $author_id );
		$periscope = get_the_author_meta( 'user_periscope', $author_id );
		$telegram = get_the_author_meta( 'user_telegram', $author_id );
		$apple_podcasts = get_the_author_meta( 'user_apple_podcasts', $author_id );
		$stitcher = get_the_author_meta( 'user_stitcher', $author_id );
		$iheartradio = get_the_author_meta( 'user_iheartradio', $author_id );
		$google_podcasts = get_the_author_meta( 'user_google_podcasts', $author_id );
		$medium = get_the_author_meta( 'user_medium', $author_id );
		$android = get_the_author_meta( 'user_android', $author_id );
		$patreon = get_the_author_meta( 'user_patreon', $author_id );
		$paypal = get_the_author_meta( 'user_paypal', $author_id );
		$foursquare = get_the_author_meta( 'user_foursquare', $author_id );
		$whatsapp = get_the_author_meta( 'user_whatsapp', $author_id );
		$weibo = get_the_author_meta( 'user_weibo', $author_id );


		$output = '';

		if( is_author() ) {

			if ( $email != '' ) : $output .= '<li><a class="sicon email" href="mailto:' . sanitize_email( $email ). '"></a></li>'; endif;
			if ( $website != '' ) : $output .= '<li><a class="sicon website" href="' . esc_url( $website ) . '"></a></li>' ; endif;
			if ( $rss != '' ) : $output .= '<li><a class="sicon rss" href="' . esc_url( $rss ) . '"></a></li>'; endif;
			if ( $facebook != '' ) : $output .= '<li><a class="sicon facebook_2" href="' . esc_url( $facebook ). '"></a></li>'; endif;
			if ( $twitter != '' ) : $output .= '<li><a class="sicon twitter" href="' . esc_url( $twitter ) . '"></a></li>'; endif;
			if ( $google != '' ) : $output .= '<li><a class="sicon googleplus" href="' . esc_url( $google ) . '"></a></li>'; endif;
			if ( $instagram != '' ) : $output .= '<li><a class="sicon instagram" href="' . esc_url( $instagram ) . '"></a></li>'; endif;
			if ( $snapchat != '' ) : $output .= '<li><a class="sicon snapchat" href="' . esc_url( $snapchat ) . '"></a></li>'; endif;
			if ( $tiktok != '' ) : $output .= '<li><a class="sicon tiktok" href="' . esc_url( $tiktok ) . '"></a></li>'; endif;
			if ( $periscope != '' ) : $output .= '<li><a class="sicon periscope" href="' . esc_url( $periscope ) . '"></a></li>'; endif;
			if ( $telegram != '' ) : $output .= '<li><a class="sicon telegram" href="' . esc_url( $telegram ) . '"></a></li>'; endif;
			if ( $itunes != '' ) : $output .= '<li><a class="sicon itunes" href="' . esc_url( $itunes ) . '"></a></li>'; endif;
			if ( $soundcloud != '' ) : $output .= '<li><a class="sicon soundcloud" href="' . esc_url( $soundcloud ) . '"></a></li>'; endif;
			if ( $mixcloud != '' ) : $output .= '<li><a class="sicon mixcloud" href="' . esc_url( $mixcloud ) . '"></a></li>'; endif;
			if ( $spotify != '' ) : $output .= '<li><a class="sicon spotify" href="' . esc_url( $spotify ) . '"></a></li>'; endif;

			if ( $apple_podcasts != '' ) : $output .= '<li><a class="sicon apple_podcasts" href="' . esc_url( $apple_podcasts ) . '">' . social_media_icon_a_p() . '</a></li>'; endif;
			if ( $stitcher != '' ) : $output .= '<li><a class="sicon stitcher" href="' . esc_url( $stitcher ) . '">' . social_media_icon_s() . '</a></li>'; endif;
			if ( $iheartradio != '' ) : $output .= '<li><a class="sicon iheartradio" href="' . esc_url( $iheartradio ) . '">' . social_media_icon_ihr() . '</a></li>'; endif;
			if ( $google_podcasts != '' ) : $output .= '<li><a class="sicon google_podcasts" href="' . esc_url( $google_podcasts ) . '">' . social_media_icon_g_p() . '</a></li>'; endif;

			if ( $pinterest != '' ) : $output .= '<li><a class="sicon pinterest" href="' . esc_url( $pinterest ) . '"></a></li>'; endif;
			if ( $tumblr != '' ) : $output .= '<li><a class="sicon tumblr" href="' . esc_url( $tumblr ) . '"></a></li>'; endif;
			if ( $medium != '' ) : $output .= '<li><a class="sicon medium" href="' . esc_url( $medium ) . '"></a></li>'; endif;
			
			if ( $flickr != '' ) : $output .= '<li><a class="sicon flickr" href="' . esc_url( $flickr ) . '"></a></li>'; endif;
			if ( $youtube != '' ) : $output .= '<li><a class="sicon youtube" href="' . esc_url( $youtube ) . '"></a></li>'; endif;
			if ( $vimeo != '' ) : $output .= '<li><a class="sicon vimeo" href="' . esc_url( $vimeo ) . '"></a></li>'; endif;
			if ( $twitch != '' ) : $output .= '<li><a class="sicon twitch" href="' . esc_url( $twitch ) . '"></a></li>'; endif;
			if ( $android != '' ) : $output .= '<li><a class="sicon android" href="' . esc_url( $android ) . '"></a></li>'; endif;
			if ( $skype != '' ) : $output .= '<li><a class="sicon skype" href="' . esc_url( $skype ) . '"></a></li>'; endif;
			if ( $whatsapp != '' ) : $output .= '<li><a class="sicon whatsapp" href="' . esc_url( $whatsapp ) . '"></a></li>'; endif;
			if ( $dribbble != '' ) : $output .= '<li><a class="sicon dribbble" href="' . esc_url( $dribbble ) . '"></a></li>'; endif;
			if ( $weibo != '' ) : $output .= '<li><a class="sicon weibo" href="' . esc_url( $weibo ) . '"></a></li>'; endif;
			if ( $patreon != '' ) : $output .= '<li><a class="sicon patreon" href="' . esc_url( $patreon ) . '"></a></li>'; endif;
			if ( $paypal != '' ) : $output .= '<li><a class="sicon paypal" href="' . esc_url( $paypal ) . '"></a></li>'; endif;
			if ( $foursquare != '' ) : $output .= '<li><a class="sicon foursquare" href="' . esc_url( $foursquare ) . '"></a></li>'; endif;
			if ( $linkedin != '' ) : $output .= '<li><a class="sicon linkedin" href="' . esc_url( $linkedin ) . '"></a></li>'; endif;
			if ( $xing != '' ) : $output .= '<li><a class="sicon xing" href="' . esc_url( $xing ) . '"></a></li>'; endif;
			if ( $github != '' ) : $output .= '<li><a class="sicon github" href="' . esc_url( $github ) . '"></a></li>'; endif;
			if ( $stackex != '' ) : $output .= '<li><a class="sicon stackexchange" href="' . esc_url( $stackex ) . '"></a></li>'; endif;

		} else {
			if ( $email != '' ) { $output .= '<li><a href="mailto:' . sanitize_email( $email ). '"><span class="far fa-envelope"></span></a></li>'; }
			if ( $website != '' ) { $output .= '<li><a href="' . esc_url( $website ) . '"><span class="fas fa-desktop"></span></a></li>' ; }

			if( $facebook != '' ) { $output .= '<li><a href="' . esc_attr( $facebook ) . '"><span class="fab fa-facebook-square"></span></a></li>'; } 
			if( $twitter != '' ) { $output .= '<li><a href="' . esc_attr( $twitter ) . '"><span class="fab fa-twitter"></span></a></li>'; } 
			if( $google != '' ) { $output .= '<li><a href="' . esc_attr( $google ) . '"><span class="fab fa-google-plus-g"></span></a></li>'; } 
			if( $instagram != '' ) { $output .= '<li><a href="' . esc_attr( $instagram ) . '"><span class="fab fa-instagram"></span></a></li>'; } 
			if( $snapchat != '' ) { $output .= '<li><a href="' . esc_attr( $snapchat ) . '"><span class="fab fa-snapchat"></span></a></li>'; } 
			if( $tiktok != '' ) { $output .= '<li><a href="' . esc_attr( $tiktok ) . '"><span class="fab fa-tiktok"></span></a></li>'; } 
			if( $periscope != '' ) { $output .= '<li><a href="' . esc_attr( $periscope ) . '"><span class="fab fa-periscope"></span></a></li>'; }
			if( $telegram != '' ) { $output .= '<li><a href="' . esc_attr( $telegram ) . '"><span class="fab fa-telegram-plane"></span></a></li>'; } 
			if( $itunes != '' ) { $output .= '<li><a href="' . esc_attr( $itunes ) . '"><span class="fab fa-apple"></span></a></li>'; } 
			if( $soundcloud != '' ) { $output .= '<li><a href="' . esc_attr( $soundcloud ) . '"><span class="fab fa-soundcloud"></span></a></li>'; } 
			if( $mixcloud != '' ) { $output .= '<li><a href="' . esc_attr( $mixcloud ) . '"><span class="fab fa-mixcloud"></span></a></li>'; } 
			if( $spotify != '' ) { $output .= '<li><a href="' . esc_attr( $spotify ) . '"><span class="fab fa-spotify"></span></a></li>'; } 
			if( $apple_podcasts != '' ) { $output .= '<li><a href="' . esc_url( $apple_podcasts ) . '">' . social_media_icon_a_p() . '</a></li>'; }
			if( $stitcher != '' ) { $output .= '<li><a href="' . esc_url( $stitcher ) . '">' . social_media_icon_s() . '</a></li>'; }
			if( $iheartradio != '' ) { $output .= '<li><a href="' . esc_url( $iheartradio ) . '">' . social_media_icon_ihr() . '</a></li>'; }
			if( $google_podcasts != '' ) { $output .= '<li><a href="' . esc_url( $google_podcasts ) . '">' . social_media_icon_g_p() . '</a></li>'; }
			if( $pinterest != '' ) { $output .= '<li><a href="' . esc_attr( $pinterest ) . '"><span class="fab fa-pinterest"></span></a></li>'; } 
			if( $tumblr != '' ) { $output .= '<li><a href="' . esc_attr( $tumblr ) . '"><span class="fab fa-tumblr"></span></a></li>'; } 
			if( $medium != '' ) { $output .= '<li><a href="' . esc_attr( $medium ) . '"><span class="fab fa-medium"></span></a></li>'; } 
			if( $flickr != '' ) { $output .= '<li><a href="' . esc_attr( $flickr ) . '"><span class="fab fa-flickr"></span></a></li>'; } 
			if( $youtube != '' ) { $output .= '<li><a href="' . esc_attr( $youtube ) . '"><span class="fab fa-youtube"></span></a></li>'; } 
			if( $vimeo != '' ) { $output .= '<li><a href="' . esc_attr( $vimeo ) . '"><span class="fab fa-vimeo"></span></a></li>'; } 
			if( $twitch != '' ) { $output .= '<li><a href="' . esc_attr( $twitch ) . '"><span class="fab fa-twitch"></span></a></li>'; } 
			if( $android != '' ) { $output .= '<li><a href="' . esc_attr( $android ) . '"><span class="fab fa-android"></span></a></li>'; } 
			if( $skype != '' ) { $output .= '<li><a href="' . esc_attr( $skype ) . '"><span class="fab fa-skype"></span></a></li>'; } 
			if( $whatsapp != '' ) { $output .= '<li><a href="' . esc_attr( $whatsapp ) . '"><span class="fab fa-whatsapp"></span></a></li>'; } 
			if( $dribbble != '' ) { $output .= '<li><a href="' . esc_attr( $dribbble ) . '"><span class="fab fa-dribbble"></span></a></li>'; } 
			if( $weibo != '' ) { $output .= '<li><a href="' . esc_attr( $weibo ) . '"><span class="fab fa-weibo"></span></a></li>'; }
			if( $patreon != '' ) { $output .= '<li><a href="' . esc_attr( $patreon ) . '"><span class="fab fa-patreon"></span></a></li>'; } 
			if( $paypal != '' ) { $output .= '<li><a href="' . esc_attr( $paypal ) . '"><span class="fab fa-paypal"></span></a></li>'; } 
			if( $foursquare != '' ) { $output .= '<li><a href="' . esc_attr( $foursquare ) . '"><span class="fab fa-foursquare"></span></a></li>'; } 
			if( $linkedin != '' ) { $output .= '<li><a href="' . esc_attr( $linkedin ) . '"><span class="fab fa-linkedin"></span></a></li>'; } 
			if( $xing != '' ) { $output .= '<li><a href="' . esc_attr( $xing ) . '"><span class="fab fa-xing"></span></a></li>'; } 
			if( $github != '' ) { $output .= '<li><a href="' . esc_attr( $github ) . '"><span class="fab fa-github"></span></a></li>'; } 
			if( $stackex != '' ) { $output .= '<li><a href="' . esc_attr( $stackex ) . '"><span class="fab fa-stack-exchange"></span></a></li>'; } 

			
		}


		return $output;




	}
}

/**
 * pod_social_media()
 * Display the social media links added in the theme options.
 *
 * @return string $output - box.
 * @since Podcaster 1.8.5
 */
if( ! function_exists( 'pod_social_media' ) ) {
	function pod_social_media( $location='' ) {

		$pod_display_icons = pod_theme_option( 'pod-social-nav', true );

		$pod_email = pod_theme_option( 'pod-email' );
		$pod_facebook = pod_theme_option( 'pod-facebook' );
		$pod_twitter = pod_theme_option( 'pod-twitter' );
		$pod_google = pod_theme_option( 'pod-google' );
		$pod_instagram = pod_theme_option( 'pod-instagram' );
		$pod_tiktok = pod_theme_option( 'pod-tiktok' );
		$pod_soundcloud = pod_theme_option( 'pod-soundcloud' );
		$pod_apple_podcasts = pod_theme_option( 'pod-apple-podcasts' );
		$pod_stitcher = pod_theme_option( 'pod-stitcher' );
		$pod_iheart_radio = pod_theme_option( 'pod-iheart-radio' );
		$pod_google_podcasts = pod_theme_option( 'pod-google-podcasts' );
		$pod_pocket_casts = pod_theme_option( 'pod-pocket-casts' );
		$pod_telegram = pod_theme_option( 'pod-telegram' );
		$pod_tumblr = pod_theme_option( 'pod-tumblr' );
		$pod_pinterest = pod_theme_option( 'pod-pinterest' );
		$pod_flickr = pod_theme_option( 'pod-flickr' );
		$pod_youtube = pod_theme_option( 'pod-youtube' );
		$pod_vimeo = pod_theme_option( 'pod-vimeo' );
		$pod_skype = pod_theme_option( 'pod-skype' );
		$pod_dribbble = pod_theme_option( 'pod-dribbble' );
		$pod_weibo = pod_theme_option( 'pod-weibo' );
		$pod_foursquare = pod_theme_option( 'pod-foursquare' );
		$pod_github = pod_theme_option( 'pod-github' );
		$pod_xing = pod_theme_option( 'pod-xing' );
		$pod_linkedin = pod_theme_option( 'pod-linkedin' );
		$pod_snapchat = pod_theme_option( 'pod-snapchat' );
		$pod_twitch = pod_theme_option( 'pod-twitch' );
		$pod_mixcloud = pod_theme_option( 'pod-mixcloud' );
		$pod_spotify = pod_theme_option( 'pod-spotify' );
		$pod_itunes = pod_theme_option( 'pod-itunes' );
		$pod_rss = pod_theme_option( 'pod-rss' );
		$pod_android = pod_theme_option( 'pod-android' );
		$pod_medium = pod_theme_option( 'pod-medium' );
		$pod_periscope = pod_theme_option( 'pod-periscope' );
		$pod_patreon = pod_theme_option( 'pod-patreon' );
		$pod_paypal = pod_theme_option( 'pod-paypal' );
		$pod_whatsapp = pod_theme_option( 'pod-whatsapp' );


		$output = '';
		$icons = '';

		$output .= '<div class="' . $location . '-inner social_container">';

			if( $pod_email !="" ) { $icons .= '<a class="email social_icon" href="mailto:' . sanitize_email( $pod_email ) . '"></a> '; }
			if( $pod_rss !="" ) { $icons .= '<a class="rss social_icon" href="' . esc_url( $pod_rss ) . '" target="_blank"></a> '; }
			if( $pod_facebook !="" ) { $icons .= '<a class="facebook social_icon" href="' . esc_url( $pod_facebook ) . '" target="_blank"></a> ';}
			if( $pod_twitter !="" ) { $icons .= '<a class="twitter social_icon" href="' . esc_url( $pod_twitter ) . '" target="_blank"></a> '; }
			if( $pod_google !="" ) { $icons .= '<a class="google social_icon" href="' . esc_url( $pod_google ) . '" target="_blank"></a> '; }
			if( $pod_instagram !="" ) { $icons .= '<a class="instagram social_icon" href="' . esc_url( $pod_instagram ) . '" target="_blank"></a> '; }
			if( $pod_tiktok !="" ) { $icons .= '<a class="tiktok social_icon" href="' . esc_url( $pod_tiktok ) . '" target="_blank"></a> '; }
			if( $pod_snapchat !="" ) { $icons .= '<a class="snapchat social_icon" href="' . esc_url( $pod_snapchat ) . '" target="_blank"></a> '; }
			if( $pod_telegram !="" ) { $icons .= '<a class="telegram social_icon" href="' . esc_url( $pod_telegram ) . '" target="_blank"></a> '; }
			if( $pod_periscope !="" ) { $icons .= '<a class="periscope social_icon" href="' . esc_url( $pod_periscope ) . '" target="_blank"></a> '; }

			if( $pod_itunes !="" ) { $icons .= '<a class="itunes social_icon" href="' . esc_url( $pod_itunes ) . '" target="_blank"></a> ';}
			if( $pod_soundcloud !="" ) { $icons .= '<a class="soundcloud social_icon" href="' . esc_url( $pod_soundcloud ) . '" target="_blank"></a> ';}
			if( $pod_spotify !="" ) { $icons .= '<a class="spotify social_icon" href="' . esc_url( $pod_spotify ) . '" target="_blank"></a> ';}

			if( $pod_apple_podcasts != "" ) { $icons .= '<a class="svg_icon_cont apple-podcasts" href="' . esc_url( $pod_apple_podcasts ) . '" target="_blank">' . social_media_icon_a_p() . '</a> '; }
			if( $pod_stitcher != "" ) { $icons .= '<a class="svg_icon_cont stitcher" href="' . esc_url( $pod_stitcher ) . '" target="_blank">' . social_media_icon_s() . '</a> '; }
			if( $pod_iheart_radio != "" ) { $icons .= '<a class="svg_icon_cont iheartradio" href="' . esc_url( $pod_iheart_radio ) . '" target="_blank">' . social_media_icon_ihr() . '</a> '; }
			if( $pod_google_podcasts != "" ) { $icons .= '<a class="svg_icon_cont google-podcasts" href="' . esc_url( $pod_google_podcasts ) . '" target="_blank">' . social_media_icon_g_p() . '</a> '; }

			if( $pod_pocket_casts != "" ) { $icons .= '<a class="svg_icon_cont pocket-casts" href="' . esc_url( $pod_pocket_casts ) . '" target="_blank">' . social_media_icon_p_c() . '</a> '; }
			if( $pod_mixcloud !="" ) { $icons .= '<a class="mixcloud social_icon" href="' . esc_url( $pod_mixcloud ) . '" target="_blank"></a> '; }
			

			if( $pod_tumblr !="" ) { $icons .= '<a class="tumblr social_icon" href="' . esc_url( $pod_tumblr ) . '" target="_blank"></a> ';}
			if( $pod_medium !="" ) { $icons .= '<a class="medium social_icon" href="' . esc_url( $pod_medium ) . '" target="_blank"></a> '; }
			if( $pod_pinterest !="" ) { $icons .= '<a class="pinterest social_icon" href="' . esc_url( $pod_pinterest ) . '" target="_blank"></a> ';}
			if( $pod_flickr !="" ) { $icons .= '<a class="flickr social_icon" href="' . esc_url( $pod_flickr ) . '" target="_blank"></a> ';}
			if( $pod_youtube !="" ) { $icons .= '<a class="youtube social_icon" href="' . esc_url( $pod_youtube ) . '" target="_blank"></a> ';}
			if( $pod_vimeo !="" ) { $icons .= '<a class="vimeo social_icon" href="' . esc_url( $pod_vimeo ) . '" target="_blank"></a> ';}
			if( $pod_twitch !="" ) { $icons .= '<a class="twitch social_icon" href="' . esc_url( $pod_twitch ) . '" target="_blank"></a> ';}
			if( $pod_android !="" ) { $icons .= '<a class="android social_icon" href="' . esc_url( $pod_android ) . '" target="_blank"></a> '; }
			if( $pod_skype !="" ) { $icons .= '<a class="skype social_icon" href="' . esc_url( $pod_skype ) . '" target="_blank"></a> ';}
			if( $pod_whatsapp !="" ) { $icons .= '<a class="whatsapp social_icon" href="' . esc_url( $pod_whatsapp ) . '" target="_blank"></a> '; }
			if( $pod_dribbble !="" ) { $icons .= '<a class="dribbble social_icon" href="' . esc_url( $pod_dribbble ) . '" target="_blank"></a> ';}
			if( $pod_weibo !="" ) { $icons .= '<a class="weibo social_icon" href="' . esc_url( $pod_weibo ) . '" target="_blank"></a> ';}
			if( $pod_patreon !="" ) { $icons .= '<a class="patreon social_icon" href="' . esc_url( $pod_patreon ) . '" target="_blank"></a> '; }
			if( $pod_paypal !="" ) { $icons .= '<a class="paypal social_icon" href="' . esc_url( $pod_paypal ) . '" target="_blank"></a> '; }
			if( $pod_foursquare !="" ) { $icons .= '<a class="foursquare social_icon" href="' . esc_url( $pod_foursquare ) . '" target="_blank"></a> ';}
			if( $pod_github !="" ) { $icons .= '<a class="github social_icon" href="' . esc_url( $pod_github ) . '" target="_blank"></a> ';}
			if( $pod_xing !="" ) { $icons .= '<a class="xing social_icon" href="' . esc_url( $pod_xing ) . '" target="_blank"></a> ';}
			if( $pod_linkedin !="" ) { $icons .= '<a class="linkedin social_icon" href="' . esc_url( $pod_linkedin ) . '" target="_blank"></a> ';}
			
			if( $icons == '' ) {
				return;
			}

			$output .= $icons;

		$output .= '</div>';

		return $output;

	}
}

if( ! function_exists( 'pod_subscribe_dropdown' ) ) {
function pod_subscribe_dropdown(){ ?>

	<?php if ( has_nav_menu( 'subscribe-dropdown' ) ) { ?>	
		<div class="subscribe-dropdown">
			<a href="#" class="butn small subscribe-button-opener"><i class="fas fa-microphone icon"></i> Subscribe</a>	
					
				<?php wp_nav_menu( array( 'theme_location' => 'subscribe-dropdown', 'container_id' => '', 'sort_column' => 'menu_order', 'menu_class' => 'subscribe-dropdown-menu', 'fallback_cb' => false, 'container' => false, 'depth' => 1 )); ?>	
			
		</div>					
	<?php } ?>

<?php }

}