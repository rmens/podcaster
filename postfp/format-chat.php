<?php
/**
 * This file is used for your chat post format.
 * @package Podcaster
 * @since 1.0
 */
 ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
				
		<?php get_template_part('post/postheader'); ?>

		<?php if ( is_archive() || is_search() || is_sticky() ) : // Only display Excerpts for Search ?>
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