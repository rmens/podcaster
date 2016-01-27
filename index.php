<?php
/**
 * Index.php is the default template. This file is used when a more specific template can not be found to display your posts.
 * 
 * @package Podcaster
 * @since 1.0
 * @author Theme Station 
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

get_header();
$options = get_option('podcaster-theme');  

$podrec_category = isset( $options['pod-recordings-category'] ) ? $options['pod-recordings-category'] : '';
$pod_hide_posts = isset( $options['pod-archive-hide-in-blog'] ) ? $options['pod-archive-hide-in-blog'] : '';
$pod_blog_header = isset( $options['pod-blog-header'] ) ? $options['pod-blog-header'] : '';
$pod_blog_header_img = isset( $pod_blog_header['url'] ) ? $pod_blog_header['url'] : '';
$pod_blog_header_title = isset( $options['pod-blog-header-title'] ) ? $options['pod-blog-header-title'] : '';
$pod_blog_header_blurb = isset( $options['pod-blog-header-blurb'] ) ? $options['pod-blog-header-blurb'] : '';
$pod_blog_bg_style = isset( $options['pod-blog-bg-style'] ) ? $options['pod-blog-bg-style'] : '';
$pod_blog_header_par = isset( $options['pod-blog-header-par'] ) ? $options['pod-blog-header-par'] : '';
$pod_blog_layout = isset( $options['pod-blog-layout'] ) ? $options['pod-blog-layout'] : '';
if( $pod_blog_header_img == '' && ( $pod_blog_header_title == '' || $pod_blog_header_blurb == '' ) ) {
	$have_header = 'no-header';
} else {
	$have_header = '';
}
?>
	<?php if ( $pod_blog_header_img != '' ) : ?>
	<div class="main-content <?php echo pod_is_nav_sticky(); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?>">
	<?php else : ?>
	<div class="main-content <?php echo pod_is_nav_sticky(); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image(); ?>">
	<?php endif ; ?>

	<?php if( is_home() && $pod_blog_header_img != '' || $pod_blog_header_title != '' || $pod_blog_header_blurb != '' ) : ?>
		
		<div class="static">
		<?php if ( $pod_blog_header_img != '') : ?>
			<?php if( $pod_blog_header_par == true ) {  ?>
				<div class="content_page_thumb" style="background-image: url('<?php echo $pod_blog_header_img; ?>'); <?php echo $pod_blog_bg_style; ?>" data-stellar-background-ratio="0.25">
			<?php } else { ?>
				<div class="content_page_thumb" style="background-image: url('<?php echo $pod_blog_header_img; ?>'); <?php echo $pod_blog_bg_style; ?>">
			<?php } ?>
			<div id="loading_bg"></div>
			<div class="screen">
		<?php endif; ?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="heading">
							
								<div class="title">
									<h1><?php echo $pod_blog_header_title; ?></h1>
									<?php if( $pod_blog_header_blurb !='' ) { ?><p><?php echo $pod_blog_header_blurb; ?></p><?php } ?>
								</div><!-- .title -->
							
							</div><!-- .heading -->
						</div><!-- .col-lg-12 -->
					</div><!-- .row -->
				</div><!-- .container -->
			<?php if ($pod_blog_header_img !='') : ?>
			</div><!-- .transparent -->
			</div><!-- .content_page_thumb -->
			<?php endif; ?>
		</div><!-- .static -->
	<?php endif ; ?>

		<div class="container">
			<div class="row">
				<?php if ( $pod_blog_layout == 'sidebar-right' ) : /* If sidebar is being displayed on the right. */ ?>
				<div class="col-lg-8 col-md-8">
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
								</div><!--pagination-->
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
								</div><!--pagination-->
								<?php endif; ?>
							</div><!--col-lg-8-->
					</div><!--entries-->					
						
					<div class="col-lg-4 col-md-4">
						<?php
						//This displays the sidebar with help of sidebar.php
						get_template_part('sidebar'); ?>
					</div><!--col-lg-4-->
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
									</div><!--pagination-->
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
									</div><!--pagination-->
									<?php endif; ?>
						</div><!--  .entries -->
					</div><!-- .col-lg-8 -->
					<div class="col-lg-4 col-md-4 pulls-left">
						<?php
						//This displays the sidebar with help of sidebar.php
						get_template_part('sidebar'); ?>
					</div><!--col-lg-4-->	
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
								</div><!--pagination-->
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
								</div><!--pagination-->
								<?php endif; ?>
							</div><!--col-lg-8-->
					</div><!--entries-->	
				<?php else : ?>
					<div class="col-lg-8 col-md-8">
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
								</div><!--pagination-->
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
								</div><!--pagination-->
								<?php endif; ?>
							</div><!--col-lg-8-->
					</div><!--entries-->					
						
					<div class="col-lg-4 col-md-4">
						<?php
						//This displays the sidebar with help of sidebar.php
						get_template_part('sidebar'); ?>
					</div><!--col-lg-4-->
				<?php endif; ?>

			</div><!--row-->
		</div><!--container-->
	</div><!--main-content-->
 

<?php
/*This displays the footer with help of footer.php*/
get_footer(); ?>