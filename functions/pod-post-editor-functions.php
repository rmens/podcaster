<?php

/**
 * Register custom fonts.
 * Based on the function from Twenty Seventeen.
 */
if( ! function_exists( 'pod_fonts_url' ) ){
	function pod_fonts_url() {
		$fonts_url = '';
		/*
		 * Translators: If there are characters in your language that are not
		 * supported by Raleway, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$raleway = esc_html_x( 'on', 'Raleway font: on or off', 'podcaster' );
		/*
		 * Translators: If there are characters in your language that are not
		 * supported by Lora, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$lora = esc_html_x( 'on', 'Lora font: on or off', 'podcaster' );


		if ( 'off' !== $raleway && 'off' !== $lora ) {

			$font_families = array();
			if ( 'off' !== $raleway ) {
				$font_families[] = 'Raleway:400,400i,600,600i,700,700i';
			}
			if ( 'off' !== $lora ) {
				$font_families[] = 'Lora:400,400i,700,700i';
			}

			$query_args = array(
				'family' => rawurlencode( implode( '|', $font_families ) ),
				'subset' => rawurlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

		}
		return esc_url_raw( $fonts_url );
	}
}

if( ! function_exists( 'pod_custom_fonts_url' ) ){
	function pod_custom_fonts_url() {
		$fonts_url = '';
		$font_families = array();

		$pod_typo_active = pod_theme_option( 'pod-typography', 'sans-serif' );

		if( $pod_typo_active == "custom" ) {

			// Google | Single
			$pod_google_single_heading = pod_theme_option('pod-typo-single-heading', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '42px',
			'font-weight'	 => '600',
			'line-height'    => '46px']);
			$pod_google_single_text = pod_theme_option('pod-typo-single-text', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '400',
			'line-height'    => '32px']);
			$pod_google_single_heading_ff = isset( $pod_google_single_heading["font-family"] ) ? $pod_google_single_heading["font-family"] : '';
			$pod_google_single_heading_fw = isset( $pod_google_single_heading["font-weight"] ) ? $pod_google_single_heading["font-weight"] : '';
			$pod_google_single_text_ff = isset( $pod_google_single_text["font-family"] ) ? $pod_google_single_text["font-family"] : '';
			$pod_google_single_text_fw = isset( $pod_google_single_text["font-weight"] ) ? $pod_google_single_text["font-weight"] : '';
			$font_families[] = $pod_google_single_heading_ff . ":" . $pod_google_single_heading_fw . "," . $pod_google_single_heading_fw . "i";
			$font_families[] = $pod_google_single_text_ff . ":" . $pod_google_single_text_fw . "," . $pod_google_single_text_fw . "i";

			// Google | Page
			$pod_google_page_heading = pod_theme_option('pod-typo-page-heading', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '42px',
			'font-weight'	 => '600',
			'line-height'    => '46px']);
			$pod_google_page_text = pod_theme_option('pod-typo-page-text',[
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '400',
			'line-height'    => '32px']);
			$pod_google_page_heading_ff = isset( $pod_google_page_heading["font-family"] ) ? $pod_google_page_heading["font-family"] : '';
			$pod_google_page_heading_fw = isset( $pod_google_page_heading["font-weight"] ) ? $pod_google_page_heading["font-weight"] : '';
			$pod_google_page_text_ff = isset( $pod_google_page_text["font-family"] ) ? $pod_google_page_text["font-family"] : '';
			$pod_google_page_text_fw = isset( $pod_google_page_text["font-weight"] ) ? $pod_google_page_text["font-weight"] : '';
			$font_families[] = $pod_google_page_heading_ff . ":" . $pod_google_page_heading_fw . "," . $pod_google_page_heading_fw . "i";
			$font_families[] = $pod_google_page_text_ff . ":" . $pod_google_page_text_fw . "," . $pod_google_page_text_fw . "i";


				$query_args = array(
					'family' => rawurlencode( implode( '|', $font_families ) ),
					'subset' => rawurlencode( 'latin,latin-ext' ),
				);

				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

				return esc_url_raw( $fonts_url );

		}
	}
}

if( ! function_exists( 'pod_gutenberg_setup' ) ){
	function pod_gutenberg_setup() {

		$wp_version = get_bloginfo( 'version' );

		// Add support for wide and full width alignment
		add_theme_support( 'align-wide' );
		add_theme_support( 'align-full' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
		
		// Enqueue editor styles.
		add_editor_style( pod_fonts_url() );
		add_editor_style( pod_custom_fonts_url() );
	    
	    // Monospace font
	    $mono_font_url = str_replace( ',', '%2C', 'https://fonts.googleapis.com/css?family=B612+Mono' );
	    add_editor_style( $mono_font_url );

	    // Icons
	    //add_editor_style( 'css/font-awesome-5.9.0.all.min.css' );
		
	    // Gutenberg editor stylesheet
	    if( $wp_version >= 5.6 ) {
			add_editor_style( 'css/editor-5.6.css' );
		} else {
			add_editor_style( 'css/editor.css' );
		}

		// Check for Typography settings
		$pod_font_setting = pod_theme_option( 'pod-typography', 'sans-serif' );

		if( $pod_font_setting == "serif" ) {
			add_editor_style( 'css/editor-serif.css' );
		} elseif( $pod_font_setting == "sans-serif" ) {
			add_editor_style( 'css/editor-sans.css' );
		}  elseif( $pod_font_setting == "custom" ) {
			if( class_exists("Kirki") && ! class_exists("ReduxFramework")) {
				// Custom Adobe Fonts from theme options
				$pod_adobe_url = pod_theme_option( 'pod-typography-adobe-css' );
				if( $pod_adobe_url ) {
					add_editor_style( $pod_adobe_url );
				}
			}
		}

	}
}
add_action( 'after_setup_theme', 'pod_gutenberg_setup' );


if ( ! function_exists( 'pod_preload_webfonts' ) ) {
	/**
	 * Preloads the icon web font to improve performance.
	 *
	 *
	 * @since Podcaster 2.6
	 *
	 * @return void
	 */
	function pod_preload_webfonts() {
		?>
		<link rel="preload" href="<?php echo esc_url( get_theme_file_uri( 'css/font-awesome-5.9.0.all.min.css' ) ); ?>" as="font" type="text/css" crossorigin>
		<?php
	}
}
add_action( 'admin_head', 'pod_preload_webfonts' );


if( ! function_exists('pod_googlefonts_admin_css') ) {
	function pod_googlefonts_admin_css() {
		
		$pod_font_setting = pod_theme_option( 'pod-typography', 'sans-serif' );
		if( $pod_font_setting != "custom" ) {
			return;
		}

		$css = '';
		$screen_type = get_current_screen()->post_type;


		// Google | Single
		$pod_google_single_heading = pod_theme_option('pod-typo-single-heading', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '42px',
			'font-weight'	 => '600',
			'line-height'    => '46px']);
		$pod_google_single_text = pod_theme_option('pod-typo-single-text', [
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '18px',
			'font-weight'	 => '400',
			'line-height'    => '32px']);

		$font_family_h = ( ! empty( $pod_google_single_heading["font-family"] ) ) ? $pod_google_single_heading["font-family"] : '';
		$font_family_h_w = ( ! empty( $pod_google_single_heading["font-weight"] ) ) ? $pod_google_single_heading["font-weight"] : '';
		$font_family_h_s = ( ! empty( $pod_google_single_heading["font-style"] ) ) ? $pod_google_single_heading["font-style"] : '';

		$font_family_t = ( ! empty( $pod_google_single_text["font-family"] ) ) ? $pod_google_single_text["font-family"] : '';
		$font_family_t_w = ( ! empty( $pod_google_single_text["font-weight"] ) ) ? $pod_google_single_text["font-weight"] : '';
		$font_family_t_s = ( ! empty( $pod_google_single_text["font-style"] ) ) ? $pod_google_single_text["font-style"] : 'normal';
		$font_family_t_lh = ( ! empty( $pod_google_single_text["line-height"] ) ) ? $pod_google_single_text["line-height"] : '';
		$font_family_t_lh_vw = pod_calc_responsive_font_size($font_family_t_lh, 24, 20);

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

		$font_family_p_h = ( ! empty( $pod_google_page_heading["font-family"] ) ) ? $pod_google_page_heading["font-family"] : '';
		$font_family_p_h_w = ( ! empty( $pod_google_page_heading["font-weight"] ) ) ? $pod_google_page_heading["font-weight"] : '';
		$font_family_p_h_s = ( ! empty( $pod_google_page_heading["font-style"] ) ) ? $pod_google_page_heading["font-style"] : 'normal';

		$font_family_p_t = ( ! empty( $pod_google_page_text["font-family"] ) ) ? $pod_google_page_text["font-family"] : '';

		$font_family_p_t_si = ( ! empty( $pod_google_page_text["font-size"] ) ) ? $pod_google_page_text["font-size"] : '';
		$font_family_p_t_si_vw = pod_calc_responsive_font_size($font_family_p_t_si, 18, 16);

		$font_family_p_t_w = ( ! empty( $pod_google_page_text["font-weight"] ) ) ? $pod_google_page_text["font-weight"] : '';
		$font_family_p_t_s = ( ! empty( $pod_google_page_text["font-style"] ) ) ? $pod_google_page_text["font-style"] : 'normal';
		$font_family_p_t_lh = ( ! empty( $pod_google_page_text["line-height"] ) ) ? $pod_google_page_text["line-height"] : '';
		$font_family_p_t_lh_vw = pod_calc_responsive_font_size($font_family_p_t_lh, 24, 20);


		if( $screen_type == "post" || $screen_type == "podcast" ) {
			$css = '.post-type-post .editor-styles-wrapper,
			.post-type-podcast .editor-styles-wrapper {
						font-family: "' . $font_family_t . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_t_w. ';
						font-style: ' . $font_family_t_s. ';
						line-height: ' . $font_family_t_lh . ';
						line-height: calc( 20px + ' . $font_family_t_lh_vw . 'vw );
					}
					.post-type-post .editor-styles-wrapper h1, 
					.post-type-post .editor-styles-wrapper h2, 
					.post-type-post .editor-styles-wrapper h3, 
					.post-type-post .editor-styles-wrapper h4, 
					.post-type-post .editor-styles-wrapper h5, 
					.post-type-post .editor-styles-wrapper h6,
					.post-type-podcast .editor-styles-wrapper h1, 
					.post-type-podcast .editor-styles-wrapper h2, 
					.post-type-podcast .editor-styles-wrapper h3, 
					.post-type-podcast .editor-styles-wrapper h4, 
					.post-type-podcast .editor-styles-wrapper h5, 
					.post-type-podcast .editor-styles-wrapper h6 {
						font-family: "' . $font_family_h . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_h_w. ';
						font-style: ' . $font_family_h_s. ';
					}
					.post-type-post .editor-post-title__block .editor-post-title__input,
					.post-type-podcast .editor-post-title__block .editor-post-title__input {
						font-family: "' . $font_family_h . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_h_w. ';
						font-style: ' . $font_family_h_s. ';
					}
					.post-type-post .block-editor-default-block-appender textarea.block-editor-default-block-appender__content,
					.post-type-podcast .block-editor-default-block-appender textarea.block-editor-default-block-appender__content {
						font-family: "' . $font_family_t . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_t_w. ';
						font-style: ' . $font_family_t_s. ';
					}';
		} elseif( $screen_type == "page" ) {
			$css = '.post-type-page .editor-styles-wrapper,
			.post-type-page .editor-styles-wrapper p,
			.post-type-page .editor-styles-wrapper .wp-block-verse pre, 
			.post-type-page .editor-styles-wrapper pre.wp-block-verse {
						font-family: "' . $font_family_p_t . '", "Arial", sans-serif !important;
						font-size: ' . $font_family_p_t_si . ';
						font-size: calc( 16px + ' . $font_family_p_t_si_vw . 'vw );
						font-weight: ' . $font_family_p_t_w. ';
						font-style: ' . $font_family_p_t_s. ';
						line-height: ' . $font_family_p_t_lh . ';
						line-height: calc( 20px + ' . $font_family_p_t_lh_vw . 'vw );
					}
					.post-type-page .editor-styles-wrapper h1, 
					.post-type-page .editor-styles-wrapper h2, 
					.post-type-page .editor-styles-wrapper h3, 
					.post-type-page .editor-styles-wrapper h4, 
					.post-type-page .editor-styles-wrapper h5, 
					.post-type-page .editor-styles-wrapper h6 {
						font-family: "' . $font_family_p_h . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_p_h_w. ';
						font-style: ' . $font_family_p_h_s. ';
					}
					.post-type-page .editor-post-title__block .editor-post-title__input {
						font-family: "' . $font_family_p_h . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_p_h_w. ';
						font-style: ' . $font_family_p_h_s. ';
					}
					.post-type-page .block-editor-default-block-appender textarea.block-editor-default-block-appender__content {
						font-family: "' . $font_family_p_t . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_p_t_w. ';
						font-style: ' . $font_family_p_t_s. ';
					}';
		}

		$css = trim(preg_replace('!\s+!', ' ', $css));
		wp_add_inline_style('wp-admin', $css);
	}
}
add_action('admin_enqueue_scripts', 'pod_googlefonts_admin_css');


if( ! function_exists('pod_typekitfonts_admin_css') ) {
	function pod_typekitfonts_admin_css() {
		
		$pod_font_setting = pod_theme_option('pod-typography');
		if( $pod_font_setting != "custom-typekit" ) {
			return;
		}

		$css = '';
		$screen_type = get_current_screen()->post_type;


		$pod_typekit_code = pod_theme_option('pod-typekit-code');
		echo wp_kses( $pod_typekit_code, array( "link" => array( "rel" => array(), "href" => array(), "type" => array() ), "script" => array( "src" => array() ) ) );

		


		// Typekit | Single
		$pod_ado_single_heading = pod_theme_option('pod-typo-single-heading-typek');
		$pod_ado_single_text = pod_theme_option('pod-typo-single-text-typek');

		$font_family_h = ( ! empty($pod_ado_single_heading ["font-family"] ) ) ? $pod_ado_single_heading ["font-family"] : '';
		$font_family_h_w = ( ! empty( $pod_ado_single_heading ["font-weight"] ) ) ? $pod_ado_single_heading ["font-weight"] : '';
		$font_family_h_s = ( ! empty( $pod_ado_single_heading ["font-style"] ) ) ? $pod_ado_single_heading ["font-style"] : '';
		$font_family_h_lh = ( ! empty( $pod_ado_single_heading ["line-height"] ) ) ? $pod_ado_single_heading ["line-height"] : '';

		$font_family_t = ( ! empty( $pod_ado_single_text["font-family"] ) ) ? $pod_ado_single_text["font-family"] : '';
		$font_family_t_w = ( ! empty( $pod_ado_single_text["font-weight"] ) ) ? $pod_ado_single_text["font-weight"] : '';
		$font_family_t_s = ( ! empty( $pod_ado_single_text["font-style"] ) ) ? $pod_ado_single_text["font-style"] : '';

		// Typekit | Page
		$pod_ado_page_heading = pod_theme_option('pod-typo-page-heading-typek');
		$pod_ado_page_text = pod_theme_option('pod-typo-page-text-typek');

		$font_family_p_h = ( ! empty( $pod_ado_page_heading["font-family"] ) ) ? $pod_ado_page_heading["font-family"] : '';
		$font_family_p_h_w = ( ! empty( $pod_ado_page_heading["font-weight"] ) ) ? $pod_ado_page_heading["font-weight"] : '';
		$font_family_p_h_s = ( ! empty( $pod_ado_page_heading["font-style"] ) ) ? $pod_ado_page_heading["font-style"] : '';

		$font_family_p_t = ( ! empty( $pod_ado_page_text["font-family"] ) ) ? $pod_ado_page_text["font-family"] : '';
		$font_family_p_t_w = ( ! empty( $pod_ado_page_text["font-weight"] ) ) ? $pod_ado_page_text["font-weight"] : '';
		$font_family_p_t_s = ( ! empty( $pod_ado_page_text["font-style"] ) ) ? $pod_ado_page_text["font-style"] : '';

		// Typekit | Button 
		$pod_ado_button = pod_theme_option('pod-typo-buttons-typek');

		
		$font_family_butn = ( ! empty( $pod_ado_button["font-family"] ) ) ? $pod_ado_button["font-family"] : '';
		$font_family_butn_w = ( ! empty( $pod_ado_button["font-weight"] ) ) ? $pod_ado_button["font-weight"] : '';
		$font_family_butn_s = ( ! empty( $pod_ado_button["font-style"] ) ) ? $pod_ado_button["font-style"] : '';


		if( $screen_type == "post" || $screen_type == "podcast" ) {
			$css = '.post-type-post .editor-styles-wrapper,
			.post-type-podcast .editor-styles-wrapper {
						font-family: "' . $font_family_t . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_t_w. ';
						font-style: ' . $font_family_t_s. ';
					}
					.post-type-post .editor-styles-wrapper h1, 
					.post-type-post .editor-styles-wrapper h2, 
					.post-type-post .editor-styles-wrapper h3, 
					.post-type-post .editor-styles-wrapper h4, 
					.post-type-post .editor-styles-wrapper h5, 
					.post-type-post .editor-styles-wrapper h6,
					.post-type-podcast .editor-styles-wrapper h1, 
					.post-type-podcast .editor-styles-wrapper h2, 
					.post-type-podcast .editor-styles-wrapper h3, 
					.post-type-podcast .editor-styles-wrapper h4, 
					.post-type-podcast .editor-styles-wrapper h5, 
					.post-type-podcast .editor-styles-wrapper h6 {
						font-family: "' . $font_family_h . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_h_w. ';
						font-style: ' . $font_family_h_s. ';
						line-height: ' . $font_family_h_lh . ';
					}
					.post-type-post .editor-post-title__block .editor-post-title__input,
					.post-type-podcast .editor-post-title__block .editor-post-title__input {
						font-family: "' . $font_family_h . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_h_w. ';
						font-style: ' . $font_family_h_s. ';
					}
					.post-type-post .block-editor-default-block-appender textarea.block-editor-default-block-appender__content,
					.post-type-podcast .block-editor-default-block-appender textarea.block-editor-default-block-appender__content {
						font-family: "' . $font_family_t . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_t_w. ';
						font-style: ' . $font_family_t_s. ';
					}
					.wp-block-button__link {
						font-family: "' . $font_family_butn . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_butn_w. ';
						font-style: ' . $font_family_butn_s. ';	
					}';
		} elseif( $screen_type == "page" ) {
			$css = '.post-type-page .editor-styles-wrapper {
						font-family: "' . $font_family_p_t . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_p_t_w. ';
						font-style: ' . $font_family_p_t_s. ';
					}
					.post-type-page .editor-styles-wrapper h1, 
					.post-type-page .editor-styles-wrapper h2, 
					.post-type-page .editor-styles-wrapper h3, 
					.post-type-page .editor-styles-wrapper h4, 
					.post-type-page .editor-styles-wrapper h5, 
					.post-type-page .editor-styles-wrapper h6 {
						font-family: "' . $font_family_p_h . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_p_h_w. ';
						font-style: ' . $font_family_p_h_s. ';
					}
					.post-type-page .editor-post-title__block .editor-post-title__input {
						font-family: "' . $font_family_p_h . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_p_h_w. ';
						font-style: ' . $font_family_p_h_s. ';
					}
					.post-type-page .block-editor-default-block-appender textarea.block-editor-default-block-appender__content {
						font-family: "' . $font_family_p_t . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_p_t_w. ';
						font-style: ' . $font_family_p_t_s. ';
					}
					.wp-block-button__link,
					.wp-block-file .wp-block-file__button-richtext-wrapper .wp-block-file__button {
						font-family: "' . $font_family_butn . '", "Arial", sans-serif !important;
						font-weight: ' . $font_family_butn_w. ';
						font-style: ' . $font_family_butn_s. ';	
					}';
		}

		$css = trim(preg_replace('!\s+!', ' ', $css));
		wp_add_inline_style('wp-admin', $css);
	}
}
add_action('admin_enqueue_scripts', 'pod_typekitfonts_admin_css');


if( ! function_exists('pod_colors_editor_css') ) {
	function pod_colors_editor_css() {

		$css = '';
		$screen_type = get_current_screen()->post_type;
		$pod_post_link_color = '';
		$pod_post_link_hover_color = '';
		
		$pod_post_link_color = pod_theme_option( "pod-color-primary", "#1e7ce8" );
		$pod_post_link_hover_color = $pod_post_link_color;
 
		$pod_allow_advanced_colors = pod_theme_option( "pod-advanced-color-settings", false );
		if( $pod_allow_advanced_colors ) {
			$pod_post_link_color = pod_theme_option( "pod-color-link", "#1e7ce8" );
			$pod_post_link_hover_color = pod_theme_option( "pod-color-link-hover", "#1e7ce8" );
		}

		$pod_allow_advanced_colors_singular = pod_theme_option( "pod-advanced-color-single-settings", false );
		if( $pod_allow_advanced_colors_singular ) {
			$pod_post_link_color = pod_theme_option( "pod-color-single-link", '#1e7ce8' );
			$pod_post_link_hover_color = pod_theme_option( "pod-color-single-link-hover", '#1e7ce8' );
		}


		if( $screen_type == "post" || $screen_type == "page" || $screen_type == "podcast"  ) {
			$css = '.editor-styles-wrapper .wp-block a:link, .editor-styles-wrapper .wp-block a:visited {
						color: ' . $pod_post_link_color . ';
					}
					.editor-styles-wrapper .wp-block a:hover {
						color: ' . $pod_post_link_hover_color . ';				
					}';
					
		}

		$css = trim(preg_replace('!\s+!', ' ', $css));
		wp_add_inline_style('wp-admin', $css);
	}
}
add_action('admin_enqueue_scripts', 'pod_colors_editor_css', 175);


/**
 * Theme Setup 
 *
 */

if( ! function_exists( 'pod_gb_color_palette' ) ){
	function pod_gb_color_palette() {

		// Editor Color Palette
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => __( 'Azure Blue', 'podcaster' ),
				'slug'  => 'azure-blue',
				'color'	=> '#252ee5',
			),
			array(
				'name'  => __( 'Slate Grey', 'podcaster' ),
				'slug'  => 'slate-grey',
				'color' => '#555555',
			),
			array(
				'name'	=> __( 'Dolphin Grey', 'podcaster' ),
				'slug'	=> 'dolphin-grey',
				'color'	=> '#aaaaaa',
			),
			array(
				'name'  => __( 'Silver Grey', 'podcaster' ),
				'slug'  => 'sliver-grey',
				'color' => '#dddddd',
			),
			array(
				'name'  => __( 'White', 'podcaster' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
		) );
	}
}
add_action( 'after_setup_theme', 'pod_gb_color_palette' );
