<?php

/**
 * This file is used to display your front page.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*
Template Name: Front Page
*/

get_header(); ?>

	<?php

	if ( have_posts() ) : while ( have_posts() ) : the_post();

	/* Theme Options Values */
	$options = get_option('podcaster-theme'); 

	/* Avatar Settings */
	$pod_avtr_frnt = pod_theme_option('pod-avatar-front');
	$show_avtrs = get_option('show_avatars');

	/* New Slider Settings */
	$pod_fh_active = pod_theme_option('pod-featured-header-active');
	$pod_fh_type = pod_theme_option('pod-featured-header-type');

	/* Featured Post  */
	$arch_category = pod_theme_option('pod-recordings-category', 1);
	$featured_content = pod_theme_option('pod-featured-header-content');
	$pod_featured_excerpt = pod_theme_option('pod-frontpage-fetured-ex');
	$pod_excerpt_type = pod_theme_option('pod-excerpts-type');
	$pod_display_excerpt = pod_theme_option('pod-display-excerpts');
	$pod_excerpts_style  = pod_theme_option('pod-excerpts-style');
	
	$pod_front_num_posts = pod_theme_option('pod-front-posts');
	$pod_archive_link = pod_theme_option('pod-archive-link');
	$pod_archive_link_txt = pod_theme_option('pod-archive-link-txt');
	$pod_slide_amount = pod_theme_option('pod-featured-header-slides-amount');
	?>


	<?php if( $pod_fh_type == 'text'){
		if( function_exists( 'pod_featured_header_text') ) { echo pod_featured_header_text(); }
	} elseif( $pod_fh_type == 'static' ){
		if( function_exists( 'pod_featured_header_static') ) { echo pod_featured_header_static(); }
	} elseif( $pod_fh_type == 'static-posts' ){
		if( function_exists( 'pod_featured_header_static_posts') ) { echo pod_featured_header_static_posts(); }
	} else {
		if( function_exists( 'pod_featured_header_slideshow') ) { echo pod_featured_header_slideshow(); } 
	} ?>
	   		
			
			<div class="list-of-episodes">
				<div class="container">
					<div class="row masonry-container">
						
			   			<?php 
			   			/* Variables & Paths */
						$active_plugin = get_pod_plugin_active();
						if( $pod_fh_type == 'text' ){
							$offset = 0;
						} elseif( $pod_fh_type == 'slideshow' ) {
							if( $featured_content == 'newest'){
								$offset = 1;
							} else {
								$offset = 0;
							}
						} else {
							if( $featured_content == 'newest'){
								$offset = 1;
							} else {
								$offset = 0;
							}
						}
						
						/* WP_Query() for the most recent posts on the front page */

						if( $active_plugin == 'ssp' ) { 
							$args = array( 'post_type' => 'podcast', 'posts_per_page' => $pod_front_num_posts, 'offset' => $offset, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );	
								   				
							$category_posts2 = new WP_Query($args);

							if( $category_posts2->have_posts() ) {
								while( $category_posts2->have_posts() ) {
								   	$category_posts2->the_post(); 
									   	
								   	global $ss_podcasting, $wp_query;
									$id = get_the_ID();
									$terms = wp_get_post_terms( $id , 'series' );
									
									if( ! empty( $terms )) {
										foreach( $terms as $term ) {
											$series_id = $term->term_id;
											$series = $term->name;
											break;
										}
									} else {
										$series = "";
									}

								   	$get_classes = get_post_class();
									$classes = implode(' ', $get_classes); ?>
									<div class="inside-container col-xxs-12">
								   	<article class="<?php echo $classes; ?> list">
								   		<div class="featured-image">
								   			<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail($id, 'square'); ?></a>
								   			<div class="hover">
								   				<a href="<?php echo get_permalink() ?>" class="batch icon" data-icon="&#xF16b;"></a>
								   			</div><!-- .hover -->
								   		</div><!-- .featured-image -->
								   		<div class="inside">
									   		<div class="post-header">
									   			<?php if( $terms || $explicit_flag == 'Yes' ) { ?>
									   				<ul>
									   					<?php if( $series != "" ) { ?><li><?php echo $series; ?></li><?php } ?>
									   					<li><?php echo pod_explicit_post($post->ID); ?></li>
									   				</ul>
									   			<?php } ?>
									   			<h2><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
									   		</div><!-- .post-header -->
											<div class="post-content">
												<?php if ( $pod_excerpt_type == 'force_excerpt' ) { ?>
													<?php echo get_the_excerpt(); ?><a href="<?php echo get_permalink(); ?>" class="more-link"><?php echo __( ' Read More', 'thstlang'); ?><span class="meta-nav"></span></a>
												<?php } else { 
													global $more;
													$more = 0; ?>
													<?php echo get_the_content( __(' Read More', 'thstlang') ); ?>
												<?php } ?>
											</div>
											<div class="post-footer clearfix">
												<span class="date"><?php echo get_the_date(); ?></span>
											</div><!-- .post-footer -->
										</div><!-- .inside -->
									</article>
									</div>
								<?php } ?>
							<?php } ?>
							<?php wp_reset_query(); ?>
						<?php } elseif( $active_plugin == 'bpp' ) { 
							global $post;
							if ( isset( $pod_front_num_posts ) && isset($arch_category) ) { 
						   		$args = array( 'offset' => $offset, 'cat' => $arch_category, 'posts_per_page' =>  $pod_front_num_posts, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );
							} else { 
								$args = array( 'offset' => $offset, 'cat' => 'uncategorized', 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true);
							}
							  			
							$category_posts = new WP_Query($args);
				   			if( $category_posts->have_posts() ) {
				   				while( $category_posts->have_posts() ) {
				   					$category_posts->the_post(); 

						   			$audioex = get_post_meta( $post->ID, 'cmb_thst_audio_explicit', true );
						            $videoex = get_post_meta( $post->ID, 'cmb_thst_video_explicit', true );
						            $get_classes = get_post_class();
									$classes = implode(' ', $get_classes);
									$categories = get_the_category(); ?>			
									<div class="inside-container col-xxs-12">	
									<article class="<?php echo $classes; ?> list">
										<div class="featured-image">
											<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail( $post->ID, "square"); ?></a>
											<div class="hover">
												<a href="<?php echo get_permalink(); ?>" class="batch icon" data-icon="&#xF16b;"></a>
											</div><!-- .hover -->
										</div><!-- .featured-image -->
										<div class="inside">
							   				<div class="post-header">
											<?php if( has_category() ) { ?>
							 					<ul>
												<?php foreach( $categories as $category ) { ?>
										   			<li>
													<?php echo $category->name; ?>
													</li>
												<?php } ?>
												</ul>
											<?php } ?>

										   	<h2><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
										   	</div><!-- .post-header -->
											<div class="post-content">
											<?php if ( $pod_excerpt_type == 'force_excerpt' ) { ?>
												<?php echo get_the_excerpt(); ?>
												<a href="<?php echo get_permalink(); ?>" class="more-link"><?php echo __( ' Read More', 'thstlang' ) ?><span class="meta-nav"></span></a>
											<?php } else {
												global $more;
												$more = 0; ?>
												<?php echo get_the_content( __(' Read More', 'thstlang') ); ?>
											<?php } ?>
											</div>
											<div class="post-footer clearfix">
												<span class="date"><?php echo get_the_date(); ?></span>
											</div><!-- .post-footer -->
										</div><!-- .inside -->
									</article>
									</div>
								<?php } ?>
							<?php } ?>
						   	<?php wp_reset_query(); ?>

						<?php } else {
							global $post;
							
							if ( isset( $pod_front_num_posts ) && isset($arch_category) ) { 
					   			$args = array( 'offset' => $offset, 'cat' => $arch_category, 'posts_per_page' =>  $pod_front_num_posts, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );
						  	} else { 
						  		$args = array( 'offset' => $offset, 'cat' => 'uncategorized', 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true);
						  	}
						  			
						  	$category_posts = new WP_Query($args);
						   	if( $category_posts->have_posts() ) {
						   		while( $category_posts->have_posts() ) {
						   			$category_posts->the_post();

						   			$audioex = get_post_meta( $post->ID, 'cmb_thst_audio_explicit', true );
				            		$videoex = get_post_meta( $post->ID, 'cmb_thst_video_explicit', true );
				            		$get_classes = get_post_class();
									$classes = implode(' ', $get_classes);
									$categories = get_the_category();

				            		?>
				            		<div class="inside-container col-xxs-12">
						   			<article class="<?php echo $classes; ?> list">
						   				<div class="featured-image">
						   				<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'square' ); ?></a>
						   					<div class="hover">
						   						<a href="<?php echo get_the_permalink(); ?>" class="batch icon" data-icon="&#xF16b;"></a>
						   					</div><!-- .hover -->
						   				</div><!-- .featured-image -->
						   				<div class="inside">
							   				<div class="post-header">
								   				<ul>
								   				<?php if( has_category() ) { 
													foreach( $categories as $category ) { ?>
											   		<li><?php echo $category->name; ?></li>
													<?php } ?>
												<?php } ?>
								   				<li><?php echo pod_explicit_post($post->ID); ?></li>
						                     	</ul>
								   				<h2><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
											</div><!-- .post-header -->
											<div class="post-content">
											<?php if ( $pod_excerpt_type == 'force_excerpt' || $pod_excerpt_type == '' ) { ?>
												<?php echo get_the_excerpt(); ?><a href="<?php echo get_permalink(); ?>" class="more-link"><?php echo __( ' Read More', 'thstlang'); ?><span class="meta-nav"></span></a>
											<?php } else {
												global $more;	
												$more = 0; ?> 
												<?php the_content( __(' Read More', 'thstlang') ); ?>
											<?php } ?>
											</div>
											<div class="post-footer clearfix">
												<span class="date"><?php echo get_the_date(); ?></span>
											</div><!-- .post-footer -->
										</div><!-- .inside -->
									</article>
									</div>
						   		<?php } ?>
							<?php } ?>
					   		<?php wp_reset_query(); ?>
						<?php } ?>
		   			</div><!-- .row -->
		   			<?php if( $pod_archive_link != '' ): ?>
		   			<div class="row">
		   				<div class="button-container col-lg-12">
							<a class="butn small" href="<?php echo $pod_archive_link ?>"><?php echo $pod_archive_link_txt; ?></a>
						</div>
		   			</div><!-- .row -->
		   		<?php endif; ?>
		   		</div><!-- .container -->
			</div><!-- .list-of-episodes -->

		<?php if (  isset( $pod_excerpts_style ) && $pod_excerpts_style == 'columns' ) : ?>
			<div class="fromtheblog">
			 	<div class="container">
			 		<div class="row">
			 			<div class="col-lg-12">
			 				<h2 class="title"><?php echo __('From the Blog', 'thstlang') ?></h2>
			 				<div class="row">

				 				<?php 
				 				if( isset( $arch_category ) ) {
				 					$args = array( 'cat' => -$arch_category, 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true);
				 				} else {
				 					$args = array( 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );
				 				}
				 				//echo $arch_category;
					  			$fromblog_posts = new WP_Query($args);

					   			if( $fromblog_posts->have_posts() ) : while( $fromblog_posts->have_posts() ) : $fromblog_posts->the_post(); ?>
					   			<article <?php post_class('col-lg-3 col-md-3 col-sm-3 col-xs-4 col-xxs-6'); ?>>
					   				<div class="featured-image">
					   					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('square'); ?></a>
					   				</div><!-- .featured-image -->
									<div class="inside">		   					
						   				<div class="post-header">
						   					<?php if( has_category() ) : ?>
						   					<ul>
						   						<li><?php the_category(', </li> <li> '); ?></li>
						   					</ul>
						   					<?php endif ; ?>
						   					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

						   				</div><!-- .post-header -->
										<div class="post-content">
											<?php if ( $pod_excerpt_type == 'force_excerpt' ) : ?>
												<?php the_excerpt(); ?>
											<?php else : ?>
												<?php global $more;	$more = 0; the_content(''); ?>
											<?php endif; ?>
										</div>
										<div class="post-footer clearfix">
											<a href="<?php the_permalink(); ?>"><?php echo __('Read More', 'thstlang') ?></a>
										</div><!-- .post-footer -->
									</div><!-- .inside -->
								</article>
					   			<?php endwhile; ?>
				   			<?php endif; wp_reset_query(); ?>
			   			</div><!-- .col-->
			 			</div><!-- .col -->
			 		</div><!-- .row -->
			 	</div><!-- .container -->
			 </div><!-- .fromtheblog -->
		<?php elseif( $pod_excerpts_style == 'list' || $pod_excerpts_style == ''  ) : ?>
			<div class="fromtheblog list">
			 	<div class="container">
			 		<div class="row">
			 			<div class="col-lg-12">
			 				<h2 class="title"><?php echo __('From the Blog', 'thstlang') ?></h2>
			 				
				 				<?php 
				 				if ( isset( $arch_category ) ) {
				 					$args = array( 'cat' => -$arch_category , 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );
				 				} else {
				 					$args = array( 'posts_per_page' => 4, 'paged' => get_query_var( 'paged' ), 'ignore_sticky_posts' => true );
					  			}
					  			$fromblog_posts = new WP_Query($args);

					   			if( $fromblog_posts->have_posts() ) : while( $fromblog_posts->have_posts() ) : $fromblog_posts->the_post(); ?>
					   			<article <?php post_class(); ?>>
					   				<div class="inside clearfix">		   					
						   				<div class="cont post-header">
						   					<?php if( $show_avtrs == true && $pod_avtr_frnt == true ) : ?>
						   					<a class="user_img_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">	
						   					<?php
												$usr_avatar = get_avatar( get_the_author_meta( 'ID' ), 32 ); 
												echo $usr_avatar;
											?>
											</a>
											<?php endif; ?>
						   					<span><?php the_author(); ?></span>
						   				</div>
						   				<div class="cont_large post-content">
						   					<span class="cats"><?php the_category('</span> <span class="cats"> '); ?></span>
						   					<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
						   				</div><!-- .post-header -->
										
										<div class="cont date post-footer">
											<span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span>
										</div><!-- .post-footer -->
									</div><!-- .inside -->
								</article>
					   			<?php endwhile; ?>
				   			<?php endif; wp_reset_query(); ?>

				   			<?php if( get_option( 'show_on_front' ) == 'page' ) { ?>
				   				<div class="button-container">
					   				<a class="butn small" href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>"><?php echo __('Go to Blog', 'thstlang') ?></a>
					   			</div>
				   			<?php } ?>
			 			</div><!-- .col -->
			 		</div><!-- .row -->
			 	</div><!-- .container -->
			</div>
		<?php else : ?>
			<?php //Do nothing. ?>
		<?php endif; ?>					
<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>