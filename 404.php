<?php
/**
 * This file is used to display your standard pages.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.co
 * @copyright Copyright (c) 2013, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

get_header(); 

?>

	<div class="main-content page">
        <div class="container">
	        <div class="row">
				<div class="col-lg-12">
					<div class="page post">
						<div class="content">
							<div class="post_body clearfix">
								<h2><?php echo __('404 Error', 'thstlang'); ?></h2>
								<p><?php echo __('Sorry, the page you requested cannot be found', 'thstlang'); ?></p>
							</div><!-- .post_body -->
						</div><!-- .content -->			
					</div><!-- .page.post-->
			    </div><!-- .col -->
	        </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .main-content -->
	
<?php get_footer(); ?>