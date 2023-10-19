<?php
/**
 * Plugin Name: WannaKnow?
 * Description: Investigate admin-side events
 * Version: 0.1.0
 * Author: Attila Bakos
 */

// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Path definitions
if (
	defined( 'WK_DIR' ) ||
	defined( 'WK_DIR_CORE' ) ||
	defined( 'WK_DIR_INTERFACE' )
) {
	die;
}
define( 'WK_DIR', plugin_dir_path( __FILE__ ) );
define( 'WK_DIR_CORE', plugin_dir_path( __FILE__ ) . 'core/' );
define( 'WK_DIR_INTERFACE', plugin_dir_path( __FILE__ ) . 'core/interface/' );
define( 'WK_DIR_ENUM', plugin_dir_path( __FILE__ ) . 'core/enum/' );

// Version definition
$plugin_data    = get_file_data( __FILE__, [ 'Version' => 'Version' ], false );
$plugin_version = $plugin_data['Version'] ?? '0.0.0';

define( 'WK_VERSION', $plugin_version );
define( 'WK_BASENAME', plugin_basename( __FILE__ ) );

// File includes
require_once WK_DIR_INTERFACE . 'WK_Consts.php';

require_once WK_DIR_ENUM . 'WK_DB_Column.php';
require_once WK_DIR_ENUM . 'WK_Assets.php';
require_once WK_DIR_ENUM . 'WK_Event.php';
require_once WK_DIR_ENUM . 'WK_Log.php';
require_once WK_DIR_ENUM . 'WK_Subject_Type.php';

require_once WK_DIR_CORE . 'WK_DB.php';
require_once WK_DIR_CORE . 'WK_Request_Router.php';
require_once WK_DIR_CORE . 'WK_Menu.php';

require_once WK_DIR_CORE . 'WK_Admin_Page_Settings.php';
require_once WK_DIR_CORE . 'WK_Admin_Page_Log.php';
require_once WK_DIR_CORE . 'WK_Admin_Dashboard_Feed.php';
require_once WK_DIR_CORE . 'WK_Admin_Dashboard_Stats.php';
require_once WK_DIR_CORE . 'WK_Admin_Dashboard_Users.php';
require_once WK_DIR_CORE . 'WK_Admin_Bar.php';

require_once WK_DIR_CORE . 'WK_Events.php';
require_once WK_DIR_CORE . 'WK_Cron.php';

require_once WK_DIR_CORE . 'WK_Event_Listener_Media.php';
require_once WK_DIR_CORE . 'WK_Event_Listener_Post.php';
require_once WK_DIR_CORE . 'WK_Event_Listener_System.php';
require_once WK_DIR_CORE . 'WK_Event_Listener_User.php';

require_once WK_DIR_CORE . 'WK_Init.php';

readonly final class WK implements \WK\WK_Consts {

	public function __construct() {
		$this->plugin_setup();
		new \WK\WK_Init();
	}

	/**
	 * Plugin setup processes.
	 */
	private function plugin_setup(): void {
		register_activation_hook( __FILE__, [ $this, 'plugin_activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'plugin_deactivate' ] );

		// Hook into actions that are needed to run the plugin.
		add_action( 'admin_init', [ $this, 'wk_check_php' ] );
		add_action( 'plugins_loaded', [ $this, 'wk_after_plugin_loaded' ] );
	}

	/**
	 * Plugin activation
	 *
	 * @return void
	 */
	public function plugin_activate(): void {
		( new \WK\WK_DB() )?->create_main_table();

		// Register admin rights
	}

	/**
	 * Plugin deactivation & clean up processes.
	 *
	 * @return void
	 */
	public function plugin_deactivate(): void {
		// Maybe Drop the main database table
		//if ( get_option( self::SETTING_NAME['delete_main_table'] ) ) {
		( new \WK\WK_DB() )?->drop_table();

		// Maybe delete all plugin settings

		// Remove user rights
	}

	/**
	 * Check PHP version function hook
	 *
	 * @return void
	 */
	public function wk_check_php(): void {
		if ( version_compare( PHP_VERSION, \WK\WK_Consts::MINIMUM_PHP_VERSION, '<' ) ) {
			if ( is_plugin_active( WK_BASENAME ) ) {
				deactivate_plugins( WK_BASENAME );
				// add_action( 'admin_notices', [ $this, 'wk_error_activation_notice' ] );
				unset( $_GET['activate'] );
			}
		}
	}

	/**
	 * Once the plugin has loaded AND the user is logged in, register the
	 * assets on admin-side and front-end
	 *
	 * @return void
	 */
	public function wk_after_plugin_loaded(): void {
		if ( is_user_logged_in() ) {
			$this->load_scripts_and_styles();
		}
	}

	public function load_scripts_and_styles(): void {
		add_action( 'wp_enqueue_scripts', [ $this, 'wk_enqueue_front_end' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'wk_enqueue_admin' ] );
	}

	public function wk_enqueue_admin(): void {
		wp_enqueue_style(
			\WK\WK_AssetHandler::CSS_Admin->value,
			plugin_dir_url( __FILE__ ) . \WK\WK_AssetHandler::CSS_Admin->get_path(),
			false,
			WK_VERSION
		);

		wp_enqueue_script(
			\WK\WK_AssetHandler::JS_Admin->value,
			plugin_dir_url( __FILE__ ) . \WK\WK_AssetHandler::JS_Admin->get_path(),
			[ \WK\WK_AssetHandler::JQuery->value ]
		);
	}

	public function wk_enqueue_front_end(): void {
		wp_enqueue_style(
			\WK\WK_AssetHandler::CSS_Front->value,
			plugin_dir_url( __FILE__ ) . \WK\WK_AssetHandler::CSS_Front->get_path(),
			false,
			WK_VERSION
		);

		wp_enqueue_script(
			\WK\WK_AssetHandler::JS_Front->value,
			plugin_dir_url( __FILE__ ) . \WK\WK_AssetHandler::CSS_Front->get_path(),
			[ \WK\WK_AssetHandler::JQuery->value ]
		);
	}
}

// Plugin init
new WK();