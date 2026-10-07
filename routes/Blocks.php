<?php
namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\Blocks\Blocks as Route;
use WPSPCORELITE\App\Routes\Blocks\BlocksRouteTrait;
use WPSPLITE\App\WordPress\Blocks\block_demo;

class Blocks {

	use BlocksRouteTrait;

	/*
	 *
	 */

	public function blocks() {
		Route::block('block-demo', [block_demo::class]);
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}