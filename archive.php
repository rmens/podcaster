<?php

/**
 * This file is used to display your archive type pages.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station
 * @copyright Copyright (c) 2013, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

$options = get_option('podcaster-theme');  
$pod_sticky_header = isset( $options['pod-sticky-header'] ) ? isset( $options['pod-sticky-header'] ) : '';

 get_header(); ?>
	<?php if ( isset( $pod_sticky_header ) && $pod_sticky_header == TRUE ) : ?>
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
								<?php if( is_category() ) { ?>
									<h1>Category: <?php single_cat_title(); ?></h1>
									<?php echo category_description(); ?>
								<?php } elseif( is_tag() ) { ?>
									<h1>Tag: <?php single_tag_title(); ?></h1>
									<?php if(tag_description() != '') echo '</p>' .tag_description(). '</p>'; ?>
								<?php } elseif( is_author() ) { ?>
									<?php
										global $post;
										$author_id=$post->post_author; 
										$field='description'; 
										$field2='display_name'; 
										$ava_email = get_the_author_meta('user_email', $author_id);
									?>
									<?php echo get_avatar( $ava_email, 100 ); ?>
									<h1>Post Archive of <?php the_author_meta( $field2, $author_id ); ?></h1>
									<p>
									<?php
										the_author_meta( $field, $author_id );
									?>
									</p>
								<?php } else { ?>
									<?php 
										the_archive_title( '<h1>', '</h1>' );
										if ( the_archive_description() != '' ) {
											the_archive_description( '<p>', '</p>' );
										} else {
											echo '<p>You are viewing all posts published for the month of ' . get_the_date('F, Y. ') . 'If you still can\'t find what you are looking for, try searching using the form at the right upper corner of the page.</p>';
										}
									?>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
	

	<div class="main-content page">
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