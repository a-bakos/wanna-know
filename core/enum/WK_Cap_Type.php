<?php

namespace WK;

enum CAP_TYPE: string {
	case Admin = WK_Consts::ADMIN_CAP;
	case Super = WK_Consts::WK_CAP;
}