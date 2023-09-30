<?php
/**
 * This file is used for your gallery post format.
 * @package Podcaster
 * @since 1.0
 */

$galleryimgs = get_post_meta( $post->ID, 'cmb_thst_gallery_list', true );
$gallerycapt = get_post_meta($post->ID, 'cmb_thst_gallery_capt', true);
$gallerycol = get_post_meta($post->ID, 'cmb_thst_gallery_col', true);

/* Grid to Slideshow */
$gallerystyle_global = pod_theme_option('pod-pofo-gallery', 'slideshow_on');

$gallerystyle = get_post_meta( $post->ID, 'cmb_thst_post_gallery_style', true );
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php get_template_part('post/postheader'); ?>

		<?php if ( ! is_single() && ! is_sticky() && $galleryimgs != ''  ) : ?>
			<div class="featured-gallery featured-media">
				<?php if ( $gallerystyle == "slideshow" ) : ?>
					<div class="gallery flexslider loading_post">
						<?php echo pod_loading_spinner(); ?>
						<ul class="slides">
							<?php foreach ($galleryimgs as $galleryimgsKey => $galleryimg) {
									$imgid = $galleryimgsKey;
					    			echo '<li>';
					    			echo '<a href="' . $galleryimg . '" data-lightbox="lightbox-' . $post->ID . '">';
					    			echo wp_get_attachment_image( $imgid, 'regular-large' );
					    			echo '</a>';
					    			echo '</li>';
								}
							?>
						</ul><!-- .slides -->
					</div><!-- .gallery -->
				<?php else : ?>
				<div class="gallery grid clearfix <?php echo  esc_attr( $gallerycol ); ?> ">
					<?php foreach ( $galleryimgs as $galleryimgsKey => $galleryimg ) {
							$imgid = $galleryimgsKey;
			    			echo '<div class="gallery-item">';
			    			echo '<a href="' . $galleryimg . '" data-lightbox="lightbox">';
			    			echo wp_get_attachment_image( $imgid, 'square' );
			    			echo '</a>';
			    			echo '</div>';
						}
					?>
					</div>
					
				<?php endif ; ?><!-- end checking whether the gallery is being displayed as grid or slideshow -->

				<?php if( $gallerycapt != '' ) {
					echo '<div class="gallery-caption">' . $gallerycapt . '</div>';
				} ?>
			</div><!-- .featured-media -->
		<?php endif; ?>

		<?php if ( is_archive() || is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
		<?php if( is_single() ) { ?>
			<?php the_content(); ?>
		<?php } else { ?>
			<?php echo pod_the_blog_content(); ?>
		<?php } ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<?php if ( ! is_sticky() ) : ?>
			<?php get_template_part('post/postfooter'); ?>
		<?php endif; ?>
	</article><!-- #post -->