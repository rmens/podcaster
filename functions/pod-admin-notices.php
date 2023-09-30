<?php
/*
 *
 * NOTICES
 *-------------------------------------------------------*/

/**
 * Display notice when multiple podcasting plugins are ative
 *
 * @param -
 * @since 1.9.3
 * @return -
 */
function pod_plugin_conflict_hook_admin_notice() {
	
	$screen = get_current_screen();
	$pod_plugins_url = admin_url('plugins.php?plugin_status=active' );
	$pod_docs_url = 'http://themestation.co/documentation/podcaster/#start-plugins';

	if ( ! get_option('dismissed-pod_plugin_conflict', FALSE ) ) {

		if( ( pod_is_active_ssp() && pod_is_active_bpp() && pod_is_active_podm() ) || ( pod_is_active_ssp() && pod_is_active_bpp() ) ) : ?>

			<div class="notice notice-warning notice-pod-plugin-conflict is-dismissible" data-notice="pod_plugin_conflict">
				<p><?php _e('Multiple podcasting plugins seems to be active at the same time. Please keep one podcasting plugin active at a time to avoid conflicts.', 'podcaster'); ?></p>
				<p>
					<a href="<?php echo esc_url( $pod_plugins_url ); ?>" target="_blank"><?php echo __( 'Begin deactivating plugins', 'podcaster' ); ?></a> | 
					<a href="<?php echo esc_url( $pod_docs_url ); ?>" target="_blank"><?php echo __( 'Find out more', 'podcaster' ); ?></a>
				</p>
			</div>

		<?php elseif ( pod_is_active_ssp() && pod_is_active_podm() ) : ?>
			
			<div class="notice notice-warning notice-pod-plugin-conflict is-dismissible" data-notice="pod_plugin_conflict">
				<p><?php echo sprintf( __( 'If you are using %1$s Seriously Simple Podcasing %2$s to manage your podcast, please deactivate %1$s Podcaster Media %2$s to avoid conflicts.', 'podcaster' ), '<strong>', '</strong>' ); ?></p>
				<p>
					<a href="<?php echo esc_url( $pod_plugins_url ); ?>" target="_blank"><?php echo __( 'Begin deactivating plugins', 'podcaster' ); ?></a> | 
					<a href="<?php echo esc_url( $pod_docs_url ); ?>" target="_blank"><?php echo __( 'Find out more', 'podcaster' ); ?></a>
				</p>
			</div>

		<?php elseif( pod_is_active_bpp() && pod_is_active_podm() ) : ?>

			<div class="notice notice-warning notice-pod-plugin-conflict is-dismissible" data-notice="pod_plugin_conflict">
				<p><?php echo sprintf( __( 'If you are using %1$s Blubrry PowerPress %2$s to manage your podcast, please deactivate %1$s Podcaster Media %2$s to avoid conflicts.', 'podcaster' ), '<strong>', '</strong>' ); ?></p>
				<p>
					<a href="<?php echo esc_url( $pod_plugins_url ); ?>" target="_blank"><?php echo __( 'Begin deactivating plugins', 'podcaster' ); ?></a> | 
					<a href="<?php echo esc_url( $pod_docs_url ); ?>" target="_blank"><?php echo __( 'Find out more', 'podcaster' ); ?></a>
				</p>
			</div>

		<?php endif;

	}

}
add_action('admin_notices', 'pod_plugin_conflict_hook_admin_notice');



/**
 * Register and enqueue a custom script in the WordPress admin for the notice.
 *
 * @param -
 * @since 1.9.3
 * @return -
 */
add_action( 'admin_enqueue_scripts', 'pod_enqueue_custom_admin_scripts' );
function pod_enqueue_custom_admin_scripts() {
        wp_register_script( 'pod-plugin-conflict', get_template_directory_uri() . '/js/pod-plugin-conflict-js.js', false, '1.0.0' );
        wp_enqueue_script( 'pod-plugin-conflict' );
}


/**
 * AJAX handler that stores the state of podcasting plugin notice.
 *
 * @param -
 * @since 1.9.3
 * @return -
 */
add_action( 'wp_ajax_dismissed_notice_handler', 'pod_ajax_notice_handler' );
function pod_ajax_notice_handler() {
    // Pick up the notice "type" - passed via jQuery (the "data-notice" attribute on the notice)
    $type = $_POST['type'];
    print_r( $type );
    // Store it in the options table
    update_option( 'dismissed-' . $type, TRUE );
}