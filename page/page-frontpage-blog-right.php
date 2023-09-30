<?php

/**
 * This file is used to display your front page with a blog and sidebar on the right.
 * @package Podcaster
 * @since 1.8.9
 */

/*
Template Name: Front Page (Blog - Sidebar Right)
*/

get_header();



	if ( have_posts() ) : while ( have_posts() ) : the_post();

	$active_plugin = pod_get_plugin_active();
	$paged_static = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;

	$pod_list_of_posts_button = pod_theme_option('pod-front-page-button-type');
	$pod_ajax_button_text = pod_theme_option('pod-ajax-link-txt', 'Load More');
	$pod_archive_link = pod_theme_option('pod-archive-link');
	$pod_archive_link_txt = pod_theme_option('pod-archive-link-txt');

	/* Podcast Archive */
	$arch_category = pod_theme_option('pod-recordings-category', '');
	$arch_category = ( $arch_category != '' ) ? (int) $arch_category : '';

	/* Featured Header Settings */
	$pod_fh_type = pod_theme_option('pod-featured-header-type', 'static');
	$featured_content = pod_theme_option('pod-featured-header-content');
	$pod_slide_amount = pod_theme_option('pod-featured-header-slides-amount', 4);

	if( $pod_fh_type == 'text' || $pod_fh_type == 'hide' || $pod_fh_type == 'video-bg' ){
		$offset = 0;
	} else {
		if( $featured_content == 'featured' && ( $pod_fh_type == 'static-posts' || $pod_fh_type == 'slideshow' )){
			$offset = 0;
		} else {
			$offset = 1;
		}
	}

	$featured_content = pod_theme_option('pod-featured-header-content', 'newest');
	$pod_featured_excerpt = pod_theme_option('pod-frontpage-fetured-ex', 'show');
	$pod_excerpt_type = pod_theme_option('pod-excerpts-type', 'force_excerpt');
	$pod_content_position = pod_theme_option('pod-front-page-content-position', 'content-above-episodes');

	/* List of episodes */
	$pod_front_num_posts = pod_theme_option('pod-front-posts', 9);

	/* From the Blog */
	$pod_excerpts_style  = pod_theme_option('pod-excerpts-style', 'list');
	$pod_exceprts_title = pod_theme_option('pod-excerpts-section-title', 'From the Blog');
	$pod_excerpts_desc = pod_theme_option('pod-excerpts-section-desc');
	$pod_excerpts_button = pod_theme_option('pod-excerpts-section-button');
	$pod_fh_t_media = pod_theme_option('pod-featured-header-text-media-activate', false);


	/* Avatar Settings */
	$pod_avtr_frnt = pod_theme_option('pod-avatar-front', true);
	$show_avtrs = get_option('show_avatars');
	
	/* Hosts */
	$pod_front_hosts = pod_theme_option('pod-frontpage-hosts-active');

	/* Newsletter */
	$pod_front_newsletter = pod_theme_option( 'pod-frontpage-newsletter-active' );

	/* Responsive settings */
	$pod_resp_layout = pod_theme_option('pod-responsive-layout');

	// Truncate settings
	$pod_truncate_title = pod_theme_option('pod-front-page-titles');
	$is_truncate = $pod_truncate_title ? " truncate" : " not-truncate";

	/* Corners */
	$pod_entries_corners = pod_theme_option('pod-front-page-entries-corners');
	$pod_entries_corners_opts = pod_theme_option('pod-front-page-entries-corners-opts');
	?>	

	<?php if( $paged_static == 1) { 

		if( function_exists( 'pod_featured_header_container' ) ) {
			echo pod_featured_header_container();
		}

	} ?>

			<div class="main-content blog-front-page blog-front-page-right-sidebar <?php echo esc_attr( $pod_excerpt_type ); ?> <?php echo esc_attr( $pod_entries_corners ); ?> <?php echo esc_attr( $pod_entries_corners_opts ); ?> <?php echo esc_attr( $pod_resp_layout ); ?>">
				<div class="container">
					<div class="row">

						

						<div class="col-lg-8 col-md-8">
							<?php if( $pod_content_position == 'content-above-episodes' && $post->post_content != '' ){ ?>
								<div class="front-page-the-content">
									<?php the_content(); ?>
									<div class="clear"></div>
								</div>
							<?php } ?>

							<div class="entries-container entries">

							<?php
								if( $active_plugin == 'ssp' ) {

									$ssp_post_types = ssp_post_types();
									$ssp_arch_category = pod_ssp_active_cats("ssp");
									
									if ( isset( $pod_front_num_posts ) && ( isset( $ssp_arch_category ) || isset( $arch_category ) ) ) { 
										$args = array( 
											'post_type' => $ssp_post_types,
											'posts_per_page' => $pod_front_num_posts, 
											'paged' => $paged_static, 
											'ignore_sticky_posts' => true,
											'offset' => $offset,
											'tax_query' => array(
								                'relation' => 'OR',
								                array(
								                    'taxonomy' => 'category',
								                    'field'    => 'term_id',
								                    'terms'    => $arch_category,
								                ),
								                array(
								                    'taxonomy' => 'series',
								                    'field'    => 'term_id',
								                    'terms'    => $ssp_arch_category,
								                ),
								            ),
										);
									} else {
										$args = array( 
											'post_type' => $ssp_post_types,
											'posts_per_page' => $pod_front_num_posts, 
											'paged' => $paged_static, 
											'ignore_sticky_posts' => true,
											'offset' => $offset,
										);
									}

								} else {

									if ( isset( $pod_front_num_posts ) && isset( $arch_category ) ) { 
							   			$args = array( 
							   				'cat' => $arch_category, 
							   				'posts_per_page' =>  $pod_front_num_posts,
							   				'paged' => $paged_static,
							   				'ignore_sticky_posts' => true,
							   				'offset' => $offset,
							   			);
								  	} else { 
								  		$args = array( 
								  			'cat' => 'uncategorized', 
								  			'posts_per_page' => 4, 
								  			'paged' => $paged_static,
							   				'ignore_sticky_posts' => true,
								  			'offset' => $offset,
								  		);
								  	}

								}

								// Calculate offset for ajax loading.
								if ( isset( $args['offset'] ) ) {
								    $offset = absint( $args['offset'] );
								    $args['offset'] = absint( ( $args['paged'] - 1 ) * $args['posts_per_page'] ) + $offset;
								}

								 ?>

								<?php 

									$wp_query_episodes = new WP_Query( $args );

									if( $wp_query_episodes->have_posts() ) {
										while( $wp_query_episodes->have_posts() ) {
										   	$wp_query_episodes->the_post(); 

										   	$format = get_post_format();
											get_template_part( 'postfp/format', $format );
									
									   }
									}

									wp_reset_query();

								?>

								<?php 		
									if ( $wp_query_episodes->max_num_pages > 1 && $pod_list_of_posts_button == "list-of-posts-ajax" ) { ?>

										<div class="pod_loadmore"><?php echo esc_html( $pod_ajax_button_text ); ?></div>

									<?php } elseif( $pod_list_of_posts_button == "list-of-posts-pagination" ) { ?>							

										<div class="pagination clearfix">
											<?php 
												$big = 999999999; // need an unlikely integer

												echo paginate_links( array(
													'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
													'format' => '?paged=%#%',
													'current' => max( 1, get_query_var('page') ),
													'total' => $wp_query_episodes->max_num_pages,
												
												)); 
											?> 
										</div><!-- pagination -->

									<?php } elseif( $pod_list_of_posts_button == "list-of-posts-custom" ) { ?>
										<a class="butn small archive-link-button" href="<?php echo esc_url( $pod_archive_link ); ?>"><?php echo esc_html( $pod_archive_link_txt ); ?></a>
									<?php } ?>

							</div><!-- entries -->

							<?php if( $pod_content_position == 'content-below-episodes' && $post->post_content != ''  ){ ?>
								<div class="front-page-the-content">
									<?php the_content(); ?>
									<div class="clear"></div>
								</div>
							<?php } ?>
						</div><!-- col-8 -->			
						
						<?php if ( is_active_sidebar( 'sidebar_blog' ) ) { ?>	
							<div class="col-lg-4 col-md-4">
								<?php
								//This displays the sidebar with help of sidebar.php
								get_template_part('sidebar'); ?>
							</div><!-- col-4 -->
						<?php } ?>

					</div><!-- .row -->
		   		</div><!-- .container -->
			</div><!-- .main-content -->


			<?php if( $pod_front_hosts == true ) : ?>
			<div class="hosts-container">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">

							<?php echo pod_host_section(); ?>

						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>


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