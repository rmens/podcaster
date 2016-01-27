<?php 
/* Functions for the improved featured header for the front page */

if( ! function_exists( 'pod_themeoption_typekit' ) ) {
	add_action('wp_head','pod_themeoption_typekit');
	function pod_themeoption_typekit() {
		$pod_typekit_code = pod_theme_option('pod-typekit-code');

		if( $pod_typekit_code != '') {
			$code = $pod_typekit_code;
			echo $code;
		}
	}
}

if( ! function_exists( 'pod_themeoption_css' ) ) {
	add_action('wp_head','pod_themeoption_css');
	function pod_themeoption_css() {
		$pod_custom_css = pod_theme_option('pod-typekit-css-code');

		if( $pod_custom_css != '') {
			$css = '';
			$css .= '<style>';
				$css .= $pod_custom_css;
			$css .= '</style>';
			$css = str_replace(PHP_EOL, '', $css);
			$css = trim(preg_replace('!\s+!', ' ', $css));
			echo $css;
		}
	}
}

/**
 * pod_flexible_excerpt()
 * Custom Excerpt Length for the featured header (set in post).
 *
 * @param string $post_id - ID of given post. 
 * @param string $limit - Default value for the excerpt length.
 * @return string $excerpt - Excerpt with length set to custom value.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_flexible_excerpt') ) {
	function pod_flexible_excerpt($post_id, $limit='25') {
		$post_format = get_post_format($post_id);
		if( $limit == '') $limit = 25;
		$limit = intval($limit);
		$post_object = get_post( $post_id );
		$get_content = $post_object->post_content;
		$excerpt = explode(' ', $get_content, $limit);

		if (count($excerpt)>=$limit) {
		    array_pop($excerpt);
		    $excerpt = implode(" ",$excerpt).' ...';
		} else {
		    $excerpt = implode(" ",$excerpt);
		}	
		
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	  	
	  	return $excerpt;
	}
}

/**
 * pod_the_blog_content()
 * Custom Excerpt Length for the featured header (set in post).
 *
 * @param string $post_id - ID of given post. 
 * @param string $limit - Default value for the excerpt length.
 * @return string $excerpt - Excerpt with length set to custom value.
 * @since Podcaster 1.5.3
 */
if( ! function_exists( 'pod_the_blog_content' ) ) {
	function pod_the_blog_content() {
		$pod_the_blog_content = pod_theme_option('pod-blog-excerpts');
		$output = '';
		if( $pod_the_blog_content == 'force' ) {
			$output .= get_the_excerpt() . '<p><a class="more-link" href="'. get_the_permalink() .'">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'thstlang' ) . '</a></p>';
		} elseif( $pod_the_blog_content == 'set_in_post' ) {
			$content = get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'thstlang' ) );
			$content = apply_filters('the_content', $content);
			$output = $content;
		} else {
			$content = get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'thstlang' ) );
			$content = apply_filters('the_content', $content);
			$output = $content;
		}

		return $output;
	}
}

/**
 * pod_next_week()
 * Next week/scheduled posts.
 *
 * @return string $output - The next week <div> that is displayed under the player on the front page.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_next_week')) {
	function pod_next_week() {
		/* Theme Option Values */
		$options = get_option('podcaster-theme');
		$arch_category = isset( $options['pod-recordings-category'] ) ? $options['pod-recordings-category'] : 1;
		$pod_preview_title = isset( $options['pod-preview-title'] ) ? $options['pod-preview-title'] : '';
		$pod_preview_heading = isset( $options['pod-preview-heading'] ) ? $options['pod-preview-heading'] : '';
		$pod_scheduled_posts = isset( $options['pod-scheduling'] ) ? $options['pod-scheduling'] :'';
		$pod_next_week = isset( $options['pod-frontpage-nextweek'] ) ? $options['pod-frontpage-nextweek'] : '';
		$pod_subscribe_buttons = pod_theme_option('pod-subscribe-buttons');
		
		/* Subscribe Buttons */
		$pod_butn_one = isset( $options['pod-subscribe1'] ) ? $options['pod-subscribe1'] : '';
		$pod_butn_one_url  = isset( $options['pod-subscribe1-url'] ) ? $options['pod-subscribe1-url'] : '';
		$pod_butn_two = isset( $options['pod-subscribe2'] ) ? $options['pod-subscribe2'] : '';
		$pod_butn_two_url  = isset( $options['pod-subscribe2-url'] ) ? $options['pod-subscribe2-url'] : '';
		
		$plugin_inuse = get_pod_plugin_active();
		$output = '';
		$output .= '<div class="next-week">
							<div class="row">';
							if( $pod_next_week == 'show' ) {
								if ( $pod_subscribe_buttons == true ) {
						   				$output .= '<div class="col-lg-6 col-md-6">';
						   			} else {
						   				$output .= '<div class="col-lg-12 col-md-12">';
						   			}
									$output .= '<div class="content scheduled">
									<span class="mini-title">';
										if( $pod_preview_title != '') { 
						   					$output .= $pod_preview_title; 
						   				} 
						   			$output .= '</span>';

				                    if( $pod_scheduled_posts  == true ) {
					                    if ( $plugin_inuse == 'ssp' ) {
								   			$sched_args = array( 
								   				'post_type' => 'podcast', 
								   				'posts_per_page' => 15,  
								   				'ignore_sticky_posts' => true,
								   				'post_status' => 'future',
								   				'order' => 'ASC',
								   			);	
							   			} else {
							   				$sched_args = array( 
								   				'post_type' => 'post', 
								   				'cat' => $arch_category,
								   				'posts_per_page' => 1,  
								   				'ignore_sticky_posts' => true,
								   				'post_status' => 'future',
								   				'order' => 'ASC',
								   			);
							   			} 							   			

										$sched_q = new WP_Query($sched_args);
										if( !($sched_q->have_posts()) ) {
											$output .=  '<p class="schedule-message">' . __('Please schedule a podcast post, to make it visible here.', 'thstlang') . '</p>';
										} else {
											while( $sched_q->have_posts() ) : $sched_q->the_post();
											$output .= '<h3>' . get_the_title() .'</h3>';
											endwhile;
											wp_reset_query();
										}
				                    } else {
							   			$output .= '<h3>';
							   			if( $pod_preview_heading != '') { 
							   				$output .= $pod_preview_heading;
							   			} 
							   			$output .= '</h3>';
							   		}
							   	$output .= '</div><!-- .content -->
						   			</div><!-- .col -->';
						   		}
						   		if( $pod_subscribe_buttons == true ){
						   			if ( $pod_next_week == 'show' ) {
						   				$output .= '<div class="col-lg-6 col-md-6">';
						   			} else {
						   				$output .= '<div class="col-lg-12 col-md-12">';
						   			}

						   			$output .= '<div class="content buttons">';
						   				if( isset( $options['pod-subscribe1'] ) ) {
						   					$output .= '<a href="' . $pod_butn_one_url . '" class="butn small">' . $pod_butn_one . '</a>';
						   				} else {
						   					$output .= '<a href="#" class="butn small">' . __('Subscribe with iTunes', 'thstlang') . '</a>';
						   				}
						   				if( isset( $options['pod-subscribe2'] ) ) {
						   					$output .= '<a href="' . $pod_butn_two_url .'" class="butn small">' . $pod_butn_two .'</a>';
						   				} else {
						   					$output .= '<a href="#" class="butn small">' . __('Subscribe with RSS', 'thstlang') . '</a>';
						   				}
						   			$output .= '</div><!-- .content -->
						   		</div><!-- .col -->';
						   		}
						   	$output .='</div><!-- .row -->
					</div><!-- .next-week -->';
					return $output;
	}
}

/**
 * pod_explicit_post()
 * Explicit marker displayed when oist has been marked as such.
 *
 * @param string $post_id - ID of given post. 
 * @return string $excerpt - Explicit marker.
 * @since Podcaster 1.5
 */
if( !function_exists('pod_explicit_post') ){
	function pod_explicit_post($post_id) {
		$plugin_inuse = get_pod_plugin_active();
		$output = '';

		if( $plugin_inuse == 'ssp' ) {
			$ep_explicit = get_post_meta( $post_id , 'explicit' , true );
			$ep_explicit && $ep_explicit == 'on' ? $explicit_flag = 'Yes' : $explicit_flag = 'No';
				
			if( $explicit_flag == 'Yes' ) {
			    $output .= '<span class="mini-ex">' . __('Explicit', 'thstlang') .'</span>';
			} else {
				$output .= '';
			}
		} else {
			$post_format = get_post_format( $post_id );
			$ep_explicit_au = get_post_meta( $post_id, 'cmb_thst_audio_explicit', true );
			$ep_explicit_vi = get_post_meta( $post_id, 'cmb_thst_video_explicit', true );
			$ep_explicit_au || $ep_explicit_vi == 'on' ? $explicit_flag = 'Yes' : $explicit_flag = 'No';

			if( $post_format == 'audio' ) {
				if( $ep_explicit_au != '' ){
			    	$output .= '<span class="mini-ex">' . __('Explicit', 'thstlang') .'</span>';
			    	$output .= '<span class="mini-ex small">' . __('E', 'thstlang') .'</span>';
			    } else {
			    	$output .= '';
			    }
			} elseif( $post_format == 'video' ) {
				if( $ep_explicit_vi != '' ){
			    	$output .= '<span class="mini-ex">' . __('Explicit', 'thstlang') .'</span>';
			    	$output .= '<span class="mini-ex small">' . __('E', 'thstlang') .'</span>';
			    } else {
			    	$output .= '';
			    }
			}
			
		}
		return $output;
	}
}

/**
 * pod_the_embed()
 * Featured embedded content style.
 *
 * @param -
 * @return string $excerpt - Audio or video player.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_the_embed' ) ) {
	function pod_the_embed($text="", $multimedia=""){

		/* Theme Option Values */
		$pod_embed_style = pod_theme_option('pod-embed-style');
		$pod_embed_widths = pod_theme_option('pod-embed-widths');
		if( $pod_embed_widths == 'narrow' ) {
			$t_width = '8';
			$m_width = '4';
		} elseif( $pod_embed_widths == 'equal' ) {
			$t_width = '6';
			$m_width = '6';
		} elseif( $pod_embed_widths == 'wide' ) {
			$t_width = '4';
			$m_width = '8';
		}

		$output = '';
		if( $pod_embed_style == "left" ) {
			$output .= '<div class="col-lg-' .$t_width. ' pulls-right">' . $text. '</div>
				<div class="col-lg-' .$m_width. ' pulls-left">' .$multimedia. '</div>';
		} elseif( $pod_embed_style == "right" ) {
			$output .= '<div class="col-lg-' .$m_width. ' pulls-right">' .$multimedia. '</div> 
				<div class="col-lg-' .$t_width. ' pulls-left">' . $text. '</div>';
		} elseif( $pod_embed_style == "center-bottom" ) {
			$output .= '<div class="col-lg-12">' .$multimedia. '</div> 
				<div class="col-lg-12">' . $text. '</div>';
		} elseif( $pod_embed_style == "center-top" ) {
			$output .= '<div class="col-lg-12">' . $text. '</div>
				<div class="col-lg-12">' .$multimedia. '</div>';
		} else {
			$output .= '<div class="col-lg-12">' . $text. '</div>
				<div class="col-lg-12">' .$multimedia. '</div>';
		}

		return $output;
	}
}
/**
 * pod_featured_multimedia()
 * Featured multimedia for the front page.
 *
 * @param string $post_id - ID of given post. 
 * @return string $excerpt - Audio or video player.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_featured_multimedia') ) {
	function pod_featured_multimedia($post_id) {
		global $post;
		
		$plugin_inuse = get_pod_plugin_active();
		$post_format = get_post_format($post_id);
		$pod_featured_excerpt = pod_theme_option('pod-frontpage-fetured-ex');
		$post_featured_media = '';

		if( $plugin_inuse == 'ssp' ) {
				$pod_fh_heading = pod_theme_option( 'pod-featured-heading' );

				
				$id = get_the_ID();
				$file = get_post_meta( $post_id , 'enclosure' , true );
				$terms = wp_get_post_terms( $post_id , 'series' );
				foreach( $terms as $term ) {
					$series_id = $term->term_id;
					$series = $term->name;
					break;
				}
				$post_featured_media .= '<span class="mini-title">' . $pod_fh_heading . '</span>';
				$post_featured_media .= pod_explicit_post($post->ID);
				$post_featured_media .= '<h2><a href="' . get_permalink() .'">' . get_the_title() . '</a></h2>';										
						
				if( $file != '' ) {
					$post_featured_media .= '<div class="audio"><div class="audio_player">' . do_shortcode('[audio src="' . $file . '"][/audio]') . '</div><!--audio_player--></div><!-- .audio -->';
				} else {
					$post_featured_media .= '';
				}
				if ( $pod_featured_excerpt == true ) { 
							$post_featured_media .= '<div class="featured-excerpt ' . $post_format .'">';
								$post_featured_media .= get_the_excerpt();
								$post_featured_media .= '<a href="' . get_permalink() . '" class="more-link">';
									$post_featured_media .= __( ' Read More', 'thstlang');
									$post_featured_media .= '<span class="meta-nav"></span>
								</a>';
							$post_featured_media .= '</div>';
						}
			} elseif( $plugin_inuse == 'bpp'){
				$pod_fh_heading = pod_theme_option( 'pod-featured-heading' );
					
				$pp_audio_str = get_post_meta( $post_id, 'enclosure', true );
				$pp_audiourl = strtok($pp_audio_str, "\n");
				$post_featured_media .= '<span class="mini-title">' . $pod_fh_heading . '</span>';
						$post_featured_media .= pod_explicit_post($post->ID);
						$post_featured_media .= '<h2><a href="' . get_permalink() .'">' . get_the_title() . '</a></h2>';										
						
				if( $pp_audiourl != '') {								
					$post_featured_media .= get_the_powerpress_content(); 
				}
				if ( $pod_featured_excerpt == true ) { 
							$post_featured_media .= '<div class="featured-excerpt ' . $post_format .'">';
								$post_featured_media .= get_the_excerpt();
								$post_featured_media .= '<a href="' . get_permalink() . '" class="more-link">';
									$post_featured_media .= __( ' Read More', 'thstlang');
									$post_featured_media .= '<span class="meta-nav"></span>
								</a>';
							$post_featured_media .= '</div>';
						}
			} else {
				
				if( $post_format == 'audio' ){
					$audiourl = get_post_meta( $post_id, 'cmb_thst_audio_url', true );
					$audioembed = get_post_meta( $post_id, 'cmb_thst_audio_embed', true );
					$audioembedcode = get_post_meta( $post_id, 'cmb_thst_audio_embed_code', true );
					$audiocapt = get_post_meta( $post_id, 'cmb_thst_audio_capt', true );
					$audioplists = get_post_meta( $post_id, 'cmb_thst_audio_playlist', true );
					$au_uploadcode = wp_audio_shortcode( $audiourl );
					$audioex = get_post_meta( $post_id, 'cmb_thst_audio_explicit', true );

					$options = get_option('podcaster-theme');
					$pod_fh_heading = isset( $options['pod-featured-heading'] ) ? $options['pod-featured-heading'] : '';
					
					$excerpt_count = get_post_meta( $post_id, 'cmb_thst_featured_post_excerpt_count', true);
					$has_excerpt = get_post_meta( $post_id, 'cmb_thst_feature_post_excerpt', true);
					$post_object = get_post( $post_id );
					$fheader_type = pod_theme_option('pod-featured-header-type');

					if( $fheader_type == 'static' ) { 
						$post_excerpt = get_the_excerpt();
					} else {
						if( $has_excerpt == 'on') {
							if( $post_object->post_excerpt ) {
								$post_excerpt = $post_object->post_excerpt;
							} elseif( isset($excerpt_count) ) {
								$post_excerpt = pod_flexible_excerpt( $post_id, $excerpt_count );
							} else {
								$post_excerpt = '';
							}
						} else {
							$post_excerpt = '';
						}
					}
								        
					if($audioembed != '') {
						$file_parts = pathinfo($audioembed);
						if(array_key_exists("extension", $file_parts )) {
							$audioembed ='';
							$au_embedcode = "<p>Please use a valid embed URL. Make sure it doesn't have a file extension, such as *.mp3.</p>";
						} else {
							$au_embedcode = wp_oembed_get( $audioembed );
						}
						$post_featured_media .= '<div class="row">' .pod_the_embed('<span class="mini-title">' . $pod_fh_heading . '</span> ' . pod_explicit_post($post_id) .' <h2><a href="' . get_permalink($post_id ) . '">' . get_the_title($post_id) . '</a></h2> <p>' . $post_excerpt . '</p><a class="more-link" href="' . get_permalink($post_id ) . '">' .__('Read More', 'thstlang'). '</a>','<div class="audio_player au_oembed">' . $au_embedcode . '</div><!--audio_player-->'). '</div>';
					} elseif($audiourl != '') {
						$post_featured_media .= '<span class="mini-title">' . $pod_fh_heading . '</span>';
						$post_featured_media .= pod_explicit_post($post->ID);
						$post_featured_media .= '<h2><a href="' . get_permalink() .'">' . get_the_title() . '</a></h2>';										
											
						$post_featured_media .= '<div class="audio_player">' . do_shortcode('[audio src="' .$audiourl. '"][/audio]') . '</div><!--audio_player-->';	
						if ( $pod_featured_excerpt == true ) { 
							$post_featured_media .= '<div class="featured-excerpt ' . $post_format .'">';
								$post_featured_media .= get_the_excerpt();
								$post_featured_media .= '<a href="' . get_permalink() . '" class="more-link">';
									$post_featured_media .= __( ' Read More', 'thstlang');
									$post_featured_media .= '<span class="meta-nav"></span>
								</a>';
							$post_featured_media .= '</div>';
						}
					} elseif( is_array( $audioplists ) ) {
						$post_featured_media .= '<div class="row">' .pod_the_embed( '<span class="mini-title">' . $pod_fh_heading . '</span> ' . pod_explicit_post($post_id) .' <h2><a href="' . get_permalink($post_id ) . '">' . get_the_title($post_id) . '</a></h2> <p>' . $post_excerpt . '</p><a class="more-link" href="' . get_permalink($post_id ) . '">' .__('Read More', 'thstlang'). '</a>', do_shortcode('[playlist type="audio" ids="'.implode(',', array_keys($audioplists)).'"][/playlist]')). '</div>';
					} elseif ( $audioembedcode != '') {
						$post_featured_media .= '<div class="row">' .pod_the_embed( '<span class="mini-title">' . $pod_fh_heading . '</span> ' . pod_explicit_post($post_id) .' <h2><a href="' . get_permalink($post_id ) . '">' . get_the_title($post_id) . '</a></h2> <p>' . $post_excerpt . '</p><a class="more-link" href="' . get_permalink($post_id ) . '">' .__('Read More', 'thstlang'). '</a>','<div class="audio_player embed_code">' . $audioembedcode . '</div><!--audio_player-->'). '</div>';
					} else {
						$post_featured_media .= '';
					} 
				} elseif( $post_format == 'video' ) {
					$options = get_option('podcaster-theme');
					$pod_fh_heading = isset( $options['pod-featured-heading'] ) ? $options['pod-featured-heading'] : '';
					
					$excerpt_count = get_post_meta( $post_id, 'cmb_thst_featured_post_excerpt_count', true);
					$has_excerpt = get_post_meta( $post_id, 'cmb_thst_feature_post_excerpt', true);
					$post_object = get_post( $post_id );
					$fheader_type = pod_theme_option('pod-featured-header-type');

					if( $fheader_type == 'static' ) { 
						$post_excerpt = get_the_excerpt();
					} else {
						if( $has_excerpt == 'on') {
							if( $post_object->post_excerpt ) {
								$post_excerpt = $post_object->post_excerpt;
							} elseif( isset($excerpt_count) ) {
								$post_excerpt = pod_flexible_excerpt( $post_id, $excerpt_count );
							} else {
								$post_excerpt = '';
							}
						} else {
							$post_excerpt = '';
						}
					}
					

					$videoembed = get_post_meta( $post_id, 'cmb_thst_video_embed', true );
					$videoembedcode = get_post_meta( $post_id, 'cmb_thst_video_embed_code', true );
					$videourl = get_post_meta( $post_id, 'cmb_thst_video_url', true );
					$videocapt = get_post_meta( $post_id, 'cmb_thst_video_capt', true );
					$videoplists = get_post_meta( $post_id, 'cmb_thst_video_playlist', true );
					$videothumb = get_post_meta( $post_id, 'cmb_thst_video_thumb',true );
					$videoex = get_post_meta( $post_id, 'cmb_thst_video_explicit', true );
					
					$post_featured_media .= '<div class="row">';
					if( $videoembed != '' ) {
						$post_featured_media .= pod_the_embed('<span class="mini-title">' . $pod_fh_heading . '</span> ' . pod_explicit_post($post_id) .' <h2><a href="' . get_permalink($post_id ) . '">' . get_the_title($post_id) . '</a></h2> <p>' . $post_excerpt . '</p><a class="more-link" href="' . get_permalink($post_id ) . '">' .__('Read More', 'thstlang'). '</a>', '<div class="video_player">' . wp_oembed_get($videoembed) . '</div>');
					} elseif( $videourl != '' ){
						$post_featured_media .= pod_the_embed('<span class="mini-title">' . $pod_fh_heading . '</span> ' . pod_explicit_post($post_id) .' <h2><a href="' . get_permalink($post_id ) . '">' . get_the_title($post_id) . '</a></h2> <p>' . $post_excerpt . '</p><a class="more-link" href="' . get_permalink($post_id ) . '">' .__('Read More', 'thstlang'). '</a>', '<div class="video_player"> ' . do_shortcode('[video poster="' .$videothumb. '" src="' .$videourl. '"][/video]') .'</div>');
					} elseif( is_array( $videoplists ) ) {
						$post_featured_media .= pod_the_embed('<span class="mini-title">' . $pod_fh_heading . '</span> ' . pod_explicit_post($post_id) .' <h2><a href="' . get_permalink($post_id ) . '">' . get_the_title($post_id) . '</a></h2> <p>' . $post_excerpt . '</p><a class="more-link" href="' . get_permalink($post_id ) . '">' .__('Read More', 'thstlang'). '</a>', '<div class="video_player">' . do_shortcode('[playlist type="video" ids="'.implode(',', array_keys($videoplists)).'"][/playlist]') .'</div>');
					} elseif ( $videoembedcode != '') {
						$post_featured_media .= pod_the_embed('<span class="mini-title">' . $pod_fh_heading . '</span> ' . pod_explicit_post($post_id) .' <h2><a href="' . get_permalink($post_id ) . '">' . get_the_title($post_id) . '</a></h2> <p>' . $post_excerpt . '</p><a class="more-link" href="' . get_permalink($post_id ) . '">' .__('Read More', 'thstlang'). '</a>', '<div class="video_player">' . $videoembedcode .'</div>');
					} else {
						$post_featured_media .= '';
					}
					$post_featured_media .= '</div>';
				}
			}
		return $post_featured_media;
	}
}

/**
 * pod_featured_header_text()
 * Featured header when set to 'text'.
 *
 * @return string $output - Featured header.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_featured_header_text') ){
	function pod_featured_header_text() {
		$options = get_option('podcaster-theme');
		$pod_frontpage_bg_color = pod_theme_option('pod-fh-bg');
		$pod_frontpage_header  = pod_theme_option('pod-upload-frontpage-header');
		$pod_frontpage_header_url = isset( $pod_frontpage_header['url'] ) ? $pod_frontpage_header['url'] : '';
		! empty($pod_frontpage_header_url) ? $header_state = 'has-header' : $header_state = '';
		$pod_frontpage_header_par = pod_theme_option('pod-frontpage-header-par');
		$pod_frontpage_header_par == TRUE ? $parallax = 'data-stellar-background-ratio="0.5"' :	$parallax = '';
		$pod_fh_text = pod_theme_option('pod-featured-header-text');
		$pod_fh_text_url = pod_theme_option('pod-featured-header-text-url');
		$pod_frontpage_bg_style = pod_theme_option('pod-frontpage-bg-style');
		$pod_next_week = pod_theme_option('pod-frontpage-nextweek');
		$pod_sub_buttons = pod_theme_option('pod-subscribe-buttons');
	
		$output = '';
		$output .= '<div class="front-page-header text ' .$header_state. ' ' .pod_is_nav_sticky(). ' ' .pod_is_nav_transparent(). '" style="background-color:' .$pod_frontpage_bg_color.'; background-image:url(' .$pod_frontpage_header_url. '); ' .$pod_frontpage_bg_style. '"' .$parallax. '>
						<div class="inside">
							<div class="container">
								<div class="row">
									<div class="col-lg-12">	
										<div class="content-text">';
											if(! empty($pod_fh_text_url) ){
												$output .= '<a href="' .$pod_fh_text_url. '">';
											}
												if(! empty($pod_fh_text) ){
													$output .= '<h2>' .$pod_fh_text. '</a></h2>';
												}
											if(! empty($pod_fh_text_url) ){
												$output .= '</a>';
											}
										$output .='</div><!-- .content-text -->';
										if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons == true ) ) { 
										  	$output .= pod_next_week(); 
										}
									$output .= '</div>
								</div>
							</div>
						</div>
					</div>';
		return $output;		
	}
}

/**
 * pod_featured_header_static()
 * Featured header when set to 'static'.
 *
 * @return string $output - Featured header.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_featured_header_static') ){
	function pod_featured_header_static(){
		//For the custom loop
		$options = get_option('podcaster-theme');  
		$arch_category = isset( $options['pod-recordings-category'] ) ? $options['pod-recordings-category'] : '';
		$pod_frontpage_header  = isset( $options['pod-upload-frontpage-header'] ) ? $options['pod-upload-frontpage-header'] : '';
		$pod_frontpage_header_url = isset( $pod_frontpage_header['url'] ) ? $pod_frontpage_header['url'] : '';
		$pod_frontpage_bg_color = pod_theme_option('pod-fh-bg');
		$pod_frontpage_bg_style = isset( $options['pod-frontpage-bg-style'] ) ? $options['pod-frontpage-bg-style'] : '';
		$pod_page_image = isset( $options['pod-page-image'] ) ? $options['pod-page-image'] : '';
		$pod_featured_heading = isset( $options['pod-featured-heading'] ) ? $options['pod-featured-heading'] : '';
		$pod_frontpage_header_par = isset( $options['pod-frontpage-header-par'] ) ? $options['pod-frontpage-header-par'] : '';
		$pod_frontpage_header_par == true ? $parallax = 'data-stellar-background-ratio="0.5"' : $parallax = '';
		$pod_fh_heading = pod_theme_option('pod-featured-heading');
		$pod_next_week = isset( $options['pod-frontpage-nextweek'] ) ? $options['pod-frontpage-nextweek'] : '';
		$pod_sub_buttons = pod_theme_option('pod-subscribe-buttons');

		$plugin_inuse = get_pod_plugin_active();

		if( $plugin_inuse == 'ssp' ) {
			$args = array(
				'posts_per_page'   => 1,
				'cat'         => '',
				'post_type'        => 'podcast',
			);
		} else {
			$args = array(
				'posts_per_page'   => 1,
				'cat'         => $arch_category,
				'post_type'        => 'post',
			);
		}
		$the_query = new WP_Query( $args );
		$output = '';

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;

				$attachment_id = get_post_thumbnail_id( $post->ID );
				$image_attributes = wp_get_attachment_image_src( $attachment_id, 'original' ); // returns an array
				$thumb_back = $image_attributes[0];
				$post_format = get_post_format($post->ID);
				$post_title = get_the_title($post->ID);
				$post_permalink = get_permalink($post->ID);

				if ( $pod_frontpage_header_url != '' && $pod_page_image == false ) {
					$output .= '<div ' .$parallax. ' class="latest-episode front-header ' .pod_is_nav_transparent(). ' ' .pod_is_nav_sticky(). '" style="background-color:' .$pod_frontpage_bg_color.'; background-position:0 0; background-image: url(' .$pod_frontpage_header_url.'); ' .$pod_frontpage_bg_style. '">';
				} elseif( $pod_page_image == true && $thumb_back != '' ) {
					$output .= '<div ' .$parallax. ' class="latest-episode front-header ' .pod_is_nav_transparent(). ' ' .pod_is_nav_sticky(). '" style="background-color:' .$pod_frontpage_bg_color.'; background-position:center; background-image: url(' .$thumb_back. '); ' .$pod_frontpage_bg_style. '">';
				} else {
					$output .= '<div class="latest-episode ' .pod_is_nav_transparent(). ' ' .pod_is_nav_sticky(). '" style="background-color:' .$pod_frontpage_bg_color.';">';
				} 
				$output .= '<div id="loading_bg"></div>';
				if ( $pod_frontpage_header_url != '' || ( $pod_page_image == true && $thumb_back != '' ) ) { 
					$output .= '<div class="translucent">';
				}
				$output .= '<div class="container">
								<div class="row">
									<div class="col-lg-12">
								   		<div class="main-featured-post ' . $post_format . ' clearfix">';
									  	
									  		$output .= pod_featured_multimedia($post->ID);

									  	$output .= '</div><!-- .main-featured-posts -->';
									  	
									  	if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons == true ) ) { 
									  		$output .= pod_next_week(); 
									  	}
									  	$output .='</div><!-- .col -->';
									$output .='</div><!-- .row -->';
								$output .='</div><!-- .container -->';
					wp_reset_postdata();
					if ( $pod_frontpage_header_url != '' || ( $pod_page_image == true && $thumb_back != '' )  ) {
					$output .= '</div><!-- .translucent -->';
					}
				$output .='</div>';
			}
		}
		return $output;
	}
}

/**
 * pod_featured_header_static_posts()
 * Featured header when set to 'static (posts)'.
 *
 * @return string $output - Featured header.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_featured_header_static_posts') ){
	function pod_featured_header_static_posts($type = 'newest') {

		/* Theme Option Values */
		$options = get_option('podcaster-theme');
		$pod_nav_trans = pod_theme_option('pod-nav-bg');
		$pod_fh_type = pod_theme_option('pod-featured-header-type');
		$pod_fh_content = pod_theme_option('pod-featured-header-content');
		$pod_fh_heading = pod_theme_option('pod-featured-heading');
		$pod_fh_layout = pod_theme_option('pod-featured-header-layout');
		$pod_frontpage_bg_color = pod_theme_option('pod-fh-bg');

		if( $pod_fh_content == 'featured' ){
			$is_featured = array(
				array(
					'key' => 'cmb_thst_feature_post',
					'value' => 'on',
					)
				);
		} else {
			$is_featured = '';
		}
		$arch_category = isset( $options['pod-recordings-category'] ) ? $options['pod-recordings-category'] : '';
		$pod_next_week = isset( $options['pod-frontpage-nextweek'] ) ? $options['pod-frontpage-nextweek'] : '';
		$pod_sub_buttons = pod_theme_option('pod-subscribe-buttons');
		$pod_excerpt_type = isset( $options['pod-excerpts-type'] ) ? $options['pod-excerpts-type'] : '';
	
		$pod_next_week == 'hide' ? $pod_nextweek_state = 'nw-hidden' : $pod_nextweek_state = '';
		
		$plugin_inuse = get_pod_plugin_active();
		
		if( $plugin_inuse == 'ssp' ) {
			$args = array(
				'posts_per_page'   => 1,
				'cat'         => '',
				'post_type'        => 'podcast',
				'meta_query'	   => $is_featured,
			);
		} else {
			$args = array(
				'posts_per_page'   => 1,
				'cat'         => $arch_category,
				'post_type'        => 'post',
				'meta_query'	   => $is_featured,
			);
		}
		$the_query = new WP_Query( $args );
		$output = '';

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;

			/* Post Values */
			$post_format = get_post_format($post->ID);
			$post_title = get_the_title($post->ID);
			$post_permalink = get_permalink($post->ID);
			
			$is_featured = get_post_meta( $post->ID, 'cmb_thst_feature_post', true );
			$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			$header_img = get_post_meta( $post->ID, 'cmb_thst_feature_post_img', true );
			$bg_style = get_post_meta( $post->ID, 'cmb_thst_page_header_bgstyle', true);
			$has_excerpt = get_post_meta( $post->ID, 'cmb_thst_feature_post_excerpt', true);
			$excerpt_count = get_post_meta( $post->ID, 'cmb_thst_featured_post_excerpt_count', true);
			$post_align = get_post_meta( $post->ID, 'cmb_thst_feature_post_align', true);
			$is_parallax = get_post_meta( $post->ID, 'cmb_thst_feature_post_para', true);
			
			$is_parallax == 'on' ? $parallax = 'data-stellar-background-ratio="0.5"' : $parallax = '';
			$is_parallax == 'on' ? $has_parallax = 'parallax-on' : $has_parallax = 'parallax-off';

			if( $has_excerpt == 'on') {
				$post_object = get_post( $post->ID );
				if( $post_object->post_excerpt ) {
					$post_excerpt = $post_object->post_excerpt;
				} elseif( isset($excerpt_count) ) {
					$post_excerpt = pod_flexible_excerpt( $post->ID, $excerpt_count );
				} else {
					$post_excerpt = '';
				}
			} else {
				$post_excerpt = '';
			}

			if($header_img != '' ) {
				$header_img_url = $header_img;
			} else {
				$header_img_url = $featured_img[0];
			}
			! empty($header_img_url) ? $header_state = 'has-header' : $header_state = '';

			$output .= '<div class="front-page-header static ' . pod_is_nav_transparent() . ' ' . $type . ' ' . pod_is_nav_sticky() . ' ' . $header_state . ' ' . $pod_nextweek_state .'">
				<div class="background-image ' . $has_parallax . '" style="background-color:' .$pod_frontpage_bg_color.'; background-image: url(' . $header_img_url . '); ' . $bg_style . '" ' . $parallax . '>
					<div class="inside">
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<div class="text ' . $post_format . '" style="' . $post_align . '">';
										
										$output .= pod_featured_multimedia($post->ID);

									$output .= '</div><!-- .text -->';
									if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons == true ) ) { $output .= pod_next_week(); }
								$output .= '</div>
							</div>
						</div>
					</div><!-- .inside -->
				</div>
			</div>';
			}
		}
		wp_reset_postdata();

		return $output;
	}
}

/**
 * pod_featured_header_slideshow()
 * Featured header when set to 'slideshow'.
 *
 * @return string $output - Featured header.
 * @since Podcaster 1.5
 */
if( ! function_exists('pod_featured_header_slideshow') ){
	function pod_featured_header_slideshow() {
		/* Theme Option Values */
		$options = get_option('podcaster-theme');

		$pod_nav_trans = pod_theme_option('pod-nav-bg');
		$pod_fh_type = pod_theme_option('pod-featured-header-type');
		$pod_fh_content = pod_theme_option('pod-featured-header-content');
		$pod_fh_heading = pod_theme_option('pod-featured-heading');

		$pod_frontpage_bg_color = pod_theme_option('pod-fh-bg');

		if( $pod_fh_content == 'featured' ){
			$is_featured = array(
				array(
					'key' => 'cmb_thst_feature_post',
					'value' => 'on',
					)
				);
		} else {
			$is_featured = '';
		}
		$pod_fh_slides_amount = isset( $options['pod-featured-header-slides-amount'] ) ? $options['pod-featured-header-slides-amount'] : '';
		$arch_category = isset( $options['pod-recordings-category'] ) ? $options['pod-recordings-category'] : '';
		$pod_next_week = isset( $options['pod-frontpage-nextweek'] ) ? $options['pod-frontpage-nextweek'] : '';
		$pod_sub_buttons = pod_theme_option('pod-subscribe-buttons');
		$pod_excerpt_type = isset( $options['pod-excerpts-type'] ) ? $options['pod-excerpts-type'] : '';
	
		if( $pod_next_week == 'hide' ){
			$pod_nextweek_state = 'nw-hidden';
		} else {
			$pod_nextweek_state = '';
		}
		$pod_frontpage_header_par = isset( $options['pod-frontpage-header-par'] ) ? $options['pod-frontpage-header-par'] : '';
		if($pod_frontpage_header_par == TRUE){
				$parallax = 'data-stellar-background-ratio="0.5"';
			} else {
				$parallax = '';
		}
		$plugin_inuse = get_pod_plugin_active();
		
		if( $plugin_inuse == 'ssp' ) {
			$args = array(
				'posts_per_page'   => $pod_fh_slides_amount,
				'cat'         => '',
				'post_type'        => 'podcast',
				'meta_query'	   => $is_featured,
			);
		} else {
			$args = array(
			'posts_per_page'   => $pod_fh_slides_amount,
			'cat'         => $arch_category,
			'post_type'        => 'post',
			'meta_query'	   => $is_featured,
			);
		}
		$the_query = new WP_Query( $args );
		$output = '';

		if ( $the_query->have_posts() ) {
		$output .= '<div class="flexslider-container">';
		$output .= '<div id="loading_bg" class="hide_bg"></div>';
			$output .= '<div class="front-page-header slideshow loading_featured flexslider ' .pod_is_nav_transparent(). ' ' . pod_is_nav_sticky() . ' ' . $pod_nextweek_state .'">';
			$output .= '<div class="slides">';
			
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;

				/* Post Values */
				$post_format = get_post_format($post->ID);
				$post_title = get_the_title($post->ID);
				$is_featured = get_post_meta( $post->ID, 'cmb_thst_feature_post', true );
				$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
				$header_img = get_post_meta( $post->ID, 'cmb_thst_feature_post_img', true );
				$bg_style = get_post_meta( $post->ID, 'cmb_thst_page_header_bgstyle', true);
				$post_permalink = get_permalink($post->ID);
				$has_excerpt = get_post_meta( $post->ID, 'cmb_thst_feature_post_excerpt', true);			
				$excerpt_count = get_post_meta( $post->ID, 'cmb_thst_featured_post_excerpt_count', true);
				$post_align = get_post_meta( $post->ID, 'cmb_thst_feature_post_align', true);				
				$post_object = get_post( $post->ID );
				
				if( $has_excerpt == 'on') {
					if( $post_object->post_excerpt ) {
						$post_excerpt = $post_object->post_excerpt;
					} elseif( isset($excerpt_count) ) {
						$post_excerpt = pod_flexible_excerpt( $post->ID, $excerpt_count );
					} else {
						$post_excerpt = '';
					}
				} else {
					$post_excerpt = '';
				}

				if($header_img != '' ) {
					$header_img_url = $header_img;
				} else {
					$header_img_url = $featured_img[0];
				}

				if( ! empty($header_img_url) ) {
					$header_state = 'has-header';
				} else {
					$header_state = '';
				}


				$output .= '<div class="background-image slide ' . $header_state . '" style="background-color:' .$pod_frontpage_bg_color.'; background-image: url(' . $header_img_url . '); ' . $bg_style . '">
						<div class="inside">
							<div class="container">
								<div class="row">
									<div class="col-lg-12">
										<div class="text ' . $post_format . '" style="' . $post_align . '">';

										$output .= pod_featured_multimedia($post->ID);
										
										$output .= '</div><!-- .text -->';
										
									$output .= '</div>
								</div>
							</div>
						</div><!-- .inside -->
					</div>';			

				}
			$output .= '</div><!-- .slides -->';
			$output .= '</div>';

			if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons ) ) { 
				$output .= pod_next_week(); 
			}
		$output .= '</div>';
		} else {
			$output .= '<div class="empty-slideshow container">';
			$output .= '<div class="row">';
			$output .= '<div class="col-lg-12">';
			$output .= '<div class="placeholder inside">';
			$output .= '<p>'. __('Please mark your post(s) as featured for them to appear here.', 'thstlang') .'</p>';
			$output .= '</div>';
			if( function_exists('pod_next_week') && ( $pod_next_week == 'show' || $pod_sub_buttons ) ) { 
				$output .= pod_next_week(); 
			}
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
		}
		wp_reset_postdata();
		return $output;
	}
}