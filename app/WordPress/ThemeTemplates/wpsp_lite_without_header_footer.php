<?php

namespace WPSPLITE\App\WordPress\ThemeTemplates;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\WordPress\ThemeTemplates\BaseThemeTemplates;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\Funcs;

class wpsp_lite_without_header_footer extends BaseThemeTemplates {

	use InstancesTrait;

//	public $name       = 'wpsp-lite-without-header-footer';
	public $label      = 'WPSP - Template without header and footer';
//	public $path       = null;
	public $post_types = ['page'];

	/*
	 *
	 */

	public function customProperties(Request $request) {
		$this->path = Funcs::instance()->_getResourcesPath('/views/theme-templates/' . $this->name . '.blade.php');
	}

}