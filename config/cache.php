<?php

/*
|--------------------------------------------------------------------------
| Cache - wpsp-lite/config/cache.php
|--------------------------------------------------------------------------
|
| Same shape as Laravel 12's config/cache.php. Code does not change when
| switching store: Cache::remember(), tags(), lock(), flexible()... work
| the same on every store.
|
| Drivers:
|   transient    WordPress Transients API (wp_options, or the Redis/Memcached drop-in)
|   object       WordPress object cache (wp_cache_*), needs a persistent drop-in
|   file         Pure PHP file cache (Laravel "file" driver)
|   phpfastcache Needs: composer require phpfastcache/phpfastcache
|   array, null, failover
|
| The Application binds this config as 'cache' (CacheManager) and 'cache.store'.
| Isolation from other plugins is automatic, based on 'prefix':
|   - keys are "{prefix}.{key}", so no prefix can overlap another one;
|   - folders are always "{path}/{prefix}/..." (path = wp-content/cache by default);
|   - Redis / Memcached can be shared (same host, same database) by every plugin:
|     flush() only removes this plugin's keys, it never runs FLUSHDB.
|
*/

return [

	/*
	|--------------------------------------------------------------------------
	| Default Cache Store
	|--------------------------------------------------------------------------
	|
	| A store name from 'stores' below. Only use a phpfastcache store when this
	| plugin requires phpfastcache/phpfastcache in its own composer.json.
	|
	*/

	'default' => 'transient',

	/*
	|--------------------------------------------------------------------------
	| Cache Stores
	|--------------------------------------------------------------------------
	*/

	'stores' => [

		'transient' => [
			'driver'            => 'transient',
			'network'           => false,      		// true = site transients (shared across a multisite network)
			'atomic_increments' => true,       		// increment()/decrement() under a short lock
			'lock_lottery'      => [2, 100],   		// chance to prune expired lock rows
			'lock_timeout'      => 86400,      		// max lifetime of a lock acquired with 0 seconds
//			'finish_request' => true,       		// flexible(): send the response before refreshing (PHP-FPM)
		],

		'object' => [
			'driver' => 'object',             		// groups "wpsp_lite_cache" / "wpsp_lite_cache_locks"
		],

		'file' => [
			'driver' => 'file',
// 			'path' => WP_CONTENT_DIR . '/cache',   	// => wp-content/cache/wpsp_lite/data
		],

		/*
		| phpfastcache stores: only usable when this plugin has phpfastcache/phpfastcache.
		*/

		'phpfastcache' => [
			'driver'              => 'phpfastcache',
			'phpfastcache_driver' => 'Files',
			'options'             => [
// 			'path' => WP_CONTENT_DIR . '/cache',   	// => wp-content/cache/wpsp_lite/files
			],
		],

		'redis' => [
			'driver'              => 'phpfastcache',
			'phpfastcache_driver' => 'Redis',
			'options'             => [
				'host'     => '127.0.0.1',
				'port'     => 6379,
				'database' => 0,                  	// may be shared with any other plugin / object cache
// 				'password' => '',
			],
		],

		'array' => [
			'driver'    => 'array',
			'serialize' => false,
		],

		'null' => [
			'driver' => 'null',
		],

		'failover' => [
			'driver' => 'failover',
			'stores' => ['redis', 'transient'],
		],

	],

	/*
	|--------------------------------------------------------------------------
	| Cache Key Prefix
	|--------------------------------------------------------------------------
	|
	| null = built from this plugin's folder name: plugins/wpsp-lite => "wpsp_lite_",
	| plugins/plugin-cua-toi => "plugin_cua_toi_". Two plugins on one site can't share a
	| folder, so leaving it null is the safest choice: a plugin created from this template
	| never collides with another one. Set a string only to pin a fixed prefix
	| (characters other than A-Z a-z 0-9 _ - are removed).
	|
	*/

	'prefix' => null,

	/*
	|--------------------------------------------------------------------------
	| Cache Class
	|--------------------------------------------------------------------------
	|
	| Class the Application binds as 'cache'. Must extend \WPSPCORELITE\App\Cache\Cache.
	|
	*/

	'class' => \WPSPLITE\App\Widen\Cache\Cache::class,

	/*
	|--------------------------------------------------------------------------
	| Rate Limiter
	|--------------------------------------------------------------------------
	|
	| 'limiter': store holding the RateLimiter counters (null = 'default').
	| Use a store shared by every request (transient, object, file, redis...),
	| never 'array' or 'null'. 'limiter_class' must extend
	| \WPSPCORELITE\App\Cache\RateLimiter.
	|
	*/

	'limiter' => null,

	'limiter_class' => \WPSPLITE\App\Widen\Cache\RateLimiter::class,

	/*
	|--------------------------------------------------------------------------
	| Cache Events
	|--------------------------------------------------------------------------
	|
	| false = off. true = WordPress hooks "{prefix}cache" e.g. "wpsp_lite_cache" (every event)
	| and "wpsp_lite_cache/cache_hit", ".../cache_missed", ".../key_written"...
	| A string sets a custom hook name.
	|
	*/

	'events' => false,

];
