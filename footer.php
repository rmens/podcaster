<?php
/**
 * This file is used for your footer.
 *
 * @package Podcaster
 * @since 1.0
 */

$pod_display_icons = pod_theme_option( 'pod-social-footer', true );
$pod_footer_text = pod_theme_option( 'pod-footer-text', 'Powered by Podcaster for WordPress.' );
$pod_footer_copyright = pod_theme_option( 'pod-footer-copyright', get_bloginfo( 'name' ). ' &copy; ' .  date("Y") );

?>

<?php if( ! is_page_template( 'page/page-blank.php' ) ) { ?>
	<footer class="main-footer">
		<div class="footer-widgets">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-8 col-sm-8">
						<div class="footer-inner">
							<?php if( isset( $pod_footer_text ) && $pod_footer_text != '' ) : ?>
								<?php echo do_shortcode( $pod_footer_text ); ?>
							<?php endif; ?>						
						</div>
					</div>
					<?php if( $pod_display_icons == true ) { ?>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="footer-inner social_container">
							<?php if( $pod_display_icons == true ) : ?>
								<?php echo pod_social_media( "footer" ); ?>
							<?php endif; ?>			

						</div>
					</div><!-- .col -->
					<?php } ?>
				</div>
			</div>
		</div>
	</footer>

	<div class="sub-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<?php if( $pod_footer_copyright != '' ) : ?>
								<span><?php echo esc_html( $pod_footer_copyright ); ?></span>
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
<?php } ?>

<?php wp_footer(); /* Footer hook, do not delete, ever */ ?>

</body>
</html>