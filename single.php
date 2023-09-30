<?php
/**
 * This file displays your single posts.
 *
 * @package Podcaster
 * @since 1.0
 */
/* Loads the header.php template*/

get_header();

$thst_wp_version = get_bloginfo( 'version' );
$pod_plugin_active = pod_get_plugin_active();

$format = get_post_format();

if( $pod_plugin_active == "ssp" ) {
	$format = pod_ssp_get_format( $post->ID );
}


$thump_cap = pod_the_post_thumbnail_caption();
$featured_post_header = get_post_meta( $post->ID, 'cmb_thst_feature_post_img', true );
$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
$header_img = ! empty( $image[0] ) ? $image[0] : '';

$posttype = get_post_type();

$pod_blog_layout = pod_theme_option('pod-blog-layout', 'sidebar-right');
$gallerystyle_global = pod_theme_option('pod-pofo-gallery', 'slideshow_on');
$pod_sticky_header = pod_theme_option('pod-sticky-header', false);
$pod_single_header_display = pod_theme_option('pod-single-header-display', 'has-thumbnail');
$pod_single_header_thumb_embed = pod_theme_option('pod-single-header-thumbnail-audio-embed', true);
$pod_single_header_thumb_playlist = pod_theme_option('pod-single-header-thumbnail-audio-playlist', true);
$pod_header_thumb_size = pod_theme_option('pod-single-header-thumbnail-size', 'thumb-size-small');
$pod_header_thumb_radius = pod_theme_option('pod-single-header-thumbnail-radius', 'straight-corners');
$pod_single_header_par = pod_theme_option('pod-single-header-par', false);
$pod_single_header_bgstyle = pod_theme_option( 'pod-single-bg-style', 'background-repeat:repeat;' );
$pod_header_par = pod_theme_option( 'pod-single-header-par', false );
$pod_single_video_bg = pod_theme_option('pod-single-video-bg', false);
$pod_players_preload = pod_theme_option('pod-players-preload', 'none');

/* Player position */
$pod_single_audio_player_position = pod_theme_option( 'pod-single-header-player-display', 'player-in-header' );
$pod_ssp_meta = pod_theme_option('pod-ssp-meta-data', false);
$has_thumb = ( has_post_thumbnail() && $pod_single_header_display ) == 'has-thumbnail' ? ' with_thumbnail' : '';


$ssp_single_sticky = $pod_sticky_header == true ?  'sticky' : '';
$pod_single_header_bg = (has_post_thumbnail() && $pod_single_header_display == 'has-background' && $format == 'audio') ? 'thumb_bg' : '';
$ssp_single_header_bg = (has_post_thumbnail() && $pod_single_header_display == 'has-background' && $posttype == 'podcast') ? 'thumb_bg' : '';
$pod_single_bg_img = (has_post_thumbnail() &&  $pod_single_header_display == 'has-background') ?  'background-image: url(' . $header_img . ');' : '';
$ssp_single_thumb_style = (has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail') ?  ' with_thumbnail' : '';

$bpp_single_sticky = $pod_sticky_header == true ? 'sticky' : ''; 
$bpp_single_header_bg = (has_post_thumbnail() && $pod_single_header_display == 'has-background' && $format == 'audio') ? 'thumb_bg' : '';
$bpp_single_bg_img = (has_post_thumbnail() &&  $pod_single_header_display == 'has-background') ? 'background-image: url(' . $header_img . ');' : '';
$bpp_single_thumb_style = (has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail') ? ' with_thumbnail' : '';

$audiotype = get_post_meta( $post->ID, 'cmb_thst_audio_type', true );
$audiourl = get_post_meta( $post->ID, 'cmb_thst_audio_url', true );
$audioembed = get_post_meta( $post->ID, 'cmb_thst_audio_embed', true );
$audioembedcode = get_post_meta( $post->ID, 'cmb_thst_audio_embed_code', true );
$audiocapt = get_post_meta($post->ID, 'cmb_thst_audio_capt', true );
$audioplists = get_post_meta( $post->ID, 'cmb_thst_audio_playlist', true );
$audioex = get_post_meta( $post->ID, 'cmb_thst_audio_explicit', true );

$videotype = get_post_meta( $post->ID, 'cmb_thst_video_type', true );		
$videoembed = get_post_meta( $post->ID, 'cmb_thst_video_embed', true);
$videourl =  get_post_meta( $post->ID, 'cmb_thst_video_url', true);
$videocapt = get_post_meta($post->ID, 'cmb_thst_video_capt', true);
$videothumb = get_post_meta($post->ID, 'cmb_thst_video_thumb',true);
$videoplists = get_post_meta( $post->ID, 'cmb_thst_video_playlist', true );
$videoembedcode = get_post_meta( $post->ID, 'cmb_thst_video_embed_code', true );
$videoex = get_post_meta( $post->ID, 'cmb_thst_video_explicit', true );

$gallerystyle = get_post_meta( $post->ID, 'cmb_thst_post_gallery_style', true );
$galleryimgs = get_post_meta( $post->ID, 'cmb_thst_gallery_list', true );
$gallerycapt = get_post_meta($post->ID, 'cmb_thst_gallery_capt', true);
$gallerycol = get_post_meta($post->ID, 'cmb_thst_gallery_col', true);

$pod_sc_player = pod_theme_option('pod-audio-soundcloud-player-style', 'sc-classic-player');

$mediatype = '';
if( $format == "audio" ) {
	$mediatype = $audiotype;
} elseif( $format == "video" ) {
	$mediatype == $videotype;
}

if( $audiotype == "audio-embed-url" || $audiotype == "audio-embed-code" ) {
	$has_thumb_embed = ( $pod_single_header_thumb_embed ) ? "audio-embed-thumbnail-active" : "audio-embed-thumbnail-inactive" ;
} else {
	$has_thumb_embed = "";
}

if( $audiotype == "audio-playlist" ) {
	$has_thumb_playlist = ( $pod_single_header_thumb_playlist ) ? "audio-playlist-thumbnail-active" : "audio-playlist-thumbnail-inactive";
} else {
	$has_thumb_playlist = "";
}

/* Check for sidebars */
$pod_is_sidebar_active = is_active_sidebar( 'sidebar_single' ) ? "pod-is-sidebar-active" : "pod-is-sidebar-inactive";

?>	


<?php

	/* If the post has the post type podcast, or has either audio/video/image as a postformat. */ 
	if( $format == 'audio' || $format == 'video' || $format == 'image' ) { ?>

		<?php if( has_post_thumbnail() && $pod_single_video_bg == true && $format == 'video' ) { ?>

			<div class="single-featured <?php echo pod_is_nav_transparent(); ?> <?php echo pod_audio_format_featured_image( $post->ID ); ?> <?php echo pod_has_featured_image($post->ID); ?> <?php echo 'format-' . $format; ?>">	

				<?php echo pod_header_parallax( $post->ID ); ?>

				<div class="background translucent">

		<?php } elseif( has_post_thumbnail() && $pod_single_header_display == "has-background" && ( $format == 'audio' ) ) { ?>

			<div class="single-featured <?php echo pod_is_nav_transparent(); ?> <?php echo pod_audio_format_featured_image( $post->ID ); ?> <?php echo pod_has_featured_image($post->ID); ?> <?php echo 'format-' . $format; ?> <?php echo esc_attr( $mediatype ); ?>">	
				
				<?php echo pod_header_parallax( $post->ID ); ?>

				<div class="background translucent">

		<?php } else { ?>

			<div style="<?php echo esc_attr( $pod_single_header_bgstyle ); ?>" class="single-featured <?php echo esc_attr( $pod_header_thumb_size ); ?> <?php echo pod_is_nav_transparent(); ?> <?php echo esc_attr( $pod_header_thumb_radius ); ?> <?php echo pod_has_featured_image($post->ID); ?> <?php echo pod_audio_format_featured_image( $post->ID ); ?> <?php echo 'format-' . $format; ?> <?php echo esc_attr( $mediatype ); ?>">	
				<div class="background translucent">

		<?php } ?>

			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="single-featured-<?php echo esc_attr( $format ); ?>-container">
						

						<?php if( $pod_plugin_active == "ssp" ) { 
							global $ss_podcasting, $wp_query;

							$id = get_the_ID();
							$output_s_ssp_a = '';
							$file = get_post_meta( $id , "enclosure", true );
							$audio_file = get_post_meta( $id, "audio_file", true );
							$file = $audio_file ? $audio_file : $file;
							$audiotype = "audio-url";

							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
							$ep_explicit = get_post_meta( get_the_ID() , 'explicit' , true );
							if( $ep_explicit && $ep_explicit == 'on' ) {
								$explicit_flag = 'Yes';
							} else {
								$explicit_flag = 'No';
							} 

						?>

							<?php if( $format == "audio" ) { ?>
								<?php if( has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail' ) { ?>
									<div class="album-art">
										<?php echo get_the_post_thumbnail($id, 'square-large'); ?>
									</div>
								<?php } ?>
								
							<?php } ?>
							
							<?php if( $format == "audio" || $format == "video" ){ ?>
								
								<?php if( $format == "audio" ) { ?> 
									<div class="player_container <?php echo esc_attr( $ssp_single_thumb_style ); ?> <?php echo esc_attr( $audiotype ); ?>">

										<span class="mini-title">
											<?php echo get_the_date(); ?> &bull; 
											<?php echo pod_get_ssp_series_cats($post->ID, '', '', ',&nbsp;', true); ?>
										</span>
										
										<h2>
											<?php echo get_the_title(); ?>

											<?php if( $explicit_flag == 'Yes' ) { ?>
								   			<span class="mini-ex">
								       			<?php echo __('Explicit', 'podcaster'); ?>
							  				</span>
											<?php } ?>
										</h2>
										

										<?php if( $file != '' ){
											echo '<div class="audio">';
												echo pod_get_featured_player( $post->ID );	

											echo '</div><!-- .audio -->';
										} ?>

									</div><!-- player_container -->
								<?php } elseif( $format == "video" ) { ?>
									<?php if( $file != '' ){
											$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
											$featured_image_url = $featured_image[0];

											echo pod_get_featured_player( $post->ID );

										} ?>	
								<?php }  ?>		

							<?php } ?>						

						<?php } elseif( $pod_plugin_active == "bpp" ) { ?>
							<?php $bpp_settings = get_option('powerpress_general');
							$bpp_disable_appearance = isset( $bpp_settings['disable_appearance'] ) ? $bpp_settings['disable_appearance'] : '';
								
								/* PowerPress Files*/
								$pp_audio_str = get_post_meta( $post->ID, 'enclosure', true );
								$pp_audiourl = strtok($pp_audio_str, "\n"); 
							?>
							
							<?php if( $format == "audio" ) { 
								$audiotype = "audio-url"; ?>

								<?php if( has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail' ) { ?>
									<div class="album-art">
										<?php echo get_the_post_thumbnail($id, 'square-large'); ?>
									</div>
								<?php } ?>

								<div class="player_container audio-container <?php echo esc_attr( $bpp_single_thumb_style ); ?> <?php echo esc_attr( $audiotype ); ?>">
									<span class="mini-title"><?php echo get_the_date(); ?></span>
									<h2><?php echo get_the_title(); ?></h2>

									<?php if( $bpp_disable_appearance != true ) { ?>
										<?php echo pod_get_featured_player( $post->ID ); ?>
									<?php } ?>

								</div><!-- player_container -->

							<?php } elseif( $format == "video" ) { ?>

								<?php echo pod_get_featured_player( $post->ID ); ?>

							<?php } ?>

						<?php } else { ?>

							<?php if( $format == "audio" ) { ?>
								<?php if( has_post_thumbnail() &&  $pod_single_header_display == 'has-thumbnail' ) { ?>
									
									<?php if( ( $audiotype == "audio-embed-url" || $audiotype == "audio-embed-code" ) && $pod_single_header_thumb_embed == true ) { ?>
										<div class="album-art">
											<?php echo get_the_post_thumbnail($id, 'square-large'); ?>
										</div>
									<?php } elseif( ( $audiotype == "audio-playlist" ) && $pod_single_header_thumb_playlist == true ) { ?>
										<div class="album-art">
											<?php echo get_the_post_thumbnail($id, 'square-large'); ?>
										</div>
									<?php } elseif( $audiotype == "audio-url" ) { ?>
										<div class="album-art">
											<?php echo get_the_post_thumbnail($id, 'square-large'); ?>
										</div>
									<?php } ?>

								<?php } ?>

								<div class="player_container <?php echo esc_attr( $has_thumb ); ?> <?php echo esc_attr( $has_thumb_embed ); ?> <?php echo esc_attr( $has_thumb_playlist ); ?> <?php echo esc_attr( $audiotype ); ?>">

									<div class="player_container_text">
										<span class="mini-title"><?php echo get_the_date(); ?></span>
										
										<h2>
											<?php echo get_the_title(); ?>

											<?php if( $audioex == 'on' ) { ?>
										        <span class="mini-ex">
										            <?php echo  __('Explicit', 'podcaster'); ?>
										        </span>
										    <?php } ?>
										</h2>
									</div>

									<div class="audio">

										<?php echo pod_get_featured_player( $post->ID ); ?>

									</div><!-- audio -->
									
								</div><!-- player_container -->

								<?php } elseif( $format == "video" ) { ?>

									<?php echo pod_get_featured_player( $post->ID ); ?>

								<?php } ?>

						<?php } ?>


						<?php if( $format == 'image') { ?>
							<div class="image">
								<?php echo get_the_post_thumbnail( $post->ID,'regular-large' ); ?>
							</div><!-- .image -->
						<?php }  ?>

						</div><!-- single-featured-container -->
					</div><!-- col -->
				</div><!-- row -->
			</div><!-- container -->
		<?php if( has_post_thumbnail() && $pod_single_header_display == 'background' && $posttype == 'podcast' ) { ?>

		</div>

		<?php } elseif( has_post_thumbnail() && $pod_single_header_display == 'background'  && ( $format == 'audio' || ( $format == 'video' && $pod_single_video_bg == true) ) ) { ?>

		</div>

		<?php } else { ?>

		</div>

		<?php } ?>

	</div><!-- single-featured -->

	<?php } elseif( $format == 'gallery' ){ ?>

		<?php if ( $galleryimgs != ''  ) { ?>
			<div class="featured-gallery">
			<?php if ( $gallerystyle == "slideshow" ) { ?>
				<div class="gallery flexslider">
					<ul class="slides">
						<?php foreach ($galleryimgs as $galleryimgsKey => $galleryimg) { 
						$imgid = $galleryimgsKey; ?>
						<li>
					    <?php echo wp_get_attachment_image( $imgid, 'regular-large' ); ?>
					    </li>
						<?php } ?>
					</ul>
				</div><!-- gallery.flexslider -->
			<?php } else { ?>
				<div class="gallery grid clearfix <?php echo esc_attr( $gallerycol ); ?>">
					<?php foreach ( $galleryimgs as $galleryimgsKey => $galleryimg ) {
						$imgid = $galleryimgsKey; ?>
						<div class="gallery-item">
						<a href="<?php echo esc_attr( $galleryimg ); ?>" data-lightbox="lightbox">
						<?php echo wp_get_attachment_image( $imgid, 'square-large' ); ?>
						</a>
					</div>
					<?php } ?>
				</div><!-- gallery.grid -->
			<?php } ?>
			</div>
		<?php } ?>

	<?php } ?>

	<?php if( $pod_plugin_active == 'bpp' && ( $format == 'audio' || $format == 'video' )  ) : ?>
		<?php 

			$bpp_settings = get_option('powerpress_general');
			$bpp_settings_feeds = isset( $bpp_settings['custom_feeds'] ) ? $bpp_settings['custom_feeds'] : '';
			$bpp_disable_appearance = isset( $bpp_settings[ 'disable_appearance' ] ) ? $bpp_settings[ 'disable_appearance' ] : '';
			$bpp_disable_player = isset( $bpp_settings['disable_player'] ) ? $bpp_settings['disable_player'] : '';

			$bpp_ep_data = powerpress_get_enclosure_data( $post->ID, 'podcast' );
			$bpp_ep_data_url = ! empty( $bpp_ep_data['url'] ) ? $bpp_ep_data['url'] : '';
			$bpp_media_url = powerpress_add_flag_to_redirect_url( $bpp_ep_data_url, 'p' );
			$bpp_subscribe_links = powerpressplayer_link_subscribe_pre( ' ', $bpp_media_url, $bpp_ep_data );	

			if( $bpp_disable_appearance != true ) { ?>
			
			
				<?php $bpp_ep_data = powerpress_get_enclosure_data(get_the_ID(), 'podcast'); ?>
							
					<?php if( ! empty( $bpp_settings_feeds) ) {
						$array_default_feed = array( "podcast" => "Podcast" );
						$bpp_settings_feeds = array_merge( $array_default_feed, $bpp_settings_feeds );
					?>
					

						<?php foreach ( $bpp_settings_feeds as  $key => $feed ) {
						    if ( ! empty($bpp_settings_feeds) ) {
						    	$bpp_ep_data_custom_feed = powerpress_get_enclosure_data(get_the_ID(), $key );
						    	$bpp_ep_feed = $bpp_ep_data_custom_feed['feed'];


					    		if ( array_key_exists($bpp_ep_feed, $bpp_disable_player ) ) {
					    			$bpp_feed_custom_player_active = $bpp_disable_player[$bpp_ep_feed];
					    		} else {
					    			$bpp_feed_custom_player_active = false;
					    		}


						    	if( $bpp_ep_data_custom_feed != false && $bpp_feed_custom_player_active != true ){
							    	
							    	$bpp_media_url = powerpress_add_flag_to_redirect_url( $bpp_ep_data_custom_feed['url'], 'p' );
									$bpp_new_wind_link = powerpressplayer_link_pinw( '', $bpp_media_url, $bpp_ep_data_custom_feed );
									$bpp_download_link = powerpressplayer_link_download( '', $bpp_media_url, $bpp_ep_data_custom_feed );
									$bpp_embed_link = powerpressplayer_link_embed( '', $bpp_media_url, $bpp_ep_data_custom_feed );

									?>
									<div class="caption-container format-<?php echo esc_attr( $format ); ?>">
										<div class="container">
											<div class="row">
												<div class="col-lg-12">
													<div>
														<div class="featured audio">

														<?php if( $bpp_ep_data_custom_feed != false && ( $bpp_new_wind_link !='' || $bpp_download_link != '' || $bpp_embed_link != '' ) ) : ?>

															<p class="powerpress_embed_box" style="display: block;">
															<?php echo __('Podcast', 'podcaster') . ': '; ?>
															<?php 
																if ( !empty( $bpp_new_wind_link ) ) {

																	echo powerpressplayer_link_pinw( '', $bpp_media_url, $bpp_ep_data_custom_feed );
																	if( !empty( $bpp_download_link ) || !empty( $bpp_embed_link ) ) {
																		echo ' | ';
																	}
																}
																if ( !empty( $bpp_download_link ) ) {

																	echo powerpressplayer_link_download( '', $bpp_media_url, $bpp_ep_data_custom_feed );
																	if( !empty( $bpp_new_wind_link) || !empty( $bpp_embed_link ) ) {
																		echo ' | ';
																	}
																}
																if ( !empty( $bpp_embed_link ) ) {

																	echo powerpressplayer_link_embed( '', $bpp_media_url, $bpp_ep_data_custom_feed );
																}
																?>

																<?php if( $bpp_settings['subscribe_links'] == true ) { ?>
																	<span> 
																		<?php echo __('Subscribe', 'podcaster') . ': '; ?>
																		<?php echo powerpressplayer_link_subscribe_pre( ' ', $bpp_media_url, $bpp_ep_data ); ?>
																	</span>
																<?php }	?>
																
															</p>
														<?php endif; ?>
														</div>
													</div><!-- next-week -->
												</div><!-- col -->
											</div><!-- row -->	 
										</div><!-- container -->  	
									</div><!-- caption-container -->
							<?php }
					    	}
						} ?>
											


					<?php } else {
						$bpp_ep_data_url = ! empty( $bpp_ep_data['url'] ) ? $bpp_ep_data['url'] : '';
						$bpp_media_url = powerpress_add_flag_to_redirect_url($bpp_ep_data_url, 'p'); 
						$bpp_new_wind_link = powerpressplayer_link_pinw('', $bpp_media_url, $bpp_ep_data );
						$bpp_download_link = powerpressplayer_link_download('', $bpp_media_url, $bpp_ep_data );
						$bpp_embed_link = powerpressplayer_link_embed('', $bpp_media_url, $bpp_ep_data );

					 ?>

						<?php if( $bpp_ep_data != false && ( $bpp_new_wind_link !='' || $bpp_download_link != '' || $bpp_embed_link != '' ) ) : ?>
						<div class="caption-container format-<?php echo esc_attr( $format ); ?>">
							<div class="container">
								<div class="row">
									<div class="col-lg-12">
										<div>
											<div class="featured audio">
												<p class="powerpress_embed_box" style="display: block;">
												<?php echo __('Podcast', 'podcaster') . ': '; ?>
												<?php 
													if ( !empty( $bpp_new_wind_link ) ) {

														echo powerpressplayer_link_pinw('', $bpp_media_url, $bpp_ep_data );
														if( !empty( $bpp_download_link ) || !empty( $bpp_embed_link ) ) {
															echo ' | ';
														}
													}
													if ( !empty( $bpp_download_link ) ) {

														echo powerpressplayer_link_download('', $bpp_media_url, $bpp_ep_data );
														if( !empty( $bpp_new_wind_link) || !empty( $bpp_embed_link ) ) {
															echo ' | ';
														}
													}
													if ( !empty( $bpp_embed_link ) ) {

														echo powerpressplayer_link_embed('', $bpp_media_url, $bpp_ep_data );
													}
												?>
												</p>
											</div>
										</div><!-- next-week -->
									</div><!-- col -->
								</div><!-- row -->	 
							</div><!-- container -->  	
						</div><!-- caption-container -->
									   	
						<?php endif; ?>
					<?php } ?>

								
			
		<?php } ?>
	<?php elseif( $pod_plugin_active == 'ssp' && $pod_ssp_meta == true && ( $format == 'audio' || $format == 'video' ) ) : 
			global $ss_podcasting;
			$audio_meta = $ss_podcasting->episode_meta_details( $post->ID ); ?>
		<div class="caption-container format-<?php echo esc_attr( $format ); ?>">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div>
							<div class="featured audio">

								<?php echo wp_kses_post( $audio_meta ); ?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


	<?php else : ?> 
		<?php if( ( $format == "video" && $videocapt != '' ) || ( $format == "audio" && $audiocapt != '' ) || ( $format == "image" && $thump_cap != '' ) || ( $format == "gallery" && $gallerycapt != '' ) ) : ?>
		<div class="caption-container format-<?php echo esc_attr( $format ); ?>">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div>
					   		<?php if ( $format == "video" ) : ?>
								<?php echo '<div class="featured vid">' . $videocapt . '</div>'; ?>
							<?php endif; ?>

							<?php if ( $format == "audio" ) : ?>
								<?php echo '<div class="featured audio">' . $audiocapt . '</div>'; ?>
							<?php endif; ?>

							<?php if ( $format == "image" ) : ?>
								<?php echo '<div class="featured img">' . $thump_cap . '</div>'; ?>
							<?php endif; ?>

							<?php if ( $format == "gallery" ) : ?>
								<?php echo '<div class="featured img">' . $gallerycapt . '</div>'; ?>
							<?php endif; ?>
					   	</div><!-- next-week -->
					</div><!-- col -->
				</div><!-- row -->	 
			</div><!-- container -->  	
		</div>
		<?php endif; ?>
	<?php endif; ?>


	<?php if ( ! ($format == "video" || $format == "image" || $format == "audio" || $format == "gallery" || $posttype == "podcast" ) &&  $pod_sticky_header == TRUE ) : ?>
	<div class="main-content single thst-main-posts sticky <?php echo esc_attr( $pod_is_sidebar_active ); ?>">
	<?php else : ?>
	<div class="main-content single thst-main-posts <?php echo esc_attr( $pod_is_sidebar_active ); ?>">
	<?php endif ; ?>

		<div class="container">
				<div class="row">
					<?php if( $pod_blog_layout == 'sidebar-right' ) : /* If sidebar is being displayed on the right. */ ?>
					<div class="col-lg-8 col-md-8">
						<div class="entry-container content">
							<?php
							/*The following line creates the main loop.*/
							if (have_posts()) :
								while (have_posts()) : the_post();
								
								/*This gets the template to display the posts.*/
								get_template_part( 'post/format', $format );
								?>

								<?php pod_set_post_views(get_the_ID()); ?>

								<?php 
								endwhile;	
							endif;
							?>

						</div><!-- entry-container -->
					</div><!-- col-8 -->
					
					<?php if( is_active_sidebar( 'sidebar_single' ) ) { ?>
						<div class="col-lg-4 col-md-4">
						<?php
							/*This displays the sidebar with help of sidebar.php*/
							get_template_part('sidebar');
						?>
						</div><!-- col-4 -->
					<?php } ?>

					<?php elseif( $pod_blog_layout == 'sidebar-left' ) : /* If sidebar is being displayed on the left. */ ?>
						<div class="col-lg-8 col-md-8 sbar-left pulls-right">
						<div class="entry-container content">
							<?php
							/*The following line creates the main loop.*/
							if (have_posts()) :
								while (have_posts()) : the_post();
								
								/*This gets the template to display the posts.*/
								get_template_part( 'post/format', $format );
								?>

								<?php pod_set_post_views(get_the_ID()); ?>
								<?php 
								endwhile;	
							endif;
							?>

						</div><!-- entry-container-->
					</div><!-- col-8 -->

					<?php if( is_active_sidebar( 'sidebar_single' ) ) { ?>
						<div class="col-lg-4 col-md-4 pulls-left">
							<?php
								/*This displays the sidebar with help of sidebar.php*/
								get_template_part('sidebar');
							?>
						</div><!-- col-4 -->
					<?php } ?>


					<?php elseif( $pod_blog_layout == 'no-sidebar' ) : /* If no sidebar is being displayed. */ ?>
					<div class="col-lg-12 col-md-12">
						<div class="entry-container content">
							<?php
							/*The following line creates the main loop.*/
							if (have_posts()) :
								while (have_posts()) : the_post();
								
								/*This gets the template to display the posts.*/
								get_template_part( 'post/format', $format );
								?>

								<?php pod_set_post_views(get_the_ID()); ?>
								<?php 
								endwhile;	
							endif;
							?>

						</div><!-- entry-container-->
					</div><!-- col-12 -->
					<?php else : ?>
					<div class="col-lg-8 col-md-8">
						<div class="entry-container content">
							<?php
							/*The following line creates the main loop.*/
							if (have_posts()) :
								while (have_posts()) : the_post();
								
								/*This gets the template to display the posts.*/
								get_template_part( 'post/format', $format );
								?>

								<?php pod_set_post_views(get_the_ID()); ?>
								<?php 
								endwhile;	
							endif;
							?>

						</div><!-- entry-container -->
					</div><!-- col-8 -->
					
					<?php if( is_active_sidebar( 'sidebar_single' ) ) { ?>
						<div class="col-lg-4 col-md-4">
						<?php
							/*This displays the sidebar with help of sidebar.php*/
							get_template_part('sidebar');
						?>
						</div><!-- col-4 -->
					<?php } ?>
					
					<?php endif; ?>
				</div><!-- row -->
		</div><!-- container -->

		<?php if( $pod_single_audio_player_position == "player-in-footer" ) { 
			$pod_use_sticky_player = pod_use_single_sticky_audio_player( $post->ID );
			if( $pod_use_sticky_player ) {
				echo pod_single_sticky_audio_player( $post->ID );
			}

		} ?>

	</div><!-- main-content -->
<?php
/*This displays the footer with help of footer.php*/
get_footer(); ?>