<?php
/**
 * Index.php is the default template. This file is used when a more specific template can not be found to display your posts. It is also used for your blog.
 * 
 * @package Podcaster
 * @since 1.0
 */

get_header();

$podrec_category = pod_theme_option( 'pod-recordings-category', '' );
$podrec_category = ( $podrec_category != '' ) ? (int) $podrec_category : '';

$pod_hide_posts = pod_theme_option( 'pod-archive-hide-in-blog', true );
$pod_blog_header = pod_theme_option( 'pod-blog-header' );
$pod_blog_header_img = isset( $pod_blog_header['url'] ) ? $pod_blog_header['url'] : '';
$pod_blog_header_title = pod_theme_option( 'pod-blog-header-title' );
$pod_blog_header_blurb = pod_theme_option( 'pod-blog-header-blurb' );
$pod_blog_bg_style = pod_theme_option( 'pod-blog-bg-style', 'background-repeat:repeat;' );
$pod_blog_header_par = pod_theme_option( 'pod-blog-header-par', false );
$pod_blog_layout = pod_theme_option( 'pod-blog-layout', 'sidebar-right' );

/* Check for sidebars */
$pod_is_sidebar_active = is_active_sidebar( 'sidebar_blog' ) ? "pod-is-sidebar-active" : "pod-is-sidebar-inactive";

/* Check if has header */
$have_header = ( $pod_blog_header_img == '' && ( $pod_blog_header_title == '' || $pod_blog_header_blurb == '' ) ) ?  'no-header' : '';

?>
	<?php if( is_home() && $pod_blog_header_img != '' || $pod_blog_header_title != '' || $pod_blog_header_blurb != '' ) : ?>
	<div class="reg <?php echo pod_is_nav_sticky(); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?>">
		<div class="static">

		<?php if ( $pod_blog_header_img != '') : ?>
			<div class="content_page_thumb">

			<?php echo pod_loading_spinner(); ?>
			<?php echo pod_header_parallax( $post->ID ); ?>

			<div class="screen">
		<?php endif; ?>


		
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="heading">
							
								<div class="title">
									<h1><?php echo esc_html( $pod_blog_header_title ); ?></h1>
									<?php if( $pod_blog_header_blurb !='' ) { ?><p><?php echo esc_html( $pod_blog_header_blurb ); ?></p><?php } ?>
								</div><!-- title -->
							
							</div><!-- heading -->
						</div><!-- col-12 -->
					</div><!-- row -->
				</div><!-- container -->
			<?php if ($pod_blog_header_img !='') : ?>
			</div><!-- transparent -->
			</div><!--  content_page_thumb -->
			<?php endif; ?>
		</div><!--  static -->
	</div><!-- reg -->
	<?php endif; ?>
	<div class="main-content blog <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?> <?php echo esc_attr( $pod_is_sidebar_active ); ?>">

		<div class="container">
			<div class="row">
				<?php if ( $pod_blog_layout == 'sidebar-right' ) : /* If sidebar is being displayed on the right. */ ?>
				<div class="col-lg-8 col-md-8">
					<div class="entries-container entries">
						<?php if( $pod_hide_posts == FALSE ) : ?> 
						<?php 
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
							$args = array( 'post_type' => 'post', 'cat' => -$podrec_category, 'paged' => $paged, );
							$excat_posts = new WP_Query($args); 
						?>

							<?php  if( $excat_posts->have_posts() ) : while( $excat_posts->have_posts() ) : $excat_posts->the_post(); 
										if ( is_sticky() ) { ?>
											<article id="post-<?php the_ID(); ?>" <?php post_class('sticky_post post clearfix'); ?>>
												<?php get_template_part('post/postheader'); ?>
											</article>
										<?php } else {

								        /*This gets the template to display the posts.*/
										$format = get_post_format();
										get_template_part( 'post/format', $format );
										}
										endwhile;	
										wp_reset_query(); 
								    endif;
								    ?>
							<div class="pagination clearfix">
									<?php 
										$big = 999999999; // need an unlikely integer

										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $excat_posts->max_num_pages
										
										)); ?> 
								</div><!-- pagination -->
						<?php else : ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
										if ( is_sticky() ) { ?>
											<article id="post-<?php the_ID(); ?>" <?php post_class('sticky_post post'); ?>>
												<?php get_template_part('post/postheader'); ?>
											</article>
										<?php } else {

								        /*This gets the template to display the posts.*/
										$format = get_post_format();
										get_template_part( 'post/format', $format );
										}
										endwhile;	
										wp_reset_query(); 
								    endif;
								    ?>
								
							    <div class="pagination clearfix">
									<?php 
										$big = 999999999; // need an unlikely integer

										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $wp_query->max_num_pages,
										
										)); 
									?> 
								</div><!-- pagination -->
								<?php endif; ?>
							</div><!-- col-8 -->
					</div><!-- entries -->					
					
					<?php if ( is_active_sidebar( 'sidebar_blog' ) ) { ?>	
						<div class="col-lg-4 col-md-4">
							<?php
							//This displays the sidebar with help of sidebar.php
							get_template_part('sidebar'); ?>
						</div><!-- col-4 -->
					<?php } ?>


				<?php elseif( $pod_blog_layout == 'sidebar-left' ) : /* If sidebar is being displayed on the left. */ ?>
					<div class="col-lg-8 col-md-8 pulls-right">
						<div class="entries">
							<?php if( $pod_hide_posts == FALSE ) : ?> 
							<?php 
								$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
								$args = array( 'post_type' => 'post', 'cat' => -$podrec_category, 'paged' => $paged, );
								$excat_posts = new WP_Query($args); 
							?>

								<?php  if( $excat_posts->have_posts() ) : while( $excat_posts->have_posts() ) : $excat_posts->the_post(); 
											if ( is_sticky() ) { ?>
												<article id="post-<?php the_ID(); ?>" <?php post_class('sticky_post post clearfix'); ?>>
													<?php get_template_part('post/postheader'); ?>
												</article>
											<?php } else {

									        /*This gets the template to display the posts.*/
											$format = get_post_format();
											get_template_part( 'post/format', $format );
											}
											endwhile;	
											wp_reset_query(); 
									    endif;
									    ?>
								<div class="pagination clearfix">
										<?php 
											$big = 999999999; // need an unlikely integer

											echo paginate_links( array(
												'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
												'format' => '?paged=%#%',
												'current' => max( 1, get_query_var('paged') ),
												'total' => $excat_posts->max_num_pages
											
											)); ?> 
									</div><!-- pagination -->
							<?php else : ?>
							<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
											if ( is_sticky() ) { ?>
												<article id="post-<?php the_ID(); ?>" <?php post_class('sticky_post post'); ?>>
													<?php get_template_part('post/postheader'); ?>
												</article>
											<?php } else {

									        /*This gets the template to display the posts.*/
											$format = get_post_format();
											get_template_part( 'post/format', $format );
											}
											endwhile;	
											wp_reset_query(); 
									    endif;
									    ?>
									
								    <div class="pagination clearfix">
										<?php 
											$big = 999999999; // need an unlikely integer

											echo paginate_links( array(
												'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
												'format' => '?paged=%#%',
												'current' => max( 1, get_query_var('paged') ),
												'total' => $wp_query->max_num_pages,
											
											)); 
										?> 
									</div><!-- pagination -->
									<?php endif; ?>
						</div><!--  entries -->
					</div><!-- col-8 -->

					<?php if ( is_active_sidebar( 'sidebar_blog' ) ) { ?>	
						<div class="col-lg-4 col-md-4 pulls-left">
							<?php
							//This displays the sidebar with help of sidebar.php
							get_template_part('sidebar'); ?>
						</div><!-- col-4 -->
					<?php } ?>


				<?php elseif( $pod_blog_layout == 'no-sidebar' ) : /* If no sidebar is being displayed. */ ?>
					<div class="col-lg-12 col-md-12">
					<div class="entries">
						<?php if( $pod_hide_posts == FALSE ) : ?> 
						<?php 
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
							$args = array( 'post_type' => 'post', 'cat' => -$podrec_category, 'paged' => $paged, );
							$excat_posts = new WP_Query($args); 
						?>

							<?php  if( $excat_posts->have_posts() ) : while( $excat_posts->have_posts() ) : $excat_posts->the_post(); 
										if ( is_sticky() ) { ?>
											<article id="post-<?php the_ID(); ?>" <?php post_class('sticky_post post clearfix'); ?>>
												<?php get_template_part('post/postheader'); ?>
											</article>
										<?php } else {

								        /*This gets the template to display the posts.*/
										$format = get_post_format();
										get_template_part( 'post/format', $format );
										}
										endwhile;	
										wp_reset_query(); 
								    endif;
								    ?>
							<div class="pagination clearfix">
									<?php 
										$big = 999999999; // need an unlikely integer

										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $excat_posts->max_num_pages
										
										)); ?> 
								</div><!-- pagination -->
						<?php else : ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
										if ( is_sticky() ) { ?>
											<article id="post-<?php the_ID(); ?>" <?php post_class('sticky_post post'); ?>>
												<?php get_template_part('post/postheader'); ?>
											</article>
										<?php } else {

								        /*This gets the template to display the posts.*/
										$format = get_post_format();
										get_template_part( 'post/format', $format );
										}
										endwhile;	
										wp_reset_query(); 
								    endif;
								    ?>
								
							    <div class="pagination clearfix">
									<?php 
										$big = 999999999; // need an unlikely integer

										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $wp_query->max_num_pages,
										
										)); 
									?> 
								</div><!-- pagination -->
								<?php endif; ?>
							</div><!-- col-8 -->
					</div><!-- entries -->	
				<?php else : ?>
					<div class="col-lg-8 col-md-8">
					<div class="entries">

						<?php if( $pod_hide_posts != true ) : ?> 
						<?php 
							$query_var_paged = get_query_var( 'paged' );
							$paged = ! empty( $query_var_paged ) ? $query_var_paged : 1;
							$args = array( 
								'post_type' => 'post', 
								'cat' => -$podrec_category, 
								'paged' => $paged
							);
							$excat_posts = new WP_Query($args); 
						?>
						
							<?php  if( $excat_posts->have_posts() ) : while( $excat_posts->have_posts() ) : $excat_posts->the_post(); 
										if ( is_sticky() ) { ?>
											<article id="post-<?php the_ID(); ?>" <?php post_class('sticky_post post clearfix'); ?>>
												<?php get_template_part('post/postheader'); ?>
											</article>
										<?php } else {

								        /*This gets the template to display the posts.*/
										$format = get_post_format();
										get_template_part( 'post/format', $format );
										}
										endwhile;	
										wp_reset_query(); 
								    endif;
								    ?>
							<div class="pagination clearfix">
									<?php 
										$big = 999999999; // need an unlikely integer

										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $excat_posts->max_num_pages
										
										)); ?> 
								</div><!-- pagination -->
						<?php else : ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
										if ( is_sticky() ) { ?>
											<article id="post-<?php the_ID(); ?>" <?php post_class('sticky_post post'); ?>>
												<?php get_template_part('post/postheader'); ?>
											</article>
										<?php } else {

								        /*This gets the template to display the posts.*/
										$format = get_post_format();
										get_template_part( 'post/format', $format );
										}
										endwhile;	
										wp_reset_query(); 
								    endif;
								    ?>
								
							    <div class="pagination clearfix">
									<?php 
										$big = 999999999; // need an unlikely integer

										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $wp_query->max_num_pages,
										
										)); 
									?> 
								</div><!-- pagination -->
								<?php endif; ?>
							</div><!-- entries -->
					</div><!-- col-8 -->					
					
					<?php if ( is_active_sidebar( 'sidebar_blog' ) ) { ?>	
						<div class="col-lg-4 col-md-4">
							<?php
							//This displays the sidebar with help of sidebar.php
							get_template_part('sidebar'); ?>
						</div><!-- col-4 -->
					<?php } ?>

				<?php endif; ?>

			</div><!-- row -->
		</div><!-- container -->
	</div><!-- main-content -->
 

<?php
/*This displays the footer with help of footer.php*/
get_footer(); ?>