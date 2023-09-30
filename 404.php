<?php
/**
 * This file is used to display your 404 pages.
 *
 * @package Podcaster
 * @since 1.0
 */

get_header(); 

?>

	<div class="main-content page page-404">
        <div class="container">
	        <div class="row">
				<div class="col-lg-12">
					<div class="entry-container content">
						<div class="entry-content post_body clearfix">
							<h2><?php echo __('404 Error', 'podcaster'); ?></h2>
							<p><?php echo __('Sorry, the page you requested cannot be found.', 'podcaster'); ?></p>
							<a href="<?php echo esc_url( home_url() ); ?>" class="butn small"><?php echo esc_html( "&larr; Back Home" ); ?></a>
						</div><!-- entry-content -->
					</div><!-- entry-container -->			
			    </div><!-- col-12 -->
	        </div><!-- row -->
        </div><!-- container -->
    </div><!-- main-content -->
	
<?php get_footer(); ?>