<?php

/**
 * This file is used to display your archive pages.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Template Name: Archive Page */

get_header(); ?>

	
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post(); 

$attachment_id = get_post_thumbnail_id( $post->ID );
$image_attributes = wp_get_attachment_image_src( $attachment_id, 'original' ); // returns an array
$thumb_back = $image_attributes[0];

//Header Settings
$subtitle_blurb = get_post_meta($post->ID, 'cmb_thst_page_subtitle', true);
$bg_style = get_post_meta($post->ID, 'cmb_thst_page_header_bg_style', true);
$bg_parallax = get_post_meta($post->ID, 'cmb_thst_page_header_parallax', true);
$heading_align = get_post_meta($post->ID, 'cmb_thst_page_header_align', true);

$options = get_option('podcaster-theme');

?>	
	

	<div class="reg <?php echo pod_is_nav_sticky(); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?>">
		<div class="static">
			<?php if( has_post_thumbnail() ) : ?>
				<?php if( $bg_parallax == 'on' ) : ?>
					<div class="content_page_thumb" style="background-image: url('<?php echo $thumb_back ?>'); <?php echo $bg_style ?>" data-stellar-background-ratio="0.25">
				<?php else : ?>
					<div class="content_page_thumb" style="background-image: url('<?php echo $thumb_back ?>'); <?php echo $bg_style ?>">
				<?php endif; ?>
			<div id="loading_bg"></div>
			<div class="screen">
			<?php endif; ?>
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
			<?php if( has_post_thumbnail() ) : ?>
			</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
		
    <div class="main-content page archive-page">
        <div class="container">
           <div class="row">
				<div class="col-lg-8 col-md-8">
					<div class="page post">
						<div class="entry-content clearfix">
							<?php the_content(); ?>
	
							<div class="arch_searchform">
								<form class="clearfix" action="<?php bloginfo('siteurl'); ?>" id="ind_searchform" method="get">
								    <div class="first">
								        <label for="s" class="screen-reader-text">Search for:</label>
								        <input type="search" id="ind_s" name="s" value="" placeholder="<?php echo __( 'Search Archives', 'thstlang' ); ?>" />
								    </div>
								    <div class="second">
									        <input value="&#xF097;" class="batch" type="submit" id="ind_searchsubmit" />
								    </div>
								</form>
							</div>
							<div class="row archive_cols">
								<div class="col-lg-6 col-md-6 col-sm-6">
									<h2><?php echo __('By Date', 'thstlang'); ?>:</h2>
									<ul>
										<?php wp_get_archives('type=monthly'); ?>
									</ul>
								</div>
	
								<div class="col-lg-6 col-md-6 col-sm-6">						
									<h2><?php echo __('By Topic', 'thstlang') ?>:</h2>
									<ul>
										<?php wp_list_categories('title_li='); ?>
									</ul>
								</div>
							</div><!--row-->
							<?php comments_template(); ?> 
						</div><!--content-->			
					</div>
				</div><!--span8-->
						
				<div class="col-lg-4 col-md-4">
					<?php get_template_part( 'sidebar' ); ?> 
				</div><!--span4-->
            </div>
        </div>
	</div>

	<?php endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
<?php get_footer(); ?>