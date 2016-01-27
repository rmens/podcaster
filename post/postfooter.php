<?php 
/**
 * This file displays your post footer.
 * @package Podcaster
 * @since 1.0
 * @author Theme Station : http://www.themestation.net
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.net
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * */
 
$options = get_option('podcaster-theme'); 
$audiourl = get_post_meta( $post->ID, 'cmb_thst_audio_url', true );
$pod_comm_display = isset( $options['pod-comments-display'] ) ? $options['pod-comments-display'] : '';
$podhide_posts = isset( $options['pod-archive-hide-in-blog'] ) ? $options['pod-archive-hide-in-blog'] : '';
$arch_category = isset( $options['pod-recordings-category'] ) ? $options['pod-recordings-category'] : '';
$pod_plugin_active = get_pod_plugin_active();

if ( isset( $arch_category ) ) {
	$ex_cats = array( $arch_category );
}
$pod_avtr_single = isset( $options['pod-avatar-single'] ) ? $options['pod-avatar-single'] : '';
$pod_athnm_single = isset( $options['pod-authname-single'] ) ? $options['pod-authname-single'] : '';
$pod_avtr_blg = isset( $options['pod-avatar-blog'] ) ? $options['pod-avatar-blog'] : '';
$pod_athnm_blg = isset( $options['pod-authname-blog'] ) ? $options['pod-authname-blog'] : '';

$position = get_the_author_meta( 'user_position' );

?> <?php if ( !( is_archive() || is_search() ) ) : ?>
	<?php 
	wp_link_pages( array(
        'before' => '<div class="post_pagination clearfix">',
        'after' => '</div>',
        'next_or_number' => 'next_and_number',
        'nextpagelink' => __('Next', 'thstlang'),
        'previouspagelink' => __('Previous', 'thstlang'),
        'pagelink' => '%',
        'echo' => 1 )
    );
 	?>
	<?php endif; ?>

	
	<?php if ( ! is_single() ) { ?>
		<footer class="entry-meta clearfix">
			<div class="entry-taxonomy">	
				<?php if ( comments_open() && isset ( $pod_comm_display ) && $pod_comm_display == TRUE ) : ?>
					<span class="comment-link"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'thstlang' ) . '</span>', __( '1 Reply', 'thstlang' ), __( '% Replies', 'thstlang' ) ); ?></span>
				<?php else : ?>
					<span class="comment-link"><a href="<?php the_permalink(); ?>"><?php echo __('Read More', 'thstlang') ?></a></span>
				<?php endif; // comments_open() ?>	
			</div>

			<div class="footer-meta">
				<?php if( $pod_avtr_blg == true ) : ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">	
					<?php
						$usr_avatar = get_avatar( get_the_author_meta( 'ID' ), 48 ); 
						echo $usr_avatar;
					?>
				</a>
				<?php endif; ?>
				<?php if( $pod_athnm_blg == true ) : ?>
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">	
					<span class="authorname"><?php printf( __( '%s', 'thstlang' ), get_the_author() ); ?></span>
					</a>
				<?php endif; ?>
			</div>
	<?php } ?>
			
	<?php if ( is_single() ) { ?>	
		<?php if( has_category() ) : ?>
			<ul class="entry-categories">
				<li><strong><?php echo __('Categories: ', 'thstlang'); ?></strong><?php the_category(', </li> <li> '); ?></li><br>
				<li><strong><?php echo __('Directe download: ', 'thstlang'); ?></strong><a href="<?php echo $audiourl ?>">128kbit mp3</a></li>
			</ul><!--tags-->
		<?php endif; ?>
		<footer class="entry-meta clearfix">
		<ul class="singlep_pagi clearfix">
            <li class="right">
                <p><?php echo __('Previous Post', 'thstlang'); ?></p>
                <?php if( $pod_plugin_active == "ssp") { ?>
	                <?php previous_post_link('%link &rarr;', '%title', false, ''); ?>
	            <?php } else { ?>
	            	<?php if( in_category($arch_category) && $podhide_posts == false ) : ?>
	                	<?php previous_post_link('%link &rarr;', '%title', true, ''); ?>
	            	<?php else : ?>
	            		<?php previous_post_link('%link &rarr;', '%title', false, $arch_category, 'category'); ?>
	            	<?php endif; ?>
	            <?php } ?>
            </li>
            <li class="left">
                <p><?php echo __('Next Post', 'thstlang'); ?></p>
                <?php if( $pod_plugin_active == "ssp") { ?>
            		<?php next_post_link('&larr; %link', '%title', false, ''); ?>
            	<?php } else { ?>
	                <?php if( in_category($arch_category) && $podhide_posts == false ) : ?>
	                	<?php next_post_link('&larr; %link', '%title', true, ''); ?>
	                <?php else : ?>
	                	<?php next_post_link('&larr; %link', '%title', false, $arch_category, 'category'); ?>
	                <?php endif; ?>
                <?php } ?>
            </li>
        </ul>
		<?php } ?>
		
		<?php if ( is_singular() ) : // If a user has filled out their description, show a bio on their entries. ?>
			<div class="author-info">
				<?php if( $pod_avtr_single == true ) : ?>
				<div class="author-avatar">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'themestation_author_bio_avatar_size', 68 ) ); ?>
					</a>
				</div><!-- .author-avatar -->
				<?php endif; ?>
				<?php if ( $pod_athnm_single == true ) : ?>
				<div class="author-description">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
						<h4><?php printf( __( '%s', 'thstlang' ), get_the_author() ); ?></h4>
					</a>
					<span><?php if ( $position !='' ) { echo $position ; } ?></span><br />
				</div><!-- .author-description -->
				<?php endif; ?>
			</div><!-- .author-info -->
		<?php endif; ?>	
	</footer><!-- .entry-meta -->