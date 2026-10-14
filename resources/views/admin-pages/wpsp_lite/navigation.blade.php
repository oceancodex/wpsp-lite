<div class="nav-tab-wrapper">
	<a href="?page={{$menuSlug}}&tab=dashboard" class="nav-tab {{ !isset($requestParams['tab']) || $requestParams['tab'] == 'dashboard' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('Dashboard', true) }}</a>
	<a href="?page={{$menuSlug}}&tab=license" class="nav-tab {{ isset($requestParams['tab']) && $requestParams['tab'] == 'license' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('License', true) }}</a>
	<a href="?page={{$menuSlug}}&tab=database" class="nav-tab {{ isset($requestParams['tab']) && $requestParams['tab'] == 'database' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('Database', true) }}</a>
	<a href="?page={{$menuSlug}}&tab=settings" class="nav-tab {{ isset($requestParams['tab']) && $requestParams['tab'] == 'settings' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('Settings', true) }}</a>
	<a href="?page={{$menuSlug}}&tab=tools" class="nav-tab {{ isset($requestParams['tab']) && $requestParams['tab'] == 'tools' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('Tools', true) }}</a>
	<a href="?page={{$menuSlug}}&tab=table" class="nav-tab {{ isset($requestParams['tab']) && $requestParams['tab'] == 'table' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('Table', true) }}</a>
	<a href="?page={{$menuSlug}}&tab=roles" class="nav-tab {{ isset($requestParams['tab']) && $requestParams['tab'] == 'roles' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('Roles', true) }}</a>
	<a href="?page={{$menuSlug}}&tab=permissions" class="nav-tab {{ isset($requestParams['tab']) && $requestParams['tab'] == 'permissions' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('Permissions', true) }}</a>
	<a href="?page={{$menuSlug}}&tab=users" class="nav-tab {{ isset($requestParams['tab']) && $requestParams['tab'] == 'users' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('Users', true) }}</a>
	<a href="?page={{$menuSlug}}&tab=activity_log" class="nav-tab {{ isset($requestParams['tab']) && $requestParams['tab'] == 'activity_log' ? 'nav-tab-active' : '' }}">{{ wpsp_lite_trans('Activity log', true) }}</a>
</div>