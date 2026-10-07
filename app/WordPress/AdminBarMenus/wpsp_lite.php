<?php

namespace WPSPLITE\App\WordPress\AdminBarMenus;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPCORELITE\App\WordPress\AdminBarMenus\BaseAdminBarMenu;

class wpsp_lite extends BaseAdminBarMenu {

	use InstancesTrait;

	// Args.
	public $id     = 'wpsp_lite';
	public $title  = 'WPSP';
	public $href   = '/wp-admin/admin.php?page=wpsp';
	public $parent = '';
	public $meta   = [];


	/*
	 *
	 */

	public function customProperties() {
		$this->id    = 'wpsp_lite';
		$this->title = '<span class="ab-icon dashicons dashicons-analytics" style="padding: 6px 0;"></span><span class="ab-label">WPSP</span>';
	}

	/*
	 *
	 */

//	public function init($id = null) {
//		dump($this->request->route());
//		global $wp_query;
//		dump($wp_query);
//
//		parent::init($id);
//	}

}