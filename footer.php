<?php
/**
 * This file is used for your footer.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
$options = get_option('podcaster-theme');  
$pod_display_icons = isset( $options['pod-social-footer'] ) ? $options['pod-social-footer'] : '';
$pod_footer_text = isset( $options['pod-footer-text'] ) ? $options['pod-footer-text'] : '';
$pod_footer_copyright = isset( $options['pod-footer-copyright'] ) ? $options['pod-footer-copyright'] : '';

/* Social Media*/
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

<footer class="main">
	<div class="footer-widgets">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-8">
					<div class="footer-inner">
						<?php if( isset( $pod_footer_text ) && $pod_footer_text != '' ) : ?>
							<?php echo $pod_footer_text; ?>
						<?php endif; ?>						
					</div>
				</div>
				<?php if( $pod_display_icons == true ) { ?>
				<div class="col-lg-4 col-md-4 col-sm-4">
					<div class="footer-inner social_container">
						<?php if( $pod_email !="" ) { ?>
						<a class="email social_icon" href="mailto:<?php echo $pod_email; ?>"></a>
						<?php } ?>
						<?php if( $pod_facebook !="" ) { ?>
							<a class="facebook social_icon" href="<?php echo $pod_facebook ?>"></a>
						<?php } ?>
						<?php if( $pod_twitter !="" ) { ?>
							<a class="twitter social_icon" href="<?php echo $pod_twitter ?>"></a>
						<?php } ?>
						<?php if( $pod_google !="" ) { ?>
						<a class="google social_icon" href="<?php echo $pod_google ?>"></a>
						<?php } ?>
						<?php if( $pod_instagram !="" ) { ?>
						<a class="instagram social_icon" href="<?php echo $pod_instagram ?>"></a>
						<?php } ?>
						<?php if( $pod_soundcloud !="" ) { ?>
						<a class="soundcloud social_icon" href="<?php echo $pod_soundcloud ?>"></a>
						<?php } ?>
						<?php if( $pod_tumblr !="" ) { ?>
						<a class="tumblr social_icon" href="<?php echo $pod_tumblr ?>"></a>
						<?php } ?>
						<?php if( $pod_pinterest !="" ) { ?>
						<a class="pinterest social_icon" href="<?php echo $pod_pinterest ?>"></a>
						<?php } ?>
						<?php if( $pod_flickr !="" ) { ?>
						<a class="flickr social_icon" href="<?php echo $pod_flickr ?>"></a>
						<?php } ?>
						<?php if( $pod_youtube !="" ) { ?>
						<a class="youtube social_icon" href="<?php echo $pod_youtube ?>"></a>
						<?php } ?>
						<?php if( $pod_vimeo !="" ) { ?>
						<a class="vimeo social_icon" href="<?php echo $pod_vimeo ?>"></a>
						<?php } ?>
						<?php if( $pod_skype !="" ) { ?>
						<a class="skype social_icon" href="<?php echo $pod_skype ?>"></a>
						<?php } ?>
						<?php if( $pod_dribbble !="" ) { ?>
						<a class="dribbble social_icon" href="<?php echo $pod_dribbble ?>"></a>
						<?php } ?>
						<?php if( $pod_weibo !="" ) { ?>
						<a class="weibo social_icon" href="<?php echo $pod_weibo ?>"></a>
						<?php } ?>
						<?php if( $pod_foursquare !="" ) { ?>
						<a class="foursquare social_icon" href="<?php echo $pod_foursquare ?>"></a>
						<?php } ?>
						<?php if( $pod_github !="" ) { ?>
						<a class="github social_icon" href="<?php echo $pod_github ?>"></a>
						<?php } ?>
						<?php if( $pod_xing !="" ) { ?>
						<a class="xing social_icon" href="<?php echo $pod_xing ?>"></a>
						<?php } ?>
						<?php if( $pod_linkedin !="" ) { ?>
						<a class="linkedin social_icon" href="<?php echo $pod_linkedin; ?>"></a>
						<?php } ?>
						

					</div>
				</div><!-- .col -->
				<?php } ?>
			</div>
		</div>
	</div>
</footer>

<div class="postfooter">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-4 col-md-4">
						<?php if( isset( $pod_footer_copyright ) ) : ?>
							<span><?php echo $pod_footer_copyright; ?></span>
						<?php else : ?>
							<span><?php echo get_bloginfo( 'name' ); ?></span> &copy; <?php echo date("Y"); ?>
						<?php endif; ?>
					</div><!-- .col -->
					<div class="col-lg-8 col-md-8">
						<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'depth' => 1,  'sort_column' => 'menu_order', 'menu_class' => 'thst-menu', 'fallback_cb' => false, 'container' => 'nav' )); ?>
					</div><!-- .col -->
				</div><!-- .row -->
			</div><!-- .col -->
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .post-footer -->

</div><!--end .supercontainer-->
<?php wp_footer(); /* Footer hook, do not delete, ever */ ?>

</body>
</html>