<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category Podcaster
 * @package  podcaster
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */


$podcast_plugin_active = pod_get_plugin_active();

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 $cmb CMB2 object.
 *
 * @return bool      True if metabox should show
 */
function podmetab_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field $field Field object.
 *
 * @return bool              True if metabox should show
 */
function podmetab_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}


if( $podcast_plugin_active == "ssp" ) {
	/**
	 * Gets a number of terms and displays them as options
	 * @param  string       $taxonomy Taxonomy terms to retrieve. Default is category.
	 * @param  string|array $args     Optional. get_terms optional arguments
	 * @return array                  An array of options that matches the CMB2 options array
	 */
	function cmb2_get_term_options2( $taxonomy = array('series', 'category' ), $args = array() ) {

	    $args['taxonomy'] = $taxonomy;

	    $args = wp_parse_args( $args, array( 'taxonomy' => array('series', 'category' ) ) );

	    $taxonomy = $args['taxonomy'];

	    $terms = (array) get_terms( $taxonomy, $args );

	    // Initate an empty array
	    $term_options = array();
	    if ( ! empty( $terms ) ) {
	        foreach ( $terms as $term ) {
	            $term_options[ $term->term_id ] = $term->name;
	        }
	    }

	    return $term_options;
	}
} else {
	/**
	 * Gets a number of terms and displays them as options
	 * @param  string       $taxonomy Taxonomy terms to retrieve. Default is category.
	 * @param  string|array $args     Optional. get_terms optional arguments
	 * @return array                  An array of options that matches the CMB2 options array
	 */
	function cmb2_get_term_options( $taxonomy = 'category', $args = array() ) {

	    $args['taxonomy'] = $taxonomy;
	    // $defaults = array( 'taxonomy' => 'category' );
	    $args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

	    $taxonomy = $args['taxonomy'];

	    $terms = (array) get_terms( $taxonomy, $args );

	    // Initate an empty array
	    $term_options = array();
	    if ( ! empty( $terms ) ) {
	        foreach ( $terms as $term ) {
	            $term_options[ $term->term_id ] = $term->name;
	        }
	    }

	    return $term_options;
	}
}


/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
add_action( 'cmb2_admin_init', 'podmetab_register_metabox' );
function podmetab_register_metabox() {
	$prefix = 'cmb_';

	$feat_head_type = pod_theme_option('pod-featured-header-type', 'static');
	$feat_head_cont = pod_theme_option('pod-featured-header-content', 'newest');
	$pod_slideshow_in_post = pod_theme_option( 'pod-featured-header-slides-in-post', false );
	$podcast_plugin_active = pod_get_plugin_active();

	if( $feat_head_type == 'static-posts' || ( $feat_head_type == 'slideshow' ) ){
		$cmb_featured_post = new_cmb2_box( array(
			'id'            => 'thst_featured_post',
			'title'         => esc_html__( 'Featured Post', 'podcaster' ),
			'object_types'  => array( 'post', 'podcast' ),
			'context'    => 'side',
			'priority'   => 'default',
			'show_names' => true, 
		) );

		$cmb_featured_post->add_field( array(
			'name' => esc_html__( 'Feature Post', 'podcaster' ),
			'desc' => esc_html__( 'Tick the box to feature this post on the front page.', 'podcaster' ),
			'id'   => $prefix . 'thst_feature_post',
			'type' => 'checkbox',
		) );
		$cmb_featured_post->add_field( array(
			'name' => esc_html__( 'Featured Post Header', 'podcaster' ),
			'desc' => esc_html__( 'Upload an image or enter an URL.', 'podcaster' ),
			'id'   => $prefix . 'thst_feature_post_img',
			'type' => 'file',
			'allow' => array( 'url', 'attachment' )
		) );
		$cmb_featured_post->add_field( array(
			'name'    => esc_html__( 'Alignment', 'podcaster' ),
			'desc'    => esc_html__( 'Select the alignment of your header.', 'podcaster' ),
			'id'      => $prefix . 'thst_feature_post_align',
			'type'    => 'select',
			'show_option_none' => true,
			'options'          => array(
				'text-align:left;' 		=> esc_html__( 'Left', 'podcaster' ),
				'text-align:center;'	=> esc_html__( 'Center', 'podcaster' ),
				'text-align:right;'		=> esc_html__( 'Right', 'podcaster' ),
			),
		) );
		$cmb_featured_post->add_field( array(
			'name'    => esc_html__( 'Background Style', 'podcaster' ),
			'desc'    => esc_html__( 'Choose how you would like to display the background image.', 'podcaster' ),
			'id'      => $prefix . 'thst_page_header_bgstyle',
			'type'    => 'radio',
			'options' => array(
				'background-size:auto;'	=> esc_html__( 'Tiled', 'podcaster' ),
				'background-size:contain;'	=> esc_html__( 'Contain', 'podcaster' ),
				'background-size:cover;'	=> esc_html__( 'Stretched', 'podcaster' ),
			),
			'default' => 'background-size:cover;',
		) );
		$cmb_featured_post->add_field( array(
			'name' => esc_html__( 'Display Excerpt', 'podcaster' ),
			'desc' => esc_html__( 'Tick the box to display an excerpt.', 'podcaster' ),
			'id'   => $prefix . 'thst_feature_post_excerpt',
			'type' => 'checkbox',
		) );
		$cmb_featured_post->add_field( array(
		    'name' => esc_html__('Excerpt Word Count', 'podcaster'),
		    'desc' => esc_html__('Enter the amount of words you want to display in your excerpt. Leaving it blank with default to 55 words.', 'podcaster'),
		    'id' => $prefix . 'thst_featured_post_excerpt_count',
		    'type' => 'text_small'
		) );
		$cmb_featured_post->add_field( array(
			'name' => esc_html__( 'Parallax', 'podcaster' ),
			'desc' => esc_html__( 'Tick the box to activate parallax background scrolling.', 'podcaster' ),
			'id'   => $prefix . 'thst_feature_post_para',
			'type' => 'checkbox',
		) );
	}

	if( $podcast_plugin_active != 'bpp' && $podcast_plugin_active != 'ssp' ) {

		$cmb_featured_audio = new_cmb2_box( array(
			'id'            => 'thst_featured_audio',
			'title'         => esc_html__( 'Featured Audio', 'podcaster' ),
			'object_types'  => array( 'post' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, 
		) );
		$cmb_featured_audio->add_field( array(
		    'name'    => esc_html__('Audio Type', 'podcaster'),
		    'id'      => $prefix . 'thst_audio_type',
		    'type'    => 'radio_inline',
		    'options' => array(
		        'audio-url' => esc_html__( 'Audio File (URL)', 'podcaster' ),
		        'audio-embed-url'   => esc_html__( 'Audio Embed (URL)', 'podcaster' ),
		        'audio-embed-code'     => esc_html__( 'Audio Embed (Code)', 'podcaster' ),
		        'audio-playlist'     => esc_html__( 'Audio Playlist', 'podcaster' ),
		    ),
		    'default' => 'audio-url',
		) );
		$cmb_featured_audio->add_field( array(
			'name' => esc_html__( 'Audio URL', 'podcaster' ),
			'desc' => esc_html__( 'Upload an audio file or enter a URL that ends with a file extension, such as <strong>*.mp3</strong>.', 'podcaster' ),
			'id'   => $prefix . 'thst_audio_url',
			'type' => 'file',
		) );
		$cmb_featured_audio->add_field( array(
			'name' => esc_html__( 'Audio Embed URL', 'podcaster' ),
			'desc' => esc_html__( 'Enter your embed URL here. URL\'s posted here should  not end on <strong>*.mp3</strong> or other file extensions. Supported websites are: YouTube, Vimeo, Hulu, DailyMotion, Flickr Video and Qik.', 'podcaster' ),
			'id'   => $prefix . 'thst_audio_embed',
			'type' => 'oembed',
		) );
		$cmb_featured_audio->add_field( array(
			'name' => esc_html__( 'Audio Embed Code', 'podcaster' ),
			'desc' => esc_html__( 'Paste your embed code here.', 'podcaster' ),
			'id'   => $prefix . 'thst_audio_embed_code',
			'type' => 'textarea_code',
			'options' => array( 'disable_codemirror' => true ),
		) );		
		$cmb_featured_audio->add_field( array(
			'name' => esc_html__( 'Audio Playlist', 'podcaster' ),
			'desc' => esc_html__( 'Upload audio to be displayed in a playlist. (Only works with uploads.)', 'podcaster' ),
			'id'   => $prefix . 'thst_audio_playlist',
			'type' => 'file_list',
		) );
		$cmb_featured_audio->add_field( array(
			'name' => esc_html__( 'Audio Caption', 'podcaster' ),
			'desc' => esc_html__( 'Enter a short audio caption.(optional)', 'podcaster' ),
			'id'   => $prefix . 'thst_audio_capt',
			'type' => 'text',
		) );
		$cmb_featured_audio->add_field( array(
			'name' => esc_html__( 'Allow Download', 'podcaster' ),
			'desc' => esc_html__( 'Check this box if you would like your users to be able to download your audio file. (Might not work with files hosted on Soundcloud.)', 'podcaster' ),
			'id'   => $prefix . 'thst_audio_download',
			'type' => 'checkbox',
		) );
		$cmb_featured_audio->add_field( array(
			'name' => esc_html__( 'Explicit', 'podcaster' ),
			'desc' => esc_html__( 'Please check this box if you would like your post to be marked as explicit.', 'podcaster' ),
			'id'   => $prefix . 'thst_audio_explicit',
			'type' => 'checkbox',
		) );


		$cmb_featured_video = new_cmb2_box( array(
			'id'            => 'thst_featured_video',
			'title'         => esc_html__( 'Featured Video', 'podcaster' ),
			'object_types'  => array( 'post' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, 
		) );
		$cmb_featured_video->add_field( array(
		    'name'    => 'Video Type',
		    'id'      => $prefix . 'thst_video_type',
		    'type'    => 'radio_inline',
		    'options' => array(
		        'video-oembed' => esc_html__( 'Video oEmbed Code', 'podcaster' ),
		        'video-embed-url'   => esc_html__( 'Video Embed Code', 'podcaster' ),
		        'video-url'     => esc_html__( 'Video URL (Upload/Self-Hosted)', 'podcaster' ),
		        'video-playlist'     => esc_html__( 'Video Playlist', 'podcaster' ),
		    ),
		    'default' => 'video-oembed',
		) );
		$cmb_featured_video->add_field( array(
			'name' => esc_html__( 'Video oEmbed Code', 'podcaster' ),
			'desc' => esc_html__( 'Enter your oembed code here. Supported websites are: YouTube, Vimeo, Hulu, DailyMotion, Flickr Video and Qik.', 'podcaster' ),
			'id'   => $prefix . 'thst_video_embed',
			'type' => 'oembed',
		) );
		$cmb_featured_video->add_field( array(
			'name' => esc_html__( 'Video Embed Code', 'podcaster' ),
			'desc' => esc_html__( 'Paste your embed code here.', 'podcaster' ),
			'id'   => $prefix . 'thst_video_embed_code',
			'type' => 'textarea_code',
			'options' => array( 'disable_codemirror' => true ),
		) );
		$cmb_featured_video->add_field( array(
			'name' => esc_html__( 'Video URL', 'podcaster'),
			'desc' => esc_html__( 'Upload a video file or enter an URL.', 'podcaster' ),
			'id'   => $prefix . 'thst_video_url',
			'type' => 'file',
		) );
		$cmb_featured_video->add_field( array(
			'name' => esc_html__( 'Video Playlist', 'podcaster' ),
			'desc' => esc_html__( 'Upload videos to be displayed in a playlist.(Only works with uploads.)', 'podcaster' ),
			'id'   => $prefix . 'thst_video_playlist',
			'type' => 'file_list',
		) );
		$cmb_featured_video->add_field( array(
			'name' => esc_html__( 'Thumbnail', 'podcaster' ),
			'desc' => esc_html__( 'Upload a thumbnail for your video. You only need to do this if you are hosting it yourself.', 'podcaster' ),
			'id'   => $prefix . 'thst_video_thumb',
			'type' => 'file',
		) );
		$cmb_featured_video->add_field( array(
			'name' => esc_html__( 'Caption', 'podcaster' ),
			'desc' => esc_html__( 'Enter a short video caption.(optional)', 'podcaster' ),
			'id'   => $prefix . 'thst_video_capt',
			'type' => 'text',
		) );
		$cmb_featured_video->add_field( array(
			'name' => esc_html__( 'Allow Download', 'podcaster' ),
			'desc' => esc_html__( 'Check this box if you would like your users to be able to download your video file. (Only works with self-hosted files.)', 'podcaster' ),
			'id'   => $prefix . 'thst_video_download',
			'type' => 'checkbox',
		) );
		$cmb_featured_video->add_field( array(
			'name' => esc_html__( 'Explicit', 'podcaster' ),
			'desc' => esc_html__( 'Please check this box if you would like your post to be marked as explicit.', 'podcaster' ),
			'id'   => $prefix . 'thst_video_explicit',
			'type' => 'checkbox',
		) );
	}


	$cmb_featured_gallery = new_cmb2_box( array(
		'id'            => 'thst_featured_gallery',
		'title'         => esc_html__( 'Featured Gallery', 'podcaster' ),
		'object_types'  => array( 'post' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, 
	) );
	$cmb_featured_gallery->add_field( array(
		'name' => esc_html__( 'Images', 'podcaster' ),
		'desc' => esc_html__( 'Upload images that will be displayed in your gallery.', 'podcaster' ),
		'id'   => $prefix . 'thst_gallery_list',
		'type' => 'file_list',
	) );
	$cmb_featured_gallery->add_field( array(
		'name' => esc_html__( 'Caption', 'podcaster'),
		'desc' => esc_html__( 'Enter a short gallery caption.(optional)', 'podcaster'),
		'id'   => $prefix . 'thst_gallery_capt',
		'type' => 'text',
	) );
	$cmb_featured_gallery->add_field( array(
		'name'    => esc_html__( 'Style', 'podcaster' ),
		'desc'    => esc_html__( 'Choose how you would like to display your gallery.', 'podcaster' ),
		'id'      => $prefix . 'thst_post_gallery_style',
		'type'    => 'radio',
		'options' => array(
			'slideshow'		=> esc_html__( 'Slideshow', 'podcaster' ),
			'grid'			=> esc_html__( 'Grid', 'podcaster' )
		),
	) );
	$cmb_featured_gallery->add_field( array(
		'name'    => esc_html__( 'Columns', 'podcaster' ),
		'desc'    => esc_html__( 'Choose the amount of columns (only when set to grid)', 'podcaster' ),
		'id'      => $prefix . 'thst_gallery_col',
		'type'    => 'select',
		'options' => array(
			'three' => esc_html__( '3 Columns', 'podcaster' ),
			'four' => esc_html__( '4 Columns', 'podcaster' ),
			'five' => esc_html__( '5 Columns', 'podcaster' ),
			'six' => esc_html__( '6 Columns', 'podcaster' ),
			'seven' => esc_html__( '7 Columns', 'podcaster' ),
			'eight' => esc_html__( '8 Columns', 'podcaster' ),
		),
	) );


	$cmb_header_subtitle = new_cmb2_box( array(
		'id'            => 'thst_page_subtitle',
		'title'         => esc_html__( 'Page Header Subtitle', 'podcaster' ),
		'object_types'  => array( 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, 
	) );
	$cmb_header_subtitle->add_field( array(
		'name'    => esc_html__( 'Text Alignment', 'podcaster' ),
		'desc'    => esc_html__( 'Align the heading text to the left (default), center or right.', 'podcaster' ),
		'id'      => $prefix . 'thst_page_header_align',
		'type'    => 'radio',
		'options' => array(
			'text-align:left;'		=> esc_html__( 'Left', 'podcaster' ),
			'text-align:center;'	=> esc_html__( 'Center', 'podcaster' ),
			'text-align:right;'		=> esc_html__( 'Right', 'podcaster' ),
		),
	) );
	$cmb_header_subtitle->add_field( array(
		'name' => esc_html__( 'Short Blurb', 'podcaster'),
		'desc' => esc_html__( 'Submit a short blurb or summary of your page that will appear below the title.', 'podcaster' ),
		'id'   => $prefix . 'thst_page_subtitle',
		'type' => 'text',
	) );
	$cmb_header_subtitle->add_field( array(
		'name'    => esc_html__( 'Background Style', 'podcaster' ),
		'desc'    => esc_html__( 'Select whether you would like to display your background stretched or tiled.', 'podcaster' ),
		'id'      => $prefix . 'thst_page_header_bg_style',
		'type'    => 'radio',
		'options' => array(
			'background-repeat:repeat, no-repeat;'		=> esc_html__( 'Tiled', 'podcaster' ),
			'background-repeat:repeat; background-size:cover;'		=> esc_html__( 'Stretched', 'podcaster'),
		),
	) );
	$cmb_header_subtitle->add_field( array(
		'name' => esc_html__( 'Parallax', 'podcaster' ),
		'desc' => esc_html__( 'Select if you would like to activate parallax.', 'podcaster' ),
		'id'   => $prefix . 'thst_page_header_parallax',
		'type' => 'checkbox',
		'std'  => ''
	) );
	$cmb_header_subtitle->add_field( array(
		'name' => esc_html__( 'Page Padding Top Off', 'podcaster' ),
		'desc' => esc_html__( 'Select if you would like to deactivate padding on the top of the page.', 'podcaster' ),
		'id'   => $prefix . 'thst_page_padding_top',
		'type' => 'checkbox',
		'std'  => '0'
	) );
	$cmb_header_subtitle->add_field( array(
		'name' => esc_html__( 'Page Padding Bottom Off', 'podcaster' ),
		'desc' => esc_html__( 'Select if you would like to deactivate padding on the bottom of the page.', 'podcaster' ),
		'id'   => $prefix . 'thst_page_padding_bottom',
		'type' => 'checkbox',
		'std'  => '0'
	) );



	$cmb_podcast_archive = new_cmb2_box( array(
		'id'            => 'thst_podcast_archive',
		'title'         => esc_html__( 'Podcast Archive', 'podcaster' ),
		'object_types'  => array( 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, 
	) );
	if( $podcast_plugin_active == "ssp"){
		$cmb_podcast_archive->add_field( array(
		    'name'    => esc_html__( 'Podcast Category', "podcaster" ),
		    'desc'    => esc_html__( 'Select the category to be displayed on this podcast archive page.', "podcaster" ),
		    'id'      => $prefix . 'thst_podcast_cat',
		    'type'    => 'select',
		    'show_option_none' => true,
		    'options' => cmb2_get_term_options2(),
		) );
	} else {
		$cmb_podcast_archive->add_field( array(
		    'name'    => esc_html__( 'Podcast Category', "podcaster" ),
		    'desc'    => esc_html__( 'Select the category to be displayed on this podcast archive page.', "podcaster" ),
		    'id'      => $prefix . 'thst_podcast_cat',
		    'type'    => 'select',
		   	'show_option_none' => true,
		    'options' => cmb2_get_term_options(),
		) );
	}
	$cmb_podcast_archive->add_field( array(
		'name' => esc_html__( 'Posts per page', 'podcaster' ),
		'desc' => esc_html__( 'Enter the amount of posts you would like to display per page.', 'podcaster'),
		'default' => '10',
		'id' => $prefix . 'thst_podcast_amount',
		'type' => 'text_small'
	) );
	$cmb_podcast_archive->add_field( array(
		'name'    => esc_html__( 'Post Order', 'podcaster' ),
		'id'      => $prefix . 'thst_podcast_order',
		'type'    => 'radio',
		'options' => array(
			'DESC'   => esc_html__( 'Newest to Oldest', 'podcaster' ),
			'ASC' => esc_html__( 'Oldest to Newest', 'podcaster' ),
		),
		'default' => 'DESC'
	) );
	$cmb_podcast_archive->add_field( array(
		'name'    => esc_html__( 'Use featured image as', 'podcaster' ),
		'desc'    => esc_html__( 'Select whether you would like to display your background stretched or tiled.', 'podcaster' ),
		'id'      => $prefix . 'thst_podcast_image_use',
		'type'    => 'radio',
		'options' => array(
			'pod-archive-img-background'		=> esc_html__( 'Background', 'podcaster' ),
			'pod-archive-img-thumbnail'		=> esc_html__( 'Thumbnail', 'podcaster'),
		),
		'std' => 'pod-archive-img-thumbnail'
	) );
	$cmb_podcast_archive->add_field( array(
		'name' => esc_html__( 'Subscribe Button Text 1', 'podcaster' ),
		'desc' => esc_html__( '(Example: Subscribe with RSS)', 'podcaster' ),
		'id'   => $prefix . 'thst_podcast_button_text_1',
		'type' => 'text_medium',
	) );
	$cmb_podcast_archive->add_field( array(
		'name' => esc_html__( 'Subscribe Button URL 1', 'podcaster' ),
		'id'   => $prefix . 'thst_podcast_button_url_1',
		'type' => 'text_url',
	) );
	$cmb_podcast_archive->add_field( array(
		'name' => esc_html__( 'Subscribe Button Text 2', 'podcaster' ),
		'desc' => esc_html__( '(Example: Subscribe with Apple Podcast)', 'podcaster' ),
		'id'   => $prefix . 'thst_podcast_button_text_2',
		'type' => 'text_medium',
	) );
	$cmb_podcast_archive->add_field( array(
		'name' => esc_html__( 'Subscribe Button URL 2', 'podcaster' ),
		'id'   => $prefix . 'thst_podcast_button_url_2',
		'type' => 'text_url',
	) );
	$cmb_podcast_archive->add_field( array(
		'name' => esc_html__( 'Subscribe Button Text 3', 'podcaster' ),
		'desc' => esc_html__( '(Example: Subscribe with Stitcher)', 'podcaster' ),
		'id'   => $prefix . 'thst_podcast_button_text_3',
		'type' => 'text_medium',
	) );
	$cmb_podcast_archive->add_field( array(
		'name' => esc_html__( 'Subscribe Button URL 3', 'podcaster' ),
		'id'   => $prefix . 'thst_podcast_button_url_3',
		'type' => 'text_url',
	) );
}