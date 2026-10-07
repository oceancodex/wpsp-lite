<?php

namespace WPSP\App\WordPress\Shortcodes;

use WPSP\App\Widen\Traits\InstancesTrait;
use WPSPCORELITE\App\Widen\Http\Request;
use WPSPCORELITE\App\WordPress\Shortcodes\BaseShortcode;

class wpsp_content extends BaseShortcode {

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