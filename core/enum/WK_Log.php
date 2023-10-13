<?php

namespace WK;

enum WK_Log: int {
	case Post     = 1;
	case Media    = 2;
	case Category = 3;
	case Menu     = 4;
	case Plugin   = 5;
	case Theme    = 6;
	case User     = 7;
	case Unknown  = 0;
}