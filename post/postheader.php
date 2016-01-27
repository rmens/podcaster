<?php 
/**
 * This file displays your post header.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * */
$id = get_the_ID();
$format = get_post_format();
$posttype = get_post_type();
$videoex = get_post_meta( $post->ID, 'cmb_thst_video_explicit', true );
$audioex = get_post_meta( $post->ID, 'cmb_thst_audio_explicit', true );
?>		
		<?php if( ! is_single() ) : ?><!-- if the post being displayed is not a single post -->
			<header class="entry-header clearfix">  
		    	<?php if( $format != 'aside' ) : ?>	
					<div class="title-container">
						<?php if( ! is_sticky() && has_category() ) : ?>
							<ul class="post-cat-res">
								<li><?php the_category(' </li> <li> '); ?></li>
							</ul><!-- .post-cat-res -->
						<?php endif; ?>

						<?php if( $format != 'image' ) : ?>	
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'thstlang' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2><!-- .entry-title -->
							<?php if( $audioex == 'on' || $videoex == 'on' ) { ?>
                                <span class="mini-ex">
                                    <?php echo __('Explicit', 'thstlang'); ?>
                                </span>
                            <?php } ?>
						<?php endif; ?>

						<ul class="entry-date">
							<li><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
							<?php if ( has_tag() ) { ?>
								<li>Tagged as:
								<?php the_tags( '', ', ', '' ); ?>
								</li>
							<?php } ?>
							<?php if ( is_sticky() ) { ?><li class="sticky_label">Sticky Post</li><?php } ?>
						</ul><!-- .entry-date -->
		        	</div><!-- .title-container -->
				<?php endif; //end if != 'aside' ?>
				<?php if ( has_post_thumbnail() && ( $format == '' ) && $posttype != 'podcast' ) : ?>
					<div class="featured-image-large">							
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('regular-large'); ?></a>
					</div>
				<?php endif; ?><!-- end if it has a featured image (displayed only on standard posts) -->
			</header><!-- .entry-header -->		

		<?php else : ?><!-- if the post being displayed is a single post -->

			<header class="entry-header clearfix">
				<?php if ( has_post_thumbnail() && ( $format == '' ) && $posttype != 'podcast' ) : ?>
					<div class="featured-image-large">							
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('regular-large'); ?></a>
					</div><!-- .featured-image-large -->
				<?php endif; ?><!-- end if it has a featured image (displayed only on standard posts) -->

				<?php if ( $format == 'video' ) : ?>

				<span class="mini-title"><?php echo get_the_date(); ?><?php echo pod_explicit_post($post->ID); ?></span>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				
				<?php elseif ( $format == 'aside' || $posttype == 'podcast' ) : ?>
					<?php //Display no title. ?>
				<?php else : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<span class="mini-title"><?php echo get_the_date(); ?></span>
				<?php endif ; ?>
			</header><!-- .entry-header -->

		<?php endif; ?><!-- end if a single post is being displayed loop -->