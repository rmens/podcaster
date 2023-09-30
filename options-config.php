<?php
    /**
     * ReduxFramework Config File (Podcaster)
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "podcaster-theme";

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    $theme_options_img = get_template_directory_uri() . '/includes/options/img/';
    $theme_img = get_template_directory_uri() . '/img/';
    $theme_dir = get_template_directory_uri();

    /* Patterns */
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /* Background Patterns Reader */
	$theme_options_img = get_template_directory_uri(). '/options/img/';



    function pod_add_panel_css() {
        wp_register_style(
            'pod-redux-custom-css',
            get_template_directory_uri(). '/css/redux-panel.css',
            array( 'redux-admin-css' ), // Be sure to include redux-admin-css so it's appended after the core css is applied
            time(),
            'all'
        );  
        wp_enqueue_style('pod-redux-custom-css');
    }
    // This example assumes your opt_name is set to OPT_NAME, replace with your opt_name value
    add_action( 'redux/page/' . $opt_name . '/enqueue', 'pod_add_panel_css' );

	function podNewIconFont() {

	    wp_register_style(
	        'redux-font-awesome',
	        get_template_directory_uri(). '/css/font-awesome-5.9.0.all.min.css',
	        array(),
	        time(),
	        'all'
	    );
	    wp_enqueue_style( 'redux-font-awesome' );
	}
	// This example assumes the opt_name is set to redux_demo.  Please replace it with your opt_name value.
	add_action( 'redux/page/podcaster-theme/enqueue', 'podNewIconFont' );


    /*
     *
     * --> Action hook examples
     *
     */

    // If Redux is running as a plugin, this will remove the demo notice and links
    add_action( 'redux/loaded', 'pod_remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'pod_compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'pod_change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'pod_change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'pod_dynamic_section');


    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.
    $googleapi = '';

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        //'menu_type'            => 'menu',
        'menu_type'            => 'submenu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'podcaster' ),
        'page_title'           => __( 'Podcaster Theme Options', 'podcaster' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => $googleapi,
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => 10,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        //'page_parent'          => 'themes.php',
        'page_parent'          => 'pod-theme-options',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        //'menu_icon'            => '',
        // Set a custom menu icon.
        'menu_icon' => $theme_options_img. 'icon.png',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '_options',
        // Page slug used to denote the panel
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        'footer_credit'     => ' ',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'system_info'          => false,
        // REMOVE

        //'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
    }

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'podcaster' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'podcaster' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'podcaster' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'podcaster' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'podcaster' );
    Redux::setHelpSidebar( $opt_name, $content );

    $plugin_inuse = pod_get_plugin_active();
    $ssp_active = pod_is_ssp_active();



    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields
    Redux::setSection( $opt_name, array(
        'icon'          => 'fas fa-sliders-h',
        'icon_class'    => 'icon-large',
        'title'         => __('General', 'podcaster'),
        'desc'          => __('<p class="description">Select general for the website.</p>', 'podcaster'),
        'id'            => 'pod-subsection-general-subsection',
        'fields' => array(
            array(
                'id'=>'pod-general-tempalte-width',
                'type' => 'radio',
                'title' => __('Template Width', 'podcaster'),
                'subtitle' => __('Select between fixed and full.', 'podcaster'),
                'options' => array(
                    'template-width-fixed' => 'Fixed width', 
                    'template-width-full' => 'Full width',
                ),
                'default' => 'template-width-fixed'
            ),
        )
    ) );
    /*Redux::setSection( $opt_name, array(
        'title' => __('General', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize website template colors. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-colors"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'=>'pod-color-darklight',
                'type' => 'image_select',
                'title' => __('Template Color', 'podcaster'),
                'subtitle' => __('Choose between classic and dark.', 'podcaster'),
                'options' => array(
                    'classic' => array('title' => 'Classic', 'img' => $theme_options_img. 'color-options-classic.png'),
                    'dark' => array('title' => 'Dark', 'img' => $theme_options_img. 'color-options-dark.png')
                ),
                'default' => 'classic'
            ),
        )
    ) );*/



    Redux::setSection( $opt_name, array(
        'icon'          => 'fas fa-palette',
        'icon_class'    => 'icon-large',
        'title'         => __('Colors', 'podcaster'),
        'desc'          => __('<p class="description">Select colors for your website.</p>', 'podcaster'),
        'id'            => 'pod-subsection-colors-subsection',
    ) );
	Redux::setSection( $opt_name, array(
        'title' => __('General', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize website template colors. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-colors"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
        	array(
				'id'=>'pod-color-darklight',
				'type' => 'image_select',
				'title' => __('Template Color', 'podcaster'),
				'subtitle' => __('Choose between classic and dark.', 'podcaster'),
				'options' => array(
                    'classic' => array('title' => 'Classic', 'img' => $theme_options_img. 'color-options-classic.png'),
                    'dark' => array('title' => 'Dark', 'img' => $theme_options_img. 'color-options-dark.png')
				),
				'default' => 'classic'
			),
            array(
                'id' => 'pod-color-primary',
                'type' => 'color',
                'title' => __('Accent', 'podcaster'),
                'subtitle' => __('Select a highlight color.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color'  => 'a:link, a:visited, .header a, .header .main-title a, .latest-episode .main-featured-post .mini-title, .front-page-header .text .mini-title, .latest-episode .next-week .mini-title, .next-week .mini-title, .list-of-episodes article.list .post-header ul a:link, .list-of-episodes article.list .post-header ul a:visited, .latest-episode .main-featured-post .featured-excerpt .more-link, .list-of-episodes article .featured-image .hover .icon, .mejs-container.mejs-video .mejs-controls:hover .mejs-time-rail .mejs-time-float, .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float .mejs-time-float-current, .list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button button, .post .wp-playlist.wp-audio-playlist .mejs-container .mejs-controls .mejs-time-rail .mejs-time-float, .single .single-featured .audio_player .mejs-controls .mejs-button button:hover, .single .single-featured .mejs-container.mejs-audio .mejs-controls .mejs-button button:hover, .single .sticky-featured-audio-container .audio_player .mejs-controls .mejs-button button:hover, .single .sticky-featured-audio-container .mejs-container.mejs-audio .mejs-controls .mejs-button button:hover, .post.format-gallery .featured-gallery .gallery-caption, .post.format-audio .featured-media .audio-caption, .post.format-video .video-caption, .list-of-episodes article .featured-image .hover .new-icon a .fa:hover, .post.format-image .entry-featured .image-caption, .page-template-pagepage-podcastarchive-php .entries.grid .podpost .entry-footer .podpost-meta .title a, .post-type-archive-podcast .entries.grid .podpost .entry-footer .podpost-meta .title a, .single .single-featured span.mini-title, #searchform .search-container:hover #searchsubmit, .search-container input[type="submit"]#searchsubmit, #searchform-nav .search-container:hover #searchsubmit-nav, .search-container input[type="submit"]#searchsubmit-nav, .sidebar .widget ul li a:link, .sidebar .widget ul li a:visited, .widget.thst_recent_blog_widget .ui-tabs-panel article .text .date, .widget.widget_search .search-container #searchsubmit,  .lb-data .lb-close:before, .list-of-episodes article .post-header ul a:link, .list-of-episodes article .post-header ul a:visited, .pod-2-podcast-archive-grid .podpost .cover-art .hover-content .pp-permalink-icon .fa:hover, .pod-2-podcast-archive-grid .podpost .cover-art .hover-content .pp-permalink-icon .fas:hover, .pagination a.page-numbers:link, .pagination a.page-numbers:visited, .pagination a.post-page-numbers:link, .pagination a.post-page-numbers:visited',
                    'background-color' => 'input[type=submit]:link, input[type=submit]:visited, #respond #commentform #submit:link, #respond #commentform #submit:visited, a.butn:link, a.butn:visited, .error404 .entry-content a.butn:link, .error404 .entry-content a.butn:visited, .butn:link, .butn:visited, .wp-block-file__button, input.secondary[type=submit], #respond #cancel-comment-reply-link:link, #respond #cancel-comment-reply-link:visited, #comments .commentlist li .comment-body .reply a:link, #comments .commentlist li .comment-body .reply a:visited, #respond #commentform #submit, .wpcf7-form-control.wpcf7-submit, .post-password-form input[type="submit"], .featured-caption, .listen_butn, .slideshow_fh .text .play-button:hover, #nav .thst-menu li:hover > .sub-menu, #nav .thst-menu li > .sub-menu li a:link, #nav .thst-menu li > .sub-menu li a:visited, .audio_player.regular-player, body .mejs-container .mejs-controls, .mejs-container .mejs-controls .mejs-time-rail .mejs-time-float, .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .mejs-overlay-button:hover, .mejs-video .mejs-controls:hover, .mejs-container.mejs-video .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container.mejs-video.wp-video-shortcode .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-handle, .mejs-container.mejs-video .mejs-controls .pod-mejs-controls-inner .mejs-volume-handle, .latest-episode.front-header .mejs-video .mejs-controls:hover, .list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-handle-content, .list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float, .list-of-episodes article .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .list-of-episodes article .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .list-of-episodes article .mejs-container.mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .list-of-episodes article .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-volume-button .mejs-volume-handle, .post .entry-content .mejs-container.wp-audio-shortcode.mejs-audio, .wp-playlist.wp-audio-playlist, .wp-playlist.wp-video-playlist, .wp-playlist .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, .single-featured .wp-audio-shortcode.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .single-featured .wp-audio-shortcode.mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .single-featured  .wp-audio-shortcode.mejs-container.mejs-audio .mejs-controls .mejs-time-rail span.mejs-time-handle-content, .sticky-featured-audio-container .wp-audio-shortcode.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .sticky-featured-audio-container .wp-audio-shortcode.mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .sticky-featured-audio-container  .wp-audio-shortcode.mejs-container.mejs-audio .mejs-controls .mejs-time-rail span.mejs-time-handle-content, .single .single-featured-video-container .mejs-video .mejs-controls .pod-mejs-controls-inner .mejs-volume-button .mejs-volume-slider .mejs-volume-handle, .single .single-featured-video-container .mejs-container.mejs-video.wp-video-shortcode .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-handle, .pagi-stamp .pagination.loader-button a:link, .pagi-stamp .pagination.loader-button a:visited, .post .entry-header .permalink-icon, .post .post-header .permalink-icon, .post .entry-content .permalink-icon, .post.sticky_post .entry-header .permalink-icon, .post.sticky_post .post-header .permalink-icon, .post.sticky_post .entry-content .permalink-icon, .post .post-header .post-cat li a, .post .entry-header .entry-date .sticky_label, .podcast .post-header .post-cat li a, .gallery.grid .gallery-item .flex-caption,  .post .entry-content .gallery.flexslider .flex-direction-nav .flex-next:hover, .post .entry-content .gallery.flexslider .flex-direction-nav .flex-prev:hover, .post .entry-content .gallery.flexslider li.gallery-item .flex-caption, .post.format-gallery .entry-content .gallery.grid .gallery-item .flex-caption, .post.format-gallery .featured-gallery .gallery.flexslider .flex-direction-nav .flex-prev:hover, .post.format-gallery .featured-gallery .gallery.flexslider .flex-direction-nav .flex-next:hover, .post.format-gallery .featured-gallery .gallery.flexslider li.gallery-item .flex-caption, .single-podcast.podcast-archive .main-content .container .entries .podcast-content .podcast_meta a:link, .single-podcast.podcast-archive .main-content .container .entries .podcast-content .podcast_meta a:visited, .single .featured-gallery .gallery.flexslider .flex-direction-nav .flex-prev:hover, .single .featured-gallery .gallery.flexslider .flex-direction-nav .flex-next:hover, .single .featured-gallery .gallery.flexslider li.gallery-item .flex-caption, .flex-direction-nav a, .widget.thst_recent_blog_widget .ui-tabs-nav li, .thst_highlight_category_widget ul li:first-child .text, .reg, .page .reg, .podcast-archive .reg, .search .reg, .archive .reg, .blog .static, .fromtheblog.list article .post-content .cats a:link, .fromtheblog.list article .post-content .cats a:visited, .front-page-grid #loading_bg .circle-spinner .line::before, .players-style-2 .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button, .players-style-2.single .single-featured.format-audio .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button:hover',
                    'background' => '.mejs-container .mejs-controls, .single .single-featured .mejs-audio .mejs-controls .mejs-time-rail span.mejs-time-handle-content, .single .single-featured .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button .mejs-volume-handle, .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button .mejs-volume-handle',
                    'border-color' => '.slideshow_fh .text .play-button:hover, .thst_highlight_category_widget ul li:first-child .text, .fromtheblog.list article .post-header .user_img_link, .front-page-grid #loading_bg .circle-spinner',
                    'border-bottom-color' => '.thst_highlight_category_widget ul li:first-child .text.arrow::after',
                    'border-top-color' => '.list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float-corner'
                ),
            ),
            array(
                'id' => 'pod-advanced-color-settings',
                'type' => 'switch',
                'title' => __('Advanced colors', 'podcaster'),
                'subtitle' => __('Activate advanced color settings.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-color-headings',
                'type' => 'color',
                'required' => array('pod-advanced-color-settings', '=', true),
                'title' => __('Titles', 'podcaster'),
                'subtitle' => __('Select a color for titles.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.list-of-episodes article .post-header h2 a:link, .list-of-episodes article .post-header h2 a:visited, .single .author-description span, .pod-2-podcast-archive-list .podpost .right .post-excerpt .title a, .pod-2-podcast-archive-grid .podpost .post-footer .title a, .post .entry-header .entry-title a:link, .post .entry-header .entry-title a:visited'
                )
            ),
            array(
                'id' => 'pod-color-text',
                'type' => 'color',
                'required' => array('pod-advanced-color-settings', '=', true),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a title for text.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => 'body, .sidebar h3, .archive .sidebar h3, .arch_searchform #ind_searchform div #ind_searchsubmit .fa-search::before, .single .comment-respond h3, .single #comments h3, .dark-template-active .hosts-container .hosts-description h2, .fromtheblog.list h2.title, .fromtheblog.list article .post-header span a:link, .fromtheblog.list article .post-header span a:visited, .fromtheblog.list article .post-content .title a:link, .fromtheblog.list article .post-content .title a:visited, .wp-block-image figcaption, .wp-block-gallery figcaption, .wp-block-audio figcaption, .wp-block-video figcaption, .post.format-status .entry-content, .wp-block-rss__item-publish-date, .wp-block-rss__item-author, .wp-block-latest-comments__comment-date'
                )
            ),
            array(
                'id' => 'pod-color-link',
                'type' => 'color',
                'required' => array('pod-advanced-color-settings', '=', true),
                'title' => __('Links', 'podcaster'),
                'subtitle' => __('Select a color for links.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => 'a:link, a:visited, .sidebar .widget ul li a:link, .sidebar .widget ul li a:visited, .pod-2-podcast-archive-grid .podpost .post-footer .categories a, .pod-2-podcast-archive-list .podpost .right .post-excerpt .categories a'
                )
            ),
            array(
                'id' => 'pod-color-link-hover',
                'type' => 'color',
                'required' => array('pod-advanced-color-settings', '=', true),
                'title' => __('Links (Hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for links.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => 'a:hover, .sidebar .widget ul li a:hover'
                )
            ),
            array(
                'id' => 'pod-color-advanced-border',
                'type' => 'color',
                'required' => array('pod-advanced-color-settings', '=', true),
                'title' => __('Borders', 'podcaster'),
                'subtitle' => __('Select a color for borders.', 'podcaster'),
                'default' => '#dddddd',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'border-color' => '.post .entry-meta, .arch_searchform, .wp-block-table table, table.wp-block-table, .wp-block-table td, .wp-block-table th, .single.single-format-gallery .caption-container, .post.format-chat .entry-content ul li, input[type="text"], input[type="email"], input[type="password"], .single .single-featured.format-audio .caption-container, .wp-block-separator, textarea, .single .post .entry-meta, .single .entry-meta .author-info, .wp-block-latest-posts li, .wp-block-rss li, .single .template-gutenberg .entry-meta .author-info',
                    'color' => '.wp-block-separator.is-style-dots::before'
                )
            ),
            array(
                'id' => 'pod-color-text-icons-status',
                'type' => 'color',
                'required' => array('pod-advanced-color-settings', '=', true),
                'title' => __('Icons & Lables', 'podcaster'),
                'subtitle' => __('Select a color for icons and labels.', 'podcaster'),
                'default' => '#aaaaaa',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.singlep_pagi p, .single-post #mediainfo .download li::before, .post.format-chat .entry-content ul li strong, .post.format-status .status_icon::before, .wp-block-file a:not(.wp-block-file__button)::before'
                )
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Buttons', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the colors of the buttons. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-colors-buttons"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'id'         => 'pod-subsection-color-buttons',
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'pod-color-buttons-bg',
                'type' => 'color',
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array('background-color' => 'input[type="submit"]:link, input[type="submit"]:visited, #respond #commentform #submit:link, #respond #commentform #submit:visited, a.butn:link, a.butn:visited, .error404 .entry-content a.butn:link, .error404 .entry-content a.butn:visited, .butn:link, .butn:visited, .wp-block-file__button, .page .entry-content .wp-block-file__button, .page .entry-content .wp-block-file__button:link, .page .entry-content .wp-block-file__button:visited, .single .entry-content .wp-block-file__button, .single .entry-content .wp-block-file__button:link, .single .entry-content .wp-block-file__button:visited, .page:not(.has-front-page-template) .entry-content .wp-block-file__button:link, .page:not(.has-front-page-template) .entry-content .wp-block-file__button:visited, input.secondary[type="submit"], #respond #cancel-comment-reply-link:link, #respond #cancel-comment-reply-link:visited, #comments .commentlist li .comment-body .reply a:link, #comments .commentlist li .comment-body .reply a:visited, #respond #commentform #submit, .wpcf7-form-control.wpcf7-submit, .fromtheblog.list article .post-content .cats a:link, .fromtheblog.list article .post-content .cats a:visited, .front-page-indigo .pagi-stamp .pagination.loader-button a:link, .front-page-indigo .pagi-stamp .pagination.loader-button a:visited, .widget.widget_mc4wp_form_widget form.mc4wp-form input[type="submit"], .widget.widget_search .search-container #searchsubmit')
            ),
            array(
                'id' => 'pod-color-buttons-link',
                'type' => 'color',
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array('color' => 'input[type="submit"]:link, input[type="submit"]:visited, #respond #commentform #submit:link, #respond #commentform #submit:visited, a.butn:link, a.butn:visited, .error404 .entry-content a.butn:link, .error404 .entry-content a.butn:visited, .butn:link, .butn:visited, .wp-block-file__button, .page .entry-content .wp-block-file__button, .page .entry-content .wp-block-file__button:link, .page .entry-content .wp-block-file__button:visited, .single .entry-content .wp-block-file__button, .single .entry-content .wp-block-file__button:link, .single .entry-content .wp-block-file__button:visited, .single .entry-content .wp-block-file__button:hover, .page:not(.has-front-page-template) .entry-content .wp-block-file__button:link, .page:not(.has-front-page-template) .entry-content .wp-block-file__button:visited, input.secondary[type="submit"], #respond #cancel-comment-reply-link:link, #respond #cancel-comment-reply-link:visited, #comments .commentlist li .comment-body .reply a:link, #comments .commentlist li .comment-body .reply a:visited, #respond #commentform #submit, .wpcf7-form-control.wpcf7-submit, .fromtheblog.list article .post-content .cats a:link, .fromtheblog.list article .post-content .cats a:visited, .front-page-indigo .pagi-stamp .pagination.loader-button a:link, .front-page-indigo .pagi-stamp .pagination.loader-button a:visited, .widget.widget_mc4wp_form_widget form.mc4wp-form input[type="submit"], .template-podcast-archive-legacy .entries-container.list .podpost .entry-footer .podpost-meta .listen .butn, .widget.widget_search .search-container #searchsubmit, .widget.widget_search #searchform .search-container:hover #searchsubmit')
            ),
            array(
                'id' => 'pod-color-buttons-bg-hover',
                'type' => 'color',
                'title' => __('Background (hover)', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array('background-color' => 'input[type="submit"]:hover, input.secondary[type="submit"]:hover, a.butn:hover, .butn:hover, .error404 .entry-content a.butn:hover, .wp-block-file__button:hover, .page .entry-content .wp-block-file__button:hover, .single .entry-content .wp-block-file__button:hover, .page:not(.has-front-page-template) .entry-content .wp-block-file__button:hover, #respond #cancel-comment-reply-link:hover, #respond #commentform #submit:hover, #comments .commentlist li .comment-body .reply a:hover, .fromtheblog.list article .post-content .cats a:hover, .front-page-indigo .pagi-stamp .pagination.loader-button a:hover, .wpcf7-form-control.wpcf7-submit:hover, .widget.widget_mc4wp_form_widget form.mc4wp-form input[type="submit"]:hover, .widget.widget_search .search-container #searchsubmit:hover')
            ),
            array(
                'id' => 'pod-color-buttons-link-hover',
                'type' => 'color',
                'title' => __('Text (hover)', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array('color' => 'input[type="submit"]:link, input.secondary[type="submit"]:hover, a.butn:hover, .butn:hover, .error404 .entry-content a.butn:hover, .wp-block-file__button, .page .entry-content .wp-block-file__button:hover, .single .entry-content .wp-block-file__button:hover, .page:not(.has-front-page-template) .entry-content .wp-block-file__button:hover, #respond #commentform #submit:hover, #respond #cancel-comment-reply-link:hover, #comments .commentlist li .comment-body .reply a:hover, .wpcf7-form-control.wpcf7-submit:hover, .fromtheblog.list article .post-content .cats a:hover, .front-page-indigo .pagi-stamp .pagination.loader-button a:hover, .widget.widget_mc4wp_form_widget form.mc4wp-form input[type="submit"]:hover, .widget.widget_search .search-container #searchsubmit:hover, .widget.widget_search #searchform .search-container:hover #searchsubmit:hover, .template-podcast-archive-legacy .entries-container.list .podpost .entry-footer .podpost-meta .listen .butn:hover')
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Headers', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the colors for the headers. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-colors-headers"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'id'         => 'pod-subsection-color-headers',
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-color-page-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Page Headers</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for page headers.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-page-header-bg',
                'type'     => 'color',
                'title'    => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color for the headers.', 'podcaster'),
                'default' => '#24292c',
                'transparent' => false,
                'output' => array(
                    'background' => '.latest-episode, .reg, .page .reg, .podcast-archive .reg, .search .reg, .archive .reg, .blog .static'
                )
            ),
            array(
                'id'       => 'pod-page-header-title',
                'type'     => 'color',
                'title'    => __('Title', 'podcaster'),
                'subtitle' => __('Select a color for the titles.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array('color' => '.reg .heading h1, .reg .heading h2')
            ),
            array(
                'id'       => 'pod-page-header-text',
                'type'     => 'color',
                'title'    => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array(
                    'color' => '.reg .heading p, .reg .author_position, .archive .author_profile .social li .sicon:before',
                    'fill' => '.archive .author_profile .social li .sicon .svg_icon svg')
            ),
            array(
                'id'       => 'pod-color-filter-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Header Filters</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for header filters.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-filter-active',
                'type' => 'switch',
                'title' => __('Activate Filter', 'podcaster'),
                'subtitle' => __('Activate the transparent filter.', 'podcaster'),
                'default' => true
            ),
            array(
                'id'        => 'pod-transparent-screen',
                'type'      => 'color_rgba',
                'required'  => array( 'pod-filter-active', '=', true ),
                'title'     => 'Filter',
                'subtitle'  => 'Select a color and transparency for the filter.',
                'transparent' => false,
                'default'   => array(
                    'color'     => '#000000',
                    'alpha'     => 0.5
                ),
            ),
            array(
                'id'       => 'pod-page-header-filter-title',
                'type'     => 'color',
                'title'    => __('Title', 'podcaster'),
                'subtitle' => __('Select a color for the titles.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array('color' => '.page .reg.has-featured-image .heading .title, .single .single-featured.has-featured-image h1, .single .single-featured.has-featured-image h2, .reg.has-featured-image .heading h1, .reg.has-featured-image .heading h2',
                    'border-color' => '.reg .circle-spinner',
                    'background' => '.reg .circle-spinner .line::before' )
            ),
            array(
                'id'       => 'pod-page-header-filter-text',
                'type'     => 'color',
                'title'    => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array('color' => '.reg .content_page_thumb .heading .title p, .archive .reg.has-featured-image .heading .title p, .page:not(.pod-is-podcast-archive) .reg.has-featured-image .heading .title p, .blog .main-content.has-featured-image .static .heading .title p')
            ),
        )
    ) );
	Redux::setSection( $opt_name, array(
        'icon'			=> 'far fa-image',
        'icon_class'	=> 'icon-large',
        'title'			=> __('Front Page Header', 'podcaster'),
        'desc'			=> __('<p class="description">Use the settings below to customize your front page header. </p>', 'podcaster'),
        'id'			=> 'pod-subsection-fheader-section',
    ) );
	Redux::setSection( $opt_name, array(
        'title' => __('General', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize your front page header. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'id'         => 'pod-subsection-fheader-general',
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'pod-featured-header-type',
                'type' => 'button_set',
                'title' => __('Header Type', 'podcaster'),
                'subtitle' => __('Choose between a text, static header or slideshow.', 'podcaster'),
                'options' => array(
                    'text' => 'Text',
                    'static' => 'Static',
                    'static-posts' => 'Static (Posts)',
                    'slideshow' => 'Slideshow',
                    'video-bg' => 'Video background',
                    'hide' => 'Hide',
                    ),
                'default' => 'static'
            ),
            array(
                'id' => 'pod-featured-heading',
                'type' => 'text',
                'required' => array( 'pod-featured-header-type', '=', array( 'static', 'static-posts', 'slideshow' )),
                'title' => __('Header Title', 'podcaster'),
                'subtitle' => __('Enter the title of the featured post section.', 'podcaster'),
                'placeholder' => 'Featured Episode',
                'default' => 'Featured Episode',
            ),
            array(
                'id' => 'pod-featured-header-text',
                'type' => 'text',
                'required' => array('pod-featured-header-type', '=', array('text', 'video-bg') ),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Enter the text for the header.', 'podcaster'),
                'placeholder' => 'Type your text here.',
                'default' => 'Welcome to Podcaster. Handcrafted WordPress themes for your podcasting project.',
            ),
            array(
                'id' => 'pod-featured-header-blurb',
                'type' => 'text',
                'required' => array('pod-featured-header-type', '=', array('text', 'video-bg')),
                'title' => __('Blurb', 'podcaster'),
                'subtitle' => __('Enter a blurb for the header.', 'podcaster'),
                'default' => 'This is a little blurb you can add to your text.',
            ),
            array(
                'id' => 'pod-featured-header-text-url',
                'type' => 'text',
                'required' => array('pod-featured-header-type', '=', array('text', 'video-bg')),
                'title' => __('Link', 'podcaster'),
                'subtitle' => __('Enter a valid URL for the header.', 'podcaster'),
                'placeholder' => 'http://www.example.com',
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-featured-header-content',
                'type' => 'button_set',
                'required' => array( 'pod-featured-header-type', '=', array( 'static-posts', 'slideshow' ) ),
                'title' => __('Header Content', 'podcaster'),
                'subtitle' => __('Choose between a featured posts or newest posts.', 'podcaster'),
                'options' => array(
                    'newest' => 'Newest',
                    'featured' => 'Featured',
                    ),
                'default' => 'newest'
            ),
            array(
                'id'       => 'pod-featured-header-alignment-raw-title',
                'type'     => 'raw',
                'required' => array( 'pod-featured-header-type', '=', array( 'text', 'static', 'video-bg' ) ),
                'title'  => __( '<h3>Alignment & Padding</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the alignment and padding of the header.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-audio-player-aligment',
                'type' => 'radio',
                'required' => array( 
                    'pod-featured-header-type', '=', array( 'text', 'static', 'video-bg' ),
                ),
                'title' => __('Aligment', 'podcaster'),
                'subtitle' => __('Set the alignment, choose between left (default), center and right.', 'podcaster'),
                'options' => array(
                    'fh-audio-player-left' => 'Left',
                    'fh-audio-player-center' => 'Center',
                    'fh-audio-player-right' => 'Right'
                ),
                'default' => 'fh-audio-player-left'
            ),
            array(
                'id'             => 'pod-fh-padding',
                'type'           => 'spacing',
                'required' => array( 'pod-featured-header-type', '=', array( 'text' )),
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'top'           => true,
                'bottom'           => true,
                'left'           => false,
                'right'           => false,
                'title'          => __('Header Padding', 'podcaster'),
                'subtitle'       => __('Do you want to set your padding?', 'podcaster'),
                'desc'           => __('Add padding to the top or bottom of your header.', 'podcaster'),
                'default'            => array(
                    'padding-top'     => '75px',
                    'padding-bottom'  => '75px',
                    'units'          => 'px',
                ),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Colors', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize colors for the front page header. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-colors"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-colors',
        'subsection' => true,
        'fields'     => array(

            array(
                'id' => 'pod-fh-bg-mode',
                'type' => 'button_set',
                'title' => __('Background style', 'podcaster'),
                'subtitle' => __('Select a background style.', 'podcaster'),
                'options' => array(
                    'background-solid' => 'Background',
                    'background-gradient' => 'Gradient',
                ),
                'default' => 'background-solid',
            ),
            array(
                'id' => 'pod-fh-bg-grad-mode',
                'type' => 'button_set',
                'title' => __('Gradient style', 'podcaster'),
                'required' => array('pod-fh-bg-mode', '=', 'background-gradient'),
                'subtitle' => __('Select a gradient style.', 'podcaster'),
                'options' => array(
                    'background-grad-linear' => 'Linear',
                    'background-grad-radial' => 'Radial',
                ),
                'default' => 'background-grad-linear',
            ),
            array(
                'id'       => 'pod-fh-bg-grad-angle',
                'type'     => 'spinner', 
                'title'    => __('Gradient angle', 'podcaster'),
                'required' => array(
                    array('pod-fh-bg-mode', '=', 'background-gradient'),
                    array('pod-fh-bg-grad-mode', '=', 'background-grad-linear'),
                ),
                'subtitle' => __('Select an angle for the gradient.','podcaster'),
                'default'  => '0',
                'min'      => '-360',
                'step'     => '1',
                'max'      => '360',
            ),
            array(
                'id'=>'pod-fh-grad-color-1',
                'type' => 'color',
                'title' => __('Gradient color 1', 'podcaster'),
                'required' => array('pod-fh-bg-mode', '=', 'background-gradient'),
                'subtitle' => __('Select a the first gradient color.', 'podcaster'),
                'default' => '#24292c',
                'transparent' => false,
                'output' => array(
                    'background' => '.latest-episode .translucent.solid-bg, .slideshow_fh .translucent.solid-bg, #loading_bg, .flexslider-container, .front-page-header.slideshow-empty, .nav-placeholder.no-featured-image.nav-transparent'
                )
            ),
            array(
                'id'=>'pod-fh-grad-color-2',
                'type' => 'color',
                'title' => __('Gradient color 2', 'podcaster'),
                'required' => array('pod-fh-bg-mode', '=', 'background-gradient'),
                'subtitle' => __('Select a the secondary gradient color.', 'podcaster'),
                'default' => '#24292c',
                'transparent' => false,
                'output' => array(
                    'background' => '.latest-episode .translucent.solid-bg, .slideshow_fh .translucent.solid-bg, #loading_bg, .flexslider-container, .front-page-header.slideshow-empty, .nav-placeholder.no-featured-image.nav-transparent'
                )
            ),
            array(
                 'id'=>'pod-fh-grad-color-3',
                'type' => 'color',
                'title' => __('Gradient color 3', 'podcaster'),
                'required' => array('pod-fh-bg-mode', '=', 'background-gradient'),
                'subtitle' => __('Select a the third gradient color.', 'podcaster'),
                'default' => '#24292c',
                'transparent' => false,
                'output' => array(
                    'background' => '.latest-episode .translucent.solid-bg, .slideshow_fh .translucent.solid-bg, #loading_bg, .flexslider-container, .front-page-header.slideshow-empty, .nav-placeholder.no-featured-image.nav-transparent'
                )
            ),

            array(
                'id'=>'pod-fh-bg',
                'type' => 'color',
                'title' => __('Background', 'podcaster'),
                'required' => array('pod-fh-bg-mode', '=', 'background-solid'),
                'subtitle' => __('Select a background color for the front page header.', 'podcaster'),
                'default' => '#24292c',
                'transparent' => false,
                'output' => array(
                    'background' => '.latest-episode .translucent.solid-bg, .slideshow_fh .translucent.solid-bg, #loading_bg, .flexslider-container, .front-page-header.slideshow-empty, .nav-placeholder.no-featured-image.nav-transparent'
                )
            ),
            array(
                'id' => 'pod-fh-title-color',
                'type' => 'color',
                'title' => __('Title', 'podcaster'),
                'subtitle' => __('Select a color for the title.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.latest-episode .main-featured-post a:link:not(.butn), .latest-episode .main-featured-post a:visited:not(.butn), .front-page-header .content-text a:link:not(.butn), .front-page-header .content-text a:visited:not(.butn), .front-page-header .text h1 a:link, .front-page-header .text h1 a:visited, .front-page-header .text h2 a:link, .front-page-header .text h2 a:visited, .front-page-header.text .content-text h2, .front-page-header.static .text',
                    'border-color' => '.latest-episode .circle-spinner, .front-page-header .circle-spinner',
                    'background' => '.latest-episode .circle-spinner .line:before, .front-page-header .circle-spinner .line:before' 
                )
            ),
            array(
                'id' => 'pod-fh-title-hover-color',
                'type' => 'color',
                'title' => __('Title (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the title.', 'podcaster'),
                'default' => '#eeeeee',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array( 'color' => '.latest-episode .main-featured-post a:hover:not(.butn), .front-page-header .content-text a:hover:not(.butn), .front-page-header .text h1 a:hover, .front-page-header .text h2 a:hover' )
            ),
            array(
                'id' => 'pod-fh-text-color',
                'type' => 'color',
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array( 'color' => '.latest-episode .main-featured-post .featured-excerpt, .front-page-header, .front-page-header .featured-excerpt, .next-week .schedule-message, .next-week h3, .latest-episode .main-featured-post .mini-title, .front-page-header .text .mini-title, .empty-slideshow .placeholder.inside p' )
            )
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Background image', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the front page header background. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-background"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-background',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-frontpage-header-bg-activate',
                'type' => 'switch',
                'title' => __('Background images', 'podcaster'),
                'subtitle' => __('Activate background images for your front page header.', 'podcaster'),
                'default' => false,
            ),
            array(
                'id' => 'pod-upload-frontpage-header',
                'type' => 'media',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'text', 'static' ) ),
                    array( 'pod-frontpage-header-bg-activate', '=', true )
                ),
                'title' => __('Header background', 'podcaster'),
                'subtitle' => __('Upload an image which will be displayed as your header. (At least 600 x 1920px.)', 'podcaster'),
                'default' => '',
                'url' => false
            ),
            array(
                'id' => 'pod-page-image',
                'type' => 'checkbox',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'static', 'text' )),
                    array( 'pod-frontpage-header-bg-activate', '=', true )
                ),
                'title' => __('Featured image (from page)', 'podcaster'),
                'subtitle' => __('Use the featured image from your set front page instead of uploading it above.', 'podcaster'),
                'switch' => true,
                'default' => false
            ),
            array(
                'id' => 'pod-frontpage-bg-style',
                'type' => 'radio',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'text', 'static' )),
                    array( 'pod-frontpage-header-bg-activate', '=', true )
                ),
                'title' => __('Header background style', 'podcaster'),
                'subtitle' => __('Choose between stretched and tiled.', 'podcaster'),
                'options' => array(
                    'background-repeat:repeat;' => 'Tiled',
                    'background-repeat:no-repeat; background-size:cover;' => 'Stretched',
                ),
                'default' => 'background-repeat:repeat;'
            ),
            array(
                'id' => 'pod-frontpage-header-par',
                'type' => 'switch',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'text', 'static' )),
                    array( 'pod-frontpage-header-bg-activate', '=', true )
                ),
                'title' => __('Parallax', 'podcaster'),
                'subtitle' => __('Activate parallax scrolling.', 'podcaster'),
                'default' => false,
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Video background', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the front page header background video. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-background"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-video-background',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'pod-video-bg-raw-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-featured-header-type', '!=', 'video-bg'),
                'desc'  => __( 'Please select go to <strong>Front Page Header</strong> > <strong>General</strong> > <strong>Header Type</strong> and select <strong>Video background</strong> to use these settings.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-frontpage-header-bg-video-activate',
                'type' => 'switch',
                'required' => array('pod-featured-header-type', '=', array('video-bg')),
                'title' => __('Background video', 'podcaster'),
                'subtitle' => __('Activate the background video for your front page header.', 'podcaster'),
                'default' => true,
            ),
            array(
                'id' => 'pod-upload-frontpage-header-video-file',
                'type' => 'media',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' ) ),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Header video', 'podcaster'),
                'subtitle' => __('Upload a video which will be displayed in the header. (Supported formats: *.mp4)', 'podcaster'),
                'default' => '',
                'url' => false,
                'library_filter' => array(
                    'mp4',
                    'avi',
                    'mpeg',
                )
            ),
            array(
                'id' => 'pod-frontpage-header-video-button',
                'type' => 'switch',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' )),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Play/pause button', 'podcaster'),
                'subtitle' => __('Display a play/pause button.', 'podcaster'),
                'default' => true,
            ),
            array(
                'id' => 'pod-frontpage-header-video-autoplay',
                'type' => 'switch',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' )),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Autoplay video', 'podcaster'),
                'subtitle' => __('Activate autoplay.', 'podcaster'),
                'default' => true,
            ),
            array(
                'id' => 'pod-frontpage-header-video-loop',
                'type' => 'switch',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' )),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Loop video', 'podcaster'),
                'subtitle' => __('Activate loop.', 'podcaster'),
                'default' => true,
            ),
            array(
                'id' => 'pod-frontpage-header-video-mute',
                'type' => 'switch',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' )),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Mute video', 'podcaster'),
                'subtitle' => __('Mute sound for the video.', 'podcaster'),
                'default' => false,
            ),
            array(
                'id' => 'pod-frontpage-header-video-par',
                'type' => 'switch',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' )),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Parallax', 'podcaster'),
                'subtitle' => __('Activate parallax scrolling.', 'podcaster'),
                'default' => false,
            ),
            array(
                'id' => 'pod-frontpage-header-video-button-bg',
                'type' => 'color',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' )),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Play button background', 'podcaster'),
                'subtitle' => __('Select a color background color for the button.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.pod-video-bg-controls button'
                )
            ),
            array(
                'id' => 'pod-frontpage-header-video-button-txt',
                'type' => 'color',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' )),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Play button icon', 'podcaster'),
                'subtitle' => __('Select a color background color for the button.', 'podcaster'),
                'default' => '#000000',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.pod-video-bg-controls button::before'
                )
            ),


            array(
                'id' => 'pod-frontpage-header-video-button-bg-hover',
                'type' => 'color',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' )),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Play button background (hover)', 'podcaster'),
                'subtitle' => __('Select a color background color for the button.', 'podcaster'),
                'default' => '#000000',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.pod-video-bg-controls:hover button'
                )
            ),
            array(
                'id' => 'pod-frontpage-header-video-button-txt-hover',
                'type' => 'color',
                'required' => array(
                    array( 'pod-featured-header-type', '=', array( 'video-bg' )),
                    array( 'pod-frontpage-header-bg-video-activate', '=', true )
                ),
                'title' => __('Play button icon (hover', 'podcaster'),
                'subtitle' => __('Select a color background color for the button.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.pod-video-bg-controls:hover button::before'
                )
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Custom buttons', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize custom buttons. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-custom-buttons',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-frontpage-header-custom-buttons-activate',
                'type' => 'switch',
                'title' => __('Show buttons', 'podcaster'),
                'subtitle' => __('Activate the custom buttons for the header.', 'podcaster'),
                'default' => false,
            ),
            array(
                'id'       => 'pod-featured-header-custom-button-raw-1',
                'type'     => 'raw',
                'required' => array( 'pod-frontpage-header-custom-buttons-activate', '=', true ),
                'title'  => __( '<h3>Button 1</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are to for the first button.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-featured-header-custom-button-1-text',
                'type' => 'text',
                'required' => array( 'pod-frontpage-header-custom-buttons-activate', '=', true ),
                'title' => __('Button text', 'podcaster'),
                'subtitle' => __('Enter the text for the button.', 'podcaster'),
                'default' => '',
            ),
            array(
                'id'=>'pod-featured-header-custom-button-1-type',
                'type' => 'button_set',
                'title' => __('URL type', 'podcaster'),
                'required' => array( 'pod-frontpage-header-custom-buttons-activate', '=', true ),
                'subtitle' => __('Select the type of URL.', 'podcaster'),
                'options' => array(
                    'permalink-url' => 'Permalink',
                    'custom-url' =>'Custom URL',
                ),
                'default' => 'permalink-url'
            ),
            array(
                'id' => 'pod-featured-header-custom-button-1-url',
                'type' => 'text',
                'required' => array(
                    array( 'pod-frontpage-header-custom-buttons-activate', '=', true ),
                    array( 'pod-featured-header-custom-button-1-type', '=', 'custom-url' ),
                ),
                'title' => __('Button URL', 'podcaster'),
                'subtitle' => __('Enter the URL for the button.', 'podcaster'),
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id'       => 'pod-featured-header-custom-button-raw-2',
                'type'     => 'raw',
                'required' => array( 'pod-frontpage-header-custom-buttons-activate', '=', true ),
                'title'  => __( '<h3>Button 2</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are to for the second button.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-featured-header-custom-button-2-text',
                'type' => 'text',
                'required' => array( 'pod-frontpage-header-custom-buttons-activate', '=', true ),
                'title' => __('Button text', 'podcaster'),
                'subtitle' => __('Enter the text for the button.', 'podcaster'),
                'default' => '',
            ),
            array(
                'id'=>'pod-featured-header-custom-button-2-type',
                'type' => 'button_set',
                'title' => __('URL type', 'podcaster'),
                'required' => array( 'pod-frontpage-header-custom-buttons-activate', '=', true ),
                'subtitle' => __('Select the type of URL.', 'podcaster'),
                'options' => array(
                    'permalink-url' => 'Permalink',
                    'custom-url' =>'Custom URL',
                ),
                'default' => 'custom-url'
            ),
            array(
                'id' => 'pod-featured-header-custom-button-2-url',
                'type' => 'text',
                'required' => array(
                    array( 'pod-frontpage-header-custom-buttons-activate', '=', true ),
                    array( 'pod-featured-header-custom-button-2-type', '=', 'custom-url' ),
                ),
                'title' => __('Button URL', 'podcaster'),
                'subtitle' => __('Enter the URL for the button.', 'podcaster'),
                'default' => '',
                'validate' => 'url',
            ),

        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Divider', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the divider. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-slideshow"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-separator',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-featured-header-seperator-active',
                'type' => 'switch',
                'title' => __('Activate', 'podcaster'),
                'subtitle' => __('Display a seperator for your header.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-featured-header-seperator-style',
                'type' => 'button_set',
                'required' => array( 'pod-featured-header-seperator-active', '=', true),
                'title' => __('Style', 'podcaster'),
                'subtitle' => __('Choose a style for the seperator.', 'podcaster'),
                'options' => array(
                    'sep-style-gentle-wave' => 'Gentle wave',
                    'sep-style-wave-1' => 'Waves',
                    'sep-style-wave-2' => 'Regular wave',
                    'sep-style-wave-3' => 'Scallop',
                    'sep-style-cloud' => 'Cloud',
                    'sep-style-zigzag' => 'Zigzag',

                    ),
                'default' => 'sep-style-wave-1'
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Slideshow', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the slideshow. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-slideshow"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-slideshow',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'pod-slideshow-raw-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-featured-header-type', '!=', 'slideshow'),
                'desc'  => __( 'Please select go to <strong>Front Page Header</strong> > <strong>General</strong> > <strong>Header Type</strong> and select <strong>Slideshow</strong> to use these settings.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-featured-header-slides-auto',
                'type' => 'switch',
                'required' => array( 'pod-featured-header-type', '=', 'slideshow' ),
                'title' => __('Auto Slide', 'podcaster'),
                'subtitle' => __('Activate automatic sliding.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-featured-header-slides-style',
                'type' => 'button_set',
                'required' => array( 'pod-featured-header-type', '=', 'slideshow'),
                'title' => __('Style', 'podcaster'),
                'subtitle' => __('Choose between slide and fade.', 'podcaster'),
                'options' => array(
                    'slide' => 'Slide',
                    'fade' => 'Fade',
                    ),
                'default' => 'slide'
            ),
            array(
                'id' => 'pod-featured-header-slides-arrow-color',
                'type' => 'button_set',
                'required' => array( 'pod-featured-header-type', '=', 'slideshow'),
                'title' => __('Arrow color', 'podcaster'),
                'subtitle' => __('Choose between light and dark.', 'podcaster'),
                'options' => array(
                    'light-arrows' => 'Light',
                    'dark-arrows' => 'Dark',
                    ),
                'default' => 'light-arrows'
            ),
            array(
                'id'=>'pod-featured-header-slides-amount',
                'type' => 'spinner',
                'required' => array('pod-featured-header-type', '=', 'slideshow'),
                'title' => __('Amount of slides', 'podcaster'),
                'subtitle' => __('Enter the amount of slides (posts) to be displayed.', 'podcaster'),
                "default"   => "5",
                "min"       => "1",
                "step"      => "1",
                "max"       => "999"
            ),
            array(
                'id'       => 'pod-featured-header-raw-title',
                'type'     => 'raw',
                'required' => array(
                    array( 'pod-featured-header-type', '=', 'slideshow' ),
                    array( 'pod-new-feature-soon', '=', true)
                ),
                'title'  => __( '<h3>Global slide settings</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the slideshow.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-featured-header-slides-in-post',
                'type' => 'switch',
                'required' => array( 
                    array( 'pod-featured-header-type', '=', 'slideshow' ),
                    array( 'pod-new-feature-soon', '=', true)
                ),
                'title' => __('Global slide settings', 'podcaster'),
                'subtitle' => __('Set options (excerpt length, alignment, background style and parallax settings ) in theme options instead of individual posts.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-slideshow-global-aligment',
                'type' => 'radio',
                'required' => array( 
                    array( 'pod-featured-header-type', '=', 'slideshow' ),
                    array( 'pod-featured-header-slides-in-post', '=', true ),
                ),
                'title' => __('Aligment', 'podcaster'),
                'subtitle' => __('Set the alignment, choose between left (default), center and right.', 'podcaster'),
                'options' => array(
                    'text-align:left' => 'Left',
                    'text-align:center' => 'Center',
                    'text-align:right' => 'Right'
                ),
                'default' => 'text-align:left'
            ),
            array(
                'id' => 'pod-slideshow-global-background-style',
                'type' => 'radio',
                'required' => array( 
                    array( 'pod-featured-header-type', '=', 'slideshow' ),
                    array( 'pod-featured-header-slides-in-post', '=', true ),
                ),
                'title' => __('Background Style', 'podcaster'),
                'subtitle' => __('Set the background style, choose between tiled (default), contain and streched.', 'podcaster'),
                'options' => array(
                    'background-size:auto;' => 'Tiled',
                    'background-size:contain;' => 'Contain',
                    'background-size:cover;' => 'Streched'
                ),
                'default' => 'background-size:cover;'
            ),
            array(
                'id' => 'pod-slideshow-global-excerpt',
                'type' => 'switch',
                'required' => array( 
                    array( 'pod-featured-header-type', '=', 'slideshow' ),
                    array( 'pod-featured-header-slides-in-post', '=', true ),
                ),
                'title' => __('Display excerpt', 'podcaster'),
                'subtitle' => __('Display or hide the excerpt.', 'podcaster'),
                'default' => 'true'
            ),
            array(
                'id' => 'pod-slideshow-global-excerpt-length',
                'type' => 'text',
                'required' => array( 
                    array( 'pod-featured-header-type', '=', 'slideshow' ),
                    array( 'pod-featured-header-slides-in-post', '=', true ),
                    array( 'pod-slideshow-global-excerpt', '=', true)
                ),
                'title' => __('Excerpt length', 'podcaster'),
                'subtitle' => __('Enter Enter the amount of words you want to display in your excerpt.', 'podcaster'),
                'validate' => 'no_html',
                'placeholder' =>  "",
                'default' =>  "35",
            ),
            array(
                'id' => 'pod-slideshow-global-parallax',
                'type' => 'switch',
                'required' => array( 
                    array( 'pod-featured-header-type', '=', 'slideshow' ),
                    array( 'pod-featured-header-slides-in-post', '=', true ),
                ),
                'title' => __('Parallax', 'podcaster'),
                'subtitle' => __('Turn parallax scrolling on or off.', 'podcaster'),
                'default' => 'true'
            ),

        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Title', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the title for the front page header. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-title"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-heading-section',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'=>'pod-fh-heading-width',
                'type' => 'select',
                'title' => __('Width', 'podcaster'),
                'subtitle' => __('Choose between narrow, medium, wide and full.', 'podcaster'),
                'options' => array(
                    'fh-heading-narrow' => 'Narrow',
                    'fh-heading-medium' =>'Medium',
                    'fh-heading-wide' => 'Wide',
                    'fh-heading-full' => 'Full',
                ),
                'default' => 'fh-heading-full'
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Media player', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the media player on the front page header. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-media-player"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-audio-section',
        'subsection' => true,
        'fields'     => array(
            array(
               'id' => 'pod-front-page-media-players-activate',
               'type' => 'switch',
               'title' => __('Show players', 'podcaster'),
               'subtitle' => __('Display players on the front page header.', 'podcaster'),
               'default' => true,
            ),
            array(
                'id'=>'pod-audio-player-width',
                'type' => 'select',
                'title' => __('Width', 'podcaster'),
                'required' => array('pod-front-page-media-players-activate', '=', true),
                'subtitle' => __('Choose between narrow, medium, wide and full.', 'podcaster'),
                'options' => array(
                    'fh-audio-player-narrow' => 'Narrow',
                    'fh-audio-player-medium' =>'Medium',
                    'fh-audio-player-wide' => 'Wide',
                    'fh-audio-player-full' => 'Full',
                ),
                'default' => 'fh-audio-player-full'
            ),           
            array(
                'id'       => 'pod-front-page-audio-player-colors-raw',
                'type'     => 'raw',
                'title'  => __( '<br /><h3>Media player colors</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for customizing the media player.', 'podcaster' ),
            ),
            array(
               'id' => 'pod-front-page-audio-color-activate',
               'type' => 'switch',
               'title' => __('Custom colors', 'podcaster'),
               'subtitle' => __('Activate custom colors for your front page media players.', 'podcaster'),
               'default' => false,
            ),
            array(
                'id' => 'pod-front-page-audio-transparent-active',
                'type' => 'switch',
                'required' => array('pod-front-page-audio-color-activate', '=', true),
                'title' => __('Transparent player', 'podcaster'),
                'subtitle' => __('Activate transparency for your front page audio players.', 'podcaster'),
                'default' => true
            ),
            array(
                'id'       => 'pod-front-page-audio-bg-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-front-page-audio-color-activate', '=', true),
                    array('pod-front-page-audio-transparent-active', '=', false),
                ),
                'transparent' => false,
                'title'    => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#282d31',
                'output'    => array(
                    'background-color' => '
                    .front-page-indigo .latest-episode .main-featured-post.audio.audio-url .audio_player.regular-player, 
                    .front-page-indigo .latest-episode .main-featured-post.audio.audio-url .powerpress_player, 
                    .front-page-indigo .front-page-header .audio_player.regular-player, .front-page-indigo .front-page-header .powerpress_player, 

                    .latest-episode .main-featured-post.audio.audio-url .audio_player.regular-player, 
                    .latest-episode .main-featured-post.audio.audio-url .powerpress_player, .front-page-header .audio_player.regular-player, 
                    .front-page-header .powerpress_player'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-dur-color',
                'type'     => 'color',
                'required' => array('pod-front-page-audio-color-activate', '=', true),
                'transparent' => false,
                'title'    => __('Duration text', 'podcaster'),
                'subtitle' => __('Select a color for the duration text.', 'podcaster'),
                'default' => '#ffffff',
                'output'    => array(
                    'color' => '.latest-episode .mejs-container.mejs-audio .mejs-controls .mejs-time span, .front-page-header .mejs-container.mejs-audio .mejs-controls .mejs-time span'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-icon-bg-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-front-page-audio-color-activate', '=', true),
                    array('pod-players-style', '=','players-style-2')
                ),
                'transparent' => false,
                'title'    => __('Play icon background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#282d31',
                'output'    => array(
                    'background-color' => '.players-style-2 .latest-episode .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button, .players-style-2 .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-but-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-front-page-audio-color-activate', '=', true),
                'title'    => __('Icons', 'podcaster'),
                'subtitle' => __('Select a color for the icons.', 'podcaster'),
                'default' => '#ffffff',
                'output'    => array(
                    'color' => '.latest-episode .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button button, .latest-episode .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button button, .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button button, .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button button'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-icon-bg-hover-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-front-page-audio-color-activate', '=', true),
                    array('pod-players-style', '=','players-style-2')
                ),
                'transparent' => false,
                'title'    => __('Play icon background (hover)', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#282d31',
                'output'    => array(
                    'background-color' => '.players-style-2 .latest-episode .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button:hover, .players-style-2 .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button:hover'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-but-hover-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-front-page-audio-color-activate', '=', true),
                'title'    => __('Icons (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the icons.', 'podcaster'),
                'default' => '#919495',
                'output'    => array(
                    'color' => '.latest-episode .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button button:hover, .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button button:hover'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-but-vol-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array(
                    array('pod-front-page-audio-color-activate', '=', true),
                    array('pod-players-style', '=', 'players-style-2')
                ),
                'title'    => __('Volume icon', 'podcaster'),
                'subtitle' => __('Select a color for the icons.', 'podcaster'),
                'default' => '#ffffff',
                'output'    => array(
                    'color' => '.latest-episode .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button button, .latest-episode .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button button, .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button button, .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button button'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-but-vol-hover-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array(
                    array('pod-front-page-audio-color-activate', '=', true),
                    array('pod-players-style', '=', 'players-style-2')
                ),
                'title'    => __('Volume icon (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the icons.', 'podcaster'),
                'default' => '#919495',
                'output'    => array(
                    'color' => '.latest-episode .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button button:hover, .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button button:hover'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-rail-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-front-page-audio-color-activate', '=', true),
                'title'    => __('Rail', 'podcaster'),
                'subtitle' => __('Select a color for the rail.', 'podcaster'),
                'default' => '#1d2123',
                'output'    => array(
                    'background-color' => '.latest-episode .mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-total, .latest-episode .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-total, .front-page-header .mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-total, .front-page-header .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-total'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-rail-played-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-front-page-audio-color-activate', '=', true),
                'title'    => __('Rail (played)', 'podcaster'),
                'subtitle' => __('Select a color for the rail (played).', 'podcaster'),
                'default' => '#ffffff',
                'output'    => array(
                    'background-color' => '.latest-episode .wp-audio-shortcode.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .latest-episode .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .latest-episode .wp-audio-shortcode.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .front-page-header .wp-audio-shortcode.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .front-page-header .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .front-page-header .wp-audio-shortcode.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-time-handle-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-front-page-audio-color-activate', '=', true),
                'title'    => __('Time Handle (ball)', 'podcaster'),
                'subtitle' => __('Select a color for the time handle.', 'podcaster'),
                'default' => '#ffffff',
                'output'    => array(
                    'background-color' => '.latest-episode .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-handle-content, .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-handle-content, .latest-episode .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button .mejs-volume-handle, .front-page-header .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button .mejs-volume-handle'
                )
            ),
            array(
                'id'       => 'pod-front-page-audio-time-display-bg-color',
                'type'     => 'color',
                'required' => array('pod-front-page-audio-color-activate', '=', true),
                'transparent' => false,
                'title'    => __('Time Display (background)', 'podcaster'),
                'subtitle' => __('Select a background color for the duration display.', 'podcaster'),
                'default' => '#ffffff',
                'output'    => array(
                    'background-color' => '.latest-episode .mejs-container.wp-audio-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float, .front-page-header .mejs-container.wp-audio-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float',
                    'border-top-color' => '.latest-episode .mejs-container.wp-audio-shortcode .mejs-controls .mejs-time-rail .mejs-time-float-corner, .front-page-header .mejs-container.wp-audio-shortcode .mejs-controls .mejs-time-rail .mejs-time-float-corner'
                ),
            ),
            array(
                'id'       => 'pod-front-page-audio-time-display-text-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-front-page-audio-color-activate', '=', true),
                'title'    => __('Time Display (text)', 'podcaster'),
                'subtitle' => __('Select a color for the time display.', 'podcaster'),
                'default' => '#000000',
                'output'    => array(
                    'color' => '.latest-episode .mejs-container.wp-audio-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float .mejs-time-float-current, .front-page-header .mejs-container.wp-audio-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float .mejs-time-float-current'
                )
            ),
            
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Media player with Text', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to add media players for the text front page header. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-media-player"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-text-media-section',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'pod-slideshow-raw-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-featured-header-type', '!=', 'text'),
                'desc'  => __( 'Please select go to <strong>Front Page Header</strong> > <strong>General</strong> > <strong>Header Type</strong> and select <strong>Text</strong> to use these settings.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-featured-header-text-media-activate',
                'type' => 'switch',
                'required' => array( 'pod-featured-header-type', '=', array( 'text' ) ),
                'title' => __('Activate', 'podcaster'),
                'subtitle' => __('Activate the media player for your the "Text" style front page header.', 'podcaster'),
                'default' => false,
            ),
            array(
                'id' => 'pod-featured-header-text-media-type',
                'type' => 'radio',
                'title' => __('Media type', 'podcaster'),
                'required' => array('pod-featured-header-text-media-activate', '=', true),
                'subtitle' => __('Select a media type to display.', 'podcaster'),
                'options' => array(
                    'audio-player' => 'Audio player (self-hosted)',
                    'video-player' => 'Video player (self-hosted)',
                    'oembed-player' => 'OEmbed URL (audio, video or playlist)',
                    'embed-code-player' => 'Embed code (audio, video or playlist)',                    
                    ),
                'default' => 'audio-player'
            ),
            array(
                'id' => 'pod-featured-header-text-audio-file',
                'type' => 'media',
                'required' => array(
                    array( 'pod-featured-header-text-media-type', '=', 'audio-player')
                ),
                'title' => __('Audio file', 'podcaster'),
                'subtitle' => __('Upload an audio file. (Currently supports *.mp3 and *.wav)', 'podcaster'),
                'default' => '',
                'url' => false,
                'library_filter' => array(
                    'mp3',
                    'wav',
                    'wma'
                )
            ),
            array(
                'id' => 'pod-featured-header-text-video-file',
                'type' => 'media',
                'required' => array(
                    array( 'pod-featured-header-text-media-type', '=','video-player' )
                ),
                'title' => __('Video file', 'podcaster'),
                'subtitle' => __('Upload a video file. (Currently supports *.mp4)', 'podcaster'),
                'default' => '',
                'url' => false,
                'library_filter' => array(
                    'mp4'
                )
            ),
            array(
                'id' => 'pod-featured-header-text-video-poster',
                'type' => 'media',
                'required' => array(
                    array( 'pod-featured-header-text-media-type', '=','video-player' )
                ),
                'title' => __('Video poster', 'podcaster'),
                'subtitle' => __('Upload a video poster.', 'podcaster'),
                'default' => '',
                'url' => false,
            ),
            array(
                'id' => 'pod-featured-header-text-embed-format',
                'type' => 'button_set',
                'required' => array(
                    array('pod-featured-header-text-media-type', '=', array('oembed-player', 'embed-code-player')),
                    array('pod-featured-header-text-media-activate', '=', true),
                ),
                'title' => __('Format', 'podcaster'),
                'subtitle' => __('Choose between audio for video.', 'podcaster'),
                'options' => array(
                    'audio' => 'Audio',
                    'video' => 'Video',
                    ),
            ),
            array(
                'id' => 'pod-featured-header-text-oembed',
                'type' => 'text',
                'required' => array(
                    array( 'pod-featured-header-text-embed-format', '=', array('audio', 'video') ),
                    array( 'pod-featured-header-text-media-type', '=','oembed-player' ),
                ),
                'title' => __('Embed URL', 'podcaster'),
                'subtitle' => __('Paste the code to the player.', 'podcaster'),
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-featured-header-text-embed-code',
                'type' => 'textarea',
                'required' => array(
                    array( 'pod-featured-header-text-embed-format', '=', array('audio', 'video') ),
                    array( 'pod-featured-header-text-media-type', '=','embed-code-player' ),
                ),
                'title' => __('Embed code', 'podcaster'),
                'subtitle' => __('Paste the code to the player.', 'podcaster'),
            ),
            array(
                'id' => 'pod-featured-header-text-audio-art',
                'type' => 'media',
                'required' => array(
                    array( 'pod-featured-header-text-media-type', '=', array('audio-player','oembed-player', 'embed-code-player' ) ),
                ),
                'title' => __('Audio art', 'podcaster'),
                'subtitle' => __('Upload audio art.', 'podcaster'),
                'default' => '',
                'url' => false,
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Embedded player', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize embedded players on the front page header. This includes videos, embedded videos as well as embedded audio players. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-embedded-player"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-embeds',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'=>'pod-embed-style',
                'type' => 'select',
                'title' => __('Alignment', 'podcaster'),
                'subtitle' => __('Choose between left, right and centered.', 'podcaster'),
                'options' => array(
                    'left' => 'Left',
                    'center' => 'Centered',
                    'right' => 'Right',
                ),
                'default' => 'left'
            ),
            array(
                'id'=>'pod-embed-widths',
                'type' => 'select',
                'title' => __('Width', 'podcaster'),
                'subtitle' => __('Choose between narrow, medium, wide and full.', 'podcaster'),
                'options' => array(
                    'narrow' => 'Narrow',
                    'equal' =>'Medium',
                    'wide' => 'Wide',
                    'full' => 'Full (Only Centered)',
                ),
                'default' => 'wide'
            ),

            array(
                'id'=>'pod-embed-soundcloud-player-style',
                'type' => 'radio',
                'title' => __('Soundcloud player style', 'podcaster'),
                'subtitle' => __('If Soundcloud players are active, select the type of player being used.', 'podcaster'),
                'options' => array(
                    'fph-sc-classic-player' => 'Classic player (horizontal)',
                    'fph-sc-new-player-square' =>'New player (square)',
                    'fph-sc-new-player-horz' => 'New player (horizontal)',
                ),
                'default' => 'fph-sc-classic-player'
            ),


            
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Audio thumbnail', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the audio thumbnail. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-audio-thumbnail"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-audio-thumbnail',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-featured-header-audio-art-active',
                'type' => 'switch',
                'title' => __('Thumbnail', 'podcaster'),
                'subtitle' => __('Activate the audio thumbnail.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-audio-art-alignment',
                'type' => 'button_set',
                'required' => array( 'pod-featured-header-audio-art-active', '=', true ),
                'title' => __('Alignment', 'podcaster'),
                'subtitle' => __('Set the alignment using the buttons, choose between left (default) and right.', 'podcaster'),
                'options' => array(
                    'fh-audio-art-left' => 'Left',  
                    'fh-audio-art-right' => 'Right',
                ),
                'default' => 'fh-audio-art-left'
            ),
            array(
                'id' => 'pod-audio-art-rounded-corners',
                'type' => 'button_set',
                'required' => array( 'pod-featured-header-audio-art-active', '=', true ),
                'title' => __('Rounded corners', 'podcaster'),
                'subtitle' => __('Set the corners for the thumbnail.', 'podcaster'),
                'options' => array(
                    'fh-audio-art-no-radius' => __('No Radius', 'podcaster'),  
                    'fh-audio-art-rounded' => __('Rounded', 'podcaster'),
                    'fh-audio-art-round' => __('Round', 'podcaster'),
                    'fh-audio-art-circle' => __('Circle', 'podcaster'),
                ),
                'default' => 'fh-audio-art-no-radius'
            ),

            array(
                'id' => 'pod-audio-art-circle-bg-active',
                'type' => 'switch',
                'required' => array( 'pod-featured-header-audio-art-active', '=', true ),
                'title' => __('Display background shapes', 'podcaster'),
                'subtitle' => __('Activate the circle background.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-audio-art-circle-bg-color',
                'type' => 'color',
                'required' => array(
                    array( 'pod-featured-header-audio-art-active', '=', true ),
                    array('pod-audio-art-circle-bg-active', '=', true)
                ),
                'title' => __('Background 1', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.main-featured-container .img .circle-container .circle-1'
                )
            ),
            array(
                'id' => 'pod-audio-art-circle-bg-2-color',
                'type' => 'color',
                'required' => array(
                    array( 'pod-featured-header-audio-art-active', '=', true ),
                    array('pod-audio-art-circle-bg-active', '=', true)
                ),
                'title' => __('Background 2', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.main-featured-container .img .circle-container .circle-3',
                    'border-color' => '.main-featured-container .img .circle-container .circle-2'
                )
            ),

            array(
                'id' => 'pod-audio-art-play-button-active',
                'type' => 'switch',
                'required' => array( 'pod-featured-header-audio-art-active', '=', true ),
                'title' => __('Display play button', 'podcaster'),
                'subtitle' => __('Activate the play button.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-audio-art-play-button-bg-color',
                'type' => 'color',
                'required' => array('pod-audio-art-play-button-active', '=', true),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.main-featured-container .img .play-button .icon'
                )
            ),
            array(
                'id' => 'pod-audio-art-play-button-color',
                'type' => 'color',
                'required' => array('pod-audio-art-play-button-active', '=', true),
                'title' => __('Icon', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#000000',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.main-featured-container .img .play-button .icon'
                )
            ),
            array(
                'id' => 'pod-audio-art-play-button-bg-hover-color',
                'type' => 'color',
                'required' => array('pod-audio-art-play-button-active', '=', true),
                'title' => __('Background (hover)', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#000000',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.main-featured-container .img .play-button:hover .icon'
                )
            ),
            array(
                'id' => 'pod-audio-art-play-button-hover-color',
                'type' => 'color',
                'required' => array('pod-audio-art-play-button-active', '=', true),
                'title' => __('Icon (hover)', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.main-featured-container .img .play-button:hover .icon'
                )
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Excerpt', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the excerpt. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-excerpt"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-excerpt',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-frontpage-fetured-ex',
                'type' => 'switch',
                'title' => __('Featured excerpt', 'podcaster'),
                'subtitle' => __('Use the switch to display a featured excerpt on the front page.', 'podcaster'),
                'default' => false,
            ),
            array(
                'id' => 'pod-frontpage-featured-ex-style',
                'type' => 'image_select',
                'title' => __('Style', 'podcaster'),
                'required' => array('pod-frontpage-fetured-ex', '=', true),
                'subtitle' => __('Select an excerpt style.', 'podcaster'),
                'options' => array(
                    'style-1' => array('title' => 'Style 1', 'img' => $theme_options_img. 'excerpt-1.png'),
                    'style-2' => array('title' => 'Style 2', 'img' => $theme_options_img. 'excerpt-2.png'),
                ),
                'default' => 'style-1'
            ),
            array(
                'id'=>'pod-excerpt-width',
                'type' => 'select',
                'title' => __('Width', 'podcaster'),
                'required' => array('pod-frontpage-fetured-ex', '=', true),
                'subtitle' => __('Choose between narrow, medium, wide and full.', 'podcaster'),
                'options' => array(
                    'excerpt-narrow' => 'Narrow',
                    'excerpt-medium' =>'Medium',
                    'excerpt-wide' => 'Wide',
                    'excerpt-full' => 'Full',
                ),
                'default' => 'excerpt-full'
            ),
            array(
                'id'       => 'pod-frontpage-featured-excerpt-length',
                'type'     => 'spinner', 
                'title'    => __('Excerpt length', 'podcaster'),
                'required' => array('pod-frontpage-fetured-ex', '=', true),
                'subtitle' => __('Set a length for the excerpt.','podcaster'),
                'default'  => '35',
                'min'      => '0',
                'step'     => '1',
                'max'      => '150',
            ),
            array(
                'id' => 'pod-frontpage-featured-ex-posi',
                'type' => 'radio',
                'required' => array( 'pod-frontpage-fetured-ex', '=', true ),
                'title' => __('Position', 'podcaster'),
                'subtitle' => __('Set the position, choose between above and below (default) your media.', 'podcaster'),
                'options' => array(
                    'above' => 'Above Media',
                    'below' => 'Below Media',
                ),
                'default' => 'below'
            ),
             array(
                'id' => 'pod-frontpage-featured-read-more',
                'type' => 'button_set',
                'title' => __('Read More Link', 'podcaster'),
                'required' => array('pod-frontpage-fetured-ex', '=', true),
                'subtitle' => __('Show or hide the Read More link.', 'podcaster'),
                'options' => array(
                    'show' => 'Show',
                    'hide' => 'Hide',
                    ),
                'default' => 'show'
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Schedule & subscribe', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the schedule and subscribe section.<a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-header-schedule-subscribe"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-fheader-scheduled',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-frontpage-nextweek',
                'type' => 'button_set',
                'title' => __('Show Preview Section', 'podcaster'),
                'subtitle' => __('Choose to hide or show the preview section.', 'podcaster'),
                'options' => array(
                    'show' => 'Show',
                    'hide' => 'Hide',
                    ),
                'default' => 'show'
            ),
            array(
                'id' => 'pod-scheduling',
                'type' => 'switch',
                'required' => array( "pod-frontpage-nextweek", "=", "show" ),
                'title' => __('Podcast Scheduling', 'podcaster'),
                'subtitle' => __('Display your scheduled posts on the front page. This will deactivate the <em>Upcoming Post Title</em> below.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-frontpage-nextweek-style',
                'type' => 'button_set',
                'title' => __('Style', 'podcaster'),
                'required' => array( "pod-frontpage-nextweek", "=", "show" ),
                'subtitle' => __('Choose between "Background" and "Line".', 'podcaster'),
                'options' => array(
                    'nextweek-background' => 'Background',
                    'nextweek-line' => 'Line',
                    ),
                'default' => 'nextweek-background'
            ),
            array(
                'id' => 'pod-color-advanced-scheduled-border',
                'type' => 'color',
                'required' => array('pod-frontpage-nextweek-style', '=', 'nextweek-line'),
                'title' => __('Border', 'podcaster'),
                'subtitle' => __('Select a border color.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'border-color' => '.nextweek-line .next-week')
            ),
            array(
                'id' => 'pod-color-scheduled-bg',
                'type' => 'color_rgba',
                'title' => __('Background', 'podcaster'),
                'required' => array(
                    array( "pod-frontpage-nextweek", "=", "show" ),
                    array('pod-frontpage-nextweek-style', '=', 'nextweek-background'),
                ),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'validate' => 'color',
                'transparent' => false,
                'default'   => array(
                    'color'     => '#000000',
                    'alpha'     => 0.25
                ),
            ),
            array(
                'id' => 'pod-color-advanced-scheduled-corners',
                'type' => 'button_set',
                'title' => __('Corners', 'podcaster'),
                'required' => array( "pod-frontpage-nextweek", "=", "show" ),
                'subtitle' => __('Select a corner style for this section.', 'podcaster'),
                'options' => array(
                    'next-week-corners-straight' => 'Straight',
                    'next-week-corners-round' => 'Round',
                    ),
                'default' => 'next-week-corners-round'
            ),
            array(
                'id' => 'pod-preview-title',
                'type' => 'text',
                'title' => __('Preview Title', 'podcaster'),
                'required' => array( "pod-frontpage-nextweek", "=", "show" ),
                'subtitle' => __('Enter the title for your preview section into the text field above.', 'podcaster'),
                'placeholder' => 'Next Time on Podcaster',
                'default' => 'Next Time on Podcaster',
            ),
            array(
                'id' => 'pod-preview-title-color',
                'type' => 'color',
                'required' => array( "pod-frontpage-nextweek", "=", "show" ),
                'title' => __('Preview title color', 'podcaster'),
                'subtitle' => __('Select a color for the preview title.', 'podcaster'),
                'default' => '#707172',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array( 'color' => '.latest-episode .next-week .mini-title, .next-week .mini-title' )
            ),
            array(
                'id' => 'pod-preview-heading',
                'type' => 'text',
                'required' => array(
                    array('pod-scheduling', '=', false),
                    array( "pod-frontpage-nextweek", "=", "show" )
                ),
                'title' => __('Upcoming Post Title', 'podcaster'),
                'subtitle' => __('Enter the title of your upcoming episode.', 'podcaster'),
                'default' => 'Episode 12: Let\'s go hiking!',
            ),
            array(
                'id' => 'pod-preview-heading-color',
                'type' => 'color',
                'title' => __('Post title color', 'podcaster'),
                'required' => array( "pod-frontpage-nextweek", "=", "show" ),
                'subtitle' => __('Select a color for the preview title.', 'podcaster'),
                'default' => '#a8a9a9',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array( 'color' => '.next-week h3, .next-week .schedule-message' )
            ),
            array(
                'id'       => 'pod-featured-header-buttons',
                'type'     => 'raw',
                'title'  => __( '<h3>Subscribe Buttons</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are to customize the subscribe buttons on your front page.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-subscribe-buttons',
                'type' => 'switch',
                'title' => __('Show Subscribe Buttons', 'podcaster'),
                'subtitle' => __('Display your subscribe buttons.', 'podcaster'),
                'default' => true
            ),
            array(
                'id' => 'pod-subscribe1',
                'type' => 'text',
                'required' => array('pod-subscribe-buttons', '=', true),
                'title' => __('Subscribe Button 1', 'podcaster'),
                'subtitle' => __('Enter the text for your button.', 'podcaster'),
                'validate' => 'no_html',
                'placeholder' => 'Subscribe with Apple Podcasts',
                'default' => 'Subscribe with Apple Podcasts'
            ),
            array(
                'id' => 'pod-subscribe1-url',
                'type' => 'text',
                'required' => array('pod-subscribe-buttons', '=', true),
                'title' => __('Subscribe Button 1 URL', 'podcaster'),
                'subtitle' => __('Enter the URL for your button.', 'podcaster'),
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-subscribe2',
                'type' => 'text',
                'required' => array('pod-subscribe-buttons', '=', true),
                'title' => __('Subscribe Button 2', 'podcaster'),
                'subtitle' => __('Enter the text for your button.', 'podcaster'),
                'validate' => 'no_html',
                'placeholder' => 'Subscribe with RSS',
                'default' => 'Subscribe with RSS'
            ),
            array(
                'id' => 'pod-subscribe2-url',
                'type' => 'text',
                'required' => array('pod-subscribe-buttons', '=', true),
                'title' => __('Subscribe Button 2 URL', 'podcaster'),
                'subtitle' => __('Enter the URL for your button.', 'podcaster'),
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-subscribe-single',
                'type' => 'checkbox',
                'required' => array('pod-subscribe-buttons', '=', true),
                'title' => __('Buttons on Single Page', 'podcaster'),
                'subtitle' => __('Check this box to display the buttons on single pages.', 'podcaster'),
                'switch' => true,
                'std' => '1'
            ),
            array(
                'id' => 'pod-subscribe-color-buttons-bg',
                'type' => 'color',
                'required' => array('pod-subscribe-buttons', '=', true),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array('background-color' => '.next-week .content.buttons .butn')
            ),
            array(
                'id' => 'pod-subscribe-color-buttons-link',
                'type' => 'color',
                'required' => array('pod-subscribe-buttons', '=', true),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array('color' => '.next-week .content.buttons .butn')
            ),
            array(
                'id' => 'pod-subscribe-color-buttons-bg-hover',
                'type' => 'color',
                'required' => array('pod-subscribe-buttons', '=', true),
                'title' => __('Background (hover)', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array('background-color' => '.next-week .content.buttons .butn:hover')
            ),
            array(
                'id' => 'pod-subscribe-color-buttons-link-hover',
                'type' => 'color',
                'required' => array('pod-subscribe-buttons', '=', true),
                'title' => __('Text (hover)', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array('color' => '.next-week .content.buttons .butn:hover')
            ),

        )
    ) );
	Redux::setSection( $opt_name, array(
        'icon' => 'fa fa-laptop',
        'icon_class' => 'icon-large',
        'title' => __('Front Page', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the front page. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('General', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the front page. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-list-posts-title',
                'type'     => 'raw',
                'title'  => __( '<br /><h3>Episodes</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the episodes on the static front page.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-front-page-post-players',
                'type' => 'switch',
                'title' => __('Display audio players', 'podcaster'),
                'subtitle' => __('Show audio players on the front page episodes.', 'podcaster'),
                'default' => true
            ),
            array(
                'id' => 'pod-front-page-post-categories',
                'type' => 'switch',
                'title' => __('Display categories', 'podcaster'),
                'subtitle' => __('Show categories on the front page episodes.', 'podcaster'),
                'default' => true
            ),
            array(
                'id' => 'pod-front-page-post-featured-image',
                'type' => 'switch',
                'title' => __('Display featured image', 'podcaster'),
                'subtitle' => __('Featured images on the front page episodes.', 'podcaster'),
                'default' => true
            ),
            array(
                'id' => 'pod-front-page-post-excerpts',
                'type' => 'switch',
                'title' => __('Display excerpts', 'podcaster'),
                'subtitle' => __('Show excerpts on the front page episodes.', 'podcaster'),
                'default' => true
            ),
            array(
                'id'=>'pod-front-page-post-excerpt-length',
                'type' => 'spinner',
                'required' => array('pod-front-page-post-excerpts', '=', true),
                'title' => __('Excerpt length', 'podcaster'),
                'subtitle' => 'Set a length for the excerpt.',
                "default"   => "35",
                "min"       => "0",
                "step"      => "1",
                "max"       => "150"
            ),
            array(
      				'id'=> 'pod-front-style',
      				'type' => 'radio',
      				'title' => __('Style', 'podcaster'),
      				'subtitle' => 'Select how you would like to display your episodes.',
              'options' => array(
            		'front-page-list' => 'List',
            		'front-page-grid' => 'Masonry',
                    'front-page-fit-grid' => 'Grid',
            		),
            	'default' => 'front-page-list'
      		),
            
            array(
                'id'=>'pod-front-posts',
                'type' => 'spinner',
                'title' => __('Amount of episodes', 'podcaster'),
                'subtitle' => 'Enter the amount of episodes to display.',
                "default"   => "9",
                "min"       => "0",
                "step"      => "1",
                "max"       => "9999"
            ),
            array(
                'id'       => 'pod-front-page-grid-opts-raw',
                'type'     => 'raw',
                'required' => array('pod-front-style', '=', array( 'front-page-grid', 'front-page-fit-grid' ) ),
                'title'  => __( '<h3>Grid</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the front page post button.', 'podcaster' ),
            ),
            array(
                'id'=>'pod-front-style-cols',
                'type' => 'radio',
                'required' => array('pod-front-style', '=', array( 'front-page-grid', 'front-page-fit-grid' ) ),
                'title' => __('Columns', 'podcaster'),
                'subtitle' => 'Select how many columns to use.',
                'options' => array(
                    'front-page-cols-2' => '2 columns',
                    'front-page-cols-3' => '3 columns',
                    'front-page-cols-4' => '4 columns'

                ),
                'default' => 'front-page-cols-3'
            ),
            array(
                'id'=>'pod-front-cols-gutter',
                'type' => 'spinner',
                'required' => array('pod-front-style', '=', array( 'front-page-grid', 'front-page-fit-grid' ) ),
                'title' => __('Gutter', 'podcaster'),
                'subtitle' => 'Set the gutter for the grid.',
                "default"   => "32",
                "min"       => "0",
                "step"      => "1",
                "max"       => "999"
            ),
            array(
                'id'=> 'pod-front-cols-orientation',
                'type' => 'radio',
                'required' => array('pod-front-style', '=', array( 'front-page-grid', 'front-page-fit-grid' ) ),
                'title' => __('Thumbnail orientation', 'podcaster'),
                'subtitle' => 'Select the orientation for your thumbnails.',
                'options' => array(
                    'front-page-cols-square' => 'Square',
                    'front-page-cols-horizontal' => 'Horizontal',
                    'front-page-cols-vertical' => 'Vertical'

                ),
                'default' => 'front-page-cols-square'
            ),
            array(
                'id'       => 'pod-front-page-entries-padding',
                'type'     => 'spacing',
                'mode'     => 'padding',
                'all'      => false,
                'top'           => true,     // Disable the top
                'right'         => true,     // Disable the right
                'bottom'        => true,     // Disable the bottom
                'left'          => true,     // Disable the left
                'units'         => 'px',      // You can specify a unit value. Possible: px, em, %
                'display_units' => 'true',   // Set to false to hide the units if the units are specified
                'title'    => __( 'Post padding', 'podcaster' ),
                'subtitle' => __( 'Customize the padding for your front page episodes.', 'podcaster' ),
                'default'  => array(
                    'padding-top'    => '42px',
                    'padding-right'  => '42px',
                    'padding-bottom' => '42px',
                    'padding-left'   => '42px'
                )
            ),
            array(
                'id'       => 'pod-front-page-titles-excerpts-raw',
                'type'     => 'raw',
                'title'  => __( '<h3>Titles & excerpts</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the titles and excerpts of the episodes.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-front-page-titles',
                'type' => 'switch',
                'title' => __('Truncate titles', 'podcaster'),
                'subtitle' => __('Truncate the titles of the posts on the front page.', 'podcaster'),
                'default' => false
            ),
            array(
            	'id' => 'pod-excerpts-type',
            	'type' => 'button_set',
            	'title' => __('Type of excerpts', 'podcaster'),
            	'subtitle' => __('Choose between <strong>Force Excerpt</strong> and <strong>Set in Post</strong>.','podcaster'),
            	'options' => array(
            		'force_excerpt' => 'Force Excerpt',
            		'set_in_post' => 'Custom Excerpt (Set in Post)',
                    'full-post' => 'Full Post',
            		),
            	'default' => 'force_excerpt'
            ),
            array(
                'id' => 'pod-front-page-read-more-text',
                'type' => 'text',
                'title' => __('Read more', 'podcaster'),
                'subtitle' => __('Enter the text for your read more link.', 'podcaster'),
                'default' => 'Read more',
            ),

            array(
                'id'       => 'pod-front-page-styling-raw',
                'type'     => 'raw',
                'title'  => __( '<h3>Styling</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are styling the episodes.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-front-page-entries-play-button',
                'title' => __('Play button', 'podcaster'),
                'type' => 'button_set',
                'subtitle' => __('Select a style for the play button.', 'podcaster'),
                'options' => array(
                    'episodes-play-icon-style-1' => 'Style 1',
                    'episodes-play-icon-style-2' => 'Style 2',
                ),
                'default' => 'episodes-play-icon-style-1'
            ),
            array(
                'id' => 'pod-front-page-entries-corners',
                'title' => __('Episodes corners', 'podcaster'),
                'type' => 'button_set',
                'subtitle' => __('Choose between <strong>Round</strong> and <strong>Straight</strong>.', 'podcaster'),
                'options' => array(
                    'entries-straight-corners' => 'Straight',
                    'entries-round-corners' => 'Round',
                ),
                'default' => 'entries-round-corners'
            ),
            array(
                'id' => 'pod-front-page-entries-corners-opts',
                'type' => 'radio',
                'required' => array( 'pod-front-page-entries-corners', '=', 'entries-round-corners' ),
                'title' => __('Corner Options', 'podcaster'),
                'subtitle' => __('Select an option for the corners.', 'podcaster'),
                'options' => array(
                    'entries-corners-entire' => 'Entire Episode',
                    'entries-corners-img-only' => 'Image Only',
                ),
                'default' => 'entries-corners-entire'
            ),
            array(
                'id' => 'pod-front-page-sidebar-corners',
                'title' => __('Sidebar corners', 'podcaster'),
                'type' => 'button_set',
                'subtitle' => __('Choose between <strong>Round</strong> and <strong>Straight</strong>.', 'podcaster'),
                'options' => array(
                    'sidebar-straight-corners' => 'Straight',
                    'sidebar-round-corners' => 'Round',
                ),
                'default' => 'sidebar-round-corners'
            ),
            array(
                'id' => 'pod-front-page-content-position',
                'title' => __('Content position', 'podcaster'),
                'type' => 'button_set',
                'subtitle' => __('Select whete to display your content. This is includes Gutenberg blocks or other content you enter into the page editor.', 'podcaster'),
                'options' => array(
                    'content-above-episodes' => 'Above Episodes',
                    'content-below-episodes' => 'Below Episodes',
                    'content-hide' => 'Hide'
                ),
                'default' => 'content-above-episodes'
            ),
            array(
                'id'       => 'pod-front-page-button-raw',
                'type'     => 'raw',
                'title'  => __( '<h3>Pagination</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the front page pagination button.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-front-page-button-type',
                'type' => 'button_set',
                'title' => __('Button type', 'podcaster'),
                'subtitle' => __('Choose between adding a load more button, pagination or a custom button.', 'podcaster'),
                'options' => array(
                    'list-of-posts-ajax' => 'Load More Button',
                    'list-of-posts-pagination' => 'Number Pagination',
                    'list-of-posts-custom' => 'Custom Button',
                    'list-of-posts-none' => 'None',
                    ),
                'default' => 'list-of-posts-none'
            ),
            array(
                'id' => 'pod-ajax-link-txt',
                'type' => 'text',
                'required' => array('pod-front-page-button-type', '=', 'list-of-posts-ajax'),
                'title' => __('Button text', 'podcaster'),
                'subtitle' => __('Enter text for the button in the field.', 'podcaster'),
                'validate' => 'no_html',
                'default' => 'Load More'
            ),
            array(
                'id' => 'pod-ajax-link-loading-txt',
                'type' => 'text',
                'required' => array('pod-front-page-button-type', '=', 'list-of-posts-ajax'),
                'title' => __('Loading text', 'podcaster'),
                'subtitle' => __('Enter the loading more text in the field.', 'podcaster'),
                'validate' => 'no_html',
                'default' => 'Loading...'
            ),
            array(
                'id' => 'pod-ajax-link-loaded-txt',
                'type' => 'text',
                'required' => array('pod-front-page-button-type', '=', 'list-of-posts-ajax'),
                'title' => __('Loaded text', 'podcaster'),
                'subtitle' => __('Enter the text to be displayed when all posts are loaded.', 'podcaster'),
                'validate' => 'no_html',
                'default' => 'No more posts to load.'
            ),
            array(
                'id' => 'pod-archive-link-txt',
                'type' => 'text',
                'title' => __('Button text', 'podcaster'),
                'required' => array('pod-front-page-button-type', '=', 'list-of-posts-custom'),
                'subtitle' => __('Enter the text for the button in the field.', 'podcaster'),
                'validate' => 'no_html',
                'placeholder' => 'Podcast Archive',
                'default' => 'Podcast Archive'
            ),
            array(
                'id' => 'pod-archive-link',
                'type' => 'text',
                'title' => __('Button URL', 'podcaster'),
                'required' => array('pod-front-page-button-type', '=', 'list-of-posts-custom'),
                'subtitle' => __('Enter the URL into the field.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/podcast-archive-page',
            ),
            array(
                'id'       => 'pod-responsive-layout-title',
                'type'     => 'raw',
                'required' => array('pod-front-style', '=', 'front-page-list'),
                'title'  => __( '<h3>Responsive Layout</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the responsive layout settings.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-responsive-layout',
                'type' => 'button_set',
                'required' => array('pod-front-style', '=', 'front-page-list'),
                'title' => __('Layout', 'podcaster'),
                'subtitle' => __('Choose between <strong>Grid</strong> and <strong>List</strong>.', 'podcaster'),
                'options' => array(
                    'fp-resp-list' => 'List',
                    'fp-resp-grid' => 'Grid',
                ),
                'default' => 'fp-resp-grid'
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Colors', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the colors for the front page. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-colors"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-front-page-color',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-custom-frontpage-color-settings',
                'type' => 'switch',
                'title' => __('Custom colors', 'podcaster'),
                'subtitle' => __('Activate custom color settings.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-color-bg',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#e5e5e5',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.list-of-episodes, .hosts-container, .has-front-page-template.dark-template-active .hosts-container, .has-front-page-template.dark-template-active.front-page-indigo .hosts-container, .call-to-action-container, .has-front-page-template .call-to-action-container, .has-front-page-template .main-content.blog-front-page, .pod-wave .divider-buffer',
                    'fill' => '.pod-wave .wave-svg svg path')
            ),
            array(
                'id' => 'pod-color-fp-border',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Borders', 'podcaster'),
                'subtitle' => __('Select a border color.', 'podcaster'),
                'default' => '#dddddd',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'border-color' => '.has-front-page-template .entry-meta, .has-front-page-template .thst_highlight_category_widget ul li .text, .has-front-page-template .widget.thst_recent_comments_widget ul li.recentcomments, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-panel article',
                    'background' => '.blog-front-page .entries #loading_bg'
                )
            ),
            array(
                'id' => 'pod-color-fp-fields',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Sidebar inputs & fields.', 'podcaster'),
                'subtitle' => __('Select a color for sidebar fields and inputs.', 'podcaster'),
                'default' => '#eeeeee',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.has-front-page-template .widget #calendar_wrap #wp-calendar thead tr, .has-front-page-template .thst_highlight_category_widget ul li:first-child .text, .has-front-page-template.dark-template-active .sidebar .wp-caption .wp-caption-text, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-nav li, .has-front-page-template .widget .tagcloud a:link, .has-front-page-template .widget .tagcloud a:visited, .has-front-page-template.dark-template-active .widget.thst_recent_blog_widget .ui-tabs-nav li a:link, .has-front-page-template.dark-template-active .widget.thst_recent_blog_widget .ui-tabs-nav li a:visited',   
                    'border-bottom-color' => '.has-front-page-template .thst_highlight_category_widget ul li:first-child .text.arrow::after' 
                )
            ),


            array(
                'id'       => 'pod-color-fp-ep-raw',
                'type'     => 'raw',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title'  => __( '<h3>Episodes</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the episodes.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-color-fp-ep-bg',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color for the episodes.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.list-of-episodes article .post-content, .list-of-episodes .inside, .list-of-episodes.fp-resp-list article, .list-of-episodes.full-post article.list .inside, .list-of-episodes .sidebar .widget, .front-page-indigo .list-of-episodes article .post-content, .list-of-episodes article, .list-of-episodes.fp-resp-grid.full-post article .inside, .list-of-episodes #loading_bg, .list-of-episodes #loading_bg.hide_bg, .front-page-indigo .list-of-episodes.full-post article .inside, .has-front-page-template .entries .post, .has-front-page-template .sidebar .widget:not(.widget_search):not(.thst_recent_blog_widget), .has-front-page-template .post.format-video .video-caption, .has-front-page-template .post.format-audio .featured-media .audio-caption, .has-front-page-template .post.format-image .entry-featured .image-caption, .has-front-page-template .post.format-gallery .featured-gallery .gallery-caption, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-panel, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-state-active a:link, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-state-active a:visited, .has-front-page-template.dark-template-active .sidebar .widget:not(.widget_search):not(.thst_highlight_category_widget):not(.thst_recent_blog_widget), .has-front-page-template.dark-template-active .widget.thst_recent_blog_widget .ui-tabs-panel article, .has-front-page-template.dark-template-active .widget.thst_recent_blog_widget .ui-tabs-nav, .has-front-page-template.dark-template-active .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-state-active a:link, .has-front-page-template.dark-template-active .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-state-active a:visited, .page.page-template .blog-front-page .post .entry-content')
            ),
            array(
                'id' => 'pod-color-fp-ep-heading',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Title', 'podcaster'),
                'subtitle' => __('Select a color for the episode titles.', 'podcaster'),
                'default' => '#444444',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.list-of-episodes article .post-header h2 a:link, .list-of-episodes article .post-header h2 a:visited, .list-of-episodes .sidebar h3, .has-front-page-template .list-of-episodes article .post-header h2 a:link, .has-front-page-template .list-of-episodes article .post-header h2 a:visited, .has-front-page-template .entries .post .entry-header .entry-title a:link, .has-front-page-template .entries .post .entry-header .entry-title a:visited, .has-front-page-template .sidebar h3')
            ),
            array(
                'id' => 'pod-color-fp-ep-heading-hover',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Title (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the titles.', 'podcaster'),
                'default' => '#333333',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.list-of-episodes article .post-header h2 a:hover, .has-front-page-template .list-of-episodes article .post-header h2 a:hover, .has-front-page-template .entries .post .entry-header .entry-title a:hover'
                )
            ),
            array(
                'id' => 'pod-color-fp-ep-text',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.list-of-episodes article .post-content, .list-of-episodes article .post-content p, .list-of-episodes .sidebar .widget, .has-front-page-template .list-of-episodes article .post-content, .has-front-page-template .list-of-episodes article .mejs-container .mejs-controls .mejs-time, .has-front-page-template .entries .post .entry-content, .has-front-page-template .sidebar .widget, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-state-active a:link, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-state-active a:visited, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-panel article .text .date, .has-front-page-template .thst_highlight_category_widget ul li:first-child .text .h_author',
                    'border-color' => '.blog-front-page .entries #loading_bg .circle-spinner',
                    'background' => '.blog-front-page .entries #loading_bg .circle-spinner .line::before'
                )
            ),
            array(
                'id' => 'pod-color-fp-ep-link',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Links', 'podcaster'),
                'subtitle' => __('Select a color for the links.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.list-of-episodes article .post-content a:link, .list-of-episodes article .post-content a:visited, .list-of-episodes .sidebar .widget a:link, .list-of-episodes .sidebar .widget a:visited, .list-of-episodes article .post-header ul a:link, .list-of-episodes article .post-header ul a:visited, .has-front-page-template .list-of-episodes article .post-content a:link, .has-front-page-template .list-of-episodes article .post-content a:visited, .has-front-page-template .entries .post a:link, .has-front-page-template .entries .post a:visited, .has-front-page-template .sidebar .widget a:link, .has-front-page-template .sidebar .widget a:visited, .has-front-page-template .sidebar .widget ul li a:link, .has-front-page-template .sidebar .widget ul li a:visited, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:link, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:visited'
                )
            ),
            array(
                'id' => 'pod-color-fp-ep-link-hover',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Links (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the links.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.list-of-episodes article .post-content a:hover, .list-of-episodes article .post-header ul a:hover, .list-of-episodes .sidebar .widget a:hover, .has-front-page-template .list-of-episodes article .post-content a:hover, .has-front-page-template .entries .post a:hover, .has-front-page-template .sidebar .widget a:hover, .has-front-page-template .sidebar .widget ul li a:hover, .has-front-page-template .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:hover')
            ),


             array(
                'id'       => 'pod-color-fp-player-raw',
                'type'     => 'raw',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title'  => __( '<h3>Audio players</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the audio players.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-color-fp-ep-player-icon-bg-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-custom-frontpage-color-settings', '=', true),
                    array('pod-players-style', '=','players-style-2')
                ),
                'transparent' => false,
                'title'    => __('Play icon background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#efefef',
                'output'    => array(
                    'background-color' => '.players-style-2 .list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button'
                )
            ),
            array(
                'id'       => 'pod-color-fp-ep-player-icon-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-custom-frontpage-color-settings', '=', true),
                ),
                'transparent' => false,
                'title'    => __('Icons', 'podcaster'),
                'subtitle' => __('Select an icon color.', 'podcaster'),
                'default' => '#24292c',
                'output'    => array(
                    'color' => '.front-page-indigo .list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button button'
                )
            ),
            array(
                'id'       => 'pod-color-fp-ep-player-icon-bg-hove-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-custom-frontpage-color-settings', '=', true),
                    array('pod-players-style', '=','players-style-2')
                ),
                'transparent' => false,
                'title'    => __('Play icon background (hover)', 'podcaster'),
                'subtitle' => __('Select a background color (hover).', 'podcaster'),
                'default' => '#24292c',
                'output'    => array(
                    'background-color' => '.players-style-2 .list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button:hover'
                )
            ),
            array(
                'id'       => 'pod-color-fp-ep-player-icon-hover-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-custom-frontpage-color-settings', '=', true),
                ),
                'transparent' => false,
                'title'    => __('Icons (hover)', 'podcaster'),
                'subtitle' => __('Select an icon color (hover).', 'podcaster'),
                'default' => '#1E7CE8',
                'output'    => array(
                    'color' => '.front-page-indigo .list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button button:hover'
                )
            ),
            array(
                'id'       => 'pod-color-fp-ep-player-icon-volume-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-custom-frontpage-color-settings', '=', true),
                    array('pod-players-style', '=','players-style-2')
                ),
                'transparent' => false,
                'title'    => __('Volume icon', 'podcaster'),
                'subtitle' => __('Select an icon color.', 'podcaster'),
                'default' => '#282d31',
                'output'    => array(
                    'color' => '.front-page-indigo .list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button button'
                )
            ),
            array(
                'id'       => 'pod-color-fp-ep-player-icon-volume-hover-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-custom-frontpage-color-settings', '=', true),
                    array('pod-players-style', '=','players-style-2')
                ),
                'transparent' => false,
                'title'    => __('Volume icon (hover)', 'podcaster'),
                'subtitle' => __('Select an icon color (hover).', 'podcaster'),
                'default' => '#282d31',
                'output'    => array(
                    'color' => '.front-page-indigo .list-of-episodes article .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button button:hover'
                )
            ),
            array(
                'id' => 'pod-color-fp-ep-player-rail',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Audio player rail', 'podcaster'),
                'subtitle' => __('Select a background color for the rail of audio players.', 'podcaster'),
                'default' => '#eeeeee',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.has-front-page-template .list-of-episodes article .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total, .has-front-page-template .list-of-episodes article .mejs-container .mejs-controls .mejs-time-rail .mejs-time-total, .has-front-page-template .list-of-episodes article .mejs-container .mejs-controls .mejs-time-rail .mejs-time-loaded'
                    )
            ),
            array(
                'id' => 'pod-color-fp-ep-player-rail-played',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Audio player rail (played)', 'podcaster'),
                'subtitle' => __('Select a background color for the rail of audio players.', 'podcaster'),
                'default' => '#1E7CE8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.front-page-indigo .list-of-episodes article .mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .front-page-indigo .list-of-episodes article .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current'
                    )
            ),


            array(
                'id'       => 'pod-color-fp-load-more-raw',
                'type'     => 'raw',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title'  => __( '<h3>Load More Button</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the load more button.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-color-fp-ep-button-bg',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Button background', 'podcaster'),
                'subtitle' => __('Select a background color for the button.', 'podcaster'),
                'default' => '#dddddd',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.pod_loadmore, a.butn.archive-link-button:link, a.butn.archive-link-button:visited')
            ),
            array(
                'id' => 'pod-color-fp-ep-button-txt',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Button text', 'podcaster'),
                'subtitle' => __('Select a text color for the button.', 'podcaster'),
                'default' => '#111111',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.pod_loadmore, a.butn.archive-link-button:link, a.butn.archive-link-button:visited')
            ),
            array(
                'id' => 'pod-color-fp-ep-button-bg-hover',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Button background (hover)', 'podcaster'),
                'subtitle' => __('Select a background color for the button.', 'podcaster'),
                'default' => '#767676',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.pod_loadmore:hover, a.butn.archive-link-button:hover')
            ),
            array(
                'id' => 'pod-color-fp-ep-button-txt-hover',
                'type' => 'color',
                'required' => array('pod-custom-frontpage-color-settings', '=', true),
                'title' => __('Button text (hover)', 'podcaster'),
                'subtitle' => __('Select a text color for the button.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.pod_loadmore:hover, a.butn.archive-link-button:hover')
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Hosts', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the hosts section on the front page. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-hosts"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-front-page-hosts',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-frontpage-hosts-active',
                'type' => 'switch',
                'title' => __('Hosts', 'podcaster'),
                'subtitle' => __('Activate the hosts section.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-frontpage-hosts-title',
                'type' => 'text',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Title', 'podcaster'),
                'subtitle' => __('Enter a title for the hosts section.', 'podcaster'),
                'placeholder' => '',
                'default' => 'Hosts',
            ),
            array(
                'id' => 'pod-frontpage-hosts-blurb',
                'type' => 'text',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Blurb', 'podcaster'),
                'subtitle' => __('Enter a blurb for the hosts section.', 'podcaster'),
                'placeholder' => '',
                'default' => '',
            ),
            array(
                'id'=>'pod-frontpage-hosts-align',
                'type' => 'radio',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Alignment', 'podcaster'),
                'subtitle' => 'Select an alignment for the host columns.',
                'options' => array(
                    'hosts-align-left' => 'Left',
                    'hosts-align-center' => 'Center',
                    'hosts-align-right' => 'Right'

                ),
                'default' => 'hosts-align-left'
            ),
            array(
                'id'=>'pod-frontpage-hosts-cols',
                'type' => 'radio',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Columns', 'podcaster'),
                'subtitle' => 'Select how many columns to use.',
                'options' => array(
                    'hosts-cols-2' => '2 columns',
                    'hosts-cols-3' => '3 columns',
                    'hosts-cols-4' => '4 columns'

                ),
                'default' => 'hosts-cols-3'
            ),
            array(
                'id'       => 'pod-frontpage-hosts-padding',
                'type'     => 'spacing',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'mode'     => 'padding',
                'all'      => false,
                'top'           => true,     // Disable the top
                'right'         => true,     // Disable the right
                'bottom'        => true,     // Disable the bottom
                'left'          => true,     // Disable the left
                'units'         => 'px',      // You can specify a unit value. Possible: px, em, %
                'display_units' => 'true',   // Set to false to hide the units if the units are specified
                'title'    => __( 'Padding', 'podcaster' ),
                'subtitle' => __( 'Enter the padding for an individual host box.', 'podcaster' ),
                'default'  => array(
                    'padding-top'    => '32px',
                    'padding-right'  => '32px',
                    'padding-bottom' => '32px',
                    'padding-left'   => '32px'
                )
            ),
            
            array(
                'id'       => 'pod-frontpage-host-1-raw',
                'type'     => 'raw',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title'  => __( '<h3>Host 1</h3>', 'podcaster' ),
                'content'  => __( 'Use the settings below to display your host.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-frontpage-host-1-active',
                'type' => 'switch',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Activate Host 1', 'podcaster'),
                'subtitle' => __('Activate Host 1.', 'podcaster'),
                'default' => true
            ),
            array(
                'id' => 'pod-frontpage-host-1-user',
                'type' => 'select',
                'required' => array('pod-frontpage-host-1-active', '=', true),
                'data' => 'users',
                'title' => __('Host 1', 'podcaster'),
                'subtitle' => __('Select the user from the drop down menu.', 'podcaster'),
            ),
            array(
                'id' => 'pod-frontpage-host-1-image',
                'type' => 'media',
                'required' => array('pod-frontpage-host-1-active', '=', true),
                'title' => __('Host 1 - Image', 'podcaster'),
                'subtitle' => __('Upload a user image for your host.', 'podcaster'),
                'url' => false
            ),
            array(
                'id'=>'pod-frontpage-host-1-link',
                'type' => 'radio',
                'required' => array('pod-frontpage-host-1-active', '=', true),
                'title' => __('Link', 'podcaster'),
                'subtitle' => 'Select the link settings for this host.',
                'options' => array(
                    'host-link-no' => 'No Link',
                    'host-link-default' => 'Author profile',
                    'host-link-custom' => 'Custom'

                ),
                'default' => 'host-link-default'
            ),
            array(
                'id' => 'pod-frontpage-host-1-url',
                'type' => 'text',
                'required' => array('pod-frontpage-host-1-link', '=', 'host-link-custom'),
                'title' => __('Custom URL', 'podcaster'),
                'subtitle' => __('Enter a valid URL for this host.', 'podcaster'),
                'placeholder' => 'http://www.example.com',
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-frontpage-host-1-description',
                'type' => 'textarea',
                'required' => array('pod-frontpage-host-1-active', '=', true),
                'title' => __('Host 1 - Description', 'podcaster'),
                'subtitle' => __('Enter a short description for your host.', 'podcaster'),
            ),
            array(
                'id'       => 'pod-frontpage-host-2-raw',
                'type'     => 'raw',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title'  => __( '<h3>Host 2</h3>', 'podcaster' ),
                'content'  => __( 'Use the settings below to display your host.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-frontpage-host-2-active',
                'type' => 'switch',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Host 2', 'podcaster'),
                'subtitle' => __('Activate Host 2', 'podcaster'),
                'default' => true
            ),
            array(
                'id' => 'pod-frontpage-host-2-user',
                'type' => 'select',
                'required' => array('pod-frontpage-host-2-active', '=', true),
                'data' => 'users',
                'title' => __('Host 2', 'podcaster'),
                'subtitle' => __('Select the user from the drop down menu.', 'podcaster'),
            ),
            array(
                'id' => 'pod-frontpage-host-2-image',
                'type' => 'media',
                'required' => array('pod-frontpage-host-2-active', '=', true),
                'title' => __('Host 2 - Image', 'podcaster'),
                'subtitle' => __('Upload a user image for your host.', 'podcaster'),
                'url' => false
            ),
            array(
                'id'=>'pod-frontpage-host-2-link',
                'type' => 'radio',
                'required' => array('pod-frontpage-host-2-active', '=', true),
                'title' => __('Link', 'podcaster'),
                'subtitle' => 'Select the link settings for this host.',
                'options' => array(
                    'host-link-no' => 'No Link',
                    'host-link-default' => 'Author profile',
                    'host-link-custom' => 'Custom'

                ),
                'default' => 'host-link-default'
            ),
            array(
                'id' => 'pod-frontpage-host-2-url',
                'type' => 'text',
                'required' => array('pod-frontpage-host-2-link', '=', 'host-link-custom'),
                'title' => __('Custom URL', 'podcaster'),
                'subtitle' => __('Enter a valid URL for this host.', 'podcaster'),
                'placeholder' => 'http://www.example.com',
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-frontpage-host-2-description',
                'type' => 'textarea',
                'required' => array('pod-frontpage-host-2-active', '=', true),
                'title' => __('Host 2 - Description', 'podcaster'),
                'subtitle' => __('Enter a short description for your host.', 'podcaster'),
            ),
            array(
                'id'       => 'pod-frontpage-host-3-raw',
                'type'     => 'raw',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title'  => __( '<h3>Host 3</h3>', 'podcaster' ),
                'content'  => __( 'Use the settings below to display your host.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-frontpage-host-3-active',
                'type' => 'switch',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Host 3', 'podcaster'),
                'subtitle' => __('Activate Host 3', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-frontpage-host-3-user',
                'type' => 'select',
                'required' => array('pod-frontpage-host-3-active', '=', true),
                'data' => 'users',
                'title' => __('Host 3', 'podcaster'),
                'subtitle' => __('Select the user from the drop down menu.', 'podcaster'),
            ),
            array(
                'id' => 'pod-frontpage-host-3-image',
                'type' => 'media',
                'required' => array('pod-frontpage-host-3-active', '=', true),
                'title' => __('Host 3 - Image', 'podcaster'),
                'subtitle' => __('Upload a user image for your host.', 'podcaster'),
                'url' => false
            ),
            array(
                'id'=>'pod-frontpage-host-3-link',
                'type' => 'radio',
                'required' => array('pod-frontpage-host-3-active', '=', true),
                'title' => __('Link', 'podcaster'),
                'subtitle' => 'Select the link settings for this host.',
                'options' => array(
                    'host-link-no' => 'No Link',
                    'host-link-default' => 'Author profile',
                    'host-link-custom' => 'Custom'

                ),
                'default' => 'host-link-default'
            ),
            array(
                'id' => 'pod-frontpage-host-3-url',
                'type' => 'text',
                'required' => array('pod-frontpage-host-3-link', '=', 'host-link-custom'),
                'title' => __('Custom URL', 'podcaster'),
                'subtitle' => __('Enter a valid URL for this host.', 'podcaster'),
                'placeholder' => 'http://www.example.com',
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-frontpage-host-3-description',
                'type' => 'textarea',
                'required' => array('pod-frontpage-host-3-active', '=', true),
                'title' => __('Host 3 - Description', 'podcaster'),
                'subtitle' => __('Enter a short description for your host.', 'podcaster'),
            ),
            array(
                'id'       => 'pod-frontpage-host-4-raw',
                'type'     => 'raw',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title'  => __( '<h3>Host 4</h3>', 'podcaster' ),
                'content'  => __( 'Use the settings below to display your host.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-frontpage-host-4-active',
                'type' => 'switch',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Host 4', 'podcaster'),
                'subtitle' => __('Activate Host 4', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-frontpage-host-4-user',
                'type' => 'select',
                'required' => array('pod-frontpage-host-4-active', '=', true),
                'data' => 'users',
                'title' => __('Host 4', 'podcaster'),
                'subtitle' => __('Select the user from the drop down menu.', 'podcaster'),
            ),
            array(
                'id' => 'pod-frontpage-host-4-image',
                'type' => 'media',
                'required' => array('pod-frontpage-host-4-active', '=', true),
                'title' => __('Host 4 - Image', 'podcaster'),
                'subtitle' => __('Upload a user image for your host.', 'podcaster'),
                'url' => false
            ),
            array(
                'id'=>'pod-frontpage-host-4-link',
                'type' => 'radio',
                'required' => array('pod-frontpage-host-4-active', '=', true),
                'title' => __('Link', 'podcaster'),
                'subtitle' => 'Select the link settings for this host.',
                'options' => array(
                    'host-link-no' => 'No Link',
                    'host-link-default' => 'Author profile',
                    'host-link-custom' => 'Custom'

                ),
                'default' => 'host-link-default'
            ),
            array(
                'id' => 'pod-frontpage-host-4-url',
                'type' => 'text',
                'required' => array('pod-frontpage-host-4-link', '=', 'host-link-custom'),
                'title' => __('Custom URL', 'podcaster'),
                'subtitle' => __('Enter a valid URL for this host.', 'podcaster'),
                'placeholder' => 'http://www.example.com',
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-frontpage-host-4-description',
                'type' => 'textarea',
                'required' => array('pod-frontpage-host-4-active', '=', true),
                'title' => __('Host 4 - Description', 'podcaster'),
                'subtitle' => __('Enter a short description for your host.', 'podcaster'),
            ),
            array(
                'id'       => 'pod-frontpage-host-5-raw',
                'type'     => 'raw',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title'  => __( '<h3>Host 5</h3>', 'podcaster' ),
                'content'  => __( 'Use the settings below to display your host.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-frontpage-host-5-active',
                'type' => 'switch',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Host 5', 'podcaster'),
                'subtitle' => __('Activate Host 5', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-frontpage-host-5-user',
                'type' => 'select',
                'required' => array('pod-frontpage-host-5-active', '=', true),
                'data' => 'users',
                'title' => __('Host 5', 'podcaster'),
                'subtitle' => __('Select the user from the drop down menu.', 'podcaster'),
            ),
            array(
                'id' => 'pod-frontpage-host-5-image',
                'type' => 'media',
                'required' => array('pod-frontpage-host-5-active', '=', true),
                'title' => __('Host 5 - Image', 'podcaster'),
                'subtitle' => __('Upload a user image for your host.', 'podcaster'),
                'url' => false
            ),
            array(
                'id'=>'pod-frontpage-host-5-link',
                'type' => 'radio',
                'required' => array('pod-frontpage-host-5-active', '=', true),
                'title' => __('Link', 'podcaster'),
                'subtitle' => 'Select the link settings for this host.',
                'options' => array(
                    'host-link-no' => 'No Link',
                    'host-link-default' => 'Author profile',
                    'host-link-custom' => 'Custom'

                ),
                'default' => 'host-link-default'
            ),
            array(
                'id' => 'pod-frontpage-host-5-url',
                'type' => 'text',
                'required' => array('pod-frontpage-host-5-link', '=', 'host-link-custom'),
                'title' => __('Custom URL', 'podcaster'),
                'subtitle' => __('Enter a valid URL for this host.', 'podcaster'),
                'placeholder' => 'http://www.example.com',
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-frontpage-host-5-description',
                'type' => 'textarea',
                'required' => array('pod-frontpage-host-5-active', '=', true),
                'title' => __('Host 5 - Description', 'podcaster'),
                'subtitle' => __('Enter a short description for your host.', 'podcaster'),
            ),
            array(
                'id'       => 'pod-frontpage-host-6-raw',
                'type'     => 'raw',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title'  => __( '<h3>Host 6</h3>', 'podcaster' ),
                'content'  => __( 'Use the settings below to display your host.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-frontpage-host-6-active',
                'type' => 'switch',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Host 6', 'podcaster'),
                'subtitle' => __('Activate Host 6', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-frontpage-host-6-user',
                'type' => 'select',
                'required' => array('pod-frontpage-host-6-active', '=', true),
                'data' => 'users',
                'title' => __('Host 6', 'podcaster'),
                'subtitle' => __('Select the user from the drop down menu.', 'podcaster'),
            ),
            array(
                'id' => 'pod-frontpage-host-6-image',
                'type' => 'media',
                'required' => array('pod-frontpage-host-6-active', '=', true),
                'title' => __('Host 6 - Image', 'podcaster'),
                'subtitle' => __('Upload a user image for your host.', 'podcaster'),
                'url' => false
            ),
            array(
                'id'=>'pod-frontpage-host-6-link',
                'type' => 'radio',
                'required' => array('pod-frontpage-host-6-active', '=', true),
                'title' => __('Link', 'podcaster'),
                'subtitle' => 'Select the link settings for this host.',
                'options' => array(
                    'host-link-no' => 'No Link',
                    'host-link-default' => 'Author profile',
                    'host-link-custom' => 'Custom'

                ),
                'default' => 'host-link-default'
            ),
            array(
                'id' => 'pod-frontpage-host-6-url',
                'type' => 'text',
                'required' => array('pod-frontpage-host-6-link', '=', 'host-link-custom'),
                'title' => __('Custom URL', 'podcaster'),
                'subtitle' => __('Enter a valid URL for this host.', 'podcaster'),
                'placeholder' => 'http://www.example.com',
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id' => 'pod-frontpage-host-6-description',
                'type' => 'textarea',
                'required' => array('pod-frontpage-host-6-active', '=', true),
                'title' => __('Host 6 - Description', 'podcaster'),
                'subtitle' => __('Enter a short description for your host.', 'podcaster'),
            ),
            array(
                'id'       => 'pod-frontpage-host-colors-raw',
                'type'     => 'raw',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title'  => __( '<h3>Colors</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the colors of the host section.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-color-hosts-headings-text',
                'type' => 'color',
                'required' => array('pod-frontpage-hosts-active', '=', true),
                'title' => __('Heading & text', 'podcaster'),
                'subtitle' => __('Select a color for the headings.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.hosts-container .hosts-description, .dark-template-active .hosts-container .hosts-description h2')
            ),
            array(
                'id' => 'pod-frontpage-hosts-background-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-hosts-active', '=', true ),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.hosts-container .hosts-content .host, .front-page-indigo.dark-template-active .hosts-content .host' )
            ),
            array(
                'id' => 'pod-frontpage-hosts-text-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-hosts-active', '=', true ),
                'title' => __('Title', 'podcaster'),
                'subtitle' => __('Select a color for the titles.', 'podcaster'),
                'default' => '#444444',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.hosts-container .hosts-content .host h3, .front-page-indigo.dark-template-active .hosts-container .hosts-content .host h3',
                     )
            ),
            array(
                'id' => 'pod-frontpage-hosts-description-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-hosts-active', '=', true ),
                'title' => __('Description', 'podcaster'),
                'subtitle' => __('Select a color for the description.', 'podcaster'),
                'default' => '#888888',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.hosts-container .hosts-content .host .host-content, .hosts-container .hosts-content .host .host-position, .hosts-container .hosts-content .host .host-social li a, .front-page-indigo.dark-template-active .hosts-container .hosts-content .host .host-content, .front-page-indigo.dark-template-active .hosts-container .hosts-content .host .host-position, .front-page-indigo.dark-template-active .hosts-container .hosts-content .host .host-social li a',
                    'fill' => '.hosts-container .hosts-content .host .host-social li svg'
                )
            ),

            array(
                'id' => 'pod-frontpage-hosts-user-hover-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-hosts-active', '=', true ),
                'title' => __('User image (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the user image.', 'podcaster'),
                'default' => '#2646fb',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.hosts-container .hosts-content .host .host-image::before, .front-page-indigo.dark-template-active .hosts-container .hosts-content .host .host-image::before',
                     )
            ),

        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Donate button', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the donate button on the front page. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-donate-button"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-front-page-donate',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-frontpage-donate-active',
                'type' => 'switch',
                'title' => __('Donate Button', 'podcaster'),
                'subtitle' => __('Activate the donate button section.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-frontpage-donate-title',
                'type' => 'text',
                'required' => array('pod-frontpage-donate-active', '=', true),
                'title' => __('Title', 'podcaster'),
                'subtitle' => __('Enter a title for your section.', 'podcaster'),
                'placeholder' => '',
                'default' => 'Support the show on Patreon',
            ),
            array(
                'id' => 'pod-frontpage-donate-blurb',
                'type' => 'text',
                'required' => array('pod-frontpage-donate-active', '=', true),
                'title' => __('Blurb', 'podcaster'),
                'subtitle' => __('Enter a blurb for your section.', 'podcaster'),
                'placeholder' => '',
                'default' => '',
            ),
            array(
                'id'       => 'pod-front-page-donate-padding',
                'type'     => 'spacing',
                'required' => array('pod-frontpage-donate-active', '=', true),
                'mode'     => 'padding',
                'all'      => false,
                'top'           => true,     // Disable the top
                'right'         => true,     // Disable the right
                'bottom'        => true,     // Disable the bottom
                'left'          => true,     // Disable the left
                'units'         => 'px',      // You can specify a unit value. Possible: px, em, %
                'display_units' => 'true',   // Set to false to hide the units if the units are specified
                'title'    => __( 'Padding', 'podcaster' ),
                'subtitle' => __( 'Enter the padding for your donate section.', 'podcaster' ),
                'default'  => array(
                    'padding-top'    => '72px',
                    'padding-right'  => '42px',
                    'padding-bottom' => '72px',
                    'padding-left'   => '42px'
                )
            ),
            array(
                'id' => 'pod-frontpage-donate-button-type',
                'type' => 'button_set',
                'required' => array('pod-frontpage-donate-active', '=', true),
                'title' => __('Button type', 'podcaster'),
                'subtitle' => __('Enter your own custom code or using the theme default button.', 'podcaster'),
                'options' => array(
                    'button-theme-default' => 'Default Button',
                    'button-own-code' => 'Custom Code',
                    ),
                'default' => 'button-theme-default'
            ),
            array(
                'id' => 'pod-frontpage-donate-button-custom-code',
                'type' => 'textarea',
                'required' => array(
                    array( 'pod-frontpage-donate-button-type', '=', 'button-own-code' ),
                    array( 'pod-frontpage-donate-active', '=', true ),
                ),
                'title' => __('Donate button (custom code)', 'podcaster'),
                'subtitle' => __('Enter the custom code for your button.', 'podcaster'),
                'placeholder' => '',
                'default' => '',
            ),
            array(
                'id' => 'pod-frontpage-donate-button-text',
                'type' => 'text',
                'required' => array(
                    array( 'pod-frontpage-donate-button-type', '=', 'button-theme-default' ),
                    array( 'pod-frontpage-donate-active', '=', true ),
                ),
                'title' => __('Button text', 'podcaster'),
                'subtitle' => __('Enter the text for your button.', 'podcaster'),
                'default' => 'Donate via Patreon',
            ),
            array(
                'id' => 'pod-frontpage-donate-button-url',
                'type' => 'text',
                'required' => array(
                    array( 'pod-frontpage-donate-button-type', '=', 'button-theme-default' ),
                    array( 'pod-frontpage-donate-active', '=', true ),
                ),
                'title' => __('Button URL', 'podcaster'),
                'subtitle' => __('Enter the URL for your button.', 'podcaster'),
                'validate' => 'url'
            ),
            array(
                'id' => 'pod-frontpage-donate-button-icon',
                'type' => 'select',
                'required' => array(
                    array( 'pod-frontpage-donate-button-type', '=', 'button-theme-default' ),
                    array( 'pod-frontpage-donate-active', '=', true ),
                ),
                'title' => esc_html__('Button icon', "podcaster"),
                'subtitle' => esc_html__('Select an icon for your donate button.', "podcaster"),
                'data'     => 'elusive-icons',
                'options'  => array(
                    'no-icon'   => 'No Icon',
                    'fab fa-amazon'       => 'Amazon',
                    'fab fa-amazon-pay'       => 'Amazon Pay',
                    'fab fa-apple-pay'       => 'Apple',
                    'fab fa-apple-pay'       => 'Apple Pay',
                    'fab fa-bitcoin'       => 'Bitcoin',
                    'fas fa-dollar-sign'       => 'Dollar',
                    'fab fa-ethereum'       => 'Ethereum',
                    'fas fa-euro-sign'       => 'Euro',
                    'fab fa-google-wallet'       => 'Google Wallet',
                    'fab fa-patreon'       => 'Patreon',
                    'fab fa-paypal'       => 'Paypal',
                    'fas fa-pound-sign'       => 'Pound',
                    'fab fa-stripe-s'       => 'Stripe',
                    'fas fa-yen-sign'       => 'Yen',
                ),
                'default' => 'no-icon'
            ),
            array(
                'id'       => 'pod-frontpage-donate-colors-raw',
                'type'     => 'raw',
                'required' => array('pod-frontpage-donate-active', '=', true),
                'title'  => __( '<h3>Colors</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the colors of the donate button section.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-frontpage-donate-background-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-donate-active', '=', true ),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#d7d7d7',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.call-to-action-container .call-to-action-content, .front-page-indigo .call-to-action-container .call-to-action-content, .front-page-blog-template .call-to-action-container .call-to-action-content' )
            ),
            array(
                'id' => 'pod-frontpage-donate-text-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-donate-active', '=', true ),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.front-page-indigo .call-to-action-container .call-to-action-content, .call-to-action-container .call-to-action-content, .front-page-indigo .call-to-action-content h2, .call-to-action-content h2',
                     )
            ),
            array(
                'id' => 'pod-frontpage-donate-button-bg-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-donate-active', '=', true ),
                'title' => __('Button background', 'podcaster'),
                'subtitle' => __('Select a background color for the button.', 'podcaster'),
                'default' => '#2646fb',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.front-page-indigo .call-to-action-container .call-to-action-form .butn, .call-to-action-container .call-to-action-form .butn',
                     )
            ),
            array(
                'id' => 'pod-frontpage-donate-button-text-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-donate-active', '=', true ),
                'title' => __('Button text', 'podcaster'),
                'subtitle' => __('Select a text color for the button.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.front-page-indigo .call-to-action-container .call-to-action-form .butn, .call-to-action-container .call-to-action-form .butn',
                     )
            ),
            array(
                'id' => 'pod-frontpage-donate-button-bg-hover-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-donate-active', '=', true ),
                'title' => __('Button background (hover)', 'podcaster'),
                'subtitle' => __('Select a background color (hover) for the button.', 'podcaster'),
                'default' => '#cccccc',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.front-page-indigo .call-to-action-container .call-to-action-form .butn:hover, .call-to-action-container .call-to-action-form .butn:hover',
                     )
            ),
            array(
                'id' => 'pod-frontpage-donate-button-text-hover-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-donate-active', '=', true ),
                'title' => __('Button text (hover)', 'podcaster'),
                'subtitle' => __('Select a text color (hover) for the button.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.front-page-indigo .call-to-action-container .call-to-action-form .butn:hover, .call-to-action-container .call-to-action-form .butn:hover',
                     )
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Blog excerpts', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the blog posts on the front page. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-blog-excerpts"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-front-page-blog-posts',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-excerpts-style',
                'type' => 'button_set',
                'title' => __('Blog excerpts', 'podcaster'),
                'subtitle' => __('Choose between <strong>List</strong>, <strong>Columns</strong> and <strong>Columns II</strong>.', 'podcaster'),
                'options' => array(
                    'list' => 'List',
                    'columns' => 'Columns I',
                    'columns-2' => 'Columns II',
                    'text-horizontal' => 'Horizontal Text',
                    'image-overlay' => 'Image Overlay',
                    'hide' => 'Hide'
                ),
                'default' => 'list'
            ),
            array(
                'id' => 'pod-excerpts-section-title',
                'type' => 'text',
                'required' => array( 'pod-excerpts-style', '!=', array('hide') ),
                'title' => __('Blog excerpts title', 'podcaster'),
                'subtitle' => __('Enter the title in the text field.', 'podcaster'),
                'default' => 'From the Blog',
            ),
            array(
                'id' => 'pod-excerpts-section-desc',
                'type' => 'text',
                'required' => array( 'pod-excerpts-style', '=', array( 'columns-2') ),
                'title' => __('Blog excerpts description', 'podcaster'),
                'subtitle' => __('Enter the description in the text field.', 'podcaster'),
                'default' => 'Your description here. Vivamus viverra sem nulla, ac sollicitudin ipsum lacinia et. Aliquam vitae neque nec sapien lobortis dapibus non vel augue.',
            ),
            array(
                'id'=>'pod-excerpts-amount',
                'type' => 'spinner',
                'required' => array( 'pod-excerpts-style', '=', array( 'image-overlay', 'text-horizontal') ),
                'title' => __('Amount of posts', 'podcaster'),
                'subtitle' => __('Enter the amount of (posts) to display.', 'podcaster'),
                "default"   => "4",
                "min"       => "1",
                "step"      => "1",
                "max"       => "999"
            ),
            array(
                'id' => 'pod-excerpts-section-button',
                'type' => 'text',
                'required' => array( 'pod-excerpts-style', '=', array( 'list','columns-2', 'text-horizontal', 'image-overlay') ),
                'title' => __('Blog excerpts button', 'podcaster'),
                'subtitle' => __('Enter the text for the button.', 'podcaster'),
                'default' => 'Go to Blog',
            ),
            array(
                'id' => 'pod-excerpts-image-overlay-columns',
                'type' => 'radio',
                'required' => array( 'pod-excerpts-style', '=', array( 'image-overlay') ),
                'title' => __('Columns', 'podcaster'),
                'subtitle' => __('Select the amount of columns for this section.', 'podcaster'),
                'options' => array(
                    'cols-2' => '2 Columns',
                    'cols-3' => '3 Columns',
                    'cols-4' => '4 Columns'
                ),
                'default' => 'cols-4'
            ),
            array(
                'id' => 'pod-excerpts-image-overlay-rounded-borders',
                'type' => 'button_set',
                'required' => array( 'pod-excerpts-style', '=', array( 'image-overlay') ),
                'title' => __('Rounded corners', 'podcaster'),
                'subtitle' => __('Choose between <strong>straight</strong> and <strong>rounded</strong>.', 'podcaster'),
                'options' => array(
                    'straight-borders' => 'Straight',
                    'rounded-borders' => 'Round',
                ),
                'default' => 'straight-borders'
            ),
            /*array(
                'id' => 'pod-blog-excerpts-category',
                'type' => 'select',
                'data' => 'categories',
                'title' => __('Blog categories', 'podcaster'),
                'multi' => true,
                'subtitle' => __('Select categories to display in the blog excerpt section.', 'podcaster'),
            ),*/
            array(
                'id'       => 'pod-frontpage-from-blog-colors-raw',
                'type'     => 'raw',
                'required' => array('pod-excerpts-style', '!=', 'hide'),
                'title'  => __( '<h3>Colors</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the colors of the blog excerpts section.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-advanced-color-from-blog-settings',
                'type' => 'switch',
                'required' => array('pod-excerpts-style', '!=', 'hide'),
                'title' => __('Custom colors', 'podcaster'),
                'subtitle' => __('Activate custom color settings.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-color-secondary-bg',
                'type' => 'color',
                'required' => array('pod-advanced-color-from-blog-settings', '=', true),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#e0e0e0',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.front-page-secondary, footer.main-footer, .fromtheblog.list, .fromtheblog, .newsletter-container, .instagram-footer ',
                    'border-color' => '.fromtheblog.list article .post-header .user_img_link img')
            ),
            array(
                'id' => 'pod-color-from-blog-secondary-bg',
                'type' => 'color',
                'required' => array('pod-advanced-color-from-blog-settings', '=', true),
                'title' => __('Background (hover)', 'podcaster'),
                'subtitle' => __('Select a background color (hover).', 'podcaster'),
                'default' => '#dddddd',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.fromtheblog.list article:hover'
                )
            ),
            array(
                'id' => 'pod-color-text-secondary',
                'type' => 'color',
                'required' => array('pod-advanced-color-from-blog-settings', '=', true),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.fromtheblog h2.title, .fromtheblog.list h2.title, .fromtheblog.list .cont.date, .fromtheblog article .post-header, .fromtheblog article .post-content, .fromtheblog article .post-footer, .fromtheblog .description'
                )
            ),
            array(
                'id' => 'pod-color-link-secondary',
                'type' => 'color',
                'required' => array('pod-advanced-color-from-blog-settings', '=', true),
                'title' => __('Link', 'podcaster'),
                'subtitle' => __('Select a color for the links.', 'podcaster'),
                'default' => '#000000',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.fromtheblog article .post-header ul a:link, .fromtheblog article .post-header ul a:visited, .fromtheblog.list article .post-header span a:link, .fromtheblog.list article .post-header span a:visited, .fromtheblog.list article .post-content .title a:link, .fromtheblog.list article .post-content .title a:visited, .fromtheblog article .post-footer a:link, .fromtheblog article .post-footer a:visited, .fromtheblog article .post-header h2 a:link, .fromtheblog article .post-header h2 a:visited, .fromtheblog.img-overlay article .post-header h2 a:link, .fromtheblog.img-overlay article .post-header h2 a:visited, .fromtheblog.img-overlay article .post-header ul a:link, .fromtheblog.img-overlay article .post-header ul a:visited, .fromtheblog.img-overlay article .post-header .post-permalink, .fromtheblog.horizontal article .post-content a:link, .fromtheblog.horizontal article .post-content a:visited',
                    'border-color' => '.fromtheblog.img-overlay article .post-header .post-permalink'
                )
            ),
            array(
                'id' => 'pod-color-link-hover-secondary',
                'type' => 'color',
                'required' => array('pod-advanced-color-from-blog-settings', '=', true),
                'title' => __('Link (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the links.', 'podcaster'),
                'default' => '#000000',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.fromtheblog article .post-header ul a:hover, .fromtheblog.list article .post-header span a:hover, .fromtheblog.list article .post-content .title a:hover, .fromtheblog article .post-footer a:hover, .fromtheblog article .post-header h2 a:hover, .fromtheblog.img-overlay article .post-header h2 a:hover, .fromtheblog.img-overlay article .post-header ul a:hover, .fromtheblog.img-overlay article .post-header .post-permalink:hover',
                    'border-color' => '.fromtheblog.img-overlay article .post-header .post-permalink:hover, .fromtheblog.horizontal article .post-content .title a:hover'
                )
            ),
            array(
                'id' => 'pod-color-advanced-border-secondary',
                'type' => 'color',
                'required' => array('pod-advanced-color-from-blog-settings', '=', true),
                'title' => __('Borders & icons', 'podcaster'),
                'subtitle' => __('Select a color for borders and icons.', 'podcaster'),
                'default' => '#cccccc',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'border-color' => '.fromtheblog.list article, .fromtheblog.list article:hover, .fromtheblog.horizontal article .post-header, .fromtheblog.horizontal article .post-content')
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Newsletter', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the newsletter form on the front page. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-front-page-newsletter"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-front-page-newsletter',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-frontpage-newsletter-active',
                'type' => 'switch',
                'title' => __('Newsletter section', 'podcaster'),
                'subtitle' => __('Activate the newsletter section.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-frontpage-newsletter-title',
                'type' => 'text',
                'required' => array('pod-frontpage-newsletter-active', '=', true),
                'title' => __('Title', 'podcaster'),
                'subtitle' => __('Enter a title for your section.', 'podcaster'),
                'placeholder' => '',
                'default' => 'Stay in touch. Sign up for our newsletter!',
            ),
            array(
                'id' => 'pod-frontpage-newsletter-blurb',
                'type' => 'text',
                'required' => array('pod-frontpage-newsletter-active', '=', true),
                'title' => __('Blurb', 'podcaster'),
                'subtitle' => __('Enter a blurb for your section.', 'podcaster'),
                'placeholder' => '',
                'default' => 'Get notified about updates and be the first to get early access to new episodes.',
            ),
            array(
                'id'       => 'pod-frontpage-newsletter-padding',
                'type'     => 'spacing',
                'required' => array('pod-frontpage-newsletter-active', '=', true),
                'mode'     => 'padding',
                'all'      => false,
                'top'           => true,     // Disable the top
                'right'         => true,     // Disable the right
                'bottom'        => true,     // Disable the bottom
                'left'          => true,     // Disable the left
                'units'         => 'px',      // You can specify a unit value. Possible: px, em, %
                'display_units' => 'true',   // Set to false to hide the units if the units are specified
                'title'    => __( 'Padding', 'podcaster' ),
                'subtitle' => __( 'Enter the padding for your newsletter section.', 'podcaster' ),
                'default'  => array(
                    'padding-top'    => '72px',
                    'padding-right'  => '42px',
                    'padding-bottom' => '72px',
                    'padding-left'   => '42px'
                )
            ),
            array(
                'id' => 'pod-frontpage-newsletter-type',
                'type' => 'button_set',
                'required' => array('pod-frontpage-newsletter-active', '=', true),
                'title' => __('Newsletter form type', 'podcaster'),
                'subtitle' => __('Choose between entering a shortcode or custom code.', 'podcaster'),
                'options' => array(
                    'newsletter-shortcode' => 'Shortcode',
                    'newsletter-own-code' => 'Custom Code',
                    ),
                'default' => 'newsletter-shortcode'
            ),
            array(
                'id' => 'pod-frontpage-newsletter-shortcode',
                'type' => 'text',
                'required' => array(
                    array( 'pod-frontpage-newsletter-active', '=', true ),
                    array( 'pod-frontpage-newsletter-type', '=', 'newsletter-shortcode' ),
                ),
                'title' => __('Shortcode', 'podcaster'),
                'subtitle' => __('Enter the shortcode for the newsletter form.', 'podcaster'),
            ),
            array(
                'id' => 'pod-frontpage-newsletter-custom-code',
                'type' => 'textarea',
                'required' => array(
                    array( 'pod-frontpage-newsletter-active', '=', true ),
                    array( 'pod-frontpage-newsletter-type', '=', 'newsletter-own-code' ),
                ),
                'title' => __('Newsletter form (custom code)', 'podcaster'),
                'subtitle' => __('Enter the custom code for the newsletter form.', 'podcaster'),
                'placeholder' => '',
                'default' => '',
            ),
            array(
                'id'       => 'pod-frontpage-newsletter-colors-raw',
                'type'     => 'raw',
                'required' => array( 'pod-frontpage-newsletter-active', '=', true ),
                'title'  => '<h3>' . __( 'Colors', 'podcaster' ) . '</h3>',
                'content'  => __( 'The settings below are for the colors of the newsletter section.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-frontpage-newsletter-background-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-newsletter-active', '=', true ),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#2646fb',
                'validate' => 'color',
                'transparent' => true,
                'output'    => array(
                    'background-color' => '.newsletter-container .newsletter-content' )
            ),
            array(
                'id' => 'pod-frontpage-newsletter-text-color',
                'type' => 'color',
                'required' => array( 'pod-frontpage-newsletter-active', '=', true ),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.newsletter-container .newsletter-content, .newsletter-content h2, .newsletter-container .newsletter-form input[type="email"], .newsletter-container .newsletter-form input[type="text"], .newsletter-container .newsletter-form input[type="submit"]',
                    
                    'border-color' => '.newsletter-container .newsletter-form, .newsletter-container .newsletter-form .mc4wp-form .mc4wp-form-fields p.nl-name, .newsletter-container .newsletter-form .mc4wp-form .mc4wp-form-fields p.nl-email',
                     )
            ),

        )
    ) );
	Redux::setSection( $opt_name, array(
        'icon' => 'fas fa-mouse-pointer',
        'title' => __('Navigation', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the navigation menu. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-navigation"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'fields' => array(
            array(
                'id'       => 'pod-nav-bg-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Background</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the background of the navigation.', 'podcaster' ),
            ),
        	array(
                'id'=>'pod-nav-bg',
                'type' => 'color',
                'title' => __('Navigation background', 'podcaster'),
                'subtitle' => __('Select a color for the background of the navigation menu.', 'podcaster'),
                'default' => '#282d31',
                'output' => array(
                    'background' => '.above'
                )
            ),
            array(
                'id'=>'pod-nav-bg-if-transparent',
                'type' => 'color',
                'required' => array('pod-nav-bg', '=', 'transparent'),
                'title' => __('Navigation background (no header image) ', 'podcaster'),
                'subtitle' => __('Select an alternative color for the background of the navigation.', 'podcaster'),
                'default' => '#349099',
                'transparent'   => false,
                'output' => array(
                    'background' => '.above.nav-transparent:not(.has-featured-image).nav-not-sticky, .above.nav-transparent:not(.has-featured-image).large_nav'
                )
            ),
            array(
                'id'       => 'pod-nav-links-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Menu & links</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for links links.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-nav-color',
                'type'     => 'color',
                'title'    => __('Links', 'podcaster'),
                'subtitle' => __('Select a color for the links.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.nav-search-form .search-form-drop',
                    'color' => '.above header .main-title a:link, .above header .main-title a:visited, .nav-search-form .open-search-bar .fa, .above #nav .thst-menu > li > a, .dark-icons .above .social_icon:before, .light-icons .above .social_icon:before, header .main-title a:link, header .main-title a:visited, .open-menu:link, .open-menu:visited',
                    'border-bottom-color' => '.nav-search-form .search-form-drop:after',
                    'fill' => '.dark-icons .above .svg_icon_cont svg, .light-icons .above .svg_icon_cont svg'
                    )
            ),
            array(
                'id'       => 'pod-nav-hover-color',
                'type'     => 'color',
                'title'    => __('Links (hover)', 'podcaster'),
                'subtitle' => __('Select a color for the links (hover).', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array(
                    'color' => '.above header .main-title a:hover, .nav-search-form .open-search-bar:hover .fa, .above #nav .thst-menu > li > a:hover, header .main-title a:hover, .open-menu:hover, .page:not(.pod-is-podcast-archive) .above.has-featured-image.nav-not-sticky.nav-transparent .nav-search-form .open-search-bar:hover .fa, .above .email.social_icon:hover::before',
                    )
            ),
            array(
                'id'       => 'pod-nav-hover-bg-color',
                'type'     => 'color_rgba',
                'title'    => __('Link background (hover)', 'podcaster'),
                'subtitle' => __('Select a color for the links (hover).', 'podcaster'),
                'default'   => array(
                    'color'     => '#000000',
                    'alpha'     => 0.05
                ),
                'transparent' => false,
               
            ),
            array(
                'id'       => 'pod-nav-links-drop-down-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Drop-down menu</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the drop down menu.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-nav-dropdown-color',
                'type'     => 'color',
                'title'    => __('Drop-down link (text)', 'podcaster'),
                'subtitle' => __('Select a color for the links in the drop down menu.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array(
                    'color' => '#nav.responsive-menu-inactive .thst-menu li > .sub-menu li a:link, #nav.responsive-menu-inactive .thst-menu li > .sub-menu li a:visited, #nav.responsive-menu-inactive.toggle .thst-menu li > .sub-menu li a:link, #nav.responsive-menu-inactive.toggle .thst-menu li > .sub-menu li a:visited',
                    )
            ),
            array(
                'id'       => 'pod-nav-dropdown',
                'type'     => 'color',
                'title'    => __('Drop-down menu (background)', 'podcaster'),
                'subtitle' => __('Select a color for the background in the drop down menu.', 'podcaster'),
                'default' => '#333',
                'output'   => array('background-color' => '#nav .thst-menu li > .sub-menu li a:link, #nav .thst-menu li > .sub-menu li a:visited'),
                'transparent' => false,
            ),
            array(
                'id'       => 'pod-nav-dropdown-hover-color',
                'type'     => 'color',
                'title'    => __('Drop-down link hover (text)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the links in the drop down menu.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array(
                    'color' => '#nav.responsive-menu-inactive .thst-menu li:hover > .sub-menu li a:hover, #nav.responsive-menu-inactive.toggle .thst-menu li:hover > .sub-menu li a:hover',

                    )
            ),
            array(
                'id'       => 'pod-nav-dropdown-hover',
                'type'     => 'color',
                'title'    => __('Drop-down menu hover (background)', 'podcaster'),
                'subtitle' => __('Select a background color (hover) for the drop down menu.', 'podcaster'),
                'default' => '#262626',
                'output'   => array('background-color' => '#nav .thst-menu li > .sub-menu li a:hover'),
                'transparent' => false,
            ),

            array(
                'id'       => 'pod-nav-transparency-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Transparent menu</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the transparent menu.', 'podcaster' ),
            ),
            array(
                'id'        => 'pod-nav-bg-transparent-color',
                'type'      => 'color_rgba',
                'required' => array('pod-nav-bg', '=', 'transparent'),
                'title'     => 'Navigation background (transparent)',
                'subtitle'  => 'Select a background color and transparency for the navigation menu.',
                'transparent' => false,
                'default'   => array(
                    'color'     => '#000000',
                    'alpha'     => 0.15
                ),
            ),
            array(
                'id'       => 'pod-nav-bg-transparent-links',
                'type'     => 'color',
                'title'    => __('Links', 'podcaster'),
                'subtitle' => __('Select a color for the links in the transparent navigation menu.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array(
                    'color' => ' .above.nav-transparent.has-featured-image.nav-not-sticky header .main-title a:link, .above.nav-transparent.has-featured-image.nav-not-sticky header .main-title a:visited, .above.nav-transparent.has-featured-image.large_nav header .main-title a:link, .above.nav-transparent.has-featured-image.large_nav header .main-title a:visited, .above.nav-transparent.has-featured-image.nav-not-sticky #nav .thst-menu > li > a:link, .above.nav-transparent.has-featured-image.nav-not-sticky #nav .thst-menu > li > a:visited, .above.nav-transparent.has-featured-image.large_nav #nav .thst-menu > li > a:link, .above.nav-transparent.has-featured-image.large_nav #nav .thst-menu > li > a:visited, .above.nav-transparent.has-featured-image.nav-not-sticky .nav-search-form .open-search-bar .fa, .above.nav-transparent.has-featured-image.large_nav .nav-search-form .open-search-bar .fa, .dark-icons .above.nav-transparent.has-featured-image.nav-not-sticky .social_icon:before, .dark-icons .above.nav-transparent.has-featured-image.large_nav .social_icon:before, .light-icons .above.nav-transparent.has-featured-image.nav-not-sticky .social_icon:before, .light-icons .above.nav-transparent.has-featured-image.large_nav .social_icon:before',
                    'fill' => '.dark-icons .above.nav-transparent.has-featured-image.large_nav .svg_icon_cont svg, .light-icons .above.nav-transparent.has-featured-image.large_nav .svg_icon_cont svg, .dark-icons .above.nav-transparent.has-featured-image.nav-not-sticky .svg_icon_cont svg, .light-icons .above.nav-transparent.has-featured-image.nav-not-sticky .svg_icon_cont svg'
                ),
            ),
            array(
                'id'       => 'pod-nav-bg-transparent-hover',
                'type'     => 'color',
                'title'    => __('Link (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the links in the transparent navigation menu.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array(
                    'color' => '.above.nav-transparent.has-featured-image.nav-not-sticky header .main-title a:hover, .above.nav-transparent.has-featured-image.large_nav header .main-title a:hover, .above.nav-transparent.has-featured-image.nav-not-sticky #nav .thst-menu > li > a:hover, .above.nav-transparent.has-featured-image.nav-not-sticky .nav-search-form .open-search-bar .fa:hover, .above.nav-transparent.has-featured-image.nav-not-sticky .email.social_icon:hover::before, .above.nav-transparent.has-featured-image.large_nav #nav .thst-menu > li > a:hover, .above.nav-transparent.has-featured-image.large_nav .nav-search-form .open-search-bar .fa:hover, .above.nav-transparent.has-featured-image.large_nav .email.social_icon:hover::before')
            ),
            array(
                'id'       => 'pod-nav-sticky-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Sticky menu</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the sticky menu.', 'podcaster' ),
            ),
            array(
				'id'=>'pod-sticky-header',
				'type' => 'switch',
				'title' => __('Sticky navigation', 'podcaster'),
				'subtitle' => __('Activate sticky navigation.', 'podcaster'),
				'default' => false,
			),
            array(
                'id'       => 'pod-nav-bg-sticky',
                'type'     => 'color',
                'required' => array('pod-sticky-header', '=', true),
                'title'    => __('Background', 'podcaster'),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#81F9AC',
                'transparent' => false,
                'output' => array(
                    'background-color' => '.small_nav .nav-search-form .open-search-bar .fa, .above.small_nav, .above.small_nav.nav-sticky',
                    'color'            => '.small_nav .nav-search-form .search-container #s-nav'
                    )
            ),
            array(
                'id'       => 'pod-nav-color-sticky',
                'type'     => 'color',
                'required' => array('pod-sticky-header', '=', true),
                'title'    => __('Links', 'podcaster'),
                'subtitle' => __('Select a color for the links.', 'podcaster'),
                'default' => '#222',
                'transparent' => false,
                'output' => array(
                    'color' => '.small_nav .nav-search-form .open-search-bar .fa, .above.small_nav #nav .thst-menu li a, .above.small_nav header .main-title a:link, .above.small_nav header .main-title a:visited, .above.small_nav:not(.has-featured-image) header .main-title a:link, .above.small_nav:not(.has-featured-image) header .main-title a:visited, .dark-icons .above.small_nav .social_icon::before, .light-icons .above.small_nav .social_icon::before',
                    'background-color' => '.small_nav .nav-search-form .search-form-drop',
                    'border-bottom-color' => '.small_nav .nav-search-form .search-form-drop:after',

                    'fill' => '.dark-icons .above.small_nav .svg_icon_cont svg, .light-icons .above.small_nav .svg_icon_cont svg,
                    .dark-icons .above.nav-transparent.has-featured-image.small_nav .svg_icon_cont svg, .light-icons .above.nav-transparent.has-featured-image.small_nav .svg_icon_cont svg'
                )
            ),
            array(
                'id'       => 'pod-nav-search-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Search</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the search bar.', 'podcaster' ),
            ),
            array(
                'id'=>'pod-nav-search',
                'type' => 'switch',
                'title' => __('Search bar', 'podcaster'),
                'subtitle' => __('Would you like to display a search bar in your navigation?', 'podcaster'),
                'default' => false,
            ),
            array(
                'id'    => 'pod-nav-search-style',
                'type'        => 'button_set',
                'required' => array( 'pod-nav-search', '=', true ),
                'title'       => __( 'Style', 'podcaster' ),
                'subtitle' => __( 'Select a style of search bar to use.', 'podcaster' ),
                'default'     => 'search-style-mini',
                'options'     => array(
                    'search-style-mini' => esc_html__( 'Mini', 'podcaster' ), 
                    'search-style-medium' => esc_html__( 'Horizontal', 'podcaster' ), 
                ),
            ),
            array(
                'id'=>'pod-nav-search-color',
                'type' => 'color',
                'required'  => array( 'pod-nav-search', '=', true ),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text', 'podcaster'),
                'default' => '#282d31',
                'transparent' => false,
                'output' => array(
                    'color' => '.nav-search-form .search-container #s-nav'
                )
            ),
            array(
                'id' => 'pod-nav-search-bg-color',
                'type' => 'color_rgba',
                'required' => array( 'pod-nav-search', '=', true ),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a color for the text', 'podcaster'),
                'default'   => array(
                    'color'     => '#ffffff',
                    'alpha'     => 0.95
                ),
                'output' => array(
                    'background' => '.nav-search-form.search-style-medium .search-form-drop, .nav-search-form .search-form-drop',
                    'border-bottom-color' => '.nav-search-form .search-form-drop::after',
                ),
            ),
            array(
                'id' => 'pod-nav-search-border-color',
                'type' => 'color',
                'required' => array(
                    array( 'pod-nav-search', '=', true ),
                    array( 'pod-nav-search-style', '=', 'search-style-medium' ),
                ),
                'title' => __('Border', 'podcaster'),
                'subtitle' => __('Select a color for the text', 'podcaster'),
                'default' => '#eeeeee',
                'transparent' => false,
                'output' => array(
                    'border-color' => '.nav-search-form.search-style-medium .search-form-drop',
                ),
            ),
            array(
                'id'       => 'pod-nav-responsive-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Responsive</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the responsive menu.', 'podcaster' ),
            ),
			array(
				'id'=>'pod-responsive-style',
				'type' => 'button_set',
				'title' => __('Responsive menu style', 'podcaster'),
				'subtitle' => __('Choose between drop-down (recommended for few menu elements) and toggle (recommended for many menu elements and multi-level navigation).', 'podcaster'),
				'options' => array(
            		'drop' => 'Drop-down',
            		'toggle' => 'Toggle',
            		),
            	'default' => 'toggle'
            ),
            array(
                'id'       => 'pod-nav-responsive-colors-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Responsive Colors</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for colors of the responsive menu.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-nav-responsive-custom-color-settings',
                'type' => 'switch',
                'title' => __('Custom colors', 'podcaster'),
                'subtitle' => __('Activate custom color settings.', 'podcaster'),
                'default' => false
            ),
            array(
                'id'       => 'pod-nav-responsive-hamburger-search-bg',
                'type'     => 'color',
                'required' => array('pod-nav-responsive-custom-color-settings', '=', true),
                'title'    => __('Hamburger & search background', 'podcaster'),
                'subtitle' => __('Select a background color for the hamburger search buttons.', 'podcaster'),
                'default' => '#0b0d0d',
                'transparent' => false,
            ),
            array(
                'id'       => 'pod-nav-responsive-hamburger-search',
                'type'     => 'color',
                'required' => array('pod-nav-responsive-custom-color-settings', '=', true),
                'title'    => __('Hamburger & search icon', 'podcaster'),
                'subtitle' => __('Select a color for the hamburger search buttons.', 'podcaster'),
                'default' => '#fafafa',
                'transparent' => false,
            ),

            array(
                'id'       => 'pod-nav-responsive-hamburger-search-hover',
                'type'     => 'color',
                'required' => array('pod-nav-responsive-custom-color-settings', '=', true),
                'title'    => __('Hamburger & search icon (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the hamburger search buttons.', 'podcaster'),
                'default' => '#199fdd',
                'transparent' => false,
            ),

            array(
                'id'       => 'pod-nav-responsive-social-media-bg',
                'type'     => 'color',
                'required' => array('pod-nav-responsive-custom-color-settings', '=', true),
                'title'    => __('Social media menu background', 'podcaster'),
                'subtitle' => __('Select a background for the responsive social media menu.', 'podcaster'),
                'default' => '#424545',
                'transparent' => false,
            ),
            array(
                'id'       => 'pod-nav-responsive-social-media-links',
                'type'     => 'color',
                'required' => array('pod-nav-responsive-custom-color-settings', '=', true),
                'title'    => __('Social media icons', 'podcaster'),
                'subtitle' => __('Select a color for the social media icons.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
            ),

            array(
                'id'       => 'pod-nav-responsive-social-media-hover',
                'type'     => 'color',
                'required' => array('pod-nav-responsive-custom-color-settings', '=', true),
                'title'    => __('Social media icon (email)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the email icon.', 'podcaster'),
                'default' => '#199fdd',
                'transparent' => false,
            ),


            
        )
    ) );
    Redux::setSection( $opt_name, array(
        'icon' => 'fas fa-signature',
        'title' => __('Logo', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the website logo. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-logo"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'fields' => array(
        	array(
                'id' => 'pod-upload-logo',
                'type' => 'media',
                'title' => __('Your Logo', 'podcaster'),
                'subtitle' => __('Upload an image which will be displayed as a logo in your header.', 'podcaster'),
                'default' => $theme_options_img.'/img/logo.png',
                'url' => false
            ),
            array(
                'id'=>'pod-logo-max-height',
                'type' => 'spinner',
                'title' => __('Max height', 'podcaster'),
                'subtitle' => 'Enter the maximum height of your logo. (Max 110px)',
                "default"   => "90",
                "min"       => "0",
                "step"      => "1",
                "max"       => "110",
                'output'    => array('max-height' => '.above .logo.with-img img'),
            ),
            array(
                'id'=>'pod-logo-max-width',
                'type' => 'spinner',
                'title' => __('Max width', 'podcaster'),
                'subtitle' => 'Enter the maximum width of your logo.(Max 320px)',
                "default"   => "260",
                "min"       => "0",
                "step"      => "1",
                "max"       => "320",
                'output'    => array('max-width' => '.above .logo.with-img img'),
            ),
            array(
                'id' => 'pod-upload-logo-sticky',
                'type' => 'media',
                'title' => __('Your Logo (Sticky)', 'podcaster'),
                'subtitle' => __('Upload an image which will be displayed as a logo in your header when it is in sticky mode.', 'podcaster'),
                'default' => $theme_options_img.'/img/logo-sticky.png',
                'url' => false
            ),
            array(
                'id'=>'pod-logo-sticky-max-height',
                'type' => 'spinner',
                'title' => __('Max height (sticky menu)', 'podcaster'),
                'subtitle' => 'Enter the maximum height of your logo. (Max 80px)',
                "default"   => "70",
                "min"       => "0",
                "step"      => "1",
                "max"       => "80",
            ),
            array(
                'id'=>'pod-logo-sticky-max-width',
                'type' => 'spinner',
                'title' => __('Max width (sticky menu)', 'podcaster'),
                'subtitle' => 'Enter the maximum width of your logo.(Max 160px)',
                "default"   => "130",
                "min"       => "0",
                "step"      => "1",
                "max"       => "160",
            ),
            array(
                'id' => 'pod-upload-logo-ret',
                'type' => 'media',
                'title' => __('Your Logo (Retina Size)', 'podcaster'),
                'subtitle' => __('Upload an image which will be displayed as a logo in your header. Make sure it\'s exactly double the size of the original.', 'podcaster'),
                'default' => $theme_options_img.'/img/logo.png',
                'url' => false
            ),
            /*array(
                'id' => 'pod-upload-logo-ret-sticky',
                'type' => 'media',
                'title' => __('Your Logo (Sticky, Retina Size)', 'podcaster'),
                'subtitle' => __('Upload an image which will be displayed as a logo in your header when it is in sticky mode. Make sure it\'s exactly double the size of the original.', 'podcaster'),
                'default' => $theme_options_img.'/img/logo.png'
            ),*/
            array(
                'id'=>'pod-logo-responsive-max-height',
                'type' => 'spinner',
                'title' => __('Max height (responsive menu)', 'podcaster'),
                'subtitle' => 'Enter the maximum height of your logo. (Max 60px)',
                "default"   => "50",
                "min"       => "0",
                "step"      => "1",
                "max"       => "60",
            ),
            array(
                'id'=>'pod-logo-responsive-max-width',
                'type' => 'spinner',
                'title' => __('Max width (responsive menu)', 'podcaster'),
                'subtitle' => 'Enter the maximum width of your logo.(Max 230px)',
                "default"   => "150",
                "min"       => "0",
                "step"      => "1",
                "max"       => "230",
            ),
        )
    ) );
	Redux::setSection( $opt_name, array(
        'icon' => 'fa fa-font',
        'title' => __('Type &amp; Direction', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the website typography. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-type"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('General', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize general font settings.</p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
        	array(
                'id' => 'pod-typography',
                'type' => 'radio',
                'title' => __('Typography', 'podcaster'),
                'subtitle' => __('Select the type of fonts you would like to use.', 'podcaster'),

                'options' => array(
                	'sans-serif' => 'Sans-serif',
                	'serif' => 'Serif',
                    'custom' => 'Google Fonts',
                    'custom-typekit' => 'Typekit'
                ),
                'default' => 'sans-serif'
            ),
            array(
                'id' => 'pod-reading-direction',
                'type' => 'switch',
                'title' => __('Right to left', 'podcaster'),
                'subtitle' => __('Activate right to left reading?', 'podcaster'),
                'default' => false

            ),
            array(
                'id'=>'pod-typekit-code',
                'type' => 'textarea',
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'title' => __('Adobe Fonts/Typekit', 'podcaster'),
                'subtitle' => __('Paste the code you received from Adobe Fonts/Typekit in the text box.', 'podcaster'),
                'default' => '',
            ),
            array(
                'id'       => 'pod-typekit-css-code',
                'type'     => 'ace_editor',
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'title'    => __('Adobe Fonts/Typekit CSS Code', 'podcaster'),
                'subtitle' => __('Use the text box to insert CSS overrides.', 'podcaster'),
                'mode'     => 'css',
                'theme'    => 'chrome',
                'default'  => "#header{\nmargin: 0 auto;\n}"
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Basics', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize basic font settings.</p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-type-page-header-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-typography', '=', array('sans-serif', 'serif')),
                'desc'  => __( 'Please select "Google Fonts" or "Typekit" to activate these settings.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-type-global-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>General Font Settings</h3>', 'podcaster' ),
                'required' => array('pod-typography', '=', array('custom', 'custom-typekit') ),
                'content'  => __( 'The settings below are font settings for the entire website.', 'podcaster' ),
            ),
            array(
                'id'          => 'pod-typo-headings',
                'type'        => 'typography',
                'title'       => __('Heading Font', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => false,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your headings.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '33px',
                ),
            ),
            array(
                'id'          => 'pod-typo-text',
                'type'        => 'typography',
                'title'       => __('Text Font', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => false,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your paragraphs.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '18px',
                ),
            ),
            array(
                'id'          => 'pod-typo-headings-typek',
                'type'        => 'typography_input',
                'title'       => __('Heading Font', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => false,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your headings.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family' => 'Raleway',
                    'font-size'   => '33px',
                ),
            ),
            array(
                'id'          => 'pod-typo-text-typek',
                'type'        => 'typography_input',
                'title'       => __('Text Font', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => false,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your paragraphs.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'font-size'   => '18px',
                ),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Site title & Menu', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize font settings for the site title & menu.</p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-type-site-menu-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-typography', '=', array('sans-serif', 'serif')),
                'desc'  => __( 'Please select "Google Fonts" or "Typekit" to activate these settings.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-type-menu-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Site title &amp; Menu</h3>', 'podcaster' ),
                'required' => array('pod-typography', '=', array('custom', 'custom-typekit')),
                'content'  => __( 'The settings below are font settings for the title and navigation menu.', 'podcaster' ),
            ),
            array(
                'id'          => 'pod-typo-main-heading',
                'type'        => 'typography',
                'title'       => __('Main Heading Font', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => false,
                'font-size'   => false,
                'text-align'  => false,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your site title.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'google'      => true,
                ),
            ),
            array(
                'id'          => 'pod-typo-menu-links',
                'type'        => 'typography',
                'title'       => __('Menu Font', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => false,
                'font-size'   => false,
                'color'       => false,
                'text-align'  => false,
                'text-transform' => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your menu.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family' => 'Raleway',
                    'google'      => true,
                ),
            ),
            array(
                'id'          => 'pod-typo-main-heading-typek',
                'type'        => 'typography_input',
                'title'       => __('Main Heading Font', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => false,
                'font-size'   => false,
                'text-align'  => false,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your site title.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                ),
            ),
            array(
                'id'          => 'pod-typo-menu-links-typek',
                'type'        => 'typography_input',
                'title'       => __('Menu Font', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => false,
                'font-size'   => false,
                'color'       => false,
                'text-align'  => false,
                'text-transform' => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your menu.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family' => 'Raleway',
                ),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title' => __('Front page header', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize font settings for the featured header.</p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-type-front-page-header-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-typography', '=', array('sans-serif', 'serif')),
                'desc'  => __( 'Please select "Google Fonts" or "Typekit" to activate these settings.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-type-heading-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Front page header</h3>', 'podcaster' ),
                'required' => array('pod-typography', '=', array('custom', 'custom-typekit')),
                'content'  => __( 'The settings below are for the fonts on your featured header on the front page.', 'podcaster' ),
            ),
            array(
                'id'          => 'pod-typo-featured-heading',
                'type'        => 'typography',
                'title'       => __('Featured Header Title', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'text-align'  => false,
                'text-transform' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your heading.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family' => 'Playfair Display',
                    'google'      => true,
                    'font-size'   => '42px',
                    'line-height' => '50px'
                ),
            ),
            array(
                'id'          => 'pod-typo-featured-text',
                'type'        => 'typography',
                'title'       => __('Featured Header Text', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => false,
                'color'       => false,
                'text-align'  => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '16px',
                ),
            ),
            array(
                'id'          => 'pod-typo-featured-mini-title',
                'type'        => 'typography',
                'title'       => __('Featured Header Mini Title', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'text-align'  => false,
                'text-transform' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the mini title.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '700',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '14px',
                    'line-height' => '24px'
                ),
            ),
            array(
                'id'          => 'pod-typo-featured-scheduled-mini-title',
                'type'        => 'typography',
                'title'       => __('Scheduled Mini Title', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'text-align'  => false,
                'text-transform' => true,
                'letter-spacing' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the scheduled mini title.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '12px',
                    'line-height' => '24px',
                    'text-transform' => 'uppercase',
                    'letter-spacing' => '2px',
                ),
            ),
            array(
                'id'          => 'pod-typo-featured-scheduled-heading',
                'type'        => 'typography',
                'title'       => __('Scheduled Heading', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'text-align'  => false,
                'text-transform' => false,
                'letter-spacing' => false,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the scheduld heading.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '18px',
                    'line-height' => '32px',
                    'text-transform' => 'uppercase',
                    'letter-spacing' => '2px',
                ),
            ),
            array(
                'id'          => 'pod-typo-featured-heading-typek',
                'type'        => 'typography_input',
                'title'       => __('Featured Header Title', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'text-align'  => false,
                'text-transform' => true,
                
                'units'       =>'px',
                'subtitle'    => __('Set the font for your heading.', 'podcaster'),
                'default'     => array(
                    'color'       => '#ffffff',
                    'font-weight'  => '600',
                    'font-family' => 'Playfair Display',
                    'font-size'   => '42px',
                    'line-height' => '50px'
                ),
            ),
            array(
                'id'          => 'pod-typo-featured-text-typek',
                'type'        => 'typography_input',
                'title'       => __('Featured Header Text', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => false,
                'color'       => false,
                'text-align'  => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'font-size'   => '16px',
                ),
            ),
            array(
                'id'          => 'pod-typo-featured-mini-title-typek',
                'type'        => 'typography_input',
                'title'       => __('Featured Header Mini Title', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'text-align'  => false,
                'text-transform' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the mini title.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '700',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '14px',
                    'line-height' => '24px'
                ),
            ),
            array(
                'id'          => 'pod-typo-featured-scheduled-mini-title-typek',
                'type'        => 'typography_input',
                'title'       => __('Scheduled Mini Title', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'text-align'  => false,
                'text-transform' => true,
                'letter-spacing' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the scheduled mini title.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '12px',
                    'line-height' => '24px',
                    'text-transform' => 'uppercase',
                    'letter-spacing' => '2px',
                ),
            ),
            array(
                'id'          => 'pod-typo-featured-scheduled-heading-typek',
                'type'        => 'typography_input',
                'title'       => __('Scheduled Heading', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'text-align'  => false,
                'text-transform' => false,
                'letter-spacing' => false,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the scheduld heading.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '18px',
                    'line-height' => '32px',
                    'text-transform' => 'uppercase',
                    'letter-spacing' => '2px',
                ),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title' => __('Front page episodes', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize general font settings.</p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-type-front-page-episodes-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-typography', '=', array('sans-serif', 'serif')),
                'desc'  => __( 'Please select "Google Fonts" or "Typekit" to activate these settings.', 'podcaster' ),
            ),
            array(
                'id'          => 'pod-typo-frontpage-heading',
                'type'        => 'typography',
                'title'       => __('Headings', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your headings.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '700',
                    'font-family'  => 'Raleway',
                    'google'       => true,
                    'font-size'    => '32px',
                    'line-height'  => '40px'
                ),
            ),
            array(
                'id'          => 'pod-typo-frontpage-text',
                'type'        => 'typography',
                'title'       => __('Text', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
            array(
                'id'          => 'pod-typo-frontpage-cats',
                'type'        => 'typography',
                'title'       => __('Categories', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'text-transform' => true,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the categories.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '700',
                    'font-family' => 'Raleway',
                    'font-size'   => '13px',
                    'line-height' => '24px',
                    'text-transform' => 'uppercase',
                ),
            ),
            array(
                'id'          => 'pod-typo-frontpage-read-more',
                'type'        => 'typography',
                'title'       => __('Read more link', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the read more link.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '700',
                    'font-family' => 'Raleway',
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
            array(
                'id'          => 'pod-typo-frontpage-heading-typek',
                'type'        => 'typography_input',
                'title'       => __('Headings', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your headings.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '700',
                    'font-family'  => 'Raleway',
                    'font-size'    => '32px',
                    'line-height'  => '40px'
                ),
            ),
            array(
                'id'          => 'pod-typo-frontpage-text-typek',
                'type'        => 'typography_input',
                'title'       => __('Text', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
            array(
                'id'          => 'pod-typo-frontpage-cats-typek',
                'type'        => 'typography_input',
                'title'       => __('Categories', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'text-transform' => true,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the categories.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '700',
                    'font-family' => 'Raleway',
                    'font-size'   => '18px',
                    'line-height' => '32px',
                    'text-transform' => 'uppercase',
                ),
            ),
            array(
                'id'          => 'pod-typo-frontpage-read-more-typek',
                'type'        => 'typography_input',
                'title'       => __('Read more link', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the read more link.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '700',
                    'font-family' => 'Raleway',
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title' => __('Single posts', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize font settings for single posts.</p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-type-single-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-typography', '=', array('sans-serif', 'serif')),
                'desc'  => __( 'Please select "Google Fonts" or "Typekit" to activate these settings.', 'podcaster' ),
            ),
            array(
                'id'          => 'pod-typo-single-heading',
                'type'        => 'typography',
                'title'       => __('Headings', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your headings.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family'  => 'Raleway',
                    'google'       => true,
                    'font-size'    => '42px',
                    'line-height'  => '56px'
                ),
            ),
            array(
                'id'          => 'pod-typo-single-text',
                'type'        => 'typography',
                'title'       => __('Text', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
            array(
                'id'          => 'pod-typo-single-heading-typek',
                'type'        => 'typography_input',
                'title'       => __('Headings', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your headings.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family'  => 'Raleway',
                    'font-size'    => '42px',
                    'line-height'  => '56px'
                ),
            ),
            array(
                'id'          => 'pod-typo-single-text-typek',
                'type'        => 'typography_input',
                'title'       => __('Text', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title' => __('Pages', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize font settings for pages.</p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-type-pages-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-typography', '=', array('sans-serif', 'serif')),
                'desc'  => __( 'Please select "Google Fonts" or "Typekit" to activate these settings.', 'podcaster' ),
            ),
            array(
                'id'          => 'pod-typo-page-heading',
                'type'        => 'typography',
                'title'       => __('Headings', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'text-align'  => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your headings.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family'  => 'Raleway',
                    'google'       => true,
                    'font-size'    => '42px',
                    'line-height'  => '54px'
                ),
            ),
            array(
                'id'          => 'pod-typo-page-text',
                'type'        => 'typography',
                'title'       => __('Text', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'text-align'  => false,
               'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
            array(
                'id'          => 'pod-typo-page-heading-typek',
                'type'        => 'typography_input',
                'title'       => __('Headings', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'text-align'  => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your headings.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family'  => 'Raleway',
                    'font-size'    => '42px',
                    'line-height'  => '54px'
                ),
            ),
            array(
                'id'          => 'pod-typo-page-text-typek',
                'type'        => 'typography_input',
                'title'       => __('Text', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'text-align'  => false,
               'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Blog header', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize font settings for the blog header.</p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-type-blog-header-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-typography', '=', array('sans-serif', 'serif')),
                'desc'  => __( 'Please select "Google Fonts" or "Typekit" to activate these settings.', 'podcaster' ),
            ),
            array(
                'id'          => 'pod-typo-blog-heading',
                'type'        => 'typography',
                'title'       => __('Headings', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'font-size'   => true,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your heading.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family'  => 'Raleway',
                    'google'       => true,
                    'font-size'   => '42px',
                    'line-height' => '54px'
                ),
            ),
            array(
                'id'          => 'pod-typo-blog-text',
                'type'        => 'typography',
                'title'       => __('Blurb', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'google'      => true,
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
            array(
                'id'          => 'pod-typo-blog-heading-typek',
                'type'        => 'typography_input',
                'title'       => __('Headings', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'font-size'   => true,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for your heading.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family'  => 'Raleway',
                    'font-size'   => '42px',
                    'line-height' => '54px'
                ),
            ),
            array(
                'id'          => 'pod-typo-blog-text-typek',
                'type'        => 'typography_input',
                'title'       => __('Blurb', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'line-height' => true,
                'color'       => false,
                'units'       =>'px',
                'subtitle'    => __('Set the font for the rest of the text, including excerpts.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '400',
                    'font-family' => 'Raleway',
                    'font-size'   => '18px',
                    'line-height' => '32px'
                ),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Buttons', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize font settings for buttons.</p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-type-buttons-hidden',
                'type'  => 'info',
                'style' => 'info',
                'required' => array('pod-typography', '=', array('sans-serif', 'serif')),
                'desc'  => __( 'Please select "Google Fonts" or "Typekit" to activate these settings.', 'podcaster' ),
            ),
            array(
                'id'          => 'pod-typo-buttons',
                'type'        => 'typography',
                'title'       => __('Buttons', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom'),
                'google'      => true,
                'font-backup' => false,
                'font-size'   => false,
                'line-height' => false,
                'color'       => false,
                'text-align'  => false,
                'output'      => array('input[type="submit"], .form-submit #submit, #respond #commentform #submit, a.butn:link, a.butn:visited, .error404 .entry-content a.butn:link, .error404 .entry-content a.butn:visited, .butn, a.thst-button, a.thst-button:visited, #respond #cancel-comment-reply-link:link, #respond #cancel-comment-reply-link:visited, #comments .commentlist li .comment-body .reply a:link, #comments .commentlist li .comment-body .reply a:visited, .wp-block-button__link, .wp-block-file__button, .pod_loadmore'),
                'units'       =>'px',
                'subtitle'    => __('Set the font for your buttons.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family'  => 'Raleway',
                    'google'       => true,
                ),
            ),
            array(
                'id'          => 'pod-typo-buttons-typek',
                'type'        => 'typography_input',
                'title'       => __('Buttons', 'podcaster'),
                'required' => array('pod-typography', '=', 'custom-typekit'),
                'font-backup' => false,
                'font-size'   => false,
                'line-height' => false,
                'color'       => false,
                'text-align'  => false,
                'output'      => array('input[type="submit"], .form-submit #submit, #respond #commentform #submit, a.butn:link, a.butn:visited, .error404 .entry-content a.butn:link, .error404 .entry-content a.butn:visited, .butn, a.thst-button, a.thst-button:visited, #respond #cancel-comment-reply-link:link, #respond #cancel-comment-reply-link:visited, #comments .commentlist li .comment-body .reply a:link, #comments .commentlist li .comment-body .reply a:visited, .wp-block-button__link, .wp-block-file__button, .pod_loadmore'),
                'units'       =>'px',
                'subtitle'    => __('Set the font for your buttons.', 'podcaster'),
                'default'     => array(
                    'font-weight'  => '600',
                    'font-family'  => 'Raleway',
                ),
            ),
        )
    ) );

	Redux::setSection( $opt_name, array(
		'icon' => 'fa fa-microphone',
        'icon_class' => 'icon-large',
        'title' => __('Podcast ', 'podcaster'),
	) );
    Redux::setSection( $opt_name, array(
        'title' => __('General', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the podcast. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-podcast"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'pod-recordings-category',
                'type' => 'select',
                'data' => 'categories',
                'title' => __('Podcast archive', 'podcaster'),
                'subtitle' => __('Select the podcast category. This will be used for the episodes on the front page and podcast (legacy) archive page.', 'podcaster'),
            ),
            /* If SSP is active. */
            ( ( $ssp_active == true )
                ? array(
                    'id' => 'pod-recordings-category-ssp',
                    'type' => 'select',
                    'data' => 'terms',
                    'args' => array( 'taxonomies' => 'series' , 'args' => array() ),
                    'title' => __('Seriously Simple Podcasting series', 'podcaster'),
                    'subtitle' => __('Select the podcast category. This will be used for the episodes on the front page and podcast (legacy) archive page .', 'podcaster'),
                )
                : false ),
            ( ( $ssp_active == true )
                ? array(
                    'id' => 'pod-ssp-meta-data',
                    'type' => 'switch',
                    'title' => __('Seriously Simple episode meta data', 'podcaster'),
                    'subtitle' => __('Activate player links such as downloads and duration information.', 'podcaster'),
                    'default' => false
                )
                : false ),
            ( ( $ssp_active == true )
                ? array(
                    'id' => 'pod-ssp-guest-active',
                    'type' => 'switch',
                    'title' => __('Seriously Simple Speakers', 'podcaster'),
                    'subtitle' => __('Display speakers and guests.', 'podcaster'),
                    'default' => false
                )
                : false ),
            
            array(
                'id' => 'pod-archive-hide-in-blog',
                'type' => 'checkbox',
                'title' => __('Podcast display in blog', 'podcaster'),
                'subtitle' => __('Check this box to include your episodes in the blog.', 'podcaster'),
                'switch' => true,
                'default' => true
            ),
            array(
                'id'       => 'pod-archive-title',
                'type'     => 'raw',
                'title'  => __( '<br /><h3>Podcast archive page</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the podcast archive page.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-archive-icons',
                'type' => 'radio',
                'title' => __('Icon type', 'podcaster'),
                'subtitle' => __('Select an icon type.', 'podcaster'),
                'options' => array(
                    'audio_icons' => 'Microphone Icon',
                    'video_icons' => 'Play Icon'
                ),
                'default' => 'audio_icons'
            ),
            array(
                'id' => 'pod-archive-rounded-corners',
                'type' => 'button_set',
                'title' => __('Rounded corners', 'podcaster'),
                'subtitle' => __('Set the corners for the thumbnails.', 'podcaster'),
                'options' => array( 
                    'pod-archive-corners-straight' => __('Straight', 'podcaster'),
                    'pod-archive-corners-round' => __('Round', 'podcaster'),
                ),
                'default' => 'pod-archive-corners-straight'
            ),
            array(
                'id' => 'pod-archive-button-text',
                'type' => 'text',
                'title' => __('Button text', 'podcaster'),
                'subtitle' => __('Enter the text for your button.', 'podcaster'),
                'placeholder' => 'Listen',
                'default' => 'Listen',
            ),
            array(
                'id' => 'pod-archive-trunc',
                'type' => 'switch',
                'title' => __('Truncate titles', 'podcaster'),
                'subtitle' => __('Activate to truncate titles.', 'podcaster'),
                'default' => false
            ),
            array(
                'id'       => 'pod-archive-legacy-title',
                'type'     => 'raw',
                'title'  => __( '<br /><h3>Podcast archive page (legacy)</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the podcast archive page, if the legacy template is active.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-list-style',
                'type' => 'radio',
                'title' => __('Display style', 'podcaster'),
                'subtitle' => __('How would you like to display the podcast archive?', 'podcaster'),
                'options' => array(
                    'grid' => 'Grid',
                    'list' => 'List'
                ),
                'default' => 'grid'
            ),
            array(
                'id' => 'pod-recordings-amount',
                'type' => 'spinner',
                'title' => __('Amount of posts', 'podcaster'),
                'subtitle' => __('Enter the amount of posts you would like to display per page within your archive. "0" displays all entries on one page.', 'podcaster'),
                "default" 	=> "9",
				"min" 		=> "0",
				"step"		=> "1",
				"max" 		=> "999"
            ),
            array(
                'id'       => 'pod-single-media-bg-raw',
                'type'     => 'raw',
                'title'  => __( '<br /><h3>Single Audio & Video Background Settings</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the background settings on audio & video posts.', 'podcaster' ),
            ),
            array(
               'id' => 'pod-single-header-par',
               'type' => 'switch',

               'title' => __('Single header parallax', 'podcaster'),
               'subtitle' => __('Activate parallax scrolling for the header.', 'podcaster'),
               'default' => false,
            ),
            array(
                'id' => 'pod-single-bg-style',
                'type' => 'radio',
                'title' => __('Single header background style', 'podcaster'),
                'subtitle' => __('Choose between stretched and tiled.', 'podcaster'),
                'options' => array(
                    'background-repeat:repeat;' => 'Tiled',
                    'background-repeat:no-repeat; background-size:cover;' => 'Streched',
                ),
                'default' => 'background-repeat:repeat;'
            ),
            array(
                'id'       => 'pod-single-audio-hosts-raw',
                'type'     => 'raw',
                'title'  => __( '<br /><h3>Hosts</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the host display.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-single-header-author',
                'type' => 'radio',
                'title' => __('Host info', 'podcaster'),
                'subtitle' => __('Select where to display the host info box.', 'podcaster'),
                'options' => array(
                    'host-audio' => 'Display on audio posts',
                    'host-audio-video' => 'Display on video posts',
                    'host-all' => 'Display on all posts'
                ),
                'default' => 'host-audio'
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Players', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the media player. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-podcast-single-player-colors"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'pod-player-style-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Player style</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for media players styles.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-players-style',
                'type' => 'button_set',
                'title' => __('Style', 'podcaster'),
                'subtitle' => __('Select a style for your players.', 'podcaster'),
                'options' => array(
                    'players-style-classic' => 'Classic',
                    'players-style-2' => 'Slim',
                    //'players-style-large' => 'Large',
                    ),
                'default' => 'players-style-classic'
            ),
            array(
                'id' => 'pod-players-corners',
                'type' => 'button_set',
                'title' => __('Corners', 'podcaster'),
                'subtitle' => __('Select a corner style for your players.', 'podcaster'),
                'options' => array(
                    'players-corners-straight' => 'Straight',
                    'players-corners-round' => 'Round',
                    ),
                'default' => 'players-corners-round'
            ),
            array(
                'id'       => 'pod-player-settings-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Player settings</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for media players.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-players-preload',
                'type' => 'button_set',
                'title' => __('Preload', 'podcaster'),
                'subtitle' => __('Setting to preload your audio and video players. Choose between a file & metadata, metadata or none.', 'podcaster'),
                'options' => array(
                    'none' => 'None',
                    'metadata' => 'Metadata',
                    'auto' => 'File & metadata'
                    
                    ),
                'default' => 'none'
            ),
            array(
                'id' => 'pod-audio-players-volume',
                'type' => 'button_set',
                'title' => __('Audio volume', 'podcaster'),
                'subtitle' => __('Set the style of the audio volume bar.', 'podcaster'),
                'options' => array(
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                    ),
                'default' => 'horizontal'
            ),
            array(
                'id'=>'pod-audio-soundcloud-player-style',
                'type' => 'radio',
                'title' => __('Soundcloud player style', 'podcaster'),
                'subtitle' => __('If Soundcloud players are active, select the type of player being used.', 'podcaster'),
                'options' => array(
                    'sc-classic-player' => 'Classic player (horizontal)',
                    'sc-new-player-square' =>'Square player',
                    'sc-new-player-horz' => 'Horizontal player',
                ),
                'default' => 'sc-classic-player'
            ),
            array(
                'id'       => 'pod-player-colors-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Player colors</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for media players colors.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-advanced-player-color-settings',
                'type' => 'switch',
                'title' => __('Custom colors', 'podcaster'),
                'subtitle' => __('Activate custom color settings.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-color-player-bg-color',
                'type' => 'color',
                'required' => array('pod-advanced-player-color-settings', '=', true),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.audio_player.regular-player, body .mejs-container .mejs-controls, .mejs-video .mejs-controls:hover, .mejs-video .mejs-overlay-button:hover, .latest-episode.front-header .mejs-container.mejs-video .mejs-controls:hover, .wp-playlist.wp-audio-playlist, .wp-playlist.wp-video-playlist, .post .entry-content .mejs-container.wp-audio-shortcode.mejs-audio, .post .audio_player, .audio_player .mejs-container, .audio_player .mejs-container .mejs-controls, .audio_player .mejs-embed, .audio_player .mejs-embed body'
                )
            ),
            array(
                'id' => 'pod-color-player-duration-color',
                'type' => 'color',
                'required' => array('pod-advanced-player-color-settings', '=', true),
                'title' => __('Duration text', 'podcaster'),
                'subtitle' => __('Select a color for the duration text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time, .mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-time'
                )
            ),
            array(
                'id' => 'pod-color-player-icon-color',
                'type' => 'color',
                'required' => array('pod-advanced-player-color-settings', '=', true),
                'title' => __('Icons', 'podcaster'),
                'subtitle' => __('Select a color for the icons.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button button, .mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-button button, .mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-button button, .mejs-video .mejs-overlay-button:hover::before'
                )
            ),
            array(
                'id' => 'pod-color-player-icon-hover-color',
                'type' => 'color',
                'required' => array('pod-advanced-player-color-settings', '=', true),
                'title' => __('Icons (hover)', 'podcaster'),
                'subtitle' => __('Select a hover color for the icons.', 'podcaster'),
                'default' => '#222222',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button button:hover, .mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-button button:hover'
                )
            ),
            array(
                'id' => 'pod-color-player-rail-color',
                'type' => 'color',
                'required' => array('pod-advanced-player-color-settings', '=', true),
                'title' => __('Rail', 'podcaster'),
                'subtitle' => __('Select a color for the rail.', 'podcaster'),
                'default' => '#1562BB',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-total, .mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-total, .mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-time-rail .mejs-time-total'
                )
            ),
            array(
                'id' => 'pod-color-player-rail-played-color',
                'type' => 'color',
                'required' => array('pod-advanced-player-color-settings', '=', true),
                'title' => __('Rail (played)', 'podcaster'),
                'subtitle' => __('Select a color for the rail (played).', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .post.format-audio .featured-media .audio_player .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .post.format-audio .featured-media .powerpress_player .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current')
            ),
            array(
                'id' => 'pod-color-player-time-handle-color',
                'type' => 'color',
                'required' => array('pod-advanced-player-color-settings', '=', true),
                'title' => __('Time handle (ball)', 'podcaster'),
                'subtitle' => __('Select a color for the time handle ball.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-handle-content, .mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-handle-content, .mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-handle, .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-volume-button .mejs-volume-slider .mejs-volume-handle, .mejs-container.mejs-video.wp-video-shortcode .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-handle, .mejs-container.mejs-video.wp-video-shortcode .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-handle, .mejs-container.mejs-video .mejs-controls .pod-mejs-controls-inner .mejs-volume-handle, .single .single-featured-video-container .mejs-video .mejs-controls .pod-mejs-controls-inner .mejs-volume-button .mejs-volume-slider .mejs-volume-handle, .single .single-featured-video-container .mejs-container.mejs-video.wp-video-shortcode .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-handle'
                )
            ),
            array(
                'id' => 'pod-color-player-time-display-bg-color',
                'type' => 'color',
                'required' => array('pod-advanced-player-color-settings', '=', true),
                'title' => __('Time display (background)', 'podcaster'),
                'subtitle' => __('Select a background color for the time display.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float',
                    'border-top-color' => '.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float-corner'
                )
            ),
            array(
                'id' => 'pod-color-player-time-display-text-color',
                'type' => 'color',
                'required' => array('pod-advanced-player-color-settings', '=', true),
                'title' => __('Time display (text)', 'podcaster'),
                'subtitle' => __('Select a color for the text of the time display.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float, .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float .mejs-time-float-current')
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Single post players', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the media player on single pages. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-podcast-single-player-colors"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
               'id' => 'pod-single-audio-color-activate',
               'type' => 'switch',
               'title' => __('Custom colors', 'podcaster'),
               'subtitle' => __('Activate custom colors for your single page audio and video players.', 'podcaster'),
               'default' => false,
            ),
            array(
                'id' => 'pod-single-audio-transparent-active',
                'type' => 'switch',
                'required' => array('pod-single-audio-color-activate', '=', true),
                'title' => __('Transparent audio player', 'podcaster'),
                'subtitle' => __('Activate transparency for your single audio players.', 'podcaster'),
                'default' => true
            ),
            array(
                'id'       => 'pod-single-audio-bg-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-single-audio-color-activate', '=', true),
                ),
                'transparent' => false,
                'title'    => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#eeeeee',
                'output'    => array('background-color' => '
                    .single.single-custom-color-audio-active .single-featured.format-audio .wp-playlist.wp-audio-playlist, .single.single-custom-color-audio-active.single-transparent-audio-inactive .single-featured.format-audio .audio_player:not(.embed_code):not(.au_oembed), 
                    .single.single-custom-color-audio-active.single-transparent-audio-inactive .single-featured.format-audio .powerpress_player, .single.single-custom-color-audio-active.single-transparent-audio-inactive .single-featured.format-audio .mejs-audio.mejs-container, .single.single-custom-color-audio-active.single-transparent-audio-inactive .single-featured.format-audio .mejs-audio.mejs-container .mejs-controls, .single.single-custom-color-audio-active.single-transparent-audio-inactive .sticky-featured-audio-container .audio_player, .single.single-custom-color-audio-active.single-transparent-audio-inactive .sticky-featured-audio-container .powerpress_player, .single.single-custom-color-audio-active.single-transparent-audio-inactive .sticky-featured-audio-container .mejs-audio.mejs-container, .single.single-custom-color-audio-active.single-transparent-audio-inactive .sticky-featured-audio-container .mejs-audio.mejs-container .mejs-controls, .single.single-custom-color-audio-active .single-featured.format-video .mejs-video .mejs-controls:hover, .single.single-custom-color-audio-active .single-featured.format-video .mejs-video .mejs-overlay-button:hover, .single.single-custom-color-audio-active .single-featured.format-video .mejs-video .mejs-controls:hover, .single.single-custom-color-audio-active .single-featured.format-video .mejs-video .mejs-overlay-button:hover')
            ),
            array(
                'id'       => 'pod-single-audio-dur-color',
                'type'     => 'color',
                'required' => array('pod-single-audio-color-activate', '=', true),
                'transparent' => false,
                'title'    => __('Duration text', 'podcaster'),
                'subtitle' => __('Select a color for the duration text.', 'podcaster'),
                'default' => '#888888',
                'output'    => array(
                    'color' => '
                    .single.single-custom-color-audio-active .single-featured.format-audio .mejs-container.mejs-audio .mejs-controls .mejs-time span, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-container.mejs-audio .mejs-controls .mejs-time span, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container.mejs-video .mejs-controls:hover .mejs-time span,.single.single-custom-color-audio-active .single-featured.format-audio .wp-playlist.wp-audio-playlist .wp-playlist-current-item .wp-playlist-caption')
            ),
            array(
                'id'       => 'pod-single-audio-icon-bg-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-single-audio-color-activate', '=', true),
                    array('pod-players-style', '=','players-style-2')
                ),
                'transparent' => false,
                'title'    => __('Play icon background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#282d31',
                'output'    => array(
                    'background-color' => ' .players-style-2.single .single-featured.format-audio .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button, .players-style-2.single .sticky-featured-audio-container .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button, .players-style-2.single .single-featured.format-video .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button'
                )
            ),
            array(
                'id'       => 'pod-single-audio-but-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-single-audio-color-activate', '=', true),
                'title'    => __('Icons', 'podcaster'),
                'subtitle' => __('Select a color for the icons.', 'podcaster'),
                'default' => '#888888',
                'output'    => array(
                    'color' => '
                    .single.single-custom-color-audio-active .single-featured.format-audio .mejs-container.mejs-audio .mejs-controls .mejs-button button, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-container.mejs-audio .mejs-controls .mejs-button button, 
                    .players-style-2.single .single-featured.format-audio .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button button, .players-style-2.single .sticky-featured-audio-container .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button button,
                    .players-style-2.single .single-featured-video-container .mejs-video .mejs-controls .pod-mejs-controls-inner .mejs-button button, .single.single-custom-color-audio-active .single-featured.format-audio.has-featured-image.audio-featured-image-background .audio_player .mejs-controls .mejs-button button, 
                    .single.single-custom-color-audio-active .single-featured.format-audio.has-featured-image.audio-featured-image-background .powerpress_player .mejs-controls .mejs-button button, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container.mejs-video .mejs-controls:hover .mejs-button button, .single.single-custom-color-audio-active .single-featured.format-video .mejs-video .mejs-overlay-button:hover:before',
                    
                    'background' => ' .single.single-custom-color-audio-active .single-featured .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button .mejs-volume-handle, .single.single-custom-color-audio-active .single-featured.format-audio .mejs-audio .mejs-controls .mejs-time-rail span.mejs-time-handle-content, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-volume-button .mejs-volume-handle, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-audio .mejs-controls .mejs-time-rail span.mejs-time-handle-content, .single.single-custom-color-audio-active .single-featured .mejs-container.mejs-video.wp-video-shortcode .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-handle, .single.single-custom-color-audio-active .single-featured-video-container .mejs-video .mejs-controls .pod-mejs-controls-inner .mejs-volume-button .mejs-volume-slider .mejs-volume-handle, .single.single-custom-color-audio-active .single-featured.format-video .mejs-video .mejs-controls .mejs-time-rail span.mejs-time-handle-content, .single.single-custom-color-audio-active .single-featured.format-video .mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-handle-content')

            ),
            array(
                'id'       => 'pod-single-audio-icon-bg-hover-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-single-audio-color-activate', '=', true),
                    array('pod-players-style', '=','players-style-2')
                ),
                'transparent' => false,
                'title'    => __('Play icon background (hover)', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#282d31',
                'output'    => array(
                    'background-color' => ' .players-style-2.single .single-featured.format-audio .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button:hover, .players-style-2.single .sticky-featured-audio-container .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button:hover, .players-style-2.single .single-featured.format-video .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-button.mejs-playpause-button:hover'
                )
            ),
            array(
                'id'       => 'pod-single-audio-but-hover-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-single-audio-color-activate', '=', true),
                'title'    => __('Icons (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the icons.', 'podcaster'),
                'default' => '#000000',
                'output'    => array(
                    'color' => '.single.single-custom-color-audio-active .single-featured.format-audio .mejs-container.mejs-audio .mejs-controls .mejs-button button:hover, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-container.mejs-audio .mejs-controls .mejs-button button:hover, .single.single-custom-color-audio-active .single-featured.format-audio.has-featured-image.audio-featured-image-background .audio_player .mejs-controls .mejs-button button:hover, .single.single-custom-color-audio-active .single-featured.format-audio.has-featured-image.audio-featured-image-background .powerpress_player .mejs-controls .mejs-button button:hover, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container.mejs-video .mejs-controls .mejs-button button:hover'
                )
            ),
            array(
                'id'       => 'pod-single-audio-rail-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-single-audio-color-activate', '=', true),
                'title'    => __('Rail', 'podcaster'),
                'subtitle' => __('Select a color for the rail.', 'podcaster'),
                'default' => '#bfbfbf',
                'output'    => array(
                    'background-color' => '
                    .single.single-custom-color-audio-active .single-featured.format-audio .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-total, .single.single-custom-color-audio-active .single-featured.format-audio .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-total, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-total, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-total, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container .mejs-controls:hover .pod-mejs-controls-inner .mejs-time-rail .mejs-time-total, 
                    .single.single-custom-color-audio-active .single-featured.format-video .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-total')
            ),
            array(
                'id'       => 'pod-single-audio-rail-played-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-single-audio-color-activate', '=', true),
                'title'    => __('Rail (played)', 'podcaster'),
                'subtitle' => __('Select a color (played) for the rail.', 'podcaster'),
                'default' => '#000000',
                'output'    => array(
                    'background-color' => '
                    .single.single-custom-color-audio-active .single-featured.format-audio .wp-audio-shortcode.mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .single.single-custom-color-audio-active .single-featured.format-audio .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .single.single-custom-color-audio-active .single-featured.format-audio .wp-audio-shortcode.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .single.single-custom-color-audio-active .single-featured.format-audio .mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .single.single-custom-color-audio-active .sticky-featured-audio-container .wp-audio-shortcode.mejs-container.mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .single.single-custom-color-audio-active .sticky-featured-audio-container .wp-audio-shortcode.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-audio .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .single.single-custom-color-audio-active .single-featured.format-video .wp-audio-shortcode.mejs-container.mejs-video .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .single.single-custom-color-audio-active .single-featured.format-video .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .single.single-custom-color-audio-active .single-featured.format-video .wp-audio-shortcode.mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container.mejs-video .mejs-controls .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container.mejs-video .mejs-controls:hover .pod-mejs-controls-inner .mejs-time-rail span.mejs-time-current')
            ),
            array(
                'id'       => 'pod-single-audio-time-display-bg-color',
                'type'     => 'color',
                'required' => array('pod-single-audio-color-activate', '=', true),
                'transparent' => false,
                'title'    => __('Time display (background)', 'podcaster'),
                'subtitle' => __('Select a color for the background of the time display.', 'podcaster'),
                'default' => '#000000',
                'output'    => array(
                    'background' => '
                    .single.single-custom-color-audio-active .single-featured.format-audio .mejs-container.wp-audio-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float, .single.single-custom-color-audio-active .single-featured .mejs-audio .mejs-controls .mejs-time-rail .mejs-time-float, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-container.wp-audio-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-audio .mejs-controls .mejs-time-rail .mejs-time-float, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container.wp-video-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float, .single.single-custom-color-audio-active .single-featured-video-container .mejs-video .mejs-controls:hover .mejs-time-rail .mejs-time-float',
                    'border-top-color' => '.single.single-custom-color-audio-active .single-featured.format-audio .mejs-container.wp-audio-shortcode .mejs-controls .mejs-time-rail .mejs-time-float-corner, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container.wp-video-shortcode .mejs-controls .mejs-time-rail .mejs-time-float-corner, .single.single-custom-color-audio-active .single-featured-video-container .mejs-video .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float-corner, .single.single-custom-color-audio-active .single-featured .mejs-audio .mejs-controls .mejs-time-rail .mejs-time-float-corner, .single .sticky-featured-audio-container .mejs-audio .mejs-controls .mejs-time-rail .mejs-time-float-corner'
                ),
            ),
            array(
                'id'       => 'pod-single-audio-time-display-text-color',
                'type'     => 'color',
                'transparent' => false,
                'required' => array('pod-single-audio-color-activate', '=', true),
                'title'    => __('Time display (text)', 'podcaster'),
                'subtitle' => __('Select a color for the text of the time display.', 'podcaster'),
                'default' => '#ffffff',
                'output'    => array(
                    'color' => '
                    .single.single-custom-color-audio-active .single-featured.format-audio .mejs-container.wp-audio-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float .mejs-time-float-current, .single.single-custom-color-audio-active .single-featured .mejs-audio .mejs-controls .mejs-time-rail .mejs-time-float .mejs-time-float-current, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-container.wp-audio-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float .mejs-time-float-current, .single.single-custom-color-audio-active .sticky-featured-audio-container .mejs-audio .mejs-controls .mejs-time-rail .mejs-time-float .mejs-time-float-current, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container.wp-video-shortcode .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float .mejs-time-float-current, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container.mejs-video .mejs-controls:hover .mejs-time-rail .mejs-time-float, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float, .single.single-custom-color-audio-active .single-featured.format-video .mejs-container .mejs-controls .pod-mejs-controls-inner .mejs-time-rail .mejs-time-float .mejs-time-float-current
                    ')
            ),
            array(
                'id'       => 'pod-single-audio-playlist-bg-color',
                'type'     => 'color',
                'required' => array(
                    array('pod-single-audio-color-activate', '=', true),
                ),
                'transparent' => false,
                'title'    => __('Playlist background', 'podcaster'),
                'subtitle' => __('Select a color for the background of the playlists.', 'podcaster'),
                'default' => '#eeeeee',
                'output'    => array(
                    'background-color' => '.single.single-custom-color-audio-active .single-featured.format-audio .wp-playlist.wp-audio-playlist'
                )
            ),
		)
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Audio header', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the audio episodes. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-podcast-single-player-colors"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'pod-single-header-display',
                'type' => 'radio',
                'title' => __('Single header display', 'podcaster'),
                'subtitle' => __('Choose between featured image in background and thumbnail.', 'podcaster'),
                'options' => array(
                    'has-background' => 'Featured image in background',
                    'has-thumbnail' => 'Featured image as thumbnail',
                    'no-thumbnail' => 'No featured image'
                ),
                'default' => 'has-thumbnail'
            ),
            array(
                'id' => 'pod-single-header-player-display',
                'type' => 'radio',
                'required' => array("pod-new-feature-soon", "=", true),
                'title' => __('Player display', 'podcaster'),
                'subtitle' => __('Choose between displaying the player in the header or stuck to the bottom.', 'podcaster'),
                'options' => array(
                    'player-in-header' => 'Header',
                    //'player-in-footer' => 'Stuck to bottom',
                ),
                'default' => 'player-in-header'
            ),
            
            array(
                'id' => 'pod-single-header-thumbnail-size',
                'type' => 'radio',
                'required' => array('pod-single-header-display', '=', 'has-thumbnail'),
                'title' => __('Thumbnail size', 'podcaster'),
                'subtitle' => __('Select the size for the thumbnail.', 'podcaster'),
                'options' => array(
                    'thumb-size-small' => 'Small',
                    'thumb-size-medium' => 'Medium',
                    'thumb-size-large' => 'Large'
                ),
                'default' => 'thumb-size-small'
            ),
            array(
                'id' => 'pod-single-header-thumbnail-radius',
                'type' => 'button_set',
                'required' => array('pod-single-header-display', '=', 'has-thumbnail'),
                'title' => __('Rounded corners', 'podcaster'),
                'subtitle' => __('Choose between <strong>straight</strong> and <strong>rounded</strong>.', 'podcaster'),
                'options' => array(
                    'straight-corners' => 'Straight',
                    'rounded-corners' => 'Round',
                ),
                'default' => 'straight-corners'
            ),
            array(
                'id' => 'pod-single-header-thumbnail-audio-embed',
                'type' => 'switch',
                'required' => array('pod-single-header-display', '=', 'has-thumbnail'),
                'title' => __('Thumbnail on audio embedded player', 'podcaster'),
                'subtitle' => __('Activate featured thumbnail on embedded players.', 'podcaster'),
                'default' => true
            ),
            array(
                'id' => 'pod-single-header-thumbnail-audio-playlist',
                'type' => 'switch',
                'required' => array('pod-single-header-display', '=', 'has-thumbnail'),
                'title' => __('Thumbnail on audio playlists', 'podcaster'),
                'subtitle' => __('Activate featured thumbnail on playlists posts on or off.', 'podcaster'),
                'default' => true
            ),
            array(
                'id'       => 'pod-single-audio-header-colors-raw',
                'type'     => 'raw',
                'title'  => __( '<br /><h3>Colors</h3>', 'podcaster' ),
                'content'  => __( 'The settings below for the single audio header.', 'podcaster' ),
            ),
            array(
               'id' => 'pod-single-audio-header-bg-color-activate',
               'type' => 'switch',
               'title' => __( 'Custom colors', 'podcaster' ),
               'subtitle' => __('Activate custom colors for audio single posts.', 'podcaster'),
               'default' => false,
            ),
            array(
                'id'       => 'pod-single-audio-header-bg-color',
                'type'     => 'color',
                'required' => array( 'pod-single-audio-header-bg-color-activate', '=', true ),
                'title'    => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#eeeeee',
                'transparent' => false,
                'output'    => array('background-color' => '.single .single-featured.format-audio, .single.single-format-audio .caption-container, .single.single-podcast .caption-container, .single .single-featured .wp-audio-shortcode.mejs-container, .single .single-featured .wp-audio-shortcode.mejs-container .mejs-controls, .sticky-featured-audio-container, .sticky-featured-audio-container .mejs-container .mejs-controls, .single .sticky-featured-audio-container .mejs-audio, .single .sticky-featured-audio-container .mejs-audio .mejs-controls, .sticky-featured-audio-active.single .sticky-featured-audio-container')
            ),
            array(
                'id'       => 'pod-single-audio-border-color',
                'type'     => 'color',
                'required' => array('pod-single-audio-header-bg-color-activate', '=', true),
                'title'    => __('Borders', 'podcaster'),
                'subtitle' => __('Select a color for borders.', 'podcaster'),
                'default' => '#dddddd',
                'transparent' => false,
                'output'    => array(
                    'border-color' => '.single.single-format-audio .caption-container, .single.single-podcast .caption-container.format-audio, .single.single-format-audio .single-featured, .single.single-podcast .single-featured'
                )
            ),
            array(
                'id'       => 'pod-single-audio-header-text-color',
                'type'     => 'color',
                'required' => array( 'pod-single-audio-header-bg-color-activate', '=', true ),
                'title'    => __('Title', 'podcaster'),
                'subtitle' => __('Select a color for titles.', 'podcaster'),
                'default' => '#444444',
                'transparent' => false,
                'output'    => array('color' => '.single .single-featured.format-audio h1, .single .single-featured.format-audio h2, .single.single-format-audio .single-featured span.mini-title, .sticky-featured-audio-container .sticky-featured-audio-inner .sticky-meta-text .title h4, .sticky-featured-audio-active.single .sticky-featured-audio-container .sticky-featured-audio-inner .sticky-meta-text .title h4')
            ),
            array(
                'id'       => 'pod-single-audio-header-caption-color',
                'type'     => 'color',
                'required' => array( 'pod-single-audio-header-bg-color-activate', '=', true ),
                'title'    => __('Captions', 'podcaster'),
                'subtitle' => __('Select a color for captions.', 'podcaster'),
                'default' => '#444444',
                'transparent' => false,
                'output'    => array('color' => '.single.single-format-audio .caption-container, .single.single-podcast .caption-container.format-audio')
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __('Video header', 'podcaster'),
        'desc' => __('<p class="description">Customie your video episodes. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-podcast-video-header"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'subsection' => true,
        'fields' => array(
            array(
               'id' => 'pod-single-video-bg',
               'type' => 'switch',
               'title' => __('Video background (image)', 'podcaster'),
               'subtitle' => __('Activate backgrounds in video posts.', 'podcaster'),
               'default' => false,
            ),
            array(
               'id' => 'pod-single-video-bg-color-activate',
               'type' => 'switch',
               'title' => __('Custom colors', 'podcaster'),
               'subtitle' => __('Activate custom colors for video single posts.', 'podcaster'),
               'default' => false,
            ),
            array(
                'id'       => 'pod-single-video-bg-color',
                'type'     => 'color',
                'required' => array('pod-single-video-bg-color-activate', '=', true),
                'title'    => __('Background', 'podcaster'),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#eeeeee',
                'transparent' => false,
                'output'    => array('background-color' => '.single .single-featured.format-video, .single.single-format-video .caption-container, .single.single-podcast .caption-container.format-video')
            ),
            array(
                'id'       => 'pod-single-video-border-color',
                'type'     => 'color',
                'required' => array('pod-single-video-bg-color-activate', '=', true),
                'title'    => __('Borders', 'podcaster'),
                'subtitle' => __('Select a color for borders.', 'podcaster'),
                'default' => '#dddddd',
                'transparent' => false,
                'output'    => array(
                    'border-color' => '.single.single-format-video .caption-container, .single.single-podcast .caption-container.format-video, .single.single-format-video .single-featured, .single.single-podcast .single-featured.format-video')
            ),
            array(
                'id'       => 'pod-single-video-caption-color',
                'type'     => 'color',
                'required' => array('pod-single-video-bg-color-activate', '=', true),
                'title'    => __('Captions', 'podcaster'),
                'subtitle' => __('Select a color for captions.', 'podcaster'),
                'default' => '#444444',
                'transparent' => false,
                'output'    => array('color' => '.single.single-format-video .caption-container, .single.single-podcast .caption-container.format-video')
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'icon' => 'fas fa-file-alt',
        'icon_class' => 'icon-large',
        'title' => __('Single posts & pages', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize single posts and pages. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-single-posts-pages"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'fields' => array(
            array(
                'id'       => 'pod-alignment-no-sidebar',
                'type'     => 'radio',
                'title'    => __('Alignment (no Sidebar)', 'podcaster'),
                'subtitle' => __('Select an alignment when no sidebar is set for single posts and pages.', 'podcaster'),
                'options' => array(
                    'align-content-left' => 'Left',
                    'align-content-centered' => 'Center',
                    'align-content-right' => 'Right',
                ),
                'default' => 'align-content-left'
            ),
            array(
                'id'       => 'pod-category-archive-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Category & archive pages</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the category and archive pages.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-category-heading',
                'type' => 'text',
                'title' => __('Category page title', 'podcaster'),
                'subtitle' => __('Enter a title or leave it blank.', 'podcaster'),
                'default' => __('Category:', 'podcaster'),
                'validate' => 'no_html',
            ),
            array(
                'id' => 'pod-tag-heading',
                'type' => 'text',
                'title' => __('Tags page title', 'podcaster'),
                'subtitle' => __('Enter a title or leave it blank.', 'podcaster'),
                'default' => __('Tag:', 'podcaster'),
                'validate' => 'no_html',
            ),
            array(
                'id' => 'pod-search-heading',
                'type' => 'text',
                'title' => __('Search page title', 'podcaster'),
                'subtitle' => __('Enter a title or leave it blank.', 'podcaster'),
                'default' => __('Search Results for:', 'podcaster'),
                'validate' => 'no_html',
            ),
            array(
                'id'       => 'pod-color-single-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Colors</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the colors on your single posts & pages.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-advanced-color-single-settings',
                'type' => 'switch',
                'title' => __('Custom colors', 'podcaster'),
                'subtitle' => __('Activate custom color settings.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-color-single-bg',
                'type' => 'color',
                'required' => array('pod-advanced-color-single-settings', '=', true),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.single .main-content, .single .sidebar .widget, .single .content, .single .thst-main-posts, .single .comment_container, .single textarea, .single .widget.thst_recent_blog_widget .ui-tabs-panel, .single .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active, .page:not(.has-front-page-template) .main-content, .page:not(.has-front-page-template) .sidebar .widget, .page:not(.has-front-page-template) .thst-main-posts, .page:not(.has-front-page-template) .comment_container, .page:not(.has-front-page-template) textarea,  .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-panel, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active, .error404 .main-content, .arch_searchform #ind_searchform div #ind_s, .single .sidebar .widget:not(.widget_search):not(.thst_recent_blog_widget), .dark-template-active.page.page-template:not(.has-front-page-template) .sidebar .widget, .dark-template-active.page.page-template-default:not(.has-front-page-template) .sidebar .widget, .dark-template-active.page:not(.has-front-page-template) .thst-tabs .thst-nav li a')
            ),
            array(
                'id' => 'pod-color-single-border',
                'type' => 'color',
                'required' => array('pod-advanced-color-single-settings', '=', true),
                'title' => __('Borders', 'podcaster'),
                'subtitle' => __('Select a color for borders.', 'podcaster'),
                'default' => '#dddddd',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'border-color' => '.single .post .entry-meta, .page:not(.has-front-page-template) .post .entry-meta, .single .widget.thst_recent_comments_widget ul li.recentcomments,  .page:not(.has-front-page-template) .widget.thst_recent_comments_widget ul li.recentcomments, .single .widget.thst_recent_blog_widget .ui-tabs-panel article, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-panel article, .single .thst_highlight_category_widget ul li .text, .page:not(.has-front-page-template) .thst_highlight_category_widget ul li .text, .single input[type="text"], .single input[type="email"], .single input[type="password"], .single textarea, .page:not(.has-front-page-template) input[type="text"], .page:not(.has-front-page-template) input[type="email"], .page:not(.has-front-page-template) input[type="password"], .page:not(.has-front-page-template) textarea, .dark-template-active.single .post .entry-meta .author-info, .dark-template-active.single .author-info .author-avatar img, .page-template-pagepage-podcastarchive-php .entries.list .podpost, .post-type-archive-podcast .entries.list .podpost, .arch_searchform,  .page:not(.has-front-page-template) .wp-block-table table, .page:not(.has-front-page-template) table.wp-block-table, .page:not(.has-front-page-template) .wp-block-table td, .page:not(.has-front-page-template) .wp-block-table th, .single .wp-block-table table, .single table.wp-block-table, .single .wp-block-table td, .single .wp-block-table th, .thst-tabs .thst-tab, .thst-tabs .thst-nav li a, .single .entry-meta .author-info, .template-podcast-archive-legacy .entries-container.list .podpost, .post.format-chat .entry-content ul li, .single .template-gutenberg .entry-meta .author-info',
                    
                    'background-color' => '.single .widget #calendar_wrap #wp-calendar thead tr, .dark-template-active.single .widget #calendar_wrap #wp-calendar thead tr, .page:not(.has-front-page-template) .widget #calendar_wrap #wp-calendar thead tr, .dark-template-active.page:not(.has-front-page-template) .widget #calendar_wrap #wp-calendar thead tr, .dark-template-active.single .widget .tagcloud a:link, .dark-template-active.single .widget .tagcloud a:visited, .dark-template-active.page:not(.has-front-page-template) .sidebar .widget .tagcloud a:link, .dark-template-active.page:not(.has-front-page-template) .sidebar .widget .tagcloud a:visited, .dark-template-active .sidebar .wp-caption .wp-caption-text'
                    )
            ),
            array(
                'id' => 'pod-color-single-inputs-fields',
                'type' => 'color',
                'required' => array('pod-advanced-color-single-settings', '=', true),
                'title' => __('Sidebar inputs &fields', 'podcaster'),
                'subtitle' => __('Select a color for borders.', 'podcaster'),
                'default' => '#dddddd',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.single .widget.widget_search .search-container #s, .page:not(.has-front-page-template) .widget.widget_search .search-container #s, .single .thst_highlight_category_widget ul li:first-child .text, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-nav li, .single .widget.thst_recent_blog_widget .ui-tabs-nav li, .page:not(.has-front-page-template) .thst_highlight_category_widget ul li:first-child .text',
                    'border-bottom-color' => '.single .thst_highlight_category_widget ul li:first-child .text.arrow::after, .page:not(.has-front-page-template) .thst_highlight_category_widget ul li:first-child .text.arrow::after'
                )
            ),
            array(
                'id' => 'pod-color-single-text',
                'type' => 'color',
                'required' => array('pod-advanced-color-single-settings', '=', true),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.single, body.page-template:not(.front-page-blog-template), .single .entry-content, .single-post #mediainfo .download-heading, .single .sidebar, .single .sidebar h3, .single .comment-respond h3, .single #comments h3, .single .entry-categories, .single .entry-tags, .single .post .entry-meta, .single .comment_container, .single .widget.thst_recent_blog_widget .ui-tabs-panel article .text .date, .single .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:link, .single .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:visited, .single .post.format-standard .entry-header .entry-title, .single .post .entry-header .mini-title, .single .author-description span, .page:not(.has-front-page-template) .entry-content, .page:not(.has-front-page-template) .sidebar, .page:not(.has-front-page-template) .sidebar h3, .page:not(.has-front-page-template) .comment-respond h3, .page:not(.has-front-page-template) #comments h3, .page:not(.has-front-page-template) .comment_container, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-panel article .text .date, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:link, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:visited, .dark-template-active .single .author-description span, .pod-2-podcast-archive-grid .podpost .post-footer .categories a, .pod-2-podcast-archive-list .podpost .right .post-excerpt .categories a, .template-podcast-archive.template-podcast-archive-list .post, .template-podcast-archive-legacy .entries-container.grid .podpost .entry-footer .podpost-meta .categories a, .template-podcast-archive-legacy .entries-container.list .podpost, .arch_searchform #ind_searchform div #ind_s, .single .thst_highlight_category_widget ul li:first-child .text .h_author, .page:not(.has-front-page-template) .thst_highlight_category_widget ul li:first-child .text .h_author, .single .thst_highlight_category_widget ul li:first-child .text .h_author, .page:not(.has-front-page-template) .thst_highlight_category_widget ul li:first-child .text .h_author')
            ),
            array(
                'id' => 'pod-color-single-link',
                'type' => 'color',
                'required' => array('pod-advanced-color-single-settings', '=', true),
                'title' => __('Links', 'podcaster'),
                'subtitle' => __('Select a color for the links.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.single .entry-content a:link, .single .entry-content a:visited, .single.single-post #mediainfo .download .download-link:link, .single.single-post #mediainfo .download .download-link:visited, .single .sidebar .widget a:link, .single .sidebar .widget a:visited, .single .entry-categories a:link, .single .entry-categories a:visited, .single .entry-tags a:link, .single .entry-tags a:visited, .single .post .entry-meta a:link, .single .post .entry-meta a:visited, .single .comment_container a:link, .single .comment_container a:visited, .single .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:link, .single .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:visited, .pod-2-podcast-archive-list .podpost .right .post-excerpt .title a, .page:not(.has-front-page-template) .entry-content a:link:not(.butn), .page:not(.has-front-page-template) .entry-content a:visited:not(.butn), .page:not(.has-front-page-template) .sidebar .widget a:link, .page:not(.has-front-page-template) .sidebar .widget a:visited, .page:not(.has-front-page-template) .comment_container a:link, .page:not(.has-front-page-template) .comment_container a:visited, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:link, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:visited, .pod-2-podcast-archive-grid .podpost .post-footer .title a, .template-podcast-archive-legacy .entries-container.grid .podpost .entry-footer .podpost-meta .title a, .template-podcast-archive-legacy .entries-container.list .podpost .entry-footer .podpost-meta .title a, .template-podcast-archive-legacy .entries-container.list .podpost .entry-footer .podpost-meta .categories a, .template-podcast-archive-legacy .entries-container.list .podpost .entry-footer .podpost-meta .categories span, .single .thst_highlight_category_widget ul li:first-child .text a:link, .single .thst_highlight_category_widget ul li:first-child .text a:visited, .page:not(.has-front-page-template) .thst_highlight_category_widget ul li:first-child .text a:link, .page:not(.has-front-page-template) .thst_highlight_category_widget ul li:first-child .text a:visited, .single .widget.thst_recent_blog_widget .ui-tabs-nav li a:link, .single .widget.thst_recent_blog_widget .ui-tabs-nav li a:visited, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-nav li a:link, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-nav li a:visited'
                )
            ),
            array(
                'id' => 'pod-color-single-link-hover',
                'type' => 'color',
                'required' => array('pod-advanced-color-single-settings', '=', true),
                'title' => __('Links (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the links.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.single .entry-content a:hover, .single.single-post #mediainfo .download .download-link:hover, .single .sidebar .widget ul li a:hover, .single .entry-categories a:hover, .single .entry-tags a:hover, .single .post .entry-meta a:hover, .single .comment_container a:hover, .page:not(.has-front-page-template) .entry-content a:hover:not(.butn), .page:not(.has-front-page-template) .sidebar .widget ul li a:hover, .page:not(.has-front-page-template) .comment_container a:hover, .pod-2-podcast-archive-grid .podpost .post-footer .title a:hover, .single .thst_highlight_category_widget ul li:first-child .text a:hover, .page:not(.has-front-page-template) .thst_highlight_category_widget ul li:first-child .text a:hover, .single .widget.thst_recent_blog_widget .ui-tabs-nav li a:hover, .page:not(.has-front-page-template) .widget.thst_recent_blog_widget .ui-tabs-nav li a:hover'
                )
            ),
            array(
                'id' => 'pod-color-single-text-icons-status',
                'type' => 'color',
                'required' => array('pod-advanced-color-single-settings', '=', true),
                'title' => __('Icons & labels', 'podcaster'),
                'subtitle' => __('Select a color for icons and labels.', 'podcaster'),
                'default' => '#aaaaaa',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.singlep_pagi p, .single-post #mediainfo .download li::before, .single .post.format-chat .entry-content ul li strong, .single .post.format-status .status_icon::before, .page:not(.has-front-page-template) .post.format-chat .entry-content ul li strong, .page:not(.has-front-page-template) .post.format-status .status_icon::before, .arch_searchform #ind_searchform div #ind_searchsubmit .fa-search::before'
                )
            ),
            array(
                'id'       => 'pod-single-image-header-colors-raw',
                'type'     => 'raw',
                'title'  => __( '<br /><h3>Image & Gallery Posts</h3>', 'podcaster' ),
                'content'  => __( 'The settings below for the single image/gallery header.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-galler-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Gallery</h3>', 'podcaster' ),
                'content'  => __( 'The settings below for gallery post settings.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-pofo-gallery',
                'type' => 'radio',
                'title' => __('Gallery format', 'podcaster'),
                'subtitle' => __('Choose between a slideshows or grid.', 'podcaster'),
                'options' => array(
                'slideshow_on' => 'Slideshow',
                'grid_on' => 'Grid'
                ),
                'default' => 'slideshow_on'
            ),
            array(
                'id'       => 'pod-gallery-accent',
                'type'     => 'color',
                'title'    => __('Gallery accent', 'podcaster'),
                'subtitle' => __('Select an accent color for the gallery.', 'podcaster'),
                'default' => '#1e7ce8',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.post.format-gallery .featured-gallery .gallery.flexslider li.gallery-item .flex-caption, .single .featured-gallery .gallery.flexslider li.gallery-item .flex-caption, .post .entry-content .gallery.flexslider li.gallery-item .flex-caption, .post.format-gallery .entry-content .gallery.grid .gallery-item .flex-caption, .gallery.grid .gallery-item .flex-caption')
            ),
            array(
                'id'       => 'pod-gallery-text',
                'type'     => 'color',
                'title'    => __('Caption', 'podcaster'),
                'subtitle' => __('Select a color for gallery captions.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array(
                    'color' => '.post.format-gallery .featured-gallery .gallery.flexslider li.gallery-item .flex-caption, .post.format-gallery .featured-gallery .gallery.grid .gallery-item .flex-caption, .post.format-gallery .entry-content .gallery.grid .gallery-item .flex-caption p, .post .entry-content .gallery.flexslider li.gallery-item .flex-caption, .post .entry-content .gallery.grid .gallery-item .flex-caption, .single .featured-gallery .gallery.flexslider li.gallery-item .flex-caption, .single .featured-gallery .gallery.grid .gallery-item .flex-caption, .gallery.grid .gallery-item .flex-caption p, .post .gallery.flexslider .slides li a, .single .gallery.flexslider .slides li a, .post .gallery.grid .gallery-item a, .single .gallery.grid .gallery-item a')
            ),
            array(
               'id' => 'pod-single-image-header-bg-color-activate',
               'type' => 'switch',
               'title' => __( 'Custom colors', 'podcaster' ),
               'subtitle' => __('Activate custom colors for image/gallery single posts.', 'podcaster'),
               'default' => false,
            ),
            array(
                'id'       => 'pod-single-image-header-bg-color',
                'type'     => 'color',
                'required' => array( 'pod-single-image-header-bg-color-activate', '=', true ),
                'title'    => __('Background', 'podcaster'),
                'subtitle' => __('Select a background color.', 'podcaster'),
                'default' => '#eeeeee',
                'transparent' => false,
                'output'    => array('background-color' => '.single.single-format-image .single-featured, .single.single-format-gallery .single-featured, .single .caption-container.format-image, .single .caption-container.format-gallery')
            ),
            array(
                'id'       => 'pod-single-image-border-color',
                'type'     => 'color',
                'required' => array('pod-single-image-header-bg-color-activate', '=', true),
                'title'    => __('Borders', 'podcaster'),
                'subtitle' => __('Select a color for borders.', 'podcaster'),
                'default' => '#dddddd',
                'transparent' => false,
                'output'    => array(
                    'border-color' => '.single .caption-container.format-image, .single .caption-container.format-gallery'
                )
            ),
            array(
                'id'       => 'pod-single-image-header-caption-color',
                'type'     => 'color',
                'required' => array( 'pod-single-image-header-bg-color-activate', '=', true ),
                'title'    => __('Captions', 'podcaster'),
                'subtitle' => __('Select a color for captions.', 'podcaster'),
                'default' => '#444444',
                'transparent' => false,
                'output'    => array('color' => '.single .caption-container.format-image, .single .caption-container.format-gallery')
            ),
        )
    ) );
	Redux::setSection( $opt_name, array(
        'icon' => 'fas fa-pen-alt',
        'icon_class' => 'icon-large',
        'title' => __('Blog', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the blog. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-blog"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        //'fields' => array()
    ));
    Redux::setSection( $opt_name, array(
        'title'      => __( 'General', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the blog. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-blog"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-blog-general',
        'subsection' => true,
        'fields'     => array(
        	array(
			    'id'       => 'pod-blog-layout',
			    'type'     => 'image_select',
			    'title'    => __('Main layout', 'podcaster'),
			    'subtitle' => __('Select main content and sidebar alignment.', 'podcaster'),
			    'options'  => array(
			        'sidebar-left'      => array(
			            'alt'   => 'Sidebar Left',
			            'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
			        ),
			        'no-sidebar'      => array(
			            'alt'   => 'No Sidebar',
			            'img'   => ReduxFramework::$_url.'assets/img/1col.png'
			        ),
			        'sidebar-right'      => array(
			            'alt'   => 'Sidebar Right',
			            'img'  => ReduxFramework::$_url.'assets/img/2cr.png'
			        ),
			    ),
			    'default' => 'sidebar-right'
			),
            array(
                'id'       => 'pod-blog-header-raw',
                'type'     => 'raw',
                'title'  => __( '<h3>Header</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the header on the blog.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-blog-header-title',
                'type' => 'text',
                'title' => __('Title', 'podcaster'),
                'subtitle' => __('Enter a title.', 'podcaster'),
                'placeholder' => ''
            ),
            array(
                'id' => 'pod-blog-header-blurb',
                'type' => 'text',
                'title' => __('Blurb', 'podcaster'),
                'subtitle' => __('Enter a blurb.', 'podcaster'),
                'placeholder' => '',
            ),
        	array(
                'id' => 'pod-blog-header',
                'type' => 'media',
                'title' => __('Blog header', 'podcaster'),
                'subtitle' => __('Upload a header for your blog (1920px x 450px).', 'podcaster'),
                'placeholder' => $theme_options_img. '/img/header.jpg',
                'url' => false
            ),
            array(
	            'id' => 'pod-blog-bg-style',
	            'type' => 'radio',
	            'title' => __('Background style', 'podcaster'),
	            'subtitle' => __('Choose between stretched and tiled.', 'podcaster'),
	            'options' => array(
	                'background-repeat:repeat;' => 'Tiled',
	                'background-repeat:no-repeat; background-size:cover;' => 'Stretched',
	            ),
	            'default' => 'background-repeat:repeat;'
	        ),
            array(
                'id' => 'pod-blog-header-par',
                'type' => 'switch',
                'title' => __('Parallax', 'podcaster'),
                'subtitle' => __('Activate parallax scrolling for your blog header.', 'podcaster'),
                'default' => false,
            ),
            
            array(
                'id'       => 'pod-blog-posts-raw',
                'type'     => 'raw',
                'title'  => __( '<h3>Posts</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the posts on the blog.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-blog-posts-padding',
                'type'     => 'spacing',
                'mode'     => 'padding',
                'all'      => false,
                'top'           => true,     // Disable the top
                'right'         => true,     // Disable the right
                'bottom'        => true,     // Disable the bottom
                'left'          => true,     // Disable the left
                'units'         => 'px',      // You can specify a unit value. Possible: px, em, %
                'display_units' => 'true',   // Set to false to hide the units if the units are specified
                'title'    => __( 'Padding (posts)', 'podcaster' ),
                'subtitle' => __( 'Enter padding for the blog posts.', 'podcaster' ),
                'default'  => array(
                    'padding-top'    => '32px',
                    'padding-right'  => '32px',
                    'padding-bottom' => '32px',
                    'padding-left'   => '32px'
                )
            ),
            array(
                'id'       => 'pod-blog-widgets-padding',
                'type'     => 'spacing',
                'mode'     => 'padding',
                'all'      => false,
                'top'           => true,     // Disable the top
                'right'         => true,     // Disable the right
                'bottom'        => true,     // Disable the bottom
                'left'          => true,     // Disable the left
                'units'         => 'px',      // You can specify a unit value. Possible: px, em, %
                'display_units' => 'true',   // Set to false to hide the units if the units are specified
                'title'    => __( 'Padding (sidebar widgets)', 'podcaster' ),
                'subtitle' => __( 'Enter padding for the sidebar widgets.', 'podcaster' ),
                'default'  => array(
                    'padding-top'    => '24px',
                    'padding-right'  => '24px',
                    'padding-bottom' => '24px',
                    'padding-left'   => '24px'
                )
            ),
            array(
                'id' => 'pod-blog-excerpts',
                'type' => 'button_set',
                'title' => __('Excerpts', 'podcaster'),
                'subtitle' => __('Choose between forced excerpts or setthing them in post.', 'podcaster'),
                'options' => array(
                    'force' => 'Force Excerpts',
                    'set_in_post' => 'Set in Post',
                    ),
                'default' => 'force'
            ),
            array(
                'id' => 'pod-single-stand-feat-img-style',
                'type' => 'button_set',
                'title' => __('Featured image (Standard Format)', 'podcaster'),
                'subtitle' => __('Choose between stretched and auto width.', 'podcaster'),
                'options' => array(
                    'ft-image-stretched' => 'Stretched',
                    'ft-image-auto' => 'Auto',
                    ),
                'default' => 'ft-image-stretched'
            ),
            array(
                'id' => 'pod-blog-read-more-text',
                'type' => 'text',
                'title' => __('Read more', 'podcaster'),
                'subtitle' => __('Enter the text for your read more link.', 'podcaster'),
                'default' => 'Continue reading →',
            ),
            array(
                'id' => 'pod-blog-leave-comm-0-text',
                'type' => 'text',
                'title' => __('No comments', 'podcaster'),
                'subtitle' => __('Enter the text that will be displayed when there are no comments.', 'podcaster'),
                'default' => 'Leave a reply',
            ),
            array(
                'id' => 'pod-blog-leave-comm-1-text',
                'type' => 'text',
                'title' => __('One comment', 'podcaster'),
                'subtitle' => __('Enter the text that will be displayed when there is one comment.', 'podcaster'),
                'default' => '1 Reply',
            ),
            array(
                'id' => 'pod-blog-leave-comm-mul-text',
                'type' => 'text',
                'title' => __('Multiple comments', 'podcaster'),
                'subtitle' => __('Enter the text that will be displayed when there are more comments.', 'podcaster'),
                'default' => 'Replies',
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Colors', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the colors of the blog. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-blog"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-blog-colors',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-advanced-color-blog-settings',
                'type' => 'switch',
                'title' => __('Custom colors', 'podcaster'),
                'subtitle' => __('Activate custom color settings.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-color-bg-blog',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Background', 'podcaster'),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#e5e5e5',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.archive .main-content, .search .main-content, .blog .main-content')
            ),
            array(
                'id' => 'pod-color-bg-blog-posts',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Background Color (blog posts & sidebar widgets)', 'podcaster'),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.blog .entries .post, .search .entries .post, .archive .entries .post, .blog .sidebar .widget, .search .sidebar .widget, .archive .sidebar .widget, .blog .sidebar .widget:not(.widget_search):not(.thst_recent_blog_widget), .archive .sidebar .widget:not(.widget_search):not(.thst_recent_blog_widget), .search .sidebar .widget:not(.widget_search):not(.thst_recent_blog_widget), .blog .sidebar .widget, .archive .sidebar .widget, .post.format-video .video-caption, .post.format-audio .featured-media .audio-caption, .post.format-image .entry-featured .image-caption, .post.format-gallery .featured-gallery .gallery-caption, .blog .thst_highlight_category_widget ul li .text, .blog .widget.thst_recent_comments_widget ul li.recentcomments, .blog .widget.thst_recent_blog_widget .ui-tabs-panel article, .blog .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active, .archive .thst_highlight_category_widget ul li .text, .archive .widget.thst_recent_comments_widget ul li.recentcomments, .archive .widget.thst_recent_blog_widget .ui-tabs-panel article, .archive .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active, .search .thst_highlight_category_widget ul li .text, .search .widget.thst_recent_comments_widget ul li.recentcomments, .search .widget.thst_recent_blog_widget .ui-tabs-panel article, .search .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active')
            ),
            array(
                'id' => 'pod-color-border-blog-posts',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Borders', 'podcaster'),
                'subtitle' => __('Select a color for the borders.', 'podcaster'),
                'default' => '#eeeeee',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'border-color' => '.blog .post .entry-meta, .search .post .entry-meta, .archive .post .entry-meta, .blog .sidebar input[type="email"], .archive .sidebar input[type="email"], .search .sidebar input[type="email"], .blog .sidebar input[type="text"], .archive .sidebar input[type="text"], .search .sidebar input[type="text"],  .blog .thst_highlight_category_widget ul li .text, .blog .widget.thst_recent_comments_widget ul li.recentcomments, .blog .widget.thst_recent_blog_widget .ui-tabs-panel article, .archive .thst_highlight_category_widget ul li .text, .archive .widget.thst_recent_comments_widget ul li.recentcomments, .archive .widget.thst_recent_blog_widget .ui-tabs-panel article, .search .thst_highlight_category_widget ul li .text, .search .widget.thst_recent_comments_widget ul li.recentcomments, .search .widget.thst_recent_blog_widget .ui-tabs-panel article',
                    'border-bottom-color' => '.blog .thst_highlight_category_widget ul li:first-child .text.arrow::after, .archive .thst_highlight_category_widget ul li:first-child .text.arrow::after, .search .thst_highlight_category_widget ul li:first-child .text.arrow::after',

                    'background' => '.blog .widget #calendar_wrap #wp-calendar thead tr, .dark-template-active.blog .widget #calendar_wrap #wp-calendar thead tr, .blog .widget .tagcloud a:link, .blog .widget .tagcloud a:visited, .dark-template-active.blog .widget .tagcloud a:link, .dark-template-active.blog .widget .tagcloud a:visited, .blog .widget.thst_recent_blog_widget .ui-tabs-nav li, .blog .thst_highlight_category_widget ul li:first-child .text, .archive .widget.thst_recent_blog_widget .ui-tabs-nav li, .archive .thst_highlight_category_widget ul li:first-child .text, .search .widget.thst_recent_blog_widget .ui-tabs-nav li, .search .thst_highlight_category_widget ul li:first-child .text, .blog .widget.widget_search .search-container #s, .archive .widget.widget_search .search-container #s, .search .widget.widget_search .search-container #s')
            ),
            array(
                'id' => 'pod-color-blog-inputs-fields',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Sidebar inputs &fields', 'podcaster'),
                'subtitle' => __('Select a color for inputs and fields.', 'podcaster'),
                'default' => '#dddddd',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background' => '.blog .widget.widget_search .search-container #s, .archive .widget.widget_search .search-container #s, .search .widget.widget_search .search-container #s, .blog .thst_highlight_category_widget ul li:first-child .text, .archive .thst_highlight_category_widget ul li:first-child .text, .search .thst_highlight_category_widget ul li:first-child .text, .blog .widget.thst_recent_blog_widget .ui-tabs-nav li, .archive .widget.thst_recent_blog_widget .ui-tabs-nav li, .search .widget.thst_recent_blog_widget .ui-tabs-nav li',
                    'border-bottom-color' => '.blog .thst_highlight_category_widget ul li:first-child .text.arrow::after, .archive .thst_highlight_category_widget ul li:first-child .text.arrow::after, .search .thst_highlight_category_widget ul li:first-child .text.arrow::after',

                )
            ),
            array(
                'id' => 'pod-color-blog-post-heading',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Heading', 'podcaster'),
                'subtitle' => __('Select a color for the headings.', 'podcaster'),
                'default' => '#444444',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.blog .entries .post .entry-header .entry-title a:link, .blog .entries .post .entry-header .entry-title a:visited, .blog .sidebar h3, .archive .sidebar h3, .search .sidebar h3')
            ),
            array(
                'id' => 'pod-color-blog-post-heading-hover',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Heading (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the headings.', 'podcaster'),
                'default' => '#333333',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.blog .entries .post .entry-header .entry-title a:hover')
            ),
            array(
                'id' => 'pod-color-blog-post-text',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.blog .entries .post .entry-content, .blog .entries .post .entry-summary, .blog .sidebar .widget, .archive .sidebar .widget, .search .sidebar .widget, .blog .widget.thst_recent_blog_widget .ui-tabs-panel article .text .date, .archive .widget.thst_recent_blog_widget .ui-tabs-panel article .text .date, .search .widget.thst_recent_blog_widget .ui-tabs-panel article .text .date, .blog .thst_highlight_category_widget ul li:first-child .text .h_author, .archive .thst_highlight_category_widget ul li:first-child .text .h_author, .search .thst_highlight_category_widget ul li:first-child .text .h_author, .blog .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:link, .blog .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:visited, .archive .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:link, .archive .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:visited, .search .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:link, .search .widget.thst_recent_blog_widget .ui-tabs-nav li.ui-tabs-active a:visited')
            ),
            array(
                'id' => 'pod-color-blog-post-link',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Links', 'podcaster'),
                'subtitle' => __('Select a color for the links.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.blog .entries .post a:link, .blog .entries .post a:visited, .blog .sidebar .widget ul li a:link, .blog .sidebar .widget ul li a:visited, .archive .sidebar .widget ul li a:link, .archive .sidebar .widget ul li a:visited, .search .sidebar .widget ul li a:link, .search .sidebar .widget ul li a:visited, .blog .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:link, .blog .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:visited, .archive .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:link, .archive .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:visited, .search .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:link, .search .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:visited')
            ),
            array(
                'id' => 'pod-color-blog-post-link-hover',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Link (Hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the links.', 'podcaster'),
                'default' => '#1e7ce8',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.blog .entries .post a:hover, .blog .sidebar .widget ul li a:hover, .archive .sidebar .widget ul li a:hover, .search .sidebar .widget ul li a:hover, .blog .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:hover, .archive .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:hover, .search .widget.thst_recent_blog_widget .ui-tabs-panel article .text a:hover')
            ),
            array(
                'id' => 'pod-color-blog-post-pagination-bg',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Pagination background', 'podcaster'),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#282c2f',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.pagination a.page-numbers:link, .pagination a.page-numbers:visited, .pagination a.post-page-numbers:link, .pagination a.post-page-numbers:visited')
            ),
            array(
                'id' => 'pod-color-blog-post-pagination-color',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Pagination text', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.pagination a.page-numbers:link, .pagination a.page-numbers:visited, .pagination a.post-page-numbers:link, .pagination a.post-page-numbers:visited')
            ),
            array(
                'id' => 'pod-color-blog-post-pagination-bg-hover',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Pagination background (hover)', 'podcaster'),
                'subtitle' => __('Select a color for the background (hover).', 'podcaster'),
                'default' => '#17191a',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.pagination a.page-numbers:hover, .pagination a.post-page-numbers:hover')
            ),
            array(
                'id' => 'pod-color-blog-post-pagination-color-hover',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Pagination text (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for the text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.pagination a.page-numbers:hover, .pagination a.post-page-numbers:hover')
            ),
            array(
                'id' => 'pod-color-blog-post-pagination-bg-current',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Pagination background (current page)', 'podcaster'),
                'subtitle' => __('Select a color for the backgroound.', 'podcaster'),
                'default' => '#282c2f',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => '.pagination .page-numbers.current, .pagination .post-page-numbers.current')
            ),
            array(
                'id' => 'pod-color-blog-post-pagination-color-current',
                'type' => 'color',
                'required' => array('pod-advanced-color-blog-settings', '=', true),
                'title' => __('Pagination text (current page)', 'podcaster'),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => '.pagination .page-numbers.current, .pagination .post-page-numbers.current')
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Avatars & names', 'podcaster' ),
        'desc'       => __( '<p class="description">The settings below are for the avatars. Simply turn off or on what you would like to show. Make sure <strong>Show Avatars</strong> (found under Settings > Discussion) is turned on.<a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-blog"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-blog-avatars',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'pod-avatar-front',
                'type'     => 'switch',
                'title'    => __('Front Page Avatars', 'podcaster'),
                'subtitle' => __('Display avatars on the "From the blog" section on the front page.', 'podcaster'),
                'default'  => true,
            ),
            array(
                'id'       => 'pod-avatar-blog',
                'type'     => 'switch',
                'title'    => __('Blog Avatars', 'podcaster'),
                'subtitle' => __('Display avatars on the blog page.', 'podcaster'),
                'default'  => true,
            ),
            array(
                'id'       => 'pod-authname-blog',
                'type'     => 'switch',
                'title'    => __('Blog Author Name', 'podcaster'),
                'subtitle' => __('Display author name on the blog page.', 'podcaster'),
                'default'  => true,
            ),
            array(
                'id'       => 'pod-avatar-single',
                'type'     => 'switch',
                'title'    => __('Single Page Avatars', 'podcaster'),
                'subtitle' => __('Display avatars on single pages.', 'podcaster'),
                'default'  => true,
            ),
            array(
                'id'       => 'pod-authname-single',
                'type'     => 'switch',
                'title'    => __('Single Page Author Name', 'podcaster'),
                'subtitle' => __('Display author name on single pages.', 'podcaster'),
                'default'  => true,
            ),
            array(
                'id'       => 'pod-avatar-comments',
                'type'     => 'switch',
                'title'    => __('Comment Avatars', 'podcaster'),
                'subtitle' => __('Display avatars in the comment section.', 'podcaster'),
                'default'  => true,
            ),
            array(
                'id'       => 'pod-avatar-authorpages',
                'type'     => 'switch',
                'title'    => __('Author Pages Avatars', 'podcaster'),
                'subtitle' => __('Display avatars on author pages.', 'podcaster'),
                'default'  => true,
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Comments', 'podcaster' ),
        'desc'       => __( '<p class="description">Use the settings below to customize the comments section of the blog. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-blog"><span class="fas fa-question-circle"></span></a></p>', 'podcaster' ),
        'id'         => 'pod-subsection-blog-comments',
        'subsection' => true,
        'fields'     => array(
            array(
                'id' => 'pod-comments-display',
                'type' => 'switch',
                'title' => __('Comments section', 'podcaster'),
                'subtitle' => __('show or hide comments and trackbacks across the entire website.', 'podcaster'),
                'default' => true
            ),
            array(
                'id' => 'pod-comments-setup',
                'type' => 'radio',
                'required' => array('pod-comments-display', '=', true),
                'title' => __('Comments format', 'podcaster'),
                'subtitle' => __('Select whether you would like to display comments and trackbacks or comments only.', 'podcaster'),
                'options' => array(
                    'trackcomm' => 'Trackbacks & Comments',
                    'comm' => 'Comments Only'
                    ),
                'default' => 'comm'
            ),            
            array(
                'id' => 'pod-blog-comments-closed-text',
                'type' => 'text',
                'title' => __('Comments closed text', 'podcaster'),
                'subtitle' => __('Enter text, leave blank to hide.', 'podcaster'),
                'placeholder' => '',
                'default'   => __( 'Comments are closed.', 'podcaster' )
            ),
        )
    ) );
	Redux::setSection( $opt_name, array(
		'icon' => 'far fa-comment-dots',
        'icon_class' => 'icon-large',
        'title' => __('Social media', 'podcaster'),
		'desc' => __('<p class="description">Use the settings below to customize the social media links. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-social-media"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
		'fields' => array(
            array(
                'id'       => 'pod-social-nav',
                'type'     => 'switch',
                'title'    => __('Social media (Navigation)', 'podcaster'),
                'subtitle' => __('Display social media icons in the navigation bar.', 'podcaster'),
                'default'  => true,
            ),
            array(
                'id'       => 'pod-social-footer',
                'type'     => 'switch',
                'title'    => __('Social media (Footer)', 'podcaster'),
                'subtitle' => __('Display social media icons in the footer.', 'podcaster'),
                'default'  => true,
            ),
            array(
                'id'       => 'pod-social-color',
                'type'     => 'button_set',
                'title'    => __('Color', 'podcaster'),
                'subtitle' => __('Pick a color for your social media icons.', 'podcaster'),
                'options' => array(
                    'light-icons' => 'Light',
                    'dark-icons' => 'Dark'
                 ),
                'default' => 'light-icons'
            ),
			array(
                'id' => 'pod-email',
                'type' => 'text',
                'title' => __('Email Icon', 'podcaster'),
                'subtitle' => __('Paste the email address here.', 'podcaster'),
                'validate' => 'email',
                'placeholder' => 'hello@example.com',
            ),
            array(
                'id' => 'pod-rss',
                'type' => 'text',
                'title' => __('RSS Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-facebook',
                'type' => 'text',
                'title' => __('Facebook Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-twitter',
                'type' => 'text',
                'title' => __('Twitter Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-google',
                'type' => 'text',
                'title' => __('Google Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-instagram',
                'type' => 'text',
                'title' => __('Instagram Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-snapchat',
                'type' => 'text',
                'title' => __('Snapchat Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-tiktok',
                'type' => 'text',
                'title' => __('TikTok Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-periscope',
                'type' => 'text',
                'title' => __('Periscope Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),array(
                'id' => 'pod-telegram',
                'type' => 'text',
                'title' => __('Telegram Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-itunes',
                'type' => 'text',
                'title' => __('iTunes Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-soundcloud',
                'type' => 'text',
                'title' => __('Soundcloud Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            
            array(
                'id' => 'pod-spotify',
                'type' => 'text',
                'title' => __('Spotify Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-apple-podcasts',
                'type' => 'text',
                'title' => __('Apple Podcasts Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-stitcher',
                'type' => 'text',
                'title' => __('Stitcher Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-iheart-radio',
                'type' => 'text',
                'title' => __('iHeart Radio Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-google-podcasts',
                'type' => 'text',
                'title' => __('Google Podcasts Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-pocket-casts',
                'type' => 'text',
                'title' => __('Pocket Casts Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-mixcloud',
                'type' => 'text',
                'title' => __('Mixcloud Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-tumblr',
                'type' => 'text',
                'title' => __('Tumblr Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-medium',
                'type' => 'text',
                'title' => __('Medium Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-pinterest',
                'type' => 'text',
                'title' => __('Pinterest Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-flickr',
                'type' => 'text',
                'title' => __('Flickr Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-youtube',
                'type' => 'text',
                'title' => __('Youtube Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-vimeo',
                'type' => 'text',
                'title' => __('Vimeo Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-twitch',
                'type' => 'text',
                'title' => __('Twitch Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-android',
                'type' => 'text',
                'title' => __('Android Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-skype',
                'type' => 'text',
                'title' => __('Skype Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-whatsapp',
                'type' => 'text',
                'title' => __('Whatsapp Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-dribbble',
                'type' => 'text',
                'title' => __('Dribbble Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-weibo',
                'type' => 'text',
                'title' => __('Weibo Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),

            array(
                'id' => 'pod-patreon',
                'type' => 'text',
                'title' => __('Patreon Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-paypal',
                'type' => 'text',
                'title' => __('Paypal Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),

            array(
                'id' => 'pod-foursquare',
                'type' => 'text',
                'title' => __('Foursquare Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-github',
                'type' => 'text',
                'title' => __('Github Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-xing',
                'type' => 'text',
                'title' => __('Xing Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),
            array(
                'id' => 'pod-linkedin',
                'type' => 'text',
                'title' => __('Linkedin Icon', 'podcaster'),
                'subtitle' => __('Paste the url of your profile here.', 'podcaster'),
                'validate' => 'url',
                'placeholder' => 'http://www.example.com/',
            ),

        )
    ) );
	Redux::setSection( $opt_name, array(
        'icon' => 'fa fa-paperclip',
        'title' => __('Footer', 'podcaster'),
        'desc' => __('<p class="description">Use the settings below to customize the website footer. <a target="_blank" rel="noopener noreferrer" href="http://themestation.co/documentation/podcaster/#to-footer"><span class="fas fa-question-circle"></span></a></p>', 'podcaster'),
        'fields' => array(
        	array(
				'id'=>'pod-footer-text',
				'type' => 'editor',
				'title' => __('Footer Text', 'podcaster'),
				'subtitle' => __('Enter text for the footer area.', 'podcaster'),
				'default' => 'Powered by Podcaster for WordPress.',
			),
			array(
                'id' => 'pod-footer-copyright',
                'type' => 'text',
                'title' => __('Copyright Text', 'podcaster'),
                'subtitle' => __('Enter the text for the copyright area.', 'podcaster'),
                'validate' => 'no_html',
                'placeholder' =>  get_bloginfo( 'name' ). ' &copy; ' . date("Y"),
                'default' =>  get_bloginfo( 'name' ). ' &copy; ' .  date("Y"),
            ),
            array(
                'id'       => 'pod-color-footer-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Colors</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are for the footer section of the website.', 'podcaster' ),
            ),
            array(
                'id' => 'pod-footer-advanced-color-settings',
                'type' => 'switch',
                'title' => __('Custom colors', 'podcaster'),
                'subtitle' => __('Activate custom color settings.', 'podcaster'),
                'default' => false
            ),
            array(
                'id' => 'pod-footer-color-bg',
                'type' => 'color',
                'title' => __('Background', 'podcaster'),
                'required' => array( 'pod-footer-advanced-color-settings', '=', true ),
                'subtitle' => __('Select a color for the background.', 'podcaster'),
                'default' => '#d5d5d5',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'background-color' => 'footer.main-footer .footer-widgets')
            ),
            array(
                'id' => 'pod-footer-color-text',
                'type' => 'color',
                'title' => __('Text', 'podcaster'),
                'required' => array( 'pod-footer-advanced-color-settings', '=', true ),
                'subtitle' => __('Select a color for the text.', 'podcaster'),
                'default' => '#555555',
                'validate' => 'color',
                'transparent' => false,
                'output'    => array(
                    'color' => 'footer.main-footer .footer-widgets')
            ),
            array(
                'id'       => 'pod-color-footer-navigation-raw-title',
                'type'     => 'raw',
                'title'  => __( '<h3>Footer Navigation</h3>', 'podcaster' ),
                'content'  => __( 'The settings below are fore the footer navigation of the website.', 'podcaster' ),
            ),
            array(
                'id'       => 'pod-footer-navigation',
                'type'     => 'color',
                'title'    => __('Background', 'podcaster'),
                'subtitle' => __('Select a color for the background of the footer navigation.', 'podcaster'),
                'default' => '#282d31',
                'transparent' => false,
                'output'    => array('background-color' => '.sub-footer')
            ),
            array(
                'id'       => 'pod-footer-navigation-text',
                'type'     => 'color',
                'title'    => __('Text', 'podcaster'),
                'subtitle' => __('Select a color for text of the footer navigation.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array('color' => '.sub-footer')
            ),
            array(
                'id'       => 'pod-footer-navigation-link',
                'type'     => 'color',
                'title'    => __('Links', 'podcaster'),
                'subtitle' => __('Select a color for links of the footer navigation.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array('color' => '.sub-footer a:link, .sub-footer a:visited')
            ),
            array(
                'id'       => 'pod-footer-navigation-hover',
                'type'     => 'color',
                'title'    => __('Links (hover)', 'podcaster'),
                'subtitle' => __('Select a color (hover) for links of the footer navigation.', 'podcaster'),
                'default' => '#ffffff',
                'transparent' => false,
                'output'    => array('color' => '.sub-footer a:hover')
            ),
        )
    ) );
	Redux::setSection( $opt_name, array(
		'type' => 'divide',
	));




    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     *
    * function pod_compiler_action( $options, $css, $changed_values ) {
    *     echo '<h1>The compiler hook has run!</h1>';
    *     echo "<pre>";
    *     print_r( $changed_values ); // Values that have changed since the last save
    *     echo "</pre>";
    *     //print_r($options); //Option values
    *     //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
    *  }
    */

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if( ! function_exists( 'pod_dynamic_section' ) ) {
        function pod_dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'podcaster' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'podcaster' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if( ! function_exists( 'pod_change_arguments' ) ) {
        function pod_change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if( ! function_exists( 'pod_change_defaults' ) ) {
        function pod_change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    // Remove the demo link and the notice of integrated demo from the redux-framework plugin
    if( ! function_exists( 'pod_remove_demo' ) ) {
        function pod_remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }