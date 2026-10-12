<?php

namespace WPSPLITE\App\WordPress\Schedules;

use WPSPLITE\App\Services\TestService;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPCORELITE\App\WordPress\Schedules\BaseSchedule;

class custom_schedule extends BaseSchedule {

	use InstancesTrait;

//	public $hook     = 'custom_schedule';
//	public $interval = 'everyMinute';

	/*
	 *
	 */

//	public function __wpspConstruct(TestService $testService) {
//		error_log('Schedule "custom-schedule-2" __wpspConstruct!');
//	}

	/*
	 *
	 */

//	public function __invoke(TestService $testService) {
//		$this->handle($testService);
//	}

	/*
	 *
	 */

	public function handle(TestService $testService) {
		// Code here...
		error_log('Schedule "custom_schedule" fired! - Direct call with dependency injection - ' . $testService->test());
	}

}