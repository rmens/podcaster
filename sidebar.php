<?php
/**
 * This file is used for your your sidebar.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
 ?>
 
 <div class="sidebar">
 <?php 
 	if ( is_home() || is_archive() || is_search() ){
	 	if ( is_active_sidebar( 'sidebar_blog' ) ) { 
			dynamic_sidebar( 'sidebar_blog' );
		} else { 
			echo '<ul class="placeholder">This is your blog widget area. Please go to <a href="'. admin_url( 'widgets.php', 'admin' ). '">Appearance > Widgets</a> to add new widgets.</ul>';
		} 
	} elseif( is_page() ) {
		if ( is_active_sidebar( 'sidebar_page' ) ) { 
			dynamic_sidebar( 'sidebar_page' );
		} else { 
			echo '<ul class="placeholder">This is your page widget area. Please go to <a href="'. admin_url( 'widgets.php', 'admin' ). '">Appearance > Widgets</a> to add new widgets.</ul>';
		}
	} elseif ( is_single() ){
		if ( is_active_sidebar( 'sidebar_single' ) ) { 
			dynamic_sidebar( 'sidebar_single' );
		} else { 
			echo '<ul class="placeholder">This is your single post widget area. Please go to <a href="'. admin_url( 'widgets.php', 'admin' ). '">Appearance > Widgets</a> to add new widgets.</ul>';
		}
	} 
 ?>
 </div>