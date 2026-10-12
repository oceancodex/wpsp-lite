<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\AdminBarMenus\AdminBarMenus as Route;
use WPSPLITE\App\WordPress\AdminBarMenus\wpsp_lite;
use WPSPLITE\App\WordPress\AdminBarMenus\wpsp_lite_tab_dashboard;
use WPSPCORELITE\App\Routes\AdminBarMenus\AdminBarMenusRouteTrait;

class AdminBarMenus {

	use AdminBarMenusRouteTrait;

	/*
	 *
	 */

	public function admin_bar_menus() {
		Route::name('wpsp_lite.')->group(function() {
			Route::admin_bar_menu('wpsp_lite', [wpsp_lite::class], ['priority' => 100]);
			Route::admin_bar_menu('wpsp_lite_tab_dashboard', [wpsp_lite_tab_dashboard::class]);
		});
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}