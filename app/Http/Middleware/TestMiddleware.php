<?php

namespace WPSPLITE\App\Http\Middleware;

use Closure;
use WPSPCORELITE\App\Http\Request;
use WP_HTTP_Response;

class TestMiddleware {

	public function handle(Request $request, Closure $next) {
		if (!isset($_GET['token'])) {
			return new WP_HTTP_Response('TestMiddleware false', 403);
		}

		return $next($request);
	}

}
