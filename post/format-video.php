<?php
/**
 * This file is used for your video post format.
 * @package Podcaster
 * @since 1.0
 */
 
$plugin_active = pod_get_plugin_active();
$pod_butn_one = pod_theme_option( 'pod-subscribe1', 'Subscribe with Apple Podcasts' );
$pod_butn_one_url = pod_theme_option( 'pod-subscribe1-url', '' );
$pod_butn_two = pod_theme_option('pod-subscribe2', 'Subscribe with RSS');
$pod_butn_two_url = pod_theme_option('pod-subscribe2-url', '');
$pod_subscribe_single = pod_theme_option( 'pod-subscribe-single', true );
$pod_players_preload = pod_theme_option('pod-players-preload', 'none');


$videotype = get_post_meta( $post->ID, 'cmb_thst_video_type', true );
$videoembed = get_post_meta( $post->ID, 'cmb_thst_video_embed', true );
$videourl = get_post_meta( $post->ID, 'cmb_thst_video_url', true );
$videocapt = get_post_meta( $post->ID, 'cmb_thst_video_capt', true );
$videoplists = get_post_meta( $post->ID, 'cmb_thst_video_playlist', true );
$videothumb = get_post_meta( $post->ID, 'cmb_thst_video_thumb',true );
$videoembedcode = get_post_meta( $post->ID, 'cmb_thst_video_embed_code', true );
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
		<?php 
			$pod_download = get_post_meta( $post->ID, 'cmb_thst_video_download', true );
			$pod_filedownload = get_post_meta( $post->ID, 'cmb_thst_video_url', true );
		?>
		<?php get_template_part('post/postheader'); ?>
		<?php if( is_single() && ( $pod_subscribe_single == true || $pod_download == true ) ) : ?>
			<div id="mediainfo">
				<?php if( $pod_butn_one != '' && $pod_subscribe_single == true ) : ?>
					<a class="butn small" href="<?php echo esc_url( $pod_butn_one_url ); ?>"><?php echo esc_html( $pod_butn_one ); ?></a>
				<?php endif; ?>

				<?php if( $pod_butn_two != '' && $pod_subscribe_single == true ) : ?>
					<a class="butn small sub-button-two" href="<?php echo esc_url( $pod_butn_two_url ); ?>"><?php echo esc_html( $pod_butn_two ); ?></a>
				<?php endif; ?>

				<?php if( $pod_download == true && ( $videotype == 'video-url' || $videotype == 'video-playlist' ) ) : ?>
					<h6 class="download-heading"><?php echo __('Downloads:', 'podcaster'); ?></h6>

					<?php if ( $videourl != '' && $videotype == 'video-url' ) : ?>
						<ul class="download">
							<?php
								$keys = parse_url($videourl);
								$path = explode('/', $keys['path']);
								$file_name = end($path);
								echo '<li><a class="download-link" href="'. $videourl .'" download>' . $file_name . '</a> <a class="butn" href="'. $videourl .'" download>' . __('Download', 'podcaster') . '</a></li>';
							?>
						</ul>

					<?php elseif( is_array( $videoplists ) && $videotype == 'video-playlist' ) : ?>
						<ul class="download playlist">
							<?php 
							$videoplistfiles = array_values($videoplists); 
							foreach( $videoplistfiles as $file ){
								$keys = parse_url($file);
								$path = explode('/', $keys['path']);
								$file_name = end($path);
								echo '<li><a class="download-link" href="'. $file .'" download>' . $file_name . '</a>  <a class="butn" href="'. $file .'" download>' . __('Download', 'podcaster') . '</a></li>';
							} ?>
						</ul>
					<?php endif ; ?>
				<?php endif; ?>
			</div><!-- #audioinfo -->
		<?php endif; ?>
		
		<?php if ( ! is_single() && ! is_sticky()  ) : ?>
		<div class="featured-video featured-media">
			
				<?php 

				if( $plugin_active == "ssp" ) {

					$file = get_post_meta( $id , "enclosure", true );
					$video_file = get_post_meta( $id, "audio_file", true );
					$file = $video_file ? $video_file : $file;

					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					$featured_image_url = $featured_image[0];

					$video_shortcode_attr_ssp = array('src' => $file, 'loop' => '', 'autoplay' => '', 'preload' => $pod_players_preload, 'poster' => $featured_image_url );
					echo '<div class="video_player">' . wp_video_shortcode( $video_shortcode_attr_ssp ) . '</div><!-- .video_player -->';

				} elseif( $plugin_active == "bpp" ) {
					$bpp_settings = get_option('powerpress_general');
					$bpp_disable_appearance = isset( $bpp_settings['disable_appearance'] ) ? $bpp_settings['disable_appearance'] : false;
					
					echo '<div class="video_player">' . get_the_powerpress_content() . '</div><!-- .video_player -->';
				} else {

					if( $videoembed != '' ) {
					 	echo '<div class="video_player">' .  wp_oembed_get($videoembed) . '</div><!--video_player-->';

					} elseif( $videourl != '' ){
						$video_shortcode_attr = array( 'src' => $videourl, 'poster' => $videothumb );
						echo '<div class="video_player">' . wp_video_shortcode( $video_shortcode_attr ) . '</div><!-- .video_player -->';

					} elseif( is_array( $videoplists ) ) {
						$video_playlist_ids = implode( ',', array_keys( $videoplists ) );
						$video_playlist_shortcode_attr = array( 'type' => 'video', 'ids' => $video_playlist_ids );
						echo  wp_playlist_shortcode( $video_playlist_shortcode_attr );

					} elseif( $videoembedcode !='') {
						echo '<div class="video_player">' . $videoembedcode . '</div><!--video_player-->';									
					}

					if( $videocapt != '' ) {
						echo '<div class="video-caption">' . $videocapt . '</div>';

					}

				}


				?>

		</div><!-- .featured-media -->
		<?php endif; ?>

		<?php if ( is_archive() || is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php elseif ( is_single() ) : ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		<?php else : ?>
			<div class="entry-content">
			<?php if( is_single() ) { ?>
				<?php the_content(); ?>
			<?php } else { ?>
				<?php echo pod_the_blog_content(); ?>
			<?php } ?>
			</div><!-- .entry-content -->
		<?php endif; ?>
		<?php get_template_part('post/postfooter'); ?>
	</article><!-- #post -->