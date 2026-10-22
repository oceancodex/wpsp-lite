<?php

namespace WPSPLITE\App\Widen\Support\Facades;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;
use WPSPCORELITE\App\Support\Facades\Cache as CacheCore;

class Cache extends CacheCore {

	use InstancesTrait;

	/** @var CacheCore|null */
	public static $instance = null;

	/**
	 * @return CacheCore|null
	 */
	public static function wpspInstance() {
		if (!static::$instance) {
			$funcs = Funcs::instance();

			static::$instance = new static(
				$funcs->_getMainPath(),
				$funcs->_getRootNamespace(),
				$funcs->_getPrefixEnv(),
				[]
			);

			static::$instance->setFacade();
		}

		return static::$instance;
	}

}
