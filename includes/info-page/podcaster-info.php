<?php
/**
 * Settings Page, Podcaster Updates & Information
 *
 * Creates an info page that is loaded on install or update filled with information on new information, features and updates.
 *
 *
 * @package WordPress
 * @subpackage Podcaster
 * @since 1.5
 */

add_action( 'init', 'pod_info_admin_init' );
add_action( 'admin_menu', 'pod_info_settings_page_init' );

function pod_info_admin_init() {
	$settings = get_option( "pod_info_theme_settings" );
	if ( empty( $settings ) ) {
		$settings = array(
			'pod_info_intro' => 'Some intro text for the home page',
			'pod_info_tag_class' => false,
			'pod_info_ga' => false,

			'pod_info_docs' => false,
			'pod_info_support' => false,
			'pod_info_chlog' => false

		);
		add_option( "pod_info_theme_settings", $settings, '', 'yes' );
	}	
}

function pod_info_settings_page_init() {
	$theme_data = wp_get_theme();
	$settings_page = add_theme_page( $theme_data->get( 'Name' ). ' Info', $theme_data->get( 'Name' ). ' Info', 'edit_theme_options', 'theme-information', 'pod_info_settings_page' );
	add_action( "load-{$settings_page}", 'pod_info_load_settings_page' );
}

function pod_info_load_settings_page() {
	$_POST["pod-info-settings-submit"] = '';
	if ( $_POST["pod-info-settings-submit"] == 'Y' ) {
		check_admin_referer( "pod-info-settings-page" );
		pod_info_save_theme_settings();
		$url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
		wp_redirect(admin_url('themes.php?page=theme-information&'.$url_parameters));
		exit;
	}
}

function pod_info_save_theme_settings() {
	global $pagenow;
	$settings = get_option( "pod_info_theme_settings" );
	
	if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-information' ){ 
		if ( isset ( $_GET['tab'] ) )
	        $tab = $_GET['tab']; 
	    else
	        $tab = 'whatsnew'; 

	    switch ( $tab ){ 
	        case 'documentation' :
				$settings['pod_info_docs']  = $_POST['pod_info_docs'];
			break; 
	        case 'support' : 
				$settings['pod_info_support']  = $_POST['pod_info_support'];
			break;
			case 'changelog' : 
				$settings['pod_info_chlog']  = $_POST['pod_info_chlog'];
			break;
			case 'whatsnew' : 
				$settings['pod_info_intro']	  = $_POST['pod_info_intro'];
			break;
	    }
	}
	
	if( !current_user_can( 'unfiltered_html' ) ){
		if ( $settings['pod_info_ga']  )
			$settings['pod_info_ga'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['pod_info_ga'] ) ) );
		if ( $settings['pod_info_intro'] )
			$settings['pod_info_intro'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['pod_info_intro'] ) ) );
	}

	$updated = update_option( "pod_info_theme_settings", $settings );
}

function pod_info_admin_tabs( $current = 'whatsnew' ) { 
    $tabs = array( 'whatsnew' => 'What\'s New', 'documentation' => 'Documentation', 'support' => 'Support', 'changelog' => 'Changelog' ); 
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=theme-information&tab=$tab'>$name</a>";
        
    }
    echo '</h2>';
}

function pod_info_settings_page_css($hook) {
    if ( 'appearance_page_theme-information' != $hook ) {
        return;
    }
	wp_enqueue_style( 'thst-info-page', get_template_directory_uri() . '/includes/info-page/style.css' );
}
add_action( 'admin_enqueue_scripts', 'pod_info_settings_page_css' );


function pod_info_settings_page() {
	global $pagenow;
	$settings = get_option( "pod_info_theme_settings" );
	$theme_data = wp_get_theme();
	$custom_page_dir = get_template_directory_uri() . '/includes/info-page/img';
	?>
	
	<div class="wrap">
		<div id="wpbody" role="main">
			<div id="wpbody-content" tabindex="0" aria-label="Main content">
				<div class="wrap about-wrap">
					<h1>Welcome to <?php echo $theme_data->get( 'Name' ); ?> <?php echo $theme_data->get( 'Version' ); ?></h1>
					<div class="about-text">Thank you for updating! Take a look at the newest features and updates.</div>
					<div class="wp-badge">Version <?php echo $theme_data->get( 'Version' ); ?></div>

					<?php
						$_GET['updated'] = '';
						if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Theme Settings updated.</p></div>';
						
						if ( isset ( $_GET['tab'] ) ) pod_info_admin_tabs($_GET['tab']); else pod_info_admin_tabs('whatsnew');
					?>
					<div class="sub-tabs">
						<?php
						wp_nonce_field( "pod-info-settings-page" ); 
							
						if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-information' ){ 
							
							if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
							else $tab = 'whatsnew'; 
								
							echo '<table class="form-table">';
							switch ( $tab ){
								case 'documentation' :
									?>
									<div class="feature-section one-col">
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/docs.png" />
											</div>
											<h3>Documentation</h3>
											<p>A documentation folder is included in your theme files from Themeforest. Simply look for the folder called <code>/documentation</code>. You can also view the online documneation here: <a href="http://themestation.co/documentation/podcaster/">themestation.co/documentation/podcaster/</a></p>
										</div>
									</div>
									<?php
								break; 
								case 'support' : 
									?>
									<div class="feature-section one-col">
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/support-banner.jpg" />
											</div>
											<h3>New Support System</h3>
											<p>Sign-up for the new ticket stytem and get tailor-made support. We have also adjusted our support terms to fit the new terms by Envato. <a href="http://themestation.co/support">Click here</a> to find out more.  </p>
										</div>
									</div>
									<?php
								break;
								case 'whatsnew' : 
									?>
									<div class="feature-section one-col no-top-margin">
										<div class="col">
											<h3>Maintenance Update</h3>
											<p>Version 1.5.4 addressed three bugs. Please <a href="?page=theme-information&tab=changelog">click here</a> to see the changelog.</p>
										</div>
									</div>
									<div class="feature-section two-col">
										<div class="col" style="margin-top:0">
											<h3>Rate</h3>
											<p>Support Podcaster and give a five star rating! Click <a href="http://themeforest.net/item/podcaster-multimedia-wordpress-theme/6804946?ref=Themestation">here</a> to rate.</p>
										</div>
										<div class="col" style="margin-top:0">
											<h3>Showcase</h3>
											<p>Allow us to feature your website created with Podcaster. Submit your site <a href="http://www.themestation.co/showcase">here</a>.</p>
										</div>
									</div>

									<div class="feature-section two-col">
										<h2>New Features in Version 1.5</h2>
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/new-features-header.png" />
											</div>
											<h3>Improved Header</h3>
											<p>Podcaster's featured header as been updated to include other settings including an image only header and or a slideshow.</p>
										</div>
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/new-features-presets.png" />
											</div>
											<h3>Preset Templates</h3>
											<p>Set up your website with just a few clicks. Preset templates have been added to make sure you are just a click a way from an entirely different style.</p>
										</div>
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/new-features-colors.png" />
											</div>
											<h3>More Color Settings</h3>
											<p>More color settings have been added to make customization easier and code-less. Customize menus, links, accent colors and more!</p>
										</div>
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/featured-posts.png" />
											</div>
											<h3>Featured Posts</h3>
											<p>Mark your post as featured, so choose which posts will be displayed on the front page. Upload header images, set excerpts and more!</p>
										</div>
									</div><!-- .feature-section -->

									<div class="feature-section one-col">
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/support-banner.jpg" />
											</div>
											<h3>New Support System</h3>
											<p>Sign-up for the new ticket stytem and get tailor-made support. We have also adjusted our support terms to fit the new terms by Envato. <a href="http://themestation.co/support">Click here</a> to find out more.  </p>
										</div>
									</div>

									<div class="feature-section three-col">
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/demo-data.png" />
											</div>
											<h3>Demo Data</h3>
											<p>Demo data is now provided with your theme. Import posts, pages and images with a few clicks and set up your site in no time.</p>
										</div>
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/translation-ready.png" />
											</div>
											<h3>Translation-Ready</h3>
											<p>Updated translation files have been included in Podcaster 1.5. Translate your theme to your language in no time.</p>
										</div>
										<div class="col">
											<div class="media-container">
												<img src="<?php echo $custom_page_dir;?>/rtl-support.png" />
											</div>
											<h3>Right-to-Left reading</h3>
											<p>Right to left reading can now be activated in the theme options. One click and your website with re-align to support rtl.</p>
										</div>
									</div><!-- .feature-section -->
									<?php
								break;
								case 'changelog' : 
									?>
									<div class="feature-section">
										<ul id="changelog">
											<li class="first"><h2>1.5.5</h2><span class="date">(16th November 2015)</span>
												<ul>
													<li>
														<span class="label fix">Fix</span> Excerpt output
														<div class="file"><ul>
															<li>featued-header.php</li>
															<li><span class="root">post/</span>format-link.php</li>
															<li><span class="root">post/</span>format-image.php</li>
														</ul></div>
													</li>
													<li><span class="label fix">Fix</span> Theme Option Config File (500 Internal Server Error)
														<div class="file"><ul>
															<li>options-config.php</li>
														</ul></div>
													</li>
													<li>
														<span class="label minor fix">Minor Fix</span>Overlapping download link
														<div class="file"><ul><li>single.php</li></ul></div>
													</li>
												</ul>
											</li>
											<li class="first"><h2>1.5.3</h2><span class="date">(27th Octorber 2015)</span>
												<ul>
													<li>
														<span class="label minor fix">Minor Fix</span> Force Excerpts in blog displaying in single view
														<div class="file"><ul>
															<li><span class="root">post/</span>format.php</li>
															<li><span class="root">post/</span>format-audio.php</li>
															<li><span class="root">post/</span>format-video.php</li>
															<li><span class="root">post/</span>format-status.php</li>
															<li><span class="root">post/</span>format-quote.php</li>
															<li><span class="root">post/</span>format-link.php</li>
															<li><span class="root">post/</span>format-image.php</li>
															<li><span class="root">post/</span>format-gallery.php</li>
															<li><span class="root">post/</span>format-chat.php</li>
														</ul></div>
													</li>
												</ul>
											</li>
											<li class="first"><h2>1.5.2</h2><span class="date">(25th Octorber 2015)</span>
												<ul>
													<li>
														<span class="label new">New</span> Force Excerpts in blog
														<div class="file"><ul><li><span class="root">post/</span>postfooter.php</li></ul></div>
													</li>
													<li>
														<span class="label improved">Improved</span> Demo Content improved
														<div class="file"><ul><li>podcaster-wordpress.xml</li></ul></div>
													</li>
													<li>
														<span class="label improved">Improved</span> Default template preset added
														<div class="file"><ul><li>options-config.php</li></ul></div>
													</li>
													<li>
														<span class="label minor fix">Minor Fix</span>Irregular scrolling on mobile fixed
														<div class="file"><ul><li>style.css</li></ul></div>
													</li>
													<li>
														<span class="label minor fix">Minor Fix</span>Hover effects on front page for mobile made clickable
														<div class="file"><ul><li>style.css</li></ul></div>
													</li>
													<li>
														<span class="label minor fix">Minor Fix</span>Archive button on front page fixed
														<div class="file"><ul><li>page-frontpage.php</li></ul></div>
													</li>
													<li>
														<span class="label minor fix">Minor Fix</span>Contact 7 form on mobile fixed
														<div class="file"><ul><li>style.css</li></ul></div>
													</li>
												</ul>
											</li>
											<li class="first"><h2>1.5.1</h2><span class="date">(23rd September 2015)</span>
												<ul>
													<li>
														<span class="label minor fix">Minor Fix</span> Background for audio players on single post pages fixed
														<div class="file">
															<ul>
																<li>style.css</li>
															</ul>
														</div>
													</li>
												</ul>
											</li>
											<li class="first"><h2>1.5</h2><span class="date">(22nd September 2015)</span>
												<ul>
													<li>
														<span class="label new">New</span> Four presets added to the theme options for faster and easier setup.
														<div class="file">
															<ul>
																<li>options-config.php</li>
															</ul>
														</div>
													</li>
													<li>
														<span class="label new">New</span> Social media button now supported in header.
														<div class="file">
															<ul>
																<li>navigation.php</li>
															</ul>
														</div>
													</li>
													<li>
														<span class="label new">New</span> Right to left reading now supported.
														<div class="file">
															<ul>
																<li><span class="root">css/</span>rtl.css</li>
															</ul>
														</div>
													</li>
													<li>
														<span class="label improved">Improved</span> Front page header now supports featured posts in static and slideshow mode. Feature posts to diplay them on the front page.
														<div class="file">
															<ul>
																<li><span class="root">page/</span>page-frontpage.php</li>
																<li><span class="root">functions/</span>featured-header.php</li>
															</ul>
														</div>
													</li>
													<li>
														<span class="label improved">Improved</span> More color options.
														<div class="file">
															<ul>
																<li><span class="root">css/</span>style.php</li>
															</ul>
														</div>
													</li>
													<li>
														<span class="label improved">Improved</span> Style for featured gallery in gallery post format now can be set individually.
														<div class="file">
															<ul>
																<li><span class="root">post/</span>format-gallery.php</li>
															</ul>
														</div>
													</li>
													<li>
														<span class="label improved">Improved</span> More font options added.
														<div class="file">
															<ul>
																<li><span class="root">css/</span>options-config.php</li>
															</ul>
														</div>
													</li>
													<li>
														<span class="label fix minor">Minor Fix</span> Access to all media files if download is activated on playlist.
														<div class="file">
															<ul>
																<li><span class="root">post/</span>format-audio.php</li>
																<li><span class="root">post/</span>format-video.php</li>
															</ul>
														</div>
													</li>
													<li>
														<span class="label fix minor">Minor Fix</span> Widget class bug fixed.
														<div class="file">
															<ul>
																<li><span class="root">widgets/</span>widget-highlightcategory.php</li>
																<li><span class="root">widgets/</span>widget-recentcomments.php</li>
																<li><span class="root">widgets/</span>widget-recentposts.php</li>
															</ul>
														</div>
													</li>
												</ul>						
											</li>
											<li class="first"><h2>1.4.9</h2><span class="date">(12th May 2015)</span>
												<ul>
													<li><span class="label update">Update</span> New Version of Theme Station Feed Plugin included</li>
													<li><span class="label update">Update</span> TGM Plugin Activator</li>
													<li><span class="label fix">Fix</span> TGM Plugin Activator 'No valid header'</li>
												</ul>						
											</li>
											<li class="first"><h2>1.4.8</h2><span class="date">(24th April 2015)</span>
												<ul>
													<li><span class="label fix minor">Minor Fix</span> <code>get_avatar_url()</code> fix</li>
													<li><span class="label fix">Fix</span> TGM-Plugin-Activation security update</li>
												</ul>
											</li>
											<li class="first"><h2>1.4.7</h2><span class="date">(15th April 2015)</span>
												<ul>
													<li><span class="label fix minor">Minor Fix</span> Custom Metaboxes update</li>
												</ul>
											</li>
											<li class="first"><h2>1.4.6</h2><span class="date">(9th April 2015)</span>
												<ul>
													<li><span class="label new">New</span> Video post backgrounds on single page views</li>
													<li><span class="label fix minor">Minor Fix</span> Footer background color</li>
													<li><span class="label fix minor">Minor Fix</span> Video post excerpts on front pages</li>
												</ul>
											</li>
											<li class="first"><h2>1.4.5</h2><span class="date">(15th March 2015)</span>
												<ul>
													<li><span class="label new">New</span> Responsive Menu options (drop-down or toggle)</li>
												</ul>
											</li>
											<li class="first"><h2>1.4.4</h2><span class="date">(12th March 2015)</span>
												<ul>
													<li><span class="label new">New</span> Schedule Posts to appear in the "Next time" area</li>
													<li><span class="label new">New</span> Editible copyright text in the footer</li>
													<li><span class="label fix">Fix</span> Drop-down menu (3rd level, 4th level ...)</li>
													<li><span class="label fix">Fix</span> Footer menu color</li>
												</ul>
											</li>
											<li class="first"><h2>1.4.3</h2><span class="date">(1st March 2015)</span>
												<ul>
													<li><span class="label fix">Fix</span> Size of logo in responsive settings</li>
													<li><span class="label fix">Fix</span> Blog page header when set to transparent navigation</li>
													<li><span class="label fix">Fix</span> Seach page bug</li>
												</ul>
											</li>
											<li class="first"><h2>1.4.2</h2><span class="date">(18th February 2015)</span>
												<ul>
													<li><span class="label new">New</span> Customizable text for archive button on the front page</li>
													<li><span class="label fix">Fix</span> Social Media email</li>
													<li><span class="label fix">Fix</span> <code>the_permalink()</code> on front page </li>
												</ul>
											</li>
											<li class="first"><h2>1.4.1</h2><span class="date">(9th February 2015)</span>
												<ul>
													<li><span class="label fix">Fix</span> in_array() error</li>
													<li><span class="label fix">Fix</span> the_powerpress_content() error</li>
													<li><span class="label fix">Fix</span> black screen on front page</li>
												</ul>
											</li>
											<li class="first"><h2>1.4.0</h2><span class="date">(6th February 2015)</span>
												<ul>
													<li><span class="label fix minor">Minor Fix</span> PowerPress single audio player error</li>
												</ul>
											</li>
											<li class="first"><h2>1.3.9</h2><span class="date">(5th February 2015)</span>
												<ul>
													<li><span class="label fix minor">Fix</span> Modify header information bug</li>
													<li><span class="label fix minor">Fix</span> Color options &amp; dynamic stylesheet</li>
												</ul>
											</li>
											<li class="first"><h2>1.3.8</h2><span class="date">(4th February 2015)</span>
												<ul>
													<li><span class="label new">New</span> More color settings, including transparent headers</li>
													<li><span class="label new">New</span> Display all your podcast posts on one archive page</li>
													<li><span class="label improved">Improved</span> Theme options simplified and streamlined</li>
													<li><span class="label improved">Improved</span> Now compatible with Seriously Simple Podcasting 1.8+</li>
													<li><span class="label improved">Improved</span> Now supports Blubrry Power Press</li>
													<li><span class="label fix">Fix</span> iPhone loading screen bug</li>
													<li><span class="label fix">Fix</span> Front page image error</li>
												</ul>
											</li>
											<li class="first"><h2>1.3.7</h2><span class="date">(6th January 2015)</span>
												<ul>
													<li><span class="label new">New</span> Manage your avatars in the theme options</li>
													<li><span class="label new">New</span> Single pages now also change to display sidebars left or right along with the blog</li>
													<li><span class="label new">New</span> Switch to Envato Toolkit for theme updates</li>
													<li><span class="label fix minor">Minor fix</span> Titles in single view</li>
													<li><span class="label fix minor">Minor fix</span> Source in audio player fix</li>
													<li><span class="label fix minor">Minor fix</span> avatars</li>
												</ul>
											</li>
											<li class="first"><h2>1.3.6</h2><span class="date">(21st December 2014)</span>
												<ul>
													<li><span class="label new">New</span> Explicit Posts now marked</li>
													<li><span class="label fix">Fix</span> WP 4.1 Player Fix</li>
													<li><span class="label fix minor">Minor fix</span> avatars</li>
												</ul>
											</li>
											<li class="first"><h2>1.3.5</h2><span class="date">(25th September 2014)</span>
												<ul>
												    <li><span class="label new">New</span> Retina logos now supported</li>
												    <li><span class="label new">New</span> Podcast archive can be displayed as list</li>
												    <li><span class="label new">New</span> Layout options for blog page: sidebar left, sidebar right, full width</li>
												    <li><span class="label new">New</span> Subscribe buttons have been added to the single post pages</li>
												    <li><span class="label new">New</span> Image header on front page can be set by featured image on page</li>
												    <li><span class="label new">New</span> Embed code can now be used in audio and video posts (inculding old SoundCloud player)</li>
												    <li><span class="label new">New</span> Excerpts can now be activated to appear below audio player on the front page</li>
												    <li><span class="label new">New</span> Embed code can now be used in audio and video posts (inculding old SoundCloud player)</li>
												    <li><span class="label fix">Fix</span> controls.svg deactivated</li>
												</ul>
											</li>
											<li class="first"><h2>1.3.4</h2><span class="date">(29th August 2014)</span>
												<ul>
													<li><span class="label fix">Fix</span> Auto-update bug fixed</li>
													<li><span class="label fix minor">Minor fix</span> Main page gap on player fixed</li>
													<li><span class="label fix minor">Minor fix</span> Buttons on main page aligned properly</li>
													<li><span class="label fix minor">Minor fix</span> Turned off comments on pages do not display message anymore.</li>
												</ul>
											</li>
											<li class="first"><h2>1.3.3</h2><span class="date">(27th June 2014)</span>
												<ul>
													<li><span class="label update">Update</span>Podcasting feed has now been moved into seperate plugin. Please read documentation for more information</li>
													<li><span class="label new">New</span> Automatic Theme Updates</li>
												</ul>
											</li>
											<li class="first"><h2>1.3.2</h2><span class="date">(18th June 2014)</span>
												<ul>
													<li><span class="label fix minor">Minor fix</span> Image post format</li>
												</ul>
											</li>
											<li class="first"><h2>1.3.1</h2><span class="date">(16th June 2014)</span>
												<ul>
													<li><span class="label fix minor">Minor Fix</span> Buttons in breakpoints</li>
													<li><span class="label update">Update</span> Podcasting RSS Feed function can now be found in the Theme Station Podcasting Feed Plugin. Download at http://www.themestation.co</li>
												</ul>
											</li>
											<li class="first"><h2>1.3</h2><span class="date">(30th April 2014)</span>
												<ul>
													<li><span class="label new">New</span> Audio Playlist Support</li>
													<li><span class="label new">New</span> Video Playlist Support</li>
													<li><span class="label new">New</span> Switch between static excerpts and post excerpts</li>
													<li><span class="label new">New</span> Switch off/on podcast RSS feed</li>
													<li><span class="label fix">Fix</span> Seriously Simple Podcasting front page support</li>
												</ul>
											</li>
											<li class="first"><h2>1.2</h2><span class="date">(9th April 2014)</span>
												<ul>
													<li><span class="label new">New</span> iTunes compatible feed added!</li>
													<li><span class="label new">New</span> New loading graphics</li>
													<li><span class="label new">New</span> Language files added</li>
													<li><span class="label fix">Fix</span> download button for videos</li>
												</ul>
											</li>
											<li class="first"><h2>1.1</h2><span class="date">(21st March 2014)</span>
												<ul>
													<li><span class="label new">New</span> Seriously Simple Podcasting Plugin Support added!</li>
													<li><span class="label new">New</span> Social Icons</li>
													<li><span class="label fix">Fix</span> oEmbed is now working</li>
												</ul>
											</li>
											<li class="first"><h2>1.01</h2><span class="date">(21st February 2014)</span>
												<ul>
													<li><span class="label fix minor">Minor Fix</span> Minor fix to the front page header image</li>
												</ul>
											</li>
											<li class="first"><h2>1.0</h2><span class="date">(7th february 2014)</span>
												<ul>
													<li><span class="label release">Release</span> Initial Release!</li>
												</ul>
											</li>
										</ul>
									</div>
									<?php
								break;
							}
							echo '</table>';
						}
						?>
					</div><!-- .sub-tabs -->
					<p><?php echo $theme_data['Name'] ?> theme by <a href="http://themestation.co/">themestation.co</a></p>
					
				</div>
			</div>
		</div>
	</div>
<?php
}


?>