<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Http\Middleware\PreventRequestForgery;
use WPSPLITE\App\Http\Middleware\PreventRequestForgeryWithoutOrigin;
use WPSPLITE\App\Widen\Routes\Apis\Apis as Route;
use WPSPLITE\App\Http\Controllers\ApisController;
use WPSPLITE\App\Http\Middleware\ApiTokenAuthentication;
use WPSPLITE\App\Http\Middleware\AuthenticationMiddleware;
use WPSPLITE\App\Http\Middleware\SanctumMiddleware;
use WPSPCORELITE\App\Routes\Apis\ApisRouteTrait;

class Apis {

	use ApisRouteTrait;

	/*
	 *
	 */

	public function apis() {
		Route::namespace('wpsp_lite')->version('v1')->group(function() {
			Route::name('users.')->prefix('users')->group(function() {
				Route::middleware(AuthenticationMiddleware::class)->group(function() {
//					Route::post('(?P<id>\w+)/update', [ApisController::class, 'usersUpdate'])->name('update');
					Route::post('{id}/update', [ApisController::class, 'usersUpdate'])->name('update');
				});
			});
			Route::get('test-rate-limit', [ApisController::class, 'wpsp_lite'])->name('test-rate-limit');
			Route::middleware(PreventRequestForgeryWithoutOrigin::class)->post('test-rate-limit-token', [ApisController::class, 'wpsp_lite'])->name('test-rate-limit');
		});
	}

	/*
	 *
	 */

	public function actions() {
//		Route::action('admin_init', function() { echo 'Hello world!'; })->middleware(AdministratorCapability::class)->name('action_init');
	}

	public function filters() {
		/**
		 * Xóa hết các Rest API khỏi /wp-json.
		 * Khi truy cập /wp-json sẽ không hiển thị ra bất cứ Rest API nào cả.
		 * Tuy nhiên các Rest API đã đăng ký vẫn sẽ hoạt động.
		 */
//		Route::filter('rest_index', function(\WP_REST_Response $response) {
//			$response->data = null;
//			return $response;
//		}, 10, 1);

		/**
		 * Đổi prefix "wp-json" mặc định của Rest API thành "api".
		 */
//		Route::filter('rest_url_prefix', function($prefix) {
//			return 'api';
//		}, 10, 1);
	}

}