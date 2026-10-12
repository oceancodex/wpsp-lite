<?php

namespace WPSPLITE\App\Providers;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\ServiceProvider;
use WPSPLITE\App\Services\TestService;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 */
	public function register() {
		//
		$this->app->instance('test_service', new TestService());
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
		//
	}

}