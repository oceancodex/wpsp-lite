<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Http\Middleware\AdministratorCapability;
use WPSPLITE\App\Http\Middleware\EditorCapability;
use WPSPLITE\App\Http\Middleware\TestMiddleware;
use WPSPLITE\App\Widen\Routes\RewriteFrontPages\RewriteFrontPages as Route;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\App\Http\Middleware\AuthenticationMiddleware;
use WPSPLITE\App\Http\Middleware\EnsureEmailIsVerified;
use WPSPLITE\App\WordPress\RewriteFrontPages\wpsp_lite_auth;
use WPSPLITE\App\WordPress\RewriteFrontPages\wpsp_lite_rewrite_demo;
use WPSPLITE\App\WordPress\RewriteFrontPages\wpsp_lite;
use WPSPLITE\App\WordPress\RewriteFrontPages\wpsp_lite_rewrite;
use WPSPLITE\App\WordPress\RewriteFrontPages\wpsp_lite_with_template;
use WPSPCORELITE\App\Routes\RewriteFrontPages\RewriteFrontPagesRouteTrait;

class RewriteFrontPages {

	use InstancesTrait, RewriteFrontPagesRouteTrait;

	/*
	 *
	 */

	public function rewrite_front_pages() {
		Route::name('wpsp_lite_auth.')->prefix('wpsp-lite-auth')->group(function() {
			Route::get('login', [wpsp_lite_auth::class, 'login'])->name('login');
			Route::get('register', [wpsp_lite_auth::class, 'register'])->name('register');
			Route::get('forgot-password', [wpsp_lite_auth::class, 'forgotPassword'])->name('forgot_password');
			Route::get('reset-password/{token}', [wpsp_lite_auth::class, 'resetPassword'])->name('reset_password');
		});
		Route::name('wpsp_lite_verification.')->prefix('wpsp-lite-verification')->group(function() {
			Route::get('/email/resend', [wpsp_lite_auth::class, 'resend'])->name('resend');
			Route::get('/email/notice', [wpsp_lite_auth::class, 'notice'])->name('notice');
			Route::get('/email/verify/{id}/{hash}', [wpsp_lite_auth::class, 'verify'])->middleware(AuthenticationMiddleware::class)->name('verify');
		});
		Route::name('wpsp_lite.')->group(function() {
			Route::get('wpsp-lite\/(?P<endpoint>[^\/]+)$', [wpsp_lite::class, 'index'])/*->middleware(AuthenticationMiddleware::class, EnsureEmailIsVerified::class)*/->name('index');
			Route::post('wpsp-lite\/(?P<endpoint>[^\/]+)$', [wpsp_lite::class, 'update']);
			Route::get('wpsp-lite-rewrite\/(.*?)\/?$', [wpsp_lite_rewrite::class, 'index']);
			Route::get('wpsp-lite-rewrite-params(?P<queries>.*)$', [wpsp_lite_rewrite::class, 'index'], ['force_regex' => true]);
//			Route::get('wpsp-lite-rewrite/{slug}', [wpsp_lite_rewrite::class, 'index']);
			Route::get('wpsp-lite-with-template\/?$', [wpsp_lite_with_template::class, 'index']);
		});
		Route::name('wpsp_lite_rewrite_demo.')->prefix('wpsp-lite-rewrite-demo')->group(function() {
//			Route::get('\/([\S\s]*)\/([\S\s]*)', [rewrite_demo::class, 'index'])->name('index');
//			Route::get('\/([\S\s]*)\/(?P<endpoint>[^\/]+)', [rewrite_demo::class, 'index'])->name('index');

			Route::middleware([
				['relation' => 'OR', 'throttle:30rpm', EditorCapability::class],
				['relation' => 'AND', AdministratorCapability::class, TestMiddleware::class]
			])->get('wpsp-lite-test\/(?P<slug>[^\/\?]+)(?:\?(?P<queries>.*))?', [wpsp_lite_rewrite_demo::class, 'index'], ['route_arg_1' => 'route_arg_1_value'])->name('index');

//			Route::middleware([
//				'relation' => 'OR', 'throttle:30rpm', EditorCapability::class
//			])->get('test\/(?P<slug>[^\/\?]+)(?:\?(?P<queries>.*))?', [rewrite_demo::class, 'index'], ['route_arg_1' => 'route_arg_1_value'])->name('index');

//			Route::middleware([
//				'relation' => 'OR', 'throttle:30rpm', [EditorCapability::class, 'handle']
//			])->get('test\/(?P<slug>[^\/\?]+)(?:\?(?P<queries>.*))?', [rewrite_demo::class, 'index'], ['route_arg_1' => 'route_arg_1_value'])->name('index');

//			Route::middleware(
//				'throttle:30rpm', EditorCapability::class
//			)->get('test\/(?P<slug>[^\/\?]+)(?:\?(?P<queries>.*))?', [rewrite_demo::class, 'index'], ['route_arg_1' => 'route_arg_1_value'])->name('index');
//
//			Route::middleware(EditorCapability::class)->get('test\/(?P<slug>[^\/\?]+)(?:\?(?P<queries>.*))?', [rewrite_demo::class, 'index'], ['route_arg_1' => 'route_arg_1_value'])->name('index');

//			Route::get('\/child\/(.*?)\/?', [rewrite_demo::class, 'index'])->name('index');
//			Route::get('\/(?P<slug1>[^\/]+)\/(?P<slug2>[^\/]+)\/?', [rewrite_demo::class, 'index'])->name('index');
//			Route::get('/{slug1?}/{slug2?}', [rewrite_demo::class, 'index'])->name('index');
//			Route::get('/child/{slug1?}/{slug2?}', [rewrite_demo::class, 'index'])->name('index');
		});
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}