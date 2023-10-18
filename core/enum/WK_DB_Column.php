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
}