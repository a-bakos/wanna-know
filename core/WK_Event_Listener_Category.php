<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_Category implements WK_Consts {
	use WK_Current_User;

	public function __construct() {
		add_action( 'create_category', [ $this, 'category_created' ], 10, 1 );
		add_action( 'edit_category', [ $this, 'category_edited' ], 10, 1 );
		add_action( 'delete_term_taxonomy', [ $this, 'term_deleted' ], 10, 1 );
	}

	public function category_created( ?int $category_id = null ): bool {
		if ( ! $category_id ) {
			return false;
		}

		$category = get_term( $category_id );

		if ( ! $category ) {
			return false;
		}

		$user_data = self::get_userdata();

		return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
			user_id:       $user_data[ WK_User_Data::ID->value ] ?? self::UNKNOWN_ID,
			event_id:      WK_Event::CATEGORY_CREATED->value,
			subject_id:    $category->term_id ?? self::UNKNOWN_ID,
			subject_type:  WK_Subject_Type::File->value,
			subject_title: $category->name ?? '',
			subject_url:   $category->slug,
			description:   $category->taxonomy,
			user_email:    $user_data[ WK_User_Data::Email->value ],
		) );
	}

	public function category_edited() {}

	public function term_deleted() {}

}