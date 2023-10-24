<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_Media extends WK_Current_User implements WK_Consts {
	public function __construct() {
		add_action( 'add_attachment', [ $this, 'media_uploaded' ] );
		add_action( 'delete_attachment', [ $this, 'media_deleted' ] );
	}

	public function media_uploaded(): bool {
		// Filter $_POST array for security
		$post_array = filter_input_array( INPUT_POST );

		// todo debug $post array

		$user_data = self::get_userdata();

		$media_id = 0; // TODO

		return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
			user_id:           $user_data['ID'] ?? self::UNKNOWN_ID,
			event_id:          WK_Event::FILE_UPLOADED->value,
			subject_id:        $media_id,
			subject_type:      WK_Subject_Type::File->value,
			subject_title:     '',
			subject_url:       '',
			subject_old_value: '',
			subject_new_value: '',
			description:       '',
			user_email:        $user_data->data->user_email,
		) );

		return false;
	}

	public function media_deleted(): bool {
		return false;
	}
}