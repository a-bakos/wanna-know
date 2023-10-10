<?php

namespace WK;

readonly final class WK_Events {
	public function __construct() {}

	public static function get_by_code( int $event_code ): WK_Event {
		return WK_Event::tryFrom( $event_code ) ?? WK_Event::UNKNOWN;
	}

	/**
	 * Get event description by event code or enum variant
	 */
	public static function get_event( int|WK_Event $event ): ?array {
		if ( ! $event ) {
			return null;
		}

		if ( is_int( $event ) ) {
			return self::get_by_code( $event )->details();
		}

		return $event->details();
	}

	public static function get_event_icon( int|WK_Event $event ): ?string {
		if ( ! $event ) {
			return null;
		}

		return self::get_event( $event )[ WK_EventInfo::Icon->value ];
	}

	public static function get_event_description( int|WK_Event $event ): ?string {
		if ( ! $event ) {
			return null;
		}

		return self::get_event( $event )[ WK_EventInfo::Description->value ];
	}

	public static function get_event_filter_name( int|WK_Event $event ): ?string {
		if ( ! $event ) {
			return null;
		}

		return self::get_event( $event )[ WK_EventInfo::FilterName->value ];
	}
}