<?php

namespace WK;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

enum WK_Post_Type: int {
	case Post     = 1; // Normals posts. This is the default for everything if not specified otherwise.
	case File     = 2; // Files, attachments, or media uploads
	case Revision = 3; // Post revisions
	case Category = 4; // Category
	case Taxonomy = 5; // Taxonomy
	case Plugin   = 6; // Plugin
	case Theme    = 7; // Theme
	case User     = 8; // User
	case Menu     = 9; // Menu

	public function get_name(): string {
		return match ( $this ) {
			self::Post     => 'post',
			self::File     => 'file',
			self::Revision => 'revision',
			self::Category => 'category',
			self::Taxonomy => 'taxonomy',
			self::Plugin   => 'plugin',
			self::Theme    => 'theme',
			self::User     => 'user',
			self::Menu     => 'menu',
			default        => 'unknown'
		};
	}
}