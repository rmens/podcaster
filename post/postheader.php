<?php 
/**
 * This file displays your post header.
 * @package Podcaster
 * @since 1.0
 * */

$pod_plugin_active = pod_get_plugin_active();
$id = get_the_ID();
$format = get_post_format();


if( $pod_plugin_active == "ssp" ) {
	$format = pod_ssp_get_format();
}

$posttype = get_post_type();

$videoex = get_post_meta( $post->ID, 'cmb_thst_video_explicit', true );
$audioex = get_post_meta( $post->ID, 'cmb_thst_audio_explicit', true );
$pod_single_stand_feat_img = pod_theme_option('pod-single-stand-feat-img-style', 'ft-image-stretched');
?>		
		<?php if( ! is_single() ) : // if the post being displayed is NOT a single post ?>
			<header class="entry-header clearfix">

		    	<?php if( $format != 'aside' ) : ?>	
					<div class="title-container">
						<?php if( ! is_sticky() && ( has_category() || has_term( "", "series" ) ) ) { ?>
							<?php if( $pod_plugin_active == "ssp" ) { ?>

								<ul class="post-cat-res">
									<li><?php echo pod_get_ssp_series_cats($post->ID, '', '', ',&nbsp;</li><li>', true); ?></li>
								</ul>

							<?php } else { ?>

								<ul class="post-cat-res">
									<li><?php the_category(' </li> <li> '); ?></li>
								</ul><!-- .post-cat-res -->

							<?php } ?>

						<?php } ?>

						<?php if( $format != 'image' ) : ?>	
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'podcaster' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
								<?php if( $audioex == 'on' || $videoex == 'on' ) { ?>
	                                <span class="mini-ex">
	                                    <?php echo __('Explicit', 'podcaster'); ?>
	                                </span>
	                            <?php } ?>
							</h2><!-- .entry-title -->
						<?php endif; ?>

						<ul class="entry-date">
							<li><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
							<?php if ( has_tag() ) { ?>
								<li><?php echo __('Tagged as:', 'podcaster'); ?>
								<?php the_tags( '', ', ', '' ); ?>
								</li>
							<?php } ?>
							<?php if ( is_sticky() ) { ?><li class="sticky_label"><?php echo __('Sticky Post', 'podcaster'); ?></li><?php } ?>
						</ul><!-- .entry-date -->
						
		        	</div><!-- .title-container -->
				<?php endif; //end if != 'aside' ?>

				<?php if ( has_post_thumbnail() && ( $format == '' ) && $posttype != 'podcast' ) : ?>
					<div class="featured-image-large">							
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div>
				<?php endif; // end if it has a featured image (displayed only on standard posts) ?>

			</header><!-- .entry-header -->		

		<?php else : ?><!-- if the post being displayed is a single post -->
			<?php if( $pod_plugin_active == "ssp" && get_post_type() == "podcast" ) {
				$format = pod_ssp_get_format( $post->ID );
			} ?>

			<?php if( $format != 'aside' || ( $pod_plugin_active == "ssp" && get_post_type() == "podcast" && $format == "video"  ) ) { ?>
			<header class="entry-header clearfix">

				<?php if ( has_post_thumbnail() && ( $format == '' ) && $posttype != 'podcast' ) : ?>
					<div class="featured-image-large <?php echo esc_attr( $pod_single_stand_feat_img ); ?>">							
						<?php if( $pod_single_stand_feat_img == "ft-image-stretched" ) : ?>
							
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('regular-large'); ?></a>
						
						<?php elseif( $pod_single_stand_feat_img == "ft-image-auto" ) : ?>
						
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

						<?php else : ?>

							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

						<?php endif; ?>
					</div><!-- .featured-image-large -->
				<?php endif; // end if it has a featured image (displayed only on standard posts) ?>

				<?php if ( $format == 'video' ) : ?>

				<h1 class="entry-title">
					<?php the_title(); ?>
					<?php echo pod_explicit_post($post->ID); ?>						
				</h1>
				<span class="mini-title"><?php echo get_the_date(); ?></span>
				
				<?php else : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<span class="mini-title"><?php echo get_the_date(); ?></span>
				<?php endif ; ?>
			</header><!-- .entry-header -->
			<?php } ?>

		<?php endif; ?><!-- end if a single post is being displayed loop -->