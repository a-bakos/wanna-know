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
}