<?php

namespace WPSPLITE\App\Widen\Routes\Apis;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;

class Apis extends \WPSPCORELITE\App\Routes\Apis\Apis {

	use InstancesTrait;

//	public $defaultNamespace = 'wpsp_lite';
	public $defaultVersion   = 'v1';

	/*
	 *
	 */

	public function customProperties() {
		$this->defaultNamespace = Funcs::instance()->_getAppShortName();
	}

}