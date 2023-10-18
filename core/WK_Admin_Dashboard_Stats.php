<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Admin_Dashboard_Stats implements WK_Consts {
	public function __construct() {
		// Only show the metabox/widget to users who have the required capability.
		//if ( WK_Users::is_access_granted_for_current_role() ) {
		add_action( 'wp_dashboard_setup', function () {
			add_meta_box(
				'wk-dashboard-stats-metabox',
				'WK STATS',
				[ $this, 'wk_dashboard_stats_metabox' ],
				'dashboard',
				'side',
				'high'
			);
		} );
		//}
	}

	public function wk_dashboard_stats_metabox(): void {
		echo 'HELLO STATS METABOX';
	}
}