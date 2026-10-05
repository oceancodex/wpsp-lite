<?php

namespace WPSP\App\Http\Middleware;

use Closure;
use WPSP\App\Widen\Commons\Http\Request;

class FrontendMiddleware {

	public function handle(Request $request, Closure $next, $args = []) {
		return !is_admin();
	}

}
