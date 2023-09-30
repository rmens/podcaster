<?php

/**
 * This file is used to display your archive, category, tag & author pages.
 *
 * @package Podcaster
 * @since 1.0
 */

$pod_sticky_header = pod_theme_option('pod-sticky-header', false);

/* Check for archive type */
$archive_type;
if( is_category() ) {
	$archive_type = "archive-page-categories";
} elseif( is_tag() ) {
	$archive_type = "archive-page-tags";
} elseif( is_author() ) {
	$archive_type = "archive-page-author";
}

/* Check for sidebars */
$pod_is_sidebar_active = is_active_sidebar( 'sidebar_blog' ) ? "pod-is-sidebar-active" : "pod-is-sidebar-inactive";

/* Titles */
$pod_cat_heading = pod_theme_option( "pod-category-heading", "Category:");
$pod_tag_heading = pod_theme_option( "pod-tag-heading", "Tag:" );

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
									<h1><?php echo esc_html( $pod_cat_heading ); ?> <?php single_cat_title(); ?></h1>
									<?php echo category_description(); ?>

								<?php } elseif( is_tag() ) { ?>
									<h1><?php echo esc_html( $pod_tag_heading ); ?> <?php single_tag_title(); ?></h1>
									<?php if( tag_description() != '' ) echo '</p>' . tag_description() . '</p>'; ?>

								<?php } elseif( is_author() ) { ?>
									<?php
										global $post;
										$author_id = $post->post_author; 
										$field = 'description'; 
										$field2 = 'display_name'; 
										$ava_email = get_the_author_meta('user_email', $author_id);
									?>
									<?php echo get_avatar( $ava_email, 100 ); ?>
									<h1><?php echo __('Post Archive of', 'podcaster'); ?> <?php the_author_meta( $field2, $author_id ); ?></h1>
									<p>
									<?php
										the_author_meta( $field, $author_id );
									?>
									</p>
								<?php } elseif( is_tax() ) { ?>

									<?php the_archive_title( '<h1>', '</h1>' ); ?>
									<?php the_archive_description( '<p>', '</p>' ); ?>

								<?php } else { ?>
									<?php 
										the_archive_title( '<h1>', '</h1>' );
										if ( the_archive_description() != '' ) {
											the_archive_description( '<p>', '</p>' );
										} else {
											$pod_arch_date = get_the_date('F, Y. '); ?>
											<p><?php printf( esc_html__( "You are viewing all posts published for the month of %s If you still can't find what you are looking for, try searching using the form at the right upper corner of the page.", 'podcaster' ), $pod_arch_date ); ?></p>
										<?php }
									?>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
	

	<div class="main-content archive-page <?php echo esc_attr( $archive_type ); ?> <?php echo esc_attr( $pod_is_sidebar_active ); ?>">
        <div class="container">
	        <div class="row">
				<div class="col-lg-8 col-md-8">						
					<div class="entries-container arch_posts entries <?php echo pod_has_pagination( $wp_query->max_num_pages ); ?>">
						<?php 
						// Start the Loop.
						if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							
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
				
				<?php if ( is_active_sidebar( 'sidebar_blog' ) ) {  ?>
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