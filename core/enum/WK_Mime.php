<?php

namespace WK;

enum WK_Mime: string {
	case App   = 'application';
	case Text  = 'text';
	case Image = 'image';
	case Video = 'video';

	public static function get_mime_type( int $post_id )/*: ?array*/ {
		//
	}
}