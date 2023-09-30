<?php

/* One Click Demo Imports*/
function ocdi_import_files() {
	return array(
		array(
			'import_file_name'           => 'Main New',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/main-new-demo/main-new-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-main-new.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-main-new/',
		),
		array(
			'import_file_name'           => 'Summer',
			'categories'                 => array('Full width'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/summer-demo/summer-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-summer.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-summer/',
		),
		array(
			'import_file_name'           => 'Fresh Apple',
			'categories'                 => array('Full width'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/fresh-apple-demo/fresh-apple-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-fresh-apple.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-apple/',
		),
		array(
			'import_file_name'           => 'Environment',
			'categories'                 => array('Video background', 'Grid', 'Full width'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_sc_classic.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/environment-demo/environment-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-enviro.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-environment/',
		),
		array(
			'import_file_name'           => 'Hype',
			'categories'                 => array('Grid', 'Soundcloud', 'Dark'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_sc.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/hype-demo/hype-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-hype.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-hype/',
		),
		array(
			'import_file_name'           => 'Tropical',
			'categories'                 => array('Grid', 'Video'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_video.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/tropical-demo/tropical-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-tropical.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-tropical/',
		),
		array(
			'import_file_name'           => 'Sans',
			'categories'                 => array('Grid', 'Light'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_playlist_audio.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/sans-demo/sans-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-sans.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-sans/',
		),
		array(
			'import_file_name'           => 'Adventure',
			'categories'                 => array('Video background', 'Grid', 'Dark', 'Video'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_video.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/adventure-demo/adventure-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-adventure.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-adventure/',
		),



		array(
			'import_file_name'           => 'Songbird',
			'categories'                 => array('Light'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/songbird-demo/songbird-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-songbird.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-songbird/',
		),



		array(
			'import_file_name'           => 'Neon',
			'categories'                 => array('Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/neon-demo/neon-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-neon.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-neon/',
		),
		array(
			'import_file_name'           => 'Finance',
			'categories'                 => array('Slideshow', 'Dark'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/finance-demo/finance-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-finance.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-finance/',
		),
		array(
			'import_file_name'           => 'Mindfulness',
			'categories'                 => array('Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/mindfulness-demo/mindfulness-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-mindfulness.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-mindfulness/',
		),
		array(
			'import_file_name'           => 'Light',
			'categories'                 => array('Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/light-demo/light-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-light.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-light/',
		),
		array(
			'import_file_name'           => 'Dark',
			'categories'                 => array('Dark', 'Video', 'Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_video.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/dark-demo/dark-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-dark.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-dark/',
		),
		array(
			'import_file_name'           => 'Modern',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/modern-demo/modern-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-modern.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-modern/',
		),
		array(
			'import_file_name'           => 'Minimal',
			'categories'                 => array('Grid'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/minimal-demo/minimal-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-minimal.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-minimal/',
		),
		array(
			'import_file_name'           => 'Cooking',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/cooking-demo/cooking-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-cooking.png',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'https://demo.themestation.net/podcaster-cooking/',
		),
		array(
			'import_file_name'           => 'Main',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/main-demo/main-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-main.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-main/',
		),
		array(
			'import_file_name'           => 'Grid',
			'categories'                 => array( 'Text', 'Dark', 'Grid' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/grid-demo/grid-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-grid-dark.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-grid/',
		),
		array(
			'import_file_name'           => 'Grid Light',
			'categories'                 => array( 'Text', 'Grid', 'Light' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/grid-light-demo/grid-light-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-grid-light.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-grid-light/',
		),
		array(
			'import_file_name'           => 'Writer',
			'categories'                 => array('Light'),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/writer-demo/writer-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-writer.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-writer/',
		),
		array(
			'import_file_name'           => 'Friends',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/friends-demo/friends-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-friends.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-friends/',
		),
		array(
			'import_file_name'           => 'Bold',
			'categories'                 => array( 'Simplecast', 'Dark', 'Blog' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_fp_blog.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/bold-demo/bold-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-bold.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-bold/',
		),
		array(
			'import_file_name'           => 'Corporate',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/corporate-demo/corporate-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-corporate.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-corporate/',
		),
		array(
			'import_file_name'           => 'Green',
			'categories'                 => array( 'Text' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/green-demo/green-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-green.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-green/',
		),
		array(
			'import_file_name'           => 'Orange',
			'categories'                 => array( 'Video' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_video.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/orange-demo/orange-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-orange.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-art/',
		),
		array(
			'import_file_name'           => 'Circle',
			'categories'                 => array( 'Dark' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/circle-demo/circle-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-circle.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-circle/',
		),
		array(
			'import_file_name'           => 'Creativa',
			'categories'                 => array( 'Soundcloud', 'Light' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/creativa-demo/creativa-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-creativa.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-creativa/',
		),
		array(
			'import_file_name'           => 'Note',
			'categories'                 => array( 'Blog' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_fp_blog_sidebar.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/note-demo/note-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-note.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-note/',
		),
		array(
			'import_file_name'           => 'Golden',
			'categories'                 => array(),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/golden-demo/golden-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
			'import_preview_image_url'   => get_template_directory_uri() . '/img/demo-data/podcaster-golden.jpg',
			'import_notice'              => __( 'The import process might take a few minutes, please do not close the window.', 'podcaster' ),
			'preview_url'                => 'http://demo.themestation.co/podcaster-golden/',
		),
		array(
			'import_file_name'           => 'Bleu',
			'categories'                 => array( 'Video', 'Dark' ),
			'import_file_url'            => get_template_directory_uri() . '/includes/demo-data-old/podcaster_import_video.xml',
			'import_redux'               => array(
				array(
					'file_url'    => get_template_directory_uri() . '/includes/demo-data-old/bleu-demo/bleu-demo.json',
					'option_name' => 'podcaster-theme',
				),
			),
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