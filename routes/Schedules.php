<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\Schedules\Schedules as Route;
use WPSPLITE\App\Widen\Support\Facades\Schedule;
use WPSPLITE\App\WordPress\Schedules\CheckLicenseSchedule;
use WPSPLITE\Funcs;
use WPSPCORELITE\App\Routes\Schedules\SchedulesRouteTrait;
use WPSPLITE\App\WordPress\Schedules\custom_schedule;

class Schedules {

	use SchedulesRouteTrait;

	/*
	 *
	 */

	public function schedules() {
		// WordPress schedule system.
		Route::schedule('wpsp_lite_check_license', [CheckLicenseSchedule::class, 'handle'], ['interval' => 'everyMinute']);

		// WPSP schedule system.
//		Schedule::name('WPSP')->call(function() { error_log('Schedule "WPSP" fired! - Closure function'); })->everyMinute();
//		Schedule::name('custom_schedule')->call(function() { (new custom_schedule())->wpspCall('handle'); })->everyMinute();
//		Schedule::name('custom_schedule_run_command')->command('route:remap')->everyMinute();
	}

	/*
	 *
	 */

	public function intervals() {
		Route::interval('everyMinute', 60, 'Every minute');
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}