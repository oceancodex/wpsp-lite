<?php
/**
 * Created by PhpStorm.
 * User: Khanh
 * Date: 18/10/2026
 * Time: 3:40 SA
 */

namespace WPSPLITE\App\Widen\Cache;

use WPSPLITE\App\Widen\Traits\InstancesTrait;

/**
 * RateLimiter của plugin WPSPLITE: bộ đếm nằm trong cache của plugin (config/cache.php, khoá 'limiter').
 */
class RateLimiter extends \WPSPCORELITE\App\Cache\RateLimiter {

	use InstancesTrait;

}
