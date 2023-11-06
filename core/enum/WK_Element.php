<?php

namespace WK;

enum WK_Element: string {
	const WK_OPTION_FEED  = 'wk_global_option_enable_widget_feed';
	const WK_OPTION_STATS = 'wk_global_option_enable_widget_stats';
	const WK_OPTION_USERS = 'wk_global_option_enable_widget_users';

	case General         = 'general'; // todo - rename or see if we need this variant
	case Dashboard_Feed  = self::WK_OPTION_FEED;
	case Dashboard_Stats = self::WK_OPTION_STATS;
	case Dashboard_Users = self::WK_OPTION_USERS;

	public function get_name(): string {
		return match ( $this ) {
			self::General         => 'General',
			self::Dashboard_Feed  => 'Dashboard Widget: Feed',
			self::Dashboard_Stats => 'Dashboard Widget: Stats',
			self::Dashboard_Users => 'Dashboard Widget: Users',
		};
	}

	public function get_option_name_for_role( string $role_key ): string {
		return self::construct_option_name( $this->value, $role_key );
	}

	public static function get_option_names_for_roles(): array {
		$option_names_for_roles = [];

		$all_roles = wp_roles();
		if ( ! empty( $all_roles ) ) {
			foreach ( self::cases() as $element ) {
				foreach ( $all_roles->role_names as $role_key => $role_name ) {
					$option_names_for_roles[] = self::construct_option_name( $element->value, $role_key );
				}
			}
		}

		return $option_names_for_roles;
	}

	public static function construct_option_name( string $option_variant, string $role_key ): string {
		return $option_variant . '_for_' . $role_key;
	}

}