<?php

namespace WPSPLITE\App\Widen\Support\Facades;

use WPSPCORELITE\App\Support\Facades\Request as RequestCore;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;

class Request extends RequestCore {

	use InstancesTrait;

	/** @var RequestCore|null */
	public static $instance  = null;

	/**
	 * @return RequestCore|null
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