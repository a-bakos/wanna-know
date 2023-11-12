<?php

namespace WK;

enum WK_User_Data: string {
	case ID         = 'ID';
	case Login      = 'login';
	case Email      = 'email';
	case FullName   = 'full_name';
	case FirstName  = 'first_name';
	case LastName   = 'last_name';
	case Role       = 'role';
	case ProfileURL = 'profile_url';

	public static function compile(
		int $user_id,
		string $login,
		string $email,
		string $full_name,
		string $first_name,
		string $last_name,
		array $roles,
		string $profile_url,
	): array {
		return [
			WK_User_Data::ID->value         => $user_id,
			WK_User_Data::Login->value      => $login,
			WK_User_Data::Email->value      => $email,
			WK_User_Data::FullName->value   => $full_name,
			WK_User_Data::FirstName->value  => $first_name,
			WK_User_Data::LastName->value   => $last_name,
			WK_User_Data::Role->value       => $roles,
			WK_User_Data::ProfileURL->value => $profile_url,
		];
	}
}