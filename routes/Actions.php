<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Http\Controllers\AssetsController;
use WPSPLITE\App\Http\Controllers\PagesController;
use WPSPLITE\App\Widen\Routes\Actions\Actions as Route;
use WPSPLITE\App\Widen\Routes\RouteManager;
use WPSPLITE\Funcs;
use WPSPCORELITE\App\Routes\Actions\ActionsRouteTrait;

class Actions {

	use ActionsRouteTrait;

	/*
	 *
	 */

	public function actions() {
//		Route::action('wp_head', [PagesController::class, 'index']);
//		Route::action('save_post', [PagesController::class, 'save_post'], ['accepted_args' => 3]);
		Route::action('admin_enqueue_scripts', [AssetsController::class, 'backend']);
		Route::action('wp_enqueue_scripts', [AssetsController::class, 'frontend']);
//		Route::action('current_screen', [PagesController::class, 'edit_user_screen']);
	}

	/*
	 *
	 */

	public function wp_actions() {}

}