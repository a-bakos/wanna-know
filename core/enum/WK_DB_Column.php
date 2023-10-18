<?php

namespace WK;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

enum WK_DB_Column: string {
	case ID                = 'id';
	case User_ID           = 'user_id';
	case User_Email        = 'user_email';
	case Event_ID          = 'event_id';
	case Subject_ID        = 'subject_id';
	case Subject_Title     = 'subject_title';
	case Subject_URL       = 'subject_url';
	case Subject_Old_Value = 'subject_old_value';
	case Subject_New_Value = 'subject_new_value';
	case Subject_Type      = 'subject_type';
	case Description       = 'description';
	case Datetime          = 'datetime';

	public function description(): string {
		return match ( $this ) {
			self::ID                => 'The auto-allocated row index',
			self::User_ID           => 'ID of the user performed who the action',
			self::User_Email        => 'Email of the user performed who the action',
			self::Event_ID          => 'Event/action ID',
			self::Subject_ID        => 'ID of the subject (eg. post) the user interacted with',
			self::Subject_Title     => 'Post Title where applicable',
			self::Subject_URL       => 'Post URL where applicable',
			self::Subject_Old_Value => 'Subject value changed from',
			self::Subject_New_Value => 'Subject value changed to',
			self::Subject_Type      => 'The type of the post, e.g. Post, Media',
			self::Description       => 'Any additional information if needed',
			self::Datetime          => 'Date/time of the event/action happened',
		};
	}
}