<?php
/**
 * This file is used to display audio post format.
 * @package Podcaster
 * @since 1.0
 */
$active_plugin = pod_get_plugin_active();

$audiotype = get_post_meta( $post->ID, 'cmb_thst_audio_type', true );
$audiourl = get_post_meta( $post->ID, 'cmb_thst_audio_url', true );
$audioembed = get_post_meta( $post->ID, 'cmb_thst_audio_embed', true );
$audioembedcode = get_post_meta( $post->ID, 'cmb_thst_audio_embed_code', true );
$audiocapt = get_post_meta( $post->ID, 'cmb_thst_audio_capt', true );
$audioplists = get_post_meta( $post->ID, 'cmb_thst_audio_playlist', true );
$au_uploadcode = wp_audio_shortcode( $audiourl );

$pod_butn_one = pod_theme_option('pod-subscribe1', 'Subscribe with Apple Podcasts');
$pod_butn_one_url = pod_theme_option('pod-subscribe1-url', '');
$pod_butn_two = pod_theme_option('pod-subscribe2', 'Subscribe with RSS');
$pod_butn_two_url = pod_theme_option('pod-subscribe2-url', '');
$pod_subscribe_single = pod_theme_option('pod-subscribe-single', true);
$pod_players_preload = pod_theme_option('pod-players-preload', 'none');

 /* PowerPress Files*/
$pp_audio_str = get_post_meta( $post->ID, 'enclosure', true );
$pp_audiourl = strtok($pp_audio_str, "\n");
 ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php
			$pod_download = get_post_meta( $post->ID, 'cmb_thst_audio_download', true );
			$pod_filedownload = get_post_meta( $post->ID, 'cmb_thst_audio_url', true );
		?>
		<?php if( is_single() && ( $pod_subscribe_single == true || $pod_download == true ) ) : ?>

			<div id="mediainfo">

				<?php if( $pod_butn_one != '' && $pod_subscribe_single == true ) : ?>
					<a class="butn small" href="<?php echo esc_url( $pod_butn_one_url ); ?>"><?php echo esc_html( $pod_butn_one ); ?></a>
				<?php endif; ?>

				<?php if( $pod_butn_two != '' && $pod_subscribe_single == true ) : ?>
					<a class="butn small sub-button-two" href="<?php echo esc_url( $pod_butn_two_url ); ?>"><?php echo esc_html( $pod_butn_two ); ?></a>
				<?php endif; ?>

				<?php if( $pod_download == true ) : ?>
					<h6 class="download-heading"><?php echo __('Downloads:', 'podcaster'); ?></h6>
					<?php if ( $audiourl != '' ) : ?>
						<ul class="download">
							<?php
								$keys = parse_url($audiourl);
								$path = explode('/', $keys['path']);
								$file_name = end($path);
								echo '<li><a class="download-link" href="'. $audiourl .'" download>' . $file_name . '</a> <a class="butn" href="'. $audiourl .'" download>' . __('Download', 'podcaster') . '</a></li>';
							?>
						</ul>
					<?php elseif( is_array($audioplists) ) : ?>
						<ul class="download playlist">
							<?php
							$audioplistfiles = array_values($audioplists);
							foreach( $audioplistfiles as $file ){
								$keys = parse_url($file);
								$path = explode('/', $keys['path']);
								$file_name = end($path);
								echo '<li><a class="download-link" href="'. $file .'" download>' . $file_name . '</a> <a class="butn" href="'. $audiourl .'" download>' . __('Download', 'podcaster') . '</a></li>';
							} ?>
						</ul>
					<?php endif ; ?>
				<?php endif; ?>
			</div><!-- #mediainfo -->
		<?php endif; ?>


		<?php if ( ! is_single() && ! is_sticky() ) { ?>

			<?php get_template_part('post/postheader'); ?>

			<div class="featured-media">


				<?php if ( $pp_audiourl != '' && $active_plugin == "bpp" ) { ?>
					<?php echo the_powerpress_content(); ?>

				<?php } else { 

					echo pod_get_featured_player( $post->ID );

					if( $audiocapt != '') {
						echo '<div class="audio-caption">' . $audiocapt . '</div>';
					} ?>

				<?php } ?>
			</div><!-- .featured-media -->

		<?php } ?>


		<?php if ( is_search() || is_search() ) { // Only display Excerpts for Search ?>

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		<?php } else { ?>

			<div class="entry-content">

				<?php if( is_single() ) { ?>

					<?php the_content(); ?>

				<?php } else { ?>

					<?php echo pod_the_blog_content(); ?>

				<?php } ?>

			</div><!-- .entry-content -->

		<?php } ?>


		<?php get_template_part('post/postfooter'); ?>
	</article><!-- #post -->
