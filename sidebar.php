<?php
/**
 * This file is used for your your sidebar.
 *
 * @package Podcaster
 * @since 1.0
 */
 ?>
 
 <div class="sidebar">
 <?php 
 	if( is_front_page() && is_home() ) {
 		if ( is_active_sidebar( 'sidebar_blog' ) ) { 
			dynamic_sidebar( 'sidebar_blog' );
		}
 	} elseif( is_front_page() ) {
 		if ( is_active_sidebar( 'sidebar_front' ) ) { 
			dynamic_sidebar( 'sidebar_front' );
		}
 	} elseif ( is_home() || is_archive() || is_search() ){
	 	if ( is_active_sidebar( 'sidebar_blog' ) ) { 
			dynamic_sidebar( 'sidebar_blog' );
		}
	} elseif( is_page() ) {
		if ( is_active_sidebar( 'sidebar_page' ) ) { 
			dynamic_sidebar( 'sidebar_page' );
		}
	} elseif ( is_single() ){
		if ( is_active_sidebar( 'sidebar_single' ) ) { 
			dynamic_sidebar( 'sidebar_single' );
		}
	} 
 ?>
 </div>