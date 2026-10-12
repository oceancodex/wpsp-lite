<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\Shortcodes\Shortcodes as Route;
use WPSPLITE\App\WordPress\Shortcodes\custom_shortcode;
use WPSPLITE\App\WordPress\Shortcodes\rewrite_front_page_content;
use WPSPLITE\App\WordPress\Shortcodes\wpsp_lite_content;
use WPSPCORELITE\App\Routes\Shortcodes\ShortcodesRouteTrait;

class Shortcodes {

	use ShortcodesRouteTrait;

	/*
	 *
	 */

	public function shortcodes() {
		Route::shortcode('wpsp_lite_content', [wpsp_lite_content::class, 'index']);
		Route::shortcode('rewrite_front_page_content', [rewrite_front_page_content::class, 'index']);
		Route::shortcode('custom_shortcode', [custom_shortcode::class, 'index']);
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}