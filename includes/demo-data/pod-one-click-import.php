<?php

/* One Click Demo Imports*/
function ocdi_import_files() {
	return array(
		array(
			'import_file_name'           => 'Main New',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/main-new-demo/podcaster-customizer-main-new.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-main-new.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-main-new/',
		),
		array(
			'import_file_name'           => 'Environment',
			'categories'                 => array('Video background', 'Grid', 'Full width'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_sc_classic.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/environment-demo/podcaster-customizer-environment.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-enviro.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-environment/',
		),
		array(
			'import_file_name'           => 'Hype',
			'categories'                 => array('Grid', 'Soundcloud', 'Dark'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_sc.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/hype-demo/podcaster-customizer-hype.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-hype.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-hype/',
		),
		array(
			'import_file_name'           => 'Tropical',
			'categories'                 => array('Grid', 'Video'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_video.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/tropical-demo/podcaster-customizer-tropical.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-tropical.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-tropical/',
		),
		array(
			'import_file_name'           => 'Sans',
			'categories'                 => array('Grid', 'Light'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_playlist_audio.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/sans-demo/podcaster-customizer-sans.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-sans.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-sans/',
		),
		array(
			'import_file_name'           => 'Adventure',
			'categories'                 => array('Video background', 'Grid', 'Dark', 'Video'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_video.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/adventure-demo/podcaster-customizer-adventure.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-adventure.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-adventure/',
		),



		array(
			'import_file_name'           => 'Songbird',
			'categories'                 => array('Light'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/songbird-demo/podcaster-customizer-songbird.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-songbird.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-songbird/',
		),



		array(
			'import_file_name'           => 'Neon',
			'categories'                 => array('Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/neon-demo/podcaster-customizer-neon.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-neon.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-neon/',
		),
		array(
			'import_file_name'           => 'Finance',
			'categories'                 => array('Slideshow', 'Dark'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/finance-demo/podcaster-customizer-finance.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-finance.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-finance/',
		),
		array(
			'import_file_name'           => 'Mindfulness',
			'categories'                 => array('Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/mindfulness-demo/podcaster-customizer-mindfulness.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-mindfulness.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-mindfulness/',
		),
		array(
			'import_file_name'           => 'Light',
			'categories'                 => array('Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/light-demo/podcaster-customizer-light.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-light.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-light/',
		),
		array(
			'import_file_name'           => 'Dark',
			'categories'                 => array('Dark', 'Video', 'Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_video.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/dark-demo/podcaster-customizer-dark.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-dark.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-dark/',
		),
		array(
			'import_file_name'           => 'Modern',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/modern-demo/podcaster-customizer-modern.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-modern.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-modern/',
		),
		array(
			'import_file_name'           => 'Minimal',
			'categories'                 => array('Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/minimal-demo/podcaster-customizer-minimal.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-minimal.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-minimal/',
		),
		array(
			'import_file_name'           => 'Cooking',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/cooking-demo/podcaster-customizer-cooking.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-cooking.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-cooking/',
		),
		array(
			'import_file_name'           => 'Main',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/main-demo/podcaster-customizer-main.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-main.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-main/',
		),
		array(
			'import_file_name'           => 'Grid',
			'categories'                 => array( 'Text', 'Dark', 'Grid' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/grid-demo/podcaster-customizer-grid.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-grid-dark.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-grid/',
		),
		array(
			'import_file_name'           => 'Grid Light',
			'categories'                 => array( 'Text', 'Grid', 'Light' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/grid-light-demo/podcaster-customizer-grid-light.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-grid-light.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-grid-light/',
		),
		array(
			'import_file_name'           => 'Writer',
			'categories'                 => array('Light'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/writer-demo/podcaster-customizer-writer.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-writer.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-writer/',
		),
		array(
			'import_file_name'           => 'Friends',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/friends-demo/podcaster-customizer-friends.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-friends.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-friends/',
		),
		array(
			'import_file_name'           => 'Bold',
			'categories'                 => array( 'Simplecast', 'Dark', 'Blog' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_fp_blog.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/bold-demo/podcaster-customizer-bold.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-bold.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-bold/',
		),
		array(
			'import_file_name'           => 'Corporate',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/corporate-demo/podcaster-customizer-corporate.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-corporate.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-corporate/',
		),
		array(
			'import_file_name'           => 'Green',
			'categories'                 => array( 'Text' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/green-demo/podcaster-customizer-green.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-green.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-green/',
		),
		array(
			'import_file_name'           => 'Orange',
			'categories'                 => array( 'Video' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_video.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/orange-demo/podcaster-customizer-orange.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-orange.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-art/',
		),
		array(
			'import_file_name'           => 'Circle',
			'categories'                 => array( 'Dark' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/circle-demo/podcaster-customizer-circle.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-circle.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-circle/',
		),
		array(
			'import_file_name'           => 'Creativa',
			'categories'                 => array( 'Soundcloud', 'Light' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/creativa-demo/podcaster-customizer-creativa.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-creativa.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-creativa/',
		),
		array(
			'import_file_name'           => 'Note',
			'categories'                 => array( 'Blog' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_fp_blog_sidebar.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/note-demo/podcaster-customizer-note.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-note.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-note/',
		),
		array(
			'import_file_name'           => 'Golden',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/golden-demo/podcaster-customizer-golden.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-golden.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-golden/',
		),
		array(
			'import_file_name'           => 'Bleu',
			'categories'                 => array( 'Video', 'Dark' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data/podcaster_import_video.xml',
			'import_customizer_file_url' => get_template_directory_uri() . '/includes/demo-data/bleu-demo/podcaster-customizer-bleu.dat',
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-video.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-video/',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );



function ocdi_plugin_page_setup( $default_settings ) {

	$default_settings['parent_slug'] = 'pod-theme-options';
	$default_settings['page_title']  = esc_html__( 'One Click Demo Import' , 'podcaster' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'podcaster' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'pt-one-click-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'ocdi_plugin_page_setup');



// Remove branding
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );



// Change/Hide Intro Text
//add_filter( 'pt-ocdi/plugin_intro_text', '__return_false' );
function ocdi_plugin_intro_text( $default_text ) {
	$default_text = '<div class="ocdi__intro-notice  notice  notice-warning  is-dismissible">
		<p>' . esc_html( "Before you begin, make sure all the required plugins are activated.", "podcaster" ) . '</p>
	</div>';
	$default_text .= '<hr><div class="ocdi__intro-text">	<p class="about-description">' .
			esc_html( "Importing demo data (post, pages, images, theme settings, menus & widgets) is the easiest way to setup your theme.", "podcaster" );
			esc_html( "It will allow you to quickly edit everything instead of creating content from scratch.", "podcaster" );

	$default_text .= '<p>'. esc_html( 'When you import the data, the following things might happen:', 'podcaster' ) . '</p>

		<ul>
			<li>' . esc_html( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'podcaster' ) . '</li>
			<li>' . esc_html( 'Posts, pages, images, widgets, menus and other theme settings will get imported.', 'podcaster' ) . '</li>
			<li>' . esc_html( 'Please click on the Import button only once and wait, it can take a couple of minutes.', 'podcaster' ) . '</li>
		</ul>';
	
	$default_text .= '<hr>';

	return $default_text;
}
//add_filter( 'pt-ocdi/plugin_intro_text', 'ocdi_plugin_intro_text' );


// Designate "front page" and "blog" pages
function ocdi_after_import_setup() {

	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Header Menu Demo', 'nav_menu' );
	$nav_locations = get_theme_mod('nav_menu_locations');

	if( ! $nav_locations ) {
		set_theme_mod( 'nav_menu_locations', array(
				'header-menu' => $main_menu->term_id, // replace 'main-menu' here with the menu location identifier from register_nav_menu() function
				'footer-menu' => $main_menu->term_id, // replace 'main-menu' here with the menu location identifier from register_nav_menu() function
			)
		);
	}

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Front Page' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );