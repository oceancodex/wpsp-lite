<?php

namespace WPSPLITE\App\WordPress\NavigationMenus\Locations;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPCORELITE\App\WordPress\NavigationMenus\Locations\BaseNavigationLocation;

class nav_primary extends BaseNavigationLocation {

	use InstancesTrait;

	// Args.
//	public $location    = 'nav_primary';
	public $description = 'Navigation primary';

	/*
	 *
	 */

	public function customProperties() {
//		$this->location    = 'nav_primary';
//		$this->description = 'Primary navigation menu';
	}

}