<?php

namespace WPSPLITE\App\Widen\Support\Facades;

use WPSPCORELITE\App\Cache\RateLimiter as RateLimiterCoreClass;
use WPSPCORELITE\App\Support\Facades\RateLimiter as RateLimiterCore;
use WPSPLITE\App\Widen\Cache\RateLimiter as WidenRateLimiter;
use WPSPLITE\App\Widen\Support\Facades\Cache as CacheFacade;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;

class RateLimiter extends RateLimiterCore {

	use InstancesTrait;

	/** @var RateLimiterCore|null */
	public static $instance = null;

	/**
	 * @return RateLimiterCore|null
	 */
	public static function wpspInstance() {
		if (!static::$instance) {
			$instance = new static(
				Funcs::instance()->_getMainPath(),
				Funcs::instance()->_getRootNamespace(),
				Funcs::instance()->_getPrefixEnv(),
				[]
			);
			$instance->setFacade();
			static::$instance = $instance;
		}
		return static::$instance;
	}

}
