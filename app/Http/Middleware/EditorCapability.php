<?php

namespace WPSP\App\Http\Middleware;

use Closure;
use WPSPCORELITE\App\Widen\Http\Request;

class EditorCapability {

	public function handle(Request $request, Closure $next, $args = []) {
		return current_user_can('read');
	}

}
