<?php
final class WK_Init implements WK_Consts {
    public function __construct() {
        $this->plugin_setup();
    }

    /**
	 * Plugin setup processes.
	 */
    private function plugin_setup(): void {
		// Register plugin activation/deactivation hooks.
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
		// Create DB table
		// ( new WDI_DB() )->create_main_table( WK_Consts::MAIN_TABLE_NAME );

		// Register admin rights
	}

    /**
	 * Plugin deactivation & clean up processes.
	 *
	 * @return void
	 */
    public function plugin_deactivate(): void {
		// Maybe Drop the main database table

		// Maybe delete all plugin settings

		// Remove user rights
	}

	/**
	 * Check PHP version function hook
	 *
	 * Hooks into the init, checks the PHP version - if lower than required, it
	 * disables the plugin and adds a warning notice to the admin area.
	 *
	 * @return void
	 */
	public function wk_check_php(): void {
		if ( version_compare( PHP_VERSION, WK_Consts::MINIMUM_PHP_VERSION, '<' ) ) {
			$plugin = plugin_basename( __FILE__ );

			if ( is_plugin_active( $plugin ) ) {
				deactivate_plugins( $plugin );
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
		//add_action( 'wp_enqueue_scripts', [ $this, 'wk_enqueue_frontend' ] );
		//add_action( 'admin_enqueue_scripts', [ $this, 'wk_enqueue_admin' ] );
	}

	/**
	 * Enqueue styles and scripts.
	 *
	 * @param   string  $hook  Hook comes from core WP load and is the name of
	 *                         the current view.
	 *
	 * @return void
	 */
	public function wk_enqueue_admin( $hook ): void {
		wp_enqueue_style(
			WK_Consts::ASSET_HANDLERS['admin']['css'],
			plugin_dir_url( __FILE__ ) . WK_Consts::WK_ASSET_PATH['admin']['css'],
			false,
			WK_Consts::VERSION
		);

		wp_enqueue_script(
			WK_Consts::ASSET_HANDLERS['admin']['js'],
			plugin_dir_url( __FILE__ ) . WK_Consts::WK_ASSET_PATH['admin']['js'],
			[ 'jquery' ]
		);
	}

	public function wk_enqueue_front_end( $hook ): void {
		wp_enqueue_style(
			WK_Consts::ASSET_HANDLERS['front']['css'],
			plugin_dir_url( __FILE__ ) . WK_Consts::WK_ASSET_PATH['front']['css'],
			false,
			WK_Consts::VERSION
		);

		wp_enqueue_script(
			WK_Consts::ASSET_HANDLERS['front']['js'],
			plugin_dir_url( __FILE__ ) . WK_Consts::WK_ASSET_PATH['front']['js'],
			[ 'jquery' ]
		);
	}
}