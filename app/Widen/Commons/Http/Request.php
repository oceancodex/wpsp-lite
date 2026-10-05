<?php
/**
 * Created by PhpStorm.
 * User: Khanh
 * Date: 05/10/2026
 * Time: 4:59 CH
 */

namespace WPSP\App\Widen\Commons\Http;

use Illuminate\Http\Request as IlluminateRequest;
use WPSPCORE\App\Widen\Commons\Http\Request as WPSPCORERequest;

if (class_exists(IlluminateRequest::class)) {
	class Request extends IlluminateRequest {}
}
else {
	class Request extends WPSPCORERequest {}
}