<?php

namespace WK;

enum WK_Event_Detail_Category: string {
	case Taxonomy = 'tax';
	case Name     = 'name';
	case Slug     = 'slug';
}