<?php
/**
 * This file displays your post footer.
 * @package Podcaster
 * @since 1.0
 * */


$pod_comm_display = pod_theme_option( 'pod-comments-display', true );
$podhide_posts = pod_theme_option( 'pod-archive-hide-in-blog', true );
$arch_category = pod_theme_option( 'pod-recordings-category', 1 );
$pod_blog_rm_txt = pod_theme_option( 'pod-blog-read-more-text', 'Continue reading →' );
$pod_blog_comm_0_txt = pod_theme_option( 'pod-blog-leave-comm-0-text', 'Leave a reply' );
$pod_blog_comm_1_txt = pod_theme_option( 'pod-blog-leave-comm-1-text', '1 Reply' );
$pod_blog_comm_mul_txt = pod_theme_option( 'pod-blog-leave-comm-mul-text', 'Replies' );

$pod_plugin_active = pod_get_plugin_active();
if ( isset( $arch_category ) ) {
	$ex_cats = array( $arch_category );
}

$pod_avtr_single = pod_theme_option( 'pod-avatar-single', true );
$pod_athnm_single = pod_theme_option( 'pod-authname-single', true );
$pod_avtr_blg = pod_theme_option( 'pod-avatar-blog', true );
$pod_athnm_blg = pod_theme_option( 'pod-authname-blog', true );
$pod_rtl = pod_theme_option( 'pod-reading-direction', false );

$position = get_the_author_meta( 'user_position' );

/* Host Settings */
$pod_host_active = pod_theme_option( 'pod-single-header-author', 'host-audio' ); ?>

	<?php if ( !( is_archive() || is_search() ) ) : ?>

	<?php
	wp_link_pages( array(
        'before' => '<div class="pagination">',
        'after' => '</div>',
        'link_before'      => '',
        'link_after'       => '',
        'separator'		=> '',
        'next_or_number' => 'next_and_number',
        'nextpagelink' => __('Next', 'podcaster') . ' &rarr;',
        'previouspagelink' => '&larr; ' . __('Previous', 'podcaster'),
        'pagelink' => '%',
        'echo' => 1 )
    );
 	?>
	<?php endif; ?>

	<span class="clear"></span>

	<?php if ( ! is_single() ) { ?>
		<footer class="entry-meta clearfix">
			<div class="entry-taxonomy">
				<?php if ( comments_open() && isset ( $pod_comm_display ) && $pod_comm_display == TRUE ) : ?>
					<span class="comment-link"><?php comments_popup_link( '<span class="leave-reply">' . $pod_blog_comm_0_txt . '</span>', $pod_blog_comm_1_txt , '% ' . $pod_blog_comm_mul_txt ); ?></span>
				<?php else : ?>
					<span class="comment-link"><a href="<?php the_permalink(); ?>"><?php echo esc_attr( $pod_blog_rm_txt ); ?></a></span>
				<?php endif; // comments_open() ?>
			</div>

			<div class="footer-meta">
				<?php if( $pod_avtr_blg == true ) : ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 48 ); ?>
				</a>
				<?php endif; ?>
				<?php if( $pod_athnm_blg == true ) : ?>
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
					<span class="authorname"><?php printf( __( '%s', 'podcaster' ), get_the_author() ); ?></span>
					</a>
				<?php endif; ?>
			</div>
	<?php } ?>

	<?php if ( is_single() ) { ?>

		<?php if( $pod_plugin_active == "ssp" ) { ?>

			<ul class="entry-categories">
				<li><strong><?php echo __('Series: ', 'podcaster'); ?></strong>
				<?php echo pod_get_ssp_series_cats($post->ID, '', '', ',&nbsp;', true); ?></li>
			</ul>

		<?php } else { ?>

			<?php if( has_category() ) { ?>
				<ul class="entry-categories">
					<li><strong><?php echo __('Categories: ', 'podcaster'); ?></strong><?php the_category(', </li> <li> '); ?></li>
				</ul><!--tags-->
			<?php } ?>

			<?php if( has_tag() ) { ?>
				<ul class="entry-tags">
					<li><?php the_tags('#','</li><li>#' , ''); ?></li>
				</ul><!--tags-->
			<?php } ?>

		<?php } ?>

		<?php
			$pod_post_pagi_arrow_next = "&larr;";
			$pod_post_pagi_arrow_prev = "&rarr;";

			if( $pod_rtl ) {
				$pod_post_pagi_arrow_next = "&rarr;";
				$pod_post_pagi_arrow_prev = "&larr;";				
			} ?>

		<footer class="entry-meta <?php echo esc_attr( $pod_host_active ); ?> clearfix">
			<ul class="singlep_pagi clearfix">
	            <li class="right">
	                <p><?php echo __('Previous Post', 'podcaster'); ?></p>
	                <span class="post-pagi-link prev-link">
		                <?php if( $pod_plugin_active == "ssp") { ?>
			                <?php previous_post_link('%link <span class="arrow">' . $pod_post_pagi_arrow_prev . '</span>', '%title', false, ''); ?>
			            <?php } else { ?>
			            	<?php if( in_category($arch_category) && $podhide_posts == false ) : ?>
			                	<?php previous_post_link('%link <span class="arrow">' . $pod_post_pagi_arrow_prev . '</span>', '%title', true, ''); ?>
			                <?php elseif( in_category($arch_category) && $podhide_posts == true ) : ?>
			                	<?php previous_post_link('%link <span class="arrow">' . $pod_post_pagi_arrow_prev . '</span>', '%title', false, ''); ?>
			            	<?php else : ?>
			            		<?php previous_post_link('%link <span class="arrow">' . $pod_post_pagi_arrow_prev . '</span>', '%title', false, $arch_category, 'category'); ?>
			            	<?php endif; ?>
			            <?php } ?>
			        </span>
	            </li>
	            <li class="left">
	                <p><?php echo __('Next Post', 'podcaster'); ?></p>
	                <span class="post-pagi-link next-link">
		                <?php if( $pod_plugin_active == "ssp") { ?>
		            		<?php next_post_link('<span class="arrow">' . $pod_post_pagi_arrow_next . '</span> %link', '%title', false, ''); ?>
		            	<?php } else { ?>
			                <?php if( in_category($arch_category) && $podhide_posts == false ) : ?>
			                	<?php next_post_link('<span class="arrow">' . $pod_post_pagi_arrow_next . '</span> %link', '%title', true, ''); ?>
			                <?php elseif( in_category($arch_category) && $podhide_posts == true ) : ?>
			                	<?php next_post_link('<span class="arrow">' . $pod_post_pagi_arrow_next . '</span> %link', '%title', false, ''); ?>
			                <?php else : ?>
			                	<?php next_post_link('<span class="arrow">' . $pod_post_pagi_arrow_next . '</span> %link', '%title', false, $arch_category, 'category'); ?>
			                <?php endif; ?>
		                <?php } ?>
		            </span>
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
							<h4 class="vcard author"><span class="fn"><?php printf( __( '%s', 'podcaster' ), get_the_author() ); ?></span></h4>
						</a>
						<span><?php if ( $position !='' ) { echo esc_html( $position ); } ?></span><br />
					</div><!-- .author-description -->
					<?php endif; ?>

					<?php if( $pod_plugin_active == "ssp") { ?>
						<?php $ssp_speakers_active = pod_theme_option('pod-ssp-guest-active', false);
						if( $ssp_speakers_active == true && function_exists("SSP_Speakers") ) { ?>
							<div class="episode-speakers">
								<?php $ssp_speakers = SSP_Speakers()->get_speakers( $post->ID );

								$ssp_speakers_singl = SSP_Speakers()->single;
								$ssp_speakers_plur = SSP_Speakers()->plural;
								$count = count( $ssp_speakers );
								if( 1 == $count ) {
									$label = $ssp_speakers_singl;
								} else {
									$label = $ssp_speakers_plur;
								}

								 ?>
								<h3><?php echo esc_html( $label ); ?></h3>

								<ul class="speakers">
								<?php foreach ( $ssp_speakers as $ssp_speaker ) {
									$ssp_speaker_name = $ssp_speaker['name'];
									$ssp_speaker_url = $ssp_speaker['url'];
								?>

								<li><a href="<?php echo esc_attr( $ssp_speaker_url ); ?>" title="<?php echo esc_attr( $ssp_speaker_name ); ?>"><?php echo esc_html( $ssp_speaker_name ); ?></a></li>

								<?php } ?>
								</ul>
							</div>
						<?php } ?>
					<?php } ?>
				</div><!-- .author-info -->
			<?php endif; ?>
		</footer><!-- .entry-meta -->

		<?php if( is_single() ) { ?>
			<div class="comment_container">
				<?php comments_template(); ?> 
			</div>
		<?php } ?>


