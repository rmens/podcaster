<?php
/**
 * This file is used to display your standard pages.
 *
 * @package Podcaster
 * @since 1.8.9
 *
 * Template Name: Gutenberg
 * Template Post Type: post, page, podcast
*/

get_header(); 


$pod_plugin_active = pod_get_plugin_active();
?>

 	
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();

/* Single player audio */
$pod_single_audio_player_position = pod_theme_option( 'pod-single-header-player-display', 'player-in-header' );
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


?>
	<?php if( get_post_type() == "page" ) { ?>
	<!-- Page Header -->
	<div class="reg <?php echo pod_is_nav_sticky(); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?>">
		<div class="static">

			<?php if( has_post_thumbnail() ) : ?>
				<div class="content_page_thumb">

					<?php echo pod_loading_spinner(); ?>
					<?php echo pod_header_parallax( $post->ID ); ?>

					<div class="screen">
			<?php endif; ?>

					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="heading">
									<div class="title" <?php if( $heading_align !='' ) ?> style="<?php echo esc_attr( $heading_align ); ?>">

										<h1><?php the_title(); ?></h1>
										<?php if( $subtitle_blurb !='') { ?>
											<p><?php echo esc_attr( $subtitle_blurb ); ?></p>
										<?php } ?>

									</div><!-- .title -->
								</div><!-- .heading -->
							</div><!-- .col -->
						</div><!-- .row -->
					</div><!-- .container -->
			<?php if( has_post_thumbnail() ) : ?>
				</div><!-- .screen -->
			</div><!-- .content_page_thumb -->
			<?php endif; ?>
		</div><!-- .static -->
	</div><!-- .reg -->

	<?php } elseif( get_post_type() == "post" || ( $pod_plugin_active == "ssp" && get_post_type() == "podcast" ) ) {

		if( $pod_plugin_active == "ssp" && get_post_type() == "podcast" ) {
			$format = pod_ssp_get_format( $post->ID );
		} ?>

		<?php if( get_post_format( $post->ID ) == "audio" ) { ?>
		
			<?php pod_single_header_audio( $post->ID ) ?>
		
		<?php } elseif( get_post_format( $post->ID ) == "video" ) { ?>
			
			<?php pod_single_header_video( $post->ID ) ?>

		<?php } elseif( get_post_format( $post->ID ) == "gallery" ) { ?>
			
			<?php pod_single_header_gallery( $post->ID ); ?>

		<?php } elseif( get_post_format( $post->ID ) == "image" ) { ?>
			
			<?php pod_single_header_image( $post->ID ); ?>

		<?php } ?>

		<?php echo pod_single_header_caption( $post->ID ); ?>

	<?php } ?>
	
	<div class="main-content <?php echo esc_attr( $pod_type_output ); ?> <?php echo esc_attr( $pod_is_sidebar_active ); ?> template-gutenberg <?php echo esc_attr( $page_padding_top_output ); ?> <?php echo esc_attr( $page_padding_bottom_output ); ?>">
        <div class="container">
            <div class="row">

				<div class="col-lg-12 col-md-12">
					<div class="entry-container content">

						

							<?php if( get_post_type() == "page" ) { ?>

								<div class="entry-content clearfix">
									<?php the_content(); ?>
								</div><!-- .entry-content -->

							<?php } elseif( get_post_type() == "post" || ( $pod_plugin_active == "ssp" && get_post_type() == "podcast" ) ) {

								$format = get_post_format( $post->ID );

								if( $pod_plugin_active == "ssp" && get_post_type() == "podcast" ) {
									$format = pod_ssp_get_format( $post->ID );
								} ?>

								<?php /*This gets the template to display the posts.*/
								get_template_part( 'post/format', $format );
								?>

								<?php pod_set_post_views( get_the_ID() ); ?>

							<?php } else { ?>

								<div class="entry-content clearfix">
									<?php the_content(); ?>
								</div><!-- entry-content -->

							<?php } ?>
						

						<?php 
							wp_link_pages(array(
						        'before' => '<div class="pagination clearfix">',
						        'after' => '</div>',
						        
						        'next_or_number' => 'next_and_number',
						        'nextpagelink' => __('Next', 'podcaster'),
						        'previouspagelink' => __('Previous', 'podcaster'),
						        'pagelink' => '%',
						        'echo' => 1 )
						    );
						 ?>	

						<?php if( is_page() ) : ?>
							<?php if( comments_open() || get_comments_number() ) : ?>
								<div class="comment_container">						
									<?php comments_template(); ?> 
								</div><!--comment_container-->
							<?php endif; ?>
						<?php endif; ?>

					</div><!--entry-container-->			
		        </div><!--col-12-->
				
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .main-content -->
    
<?php if( $pod_single_audio_player_position == "player-in-footer" ) { 
	$pod_use_sticky_player = pod_use_single_sticky_audio_player( $post->ID );
	if( $pod_use_sticky_player ) {
		echo pod_single_sticky_audio_player( $post->ID );
	}
	
} ?>	

<?php endwhile; else: ?>
<p><?php echo __('Sorry, no posts matched your criteria.', 'podcaster'); ?></p>
<?php endif; ?>


<?php get_footer(); ?>