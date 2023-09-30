<?php 

/**
 * pod_get_ssp_series_cats()
 * Seriously Simple Podcasting terms and categories for a given post or podcast post.
 *
 * @return string $o - List of all terms and categories for a post
 * @since Podcaster 1.8.5
 */
if( ! function_exists( 'pod_get_ssp_series_cats' ) ) {
	function pod_get_ssp_series_cats( $post_id, $before='', $after='', $sep='', $link=false ) {

		$siteurl = get_site_url();

		$terms = get_the_terms( $post_id , 'category' );
		$terms = is_array( $terms ) ? $terms : array();
		$count = count($terms);

		$ssp_terms = get_the_terms( $post_id , 'series' );
		$ssp_terms = is_array( $ssp_terms ) ? $ssp_terms : array();
		$ssp_count = count($ssp_terms);

		$all_terms = array_merge($ssp_terms, $terms);
		$all_count = count($all_terms);
		
		$o ='';

		$o .= $before;
		if( ! empty( $ssp_terms ) && has_category() ) {

			foreach( $all_terms as $a_term ) {
				$a_id = $a_term->term_id;
				$all = $a_term->name;

				if( $link == true ) {
					$o .= '<a href="' . $siteurl . '/' . $a_term->taxonomy . '/' . $a_term->slug . '">';
				}

				$o .= $all;
				
				if( $link == true ) {
					$o .= '</a>';
				}

				if (--$all_count <= 0) {
			        break;
			    }

				$o .= $sep;
			}
		
		} elseif( ! empty( $ssp_terms ) ) {

			foreach( $ssp_terms as $ssp_term ) {
				$series_id = $ssp_term->term_id;
				$series = $ssp_term->name;

				if( $link == true ) {
					$o .= '<a href="' . $siteurl . '/' . $ssp_term->taxonomy . '/' . $ssp_term->slug . '">';
				}

				$o .= $series;
				
				if( $link == true ) {
					$o .= '</a>';
				}

				if (--$ssp_count <= 0) {
			        break;
			    }

				$o .= $sep;
			}

		} elseif( ! empty( $terms ) ) {

			foreach( $terms as $term ) {
				$cat_id = $term->term_id;
				$cat = $term->name;

				if( $link == true ) {
					$o .= '<a href="' . $siteurl . '/' . $term->taxonomy . '/' . $term->slug . '">';
				}

				$o .= $cat;
				
				if( $link == true ) {
					$o .= '</a>';
				}

				if (--$count <= 0) {
			        break;
			    }

				$o .= $sep;
			}

		} else {
			$cat = "";
		}

		$o .= $after;

		return $o;
	}
}


/**
 * pod_ssp_active_cats()
 * Seriously Simple Podcasting categories selected to be featured with the theme options.
 *
 * @return array $output - Array containing all term_ids.
 * @since Podcaster 1.5.9
 */
if( ! function_exists( 'pod_ssp_active_cats' ) ) {
	function pod_ssp_active_cats( $cat_type ) {

		$output = '';
		if( $cat_type == "ssp" ) {
			
			$ssp_cat = pod_theme_option('pod-recordings-category-ssp', '');

			if ( $ssp_cat == '' ) {
				$ssp_cat_terms = get_terms( array(
					'taxonomy' => 'series'
				) );

				$ssp_cat = array();
				if( ! empty( $ssp_cat ) ) {
					foreach ( $ssp_cat_terms as $ssp_term ) {
						$ssp_cat[] = $ssp_term->term_id;
					}
				}
			}
			$output = $ssp_cat;
		} elseif( $cat_type == "default" ) {

			$pod_cat = pod_theme_option('pod-recordings-category', '');
			$pod_cat = ( $pod_cat != '' ) ? (int) $pod_cat : '';
			
			if( $pod_cat == '' ) {
				$arch_cat_terms = get_terms( array(
					'taxonomy' => 'category'
				) );

				$pod_cat = array();
				foreach ( $arch_cat_terms as $arch_term ) {
					   $pod_cat[] = $arch_term->term_id;
				}
			}
			$output = $pod_cat;
		}

		return $output;
	}
}

/**
 * pod_ssp_get_format()
 * Seriously Simple Podcasting episode type ot post formats depending on post type.
 *
 * @return array $output - The episode type/post format
 * @since Podcaster 1.8.5
 */
if( ! function_exists( 'pod_ssp_get_format' ) ) {
	function pod_ssp_get_format( $post_id='' ) {
		$post_type = get_post_type( $post_id );
		$ep_type = get_post_meta( $post_id, 'episode_type', true );

		if( $post_type == "podcast" ) {

			return $ep_type;

		} else {

			return get_post_format( $post_id );

		}
	}
}

if( ! function_exists( 'pod_ssp_get_media_file' ) ) {
	function pod_ssp_get_media_file( $post_id='' ) {

		$enclosure_file = get_post_meta( $post_id , 'enclosure' , true );
		$audio_file = get_post_meta( $post_id , 'audio_file' , true );
		$file = '';

		/* Gets the audio file for SSP */
		if( $audio_file != '' ) {
			if( strpos( $audio_file, "\n" ) !== FALSE ) {
				$audio_file = '';
			}
			$file = $audio_file;
		} elseif( $enclosure_file != '' ) {
			if( strpos( $enclosure_file, "\n" ) !== FALSE ) {
				$enclosure_file = '';
			}
			$file = $enclosure_file;
		} else {
			$file = '';
		}

		return $file;
	}
}