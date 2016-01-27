<?php

/**
 * This file is used to display your pages with a sidebar on the left.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*
Template Name: Sidebar Left
*/

get_header(); 

$attachment_id = get_post_thumbnail_id( $post->ID );
$image_attributes = wp_get_attachment_image_src( $attachment_id, 'original' ); // returns an array
$thumb_back = $image_attributes[0];

//Header Settings
$subtitle_blurb = get_post_meta($post->ID, 'cmb_thst_page_subtitle', true);
$bg_style = get_post_meta($post->ID, 'cmb_thst_page_header_bg_style', true);
$bg_parallax = get_post_meta($post->ID, 'cmb_thst_page_header_parallax', true);
$heading_align = get_post_meta($post->ID, 'cmb_thst_page_header_align', true);

?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="reg <?php echo pod_is_nav_sticky(); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?>">
		<div class="static">
			<?php  if( has_post_thumbnail() ) { ?>
				<?php if( $bg_parallax == 'on' ) { ?>
					<div class="content_page_thumb" style="background-image: url('<?php echo $thumb_back ?>'); <?php echo $bg_style ?>" data-stellar-background-ratio="0.25">
				<?php } else { ?>
					<div class="content_page_thumb" style="background-image: url('<?php echo $thumb_back ?>'); <?php echo $bg_style ?>">
				<?php } ?>
			<div id="loading_bg"></div>
			<div class="screen">
			<?php } ?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="heading">
								<div class="title" <?php if($heading_align !='' ) { ?> style="<?php echo $heading_align ?>"<?php } ?>>
									<h1><?php the_title(); ?></h1>
									<?php if( $subtitle_blurb !='') { ?>
									<p><?php echo $subtitle_blurb ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php if( has_post_thumbnail() ) { ?>
			</div>
			</div>
			<?php }  ?>
		</div>
	</div>
	
    <div class="main-content">
        <div class="container">
           <div class="row">
           		<div class="col-lg-8 col-md-8 pulls-right">
					<div class="page post">
						<div class="entry-content">						
							<?php the_content(); ?>
						</div>
						<?php 
							wp_link_pages(array(
						        'before' => '<div class="post_pagination clearfix">',
						        'after' => '</div>',
						        'next_or_number' => 'next_and_number',
						        'nextpagelink' => __('Next', 'thstlang'),
						        'previouspagelink' => __('Previous', 'thstlang'),
						        'pagelink' => '%',
						        'echo' => 1 )
						    );
						?>									
					</div><!--page post-->
					<div class="comment_container">						
						<?php comments_template(); ?> 
					</div><!--comment_container-->
				</div><!--col-lg-8-->

				<div class="col-lg-4 col-md-4 pulls-left">
					<?php get_template_part( 'sidebar' ); ?> 
				</div><!--col-lg-4-->
			</div><!--row-->
		</div><!--container-->
	</div><!--main-content-->
	
<?php endwhile; else: ?>
<p><?php echo __('Sorry, no posts matched your criteria.', 'thstlang'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>