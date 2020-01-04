<?php
/**
 * Have all functions related to plugins.
 *
 * @link       https://profiles.wordpress.org/vishakha07/
 * @since      1.0.0
 *
 * @package    Simple_Alert
 * @subpackage Simple_Alert/includes
 */

/**
 * Have all functions related to plugins.
 *
 * @since      1.0.0
 * @package    Simple_Alert
 * @subpackage Simple_Alert/includes
 * @author     Vishakha Gupta <vishakha.wordpress02@gmail.com>
 */
class Simple_Alert_Functions {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

	}

	/**
	 * Include the following files that make up the plugin.
	 *
	 * - Simple_Alert_Functions.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function setup_plugin_settings() {

		$sa_settings = array();
		$settings    = array();
		if ( is_multisite() && is_plugin_active_for_network( SIMPLE_ALERT_PLUGIN_BASENAME ) ) {
			$sa_settings = get_site_option( 'simple_alert_general_settings' );
		} else {
			$sa_settings = get_option( 'simple_alert_general_settings' );
		}
		$alert_message = esc_html__( "You can't access content.", "simple-alert" );
		if ( ! empty( $sa_settings['alert_message'] ) ) {
			$alert_message = $sa_settings['alert_message'];
		}
		$settings['alert_message'] = $alert_message;	
		$enable_on_pages = false;
		if ( isset( $sa_settings['enable_on_pages'] ) ) {
			$enable_on_pages = true;
		}
		$settings['enable_on_pages'] = $enable_on_pages;

		$enable_on_posts = false;
		if ( isset( $sa_settings['enable_on_posts'] ) ) {
			$enable_on_posts = true;
		}
		$settings['enable_on_posts'] = $enable_on_posts;

		$selected_pages = array();
		if ( isset( $sa_settings['pages'] ) ) {
			$selected_pages = $sa_settings['pages'];
		}
		$settings['pages'] = $selected_pages;

		$settings['posts'] = array();
		if ( isset( $sa_settings['posts'] ) ) {
			$settings['posts'] = $sa_settings['posts'];
		}	
		$args = array(
	       'public'   => true,
	       '_builtin' => false,
	       'exclude_from_search' => false, 
	    );
	    $output = 'names'; // names or objects, note names is the default
	    $operator = 'and'; // 'and' or 'or'

	    $post_types = get_post_types( $args, $output, $operator );

	    if ( ! empty( $post_types ) ) {
	    	foreach ( $post_types as $post_type ) {
		    	$enable_on_cpt = false;
		    	if ( isset( $sa_settings['enable_on_'.$post_type] ) ) {
		    		$enable_on_cpt = true;				
				}
				$settings['enable_on_'.$post_type] = $enable_on_cpt;
				$settings[$post_type] = array();
				if ( isset( $sa_settings[$post_type] ) ) {
					$settings[$post_type] = $sa_settings[$post_type];
				}
		    }
	    }

	    return apply_filters( 'sa_plugin_settings', $settings );

	}
}
