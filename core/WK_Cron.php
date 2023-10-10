<?php

namespace WK;

readonly final class WK_Cron implements WK_Consts {

	final public const CRON_HANDLE_CLEAR_LOGS = 'wk_clear_logs';
	final public const EVENT_SCHEDULE         = 'daily';

	public function __construct() {
		//	$this->schedule_events();
		//	$this->clear_logs_cron_function_callback();

		//	$this->unschedule_events();
	}

	/**
	 *  Add the CRON schedule.
	 *
	 * @return void
	 */
	private function schedule_events(): void {
		// Verify event has not been scheduled.
		if ( ! wp_next_scheduled( self::CRON_HANDLE_CLEAR_LOGS ) ) {
			// time() is server time.
			wp_schedule_event( time(), self::EVENT_SCHEDULE, self::CRON_HANDLE_CLEAR_LOGS );
		}
		// When the hook is called, execute the function.
		add_action( self::CRON_HANDLE_CLEAR_LOGS, [ $this, 'clear_logs_cron_callback' ] );

		// During testing CRON jobs, you may occasionally need to disable the current event:
		// $this->unschedule_events();
	}

	/**
	 * Unschedule custom CRON events.
	 *
	 * @return void
	 */
	private function unschedule_events(): void {
		wp_unschedule_event( time(), self::CRON_HANDLE_CLEAR_LOGS );
		wp_clear_scheduled_hook( self::CRON_HANDLE_CLEAR_LOGS );
	}

	/**
	 * The CRON logic to run when the database cleaning happens.
	 *
	 * @return void
	 */
	public function clear_logs_cron_callback(): void {
		// $clean_log_interval = (int) get_option( WK::SETTING_NAME['log_clean_interval'] );
		// if ( $clean_log_interval ) {
		// 	( new WK_DB() )?->delete_rows_older_than( $clean_log_interval );
		// }
	}
}