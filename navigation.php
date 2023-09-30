<?php
/**
 * This file is used to display the navigation.
 *
 * @package Podcaster
 * @since 1.0
 */
$post_id = get_the_ID();
$pod_upload_logo_url = pod_theme_option( 'pod-upload-logo' );
$pod_sticky_nav_active = pod_theme_option( 'pod-sticky-header', false );
$pod_responsive_style = pod_theme_option( 'pod-responsive-style', 'toggle' );
$pod_nav_search = pod_theme_option( 'pod-nav-search', false );

$pod_display_icons = pod_theme_option( 'pod-social-nav', true );
$pod_display_icons_active = $pod_display_icons ? "social-media-active" : "social-media-inactive"; ?>


<div class="above <?php echo pod_audio_format_featured_image( $post_id ); ?> <?php echo pod_has_featured_image(); ?> <?php echo pod_post_format(); ?> <?php echo pod_is_nav_sticky("large_nav"); ?> <?php echo pod_is_nav_transparent() ?> <?php echo esc_attr( $pod_responsive_style ); ?> <?php echo esc_attr( $pod_display_icons_active ); ?>">

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="above-inner">

					<header class="header" id="top">
						<?php echo pod_logo_img(); ?>
					</header><!--header-->

					<a href="#" id="open-off-can" class="open-menu"><span class="fas fa-bars"></span></a>
				
					<?php if( $pod_display_icons == true ){ ?>
							<?php echo pod_social_media( "header" ); ?>
					<?php } ?>

					
					<?php if ( $pod_responsive_style == 'toggle') { ?>
					<nav id="nav" class="navigation toggle">
					<?php } else { ?>
					<nav id="nav" class="navigation drop">
					<?php } ?>
					<?php if ( has_nav_menu( 'header-menu' ) ) { ?>					
						<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container_id' => 'res-menu', 'sort_column' => 'menu_order', 'menu_class' => 'thst-menu', 'fallback_cb' => false, 'container' => false )); ?>						
					<?php } ?>
					</nav><!--navigation-->

					<?php echo pod_nav_search_bar(); ?>
				</div>


			</div><!--col-lg-12-->
		</div><!--row-->
	</div><!--container-->
</div><!-- .above -->

<?php if( $pod_sticky_nav_active ) { ?>
	<div class="nav-placeholder <?php echo pod_is_nav_sticky("large_nav"); ?> <?php echo pod_has_featured_image(); ?> <?php echo pod_is_nav_transparent() ?> <?php echo pod_audio_format_featured_image(); ?>"><p><?php echo __('This is a placeholder for your sticky navigation bar. It should not be visible.', 'podcaster'); ?></p></div><!-- .above.placeholder -->
<?php } ?>