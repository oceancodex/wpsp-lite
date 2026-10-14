<?php

namespace WPSPLITE\App\Widen\View;

/**
 * Chuỗi HTML đã an toàn, không bị escape khi in bằng {{ }}.
 * Dùng cho $slot và named slot của component, giống Illuminate\Support\HtmlString.
 */
class HtmlString implements \Stringable {

	protected $html;

	public function __construct($html = '') {
		$this->html = (string)$html;
	}

	public function toHtml() {
		return $this->html;
	}

	public function isEmpty() {
		return trim($this->html) === '';
	}

	public function isNotEmpty() {
		return !$this->isEmpty();
	}

	public function __toString(): string {
		return $this->html;
	}

}