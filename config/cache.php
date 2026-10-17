<?php

/*
|--------------------------------------------------------------------------
| Cache - wpsp-lite/config/cache.php
|--------------------------------------------------------------------------
|
| Cấu trúc giống config/cache.php của Laravel 12. Đổi store không cần sửa
| code: Cache::remember(), tags(), lock(), flexible()... hoạt động như nhau
| trên mọi store.
|
| Các driver:
|   transient    WordPress Transients API (wp_options, hoặc drop-in Redis/Memcached)
|   object       WordPress object cache (wp_cache_*), cần một drop-in persistent
|   file         File cache thuần PHP (driver "file" của Laravel)
|   phpfastcache Cần: composer require phpfastcache/phpfastcache
|   array, null, failover
|
| Application bind config này thành 'cache' (CacheManager) và 'cache.store'.
| Việc tách biệt với các plugin khác là tự động, dựa trên 'prefix':
|   - key có dạng "{prefix}.{key}", nên không prefix nào có thể trùng prefix khác;
|   - thư mục luôn là "{path}/{prefix}/..." (path mặc định = wp-content/cache);
|   - Redis / Memcached có thể dùng chung (cùng host, cùng database) cho mọi plugin:
|     flush() chỉ xóa key của plugin này, không bao giờ chạy FLUSHDB.
|
*/

return [

	/*
	|--------------------------------------------------------------------------
	| Store cache mặc định
	|--------------------------------------------------------------------------
	|
	| Tên một store trong 'stores' bên dưới. Chỉ dùng store phpfastcache khi
	| plugin này có require phpfastcache/phpfastcache trong composer.json của nó.
	|
	*/

	'default' => 'transient',

	/*
	|--------------------------------------------------------------------------
	| Các store cache
	|--------------------------------------------------------------------------
	*/

	'stores' => [

		'transient' => [
			'driver'            => 'transient',
			'network'           => false,      		// true = site transients (dùng chung cho cả mạng multisite)
			'atomic_increments' => true,       		// increment()/decrement() chạy dưới một lock ngắn
			'lock_lottery'      => [2, 100],   		// xác suất dọn các dòng lock đã hết hạn
			'lock_timeout'      => 86400,      		// thời gian sống tối đa của lock lấy với 0 giây
//			'finish_request' 	=> true,       		// flexible(): gửi response trước rồi mới làm mới cache (PHP-FPM)
		],

		'object' => [
			'driver' => 'object',             		// group "wpsp_lite_cache" / "wpsp_lite_cache_locks"
		],

		'file' => [
			'driver' => 'file',
// 			'path' 	 => WP_CONTENT_DIR . '/cache',   	// => wp-content/cache/wpsp_lite/data
		],

		/*
		| Các store phpfastcache: chỉ dùng được khi plugin này có phpfastcache/phpfastcache.
		*/

		'phpfastcache' => [
			'driver'              => 'phpfastcache',
			'phpfastcache_driver' => 'Files',
			'options'             => [
// 				'path' => WP_CONTENT_DIR . '/cache',   	// => wp-content/cache/wpsp_lite/files
			],
		],

		'redis' => [
			'driver'              => 'phpfastcache',
			'phpfastcache_driver' => 'Redis',
			'options'             => [
				'host'     => '127.0.0.1',
				'port'     => 6379,
				'database' => 0,                  	// có thể dùng chung với plugin / object cache khác
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
	| Prefix cho key cache
	|--------------------------------------------------------------------------
	|
	| null = tạo từ tên thư mục của plugin: plugins/wpsp-lite => "wpsp_lite_",
	| plugins/plugin-cua-toi => "plugin_cua_toi_". Hai plugin trên cùng một site không thể
	| trùng thư mục, nên để null là an toàn nhất: plugin tạo từ template này sẽ không bao giờ
	| đụng độ với plugin khác. Chỉ đặt một chuỗi khi muốn cố định prefix
	| (các ký tự ngoài A-Z a-z 0-9 _ - sẽ bị loại bỏ).
	|
	*/

	'prefix' => null,

	/*
	|--------------------------------------------------------------------------
	| Class Cache
	|--------------------------------------------------------------------------
	|
	| Class mà Application bind thành 'cache'. Phải kế thừa \WPSPCORELITE\App\Cache\Cache.
	|
	*/

	'class' => \WPSPLITE\App\Widen\Cache\Cache::class,

	/*
	|--------------------------------------------------------------------------
	| Rate Limiter
	|--------------------------------------------------------------------------
	|
	| 'limiter': store lưu các bộ đếm của RateLimiter (null = 'default').
	| Dùng store được chia sẻ giữa mọi request (transient, object, file, redis...),
	| không bao giờ dùng 'array' hay 'null'. 'limiter_class' phải kế thừa
	| \WPSPCORELITE\App\Cache\RateLimiter.
	|
	*/

	'limiter' => null,

	'limiter_class' => \WPSPLITE\App\Widen\Cache\RateLimiter::class,

	/*
	|--------------------------------------------------------------------------
	| Sự kiện cache
	|--------------------------------------------------------------------------
	|
	| false = tắt. true = WordPress hook "{prefix}cache" vd. "wpsp_lite_cache" (mọi sự kiện)
	| và "wpsp_lite_cache/cache_hit", ".../cache_missed", ".../key_written"...
	| Một chuỗi = đặt tên hook tùy chỉnh.
	|
	*/

	'events' => false,

];