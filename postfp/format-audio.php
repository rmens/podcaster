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

		<?php if ( ! is_sticky() ) { ?>

			<?php get_template_part('postfp/postheader'); ?>

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


		<div class="entry-content">

			<?php if( is_single() ) { ?>

				<?php the_content(); ?>

			<?php } else { ?>

				<?php echo pod_the_blog_content(); ?>

			<?php } ?>

		</div><!-- .entry-content -->




		<?php get_template_part('post/postfooter'); ?>
	</article><!-- #post -->
