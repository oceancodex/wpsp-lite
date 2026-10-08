<?php

namespace WPSPLITE\App\Widen\Support\Facades;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;
use WPSPCORELITE\App\App\App as AppCore;

class App extends AppCore {

	use InstancesTrait;

	/** @var AppCore|null */
	public static $instance = null;

	/**
	 * @return AppCore|null
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