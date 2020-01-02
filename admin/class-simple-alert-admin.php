<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/vishakha07/
 * @since      1.0.0
 *
 * @package    Simple_Alert
 * @subpackage Simple_Alert/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Alert
 * @subpackage Simple_Alert/admin
 * @author     Vishakha Gupta <vishakha.wordpress02@gmail.com>
 */
class Simple_Alert_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name       The name of this plugin.
	 * @param    string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function enqueue_styles() {

		if ( ! wp_style_is( 'selectize-css', 'enqueued' ) ) {
			wp_enqueue_style( 'selectize-css', plugin_dir_url( __FILE__ ) . 'css/selectize.css', array(), $this->version, 'all' );
		}
		if ( ! wp_style_is( $this->plugin_name, 'enqueued' ) ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-alert-admin.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function enqueue_scripts() {

		if ( ! wp_script_is( 'selectize-js', 'enqueued' ) ) {
			wp_enqueue_script( 'selectize-js', plugin_dir_url( __FILE__ ) . 'js/selectize.min.js', array( 'jquery' ), $this->version, false );
		}
		if ( ! wp_script_is( $this->plugin_name, 'enqueued' ) ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-alert-admin.js', array( 'jquery' ), $this->version, false );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function simple_alert_settings() {

		add_options_page( esc_html__( 'Simple Alert', 'simple-alert' ), esc_html__( 'Simple Alert', 'simple-alert' ), 'manage_options', 'simple-alert-settings-page', array( $this, 'simple_alert_settings_page' ) );

	}

	/**
	 * Register admin settings.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function register_simple_alert_settings() {

		register_setting( 'simple_alert_general_settings', 'simple_alert_general_settings' );

	}

	/**
	 * Display admin settings page.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function simple_alert_settings_page() {
		$pages     = get_all_page_ids();
		$page_list = array();
		if ( ! empty( $pages ) ) {
			foreach ( $pages as $page_id ) {
				$page_list[ $page_id ] = get_the_title( $page_id );
			}
		}

		$args = array(
			'public'              => true,
			'_builtin'            => false,
			'exclude_from_search' => false,
		);

		$output   = 'names'; // names or objects, note names is the default.
		$operator = 'and'; // 'and' or 'or'.

		$post_types = get_post_types( $args, $output, $operator );
		$sa_func    = new Simple_Alert_Functions();
		$settings   = $sa_func->setup_plugin_settings();

		$page_list_class = 'sa-hide';
		if ( ! empty( $settings['enable_on_pages'] ) ) {
			$page_list_class = '';
		}
		$post_list_class = 'sa-hide';
		if ( ! empty( $settings['enable_on_posts'] ) ) {
			$post_list_class = '';
		}

		include 'partials/simple-alert-admin-display.php';
	}

}
