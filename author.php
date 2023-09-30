<?php
/**
 * This file displays your author archive pages.
 *
 * @package Podcaster
 * @since 1.0
 */


$pod_sticky_header = pod_theme_option( 'pod-sticky-header', false );
$pod_avtr_athpg = pod_theme_option( 'pod-avatar-authorpages', true );

/* Check for sidebars */
$pod_is_sidebar_active = is_active_sidebar( 'sidebar_blog' ) ? "pod-is-sidebar-active" : "pod-is-sidebar-inactive";

get_header(); ?>

	<?php if ( isset( $pod_sticky_header ) && $pod_sticky_header == TRUE ) : ?>
	<div class="reg sticky">
	<?php else : ?>
	<div class="reg">
	<?php endif ; ?>
		<div class="static">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading">
							<div class="title">
								<div class="author_profile">
									<?php

										$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
										$author_id = $author->ID;

										$field ='description'; 
										$field2 ='display_name'; 

										$email = get_the_author_meta( 'contact_email', $author_id );
										$website = get_the_author_meta( 'user_website', $author_id );
										$twitter = get_the_author_meta( 'user_twitter', $author_id );
										$position = get_the_author_meta( 'user_position', $author_id );
										$google = get_the_author_meta( 'user_googleplus', $author_id );
										$facebook = get_the_author_meta( 'user_facebook', $author_id );
										$skype = get_the_author_meta( 'user_skype', $author_id );
										$youtube = get_the_author_meta( 'user_youtube', $author_id );
										$vimeo = get_the_author_meta( 'user_vimeo', $author_id );
										$dribbble = get_the_author_meta( 'user_dribbble', $author_id );
										$flickr = get_the_author_meta( 'user_flickr', $author_id );
										$instagram = get_the_author_meta( 'user_instagram', $author_id );
										$tumblr = get_the_author_meta( 'user_tumblr', $author_id );
										$twitch = get_the_author_meta( 'user_twitch', $author_id );
										$soundcloud = get_the_author_meta( 'user_soundcloud', $author_id );
										$pinterest = get_the_author_meta( 'user_pinterest', $author_id );
										$xing = get_the_author_meta( 'user_xing', $author_id );
										$linkedin = get_the_author_meta( 'user_linkedin', $author_id );
										$github = get_the_author_meta( 'user_github', $author_id );
										$stackex = get_the_author_meta( 'user_stackex', $author_id );
										$rss = get_the_author_meta( 'user_rss', $author_id );
										$snapchat = get_the_author_meta( 'user_snapchat', $author_id );
										$spotify = get_the_author_meta( 'user_spotify', $author_id );
										$mixcloud = get_the_author_meta( 'user_mixcloud', $author_id );
										$itunes = get_the_author_meta( 'user_itunes', $author_id );


										$tiktok = get_the_author_meta( 'user_tiktok', $author_id );
										$periscope = get_the_author_meta( 'user_periscope', $author_id );
										$telegram = get_the_author_meta( 'user_telegram', $author_id );
										$apple_podcasts = get_the_author_meta( 'user_apple_podcasts', $author_id );
										$stitcher = get_the_author_meta( 'user_stitcher', $author_id );
										$google_podcasts = get_the_author_meta( 'user_google_podcasts', $author_id );
										$medium = get_the_author_meta( 'user_medium', $author_id );
										$android = get_the_author_meta( 'user_android', $author_id );
										$patreon = get_the_author_meta( 'user_patreon', $author_id );
										$paypal = get_the_author_meta( 'user_paypal', $author_id );
										$foursquare = get_the_author_meta( 'user_foursquare', $author_id );
										$whatsapp = get_the_author_meta( 'user_whatsapp', $author_id );
										$weibo = get_the_author_meta( 'user_weibo', $author_id );


									?>

									<div class="author_info">
										<?php if( $pod_avtr_athpg == true ) : ?>
											<?php echo get_avatar( $author_id, apply_filters( 'themestation_author_bio_avatar_size', 100 ) ); ?>
										<?php endif; ?>

										<div class="info">
											<h2 class="author_name"><?php the_author_meta( $field2, $author_id ); ?></h2>
											<span class="author_position"><?php echo esc_html( $position ); ?></span>
										</div><!-- .info -->
									</div><!-- .author_info -->
										

									<ul class="social">
										<?php echo pod_get_social_media_user( $author_id ); ?>
									</ul>
									<p><?php the_author_meta( $field, $author_id ); ?></p>	
								</div><!-- .author_profile -->
							</div><!-- .title -->
						</div><!-- .heading -->
					</div><!-- .col -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .static -->
	</div><!-- .reg -->


	
	<div class="main-content archive-page archive-page-author <?php echo esc_attr( $pod_is_sidebar_active ); ?>">
        <div class="container">
           <div class="row">

				<div class="col-lg-8 col-md-8">

					<div class="entries-container arch_posts entries <?php echo pod_has_pagination( $wp_query->max_num_pages ); ?>">
						<?php 
						// Start the Loop.
						if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>	
							<?php
								/*This gets the template to display the posts.*/
								$format = get_post_format();
								get_template_part( 'post/format', $format );
							?>

						<?php endwhile; ?>
						<?php endif; wp_reset_query(); ?>
				
						<div class="pagination clearfix">
						<?php 
							global $wp_query;
							$big = 999999999;			
							echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $wp_query->max_num_pages,
							'prev_text'    => __('&laquo;','podcaster'),
							'next_text'    => __('&raquo;','podcaster')
							)); 			
						?>
						</div><!-- pagination -->

					</div><!-- entries-container -->	

				</div><!-- col-8 -->
				
				<?php if( is_active_sidebar( 'sidebar_blog' ) ) { ?>
				<div class="col-lg-4 col-md-4">
					<?php get_template_part( 'sidebar' ); ?> 
				</div><!-- col-4 -->
				<?php } ?>

			</div><!-- row -->	
		</div><!-- container -->
	</div><!-- main-content -->

 

<?php
/* This displays the footer with help of footer.php */
get_footer(); ?>