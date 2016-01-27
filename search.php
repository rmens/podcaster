<?php
/**
 * This file is used to display your archive type pages.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

$options = get_option('podcaster-theme');  
$pod_sticky_header = isset( $options['pod-sticky-header'] ) ? $options['pod-sticky-header'] : '';
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
								<h1><?php printf( __( 'Search Results for: %s', 'thstlang' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
								<p><?php printf( __('Your search has found %s results', 'thstlang'), $total_results ); ?></p>
							</div><!-- .title -->
						</div><!-- .heading -->
					</div><!-- .col -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .static -->
	</div><!-- .reg -->
	
	<div class="main-content">
        <div class="container">
	        <div class="row">
				<div class="col-lg-8 col-md-8">						
					<div class="arch_posts entries">
						<!-- Start the Loop. -->
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							
						<?php
							/*This gets the template to display the posts.*/
							$format = get_post_format();
							get_template_part( 'post/format', $format );
						?>

						<?php endwhile; else: ?>
							<div class="post">
								<p>Sorry, no posts matched your criteria.</p>
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
								'prev_text'    => __('&laquo;','thstlang'),
								'next_text'    => __('&raquo;','thstlang')
								)); 			
							?>
						</div><!-- .pagination -->
						<?php endif ; ?>
					</div><!-- .arch_posts -->
				</div><!-- .col -->
					
				<div class="col-lg-4 col-md-4">
					<?php get_template_part( 'sidebar' ); ?> 
				</div><!-- .col4 -->
	        </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .main-content-->	
<?php get_footer(); ?>