<?php

namespace WPSPLITE\App\WordPress\AdminBarMenus;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPCORELITE\App\WordPress\AdminBarMenus\BaseAdminBarMenu;

class wpsp_lite_tab_dashboard extends BaseAdminBarMenu {

	use InstancesTrait;

	// Args.
	public $id     = 'wpsp_lite_tab_dashboard';
	public $title  = 'Tab: Dashboard';
	public $href   = '/wp-admin/admin.php?page=wpsp&tab=dashboard';
	public $parent = 'wpsp_lite';
	public $meta   = [];


	/*
	 *
	 */

	public function customProperties() {
		$this->id    = 'wpsp_lite_tab_dashboard';
		$this->title = 'Tab: Dashboard';
	}

}