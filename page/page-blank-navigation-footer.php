<?php
/**
 * This file is used to display your standard pages.
 *
 * @package Podcaster
 * @since 1.8.9
 *
 * Template Name: Blank Page with navigation & footer
 * Template Post Type: post, page, podcast
*/

get_header(); 


$pod_plugin_active = pod_get_plugin_active();
?>

 	
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
$page_padding_top = get_post_meta($post->ID, 'cmb_thst_page_padding_top', true);
$page_padding_top_output = $page_padding_top ? "page-padding-top-off" : "";
$page_padding_bottom = get_post_meta($post->ID, 'cmb_thst_page_padding_bottom', true);
$page_padding_bottom_output = $page_padding_bottom ? "page-padding-bottom-off" : "";

$pod_sticky_header = pod_theme_option('pod-sticky-header', false);

$pod_type = get_post_type();
if( $pod_type == "post" ) {
	$pod_type_output = "single";
} elseif( $pod_type == "page" ) {
	$pod_type_output = "page";
}

/* Check for sidebars */
$pod_is_sidebar_active = is_active_sidebar( 'sidebar_page' ) ? "pod-is-sidebar-active" : "pod-is-sidebar-inactive";

pod_set_post_views( get_the_ID() ); ?>

<div class="main-content template-blank-page <?php echo esc_attr( $pod_type_output ); ?> <?php echo esc_attr( $pod_is_sidebar_active ); ?> template-gutenberg <?php echo esc_attr( $page_padding_top_output ); ?> <?php echo esc_attr( $page_padding_bottom_output ); ?>">
        <div class="container">
            <div class="row">

				<div class="col-lg-12 col-md-12">
					<div class="entry-container content">
						<div class="entry-content clearfix">
							<?php the_content(); ?>
						</div>
								
						<?php wp_link_pages(array(
						    'before' => '<div class="pagination clearfix">',
						    'after' => '</div>',
						    
						    'next_or_number' => 'next_and_number',
						    'nextpagelink' => __('Next', 'podcaster'),
						    'previouspagelink' => __('Previous', 'podcaster'),
						    'pagelink' => '%',
						    'echo' => 1 )
						);

						 if( is_page() ) : ?>
							<?php if( comments_open() || get_comments_number() ) : ?>
								<div class="comment_container">						
									<?php comments_template(); ?> 
								</div><!--comment_container-->
							<?php endif; ?>
						<?php endif; ?>


	
<?php endwhile; else: ?>
<p><?php echo __('Sorry, no posts matched your criteria.', 'podcaster'); ?></p>
<?php endif; ?>
</div>
</div>
</div>
</div>
</div>

<?php get_footer(); ?>