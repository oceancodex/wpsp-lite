<?php

namespace WPSPLITE\App\WordPress\ThemeTemplates;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\WordPress\ThemeTemplates\BaseThemeTemplates;
use WPSPLITE\App\Widen\Traits\InstancesTrait;

class wpsp_lite_bigger_content_font_size extends BaseThemeTemplates {

	use InstancesTrait;

//	public $name       = 'wpsp-lite-bigger-content-font-size';
	public $label      = 'Custom template: wpsp-lite-bigger-content-font-size';
//	public $path       = null;
	public $post_types = ['page'];

	/*
	 *
	 */

	public function customProperties(Request $request) {
//		$this->path = Funcs::instance()->_getResourcesPath('/views/theme-templates/' . $this->name . '.blade.php');
	}

}