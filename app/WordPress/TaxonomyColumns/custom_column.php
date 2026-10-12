<?php
namespace WPSPLITE\App\WordPress\TaxonomyColumns;

use WPSPCORELITE\App\Http\Request;
use WPSPCORELITE\App\WordPress\TaxonomyColumns\BaseTaxonomyColumn;
use WPSPLITE\App\Services\TestService;
use WPSPLITE\App\Widen\Traits\InstancesTrait;

class custom_column extends BaseTaxonomyColumn {

	use InstancesTrait;

//	public column_name              = 'custom_column';
	public $column_title            = 'Custom column';
	public $column_add_priority     = 9999;
	public $column_content_priority = 9999;
	public $taxonomies              = ['category', 'wpsp_lite_category', 'product_cat'];
//	public $before_column           = [];
//	public $after_column            = ['name'];
	public $position                = 2;
	public $sortable                = true;

	/*
	 *
	 */

	public function customProperties() {}

	/*
	 *
	 */

	public function index($content, $column_name, $term_id, Request $request, TestService $testService) {
		return $term_id . ' - ' . $testService->test() . ' > ' . $testService->subTestService->subTest();
	}

	/*
	 *
	 */

	public function sort($query) {
		if (!is_admin()) return;

		$orderby = $query->query_vars['orderby'] ?? null;

		if ($orderby === 'custom_column') {
			// Sort theo meta key.
//			$query->query_vars['meta_key'] = 'icon';
//			$query->query_vars['orderby'] = 'meta_value';

			$query->query_vars['orderby'] = 'term_id';
		}
	}

}