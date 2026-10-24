<?php

/**
 * Cấu hình Gate của plugin (WPSPCORELITE\App\Auth\Access\Gate).
 *
 * Application đọc file này khi tạo binding 'gate' lần đầu (xem Application::createGate()).
 * Gate đó được dùng chung cho:
 * - Route: ->can(...), Route::can(...), ->middleware('can:...')
 * - Controller middleware: $this->middleware('can:...')
 * - Facade: \WPSPLITE\App\Widen\Support\Facades\Gate::allows(...)
 *
 * Mỗi plugin có Application riêng nên cấu hình này chỉ áp cho plugin hiện tại.
 */
return [

	/*
	|--------------------------------------------------------------------------
	| Policies
	|--------------------------------------------------------------------------
	|
	| Gắn Policy với class: [Class::class => Policy::class].
	| Policy được tìm theo đối số đầu tiên của can:
	|     ->can('viewAny', \WP_Post::class)            → PostPolicy::viewAny($user)
	|     ->can('update', [\WP_Post::class, 'post'])   → PostPolicy::update($user, '5')
	|
	| Class WordPress không có namespace (WP_Post, WP_User, WP_Term...) bắt buộc khai báo ở đây
	| hoặc bằng Gate::policy() trong boot() của provider, vì Gate không tự đoán được.
	|
	| Class có namespace được tự đoán, không cần khai báo:
	|     WPSPLITE\App\Models\Order     → WPSPLITE\App\Policies\OrderPolicy
	|     WPSPLITE\App\Resources\Report → WPSPLITE\App\Policies\ReportPolicy
	|
	| Policy class phải tồn tại: Gate khởi tạo Policy (qua container, có DI) khi cần dùng.
	|
	*/

	'policies' => [
		// \WP_Post::class => \WPSPLITE\App\Policies\PostPolicy::class,
		// \WP_User::class => \WPSPLITE\App\Policies\UserPolicy::class,
		// \WP_Term::class => \WPSPLITE\App\Policies\TermPolicy::class,
	],

	/*
	|--------------------------------------------------------------------------
	| Capability fallback
	|--------------------------------------------------------------------------
	|
	| true:  ability không có Policy / Gate::define → hỏi user_can() của WordPress.
	|        Dùng được ngay: ->can('manage_options'), ->can('edit_post', 'post').
	| false: chỉ dùng Policy / Gate::define, ability chưa định nghĩa luôn bị từ chối.
	|
	*/

	'capability_fallback' => true,

	/*
	|--------------------------------------------------------------------------
	| Policy namespaces
	|--------------------------------------------------------------------------
	|
	| Namespace thêm để tự đoán Policy. Gate luôn thử {RootNamespace}\App\Policies trước,
	| sau đó tới các namespace dưới đây, rồi tới quy ước Models → Policies.
	|
	*/

	'policy_namespaces' => [
		// 'WPSPLITE\\App\\Policies\\Admin',
	],

	/*
	|--------------------------------------------------------------------------
	| Gate class
	|--------------------------------------------------------------------------
	|
	| Class Gate riêng của plugin (vd: thêm method, đổi cách lấy user).
	| Phải kế thừa \WPSPCORELITE\App\Auth\Access\Gate, nếu không sẽ dùng Gate mặc định.
	|
	*/

	// 'gate_class' => \WPSPLITE\App\Widen\Auth\Access\Gate::class,

];
