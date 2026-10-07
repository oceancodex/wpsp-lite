<?php

namespace WPSPLITE\App\WordPress\Shortcodes;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\WordPress\Shortcodes\BaseShortcode;
use WPSPLITE\App\Widen\Traits\InstancesTrait;

class wpsp_lite_content extends BaseShortcode {

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

	public function index($atts, $content, $tag, Request $request) {
		if (isset($atts['id']) && $atts['id']) {
			$post = get_post($atts['id']);
			if (!empty($post)) {
				$content = $post->post_content;
			}
		}

		return do_shortcode($content);
	}

}