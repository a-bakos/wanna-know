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

	public function media_uploaded( int $attachment_id = null ): bool {
		// Filter $_POST array for security
		$post_array = filter_input_array( INPUT_POST );

		$key_action = 'action';
		if ( isset( $post_array[ $key_action ] ) && $post_array[ $key_action ] === \WK_Action_Type::UPLOAD_ATTACHMENT ) {
			$user_data = self::get_userdata();

//			$file = get_attached_file( $attachment_id );
//			var_dump( $file );
			/*
						{"success":true,
							"data":{
							"id":23,
							"title":"profitient-training-logo",
							"filename":"profitient-training-logo.png",
							"url":"http:\/\/localhost\/wp\/wp-content\/uploads\/2023\/10\/profitient-training-logo.png",
							"link":"http:\/\/localhost\/wp\/profitient-training-logo\/",
							"alt":"",
							"author":"1",
							"description":"",
							"caption":"",
							"name":"profitient-training-logo",
							"status":"inherit",
							"uploadedTo":0,
							"date":1698263274000,
							"modified":1698263274000,
							"menuOrder":0,
							"mime":"image\/png",
							"type":"image",
							"subtype":"png",
							"dateFormatted":"October 25, 2023",
							"editLink":"http:\/\/localhost\/wp\/wp-admin\/post.php?post=23&action=edit",

							"authorName":"abakos",
							"authorLink":"http:\/\/localhost\/wp\/wp-admin\/profile.php",
							"filesizeInBytes":188901,
							"filesizeHumanReadable":"184 KB",
							"context":"",
							"height":1348,
							"width":3988,
							"orientation":"landscape",
							"sizes":{
								"full":{
									"url":"http:\/\/localhost\/wp\/wp-content\/uploads\/2023\/10\/profitient-training-logo.png",
									"height":1348,
									"width":3988,
									*/

			return ( new WK_DB() )?->insert_log_item( WK_DB::prepare_log_item(
				user_id:           $user_data['ID'] ?? self::UNKNOWN_ID,
				event_id:          WK_Event::FILE_UPLOADED->value,
				subject_id:        $attachment_id ?? self::UNKNOWN_ID,
				subject_type:      WK_Subject_Type::File->value,
				subject_title:     $post_array['name'] ?? '',
				subject_url:       '',
				subject_old_value: '',
				subject_new_value: '',
				description:       '',
				user_email:        $user_data->data->user_email,
			) );
		}

		return false;
	}

	public function media_deleted(): bool {

		// todo
		// on delete request, grab ID, filename
		// after delete, go and try to find the ID on a media upload event
		// and connect the deleted log item to that event

		return false;
	}
}