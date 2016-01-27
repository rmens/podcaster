<?php
/**
 * This file is used for your video post format.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
 
 $options = get_option('podcaster-theme');
 $pod_butn_one = isset( $options['pod-subscribe1'] ) ? $options['pod-subscribe1'] : '';
 $pod_butn_one_url = isset( $options['pod-subscribe1-url'] ) ? $options['pod-subscribe1-url'] : '';
 $pod_subscribe_single = isset( $options['pod-subscribe-single'] ) ? $options['pod-subscribe-single'] : '';

 $videoembed = get_post_meta( $post->ID, 'cmb_thst_video_embed', true );
 $videourl = get_post_meta( $post->ID, 'cmb_thst_video_url', true );
 $videocapt = get_post_meta($post->ID, 'cmb_thst_video_capt', true);
 $videoplists = get_post_meta( $post->ID, 'cmb_thst_video_playlist', true );
 $videothumb = get_post_meta($post->ID, 'cmb_thst_video_thumb',true);
 $videoembedcode = get_post_meta( $post->ID, 'cmb_thst_video_embed_code', true );
 ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php 
			$pod_download = get_post_meta( $post->ID, 'cmb_thst_video_download', true );
			$pod_filedownload = get_post_meta( $post->ID, 'cmb_thst_video_url', true );
		?>
		<?php get_template_part('post/postheader'); ?>
		<?php if( is_single() && $pod_download == true ) : ?>
			<div id="mediainfo">
				<?php if( $pod_butn_one != '' && $pod_subscribe_single == true ) : ?>
					<a class="butn small" href="<?php echo $pod_butn_one_url; ?>"><?php echo $pod_butn_one; ?></a>
				<?php endif; ?>
				<?php if( $pod_download == true ) : ?>
					<h6 class="download-heading"><?php echo __('Downloads:', 'thstlang'); ?></h6>
					<?php if ( $videourl != '' ) : ?>
						<ul class="download">
							<?php
								$keys = parse_url($videourl);
								$path = explode('/', $keys['path']);
								$file_name = end($path);
								echo '<li><a href="'. $videourl .'" download>' . $file_name . '</a> <a class="butn" href="'. $videourl .'" download>' . __('Download', 'thstlang') . '</a></li>';
							?>
						</ul>
					<?php elseif( is_array($videoplists) ) : ?>
						<ul class="download playlist">
							<?php 
							$videoplistfiles = array_values($videoplists); 
							foreach( $videoplistfiles as $file ){
								$keys = parse_url($file);
								$path = explode('/', $keys['path']);
								$file_name = end($path);
								echo '<li><a href="'. $file .'" download>' . $file_name . '</a>  <a class="butn" href="'. $file .'" download>' . __('Download', 'thstlang') . '</a></li>';
							} ?>
						</ul>
					<?php endif ; ?>
				<?php endif; ?>
			</div><!-- #audioinfo -->
		<?php endif; ?>
		
		<?php if ( ! is_single() && ! is_sticky()  ) : ?>
		<div class="featured-video featured-media">
			
				<?php if( $videoembed != '' ) {
				 	echo '<div class="video_player">' .  wp_oembed_get($videoembed) . '</div><!--video_player-->';
				} elseif( $videourl != '' ){
					echo '<div class="video_player">' . do_shortcode('[video poster="' .$videothumb. '" src="' .$videourl. '"][/video]') .'</div><!--video_player-->';
				} elseif( is_array( $videoplists ) ) {
					echo do_shortcode('[playlist type="video" ids="'.implode(',', array_keys($videoplists)).'"][/playlist]');
				} elseif( $videoembedcode !='') {
					echo '<div class="video_player">' . $videoembedcode . '</div><!--video_player-->';									
				} else {
					//Do Nothing.
				}
				if( $videocapt != '' ) {
					echo '<div class="video-caption">' . $videocapt . '</div>';
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