<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category Podcaster
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'cmb_';
	$options = get_option('podcaster-theme');	
	$activepp_plugin = get_pod_plugin_active();
	
	if( pod_theme_option('pod-featured-header-type') == 'static-posts' || pod_theme_option('pod-featured-header-type') == 'slideshow' ){
		$meta_boxes[] = array(
			'id'         => 'thst_featured_post',
			'title'      => __( 'Featured Post', 'thstlang' ),
			'pages'      => array( 'post', 'podcast' ), 
			'context'    => 'side',
			'priority'   => 'default',
			'show_names' => true, 
			'fields'     => array(
				array(
					'name' => __( 'Feature Post', 'thstlang' ),
					'desc' => __( 'Tick the box to feature this post on the front page.', 'thstlang' ),
					'id'   => $prefix . 'thst_feature_post',
					'type' => 'checkbox',
				),
				array(
					'name' => __( 'Featured Post Header', 'thstlang' ),
					'desc' => __( 'Upload an image or enter an URL.', 'thstlang' ),
					'id'   => $prefix . 'thst_feature_post_img',
					'type' => 'file',
					'allow' => array( 'url', 'attachment' )
				),
				array(
					'name'    => __( 'Alignment', 'thstlang' ),
					'desc'    => __( 'Select the alignment of your header.', 'thstlang' ),
					'id'      => $prefix . 'thst_feature_post_align',
					'type'    => 'select',
					'options' => array(
						array( 'name' => __( 'Left', 'thstlang' ), 'value' => 'text-align:left;', ),
						array( 'name' => __( 'Center', 'thstlang' ), 'value' => 'text-align:center;', ),
						array( 'name' => __( 'Right', 'thstlang' ), 'value' => 'text-align:right;', ),
					),
				),
				array(
					'name'    => __( 'Background Style', 'thstlang' ),
					'desc'    => __( 'Choose how you would like to display the background image.', 'thstlang' ),
					'id'      => $prefix . 'thst_page_header_bgstyle',
					'type'    => 'radio',
					'options' => array(
						array( 'name' => __( 'Tiled', 'thstlang' ), 'value' => 'background-size:contain;', ),
						array( 'name' => __( 'Stretched', 'thstlang' ), 'value' => 'background-size:cover;', ),
					),
					'default' => 'background-size:cover;',
				),
				array(
					'name' => __( 'Display Excerpt', 'thstlang' ),
					'desc' => __( 'Tick the box to display an excerpt.', 'thstlang' ),
					'id'   => $prefix . 'thst_feature_post_excerpt',
					'type' => 'checkbox',
				),
				array(
				    'name' => 'Excerpt Word Count',
				    'desc' => 'Enter the amount of words you want to display in your excerpt. Leaving it blank with default to 25 words.',
				    'id' => $prefix . 'thst_featured_post_excerpt_count',
				    'type' => 'text_small'
				),
				array(
					'name' => __( 'Parallax', 'thstlang' ),
					'desc' => __( 'Tick the box to activate parallax.(Parallax is not supported if the slideshow is active.)', 'thstlang' ),
					'id'   => $prefix . 'thst_feature_post_para',
					'type' => 'checkbox',
				),
			)
		);
	}

	if( $activepp_plugin != 'bpp' && $activepp_plugin != 'ssp' ) {
		
		$meta_boxes[] = array(
			'id'         => 'thst_featured_audio',
			'title'      => __( 'Featured Audio', 'thstlang' ),
			'pages'      => array( 'post' ), 
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, 
			'fields'     => array(
				array(
				    'name'    => 'Audio Type',
				    'id'      => $prefix . 'thst_audio_type',
				    'type'    => 'radio_inline',
				    'options' => array(
				        'audio-url' => __( 'Audio File (URL)', 'thstlang' ),
				        'audio-embed-url'   => __( 'Audio Embed (URL)', 'thstlang' ),
				        'audio-embed-code'     => __( 'Audio Embed (Code)', 'thstlang' ),
				        'audio-playlist'     => __( 'Audio Playlist', 'thstlang' ),
				    ),
				    'default' => 'audio-url',
				),
				array(
					'name' => __( 'Audio URL', 'thstlang' ),
					'desc' => __( 'Upload an audio file or enter a URL that ends with a file extension, such as <strong>*.mp3</strong>.', 'thstlang' ),
					'id'   => $prefix . 'thst_audio_url',
					'type' => 'file',
				),
				array(
					'name' => __( 'Audio Embed URL', 'thstlang' ),
					'desc' => __( 'Enter your embed URL here. URL\'s posted here should  not end on <strong>*.mp3</strong> or other file extensions. Supported websites are: YouTube, Vimeo, Hulu, DailyMotion, Flickr Video and Qik.', 'thstlang' ),
					'id'   => $prefix . 'thst_audio_embed',
					'type' => 'oembed',
				),
				array(
					'name' => __( 'Audio Embed Code', 'thstlang' ),
					'desc' => __( 'Paste your embed code here.', 'thstlang' ),
					'id'   => $prefix . 'thst_audio_embed_code',
					'type' => 'textarea_code',
				),
				
				array(
					'name' => __( 'Audio Playlist', 'thstlang' ),
					'desc' => __( 'Upload audio to be displayed in a playlist. (Only works with uploads.)', 'thstlang' ),
					'id'   => $prefix . 'thst_audio_playlist',
					'type' => 'file_list',
				),
				array(
					'name' => __( 'Audio Caption', 'thstlang' ),
					'desc' => __( 'Enter a short audio caption.(optional)', 'thstlang' ),
					'id'   => $prefix . 'thst_audio_capt',
					'type' => 'text',
				),
				array(
					'name' => __( 'Allow Download', 'thstlang' ),
					'desc' => __( 'Check this box if you would like your users to be able to download your audio file. (Might not work with files hosted on Soundcloud.)', 'thstlang' ),
					'id'   => $prefix . 'thst_audio_download',
					'type' => 'checkbox',
				),
				array(
					'name' => __( 'Explicit', 'thstlang' ),
					'desc' => __( 'Please check this box if you would like your post to be marked as explicit.', 'thstlang' ),
					'id'   => $prefix . 'thst_audio_explicit',
					'type' => 'checkbox',
				),
			),
		);
		$meta_boxes[] = array(
			'id'         => 'thst_featured_video',
			'title'      => __( 'Featured Video', 'thstlang' ),
			'pages'      => array( 'post' ), 
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, 
			'fields'     => array(
				array(
				    'name'    => 'Video Type',
				    'id'      => $prefix . 'thst_video_type',
				    'type'    => 'radio_inline',
				    'options' => array(
				        'video-oembed' => __( 'Video oEmbed Code', 'thstlang' ),
				        'video-embed-url'   => __( 'Video Embed Code', 'thstlang' ),
				        'video-url'     => __( 'Video URL', 'thstlang' ),
				        'video-playlist'     => __( 'Video Playlist', 'thstlang' ),
				    ),
				    'default' => 'video-oembed',
				),
				array(
					'name' => __( 'Video oEmbed Code', 'thstlang' ),
					'desc' => __( 'Enter your oembed code here. Supported websites are: YouTube, Vimeo, Hulu, DailyMotion, Flickr Video and Qik.', 'thstlang' ),
					'id'   => $prefix . 'thst_video_embed',
					'type' => 'oembed',
				),
				array(
					'name' => __( 'Video Embed Code', 'thstlang' ),
					'desc' => __( 'Paste your embed code here.', 'thstlang' ),
					'id'   => $prefix . 'thst_video_embed_code',
					'type' => 'textarea_code',
				),
				array(
					'name' => __( 'Video URL', 'thstlang'),
					'desc' => __( 'Upload a video file or enter an URL.', 'thstlang' ),
					'id'   => $prefix . 'thst_video_url',
					'type' => 'file',
				),
				array(
					'name' => __( 'Video Playlist', 'thstlang' ),
					'desc' => __( 'Upload videos to be displayed in a playlist.(Only works with uploads.)', 'thstlang' ),
					'id'   => $prefix . 'thst_video_playlist',
					'type' => 'file_list',
				),
				array(
					'name' => __( 'Thumbnail', 'thstlang' ),
					'desc' => __( 'Upload a thumnail for your video. You only need to do this if you are hosting it yourself.', 'thstlang' ),
					'id'   => $prefix . 'thst_video_thumb',
					'type' => 'file',
				),
				array(
					'name' => __( 'Caption', 'thstlang' ),
					'desc' => __( 'Enter a short video caption.(optional)', 'thstlang' ),
					'id'   => $prefix . 'thst_video_capt',
					'type' => 'text',
				),
				array(
					'name' => __( 'Allow Download', 'thstlang' ),
					'desc' => __( 'Check this box if you would like your users to be able to download your video file. (Only works with self-hosted files.)', 'thstlang' ),
					'id'   => $prefix . 'thst_video_download',
					'type' => 'checkbox',
				),
				array(
					'name' => __( 'Explicit', 'thstlang' ),
					'desc' => __( 'Please check this box if you would like your post to be marked as explicit.', 'thstlang' ),
					'id'   => $prefix . 'thst_video_explicit',
					'type' => 'checkbox',
				),
			),
		);
	}

	$meta_boxes[] = array(
		'id'         => 'thst_featured_gallery',
		'title'      => __( 'Featured Gallery', 'thstlang' ),
		'pages'      => array( 'post' ), 
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, 
		'fields'     => array(
			array(
				'name' => __( 'Images', 'thstlang' ),
				'desc' => __( 'Upload images that will be displayed in your gallery.', 'thstlang' ),
				'id'   => $prefix . 'thst_gallery_list',
				'type' => 'file_list',
			),
			array(
				'name' => __( 'Caption', 'thstlang'),
				'desc' => __( 'Enter a short gallery caption.(optional)', 'thstlang'),
				'id'   => $prefix . 'thst_gallery_capt',
				'type' => 'text',
			),
			array(
				'name'    => __( 'Style', 'thstlang' ),
				'desc'    => __( 'Choose how you would like to display your gallery.', 'thstlang' ),
				'id'      => $prefix . 'thst_post_gallery_style',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Slideshow', 'thstlang' ), 'value' => 'slideshow', ),
					array( 'name' => __( 'Grid', 'thstlang' ), 'value' => 'grid', ),
				),
			),
			array(
				'name'    => __( 'Columns', 'thstlang' ),
				'desc'    => __( 'Choose the amount of columns (only when set to grid)', 'thstlang' ),
				'id'      => $prefix . 'thst_gallery_col',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __( '3 Columns', 'thstlang' ), 'value' => 'three', ),
					array( 'name' => __( '4 Columns', 'thstlang' ), 'value' => 'four', ),
					array( 'name' => __( '5 Columns', 'thstlang' ), 'value' => 'five', ),
					array( 'name' => __( '6 Columns', 'thstlang' ), 'value' => 'six', ),
					array( 'name' => __( '7 Columns', 'thstlang' ), 'value' => 'seven', ),
					array( 'name' => __( '8 Columns', 'thstlang' ), 'value' => 'eight', ),
				),
			),
		),
	);
	
	
	$meta_boxes[] = array(
		'id'         => 'thst_page_subtitle',
		'title'      => __( 'Page Header Subtitle', 'thstlang' ),
		'pages'      => array( 'page' ), 
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, 
		'fields'     => array(
			array(
				'name'    => __( 'Text Alignment', 'thstlang' ),
				'desc'    => __( 'Align the heading text to the left (default), center or right.', 'thstlang' ),
				'id'      => $prefix . 'thst_page_header_align',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Left', 'thstlang' ), 'value' => 'text-align:left;', ),
					array( 'name' => __( 'Center', 'thstlang' ), 'value' => 'text-align:center;', ),
					array( 'name' => __( 'Right', 'thstlang' ), 'value' => 'text-align:right;', ),
				),
			),
			array(
				'name' => __( 'Short Blurb', 'thstlang'),
				'desc' => __( 'Submit a short blub or summery of your page that will appear below the title.', 'thstlang' ),
				'id'   => $prefix . 'thst_page_subtitle',
				'type' => 'text',
			),
			array(
				'name'    => __( 'Background Style', 'thstlang' ),
				'desc'    => __( 'Select whether you would like to display your background stretched or tiled.', 'thstlang' ),
				'id'      => $prefix . 'thst_page_header_bg_style',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => __( 'Tiled', 'thstlang' ), 'value' => 'background-repeat:repeat, no-repeat;', ),
					array( 'name' => __( 'Streched', 'thstlang'), 'value' => 'background-repeat:no-repeat; background-size:cover;', ),
				),
			),
			array(
				'name' => __( 'Parallax', 'thstlang' ),
				'desc' => __( 'Select if you would like to activate parallax.', 'thstlang' ),
				'id'   => $prefix . 'thst_page_header_parallax',
				'type' => 'checkbox',
				'std'  => ''
			),
		)
	);
	


	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}