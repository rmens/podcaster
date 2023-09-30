<?php
/**
 * Header.php is generally used on all the pages of your site and is called somewhere near the top
 * of your template files. It's a very important file that should never be deleted.
 *
 * @package Podcaster
 * @since 1.0
 */

$pod_social_color = pod_theme_option( 'pod-social-color', 'light-icons' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    
    <!-- Mobile Specific -->
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php 
    /* Title Tag backwards compatability for WP 4.0 and earlier. */
    if ( ! function_exists( '_wp_render_title_tag' ) ) {
        function pod_wp_render_title() {
    ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php
        }
        add_action( 'wp_head', 'pod_wp_render_title' );
    }
    ?>
    
    <?php 
        wp_head(); // Very important WordPress core hook. If you delete this bad things WILL happen. ?>

</head><!-- /end head -->
<?php if ( is_archive() || is_author() ) : ?>
    <body <?php body_class('podcaster-theme'); ?>>
<?php elseif ( get_post_type() == "podcast" && is_single() ) : ?>      
    <body id="single-post-<?php the_ID(); ?>" <?php body_class('podcast-archive podcaster-theme'); ?>>
<?php elseif ( is_single() ) : ?>      
    <body id="single-post-<?php the_ID(); ?>" <?php body_class('podcaster-theme'); ?>>

<?php elseif( is_page_template('page/pagesidebarleft.php') ) : ?>
    <body <?php body_class('sidebar-left podcaster-theme'); ?>>
<?php else : ?>
    <body <?php body_class('podcaster-theme'); ?>>
<?php endif; ?>

<?php 
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } 
?>

<div class="super-container <?php echo esc_attr( $pod_social_color ); ?>">
    <?php
        if( ! is_page_template( 'page/page-blank.php' ) ) {
            /*Loads the navigation.php template*/
            get_template_part( 'navigation' );
        }
    ?>