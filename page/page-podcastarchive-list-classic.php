<?php

/**
 * This file is used to display your podcast archive.
 * @package Podcaster
 * @since 1.0
 */

/*
Template Name: Podcast Archive - List (Classic)
*/

get_header(); 

if ( have_posts() ) : while ( have_posts() ) : the_post(); 

/* Theme Option Values */
$arch_category = pod_theme_option( 'pod-recordings-category', 1 );
$arch_num_posts = pod_theme_option( 'pod-recordings-amount', 9 );
$arch_icon_style = pod_theme_option( 'pod-archive-icons', 'audio_icons' );
$arch_list_style = pod_theme_option( 'pod-list-style', 'grid' );
$pod_sticky_header = pod_theme_option( 'pod-sticky-header', false );
$album_art_rounded = pod_theme_option( "pod-audio-art-rounded-corners", 'fh-audio-art-no-radius' );
$arch_button_text = pod_theme_option( 'pod-archive-button-text', 'Listen' );
$pl_active = pod_get_plugin_active();

/* Header Settings */
$pod_podcast_cat = get_post_meta( $post->ID, 'cmb_thst_podcast_cat', true );
$pod_podcast_amount = get_post_meta( $post->ID, 'cmb_thst_podcast_amount', true );
$pod_podcast_order = get_post_meta( $post->ID, 'cmb_thst_podcast_order', true );

/* Subscribe Buttons */
$pod_podcast_button_text_1 = get_post_meta( $post->ID, 'cmb_thst_podcast_button_text_1', true );
$pod_podcast_button_url_1 = get_post_meta( $post->ID, 'cmb_thst_podcast_button_url_1', true );

$pod_podcast_button_text_2 = get_post_meta( $post->ID, 'cmb_thst_podcast_button_text_2', true );
$pod_podcast_button_url_2 = get_post_meta( $post->ID, 'cmb_thst_podcast_button_url_2', true );

$pod_podcast_button_text_3 = get_post_meta( $post->ID, 'cmb_thst_podcast_button_text_3', true );
$pod_podcast_button_url_3 = get_post_meta( $post->ID, 'cmb_thst_podcast_button_url_3', true );

/* Titles */
$pod_truncate_title = pod_theme_option( 'pod-archive-trunc', true );
$is_truncate = $pod_truncate_title ? " truncate" : " not-truncate";


/* Category Arch */
$args = array( 
	'posts_per_page' => $pod_podcast_amount, 
	'order' => $pod_podcast_order,
	'paged' => get_query_var( 'paged' ), 
	'ignore_sticky_posts' => true,
	'tax_query' => array(
		'relation' => 'OR',
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => array( $pod_podcast_cat ),
		),
		array(
			'taxonomy' => 'series',
			'field'    => 'term_id',
			'terms'    => array( $pod_podcast_cat ),
		),
	),
);

$category_posts = new WP_Query($args); ?>

<?php
$attachment_id = get_post_thumbnail_id( $post->ID );
$image_attributes = wp_get_attachment_image_src( $attachment_id, 'square-large' ); // returns an array
$thumb_back = !empty( $image_attributes ) ? $image_attributes[0] : '';

//Header Settings
$subtitle_blurb = get_post_meta($post->ID, 'cmb_thst_page_subtitle', true);
$bg_style = get_post_meta($post->ID, 'cmb_thst_page_header_bg_style', true);
$bg_parallax = get_post_meta($post->ID, 'cmb_thst_page_header_parallax', true);
$heading_align = get_post_meta($post->ID, 'cmb_thst_page_header_align', true);
$heading_align_out = 'page-header-align-left';

if( $heading_align == "text-align:left;" ) {
	$heading_align_out = 'page-header-align-left';
} elseif( $heading_align == "text-align:center;" ) {
	$heading_align_out = 'page-header-align-center';
} elseif( $heading_align == "text-align:right;" ) {
	$heading_align_out = 'page-header-align-right';
}
$pod_archive_img_use = get_post_meta($post->ID, 'cmb_thst_podcast_image_use', true);
$pod_archive_img_use = ($pod_archive_img_use == "") ? 'pod-archive-img-thumbnail' : $pod_archive_img_use;

?>	

	<div class="reg pod-2-podcast-archive-header <?php echo esc_attr( $album_art_rounded ); ?> <?php echo esc_attr( $heading_align_out ); ?> <?php echo esc_attr( $pod_archive_img_use ); ?> <?php echo pod_is_nav_sticky(); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?>">
		<div class="static">

			<?php if( has_post_thumbnail() && $pod_archive_img_use == 'pod-archive-img-background' ) : ?>
				<div class="content_page_thumb">

					<?php echo pod_loading_spinner(); ?>
					<?php echo pod_header_parallax( $post->ID ); ?>

					<div class="screen">
			<?php endif; ?>

			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading">
							
							<?php if(has_post_thumbnail() && $pod_archive_img_use == 'pod-archive-img-thumbnail' ){ ?>
							<div class="archive-art">
								<img src="<?php echo esc_url( $thumb_back ); ?>" alt="<?php the_title(); ?>" />
							</div>
							<?php } ?>

							<div class="title" <?php if( $heading_align !='' ) { ?> style="<?php echo esc_attr( $heading_align ); ?>"<?php } ?>>
								<h1><?php the_title(); ?></h1>
								<?php if( $subtitle_blurb !='') { ?>
								<p><?php echo esc_html( $subtitle_blurb ); ?></p>
								<?php } ?>
								<?php if( $pod_podcast_button_text_1 != '' || $pod_podcast_button_text_2 != '' || $pod_podcast_button_text_3 != '' ) { ?>
								<div class="subscribe-buttons">
									<?php if( $pod_podcast_button_text_1 != '' ) { ?><a class="butn extrasmall" href="<?php echo esc_url( $pod_podcast_button_url_1 ); ?>"><?php echo esc_html( $pod_podcast_button_text_1 ); ?></a><?php } ?>
									<?php if( $pod_podcast_button_text_2 != '' ) { ?><a class="butn extrasmall" href="<?php echo esc_url( $pod_podcast_button_url_2 ); ?>"><?php echo esc_html( $pod_podcast_button_text_2 ); ?></a><?php } ?>
									<?php if( $pod_podcast_button_text_3 != '' ) { ?><a class="butn extrasmall" href="<?php echo esc_url( $pod_podcast_button_url_3 ); ?>"><?php echo esc_html( $pod_podcast_button_text_3 ); ?></a><?php } ?>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php if( has_post_thumbnail() && $pod_archive_img_use == 'pod-archive-img-background' ) : ?>
				</div><!-- .screen -->
			</div><!-- .content_page_thumb -->
			<?php endif; ?>

		</div>
	</div>
		
    <div class="main-content page template-podcast-archive template-podcast-archive-legacy">
        <div class="container">
           <div class="row">
				<div class="col-lg-12">

					<?php if( $post->post_content !== '' ) { ?>
					<div class="archive-the-content">
						<?php the_content(); ?>
						<div class="clear"></div>
					</div>
					<?php } ?>

					<div class="entries-container entries list">
					<?php if($category_posts->have_posts()) : while($category_posts->have_posts()) : $category_posts->the_post(); ?>
						<article class="podpost">
							<div class="entry-content">
								<header class="post-header">
									<div class="cover-art">
										<?php if( has_post_thumbnail() ) : ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<?php
												$img = wp_get_attachment_image_src( get_post_thumbnail_id() );
												the_post_thumbnail( 'square' , array( 'class' => 'podcast_image' , 'alt' => get_the_title() , 'title' => get_the_title() ) ); ?>
											</a>
										<?php else : ?> 
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri() . '/img/placeholder-square.png' ?>" /></a>
										<?php endif; ?>
									</div>
									
								</header>
								<footer class="entry-footer">
									<ul class="podpost-meta clearfix">
										<li class="title<?php echo esc_attr( $is_truncate ) ;?>"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>

										<?php if( $pl_active == "ssp" ) { ?>
											<li class="categories"><?php echo pod_get_ssp_series_cats($post->ID, '', '', ',&nbsp;', true); ?></li>
										<?php } else { ?>
											<li class="categories"><?php the_category(', '); ?></li>
										<?php } ?>

										<li class="listen"><a class="butn extrasmall" href="<?php the_permalink(); ?>"><?php echo esc_attr( $arch_button_text ); ?></a></li>
									</ul>
								
								</footer>
							</div><!--entry-content-->
						</article>
					<?php endwhile; ?>

					<?php else : ?>

						<div class="entries-container entries list clearfix">
							<p><?php echo __('Sorry, no posts matched your criteria.', 'podcaster'); ?></p>

					<?php endif; ?>


						
						<div class="pagination clearfix">
							<?php 
							global $category_posts;
							$big = 999999999; // need an unlikely integer
							
							echo paginate_links(array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $category_posts->max_num_pages,
								'prev_text'    => __('&laquo;','podcaster'),
								'next_text'    => __('&raquo;','podcaster')
							)); ?> 
						</div><!--pagination-->


					</div><!--entries-->				
				</div><!--col-lg-12-->
            </div>
        </div>
	</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>