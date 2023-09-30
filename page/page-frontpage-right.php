<?php

/**
 * This file is used to display your front page.
 * @package Podcaster
 * @since 1.0
 */

/*
Template Name: Front Page (Right Sidebar)
*/

get_header(); 
	
	$active_plugin = pod_get_plugin_active();
	$ep_classes = pod_front_page_episodes_classes();
	$cols_cont = pod_front_page_episodes_cols_cont_classes();
	$cols_side = pod_front_page_episodes_cols_side_classes();
	
	/* Theme Options */
	$pod_content_position = pod_theme_option('pod-front-page-content-position', 'content-above-episodes');
	$pod_fp_style = pod_theme_option('pod-front-style');
	$pod_excerpts_style  = pod_theme_option('pod-excerpts-style', 'list');
	$pod_front_newsletter = pod_theme_option( 'pod-frontpage-newsletter-active' );
	$pod_front_num_posts = pod_theme_option('pod-front-posts', 9);

	if ( have_posts() ) : while ( have_posts() ) : the_post();

	$paged_static = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;

	?>	

	<?php if ( $paged_static == 1 ) {
		if( function_exists( 'pod_featured_header_container' ) ) {
			echo pod_featured_header_container();
		}
	} ?>
	   		
			
			<div class="list-of-episodes <?php echo esc_attr( $ep_classes ); ?>">
				<div class="container">

					<div class="row">
						<div class="<?php echo esc_attr( $cols_cont ); ?>">
							<?php if( $pod_content_position == 'content-above-episodes' && $post->post_content != '' ){ ?>
								<div class="front-page-the-content">
									<?php the_content(); ?>
									<div class="clear"></div>
								</div>
							<?php } ?>


							<?php if( $pod_front_num_posts != 0 ) { ?>
								
								<div class="row masonry-container">
									<div class="grid-sizer"></div>
									<div class="gutter-sizer"></div>
									
						   			<?php 
						   			

									$args = pod_front_page_episodes_query_args();

									// Calculate offset for ajax loading.
									if ( isset( $args['offset'] ) ) {
									    $offset = absint( $args['offset'] );
									    $args['offset'] = absint( ( $args['paged'] - 1 ) * $args['posts_per_page'] ) + $offset;
									}

									$wp_query_episodes = new WP_Query( $args );

									if( $wp_query_episodes->have_posts() ) {
										while( $wp_query_episodes->have_posts() ) {
											$wp_query_episodes->the_post(); 

											get_template_part('templates-parts/frontpage','episodes');
										}
									}

									wp_reset_query(); 
								} ?>

								<?php if($pod_fp_style == "front-page-grid" ) { echo pod_loading_spinner(); } ?>
					   			</div><!-- .row -->

				   			
							<?php echo pod_front_page_episodes_pagination( $wp_query_episodes ); ?>


							<?php if( $pod_content_position == 'content-below-episodes' && $post->post_content != '' ){ ?>
								<div class="front-page-the-content">
									<?php the_content(); ?>
									<div class="clear"></div>
								</div>
							<?php } ?>

				   		</div>

				   		<?php if( is_active_sidebar( 'sidebar_front' ) ) { ?>
					   		<div class="<?php echo esc_attr( $cols_side ); ?>">
					   			<?php
								//This displays the sidebar with help of sidebar.php
								get_template_part('sidebar'); ?>
					   		</div>
					   	<?php } ?>


				   	</div>
		   		</div><!-- .container -->
			</div><!-- .list-of-episodes -->

			<?php echo pod_host_section(); ?>
			<?php echo pod_call_to_action_section(); ?>

			<?php if( $pod_excerpts_style != 'hide' || $pod_front_newsletter == true ) { ?>
				<div class="front-page-secondary <?php echo esc_attr( $pod_excerpts_style ); ?>">

					<?php pod_from_the_blog(); ?>

					<?php if( $pod_front_newsletter == true ) : ?>
						<?php echo pod_front_page_newsletter_section(); ?>
					<?php endif; ?>

				</div><!-- .front-page-secondary -->
			<?php } ?>

<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>