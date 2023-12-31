<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Admin_Dashboard_Feed implements WK_Consts {
	public function __construct() {
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

	public function wk_dashboard_feed_metabox(): void {
		echo 'HELLO FEED METABOX';
	}
}