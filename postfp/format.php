<?php
/**
 * This file is used for your standard post format.
 * @package Podcaster
 * @since 1.0
 */
$active_plugin = pod_get_plugin_active();

$format = get_post_format();
$post_type = get_post_type();


 $pod_butn_one = pod_theme_option( 'pod-subscribe1', 'Subscribe with Apple Podcasts' );
 $pod_butn_one_url = pod_theme_option( 'pod-subscribe1-url', '' );
 $pod_butn_two = pod_theme_option( 'pod-subscribe2', 'Subscribe with RSS' );
 $pod_butn_two_url = pod_theme_option( 'pod-subscribe2-url', '' );
 $pod_subscribe_single = pod_theme_option( 'pod-subscribe-single', true );
 $pod_players_preload = pod_theme_option('pod-players-preload', 'none');
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php get_template_part('post/postheader'); ?>

		<?php if( $active_plugin == "ssp" ) { ?>

			<?php if( $post_type == "podcast" ) { ?>

			    <?php if( is_single() && ( $pod_subscribe_single == true ) ) { ?>
					<div id="mediainfo">
						<?php if( $pod_butn_one != '' ) { ?>
							<a class="butn small" href="<?php echo esc_url( $pod_butn_one_url ); ?>"><?php echo esc_html( $pod_butn_one ); ?></a>
						<?php } ?>

						<?php if( $pod_butn_two != '') { ?>
							<a class="butn small sub-button-two" href="<?php echo esc_url( $pod_butn_two_url ); ?>"><?php echo esc_html( $pod_butn_two ); ?></a>
						<?php } ?>
			    	</div><!--mediainfo -->
			    <?php } ?>			

				<div class="featured-media">

					<?php echo pod_get_featured_player( $post->ID ); ?>
					
				</div>

			<?php } ?>

		<?php } ?>

		<?php if ( is_archive() || is_search() ) : // Only display Excerpts for Search ?>
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
