<?php

namespace WK;
readonly final class WK_Events {
	public function __construct() {}

	public static function get_by_code( int $event_code ): WK_Event {
		return WK_Event::tryFrom( $event_code ) ?? WK_Event::UNKNOWN;
	}

}