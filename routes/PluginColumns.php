<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\PluginColumns\PluginColumns as Route;
use WPSPLITE\App\WordPress\PluginColumns\custom_column;
use WPSPLITE\App\WordPress\PluginColumns\custom_column_view;
use WPSPCORELITE\App\Routes\PluginColumns\PluginColumnsRouteTrait;

class PluginColumns {

	use PluginColumnsRouteTrait;

	/*
	 *
	 */

	public function plugin_columns() {
		Route::column('custom_column', [custom_column::class, 'index']);
		Route::column('custom_column_view', [custom_column_view::class, 'index']);
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}