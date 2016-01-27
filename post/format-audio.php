<?php
/**
 * This file is used to display audio post format.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
 
 $audiourl = get_post_meta( $post->ID, 'cmb_thst_audio_url', true );
 $audioembed = get_post_meta( $post->ID, 'cmb_thst_audio_embed', true );
 $audioembedcode = get_post_meta( $post->ID, 'cmb_thst_audio_embed_code', true );
 $audiocapt = get_post_meta( $post->ID, 'cmb_thst_audio_capt', true );
 $audioplists = get_post_meta( $post->ID, 'cmb_thst_audio_playlist', true );
 $au_uploadcode = wp_audio_shortcode( $audiourl );

 $options = get_option('podcaster-theme');
 $pod_butn_one = isset( $options['pod-subscribe1'] ) ? $options['pod-subscribe1'] : '';
 $pod_butn_one_url = isset( $options['pod-subscribe1-url'] ) ? $options['pod-subscribe1-url'] : '';
 $pod_subscribe_single = isset( $options['pod-subscribe-single'] ) ? $options['pod-subscribe-single'] : '';

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
					<a class="butn small" href="<?php echo $pod_butn_one_url; ?>"><?php echo $pod_butn_one; ?></a>
				<?php endif; ?>
				<?php if( $pod_download == true ) : ?>
					<h6 class="download-heading"><?php echo __('Downloads:', 'thstlang'); ?></h6>
					<?php if ( $audiourl != '' ) : ?>
						<ul class="download">
							<?php
								$keys = parse_url($audiourl);
								$path = explode('/', $keys['path']);
								$file_name = end($path);
								echo '<li><a href="'. $audiourl .'" download>' . $file_name . '</a> <a class="butn" href="'. $audiourl .'" download>' . __('Download', 'thstlang') . '</a></li>';
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
								echo '<li><a href="'. $file .'" download>' . $file_name . '</a> <a class="butn" href="'. $audiourl .'" download>' . __('Download', 'thstlang') . '</a></li>';
							} ?>
						</ul>
					<?php endif ; ?>
				<?php endif; ?>
			</div><!-- #audioinfo -->
		<?php endif; ?>		
		<?php if ( ! is_single() && ! is_sticky() ) : ?>
		<?php get_template_part('post/postheader'); ?>
		<div class="featured-media">
			<?php if ( $pp_audiourl != '' && function_exists('the_powerpress_content') ) { ?>
				<?php echo the_powerpress_content(); ?>
			<?php } else { ?>
			
			<?php 
				if($audioembed != '') {
					$au_embedcode = wp_oembed_get( $audioembed );
					echo '<div class="audio_player au_oembed">' . $au_embedcode . '</div><!--audio_player-->';
				} elseif($audiourl != '') {
					echo '<div class="audio_player">' . do_shortcode('[audio src="' . $audiourl . '"][/audio]</div><!--audio_player-->');
				} elseif( is_array( $audioplists ) ) {
					echo do_shortcode('[playlist type="audio" ids="'.implode(',', array_keys($audioplists)).'"][/playlist]');
				} elseif ( $audioembedcode != '') {
					echo '<div class="audio_player embed_code">' . $audioembedcode . '</div><!--audio_player-->';
				} 
				
				if($audiocapt != '') {
					echo '<div class="audio-caption">' . $audiocapt . '</div>';
				}	
			?>
			<?php } ?>
		</div><!-- .featured-media -->
		<?php endif; ?>
		
		<?php if ( is_search() || is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
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