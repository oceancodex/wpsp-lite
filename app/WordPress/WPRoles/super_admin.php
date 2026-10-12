<?php

namespace WPSPLITE\App\WordPress\WPRoles;

use WPSPLITE\App\Services\TestService;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPCORELITE\App\WordPress\WPRoles\BaseWPRole;

class super_admin extends BaseWPRole {

	use InstancesTrait;

//	public $role         = 'super_admin';
	public $display_name = 'Super Admin';
	public $capabilities = [
		'wpsp_lite',
		'edit_pages',
		'manage_options',
//		'edit_themes',
	];

	/*
	 *
	 */

//	public function __wpspConstruct(TestService $testService) {}

	/*
	 *
	 */

	public function customProperties() {
//		$this->capabilities = [];
	}

}