<?php
namespace WPSPLITE\Routes;

use WPSPLITE\App\Widen\Routes\DashboardWidgets\DashboardWidgets as Route;
use WPSPLITE\App\WordPress\DashboardWidgets\dashboard_widget_demo;
use WPSPLITE\App\WordPress\DashboardWidgets\dashboard_widget_demo_view;
use WPSPCORELITE\App\Routes\DashboardWidgets\DashboardWidgetsRouteTrait;

class DashboardWidgets {

	use DashboardWidgetsRouteTrait;

	/*
	 *
	 */

	public function dashboard_widgets() {
//		Route::name('wpsp_lite_dashboard_widget.')->prefix('wpsp-lite-dashboard-widget')->group(function() {
			Route::widget('dashboard_widget_demo', [dashboard_widget_demo::class, 'index'], ['priority' => 30]);
			Route::widget('dashboard_widget_demo_view', [dashboard_widget_demo_view::class, 'index']);
//		});
	}

	/*
	 *
	 */

	public function actions() {
		add_action('wp_dashboard_setup', function() {
			// Remove Welcome panel.
			remove_action('welcome_panel', 'wp_welcome_panel');

			// Remove all Dashboard widgets.
			global $wp_meta_boxes;
			unset($wp_meta_boxes['dashboard']);
		}, 20);
	}

	public function filters() {}

}