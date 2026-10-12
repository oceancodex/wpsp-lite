<?php

namespace WPSPLITE\App\WordPress\ThemeTemplates;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\WordPress\ThemeTemplates\BaseThemeTemplates;
use WPSPLITE\App\Widen\Traits\InstancesTrait;

class wpsp_lite_center_content extends BaseThemeTemplates {

	use InstancesTrait;

//	public $name       = 'wpsp-lite-center-content';
	public $label      = 'WPSP - Template center content';
//	public $path       = null;
	public $post_types = ['page'];

	/*
	 *
	 */

	public function customProperties(Request $request) {
//		$this->path = Funcs::instance()->_getResourcesPath('/views/theme-templates/' . $this->name . '.blade.php');
	}

}