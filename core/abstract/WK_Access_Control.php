<?php

namespace WK;

abstract readonly class WK_Access_Control {
	public function user_has_access( CAP_TYPE|int $cap_or_id = CAP_TYPE::Super ): bool {
		return match ( is_int( $cap_or_id ) ) {
			true  => user_can( $cap_or_id, CAP_TYPE::Super->value ),
			false => current_user_can( $cap_or_id->value ),
		};
	}
}

enum CAP_TYPE: string {
	case Admin = WK_Consts::ADMIN_CAP;
	case Super = WK_Consts::WK_CAP;
}