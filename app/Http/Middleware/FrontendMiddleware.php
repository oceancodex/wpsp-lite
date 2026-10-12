<?php

namespace WPSPLITE\App\Http\Middleware;

use Closure;
use WPSPCORELITE\App\Http\Request;

class FrontendMiddleware {

	public function handle(Request $request, Closure $next, $args = []) {
		return !is_admin();
	}

}
