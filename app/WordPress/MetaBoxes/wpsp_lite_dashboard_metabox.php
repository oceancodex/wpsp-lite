<?php

namespace WPSPLITE\App\WordPress\MetaBoxes;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\WordPress\MetaBoxes\BaseMetaBox;
use WPSPLITE\App\Widen\Traits\InstancesTrait;

class wpsp_lite_dashboard_metabox extends BaseMetaBox {

	use InstancesTrait;

	public $title         = 'WPSP Dashboard Metabox';
	public $screen        = 'dashboard';
	public $context       = 'normal';
	public $priority      = 'core';
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
		echo 'This widget created by add_meta_box() function.';
	}

}