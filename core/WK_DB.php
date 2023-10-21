<?php

namespace WK;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly final class WK_DB implements WK_Consts {

	public string $main_table;

	public function __construct() {
		global $wpdb;
		$this->main_table = $wpdb->prefix . self::MAIN_TABLE_NAME;
	}

	public function create_main_table(): void {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$id                = WK_DB_Column::ID->value;
		$user_id           = WK_DB_Column::User_ID->value;
		$user_email        = WK_DB_Column::User_Email->value;
		$event_id          = WK_DB_Column::Event_ID->value;
		$subject_id        = WK_DB_Column::Subject_ID->value;
		$subject_title     = WK_DB_Column::Subject_Title->value;
		$subject_url       = WK_DB_Column::Subject_URL->value;
		$subject_old_value = WK_DB_Column::Subject_Old_Value->value;
		$subject_new_value = WK_DB_Column::Subject_New_Value->value;
		$subject_type      = WK_DB_Column::Subject_Type->value;
		$description       = WK_DB_Column::Description->value;
		$datetime          = WK_DB_Column::Datetime->value;

		$sql = "CREATE TABLE IF NOT EXISTS $this->main_table (
			$id INT UNSIGNED NOT NULL AUTO_INCREMENT,
			$user_id INT UNSIGNED NOT NULL,
			$user_email VARCHAR(500) DEFAULT '',
			$event_id SMALLINT UNSIGNED NOT NULL,
			$subject_id INT UNSIGNED NOT NULL,
			$subject_title VARCHAR(500) DEFAULT '',
			$subject_url VARCHAR(500) DEFAULT '',
			$subject_old_value TEXT DEFAULT '',
			$subject_new_value TEXT DEFAULT '',
			$subject_type TINYINT UNSIGNED NOT NULL,
			$description TEXT DEFAULT '',
			$datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	public static function prepare_log_item(
		int $user_id,
		int $event_id,
		int $subject_id,
		int $subject_type,
		string $subject_title = '',
		string $subject_url = '',
		string $subject_old_value = '',
		string $subject_new_value = '',
		string $description = '',
		string $user_email = '',
	): array {
		$log_data = [];

		$log_data[] = $user_id ?: self::UNKNOWN_ID;
		$log_data[] = base64_encode( $user_email );
		$log_data[] = $event_id ?: WK_Event::UNKNOWN->value;
		$log_data[] = $subject_id ?: self::UNKNOWN_POST_ID;
		$log_data[] = $subject_title;
		$log_data[] = $subject_url;
		$log_data[] = $subject_old_value;
		$log_data[] = $subject_new_value;
		$log_data[] = $subject_type ?: WK_Log::Unknown->value;
		$log_data[] = $description;

		return $log_data;
	}

	// todo - insert_log_item to return bool on successful insertion
	public function insert_log_item( array $log_data ): ?bool {
		if ( ! $log_data ) {
			return null;
		}

		global $wpdb;

		$values_to_insert = [
			WK_DB_Column::User_ID->value           => $log_data[0],
			WK_DB_Column::User_Email->value        => $log_data[1],
			WK_DB_Column::Event_ID->value          => $log_data[2],
			WK_DB_Column::Subject_ID->value        => $log_data[3],
			WK_DB_Column::Subject_Title->value     => $log_data[4],
			WK_DB_Column::Subject_URL->value       => $log_data[5],
			WK_DB_Column::Subject_Old_Value->value => $log_data[6],
			WK_DB_Column::Subject_New_Value->value => $log_data[7],
			WK_DB_Column::Subject_Type->value      => $log_data[8],
			WK_DB_Column::Description->value       => $log_data[9],
		];

		$format_values = [
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
		];

		$insert = $wpdb->insert( $this->main_table, $values_to_insert, $format_values );

		// Debug:
		// wk_p( $wpdb->insert_id );
		// $wpdb->print_error();

		// $insert is false or number of rows inserted
		if ( $insert ) {
			return true;
		}

		return false;
	}

	public function drop_table(): void {
		global $wpdb;
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $this->main_table );
	}

	/**
	 * Check if a database table exists
	 *
	 * @param string $table_name The table name to check.
	 *
	 * @return bool               True if the table exists, false otherwise.
	 */
	public static function table_exists( string $table_name ): bool {
		global $wpdb;

		$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

		if ( ! $wpdb->get_var( $query ) == $table_name ) {
			return false; // Table doesn't exist.
		} else {
			return true; // Table does exist.
		}
	}

}