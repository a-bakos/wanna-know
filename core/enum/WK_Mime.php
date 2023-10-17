<?php

namespace WK;

enum WK_Mime: string {
	case App   = 'application';
	case Text  = 'text';
	case Image = 'image';
	case Video = 'video';
	case Other = 'other';

	public static function get_mime_type( int $post_id ): ?array {
		if ( ! $post_id ) {
			return null;
		}

		$mime_type = get_post_mime_type( $post_id );
		$mime      = explode( '/', $mime_type );

		if ( self::App->value == $mime[0] ) {
			$office_doc = preg_match( '/\.document/', $mime[1] );
			$office_ppt = preg_match( '/\.presentation/', $mime[1] );
			$office_xls = preg_match( '/\.sheet/', $mime[1] );

			// Doc type
			if ( 1 == $office_doc ) {
				$mime[1] = 'doc';
			}
			if ( 1 == $office_ppt ) {
				$mime[1] = 'ppt';
			}
			if ( 1 == $office_xls ) {
				$mime[1] = 'xls';
			}
		}

		if ( 0 < count( $mime ) ) {

			// Missing type
			if ( empty( $mime[1] ) ) {
				$mime[1] = 'empty';
			}

			return match ( $mime[0] ) {
				self::App->value   => [
					'group' => self::App->value,
					'type'  => $mime[1],
				],
				self::Text->value  => [
					'group' => self::Text->value,
					'type'  => $mime[1],
				],
				self::Image->value => [
					'group' => self::Image->value,
					'type'  => $mime[1],
				],
				self::Video->value => [
					'group' => self::Video->value,
					'type'  => $mime[1],
				],
				default            => [
					'group' => self::Other->value,
					'type'  => $mime[1],
				],
			};
		}

		return null;
	}
}