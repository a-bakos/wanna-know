<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_Event_Listener_Media implements WK_Consts {
	use WK_Current_User;

	public function __construct() {
		add_action( 'add_attachment', [ $this, 'media_uploaded' ] );
		add_action( 'delete_attachment', [ $this, 'media_deleted' ] );
	}

	public function media_uploaded( int $attachment_id = null ): bool {
		// Filter $_POST array for security
		$post_array = filter_input_array( INPUT_POST );
		$key_action = 'action';

		if (
			isset( $post_array[ $key_action ] ) &&
			$post_array[ $key_action ] === WK_Action_Type::UPLOAD_ATTACHMENT->value
		) {
			$user_data = self::get_userdata();

			// TODO figure out how to do this.
			// $_POST and $_REQUEST do not contain these details
			// This may need to happen at a later stage
			// Maybe create an array with these items and add to description
			/*
			"alt":"",
			"description":"",
			"caption":"",
			"uploadedTo":0,
			"mime":"image\/png",
			"type":"image",
			"subtype":"png",
			"filesizeInBytes":188901,
			"filesizeHumanReadable":"184 KB",
			"height":1348,
			"width":3988,
			"orientation":"landscape",
			*/

			return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
				user_id:           $user_data[ WK_User_Data::ID->value ] ?? self::UNKNOWN_ID,
				event_id:          WK_Event::FILE_UPLOADED->value,
				subject_id:        $attachment_id ?? self::UNKNOWN_ID,
				subject_type:      WK_Subject_Type::File->value,
				subject_title:     $post_array['name'] ?? '',
				subject_url:       '',
				subject_old_value: '',
				subject_new_value: '',
				description:       '',
				user_email:        $user_data[ WK_User_Data::Email->value ],
			) );
		}

		return false;
	}

	public function media_deleted( int $attachment_id = null ): bool {
		$user_data = self::get_userdata();
//		wk_p( $_POST );
//		die;

		$file = get_attached_file( $attachment_id );
		$aux  = basename( $file );

		return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
			user_id:           $user_data['ID'] ?? self::UNKNOWN_ID,
			event_id:          WK_Event::FILE_DELETED->value,
			subject_id:        $attachment_id ?? self::UNKNOWN_ID,
			subject_type:      WK_Subject_Type::File->value,
			subject_title:     '',
			subject_url:       '',
			subject_old_value: '',
			subject_new_value: '',
			description:       '',
			user_email:        $user_data['email'],
		) );

		// todo
		// on delete request, grab ID, filename
		// after delete, go and try to find the ID on a media upload event
		// and connect the deleted log item to that event

		return false;
	}
}