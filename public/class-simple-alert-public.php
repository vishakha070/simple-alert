<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/vishakha07/
 * @since      1.0.0
 *
 * @package    Simple_Alert
 * @subpackage Simple_Alert/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_Alert
 * @subpackage Simple_Alert/public
 * @author     Vishakha Gupta <vishakha.wordpress02@gmail.com>
 */
class Simple_Alert_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if ( ! wp_style_is( $this->plugin_name, 'enqueued' ) ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-alert-public.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( ! wp_script_is( $this->plugin_name, 'enqueued' ) ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-alert-public.js', array( 'jquery' ), time(), false );
		}
		$sa_func  = new Simple_Alert_Functions();
		$settings = $sa_func->setup_plugin_settings();
		wp_localize_script(
			$this->plugin_name,
			'sa_data',
			array(
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'settings' => $settings,
			)
		);

	}

	/**
	 * Check alert message will be display on current page or not.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function check_is_alert_page( $pid ) {
		$sa_func  = new Simple_Alert_Functions();
		$settings = $sa_func->setup_plugin_settings();

		if ( ! empty( $settings['enable_on_pages'] ) ) {
			if ( ! empty( $settings['pages'] ) ) {
				if ( in_array( $pid, $settings['pages'] ) ) {
					return true;
				}
			}
		}

		if ( is_single() ) {
			if ( ! empty( $settings['enable_on_posts'] ) ) {
				if ( ! empty( $settings['posts'] ) ) {
					if ( in_array( $pid, $settings['posts'] ) ) {
						return true;
					}
				}
			}

			$args     = array(
				'public'              => true,
				'_builtin'            => false,
				'exclude_from_search' => false,
			);
			$output   = 'names'; // names or objects, note names is the default.
			$operator = 'and'; // 'and' or 'or'.

			$post_types = get_post_types( $args, $output, $operator );

			if ( ! empty( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					$enable_on_cpt = false;
					if ( isset( $settings[ 'enable_on_' . $post_type ] ) ) {
						$enable_on_cpt = true;
					}
					if ( $enable_on_cpt ) {
						if ( ! empty( $settings[ $post_type ] ) ) {
							if ( in_array( $pid, $settings[ $post_type ] ) ) {
								return true;
							}
						}
					}
				}
			}
		}

		return false;
	}

	/**
	 * Display alert on specific pages.
	 *
	 * @author Vishakha Gupta
	 * @since  1.0.0
	 * @access public
	 */
	public function sa_show_alert_message() {
		global $wp_query;
		$current_page_id = $wp_query->post->ID;
		$alert           = $this->check_is_alert_page( $current_page_id );

		if ( $alert ) {
			$sa_func  = new Simple_Alert_Functions();
			$settings = $sa_func->setup_plugin_settings();
			?>
			<script>
				jQuery(document).ready(function() {
					alert( "<?php echo $settings['alert_message']; ?>" );
				});
			</script>
			<?php
		}
	}

}
