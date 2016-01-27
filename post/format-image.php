<?php
/**
 * This file is used for your image post format.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
 
 $thump_cap = get_post(get_post_thumbnail_id())->post_excerpt; ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php if( ! is_single() && ! is_sticky() ) : ?>
		<div class="entry-featured">
			<div class="featured">
			<?php 
				if ( has_post_thumbnail( $post->ID ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'linear_image' );
					the_post_thumbnail( 'linear_image' );
				
					if( $thump_cap != "" ) {
						echo '<div class="permalink_box"><a href="' . $image[0] . '" data-lightbox="image' .get_the_ID(). '" class="permalink-icon batch" data-icon="&#xF0A5;" title="' .$thump_cap. '"></a></div>';
					} else {
						echo '<div class="permalink_box"><a href="' . $image[0] . '" data-lightbox="image' .get_the_ID(). '" class="permalink-icon batch" data-icon="&#xF0A5;"></a></div>';
					}
				} ?>
			</div><!-- .featured -->
			<?php if( $thump_cap != '' ) { the_post_thumbnail_caption(); } ?>	
		</div><!-- .entry-featured -->
		<?php endif ;?>		
				
		<?php if ( is_search() || is_sticky() ) : // Only display Excerpts for Search ?>
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
		<?php if ( ! is_sticky() ) : ?>
			<?php get_template_part('post/postfooter'); ?>
		<?php endif; ?>
	</article><!-- #post -->