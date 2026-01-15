<?php
/**
 * Plugin Name:       CLOSECLIENT CUSTOMIZER PRO
 * Plugin URI:        https://example.com/
 * Description:       A complete production-level customizer plugin.
 * Version:           1.0.0
 * Author:            Jules
 * Author URI:        https://example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       closeclient-customizer-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants
 */
define( 'CCP_VERSION', '1.0.0' );
define( 'CCP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CCP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The main plugin class.
 */
final class CLOSECLIENT_CUSTOMIZER_PRO {

	/**
	 * The single instance of the class.
	 *
	 * @var CLOSECLIENT_CUSTOMIZER_PRO
	 */
	protected static $_instance = null;

	/**
	 * Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include required files.
	 */
	public function includes() {
		require_once CCP_PLUGIN_DIR . 'includes/class-closeclient-customizer.php';
		require_once CCP_PLUGIN_DIR . 'includes/class-closeclient-dynamic-css.php';
		require_once CCP_PLUGIN_DIR . 'includes/builder-render-functions.php';
	}

	/**
	 * Initialize hooks.
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );
	}

	/**
	 * On plugins loaded.
	 */
	public function on_plugins_loaded() {
		// Load plugin textdomain
		load_plugin_textdomain( 'closeclient-customizer-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

/**
 * Main instance of the plugin.
 */
function closeclient_customizer_pro() {
	return CLOSECLIENT_CUSTOMIZER_PRO::instance();
}

// Global for backwards compatibility.
$GLOBALS['closeclient_customizer_pro'] = closeclient_customizer_pro();
