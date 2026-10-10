<?php

use WPSPLITE\App\Widen\Support\Facades\Auth;
use WPSPLITE\App\Widen\Support\Facades\Cache;
use WPSPLITE\App\Widen\Support\Facades\RateLimiter;
use WPSPLITE\Funcs;
use WPSPLITE\WPSP;

if (!function_exists('wpsp_lite_app')) {
	function wpsp_lite_app($abstract = null, $parameters = []) {
		static $app;

		if (!$app) {
			$app = WPSP::instance()->getApplication();
		}

		if (is_null($abstract)) {
			return $app;
		}

		return $app->make($abstract, $parameters);
	}
}

if (!function_exists('wpsp_lite_env')) {
	function wpsp_lite_env($var, $addPrefix = false, $default = null) {
		return Funcs::instance()->_env($var, $addPrefix, $default);
	}
}
if (!function_exists('wpsp_lite_auth')) {
	function wpsp_lite_auth($guard = null) {
		if (class_exists('\WPSPCORELITE\App\Auth\Auth')) {
			return Auth::instance()->guard($guard);
		}
		else {
			return null;
		}
	}
}
if (!function_exists('wpsp_lite_route')) {
	function wpsp_lite_route($routeClass, $routeName, $args = [], $buildURL = false) {
		return Funcs::route($routeClass, $routeName, $args, $buildURL);
	}
}
if (!function_exists('wpsp_lite_view')) {
	function wpsp_lite_view($viewName = null, $data = [], $mergeData = []) {
		return Funcs::instance()->_view($viewName, $data, $mergeData);
	}
}
if (!function_exists('wpsp_lite_view_inject')) {
	function wpsp_lite_view_inject($views, $callback) {
		return Funcs::instance()->_viewInject($views, $callback);
	}
}
if (!function_exists('wpsp_lite_asset')) {
	function wpsp_lite_asset($path, $secure = null) {
		return Funcs::instance()->_asset($path, $secure);
	}
}
if (!function_exists('wpsp_lite_debug')) {
	function wpsp_lite_debug($message = '', $print = false, $varDump = false) {
		Funcs::instance()->_debug($message, $print, $varDump);
	}
}
if (!function_exists('wpsp_lite_trans')) {
	function wpsp_lite_trans($string, $replaces = [], $wordpress = false) {
		return Funcs::instance()->_trans($string, $replaces, $wordpress);
	}
}
if (!function_exists('wpsp_lite_config')) {
	function wpsp_lite_config($key = null, $default = null) {
		return Funcs::instance()->_config($key, $default);
	}
}
if (!function_exists('wpsp_lite_notice')) {
	function wpsp_lite_notice($message = '', $type = 'info', $echo = false, $wrap = false, $class = null, $dismiss = true) {
		Funcs::instance()->_notice($message, $type, $echo, $wrap, $class, $dismiss);
	}
}
if (!function_exists('wpsp_lite_locale')) {
	function wpsp_lite_locale() {
		return Funcs::instance()->_locale();
	}
}
if (!function_exists('wpsp_lite_response')) {
	function wpsp_lite_response($message = '', $print = false, $varDump = false) {
		return Funcs::instance()->_response($message, $print, $varDump);
	}
}
if (!function_exists('wpsp_lite_main_path')) {
	function wpsp_lite_main_path($path = null) {
		return Funcs::instance()->_getMainPath($path);
	}
}
if (!function_exists('wpsp_lite_nonce_field')) {
	function wpsp_lite_nonce_field($action = -1, $name = '_wpnonce', $referer = true, $display = true) {
		return wp_nonce_field($action, $name, $referer, $display);
	}
}
if (!function_exists('wpsp_lite_resources_path')) {
	function wpsp_lite_resources_path($path = null) {
		return Funcs::instance()->_getResourcesPath($path);
	}
}
if (!function_exists('wpsp_lite_bearer_token')) {
	function wpsp_lite_bearer_token() {
		return Funcs::instance()->_getBearerToken();
	}
}
if (!function_exists('wpsp_lite_event')) {
	function wpsp_lite_event($event = null, $payload = []) {
		return Funcs::event($event, $payload);
	}
}
if (!function_exists('wpsp_lite_validate')) {
	function wpsp_lite_validate($data, $rules, $messages = [], $customAttributes = []) {
		return Funcs::validate($data, $rules, $messages, $customAttributes);
	}
}
if (!function_exists('wpsp_lite_validation')) {
	function wpsp_lite_validation() {
		return Funcs::validation();
	}
}
if (!function_exists('wpsp_lite_cache')) {
	function wpsp_lite_cache() {
		return Cache::instance();
	}
}
if (!function_exists('wpsp_lite_rate_limiter')) {
	function wpsp_lite_rate_limiter() {
		return RateLimiter::instance()->getRateLimiter();
	}
}

/*
 *
 */

if (!function_exists('wpsp_lite_abort')) {
	function wpsp_lite_abort($code, $message = '', $headers = []) {
		throw new \WPSPLITE\App\Exceptions\HttpException($code, $message, $headers);
	}
}
if (!function_exists('wpsp_lite_abort_500')) {
	function wpsp_lite_abort_500($message = 'Internal Server Error') {
		wpsp_lite_abort(500, $message);
	}
}
if (!function_exists('wpsp_lite_abort_404')) {
	function wpsp_lite_abort_404($message = 'Page not found') {
		wpsp_lite_abort(404, $message);
	}
}
if (!function_exists('wpsp_lite_abort_403')) {
	function wpsp_lite_abort_403(string $message = 'Forbidden') {
		wpsp_lite_abort(403, $message);
	}
}
if (!function_exists('wpsp_lite_abort_503')) {
	function wpsp_lite_abort_503(string $message = 'Service Unavailable') {
		wpsp_lite_abort(503, $message);
	}
}
if (!function_exists('wpsp_lite_abort_401')) {
	function wpsp_lite_abort_401(string $message = 'Unauthorized') {
		wpsp_lite_abort(401, $message);
	}
}
if (!function_exists('wpsp_lite_abort_400')) {
	function wpsp_lite_abort_400(string $message = 'Bad Request') {
		wpsp_lite_abort(400, $message);
	}
}
if (!function_exists('wpsp_lite_abort_422')) {
	function wpsp_lite_abort_422(string $message = 'Unprocessable Entity') {
		wpsp_lite_abort(422, $message);
	}
}
if (!function_exists('wpsp_lite_abort_405')) {
	function wpsp_lite_abort_405(string $message = 'Method Not Allowed') {
		wpsp_lite_abort(405, $message);
	}
}

/*
 * 
 */

if (!function_exists('wpsp_lite_action_notice')) {
	function wpsp_lite_action_notice(?\Illuminate\Http\Request $request = null) {
		Funcs::actionNotice($request);
	}
}