<?php

/**
 * This file is used to display your podcast archive.
 * @package Podcaster
 * @since 1.0
 */

/*
Template Name: Podcast Archive
*/

get_header(); 

/* Theme Option Values */
$arch_category = pod_theme_option( 'pod-recordings-category', 1 );
$arch_num_posts = pod_theme_option( 'pod-recordings-amount', 9 );
$arch_icon_style = pod_theme_option( 'pod-archive-icons', 'audio_icons' );
$arch_list_style = pod_theme_option( 'pod-list-style', 'grid' );
$pod_sticky_header = pod_theme_option( 'pod-sticky-header', false );
$album_art_rounded = pod_theme_option( "pod-audio-art-rounded-corners", 'fh-audio-art-no-radius' );
$arch_button_text = pod_theme_option( 'pod-archive-button-text', 'Listen' );
$pl_active = pod_get_plugin_active();

/* Titles */
$pod_truncate_title = pod_theme_option('pod-archive-trunc', false);
if( $pod_truncate_title == true ) { $is_truncate = " truncate"; } else { $is_truncate = " not-truncate"; }

if( $pl_active == 'ssp' ) {
	$arch_ssp_series = pod_theme_option("pod-recordings-category-ssp");
	$ssp_podcast_post_types = ssp_post_types();
	if ( $arch_num_posts >= 1 ) {
		$args = array( 
			'post_type' => $ssp_podcast_post_types, 
			'posts_per_page' => $arch_num_posts, 
			'paged' => get_query_var( 'paged' ), 
			'ignore_sticky_posts' => true,
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => array( $arch_category ),
				),
				array(
					'taxonomy' => 'series',
					'field'    => 'term_id',
					'terms'    => array( $arch_ssp_series ),
				),
				),
			);		
	} else {
		$args = array( 
			'post_type' => $ssp_podcast_post_types, 
			'posts_per_page' => -1, 
			'paged' => get_query_var( 'paged' ), 
			'ignore_sticky_posts' => true,
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => array( $arch_category ),
				),
				array(
					'taxonomy' => 'series',
					'field'    => 'term_id',
					'terms'    => array( $arch_ssp_series  ),
				),
				),
			);	
	}
} else {
	if ( isset( $arch_category ) &&  $arch_num_posts >= 1 ) {
		$args = array(
			'cat' => $arch_category, 
			'posts_per_page' => $arch_num_posts, 
			'paged' => get_query_var( 'paged' ),
		);
	} elseif ( isset( $arch_category ) &&  $arch_num_posts == 0 ) {
		$args = array(
			'cat' => $arch_category, 
			'posts_per_page' => -1, 
			'paged' => get_query_var( 'paged' ),
		);
	} else {
		$args = array( 
			'cat' => 1, 
			'posts_per_page' => -1, 
			'paged' => get_query_var( 'paged' ) 
		);
	}
} 

$category_posts = new WP_Query($args);

if($category_posts->have_posts()) : ?>

<?php
$attachment_id = get_post_thumbnail_id( $post->ID );
$image_attributes = wp_get_attachment_image_src( $attachment_id, 'original' ); // returns an array
$thumb_back = !empty( $image_attributes ) ? $image_attributes[0] : '';

//Header Settings
$subtitle_blurb = get_post_meta($post->ID, 'cmb_thst_page_subtitle', true);
$bg_style = get_post_meta($post->ID, 'cmb_thst_page_header_bg_style', true);
$bg_parallax = get_post_meta($post->ID, 'cmb_thst_page_header_parallax', true);
$heading_align = get_post_meta($post->ID, 'cmb_thst_page_header_align', true);


?>	

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
								<div class="title" <?php if($heading_align !='' ) { ?> style="<?php echo esc_attr( $heading_align ); ?>"<?php } ?>>
									<h1><?php the_title(); ?></h1>
									<?php if( $subtitle_blurb !='') { ?>
									<p><?php echo esc_html( $subtitle_blurb ); ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php if( has_post_thumbnail() ) : ?>
			</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
		
    <div class="main-content page template-podcast-archive template-podcast-archive-legacy">
        <div class="container">
           <div class="row">
					<div class="col-lg-12">
						<?php if ( $arch_list_style == 'list') : ?>
						<div class="entries-container entries list">
							<?php while($category_posts->have_posts()) : $category_posts->the_post(); ?>
								<article class="podpost">
									<div class="entry-content">
										<header class="post-header">
											<div class="cover-art">
												<?php if( has_post_thumbnail() ) : ?>
													<?php
														$img = wp_get_attachment_image_src( get_post_thumbnail_id() );
														the_post_thumbnail( 'square' , array( 'class' => 'podcast_image' , 'alt' => get_the_title() , 'title' => get_the_title() ) ); ?>
												<?php else : ?> 
													<img src="<?php echo get_template_directory_uri() . '/img/placeholder-square.png' ?>" />
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
						<div class="entries-container entries grid">
							<div class="row">
								<div class="grid-sizer"></div>
								<div class="gutter-sizer"></div>
								
								<?php while($category_posts->have_posts()) : $category_posts->the_post(); ?>
								<article class="podpost col-lg-2 col-md-3 col-sm-4 col-xs-6">
									<div class="entry-content">
										<header class="post-header">
											<div class="cover-art">
												<?php if( has_post_thumbnail() ) : ?>
													<?php
														$img = wp_get_attachment_image_src( get_post_thumbnail_id() );
														the_post_thumbnail( 'audio-thumb-2' , array( 'class' => 'podcast_image' , 'alt' => get_the_title() , 'title' => get_the_title() ) ); ?>
														<div class="hover-content">
															<?php if( $arch_icon_style == "audio_icons") { ?>
																<a href="<?php the_permalink(); ?>" class="pp-permalink-icon"><span class="fas fa-microphone-alt"></span></a>
																<?php } else { ?>
																<a href="<?php the_permalink(); ?>" class="pp-permalink-icon"><span class="fa fa-play"></span></a>
																<?php } ?>
														</div>
												<?php else : ?> 
												<img src="<?php echo get_template_directory_uri() . '/img/placeholder.png' ?>" />
												<div class="hover-content no-image">
															<?php if( $arch_icon_style == "audio_icons") { ?>
																<a href="<?php the_permalink(); ?>" class="pp-permalink-icon"><span class="fas fa-microphone-alt"></span></a>
																<?php } else { ?>
																<a href="<?php the_permalink(); ?>" class="pp-permalink-icon"><span class="fa fa-play"></span></a>
																<?php } ?>
														</div>
												<?php endif; ?>
											</div>
										</header>
										<?php the_excerpt(); ?>
										<footer class="entry-footer">
											<ul class="podpost-meta">
												<li><h4 class="title<?php echo esc_attr( $is_truncate ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4></li>

												<?php if( $pl_active == "ssp" ) { ?>
													<li class="categories"><?php echo pod_get_ssp_series_cats($post->ID, '', '', ',&nbsp;', true); ?></li>
												<?php } else { ?>
													<li class="categories"><?php the_category(', '); ?></li>
												<?php } ?>
												
											</ul>
										
										</footer>
									</div><!--entry-content-->
								</article>
							<?php endwhile; ?>
							</div><!--row-->
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
	<?php else: ?>
		<p><?php echo __('Sorry, no posts matched your criteria.', 'podcaster'); ?></p>
	<?php endif; ?>
<?php get_footer(); ?>