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
if ( ! defined( 'WK_DIR' ) ) {
	define( 'WK_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'WK_DIR_CORE' ) ) {
	define( 'WK_DIR_CORE', plugin_dir_path( __FILE__ ) . 'core/' );
}
if ( ! defined( 'WK_INTERFACE_DIR' ) ) {
	define( 'WK_INTERFACE_DIR', plugin_dir_path( __FILE__ ) . 'core/interface/' );
}

if ( defined( 'WK_DIR_CORE' ) ) {
    require_once WK_DIR_CORE . 'WK_Init.php';
	new WK_Init();
}
