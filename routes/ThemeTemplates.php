<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\ThemeTemplates\ThemeTemplates as Route;
use WPSPLITE\App\WordPress\ThemeTemplates\wpsp_lite_bigger_content_font_size;
use WPSPLITE\App\WordPress\ThemeTemplates\wpsp_lite_center_content;
use WPSPLITE\App\WordPress\ThemeTemplates\wpsp_lite_right_content;
use WPSPLITE\App\WordPress\ThemeTemplates\wpsp_lite_without_header_footer;
use WPSPLITE\App\WordPress\ThemeTemplates\wpsp_lite_without_title;
use WPSPCORELITE\App\Routes\ThemeTemplates\ThemeTemplatesRouteTrait;

class ThemeTemplates {

	use ThemeTemplatesRouteTrait;

	/*
	 *
	 */

	public function theme_templates() {
		Route::theme_template('wpsp-lite-without-title', [wpsp_lite_without_title::class]);
		Route::theme_template('wpsp-lite-center-content', [wpsp_lite_center_content::class]);
		Route::theme_template('wpsp-lite-without-header-footer', [wpsp_lite_without_header_footer::class]);
		Route::theme_template('wpsp-lite-right-content', [wpsp_lite_right_content::class]);
		Route::theme_template('wpsp-lite-bigger-content-font-size', [wpsp_lite_bigger_content_font_size::class]);
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}