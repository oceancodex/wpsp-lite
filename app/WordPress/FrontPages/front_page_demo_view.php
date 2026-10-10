<?php

namespace WPSPLITE\App\WordPress\FrontPages;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\WordPress\FrontPages\BaseFrontPage;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;

class front_page_demo_view extends BaseFrontPage {

	use InstancesTrait;

//	public $path = 'front-page-demo-view';

	/*
	 *
	 */

	public function customProperties() {
//		$this->path = 'front-page\/([^\/]+)\/?$';
	}

	/*
	 *
	 */

	public function index(Request $request, $endpoint = null) {
		echo Funcs::view('front-pages.font_page_demo_view');
		die();
//		echo $endpoint;
	}

	public function update(Request $request) {
		print_r($request->all());
		die();
	}

}