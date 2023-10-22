<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Admin_Dashboard_Feed extends WK_Access_Control implements WK_Consts {
	public function __construct() {
		if ( $this->user_has_access( get_current_user_id() ) ) {
			add_action( 'wp_dashboard_setup', function () {
				add_meta_box(
					'wk-dashboard-feed-metabox',
					'WK LOG',
					[ $this, 'wk_dashboard_feed_metabox' ],
					'dashboard',
					'side',
					'high'
				);
			} );
		}
	}

	public function wk_dashboard_feed_metabox(): void {
		echo 'HELLO FEED METABOX';
	}
}