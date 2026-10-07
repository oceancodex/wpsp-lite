<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\TaxonomyColumns\TaxonomyColumns as Route;
use WPSPLITE\App\WordPress\TaxonomyColumns\custom_column;
use WPSPLITE\App\WordPress\TaxonomyColumns\custom_column_view;
use WPSPCORELITE\App\Routes\TaxonomyColumns\TaxonomyColumnsRouteTrait;

class TaxonomyColumns {

	use TaxonomyColumnsRouteTrait;

	/*
	 *
	 */

	public function taxonomy_columns() {
		Route::column('custom_column', [custom_column::class, 'index']);
		Route::column('custom_column_view', [custom_column_view::class, 'index']);
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}