<?php

namespace WPSP\App\Http\Middleware;

use Closure;
use WPSPCORELITE\App\Widen\Http\Request;

class FrontendMiddleware {

	public function handle(Request $request, Closure $next, $args = []) {
		return !is_admin();
	}

}
