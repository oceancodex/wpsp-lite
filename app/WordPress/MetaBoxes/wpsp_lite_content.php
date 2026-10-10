<?php

namespace WPSPLITE\App\WordPress\MetaBoxes;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\WordPress\MetaBoxes\BaseMetaBox;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;

class wpsp_lite_content extends BaseMetaBox {

	use InstancesTrait;

	public $title         = 'WPSP Content';
	public $screen        = 'wpsp_lite_content';
//	public $context       = 'advanced';
//	public $priority      = 'default';
//	public $callback_args = [];

	/*
	 *
	 */

//	public function __wpspConstruct(Request $request) {}

	/*
	 *
	 */

	public function customProperties(Request $request) {
//		$this->title = 'WPSP Content';
	}

	/*
	 *
	 */

	public function index($post, $meta_box, Request $request) {
		echo Funcs::view('meta-boxes.wpsp', compact('post', 'meta_box'));
		include_once Funcs::getResourcesPath('/views/meta-boxes/wpsp.php');
	}

}