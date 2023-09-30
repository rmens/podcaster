<?php
/**
 * This file is used for your status post format.
 * @package Podcaster
 * @since 1.0
 */
 ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

		<?php if ( is_search() || is_search() || is_sticky() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			
			<span class="icon_cont"><a class="status_icon" href="<?php the_permalink(); ?>"></a></span>
			<?php the_content(); ?>

		</div><!-- .entry-content -->
		<?php endif; ?>
		<?php if ( ! is_sticky() ) : ?>
			<?php get_template_part('post/postfooter'); ?>
		<?php endif; ?>
	</article><!-- #post -->