<?php

namespace WPSPLITE\App\Widen\Support\Facades;

use WPSPCORELITE\App\Support\Facades\Artisan as ArtisanCore;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;

class Artisan extends ArtisanCore {

	use InstancesTrait;

	/** @var ArtisanCore|null */
	public static $instance  = null;

	/**
	 * @return ArtisanCore|null
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