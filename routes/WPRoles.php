<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\WPRoles\WPRoles as Route;
use WPSPLITE\App\WordPress\WPRoles\super_admin;
use WPSPCORELITE\App\Routes\WPRoles\WPRolesRouteTrait;

class WPRoles {

	use WPRolesRouteTrait;

	/*
	 *
	 */

	public function wp_roles() {
		Route::wp_role('super_admin', [super_admin::class])->name('super_admin');
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}