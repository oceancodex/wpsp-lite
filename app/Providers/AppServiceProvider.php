<?php

namespace WPSPLITE\App\Providers;

use WPSPCORELITE\App\Cache\RateLimiting\Limit;
use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\ServiceProvider;
use WPSPLITE\App\Services\TestService;
use WPSPLITE\App\Widen\Config\Config;
use WPSPLITE\App\Widen\Support\Facades\Gate;
use WPSPLITE\App\Widen\Support\Facades\RateLimiter;
use WPSPLITE\App\Widen\View\BladeOne;
use WPSPLITE\App\Policies\ExamplePolicy;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 */
	public function register() {
		// Sử dụng "hassankhan/config" để có config như Laravel.
//		$this->app->instance('config', Config::instance());

		// Sử dụng "eftec/bladeone" để có Blade Engine như Laravel.
//		$this->app->singleton('view', fn() => BladeOne::instance());

		// Bind test service.
		$this->app->singleton('test_service', fn() => new TestService());
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
		// Đăng ký rate limiter với name 30rpm.
		RateLimiter::for('30rpm', function (Request $request) {
			return Limit::perMinute(30);
		});

		// Cho DefaultPolicy gắn với class name WP_User.
		Gate::policy(\WP_User::class, ExamplePolicy::class);
	}

}