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

// Version definiton
$plugin_data    = get_file_data( __FILE__, [ 'Version' => 'Version' ], false );
$plugin_version = (string) $plugin_data['Version'] ?? '0.0.0';
define( 'WK_VERSION', $plugin_version );

// File includes
require_once WK_DIR_INTERFACE . 'WK_Consts.php';
require_once WK_DIR_CORE . 'WK_DB.php';
require_once WK_DIR_CORE . 'WK_Init.php';

// Plugin init
new WK_Init();
