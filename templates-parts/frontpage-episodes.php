<?php
	$active_plugin = pod_get_plugin_active();

	/* Theme Options */
	$pod_players_preload = pod_theme_option('pod-players-preload', 'none');
	$pod_front_page_post_players = pod_theme_option( 'pod-front-page-post-players', true );
	$pod_front_page_episodes_featured_image = pod_theme_option( 'pod-front-page-post-featured-image', true );
	$pod_front_page_episodes_featured_image_out = ($pod_front_page_episodes_featured_image) ? "pod-featured-image-on" : "pod-featured-image-off";

	/* Truncate settings */
	$pod_truncate_title = pod_theme_option('pod-front-page-titles', false);
	$is_truncate = $pod_truncate_title ? " truncate" : " not-truncate";

	/* Check for static front page template */
	$pod_fp_id = get_option( 'page_on_front' );
	$pod_fp_current_template = get_page_template_slug( $pod_fp_id );
	
	/* Post Format */
	$format = get_post_format( $post->ID );

	if( $active_plugin == 'ssp' ) {
		global $ss_podcasting, $wp_query;
		$id = get_the_ID();
		$ep_explicit = get_post_meta( $id , 'explicit' , true );
		$ep_explicit && $ep_explicit == 'on' ? $explicit_flag = 'Yes' : $explicit_flag = 'No';

		$file = get_post_meta( $post->ID , "enclosure", true );
		$audio_file = get_post_meta( $post->ID, "audio_file", true );
		$file = $audio_file ? $audio_file : $file;
		$ssp_ep_type = get_post_meta( $post->ID, "episode_type", true );

	   	$get_classes = get_post_class('post');
		$classes = implode(' ', $get_classes);


	} elseif( $active_plugin == 'bpp' ) {

		$get_classes = get_post_class('post');
		$classes = implode(' ', $get_classes);
		$post_format = get_post_format( $post->ID );

		/* PowerPress Files*/
		$pp_audio_str = get_post_meta( $post->ID, 'enclosure', true );
		$pp_audiourl = strtok($pp_audio_str, "\n");
		

	} else {
		$audioex = get_post_meta( $post->ID, 'cmb_thst_audio_explicit', true );
		$videoex = get_post_meta( $post->ID, 'cmb_thst_video_explicit', true );
		$get_classes = get_post_class('post');
		$classes = implode(' ', $get_classes);

		$audiotype = get_post_meta( $post->ID, 'cmb_thst_audio_type', true );
		$audiourl = get_post_meta( $post->ID, 'cmb_thst_audio_url', true );
		$audioembed = get_post_meta( $post->ID, 'cmb_thst_audio_embed', true );
		$audioembedcode = get_post_meta( $post->ID, 'cmb_thst_audio_embed_code', true );
		$audiocapt = get_post_meta( $post->ID, 'cmb_thst_audio_capt', true );
		$audioplists = get_post_meta( $post->ID, 'cmb_thst_audio_playlist', true );
		$au_uploadcode = wp_audio_shortcode( $audiourl );

	}

?>

<article class="<?php echo esc_attr( $classes ); ?> <?php echo esc_attr( $pod_front_page_episodes_featured_image_out ); ?>">
	

	<?php if( has_post_thumbnail() && $pod_front_page_episodes_featured_image ) { ?>
		<?php if( ! ( $pod_fp_current_template == "page/page-frontpage.php" || $pod_fp_current_template == "page/page-frontpage-left.php" || $pod_fp_current_template == "page/page-frontpage-right.php" ) ) { ?>

			<?php echo pod_front_page_episodes_featured_image( $post->ID, "square-large" ); ?>

		<?php } else { ?>

			<?php echo pod_front_page_episodes_featured_image( $post->ID, 'square', true ); ?>

		<?php } ?>
	<?php } ?>

	<div class="post-content">
		<div class="inside">
			<div class="post-header">

				<?php echo pod_front_page_ep_cats( $post->ID ); ?>
				<h2 class="<?php echo esc_attr( $is_truncate ); ?>">
					<a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
				</h2>

			</div><!-- .post-header -->
			<div class="post-text">

				<?php 
					
					if( $pod_front_page_post_players ) {

						if( $active_plugin == 'ssp') { 
							if( $file != '' && $ssp_ep_type == "audio" ){
								//$audio_ssp_shortcode_attr = array( 'src' => $file, 'preload' => $pod_players_preload );
								//$audio_shortcode = wp_audio_shortcode( $audio_ssp_shortcode_attr );
								$audio_shortcode = pod_get_featured_player_ssp( $post->ID );

								echo '<div class="audio_player">' . $audio_shortcode . '</div><!-- .audio_player -->';
							} 
						} elseif( $active_plugin == 'bpp') { ?>
							<?php if ( function_exists('the_powerpress_content') && $post_format == "audio" ) { ?>
								<?php echo the_powerpress_content(); ?>
							<?php } ?>
						<?php } else {

							if( $format == "audio" && $audiotype == "audio-url" ) { 
								if( $audiourl != '' ) {

									$audio_shortcode_attr = array( 'src' => $audiourl, 'preload' => $pod_players_preload );
									echo '<div class="audio_player">' . wp_audio_shortcode( $audio_shortcode_attr ) . '</div><!-- .audio_player -->';

								}
							} 
						}
					}

				?>

				<?php echo pod_front_page_ep_excerpts($post->ID); ?>

			</div><!-- .post-text -->

			<div class="post-footer clearfix">
				<span class="date"><?php echo get_the_date(); ?></span>
			</div><!-- .post-footer -->

			</div><!-- .inside -->
		</div><!-- .post-content -->

</article>
