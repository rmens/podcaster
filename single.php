<?php
/**
 * This file displays your single posts.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station 
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
/* Loads the header.php template*/
get_header();
$options = get_option('podcaster-theme');  
$thst_wp_version = get_bloginfo( 'version' );
$format = get_post_format();

//$thump_cap = get_post(get_post_thumbnail_id())->post_excerpt;
$thump_cap = the_post_thumbnail_caption();
$featured_post_header = get_post_meta( $post->ID, 'cmb_thst_feature_post_img', true );
$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
$header_img = $image[0];
$pod_plugin_active = get_pod_plugin_active();
$posttype = get_post_type();

$pod_nav_bg = isset( $options['pod-nav-bg'] ) ? $options['pod-nav-bg'] : '';	
$pod_blog_layout = isset( $options['pod-blog-layout'] ) ? $options['pod-blog-layout'] : '';
$gallerystyle_global = isset( $options['pod-pofo-gallery'] ) ? $options['pod-pofo-gallery'] : '';
$pod_sticky_header = isset( $options['pod-sticky-header'] ) ? $options['pod-sticky-header'] : '';
$pod_single_header_display = isset( $options['pod-single-header-display'] ) ? $options['pod-single-header-display'] : '';
$pod_single_header_par = isset( $options['pod-single-header-par'] ) ? $options['pod-single-header-par'] : '';
$pod_single_bg_style = isset( $options['pod-single-bg-style'] ) ? $options['pod-single-bg-style'] : '';
$pod_single_header_bgstyle = isset( $options['pod-single-bg-style'] ) ? $options['pod-single-bg-style'] : '';
$pod_header_par = isset( $options['pod-single-header-par'] ) ? $options['pod-single-header-par'] : '';
$pod_single_video_bg = isset( $options['pod-single-video-bg'] ) ? $options['pod-single-video-bg'] : '';

$has_thumb = has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail' ? ' with_thumbnail' : '';

$ssp_single_sticky = $pod_sticky_header == true ?  'sticky' : '';
$ssp_single_parallax = $pod_header_par == true ? 'data-stellar-background-ratio="0.25"' : '';
$pod_single_header_bg = has_post_thumbnail() && $pod_single_header_display == 'has-background' && $format == 'audio' ? 'thumb_bg' : '';
$ssp_single_header_bg = has_post_thumbnail() && $pod_single_header_display == 'has-background' && $posttype == 'podcast' ? 'thumb_bg' : '';
$pod_single_bg_img = has_post_thumbnail() &&  $pod_single_header_display == 'has-background' ?  'background-image: url(' . $header_img . ');' : '';
$ssp_single_thumb_style = has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail' ?  ' with_thumbnail' : '';

$bpp_single_sticky = $pod_sticky_header == true ? 'sticky' : ''; 
$bpp_single_parallax = $pod_header_par == true ? 'data-stellar-background-ratio="0.25"' : ''; 
$bpp_single_header_bg = has_post_thumbnail() && $pod_single_header_display == 'has-background' && $format == 'audio' ? 'thumb_bg' : '';
$bpp_single_bg_img = has_post_thumbnail() &&  $pod_single_header_display == 'has-background' ? 'background-image: url(' . $header_img . ');' : '';
$bpp_single_thumb_style = has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail' ? ' with_thumbnail' : '';
				
$videoembed = get_post_meta( $post->ID, 'cmb_thst_video_embed', true);
$videourl =  get_post_meta( $post->ID, 'cmb_thst_video_url', true);
$videocapt = get_post_meta($post->ID, 'cmb_thst_video_capt', true);
$videothumb = get_post_meta($post->ID, 'cmb_thst_video_thumb',true);
$videoplists = get_post_meta( $post->ID, 'cmb_thst_video_playlist', true );
$videoembedcode = get_post_meta( $post->ID, 'cmb_thst_video_embed_code', true );
$videoex = get_post_meta( $post->ID, 'cmb_thst_video_explicit', true );

$audiourl = get_post_meta( $post->ID, 'cmb_thst_audio_url', true );
$audioembed = get_post_meta( $post->ID, 'cmb_thst_audio_embed', true );
$audioembedcode = get_post_meta( $post->ID, 'cmb_thst_audio_embed_code', true );
$audiocapt = get_post_meta($post->ID, 'cmb_thst_audio_capt', true );
$audioplists = get_post_meta( $post->ID, 'cmb_thst_audio_playlist', true );
$audioex = get_post_meta( $post->ID, 'cmb_thst_audio_explicit', true );

/* PowerPress Files*/
$pp_audio_str = get_post_meta( $post->ID, 'enclosure', true );
$pp_audiourl = strtok($pp_audio_str, "\n");

$gallerystyle = get_post_meta( $post->ID, 'cmb_thst_post_gallery_style', true );
$galleryimgs = get_post_meta( $post->ID, 'cmb_thst_gallery_list', true );
$gallerycapt = get_post_meta($post->ID, 'cmb_thst_gallery_capt', true);
$gallerycol = get_post_meta($post->ID, 'cmb_thst_gallery_col', true);

?>	

<?php if( $posttype == 'podcast' || $format == 'audio' || $format == 'video' || $format == 'image' ) { ?>

	<?php if( has_post_thumbnail() && $pod_single_video_bg == true && $format == 'video' ) { ?>
	<div style="<?php echo $pod_single_header_bgstyle; ?> background-image: url(' <?php echo $header_img; ?> ');" class="single-featured <?php echo pod_is_nav_transparent(); ?> <?php echo pod_audio_format_featured_image(); ?> <?php echo pod_has_featured_image($post->ID); ?>" <?php echo $ssp_single_parallax; ?>>	
	<div class="background">
	<?php } elseif( has_post_thumbnail() && $pod_single_header_display == "has-background" && ( $posttype == 'podcast' || $format == 'audio' ) ) { ?>
	<div style="<?php echo $pod_single_header_bgstyle; ?> <?php echo $pod_single_bg_img; ?>" class="single-featured <?php echo pod_is_nav_transparent(); ?> <?php echo pod_audio_format_featured_image(); ?> <?php echo pod_has_featured_image($post->ID); ?>" <?php echo $ssp_single_parallax; ?>>	
	<div class="background">
	<?php } else { ?>
	<div style="<?php echo $pod_single_header_bgstyle; ?>" class="single-featured <?php echo pod_is_nav_transparent(); ?> <?php echo pod_has_featured_image($post->ID); ?> <?php echo pod_audio_format_featured_image(); ?>" <?php echo $ssp_single_parallax; ?>>	
	<div class="background">
	<?php } ?>

		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<?php if( $posttype == 'podcast' || $format == 'audio' ) { ?>
						<?php if( has_post_thumbnail() && $pod_single_header_display == 'has-thumbnail' ) { ?>
						<div class="album-art">
							<?php echo get_the_post_thumbnail($id, 'square-large'); ?>
						</div>
					<?php } ?>
				<?php } ?>
				<?php if( $posttype == 'podcast' && $pod_plugin_active == 'ssp'  ) { ?>
					<?php 
					if( class_exists( 'SSP_Admin' ) ) {
					global $ss_podcasting, $wp_query;

					$id = get_the_ID();
					$output_s_ssp_a = '';
					$file = get_post_meta( $id , 'enclosure' , true );
					$terms = wp_get_post_terms( $id , 'series' );
					foreach( $terms as $term ) {
						$series_id = $term->term_id;
						$series = $term->name; 
						break;
					}
					$series_list = isset($series) ? $series : '';
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
					$ep_explicit = get_post_meta( get_the_ID() , 'explicit' , true );
					if( $ep_explicit && $ep_explicit == 'on' ) {
						$explicit_flag = 'Yes';
					} else {
						$explicit_flag = 'No';
					} ?>
			
					<div class="player_container <?php echo $ssp_single_thumb_style; ?>">
						<span class="mini-title"><?php echo get_the_date(); ?> &bull; <?php echo $series_list; ?></span>
						<?php if( $explicit_flag == 'Yes' ) { ?>
			   			<span class="mini-ex">
			       			<?php echo __('Explicit', 'thstlang'); ?>
		  				</span>
						<?php } ?>
						<h2><?php echo get_the_title(); ?></h2>
						<div class="audio">
							<?php if( $file != '' ) {
								echo '<div class="audio_player">' . do_shortcode('[audio src="' . $file . '"][/audio]') . '</div><!--audio_player-->';
							} ?>
						</div><!-- .audio -->
					</div><!-- .player_container -->
					<?php } ?>
				<?php } elseif( $format == 'audio' ) { ?>
					<?php if( $pod_plugin_active = 'bpp' && function_exists('powerpress_content') && $pp_audiourl != '' ) { ?>
						<div class="player_container <?php echo $bpp_single_thumb_style; ?>">
							<span class="mini-title"><?php echo get_the_date(); ?></span>
							<h2><?php echo get_the_title(); ?></h2>
							<div class="audio">
								<?php if( $pp_audiourl !='' ) { ?>
									<?php the_powerpress_content(); ?>
								<?php } ?>
							</div><!-- .audio -->
						</div><!-- .player_container -->
					<?php } else { ?>
						<div class="player_container <?php echo $has_thumb; ?>">
						<span class="mini-title"><?php echo get_the_date(); ?></span>
					    <?php if( $audioex == 'on' ) { ?>
					        <span class="mini-ex">
					            <?php echo  __('Explicit', 'thstlang'); ?>
					        </span>
					    <?php } ?>
						<h2><?php echo get_the_title(); ?></h2>
						<div class="audio">
						<?php if( $audioembed != '' ) {
							$au_embedcode = wp_oembed_get( $audioembed );
							echo '<div class="audio_player au_oembed">' . $au_embedcode . '</div><!--audio_player-->';
						}
						if( $audiourl != '' ) {
							echo '<div class="audio_player">' . do_shortcode('[audio src="' .$audiourl. '"][/audio]</div><!--audio_player-->');	
						}
						if( is_array( $audioplists ) ) {
							echo do_shortcode('[playlist type="audio" ids="'.implode(',', array_keys($audioplists)).'"][/playlist]');
						} 
						if ( $audioembedcode != '') {
							echo '<div class="audio_player embed_code">' . $audioembedcode . '</div><!--audio_player-->';
						} ?> 							
						</div><!-- .audio -->
					</div><!-- .player_container -->
					<?php } ?>
				<?php } elseif( $format == 'video' ) { ?>
					<?php if( $videoembed != '' ) {
						echo '<div class="video_player">' . wp_oembed_get($videoembed) . '</div><!--video_player-->';
					}
					if( $videourl != '' ) {
						echo  '<div class="video_player">' . do_shortcode('[video poster="' .$videothumb. '" src="' .$videourl. '"][/video]') .'</div><!--video_player-->';
					}
					if( is_array( $videoplists ) ) {
						echo  do_shortcode('[playlist type="video" ids="'.implode(',', array_keys($videoplists)).'"][/playlist]');
					}
					if( $videoembedcode !='' ) {
						echo  '<div class="video_player">' . $videoembedcode . '</div><!--video_player-->';									
					} ?>
				<?php } elseif( $format == 'image') { ?>
					<div class="image">
						<?php echo get_the_post_thumbnail( $post->ID,'regular-large' ); ?>
					</div><!-- .image -->
				<?php } ?>
				<div class="clear"></div>
				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->
	<?php if( has_post_thumbnail() && $pod_single_header_display == 'background' && $posttype == 'podcast' ) { ?>
	</div>
	<?php } elseif( has_post_thumbnail() && $pod_single_header_display == 'background'  && ( $format == 'audio' || ( $format == 'video' && $pod_single_video_bg == true) ) ) { ?>
	</div>
	<?php } else { ?>
	</div>
	<?php } ?>
</div><!-- .single-featured -->
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
							</div><!-- .gallery.flexslider -->
						<?php } else { ?>
							<div class="gallery grid clearfix <?php echo $gallerycol; ?>">
								<?php foreach ($galleryimgs as $galleryimgsKey => $galleryimg) {
									$imgid = $galleryimgsKey; ?>
									<div class="gallery-item">
									<a href="<?php echo $galleryimg; ?>" data-lightbox="lightbox">
									<?php echo wp_get_attachment_image( $imgid, 'square-large' ); ?>
									</a>
								</div>
								<?php } ?>
							</div><!-- .gallery.grid -->
						<?php } ?>
						</div>
					<?php } ?>
<?php } ?>
	
	<?php if( get_pod_plugin_active() == 'bpp' && $format == 'audio' ) : ?>
		<?php if( $pp_audiourl !='' ) : ?>
		<div class="caption-container">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div>
							<div class="featured audio">
								<?php echo __('Podcast:', 'thstlang'); ?>
								<a onclick="return powerpress_pinw('<?php echo $post->ID; ?>-podcast');" title="Play in new window" target="_blank" class="powerpress_link_pinw" href="<?php echo $pp_audiourl; ?>"><?php echo __('Play in new window', 'thstlang'); ?></a>
								 | <a title="Download" target="_blank" class="powerpress_link_pinw" href="<?php echo $pp_audiourl; ?>"><?php echo __('Download', 'thstlang'); ?></a>

							</div>
					   	</div><!-- .next-week -->
					</div><!-- .col -->
				</div><!-- .row -->	 
			</div><!-- .container -->  	
		</div>
		<?php endif; ?>
	<?php else : ?> 
		<?php if( ( $format == "video" && $videocapt != '' ) || ( $format == "audio" && $audiocapt != '' ) || ( $format == "image" && $thump_cap != '' ) || ( $format == "gallery" && $gallerycapt != '' ) ) : ?>
		<div class="caption-container">
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
					   	</div><!-- .next-week -->
					</div><!-- .col -->
				</div><!-- .row -->	 
			</div><!-- .container -->  	
		</div>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if ( ! ($format == "video" || $format == "image" || $format == "audio" || $format == "gallery" || $posttype == "podcast" ) &&  $pod_sticky_header == TRUE ) : ?>
	<div class="thst-main-posts sticky">
	<?php else : ?>
	<div class="thst-main-posts">
	<?php endif ; ?>
		<div class="container">
				<div class="row">
					<?php if( $pod_blog_layout == 'sidebar-right' ) : /* If sidebar is being displayed on the right. */ ?>
					<div class="col-lg-8 col-md-8">
						<div class="content">
							<?php
							/*The following line creates the main loop.*/
							if (have_posts()) :
								while (have_posts()) : the_post();
								
								/*This gets the template to display the posts.*/
								get_template_part( 'post/format', $format );
								?>

								<?php setPostViews(get_the_ID()); ?>
								<?php 
								endwhile;	
							endif;
							?>

							<?php comments_template(); ?> 
						</div><!-- .content-->
					</div><!-- .col-8 -->
					
					<div class="col-lg-4 col-md-4">
					<?php
						/*This displays the sidebar with help of sidebar.php*/
						get_template_part('sidebar');
					?>
					</div><!--.col-4-->
					<?php elseif( $pod_blog_layout == 'sidebar-left' ) : /* If sidebar is being displayed on the left. */ ?>
						<div class="col-lg-8 col-md-8 sbar-left pull-right">
						<div class="content">
							<?php
							/*The following line creates the main loop.*/
							if (have_posts()) :
								while (have_posts()) : the_post();
								
								/*This gets the template to display the posts.*/
								get_template_part( 'post/format', $format );
								?>

								<?php setPostViews(get_the_ID()); ?>
								<?php 
								endwhile;	
							endif;
							?>

							<?php comments_template(); ?> 
						</div><!-- .content-->
					</div><!-- .col-8 -->
					<div class="col-lg-4 col-md-4 pull-left">
						<?php
							/*This displays the sidebar with help of sidebar.php*/
							get_template_part('sidebar');
						?>
					</div><!--.col-4-->
					<?php elseif( $pod_blog_layout == 'no-sidebar' ) : /* If no sidebar is being displayed. */ ?>
					<div class="col-lg-12 col-md-12">
						<div class="content">
							<?php
							/*The following line creates the main loop.*/
							if (have_posts()) :
								while (have_posts()) : the_post();
								
								/*This gets the template to display the posts.*/
								get_template_part( 'post/format', $format );
								?>

								<?php setPostViews(get_the_ID()); ?>
								<?php 
								endwhile;	
							endif;
							?>

							<?php comments_template(); ?> 
						</div><!-- .content-->
					</div><!-- .col-12 -->
					<?php else : ?>
					<div class="col-lg-8 col-md-8">
						<div class="content">
							<?php
							/*The following line creates the main loop.*/
							if (have_posts()) :
								while (have_posts()) : the_post();
								
								/*This gets the template to display the posts.*/
								get_template_part( 'post/format', $format );
								?>

								<?php setPostViews(get_the_ID()); ?>
								<?php 
								endwhile;	
							endif;
							?>

							<?php comments_template(); ?> 
						</div><!-- .content-->
					</div><!-- .col-8 -->
					
					<div class="col-lg-4 col-md-4">
					<?php
						/*This displays the sidebar with help of sidebar.php*/
						get_template_part('sidebar');
					?>
					</div><!--.col-4-->
					<?php endif; ?>
				</div><!--row-->
		</div><!--container-->
	</div><!--thst-main-posts-->
<?php
/*This displays the footer with help of footer.php*/
get_footer(); ?>