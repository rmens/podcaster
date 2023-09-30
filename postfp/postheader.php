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
$pod_front_page_episodes_featured_image = pod_theme_option( 'pod-front-page-post-featured-image', true );
?>		

	<header class="entry-header clearfix">

    	<?php if( $format != 'aside' ) { ?>	
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


				<?php if( $format != 'image' ) { ?>	
					<h2 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'podcaster' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
						<?php if( $audioex == 'on' || $videoex == 'on' ) { ?>
                            <span class="mini-ex">
                                <?php echo __('Explicit', 'podcaster'); ?>
                            </span>
                        <?php } ?>
					</h2><!-- .entry-title -->
				<?php } ?>


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
		<?php } //end if != 'aside' ?>

		<?php if ( has_post_thumbnail() && $pod_front_page_episodes_featured_image && ( $format == '' || $format == 'audio' ) ) : ?>
			<div class="featured-image-large">							
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			</div>
		<?php endif; // end if it has a featured image (displayed only on standard posts) ?>

	</header><!-- .entry-header -->		
