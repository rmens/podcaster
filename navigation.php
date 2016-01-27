<?php
/**
 * This file is used to display the navigation.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

$options = get_option('podcaster-theme');  
$pod_upload_logo_url = isset( $options['pod-upload-logo'] ) ? $options['pod-upload-logo'] : '';
$pod_responsive_style = isset( $options['pod-responsive-style'] ) ? $options['pod-responsive-style'] : '';
$pod_nav_search = pod_theme_option('pod-nav-search');

/* Social Media*/
$pod_display_icons = isset( $options['pod-social-nav'] ) ? $options['pod-social-nav'] : '';
$pod_email = isset( $options['pod-email'] ) ? $options['pod-email'] : '';
$pod_facebook = isset( $options['pod-facebook'] ) ? $options['pod-facebook'] : '';
$pod_twitter = isset( $options['pod-twitter'] ) ? $options['pod-twitter'] : '';
$pod_google = isset( $options['pod-google'] ) ? $options['pod-google'] : '';
$pod_instagram = isset( $options['pod-instagram'] ) ? $options['pod-instagram'] : '';
$pod_soundcloud = isset( $options['pod-soundcloud'] ) ? $options['pod-soundcloud'] : '';
$pod_tumblr = isset( $options['pod-tumblr'] ) ? $options['pod-tumblr'] : '';
$pod_pinterest = isset( $options['pod-pinterest'] ) ? $options['pod-pinterest'] : '';
$pod_flickr = isset( $options['pod-flickr'] ) ? $options['pod-flickr'] : '';
$pod_youtube = isset( $options['pod-youtube'] ) ? $options['pod-youtube'] :'';
$pod_vimeo = isset( $options['pod-vimeo'] ) ? $options['pod-vimeo'] : '';
$pod_skype = isset( $options['pod-skype'] ) ? $options['pod-skype'] : '';
$pod_dribbble = isset( $options['pod-dribbble'] ) ? $options['pod-dribbble'] : '';
$pod_weibo = isset( $options['pod-weibo'] ) ? $options['pod-weibo'] : '';
$pod_foursquare = isset( $options['pod-foursquare'] ) ? $options['pod-foursquare'] : '';
$pod_github = isset( $options['pod-github'] ) ? $options['pod-github'] : '';
$pod_xing = isset( $options['pod-xing'] ) ? $options['pod-xing'] : '';
$pod_linkedin = isset( $options['pod-linkedin'] ) ? $options['pod-linkedin'] : '';

?>

<div class="above <?php echo pod_audio_format_featured_image(); ?> <?php echo pod_has_featured_image(); ?> <?php echo pod_post_format(); ?> <?php echo pod_is_nav_sticky("large_nav"); ?> <?php echo pod_is_nav_transparent() ?> <?php echo $pod_responsive_style; ?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3">
				<header class="header" id="top" role="banner">
					<a href="#" id="open-off-can" class="open-menu batch" data-icon="&#xF0AA;"></a>
					<?php if ( isset( $pod_upload_logo_url ) && $pod_upload_logo_url != '' ) : ?>
					<h1 class="main-title logo">
					<?php else : ?>
					<h1 class="main-title">
					<?php endif ; ?>
						<a href="<?php echo home_url(); ?>/" title="<?php get_bloginfo( 'name' ); ?>" rel="home"><?php echo get_bloginfo( 'name' ); ?></a>
					</h1>
				</header><!--header-->
			</div><!--col-lg-3-->

			<div class="col-lg-9 col-md-9">
				<?php if ( $pod_nav_search == true ) : ?>
				<div class="nav-search-form">
					<a class="open-search-bar" href="#"><span data-icon="&#xF097;" class="batch"></span></a></span>
					<div class="search-form-drop">
						<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
						    <div class="search-container">
						        <input type="text" value="" placeholder="Type and press enter..." name="s" id="s" />
						        <input type="submit" id="searchsubmit" value="&#xF097;" class="batch" />
						    </div>
						</form>
					</div>
				</div>
				<?php endif; ?>
				<?php if( $pod_display_icons == true ){ ?>
				<div class="header-inner social_container"><?php if( $pod_email !="" ) { ?><a class="email social_icon" href="mailto:<?php echo $pod_email; ?>"></a><?php } ?><?php if( isset( $pod_facebook ) && $pod_facebook !="" ) { ?><a class="facebook social_icon" href="<?php echo $pod_facebook ?>"></a><?php } ?><?php if( isset( $pod_twitter ) && $pod_twitter !="" ) { ?><a class="twitter social_icon" href="<?php echo $pod_twitter ?>"></a><?php } ?><?php if( isset( $pod_google ) && $pod_google !="" ) { ?><a class="google social_icon" href="<?php echo $pod_google ?>"></a><?php } ?><?php if( isset( $pod_instagram ) && $pod_instagram !="" ) { ?><a class="instagram social_icon" href="<?php echo $pod_instagram ?>"></a><?php } ?><?php if( isset( $pod_soundcloud ) && $pod_soundcloud !="" ) { ?><a class="soundcloud social_icon" href="<?php echo $pod_soundcloud ?>"></a><?php } ?><?php if( isset( $pod_tumblr ) && $pod_tumblr !="" ) { ?><a class="tumblr social_icon" href="<?php echo $pod_tumblr ?>"></a><?php } ?><?php if( isset( $pod_pinterest ) && $pod_pinterest !="" ) { ?><a class="pinterest social_icon" href="<?php echo $pod_pinterest ?>"></a><?php } ?><?php if( isset( $pod_flickr ) && $pod_flickr !="" ) { ?><a class="flickr social_icon" href="<?php echo $pod_flickr ?>"></a><?php } ?><?php if( isset( $pod_youtube ) && $pod_youtube !="" ) { ?><a class="youtube social_icon" href="<?php echo $pod_youtube ?>"></a><?php } ?><?php if( isset( $pod_vimeo ) && $pod_vimeo !="" ) { ?><a class="vimeo social_icon" href="<?php echo $pod_vimeo ?>"></a><?php } ?><?php if( isset( $pod_skype ) && $pod_skype !="" ) { ?><a class="skype social_icon" href="<?php echo $pod_skype ?>"></a><?php } ?><?php if( isset( $pod_dribbble ) && $pod_dribbble !="" ) { ?><a class="dribbble social_icon" href="<?php echo $pod_dribbble ?>"></a><?php } ?><?php if( isset( $pod_weibo ) && $pod_weibo !="" ) { ?><a class="weibo social_icon" href="<?php echo $pod_weibo ?>"></a><?php } ?><?php if( isset( $pod_foursquare ) && $pod_foursquare !="" ) { ?><a class="foursquare social_icon" href="<?php echo $pod_foursquare ?>"></a><?php } ?><?php if( isset( $pod_github ) && $pod_github !="" ) { ?><a class="github social_icon" href="<?php echo $pod_github ?>"></a><?php } ?><?php if( isset( $pod_xing ) && $pod_xing !="" ) { ?><a class="xing social_icon" href="<?php echo $pod_xing ?>"></a><?php } ?><?php if( $pod_linkedin !="" ) { ?><a class="linkedin social_icon" href="<?php echo $pod_linkedin; ?>"></a><?php } ?></div>
				<?php } ?>
				
				<?php if ( $pod_responsive_style == 'toggle') { ?>
				<nav id="nav" class="navigation toggle" role="navigation">
				<?php } else { ?>
				<nav id="nav" class="navigation drop" role="navigation">
				<?php } ?>
				<?php if ( has_nav_menu( 'header-menu' ) ) { ?>					
					<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container_id' => 'res-menu', 'sort_column' => 'menu_order', 'menu_class' => 'thst-menu', 'fallback_cb' => false, 'container' => false )); ?>						
				<?php } else { ?>
				<div class="menu">
					<a href="<?php echo $url = admin_url( 'nav-menus.php', 'admin' ); ?>">Please click here to create and set your menu</a>
				</div>
				<?php } ?>
				</nav><!--navigation-->
			</div><!--col-lg-9-->
		</div><!--row-->
	</div><!--container-->
</div><!-- .above -->
<div class="nav-placeholder <?php echo pod_is_nav_sticky("large_nav"); ?> <?php echo pod_has_featured_image(); ?> <?php echo pod_is_nav_transparent() ?> <?php echo pod_audio_format_featured_image(); ?>"><p>This is a placeholder for your sticky navigation bar. It should not be visible.</p></div><!-- .above.placeholder -->