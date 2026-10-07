<?php

namespace WPSPLITE\Routes;

use WPSPLITE\App\Http\Middleware\PreventRequestForgery;
use WPSPLITE\App\Http\Middleware\PreventRequestForgeryWithoutOrigin;
use WPSPLITE\App\Http\Middleware\VerifiedUserMiddleware;
use WPSPLITE\App\Widen\Routes\AdminPages\AdminPages as Route;
use WPSPLITE\App\Http\Middleware\AdministratorCapability;
use WPSPLITE\App\Http\Middleware\AuthenticationMiddleware;
use WPSPLITE\App\Http\Middleware\EditorCapability;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_child_example;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_child_post_type_wpsp_lite_content;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_child_taxonomy_wpsp_lite_category;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_custom;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_activity_log;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_dashboard;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_database;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_license;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_list_users;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_permissions;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_roles;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_settings;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_table;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_tools;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_tab_users;
use WPSPLITE\App\WordPress\AdminPages\wpsp_lite\wpsp_lite_test_facades;
use WPSPCORELITE\App\Routes\AdminPages\AdminPagesRouteTrait;

class AdminPages {

	use AdminPagesRouteTrait;

	/*
	 *
	 */

	public function admin_pages() {
		// Custom admin menu page with closure function
//		Route::middleware([
//			'relation' => 'OR',
//			EditorCapability::class,
//			AdministratorCapability::class
//		])->get('wpsp2', function(
//			$page_title = 'WPSP2',
//			$menu_title = 'WPSP2',
//			$capability = 'administrator',
//			$menu_slug = 'wpsp2',
//			$icon_url = null,
//			$position = null
//		) {
//			echo '<h1>Custom admin menu page "wpsp2" with closure function!</h1>';
//		});

		// Admin menu pages with class instances.
		Route::name('wpsp_lite.')->middleware([
			'relation' => 'OR',
			[AdministratorCapability::class, 'handle'],
			[EditorCapability::class, 'handle'],
		])->group(function() {
			Route::get('wpsp_lite', [wpsp_lite::class, 'index'])->name('index');
			Route::get('wpsp_lite&tab=dashboard', [wpsp_lite_tab_dashboard::class, 'index'])->name('dashboard');
			Route::name('license.')->middleware([
				'relation' => 'AND',
				[AdministratorCapability::class, 'handle'],
//				[AuthenticationMiddleware::class, 'handle'],
			])->group(function() {
				Route::get('wpsp_lite&tab=license', [wpsp_lite_tab_license::class, 'index'])->name('index');
				Route::middleware(PreventRequestForgeryWithoutOrigin::class)->post('wpsp_lite&tab=license', [wpsp_lite_tab_license::class, 'update'])->name('update');
			});
			Route::get('wpsp_lite&tab=database', [wpsp_lite_tab_database::class, 'index'])->name('database');
			Route::name('settings.')->middleware([
				'relation' => 'OR',
//				[AuthenticationMiddleware::class],
//				VerifiedUserMiddleware::class
			])->group(function() {
				Route::get('wpsp_lite&tab=settings', [wpsp_lite_tab_settings::class, 'index'])->name('index');
				Route::post('wpsp_lite&tab=settings', [wpsp_lite_tab_settings::class, 'update'])->name('update');
			});
			Route::get('wpsp_lite&tab=tools', [wpsp_lite_tab_tools::class, 'index'])->name('tools');
			Route::name('table.')->group(function() {
				Route::get('wpsp_lite&tab=table', [wpsp_lite_tab_table::class, 'index'])->name('index');
				Route::post('wpsp_lite&tab=table', [wpsp_lite_tab_table::class, 'update'])->name('update');
			});
			Route::name('roles.')->group(function() {
				Route::get('wpsp_lite&tab=roles', [wpsp_lite_tab_roles::class, 'index'])->name('index');
				Route::post('wpsp_lite&tab=roles', [wpsp_lite_tab_roles::class, 'update'])->name('update');
				Route::get('wpsp_lite&tab=roles&doaction=refresh', [wpsp_lite_tab_roles::class, 'refresh'])->name('refresh');
			});
			Route::name('permissions.')->group(function() {
				Route::get('wpsp_lite&tab=permissions', [wpsp_lite_tab_permissions::class, 'index'])->name('index');
//				Route::post('wpsp_lite&tab=permissions', [wpsp_lite_tab_permissions::class, 'update'])->name('update');
			});
			Route::name('users.')->group(function() {
				Route::get('wpsp_lite&tab=users', [wpsp_lite_tab_users::class, 'index'])->name('list');
//				Route::get('wpsp_lite&tab=users(?P<n>&?)(?P<queries>.*)', [wpsp_lite_tab_users::class, 'index'])->name('list'); // [1] Khớp với URL có params và callback "index".
				Route::get('wpsp_lite&tab=users(?P<n>&?)(?P<queries>.*)', [wpsp_lite_tab_users::class, 'bulkUpdate'])->name('bulk_update');
				Route::get('wpsp_lite&tab=users&doaction=create', [wpsp_lite_tab_users::class, 'create'])->name('create');
				Route::post('wpsp_lite&tab=users&doaction=create', [wpsp_lite_tab_users::class, 'store'])->name('create');
//				Route::get('wpsp_lite&tab=users&doaction=show&id=(?P<id>\w+)?&abc=(?P<abc>\w+)?', [wpsp_lite_tab_users::class, 'show'])->name('show');
//				Route::get('wpsp_lite&show=(?P<user>\d+)(?P<n>&?)(?P<queries>.*)', [wpsp_lite_tab_users::class, 'show'])->name('show');
				Route::get('wpsp_lite&tab=users&doaction=show&user={user?}(?P<n>&?)(?P<queries>.*)', [wpsp_lite_tab_users::class, 'show'])->name('show');
//				Route::get('wpsp_lite&tab=users&doaction=show&user_id=(?P<user_id>\d+)(?P<n>&?)(?P<queries>.*)', [wpsp_lite_tab_users::class, 'show'])->name('show');
				Route::get('wpsp_lite&tab=users&doaction=edit&id=(?P<id>\d+)', [wpsp_lite_tab_users::class, 'edit'])->middleware(AdministratorCapability::class)->name('edit');
				Route::post('wpsp_lite&tab=users&doaction=edit&id=(?P<id>\d+)', [wpsp_lite_tab_users::class, 'update'])->middleware(AdministratorCapability::class)->name('update');
				Route::get('wpsp_lite&tab=users&doaction=delete&id=(?P<id>\d+)', [wpsp_lite_tab_users::class, 'delete'])->middleware(AdministratorCapability::class)->name('delete');
			});
			Route::get('wpsp_lite&tab=activity_log', [wpsp_lite_tab_activity_log::class, 'index'])->name('activity_log');
			Route::get('wpsp_lite_tab_list_users', [wpsp_lite_list_users::class, 'index'])->name('list');
			Route::get('wpsp_lite_child_example', [wpsp_lite_child_example::class, 'index'])->name('child_example');
			Route::get('wpsp_lite_test_facades', [wpsp_lite_test_facades::class, 'create'], ['force_init' => true, 'force_init_slug' => 'wpsp_lite_test_facades'])->name('test_facades');
			Route::get('edit.php?post_type=wpsp_lite_content', [wpsp_lite_child_post_type_wpsp_lite_content::class, null])->name('list_wpsp_lite_content');
			Route::get('edit-tags.php?taxonomy=wpsp_lite_category', [wpsp_lite_child_taxonomy_wpsp_lite_category::class, null])->name('list_wpsp_lite_category');
		});

		Route::get('custom&edit=(?P<user>\d+)(?P<n>&?)(?P<queries>.*)', [wpsp_lite_custom::class, 'index'], ['force_init' => true])->name('custom');

		// Custom sub admin menu page with closure function
//		Route::name('wpsp3.')->middleware(null)->group(function() {
//			Route::name('wpsp3-child.')->middleware([])->group(function() {
//				Route::get('wpsp3-child', [wpsp_lite_child_example::class, 'index'])->name('main');
//				Route::get('wpsp3-last-child', function(
//					$is_submenu_page = true,
//					$parent_slug = 'wpsp2',
//					$page_title = 'WPSP3 Last child',
//					$menu_title = 'WPSP3 Last child',
//					$capability = 'administrator',
//					$menu_slug = 'wpsp3-last-child',
//					$icon_url = null,
//					$position = null
//				) {
//					echo '<h1>Custom admin sub menu page "wpsp3-last-child" with closure function!</h1>';
//				})->name('wpsp3-last-child');
//			});
//		});

		// Custom sub admin menu page with closure function
//		Route::middleware(AdministratorCapability::class)->get('wpsp2-child', function(
//			$is_submenu_page = true,
//			$parent_slug = 'wpsp2',
//			$page_title = 'WPSP2 Child',
//			$menu_title = 'WPSP2 Child',
//			$capability = 'administrator',
//			$menu_slug = 'wpsp2-child',
//			$icon_url = null,
//			$position = null
//		) {
//			echo '<h1>Custom admin sub menu page "wpsp2-child" with closure function!</h1>';
//		})->name('wpsp2-child');
	}

	/*
	 *
	 */

	public function actions() {}

	public function filters() {}

}