<?php
/**
 * This file is used for your aside post format.
 * @package Podcaster
 * @since 1.0
 */
 ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		
		<?php get_template_part('post/postheader'); ?>

		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'podcaster' ); ?>
		</div>
		<?php endif; ?>
		
		<?php if ( is_search() || is_search() || is_sticky() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content(); ?><?php if( ! is_single() ) { ?><a href="<?php the_permalink(); ?>"><?php echo __('&#8734;', 'podcaster'); ?></a><?php } ?>
		</div><!-- .entry-content -->
		<?php endif; ?>                                                                

		<?php if ( ! is_sticky() ) : ?>
			<?php get_template_part('post/postfooter'); ?>
		<?php endif; ?>
	</article><!-- #post -->