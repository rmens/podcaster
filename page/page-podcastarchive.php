<?php

/**
 * This file is used to display your podcast archive.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*
Template Name: Podcast Archive
*/

get_header(); 

$options = get_option('podcaster-theme');  
$arch_category = isset( $options['pod-recordings-category'] ) ? $options['pod-recordings-category'] : '';
$arch_num_posts = isset( $options['pod-recordings-amount'] ) ? $options['pod-recordings-amount'] : '';
$arch_icon_style = isset( $options["pod-archive-icons"] ) ? $options["pod-archive-icons"] : '';
$arch_list_style = isset( $options["pod-list-style"] ) ? $options["pod-list-style"] : '';
$pod_sticky_header = isset( $options['pod-sticky-header'] ) ? $options['pod-sticky-header'] : '';
$pl_active = get_pod_plugin_active();

if( $pl_active == 'ssp' ) {
	if ( $arch_num_posts >= 1 ) {
		$args = array( 'post_type' => 'podcast', 'posts_per_page' => $arch_num_posts, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );	
	} else {
		$args = array( 'post_type' => 'podcast', 'posts_per_page' => -1, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );	
	}
} else {
	if ( isset( $arch_category ) &&  $arch_num_posts >= 1 ) {
		$args = array('cat' => $arch_category, 'posts_per_page' => $arch_num_posts, 'paged' => get_query_var( 'paged' ),);
	} elseif ( isset( $arch_category ) &&  $arch_num_posts == 0 ) {
		$args = array('cat' => $arch_category, 'posts_per_page' => -1, 'paged' => get_query_var( 'paged' ),);
	} else {
		$args = array( 'cat' => 1, 'posts_per_page' => -1, 'paged' => get_query_var( 'paged' ) );
	}
 } 

$category_posts = new WP_Query($args);

if($category_posts->have_posts()) : ?>

<?php
$attachment_id = get_post_thumbnail_id( $post->ID );
$image_attributes = wp_get_attachment_image_src( $attachment_id, 'original' ); // returns an array
$thumb_back = $image_attributes[0];

//Header Settings
$subtitle_blurb = get_post_meta($post->ID, 'cmb_thst_page_subtitle', true);
$bg_style = get_post_meta($post->ID, 'cmb_thst_page_header_bg_style', true);
$bg_parallax = get_post_meta($post->ID, 'cmb_thst_page_header_parallax', true);
$heading_align = get_post_meta($post->ID, 'cmb_thst_page_header_align', true);


?>	

	<div class="reg <?php echo pod_is_nav_sticky(); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?>">
		<div class="static">
			<?php if( has_post_thumbnail() ) : ?>
				<?php if( $bg_parallax == 'on' ) : ?>
					<div class="content_page_thumb" style="background-image: url('<?php echo $thumb_back ?>'); <?php echo $bg_style ?>" data-stellar-background-ratio="0.25">
				<?php else : ?>
					<div class="content_page_thumb" style="background-image: url('<?php echo $thumb_back ?>'); <?php echo $bg_style ?>">
				<?php endif; ?>
			<div id="loading_bg"></div>
			<div class="screen">
			<?php endif; ?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="heading">
								<div class="title" <?php if($heading_align !='' ) { ?> style="<?php echo $heading_align ?>"<?php } ?>>
									<h1><?php the_title(); ?></h1>
									<?php if( $subtitle_blurb !='') { ?>
									<p><?php echo $subtitle_blurb ?></p>
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
		
    <div class="main-content page archive-page">
        <div class="container">
           <div class="row">
					<div class="col-lg-12">
						<?php if ( $arch_list_style == 'list') : ?>
						<div class="entries list clearfix">
							<?php while($category_posts->have_posts()) : $category_posts->the_post(); ?>
								<article class="podpost">
									<div class="entry-content clearfix">
										<header class="post-header clearfix">
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
										<?php the_excerpt(); ?>
										<footer class="entry-footer">
											<ul class="podpost-meta clearfix">
												<li class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
												<li class="categories"> <?php the_category(', '); ?></li>
												<li class="listen"><a class="butn extrasmall" href="<?php the_permalink(); ?>"><?php echo __( 'Listen', 'thstlang' ); ?></a></li>
											</ul>
										
										</footer>
									</div><!--entry-content-->
								</article>
							<?php endwhile; ?>
						<?php else : ?>
						<div class="entries grid clearfix">
							<div class="row">
								<?php while($category_posts->have_posts()) : $category_posts->the_post(); ?>
								<article class="podpost col-lg-2 col-md-3 col-sm-4 col-xs-6">
									<div class="entry-content">
										<header class="post-header clearfix">
											<div class="cover-art">
												<?php if( has_post_thumbnail() ) : ?>
													<?php
														$img = wp_get_attachment_image_src( get_post_thumbnail_id() );
														the_post_thumbnail( 'audio-thumb-2' , array( 'class' => 'podcast_image' , 'alt' => get_the_title() , 'title' => get_the_title() ) ); ?>
														<div class="hover-content">
															<?php if( $arch_icon_style == "audio_icons") { ?>
																<a href="<?php the_permalink(); ?>" class="pp-permalink-icon batch" data-icon="&#xF073;"></a>
																<?php } else { ?>
																<a href="<?php the_permalink(); ?>" class="pp-permalink-icon batch" data-icon="&#xF16B;"></a>
																<?php } ?>
														</div>
												<?php else : ?> 
												<img src="<?php echo get_template_directory_uri() . '/img/placeholder.png' ?>" />
												<div class="hover-content no-image">
															<?php if( $arch_icon_style == "audio_icons") { ?>
																<a href="<?php the_permalink(); ?>" class="pp-permalink-icon batch" data-icon="&#xF073;"></a>
																<?php } else { ?>
																<a href="<?php the_permalink(); ?>" class="pp-permalink-icon batch" data-icon="&#xF16B;"></a>
																<?php } ?>
														</div>
												<?php endif; ?>
											</div>
											
										</header>
										<?php the_excerpt(); ?>
										<footer class="entry-footer">
											<ul class="podpost-meta">
												<li class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
												<li class="categories"> <?php the_category(', '); ?></li>
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
									'prev_text'    => __('&laquo;','thstlang'),
									'next_text'    => __('&raquo;','thstlang')
								)); ?> 
							</div><!--pagination-->
						</div><!--entries-->				
					</div><!--col-lg-12-->
            </div>
        </div>
	</div>
	<?php else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
<?php get_footer(); ?>