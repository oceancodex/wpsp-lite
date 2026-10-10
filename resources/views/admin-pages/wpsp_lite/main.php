<?php
if (isset($requestParams['tab']) && $requestParams['tab'] == 'license') {
	$title = wpsp_lite_trans('License key', null, true);
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/license.php');
}
elseif (isset($requestParams['tab']) && $requestParams['tab'] == 'database') {
	$title = wpsp_lite_trans('Database', null, true);
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/database.php');
}
elseif (isset($requestParams['tab']) && $requestParams['tab'] == 'settings') {
	$title = wpsp_lite_trans('Settings', null, true);
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/settings.php');
}
elseif (isset($requestParams['tab']) && $requestParams['tab'] == 'tools') {
	$title = wpsp_lite_trans('Tools', null, true);
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/tools.php');
}
elseif (isset($requestParams['tab']) && $requestParams['tab'] == 'table') {
	$title = wpsp_lite_trans('Table', null, true);
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/table.php');
}
elseif (isset($requestParams['tab']) && $requestParams['tab'] == 'roles') {
	$title = wpsp_lite_trans('Roles', null, true);
	$afterTitle = ' <a href="' . wpsp_lite_route('AdminPages', 'wpsp_lite.roles.index', ['action' => 'create'], true) . '" class="page-title-action button-secondary align-baseline">' . wpsp_lite_trans('Add new', null, true) . '</a>';
	$afterTitle .= ' <a href="' . wpsp_lite_route('AdminPages', 'wpsp_lite.roles.index', ['action' => 'refresh'], true) . '" class="page-title-action button-primary">' . wpsp_lite_trans('Refresh all custom roles', null, true) . '</a>';
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/roles.php');
}
elseif (isset($requestParams['tab']) && $requestParams['tab'] == 'permissions') {
	$title = wpsp_lite_trans('Permissions', null, true);
	$afterTitle = ' <a href="' . wpsp_lite_route('AdminPages', 'wpsp_lite.permissions.index', ['action' => 'create'], true) . '" class="page-title-action button-secondary align-baseline">' . wpsp_lite_trans('Add new', null, true) . '</a>';
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/permissions.php');
}
elseif (isset($requestParams['tab']) && $requestParams['tab'] == 'users') {
	$title = wpsp_lite_trans('Users', null, true);
	$afterTitle = ' <a href="' . wpsp_lite_route('AdminPages', 'wpsp_lite.users.create', true) . '" class="page-title-action button-secondary align-baseline">' . wpsp_lite_trans('Add new', null, true) . '</a>';
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/users.php');
}
elseif (isset($requestParams['tab']) && $requestParams['tab'] == 'activity_log') {
	$title = wpsp_lite_trans('Activity log', null, true);
//	$afterTitle = ' <a href="' . wpsp_lite_route('AdminPages', 'wpsp_lite.users.create', true) . '" class="page-title-action button-secondary align-baseline">' . wpsp_lite_trans('Add new', null, true) . '</a>';
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/activity_log.php');
}
else {
	$title = wpsp_lite_trans('Dashboard', null, true);
	$view  = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/dashboard.php');
}

$navigation = wpsp_lite_resources_path('/views/admin-pages/wpsp_lite/navigation.php');

include wpsp_lite_resources_path('/views/admin-pages/header.php');
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
include $view;
include wpsp_lite_resources_path('/views/admin-pages/footer.php');