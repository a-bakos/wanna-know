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
		$this->main_table = $wpdb->prefix . WK_Consts::MAIN_TABLE_NAME;
	}

	public function create_main_table(): void {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		/**
		 * Table columns definitions:
		 *
		 * - id                => the auto-allocated row index
		 * - user_id           => ID of the user performed who the action
		 * - user_email        => Email of the user performed who the action
		 * - event_id          => Event/action ID
		 * - subject_id        => ID of the subject (eg. post) the user interacted with
		 * - subject_title     => Post Title where applicable
		 * - subject_url       => Post URL where applicable
		 * - subject_old_value => Subject value changed from
		 * - subject_new_value => Subject value changed to
		 * - subject_type      => The type of the post, e.g. Post, Media
		 * - description       => Any additional information if needed
		 * - datetime          => Date/time of the event/action happened
		 */
		$sql = "CREATE TABLE IF NOT EXISTS $this->main_table (
			id INT UNSIGNED NOT NULL AUTO_INCREMENT,
			user_id INT UNSIGNED NOT NULL,
			user_email VARCHAR(500) DEFAULT '',
			event_id SMALLINT UNSIGNED NOT NULL,
			subject_id INT UNSIGNED NOT NULL,
			subject_title VARCHAR(500) DEFAULT '',
			subject_url VARCHAR(500) DEFAULT '',
			subject_old_value TEXT DEFAULT '',
			subject_new_value TEXT DEFAULT '',
			subject_type TINYINT UNSIGNED NOT NULL,
			description TEXT DEFAULT '',
			datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
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

		$log_data[] = $user_id ?: WK_Consts::UNKNOWN_USER_ID;
		$log_data[] = $user_email;
		$log_data[] = $event_id ?: WK_Event::UNKNOWN->value;
		$log_data[] = $subject_id ?: WK_Consts::UNKNOWN_POST_ID;
		$log_data[] = $subject_title;
		$log_data[] = $subject_url;
		$log_data[] = $subject_old_value;
		$log_data[] = $subject_new_value;
		$log_data[] = $subject_type ?: WK_Log::Unknown->value;
		$log_data[] = $description;

		return $log_data;
	}

	public function insert_log_item( array $log_data ) {
		if ( ! $log_data ) {
			return;
		}

		global $wpdb;

		$values_to_insert = [
			'user_id'           => $log_data[0],
			'user_email'        => $log_data[1],
			'event_id'          => $log_data[2],
			'subject_id'        => $log_data[3],
			'subject_title'     => $log_data[4],
			'subject_url'       => $log_data[5],
			'subject_old_value' => $log_data[6],
			'subject_new_value' => $log_data[7],
			'subject_type'      => $log_data[8],
			'description'       => $log_data[9],
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

		//wk_p( $wpdb->insert_id );
		//$wpdb->print_error();
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