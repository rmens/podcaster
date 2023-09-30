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



 
/**
 * Initiate and add the page to the Dashboard Menu.
 */
if( ! function_exists( 'pod_info_settings_page_init' ) ) {
	function pod_info_settings_page_init() {
		$theme_data = wp_get_theme();

		$settings_page = add_menu_page( 
			'About', 
			'Podcaster', 
			'edit_theme_options', 
			'pod-theme-options',
			'pod_info_settings_page'
		);
	}
}
// add_action() $priority set to 9 to make sure demo install link is added before.
add_action( 'admin_menu', 'pod_info_settings_page_init', 9 );


/**
 * Load the about page.
 */
if( ! function_exists( 'pod_info_load_settings_page' ) ){
	function pod_info_load_settings_page() {
		$_POST["pod-info-settings-submit"] = '';

		if ( $_POST["pod-info-settings-submit"] == 'Y' ) {
			check_admin_referer( "pod-info-settings-page" );
			
			pod_info_save_theme_settings();

			$url_parameters = isset( $_GET['tab'] ) ? 'updated=true&tab=' . $_GET['tab'] : 'updated=true';
			wp_redirect( admin_url( 'admin.php?page=pod-theme-options&' . $url_parameters ) );
			exit;
		}
	}
}


/**
 * Manage tabs, legacy.
 */
if( ! function_exists( 'pod_info_admin_tabs_legacy' ) ){
	function pod_info_admin_tabs_legacy( $current = 'whatsnew' ) {
	    $tabs = array(
	    	'whatsnew' => __('What\'s New', 'podcaster')
	    );
	    $links = array();
	    echo '<div id="icon-themes" class="icon32"><br></div>';
	    echo '<h2 class="nav-tab-wrapper">';
	    foreach( $tabs as $tab => $name ){
	        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
	        echo "<a class='nav-tab$class' href='?page=pod-theme-options&tab=$tab'>$name</a>";
	    }
	    echo '</h2>';
	}
}


/**
 * Create navigation menu/tabs and manage them.
 */
if( ! function_exists( 'pod_info_admin_tabs' ) ){
	function pod_info_admin_tabs( $current = 'about' ) {
	    $tabs = array(
	    	'about' => __('About', 'podcaster'),
	    	'getting-started' => __('Getting Started', 'podcaster'),
	    	'whatsnew' => __('What\'s New', 'podcaster'),
	    	'help' => __('Help', 'podcaster'),
	    );

	    $links = array();
	    echo '<nav class="podcasterabout__header-navigation nav-tab-wrapper wp-clearfix" aria-label="Secondary menu">';
	    foreach( $tabs as $tab => $name ){
	        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
	        echo "<a class='nav-tab$class' href='?page=pod-theme-options&tab=$tab'>$name</a>";
	    }
	    echo '</nav>';
	}
}


/**
 * Load custom stylesheets.
 */
if( ! function_exists( 'pod_info_settings_page_css' ) ){
	function pod_info_settings_page_css($hook) {
	    if ( 'toplevel_page_pod-theme-options' != $hook ) {
	        return;
	    }
		wp_enqueue_style( 'pod-theme-options', get_template_directory_uri() . '/includes/info-page/style.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'pod_info_settings_page_css' );


/**
 * Code of the page.
 */
if( ! function_exists( 'pod_info_settings_page' ) ){
	function pod_info_settings_page() {
		global $pagenow;
		$settings = get_option( "pod_info_theme_settings" );
		$theme_data = wp_get_theme();
		$custom_page_dir = get_template_directory_uri() . '/includes/info-page/img';
		$theme_version = $theme_data->get( 'Version' );
		$ocdi_active = pod_is_active_demo_install() ? "plugin-active ocdi-active" : "plugin-inactive ocdi-inactive";
		$redux_active = pod_is_active_redux() ? "plugin-active redux-active" : "plugin-inactive redux-inactive";
		$pod_customizer_url = esc_url( admin_url( 'customize.php' ) );
		?>

		<div class="wrap podcasterabout__container">

			<div class="podcasterabout__header">
				<div class="podcasterabout__header-title">
					<p>
						<?php echo esc_html( $theme_data->get( 'Name' ) ); ?>
						<span><?php echo esc_html( $theme_version ); ?></span>

					</p>
				</div>

				<div class="podcasterabout__header-text">
					<p><?php echo __('Thank you for installing <strong>Podcaster</strong>! Take a look at the newest features and updates.', 'podcaster') ?></p>
				</div>

				<?php
					$_GET['updated'] = '';
					if ( 'true' == esc_attr( $_GET['updated'] ) ) {
						echo '<div class="updated" ><p>'. __('Theme Settings updated.', 'podcaster') . '</p></div>';
					}

					// Display nav tab
					if ( isset ( $_GET['tab'] ) ){
						pod_info_admin_tabs($_GET['tab']); 
					} else {
						pod_info_admin_tabs('about');
					}
				?>
			</div>



			<?php 
				if ( isset ( $_GET['tab'] ) ) {
					$tab = $_GET['tab'];
				} else {
					$tab = 'about';
				}

				/* Switch through the tabs/pages.*/
				switch ( $tab ){

				/* Page: About */
				case 'about' :
					?>

					<div class="podcasterabout__section has-subtle-background-color">
						<div id="pod-theme-welcome" class="podcaster-theme-welcome">
				         	<h3><?php echo __("Complete Your Theme Setup", "podcaster"); ?></h3>
				         	<?php 
								$pod_plugins_url = admin_url('themes.php?page=tgmpa-install-plugins' );
								$pod_theme_name = esc_html( $theme_data->get( 'Name' ) );
								$pod_theme_version = esc_html( $theme_data->get( 'Version' ) );

								 ?>
								<p><?php printf( esc_html__( 'Congratulations, you have successfully installed %s version %s Make sure to complete setting up the theme by following the steps below.', 'podcaster'), $pod_theme_name, $pod_theme_version ); ?>

				            <div class="podcasterabout__section col-container has-2-columns">
				            	<div class="column task-list-container">
									<ul class="tasks">

										<li>
											<div class="number">
												<span class="digit">1</span>
											</div>
											<div class="text">
												<span class="title"><strong><?php echo __("Required plugins", "podcaster"); ?></strong></span>

												<?php 
													$pod_plugins_url = admin_url('themes.php?page=tgmpa-install-plugins' ); ?>
													<span class="desc"><?php echo sprintf( wp_kses( __( '<a href="%1$s" target="_blank">Install</a> and activate all required plugins.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_plugins_url ) ); ?></span>

											</div>
										</li>

										<li class="<?php echo esc_attr( $ocdi_active ); ?> <?php echo esc_attr( $redux_active ); ?>">
											<div class="number">
												<span class="digit">2</span>
											</div>
											<div class="text">
												<span class="title">
													<strong><?php echo __("Import demo data", "podcaster"); ?></strong>
													<?php if( ! pod_is_active_demo_install() || ! pod_is_active_redux() ) { ?>
														<span class="label"><?php echo __("Plugin not active", "podcaster"); ?></span>
													<?php  } ?>
												</span>

												<?php 
													$pod_demo_url = admin_url( 'admin.php?page=pt-one-click-demo-import' );
												?>
													<span class="desc">

														<?php 
														if( pod_is_active_demo_install() && pod_is_active_redux() ) {
															echo sprintf( wp_kses( __( 'Import demo content via the <a href="%1$s" target="_blank">One-Click Demo</a> installer.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_demo_url ) );

														} elseif( ! pod_is_active_redux() && pod_is_active_demo_install() ) {
															echo sprintf( wp_kses( __( 'Please <a href="%1$s" target="_blank">install</a> and activate the Redux Framework plugin to complete this step.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_plugins_url ) );;

														} elseif( ! pod_is_active_demo_install() && pod_is_active_redux() ) {
															echo sprintf( wp_kses( __( 'Please <a href="%1$s" target="_blank">install</a> and activate the One Click Demo Import plugin to complete this step.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_plugins_url ) );;
														
														} else { 

															echo sprintf( wp_kses( __( 'Please <a href="%1$s" target="_blank">install</a> and activate the One Click Demo Import and the Redux Framework plugin to complete this step.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_plugins_url ) );;
														} ?>
															
													</span>

											</div>
										</li>

										<li class="<?php echo esc_attr( $redux_active ); ?>">
											<div class="number">
												<span class="digit">3</span>
											</div>
											<div class="text">
												<span class="title">
													<strong>Configure theme options</strong>
													<?php 
														if( ! pod_is_active_redux() ) { ?>
															<span class="label"><?php echo __("Plugin not active", "podcaster"); ?></span>
													<?php  } ?>
												</span>

												<?php 
													$pod_themeo_url = admin_url( 'admin.php?page=_options' ); ?>
													<span class="desc">
														<?php if( pod_is_active_redux() ) {
															echo sprintf( wp_kses( __( 'Customize your website by using the <a href="%1$s" target="_blank">theme options</a>.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_themeo_url ) );
														} else {
															echo sprintf( wp_kses( __( 'Please <a href="%1$s" target="_blank">install</a> and activate the Redux Framework plugin to complete this step.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ), 'target' => array() ) ), esc_url( $pod_plugins_url ) );;
														} ?>
															</span>

											</div>
										</li>

										<li>
											<div class="number">
												<span class="digit">4</span>
											</div>
											<div class="text">
												<span class="title"><strong>Optional:</strong></span>

												<?php 
													$pod_optional_url = "http://themestation.co/documentation/podcaster/" ?>
													<span class="desc"><?php echo sprintf( wp_kses( __( 'Take a look at the <a href="%1$s" target="_blank">documentation</a> for Podcaster, if questions arise.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_optional_url ) ); ?></span>

											</div>
										</li>
									</ul>
								</div>
								<div class="column col-image">
									<div class="podcasterabout__image">
										<img src="<?php echo get_template_directory_uri(); ?>/includes/info-page/svg/illustration.png">										
									</div>
								</div>
							 </div>


				         </div>
					</div>

					<hr>

					<div class="podcasterabout__section has-features has-3-columns with-gap has-no-background-color">

						<div class="column">
							<div class="icon">

								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							    <g id="Stockholm-icons-/-Weather-/-Sun" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
							        <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" id="Oval-8" fill="#000000" fill-rule="nonzero"></path>
							        <path d="M19.5,10.5 L21,10.5 C21.8284271,10.5 22.5,11.1715729 22.5,12 C22.5,12.8284271 21.8284271,13.5 21,13.5 L19.5,13.5 C18.6715729,13.5 18,12.8284271 18,12 C18,11.1715729 18.6715729,10.5 19.5,10.5 Z M16.0606602,5.87132034 L17.1213203,4.81066017 C17.7071068,4.22487373 18.6568542,4.22487373 19.2426407,4.81066017 C19.8284271,5.39644661 19.8284271,6.34619408 19.2426407,6.93198052 L18.1819805,7.99264069 C17.5961941,8.57842712 16.6464466,8.57842712 16.0606602,7.99264069 C15.4748737,7.40685425 15.4748737,6.45710678 16.0606602,5.87132034 Z M16.0606602,18.1819805 C15.4748737,17.5961941 15.4748737,16.6464466 16.0606602,16.0606602 C16.6464466,15.4748737 17.5961941,15.4748737 18.1819805,16.0606602 L19.2426407,17.1213203 C19.8284271,17.7071068 19.8284271,18.6568542 19.2426407,19.2426407 C18.6568542,19.8284271 17.7071068,19.8284271 17.1213203,19.2426407 L16.0606602,18.1819805 Z M3,10.5 L4.5,10.5 C5.32842712,10.5 6,11.1715729 6,12 C6,12.8284271 5.32842712,13.5 4.5,13.5 L3,13.5 C2.17157288,13.5 1.5,12.8284271 1.5,12 C1.5,11.1715729 2.17157288,10.5 3,10.5 Z M12,1.5 C12.8284271,1.5 13.5,2.17157288 13.5,3 L13.5,4.5 C13.5,5.32842712 12.8284271,6 12,6 C11.1715729,6 10.5,5.32842712 10.5,4.5 L10.5,3 C10.5,2.17157288 11.1715729,1.5 12,1.5 Z M12,18 C12.8284271,18 13.5,18.6715729 13.5,19.5 L13.5,21 C13.5,21.8284271 12.8284271,22.5 12,22.5 C11.1715729,22.5 10.5,21.8284271 10.5,21 L10.5,19.5 C10.5,18.6715729 11.1715729,18 12,18 Z M4.81066017,4.81066017 C5.39644661,4.22487373 6.34619408,4.22487373 6.93198052,4.81066017 L7.99264069,5.87132034 C8.57842712,6.45710678 8.57842712,7.40685425 7.99264069,7.99264069 C7.40685425,8.57842712 6.45710678,8.57842712 5.87132034,7.99264069 L4.81066017,6.93198052 C4.22487373,6.34619408 4.22487373,5.39644661 4.81066017,4.81066017 Z M4.81066017,19.2426407 C4.22487373,18.6568542 4.22487373,17.7071068 4.81066017,17.1213203 L5.87132034,16.0606602 C6.45710678,15.4748737 7.40685425,15.4748737 7.99264069,16.0606602 C8.57842712,16.6464466 8.57842712,17.5961941 7.99264069,18.1819805 L6.93198052,19.2426407 C6.34619408,19.8284271 5.39644661,19.8284271 4.81066017,19.2426407 Z" id="Oval" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
							    </g>
							</svg>
								
							</div>

							<h4><?php echo __("Welcome", "podcaster"); ?></h4>
							<p><?php echo __("Thank you for installing Podcaster. This theme comes ready to be used for your podcasting project, ready with demos and many theme options.", "podcaster"); ?></p>						
						</div>

						<div class="column">
							<div class="icon">

								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							    <g id="Stockholm-icons-/-Shopping-/-Box#2" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
							        <path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" id="Combined-Shape" fill="#000000"></path>
							        <path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" id="Path" fill="#000000" opacity="0.3"></path>
							    </g>
							</svg>

							</div>

							<h4><?php echo __("Getting Started", "podcaster"); ?></h4>
							<p><?php echo __("If this is your first time using Podcaster, it's recommended you follow the steps mentioned above or check the documentation for more information.", "podcaster"); ?></p>
							<a href="<?php echo admin_url( 'admin.php?page=pod-theme-options&tab=getting-started' ); ?>" class="button button-primary"><?php echo __("View checklist", "podcaster"); ?></a>
						</div>

						<div class="column">
							<div class="icon">

								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								    <g id="Stockholm-icons-/-Navigation-/-Double-check" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								        <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
								        <path d="M9.26193932,16.6476484 C8.90425297,17.0684559 8.27315905,17.1196257 7.85235158,16.7619393 C7.43154411,16.404253 7.38037434,15.773159 7.73806068,15.3523516 L16.2380607,5.35235158 C16.6013618,4.92493855 17.2451015,4.87991302 17.6643638,5.25259068 L22.1643638,9.25259068 C22.5771466,9.6195087 22.6143273,10.2515811 22.2474093,10.6643638 C21.8804913,11.0771466 21.2484189,11.1143273 20.8356362,10.7474093 L17.0997854,7.42665306 L9.26193932,16.6476484 Z" id="Path-94-Copy" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(14.999995, 11.000002) rotate(-180.000000) translate(-14.999995, -11.000002) "></path>
								        <path d="M4.26193932,17.6476484 C3.90425297,18.0684559 3.27315905,18.1196257 2.85235158,17.7619393 C2.43154411,17.404253 2.38037434,16.773159 2.73806068,16.3523516 L11.2380607,6.35235158 C11.6013618,5.92493855 12.2451015,5.87991302 12.6643638,6.25259068 L17.1643638,10.2525907 C17.5771466,10.6195087 17.6143273,11.2515811 17.2474093,11.6643638 C16.8804913,12.0771466 16.2484189,12.1143273 15.8356362,11.7474093 L12.0997854,8.42665306 L4.26193932,17.6476484 Z" id="Path-94" fill="#000000" fill-rule="nonzero" transform="translate(9.999995, 12.000002) rotate(-180.000000) translate(-9.999995, -12.000002) "></path>
								    </g>
								</svg>

							</div>

							<h4><?php echo __("What's new", "podcaster"); ?></h4>
							<p><?php echo __("New features and adjustments are constantly being added to Podcaster. Check out the changelog for more information.", "podcaster"); ?></p>
							<a href="http://themestation.co/documentation/podcaster/#changelog" class="button button-primary" target="_blank"><?php echo __("View changelog", "podcaster"); ?></a>			
						</div>
						
						<div class="column">
							<div class="icon">

								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								    <g id="Stockholm-icons-/-Home-/-Book-open" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
								        <path d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z" id="Combined-Shape" fill="#000000"></path>
								        <path d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z" id="Path-41-Copy" fill="#000000" opacity="0.3"></path>
								    </g>
								</svg>
							</div>

							<h4><?php echo __("Documentation", "podcaster"); ?></h4>
							<p><?php echo __("Need more information on how to use Podcaster? Take a look at the documentation, which offers a more in depth look at the themes features.", "podcaster"); ?></p>
							<a href="http://themestation.co/documentation/podcaster/" class="button button-primary" target="_blank"><?php echo __("See documentation", "podcaster"); ?></a>
						</div>

						<div class="column">
							<div class="icon">

								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								    <g id="Stockholm-icons-/-Communication-/-Group-chat" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
								        <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" id="Combined-Shape" fill="#000000"></path>
								        <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
								    </g>
								</svg>

							</div>

							<h4><?php echo __("Support", "podcaster"); ?></h4>
							<p><?php echo __("You can always get in touch, if you need more help with setting up the theme. Simply send in a request via the Podcaster support page.", "podcaster"); ?></p>
							<a href="https://themeforest.net/item/podcaster-multimedia-wordpress-theme/6804946/support" class="button button-primary" target="_blank"><?php echo __("Go to support", "podcaster"); ?></a>
						</div>

						<div class="column"></div>


					</div>

					<hr>

					<div class="podcasterabout__section is-footer has-no-background-color">
						<div class="column">
							<p>&copy; <?php echo date('Y'); ?> &middot; <?php echo esc_html( $theme_data['Name'] ); ?> <?php echo __(' by', 'podcaster'); ?> <a href="https://themeforest.net/user/themestation" target="_blank">Themestation</a></p>
						</div>
					</div>

					

					<?php
				break;

				/* 
				 *
				 * Page: Getting Started
				 * 
				 * --------------------------------------- */
				case 'getting-started' :
					?>

					<div class="podcasterabout__section has-subtle-background-color">
						<div id="pod-theme-welcome" class="podcaster-theme-welcome">
				         	<h3><?php echo __("Complete Your Theme Setup", "podcaster"); ?></h3>
				         	<?php 
								$pod_plugins_url = admin_url('themes.php?page=tgmpa-install-plugins' );
								$pod_theme_name = esc_html( $theme_data->get( 'Name' ) );
								$pod_theme_version = esc_html( $theme_data->get( 'Version' ) );

								 ?>
								<p><?php printf( esc_html__( 'Congratulations, you have successfully installed %s version %s Make sure to complete setting up the theme by following the steps below.', 'podcaster'), $pod_theme_name, $pod_theme_version ); ?>

				            <div class="podcasterabout__section col-container has-2-columns">
				            	<div class="column task-list-container">
									<ul class="tasks">

										<li>
											<div class="number">
												<span class="digit">1</span>
											</div>
											<div class="text">
												<span class="title"><strong><?php echo __("Required plugins", "podcaster"); ?></strong></span>

												<?php 
													$pod_plugins_url = admin_url('themes.php?page=tgmpa-install-plugins' ); ?>
													<span class="desc"><?php echo sprintf( wp_kses( __( '<a href="%1$s" target="_blank">Install</a> and activate all required plugins.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_plugins_url ) ); ?></span>

											</div>
										</li>

										<li class="<?php echo esc_attr( $ocdi_active ); ?> <?php echo esc_attr( $redux_active ); ?>">
											<div class="number">
												<span class="digit">2</span>
											</div>
											<div class="text">
												<span class="title">
													<strong><?php echo __("Import demo data", "podcaster"); ?></strong>
													<?php if( ! pod_is_active_demo_install() || ! pod_is_active_redux() ) { ?>
														<span class="label"><?php echo __("Plugin not active", "podcaster"); ?></span>
													<?php  } ?>
												</span>

												<?php 
													$pod_demo_url = admin_url( 'admin.php?page=pt-one-click-demo-import' );
												?>
													<span class="desc">

														<?php 
														if( pod_is_active_demo_install() && pod_is_active_redux() ) {
															echo sprintf( wp_kses( __( 'Import demo content via the <a href="%1$s" target="_blank">One-Click Demo</a> installer.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_demo_url ) );

														} elseif( ! pod_is_active_redux() && pod_is_active_demo_install() ) {
															echo sprintf( wp_kses( __( 'Please <a href="%1$s" target="_blank">install</a> and activate the Redux Framework plugin to complete this step.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_plugins_url ) );;

														} elseif( ! pod_is_active_demo_install() && pod_is_active_redux() ) {
															echo sprintf( wp_kses( __( 'Please <a href="%1$s" target="_blank">install</a> and activate the One Click Demo Import plugin to complete this step.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_plugins_url ) );;
														
														} else { 

															echo sprintf( wp_kses( __( 'Please <a href="%1$s" target="_blank">install</a> and activate the One Click Demo Import and the Redux Framework plugin to complete this step.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_plugins_url ) );;
														} ?>
															
													</span>

											</div>
										</li>

										<li class="<?php echo esc_attr( $redux_active ); ?>">
											<div class="number">
												<span class="digit">3</span>
											</div>
											<div class="text">
												<span class="title">
													<strong>Configure theme options</strong>
													<?php 
														if( ! pod_is_active_redux() ) { ?>
															<span class="label"><?php echo __("Plugin not active", "podcaster"); ?></span>
													<?php  } ?>
												</span>

												<?php 
													$pod_themeo_url = admin_url( 'admin.php?page=_options' ); ?>
													<span class="desc">
														<?php if( pod_is_active_redux() ) {
															echo sprintf( wp_kses( __( 'Customize your website by using the <a href="%1$s" target="_blank">theme options</a>.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_themeo_url ) );
														} else {
															echo sprintf( wp_kses( __( 'Please <a href="%1$s" target="_blank">install</a> and activate the Redux Framework plugin to complete this step.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ), 'target' => array() ) ), esc_url( $pod_plugins_url ) );;
														} ?>
															</span>

											</div>
										</li>

										<li>
											<div class="number">
												<span class="digit">4</span>
											</div>
											<div class="text">
												<span class="title"><strong>Optional:</strong></span>

												<?php 
													$pod_optional_url = "http://themestation.co/documentation/podcaster/" ?>
													<span class="desc"><?php echo sprintf( wp_kses( __( 'Take a look at the <a href="%1$s" target="_blank">documentation</a> for Podcaster, if questions arise.', 'podcaster' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $pod_optional_url ) ); ?></span>

											</div>
										</li>
									</ul>
								</div>
								<div class="column col-image">
									<div class="podcasterabout__image">
										<img src="<?php echo get_template_directory_uri(); ?>/includes/info-page/svg/illustration.png">										
									</div>
								</div>
							</div>


				         </div>
					</div>

					<hr>

					<div class="podcasterabout__section is-footer has-no-background-color">
						<div class="column">
							<p>&copy; <?php echo date('Y'); ?> &middot; <?php echo esc_html( $theme_data['Name'] ); ?> <?php echo __(' by', 'podcaster'); ?> <a href="https://themeforest.net/user/themestation" target="_blank">Themestation</a></p>
						</div>
					</div>

					<?php
				break;


				/* 
				 *
				 * Page: What's New 
				 * 
				 * --------------------------------------- */
				case 'whatsnew' :
					?>

					<div class="podcasterabout__section changelog">
						<div class="column">
							<h2><?php echo __('Changelog', 'podcaster'); ?></h2>
								<?php
								$pod_clog_ver = $theme_data->get( 'Version' );
								$pod_clog_url = 'http://themestation.co/documentation/podcaster/#changelog'; ?>

								<p><?php $pod_clog_link_1 = printf( esc_html__( 'Version %s inculdes a number of updates.', 'podcaster'), $pod_clog_ver); ?>
								<?php echo sprintf( wp_kses( __('Please <a href="%1$s" target="_blank">click here</a> to see the changelog.', 'podcaster' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $pod_clog_url ) ); ?></p>
						</div>
					</div>

					

					<div class="podcasterabout__section podcasterwhatsnew__section has-features has-3-columns with-gap has-no-background-color">


						<div class="column">

							<div class="icon-container">
								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								    <g id="Stockholm-icons-/-General-/-Thunder-move" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								        <rect id="Rectangle-10" x="0" y="0" width="24" height="24"></rect>
								        <path d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z" id="Path-3" fill="#000000"></path>
								        <path d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
								    </g>
								</svg>
							</div>

							<h4><?php echo __('WordPress 5.9 ready', 'podcaster'); ?></h4>
							<p><?php echo __('Podcaster has been tested and is ready to be used with WordPress 5.9.', 'podcaster'); ?></p>
						</div>

						<div class="column">

							<div class="icon-container">
								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								    <defs></defs>
								    <g id="Stockholm-icons-/-Code-/-Code" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
								        <path d="M17.2718029,8.68536757 C16.8932864,8.28319382 16.9124644,7.65031935 17.3146382,7.27180288 C17.7168119,6.89328641 18.3496864,6.91246442 18.7282029,7.31463817 L22.7282029,11.5646382 C23.0906029,11.9496882 23.0906029,12.5503176 22.7282029,12.9353676 L18.7282029,17.1853676 C18.3496864,17.5875413 17.7168119,17.6067193 17.3146382,17.2282029 C16.9124644,16.8496864 16.8932864,16.2168119 17.2718029,15.8146382 L20.6267538,12.2500029 L17.2718029,8.68536757 Z M6.72819712,8.6853647 L3.37324625,12.25 L6.72819712,15.8146353 C7.10671359,16.2168091 7.08753558,16.8496835 6.68536183,17.2282 C6.28318808,17.6067165 5.65031361,17.5875384 5.27179713,17.1853647 L1.27179713,12.9353647 C0.909397125,12.5503147 0.909397125,11.9496853 1.27179713,11.5646353 L5.27179713,7.3146353 C5.65031361,6.91246155 6.28318808,6.89328354 6.68536183,7.27180001 C7.08753558,7.65031648 7.10671359,8.28319095 6.72819712,8.6853647 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero"></path>
								        <rect id="Rectangle-28" fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-345.000000) translate(-12.000000, -12.000000) " x="11" y="4" width="2" height="16" rx="1"></rect>
								    </g>
								</svg>
							</div>

							<h4><?php echo __('PHP 7.1 - PHP 7.3', 'podcaster'); ?></h4>
							<p><?php echo __('Podcaster is fully compatible and has been tested for use with PHP 7.0 - 7.3.', 'podcaster'); ?></p>				
						</div>					

						<div class="column">

							<div class="icon-container">
								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								    <g id="Stockholm-icons-/-Tools-/-Tools" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
								        <path d="M15.9497475,3.80761184 L13.0246125,6.73274681 C12.2435639,7.51379539 12.2435639,8.78012535 13.0246125,9.56117394 L14.4388261,10.9753875 C15.2198746,11.7564361 16.4862046,11.7564361 17.2672532,10.9753875 L20.1923882,8.05025253 C20.7341101,10.0447871 20.2295941,12.2556873 18.674559,13.8107223 C16.8453326,15.6399488 14.1085592,16.0155296 11.8839934,14.9444337 L6.75735931,20.0710678 C5.97631073,20.8521164 4.70998077,20.8521164 3.92893219,20.0710678 C3.1478836,19.2900192 3.1478836,18.0236893 3.92893219,17.2426407 L9.05556629,12.1160066 C7.98447038,9.89144078 8.36005124,7.15466739 10.1892777,5.32544095 C11.7443127,3.77040588 13.9552129,3.26588995 15.9497475,3.80761184 Z" id="Combined-Shape" fill="#000000"></path>
								        <path d="M16.6568542,5.92893219 L18.0710678,7.34314575 C18.4615921,7.73367004 18.4615921,8.36683502 18.0710678,8.75735931 L16.6913928,10.1370344 C16.3008685,10.5275587 15.6677035,10.5275587 15.2771792,10.1370344 L13.8629656,8.7228208 C13.4724413,8.33229651 13.4724413,7.69913153 13.8629656,7.30860724 L15.2426407,5.92893219 C15.633165,5.5384079 16.26633,5.5384079 16.6568542,5.92893219 Z" id="Rectangle-2" fill="#000000" opacity="0.3"></path>
								    </g>
								</svg>
							</div>

							<h4><?php echo __('Bugfixes & Improvements', 'podcaster'); ?></h4>
							<p><?php echo __('Several bugs and improvements have been added to this version of Podcaster. You can check the documentation for the complete changelog.', 'podcaster'); ?></p>
						</div>

					</div>

					<hr>

					<div class="podcasterabout__section is-footer has-no-background-color">
						<div class="column">
							<p>&copy; <?php echo date('Y'); ?>  &middot; <?php echo esc_html( $theme_data['Name'] ); ?> <?php echo __(' by', 'podcaster'); ?> <a href="https://themeforest.net/user/themestation" target="_blank">Themestation</a></p>
						</div>
					</div>


					<?php
				break;

				case 'help' :
					?>

					<div class="podcasterabout__section podcasterhelp__section has-features has-2-columns with-gap has-no-background-color">

						<div class="column">
							<div class="icon-container">
								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								    <g id="Stockholm-icons-/-Home-/-Book-open" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
								        <path d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z" id="Combined-Shape" fill="#000000"></path>
								        <path d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z" id="Path-41-Copy" fill="#000000" opacity="0.3"></path>
								    </g>
								</svg>
							</div>

							<h4><?php echo __('Documentation', 'podcaster'); ?></h4>
							<p><?php echo __('Need more information on how to use Podcaster? Take a look at the documentation, which offers a more in depth look at the themes features.', 'podcaster'); ?></p>						
							<a href="http://themestation.co/documentation/podcaster/" class="button button-primary" target="_blank"><?php echo __('See Documentation', 'podcaster'); ?></a>
						</div>

						<div class="column">
							<div class="icon-container">
								<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								    <g id="Stockholm-icons-/-Communication-/-Group-chat" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
								        <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" id="Combined-Shape" fill="#000000"></path>
								        <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
								    </g>
								</svg>
							</div>

							<h4><?php echo __('Support', 'podcaster'); ?></h4>
							<p><?php echo __('You can always get in touch, if you need more help with setting up the theme. Simply send in a request via the Podcaster support page.', 'podcaster'); ?></p>
							<a href="https://themeforest.net/item/podcaster-multimedia-wordpress-theme/6804946/support" class="button button-primary" target="_blank"><?php echo __('Go to Support', 'podcaster'); ?></a>
						</div>

					</div>

					<hr>

					<div class="podcasterabout__section is-footer has-no-background-color">
						<div class="column">
							<p>&copy; <?php echo date('Y'); ?> &middot; <?php echo esc_html( $theme_data['Name'] ); ?> <?php echo __(' by', 'podcaster'); ?> <a href="https://themeforest.net/user/themestation" target="_blank">Themestation</a></p>
						</div>
					</div>

					<?php
				break;
			} ?>
		</div><!-- .wrap -->


	<?php
	}
}


?>
