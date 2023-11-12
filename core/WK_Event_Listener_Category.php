<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_Category {
	public function __construct() {
		add_action( 'create_category', [ $this, 'category_created' ], 10, 1 );
		add_action( 'edit_category', [ $this, 'category_edited' ], 10, 1 );
		add_action( 'delete_term_taxonomy', [ $this, 'term_deleted' ], 10, 1 );
	}

	public function category_created() {}

	public function category_edited() {}

	public function term_deleted() {}

}