<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_Category implements WK_Consts {
	use WK_Current_User;

	private ?array $user_data;

	public function __construct() {
		$this->user_data = self::get_userdata();
		add_action( 'create_category', [ $this, 'category_created' ] );
		add_action( 'edit_category', [ $this, 'category_edited' ] );
		add_action( 'delete_term_taxonomy', [ $this, 'term_deleted' ] );
	}

	public function category_created( ?int $category_id = null ): bool {
		if ( ! $category_id ) {
			return false;
		}

		$category = get_term( $category_id );

		if ( ! $category ) {
			return false;
		}

		return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
			user_id:       $this->user_data[ WK_User_Data::ID->value ] ?? self::UNKNOWN_ID,
			event_id:      WK_Event::CATEGORY_CREATED->value,
			subject_id:    $category->term_id ?? self::UNKNOWN_ID,
			subject_type:  WK_Subject_Type::Category->value,
			subject_title: $category->name ?? self::EMPTY_STRING,
			subject_url:   $category->slug,
			description:   json_encode( [ WK_Event_Detail_Category::Taxonomy->value => $category->taxonomy ] ),
			user_email:    $this->user_data[ WK_User_Data::Email->value ],
		) );
	}

	public function category_edited( ?int $category_id = null ): bool {
		if ( ! $category_id ) {
			return false;
		}

		$category_to_change = get_term( $category_id );
		if ( ! $category_to_change ) {
			return false;
		}

		$key_action   = 'action'; // TODO: may add this to consts
		$action_value = 'editedtag'; // TODO: Create enum for WP action values

		$updated_category = isset( $_POST[ $key_action ] ) && $_POST[ $key_action ] === $action_value ? $_POST : null; // TODO: validate $post
		if ( ! $updated_category ) {
			return false;
		}
		$old_cat_values[ WK_Event_Detail_Category::Name->value ] = $category_to_change->{WK_Event_Detail_Category::Name->value};
		$old_cat_values[ WK_Event_Detail_Category::Slug->value ] = $category_to_change->{WK_Event_Detail_Category::Slug->value};

		return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
			user_id:           $this->user_data[ WK_User_Data::ID->value ] ?? self::UNKNOWN_ID,
			event_id:          WK_Event::CATEGORY_EDITED->value,
			subject_id:        $category_to_change->term_id ?? self::UNKNOWN_ID,
			subject_type:      WK_Subject_Type::Category->value,
			subject_title:     $updated_category[ WK_Event_Detail_Category::Name->value ] ?? self::EMPTY_STRING,
			subject_url:       $updated_category[ WK_Event_Detail_Category::Slug->value ],
			subject_old_value: json_encode( $old_cat_values ),
			description:       json_encode( [ WK_Event_Detail_Category::Taxonomy->value => $category_to_change->taxonomy ] ),
			user_email:        $this->user_data[ WK_User_Data::Email->value ],
		) );
	}

	public function term_deleted( ?int $category_id = null ): bool {
		if ( ! $category_id ) {
			return false;
		}

		$category = get_term( $category_id );
		if ( ! $category ) {
			return false;
		}

		return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
			user_id:       $this->user_data[ WK_User_Data::ID->value ] ?? self::UNKNOWN_ID,
			event_id:      WK_Event::CATEGORY_DELETED->value,
			subject_id:    $category_id,
			subject_type:  WK_Subject_Type::Category->value,
			subject_title: $category->{WK_Event_Detail_Category::Name->value} ?? self::EMPTY_STRING,
			subject_url:   $category->{WK_Event_Detail_Category::Slug->value},
			description:   json_encode( [ WK_Event_Detail_Category::Taxonomy->value => $category->taxonomy ] ),
			user_email:    $this->user_data[ WK_User_Data::Email->value ],
		) );
	}

}
/*
// Prototype:

( new WK_DB() )?->insert_log_item( WK_Log_Item $log_item );
( new WK_DB() )?->insert_log_item( new WK_Log_Item( 101, WK_Event::CATEGORY_DELETED, 200, WK_Subject_Type::Category ) );
final readonly class WK_Log_Item {
	public function __construct(
		private int $user_id,
		private WK_Event $event_id,
		private int $subject_id,
		private WK_Subject_Type $subject_type,
	) {

	}
}
*/