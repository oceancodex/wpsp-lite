<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\Taxonomies\Taxonomies as Route;
use WPSPLITE\App\WordPress\Taxonomies\wpsp_lite_category;
use WPSPCORELITE\App\Routes\Taxonomies\TaxonomiesRouteTrait;

class Taxonomies {

	use TaxonomiesRouteTrait;

	/*
	 *
	 */

	public function taxonomies() {
//		Route::name('wpsp_lite_taxonomies.')->prefix('wpsp-lite-taxonomies')->group(function() {
			Route::taxonomy('wpsp_lite_category', [wpsp_lite_category::class]);
//		});
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}