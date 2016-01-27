<?php
/**
 * This file is used for your quote post format.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
 ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'thstlang' ); ?>
		</div>
		<?php endif; ?>
		
		<?php if ( is_search() || is_search() || is_sticky() ) : // Only display Excerpts for Search ?>
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