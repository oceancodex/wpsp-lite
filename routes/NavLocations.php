<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\NavigationMenus\Locations\Locations as Route;
use WPSPLITE\App\WordPress\NavigationMenus\Locations\nav_primary;
use WPSPCORELITE\App\Routes\NavigationMenus\Locations\NavLocationsRouteTrait;

class NavLocations {

	use NavLocationsRouteTrait;

	/*
	 *
	 */

	public function nav_locations() {
		Route::nav_location('nav_primary', [nav_primary::class]);
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}