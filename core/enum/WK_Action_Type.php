<?php

enum WK_Action_Type: string {
	case UPLOAD_THEME      = 'upload-theme';
	case UPLOAD_PLUGIN     = 'upload-plugin';
	case UPLOAD_ATTACHMENT = 'upload-attachment';
}