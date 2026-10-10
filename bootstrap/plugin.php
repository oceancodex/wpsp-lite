<?php

use WPSPLITE\App\Widen\Integrations\Integration;
use WPSPLITE\App\Widen\Routes\RouteManager;
use WPSPLITE\App\Widen\Routes\RouteMap;
use WPSPLITE\WPSP;
use WPSPLITE\Routes\Actions;
use WPSPLITE\Routes\AdminBarMenus;
use WPSPLITE\Routes\AdminPages;
use WPSPLITE\Routes\Ajaxs;
use WPSPLITE\Routes\Apis;
use WPSPLITE\Routes\Blocks;
use WPSPLITE\Routes\CommentColumns;
use WPSPLITE\Routes\Customizers;
use WPSPLITE\Routes\DashboardWidgets;
use WPSPLITE\Routes\Filters;
use WPSPLITE\Routes\FrontPages;
use WPSPLITE\Routes\MediaColumns;
use WPSPLITE\Routes\MetaBoxes;
use WPSPLITE\Routes\NavLocations;
use WPSPLITE\Routes\PluginColumns;
use WPSPLITE\Routes\PostTypeColumns;
use WPSPLITE\Routes\PostTypes;
use WPSPLITE\Routes\RewriteFrontPages;
use WPSPLITE\Routes\Schedules;
use WPSPLITE\Routes\Shortcodes;
use WPSPLITE\Routes\Taxonomies;
use WPSPLITE\Routes\TaxonomyColumns;
use WPSPLITE\Routes\ThemeTemplates;
use WPSPLITE\Routes\UserColumns;
use WPSPLITE\Routes\UserMetaBoxes;
use WPSPLITE\Routes\Widgets;
use WPSPLITE\Routes\WPRoles;

require_once __DIR__ . '/../vendor/autoload.php';

define('WPSP_LITE_LITE_PLUGIN_START', microtime(true));

/**
 * ---
 * Start application.
 */
//add_action('init', function() {
	$wpsp = WPSP::start();
//}, 10);

/**
 * Tích hợp.
 */
Integration::instance()->register();

/**
 * ---
 * Đăng ký và xử lý routes.
 */
//add_action('init', function() {
	foreach ([
		AdminPages::class,
		Apis::class,
		Ajaxs::class,
		FrontPages::class,
		RewriteFrontPages::class,

		AdminBarMenus::class,
		Blocks::class,
		CommentColumns::class,
		Customizers::class,
		DashboardWidgets::class,
		MediaColumns::class,
		MetaBoxes::class,
		NavLocations::class,
		PluginColumns::class,
		PostTypeColumns::class,
		PostTypes::class,
		Schedules::class,
		Shortcodes::class,
		Taxonomies::class,
		TaxonomyColumns::class,
		ThemeTemplates::class,
		UserColumns::class,
		UserMetaBoxes::class,
		Widgets::class,
		WPRoles::class,

		Actions::class,
		Filters::class,
	] as $route) {
		(new $route())->register();
	}
//}, 10);

//dd(RouteMap::instance()->getMap());

/**
 * ---
 * Chạy tất cả các route đã đăng ký.
 */
add_action('init', function() {
	RouteManager::instance()->executeAllRoutes(['Widgets']);
});

/**
 * Chạy các route với types của chúng được chỉ định.
 */
add_action('widgets_init', function() {
	RouteManager::instance()->executeRouteByTypes(['Widgets']);
});