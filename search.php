<?php
/**
 * This file is used to display your search result pages.
 *
 * @package Podcaster
 * @since 1.0
 */

$pod_sticky_header = pod_theme_option( 'pod-sticky-header', false );

/* Check for sidebars */
$pod_is_sidebar_active = is_active_sidebar( 'sidebar_blog' ) ? "pod-is-sidebar-active" : "pod-is-sidebar-inactive";

/* Titles */
$pod_search_heading = pod_theme_option( "pod-search-heading", 'Search Results for:' );

global $wp_query;
$total_results = $wp_query->found_posts;
 get_header(); ?>
 
	<?php if ( $pod_sticky_header == TRUE ) : ?>
	<div class="reg sticky">
	<?php else : ?>
	<div class="reg">
	<?php endif ; ?>
		<div class="static">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading">
							<div class="title">
								<h1><?php echo esc_html( $pod_search_heading ); ?> <?php echo get_search_query(); ?></h1>
								<p><?php printf( __('Your search has found %s results.', 'podcaster'), $total_results ); ?></p>
							</div><!-- title -->
						</div><!-- heading -->
					</div><!-- col -->
				</div><!-- row -->
			</div><!-- container -->
		</div><!-- static -->
	</div><!-- reg -->
	
	<div class="main-content archive-page archive-page-search <?php echo esc_attr( $pod_is_sidebar_active ); ?>">
        <div class="container">
	        <div class="row">
				<div class="col-lg-8 col-md-8">						
					<div class="entries-container arch_posts entries <?php echo pod_has_pagination( $wp_query->max_num_pages ); ?>">
						<!-- Start the Loop. -->
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							
						<?php
							/*This gets the template to display the posts.*/
							$format = get_post_format();
							get_template_part( 'post/format', $format );
						?>

						<?php endwhile; else: ?>
							<div class="post">
								<p><?php echo __('Sorry, no posts matched your criteria.', 'podcaster'); ?></p>
							</div><!--post-->
						<?php endif; wp_reset_query(); ?>
						<?php 
							$prev_link = get_previous_posts_link();
							$next_link = get_next_posts_link();
						?>

						<?php if ($prev_link || $next_link ) : ?>
						<div class="pagination clearfix">
							<?php 
							global $wp_query;
								$big = 999999999;			
								echo paginate_links(array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $wp_query->max_num_pages,
								'prev_text'    => __('&laquo;','podcaster'),
								'next_text'    => __('&raquo;','podcaster')
								)); 			
							?>
						</div><!-- pagination -->
						<?php endif ; ?>
					</div><!-- entries-container -->
				</div><!-- col-8 -->
				
				<?php if( is_active_sidebar( 'sidebar_blog' ) ) { ?>
				<div class="col-lg-4 col-md-4">
					<?php get_template_part( 'sidebar' ); ?> 
				</div><!-- col-4 -->
				<?php } ?>
				
	        </div><!-- row -->
        </div><!-- container -->
    </div><!-- main-content-->
    	
<?php
/* This displays the footer with help of footer.php */
get_footer(); ?>