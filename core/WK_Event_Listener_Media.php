<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_Media implements WK_Consts {
	public function __construct() {
		add_action( 'add_attachment', [ $this, 'media_uploaded' ] );
		add_action( 'delete_attachment', [ $this, 'media_deleted' ] );
	}

	public function media_uploaded(): bool {
		// Filter $_POST array for security
		$post_array = filter_input_array( INPUT_POST );

		return false;
	}

	public function media_deleted(): bool {
		return false;
	}
}