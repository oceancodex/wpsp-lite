<?php

namespace WPSPLITE\App\Widen\View;


use WPSPLITE\App\Widen\Traits\InstancesTrait;

/**
 * @property \WPSPLITE\App\Widen\View\View $view
 */
class Share extends \WPSPCORELITE\App\View\Share {

	public $view = null;

	use InstancesTrait;

	/*
	 *
	 */

	public function afterConstruct() {
		$this->view = $this->funcs->_getApplication('view');
	}

	/*
	 *
	 */

	/**
	 * Chia sẻ các biến cho tất cả các views.
	 */
	public function share() {
		$this->view?->share([
			'current_wp_user' => wp_get_current_user(),
		]);
	}

	/*
	 *
	 */

	/**
	 * Chia sẻ các biến cho các views cụ thể hoặc tất cả các views.\
	 * Sử dụng dấu "*" để chia sẻ cho tất cả các views.\
	 * Điền view name vào mảng để chia sẻ cho các view đó.
	 */
	public function compose() {
		$this->view?->composer(['*'], function(View $view) {
			global $notice;
			$view->with('current_view_name', $view->getName());
			$view->with('notice', $notice);
		});
	}

}