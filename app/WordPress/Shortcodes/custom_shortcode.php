<?php

namespace WPSPLITE\App\WordPress\Shortcodes;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\WordPress\Shortcodes\BaseShortcode;
use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPLITE\App\WordPress\NavigationMenus\Menus\Menu1;

class custom_shortcode extends BaseShortcode {

	use InstancesTrait;

//	public $shortcode = null;

	/*
	 *
	 */

	public function customProperties() {
//		$this->shortcode = 'custom_shortcode';
	}

	/*
	 *
	 */

	public function index($atts, $content, $tag, Request $request, Menu1 $menu1) {
		echo '<pre style="background:white;z-index:9999;position:relative">'; print_r($this->request->route('endpoint') ?? null); echo '</pre>';
//		return Menu1::render() . Menu2::render();
		return $menu1->render();
//		return Funcs::view('shortcodes.custom_shortcode', compact('content'))->render();
	}

}