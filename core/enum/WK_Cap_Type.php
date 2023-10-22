<?php

namespace WK;

enum WK_Cap_Type: string {
	case Admin = WK_Consts::ADMIN_CAP;
	case Super = WK_Consts::WK_CAP;
}