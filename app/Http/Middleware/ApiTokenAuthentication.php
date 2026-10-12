<?php

namespace WPSPLITE\App\Http\Middleware;

use Closure;
use WPSPCORELITE\App\Http\Request;
use WPSPLITE\Funcs;

class ApiTokenAuthentication {

	public function handle(Request $request, Closure $next, $args = []) {
		$token = Funcs::getBearerToken();

		if (!$token) {
			return false;
		}

		if ($token !== '12345678') {
			return false;
		}

		return true;
	}

}