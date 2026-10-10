<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\PostTypes\PostTypes as Route;
use WPSPLITE\App\WordPress\PostTypes\wpsp_lite_content;
use WPSPCORELITE\App\Routes\PostTypes\PostTypesRouteTrait;

class PostTypes {

	use PostTypesRouteTrait;

	/*
	 *
	 */

	public function post_types() {
		Route::post_type('wpsp_lite_content', [wpsp_lite_content::class]);
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}