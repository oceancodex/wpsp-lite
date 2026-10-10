<?php

namespace WPSPLITE\App\Widen\Support\Facades;

use WPSPCORELITE\App\Support\Facades\File\File as FileCore;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;

class File extends FileCore {

	use InstancesTrait;

	/** @var FileCore|null */
	public static $instance  = null;

	/**
	 * @return FileCore|null
	 */
	public static function wpspInstance() {
		if (!static::$instance) {
			$instance = new static(
				Funcs::instance()->_getMainPath(),
				Funcs::instance()->_getRootNamespace(),
				Funcs::instance()->_getPrefixEnv(),
				[]
			);
//			$instance->setFacade();
			static::$instance = $instance;
		}
		return static::$instance;
	}

}