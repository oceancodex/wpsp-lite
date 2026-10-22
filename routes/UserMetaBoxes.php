<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\UserMetaBoxes\UserMetaBoxes as Route;
use WPSPLITE\App\WordPress\UserMetaBoxes\custom_user_meta_box;
use WPSPCORELITE\App\Routes\UserMetaBoxes\UserMetaBoxesRouteTrait;

class UserMetaBoxes {

	use UserMetaBoxesRouteTrait;

	/*
	 *
	 */

	public function user_meta_boxes() {
//		Route::name('wpsp_lite_user_meta_boxes.')->prefix('wpsp-lite-user-meta-boxes')->group(function() {
			Route::user_meta_box('custom_user_meta_box', [custom_user_meta_box::class, 'index']);
//		});
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}