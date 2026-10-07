<?php

namespace WPSPLITE\App\Http\Middleware;

use Closure;
use WPSPCORELITE\App\Http\Request;
use WPSPLITE\App\Models\UsersModel;
use WPSPLITE\Funcs;

class ApiTokenAuthentication {

	public function handle(Request $request, Closure $next, $args = []) {
		$token = Funcs::getBearerToken();
		if (!$token) {
			return false;
		}

		$tokenHash = hash('sha256', $token);
		if (!UsersModel::where('api_token', $tokenHash)->first()) {
			return false;
		}

		return true;
	}

}