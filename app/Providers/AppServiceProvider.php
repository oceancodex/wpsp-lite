<?php

namespace WPSPLITE\App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\ServiceProvider;
use WPSPCORELITE\App\Http\Request;
use WPSPLITE\App\Widen\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 */
	public function register() {
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
		RateLimiter::for('30rpm', function (Request $request) {
			return Limit::perMinute(30);
		});
	}

}