<?php

namespace WPSPLITE\App\WordPress\Schedules;

use WPSPLITE\App\Services\TestService;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\App\WordPress\License\License;
use WPSPCORELITE\App\WordPress\Schedules\BaseSchedule;

class CheckLicenseSchedule extends BaseSchedule {

	use InstancesTrait;

//	public $hook     = 'custom_schedule';
//	public $interval = 'hourly';

	public function handle(TestService $testService) {
//		error_log('Run schedule: CheckLicenseSchedule');
		error_log('Run schedule: CheckLicenseSchedule => ' . $testService->test() . ' => ' . $testService->subTestService->subTest());
		$checkLicense = License::checkLicense(true);
		error_log(print_r($checkLicense, true));
	}

}