<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

	'name' => env('WPSP_LITE_APP_NAME', 'WPSP Framework - WordPress Starter Plugin'),

	/*
	|--------------------------------------------------------------------------
	| Application Short Name
	|--------------------------------------------------------------------------
	*/

	'short_name' => env('WPSP_LITE_APP_SHORT_NAME', 'wpsp_lite'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

	'env' => env('WPSP_LITE_APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool)env('WPSP_LITE_APP_DEBUG', false),

    'debug_handler' => env('WPSP_LITE_APP_DEBUG_HANDLER', ''),

    'debug_monitor' => (bool)env('WPSP_LITE_APP_DEBUG_MONITOR', false),

    'debug_type' => env('WPSP_LITE_APP_DEBUG_TYPE', 'simple'),

    'debug_live_reload' => (bool)env('WPSP_LITE_APP_DEBUG_LIVE_RELOAD', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

	'url' => env('WPSP_LITE_APP_URL', function_exists('home_url') ? home_url() : 'https://localhost'),

	/*
	|--------------------------------------------------------------------------
	| Application Assets URL
	|--------------------------------------------------------------------------
	*/

	'asset_url' => defined('WPSP_LITE_ORIGINAL_START') ? env('WPSP_LITE_ASSET_ORIGINAL_URL') : env('WPSP_LITE_ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => env('WPSP_LITE_APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by WPSP's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

	'locale' => \WPSPLITE\Funcs::locale() ?? env('WPSP_LITE_APP_LOCALE', 'en'),

	'fallback_locale' => env('WPSP_LITE_APP_FALLBACK_LOCALE', 'en'),

	'faker_locale' => env('WPSP_LITE_APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by WPSP's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

	'cipher' => 'AES-256-CBC',

	'key' => env('WPSP_LITE_APP_KEY'),

	'previous_keys' => [
		...array_filter(
			explode(',', (string) env('WPSP_LITE_APP_PREVIOUS_KEYS', ''))
		),
	],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage WPSP's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

	'maintenance' => [
		'driver' => env('WPSP_LITE_APP_MAINTENANCE_DRIVER', 'file'),
		'store' => env('WPSP_LITE_APP_MAINTENANCE_STORE', 'database'),
	],

];