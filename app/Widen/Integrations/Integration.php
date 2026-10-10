<?php

namespace WPSPLITE\App\Widen\Integrations;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPCORELITE\App\Integrations\Integration as IntegrationCore;

class Integration extends IntegrationCore {

	use InstancesTrait;

	public $autoIntegrationPackages = false;

	/*
	 *
	 */

	public function specificIntegrationPackages() {
		return [
//			\WPSPLITE\App\Widen\Integrations\LaravelDebugbar\LaravelDebugbar::class,
		];
	}

	/*
	 *
	 */

	public function register() {
		if ($this->autoIntegrationPackages) {
			$this->registerAllIntegrationPackages(__DIR__);
		}
		else {
			$this->registerSpecificIntegrationPackages($this->specificIntegrationPackages());
		}
	}

	public function autoIntegrationPackages() {
		$this->registerAllIntegrationPackages(__DIR__);
	}

}