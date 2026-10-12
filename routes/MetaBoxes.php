<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\MetaBoxes\MetaBoxes as Route;
use WPSPLITE\App\WordPress\MetaBoxes\wpsp_lite_content;
use WPSPLITE\App\WordPress\MetaBoxes\wpsp_lite_dashboard_metabox;
use WPSPCORELITE\App\Routes\MetaBoxes\MetaBoxesRouteTrait;

class MetaBoxes {

	use MetaBoxesRouteTrait;

	/*
	 *
	 */

	public function meta_boxes() {
		Route::meta_box('wpsp_lite_shortcode', [wpsp_lite_content::class, 'index']);
		Route::meta_box('wpsp_lite_dashboard_metabox', [wpsp_lite_dashboard_metabox::class, 'index']);
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}