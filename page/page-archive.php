<?php

/**
 * This file is used to display your archive pages.
 * @package Podcaster
 * @since 1.0
 */

/* Template Name: Archive Page */

get_header(); ?>

	
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post(); 

$attachment_id = get_post_thumbnail_id( $post->ID );
$image_attributes = wp_get_attachment_image_src( $attachment_id, 'original' ); // returns an array
$thumb_back = !empty( $image_attributes ) ? $image_attributes[0] : '';

//Header Settings
$subtitle_blurb = get_post_meta($post->ID, 'cmb_thst_page_subtitle', true);
$bg_style = get_post_meta($post->ID, 'cmb_thst_page_header_bg_style', true);
$bg_parallax = get_post_meta($post->ID, 'cmb_thst_page_header_parallax', true);
$heading_align = get_post_meta($post->ID, 'cmb_thst_page_header_align', true);

/* Check for sidebars */
$pod_is_sidebar_active = is_active_sidebar( 'sidebar_page' ) ? "pod-is-sidebar-active" : "pod-is-sidebar-inactive";


?>	
	
	<div class="reg <?php echo pod_is_nav_sticky(); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?>">
		<div class="static">
			<?php if( has_post_thumbnail() ) : ?>
				<div class="content_page_thumb">
				
			<?php echo pod_loading_spinner(); ?>
			<?php echo pod_header_parallax( $post->ID ); ?>

			<div class="screen">
			<?php endif; ?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="heading">
								<div class="title" <?php if($heading_align !='' ) { ?> style="<?php echo esc_attr( $heading_align ); ?>"<?php } ?>>
									<h1><?php the_title(); ?></h1>
									<?php if( $subtitle_blurb !='') { ?>
									<p><?php echo esc_html( $subtitle_blurb ); ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php if( has_post_thumbnail() ) : ?>
			</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
		
    <div class="main-content page page-template-archive <?php echo esc_attr( $pod_is_sidebar_active ); ?>">
        <div class="container">
           <div class="row">
				<div class="col-lg-8 col-md-8">

					<div class="entry-container content">
						<div class="entry-content clearfix">
							<?php the_content(); ?>
	
							<div class="arch_searchform">
								<form class="clearfix" action="<?php echo home_url( '/' ); ?>" id="ind_searchform" method="get">
								    <div class="first">
								        <label for="s" class="screen-reader-text"><?php echo __('Search for:', 'podcaster'); ?></label>
								        <input type="search" id="ind_s" name="s" value="" placeholder="<?php echo __( 'Search Archives', 'podcaster' ); ?>" />
								    </div>
								    <div class="second">
									    <button value="Submit" type="submit" id="ind_searchsubmit"><span class="fa fa-search"></span></button>
								    </div>
								</form>
							</div>
							<div class="row archive_cols">
								<div class="col-lg-6 col-md-6 col-sm-6">
									<h2><?php echo __('By Date', 'podcaster'); ?>:</h2>
									<ul>
										<?php wp_get_archives('type=monthly'); ?>
									</ul>
								</div>
	
								<div class="col-lg-6 col-md-6 col-sm-6">						
									<h2><?php echo __('By Topic', 'podcaster') ?>:</h2>
									<ul>
										<?php wp_list_categories('title_li='); ?>
									</ul>
								</div>
							</div><!--row-->

						</div><!-- entry-content -->

						<?php if( comments_open() ) : ?>
							<div class="comment_container">						
								<?php comments_template(); ?> 
							</div><!-- comment_container -->
						<?php endif; ?>
					</div><!-- entry-container -->

				</div><!-- col-8 -->
				
				<?php if( is_active_sidebar( 'sidebar_page' ) ) { ?>
				<div class="col-lg-4 col-md-4">
					<?php get_template_part( 'sidebar' ); ?> 
				</div><!-- col-4 -->
				<?php } ?>

            </div>
        </div>
	</div>

	<?php endwhile; else: ?>
		<p><?php echo __('Sorry, no posts matched your criteria.', 'podcaster'); ?></p>
	<?php endif; ?>
<?php get_footer(); ?>