<?php

namespace WPSPLITE\App\Widen\Routes;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;

class RouteMap extends \WPSPCORELITE\App\Routes\RouteMap {

	use InstancesTrait;

	public static $instance = null;

	/**
	 * @return static
	 */
	public static function instance() {
		if (!static::$instance) {
			static::$instance = new static(
				Funcs::instance()->_getMainPath(),
				Funcs::instance()->_getRootNamespace(),
				Funcs::instance()->_getPrefixEnv(),
				[]
			);
		}
		return static::$instance;
	}

}