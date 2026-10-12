<?php
namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\Customizers\Customizers as Route;
use WPSPLITE\App\WordPress\Customizers\customize_demo\customize_demo;
use WPSPCORELITE\App\Routes\Customizers\CustomizersRouteTrait;

class Customizers {

	use CustomizersRouteTrait;

	/*
	 *
	 */

	public function customizers() {
		Route::customize('customize_demo', [customize_demo::class]);
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}