<?php

namespace WPSPLITE\App\Widen\Support\Facades;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;
use WPSPCORELITE\App\Request\Request as RequestCore;

class Request extends RequestCore {

	use InstancesTrait;

	/** @var RequestCore|null */
	public static $instance  = null;

	/**
	 * @return RequestCore|null
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