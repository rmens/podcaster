<?php
/**
 * Header.php is generally used on all the pages of your site and is called somewhere near the top
 * of your template files. It's a very important file that should never be deleted.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

$pod_social_color = pod_theme_option('pod-social-color');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    
    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--[if lt IE 9]>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    
    <!-- Title Tag -->
    <?php if ( ! function_exists( '_wp_render_title_tag' ) ) {
        function pod_wp_render_title() {
    ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php
        }
        add_action( 'wp_head', 'pod_wp_render_title' );
    }
    ?>
    
    
    <!-- WP Head -->
    <?php wp_head(); // Very important WordPress core hook. If you delete this bad things WILL happen. ?>

</head><!-- /end head -->
<?php if ( is_archive() || is_author() ) : ?>
    <body <?php body_class('podcaster-theme'); ?>>
<?php elseif ( get_post_type() == "podcast" && is_single() ) : ?>      
    <body <?php body_class('podcast-archive podcaster-theme'); ?>>
<?php elseif( is_page_template('page/pagesidebarleft.php') ) : ?>
    <body <?php body_class('sidebar-left podcaster-theme'); ?>>
<?php else : ?>
    <body <?php body_class('podcaster-theme'); ?>>
<?php endif; ?>

<div class="super-container <?php echo $pod_social_color; ?>">
    <?php
        /*Loads the navigation.php template*/
        get_template_part( 'navigation' ); 
    ?>