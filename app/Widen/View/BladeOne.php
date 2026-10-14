<?php
/**
 * Created by PhpStorm.
 * User: khanhpkvn
 * Date: 14/10/2026
 * Time: 2:45 PM
 */

namespace WPSPLITE\App\Widen\View;

use WPSPLITE\App\Widen\Traits\InstancesTrait;
use WPSPCORELITE\BaseInstances;

/**
 * Wrapper cho eftec/bladeone, dùng giống Laravel:
 *
 *   BladeOne::view('pages.home', ['title' => 'Home']);
 *   BladeOne::share('siteName', 'KDNCOMIC');
 *   BladeOne::composer('layouts.*', fn(View $view) => $view->with('menu', $menu));
 *   BladeOne::exists('pages.home');
 *   BladeOne::directive('money', fn($exp) => "<?php echo number_format($exp); ?>");
 */
class BladeOne extends BaseInstances {

	use InstancesTrait;

	/** @var BladeOneEngine|null */
	protected $engine = null;

	/** @var string[] */
	protected $viewPaths = [];

	/** @var string|null */
	protected $cachePath = null;

	/** @var int|null */
	protected $mode = null;

	/** @var array Biến share cho mọi view. */
	protected $shared = [];

	/** @var array [[pattern, callback], ...] */
	protected $composers = [];

	/** @var string[] Namespace chứa class component (ngoài mặc định). */
	protected $componentNamespaces = [];

	/** @var array<string, string> Alias → class component. */
	protected $componentAliases = [];

	/*
	 * ---------------------------------------------------------------
	 * Static API (giống Laravel facade)
	 * ---------------------------------------------------------------
	 */

	/**
	 * Render view thành string.
	 *
	 * @param string $view Tên view, hỗ trợ dot notation: 'folder.file'
	 * @param array  $data
	 * @param array  $mergeData
	 *
	 * @return string
	 * @throws \Exception
	 */
	public static function view($view, $data = [], $mergeData = []) {
		return static::instance()->render($view, array_merge($data, $mergeData));
	}

	/**
	 * Tạo đối tượng View (chưa render), giống View::make() của Laravel.
	 *
	 *   BladeOne::make('pages.home', ['title' => 'Home'])
	 *       ->with('user', $user)
	 *       ->render();
	 *
	 * @param string $view
	 * @param array  $data
	 * @param array  $mergeData
	 *
	 * @return View
	 */
	public static function make($view, $data = [], $mergeData = []) {
		// Giống Illuminate\View\Factory::make(): báo lỗi ngay nếu view không tồn tại.
		if (!is_string($view) || trim($view) === '') {
			throw new \InvalidArgumentException(sprintf(
				'BladeOne: tên view không hợp lệ (%s).', var_export($view, true)
			));
		}

		if (!static::exists($view)) {
			throw new \InvalidArgumentException("View [{$view}] not found.");
		}

		return new View(static::instance(), $view, array_merge($data, $mergeData));
	}

	/**
	 * Share biến cho tất cả view (kể cả @include, @extends, component).
	 * Dữ liệu truyền trực tiếp vào view được ưu tiên hơn biến share, giống Laravel.
	 *
	 *   BladeOne::share('siteName', 'KDNCOMIC');
	 *   BladeOne::share(['user' => $user, 'locale' => 'vi']);
	 *
	 * @param string|array $key
	 * @param mixed        $value
	 *
	 * @return mixed
	 */
	public static function share($key, $value = null) {
		$instance = static::instance();
		$keys     = is_array($key) ? $key : [$key => $value];

		foreach ($keys as $k => $v) {
			$instance->shared[$k] = $v;
		}

		return $value;
	}

	/**
	 * Lấy biến đã share.
	 */
	public static function shared($key, $default = null) {
		return static::instance()->shared[$key] ?? $default;
	}

	/**
	 * Lấy toàn bộ biến đã share.
	 */
	public static function getShared() {
		return static::instance()->shared;
	}

	/**
	 * Đăng ký composer cho một hoặc nhiều view, hỗ trợ wildcard "*", giống Laravel.
	 * Composer chạy mỗi lần view đó được render (kể cả khi là view con).
	 *
	 *   BladeOne::composer('layouts.*', function(View $view) {
	 *       $view->with('menu', get_menu());
	 *   });
	 *   BladeOne::composer(['admin.*', 'components.admin-pages.*'], AdminComposer::class);
	 *   BladeOne::composer('*', 'App\View\Composers\GlobalComposer@compose');
	 *
	 * Composer dạng class cần có method compose(View $view).
	 *
	 * @param string|array           $views
	 * @param callable|string|object $callback
	 *
	 * @return array
	 */
	public static function composer($views, $callback) {
		$instance = static::instance();

		foreach ((array)$views as $view) {
			$instance->composers[] = [(string)$view, $callback];
		}

		return $instance->composers;
	}

	/**
	 * Đăng ký class component với alias, giống Blade::component().
	 *
	 *   BladeOne::component('meta-box', AdminPageMetaBox::class);  // <x-meta-box />
	 */
	public static function component($alias, $class) {
		$instance                           = static::instance();
		$instance->componentAliases[$alias] = $class;
		$instance->engine()->addComponentAlias($alias, $class);
		return $instance;
	}

	/**
	 * Thêm namespace chứa class component (vd: của plugin cha).
	 */
	public static function componentNamespace($namespace) {
		$instance  = static::instance();
		$namespace = trim($namespace, '\\');

		if (!in_array($namespace, $instance->componentNamespaces, true)) {
			$instance->componentNamespaces[] = $namespace;
		}

		$instance->engine()->addComponentNamespace($namespace);

		return $instance;
	}

	/**
	 * Kiểm tra view có tồn tại không.
	 */
	public static function exists($view) {
		try {
			$file = static::instance()->engine()->getTemplateFile($view);
			return $file && is_file($file);
		}
		catch (\Throwable $e) {
			return false;
		}
	}

	/**
	 * Đăng ký custom directive (compile-time), giống Blade::directive().
	 */
	public static function directive($name, callable $handler) {
		static::instance()->engine()->directive($name, $handler);
		return static::instance();
	}

	/**
	 * Đăng ký custom directive (runtime).
	 */
	public static function directiveRT($name, callable $handler) {
		static::instance()->engine()->directiveRT($name, $handler);
		return static::instance();
	}

	/**
	 * Truy cập trực tiếp engine gốc khi cần dùng API của BladeOne.
	 */
	public static function getEngine() {
		return static::instance()->engine();
	}

	/*
	 * ---------------------------------------------------------------
	 * Instance API
	 * ---------------------------------------------------------------
	 */

	/**
	 * @throws \Exception
	 */
	public function render($view, $data = []) {
		if (!is_string($view) || trim($view) === '') {
			throw new \InvalidArgumentException(sprintf(
				'BladeOne: tên view không hợp lệ (%s). Kiểm tra nơi gọi view()/BladeOne::view()/BladeOne::make().',
				var_export($view, true)
			));
		}

		return $this->engine()->run($view, $data);
	}

	/**
	 * Lazy-init engine, chỉ khởi tạo khi thực sự render.
	 */
	public function engine() {
		if ($this->engine) return $this->engine;

		$viewPaths = $this->getViewPaths();
		$cachePath = $this->getCachePath();

		$this->ensureDirectory($cachePath);

		$this->engine = new BladeOneEngine($viewPaths, $cachePath, $this->getMode());

		// Laravel dùng .blade.php
		$this->engine->setFileExtension('.blade.php');

		// Class component: {rootNamespace}\App\View\Components\... giống Laravel.
		foreach ($this->getComponentNamespaces() as $namespace) {
			$this->engine->addComponentNamespace($namespace);
		}
		foreach ($this->componentAliases as $alias => $class) {
			$this->engine->addComponentAlias($alias, $class);
		}

		// Gộp biến share + composer cho mỗi view được render (kể cả view con).
		$this->engine->setDataResolver(function($view, $data) {
			return $this->gatherData($view, $data);
		});

		return $this->engine;
	}

	/**
	 * Thêm thư mục view (ưu tiên theo thứ tự thêm).
	 */
	public function addViewPath($path) {
		$path = rtrim($path, '/\\');
		if (!in_array($path, $this->getViewPaths(), true)) {
			$this->viewPaths[] = $path;
		}

		// Reset engine để áp dụng path mới.
		$this->engine = null;

		return $this;
	}

	public function setCachePath($path) {
		$this->cachePath = rtrim($path, '/\\');
		$this->engine    = null;
		return $this;
	}

	public function setMode($mode) {
		$this->mode = $mode;
		if ($this->engine) {
			$this->engine->setMode($mode);
		}
		return $this;
	}

	/**
	 * Thứ tự ưu tiên giống Laravel: shared < data truyền vào < composer.
	 */
	public function gatherData($view, array $data) {
		$data = array_merge($this->shared, $data);

		$composers = [];
		foreach ($this->composers as [$pattern, $callback]) {
			if ($this->viewMatches($view, $pattern)) {
				$composers[] = $callback;
			}
		}

		if (!$composers) {
			return $data;
		}

		$viewObject = new View($this, $view, $data);

		foreach ($composers as $callback) {
			$this->callComposer($callback, $viewObject);
		}

		return $viewObject->getData();
	}

	protected function callComposer($callback, View $view) {
		// 'Class@method'
		if (is_string($callback) && str_contains($callback, '@')) {
			[$class, $method] = explode('@', $callback, 2);
			$this->resolveComposer($class)->{$method}($view);
			return;
		}

		// Closure / [obj, 'method'] / 'function_name'
		if (is_callable($callback) && !(is_string($callback) && class_exists($callback))) {
			$callback($view);
			return;
		}

		// Class name hoặc object có method compose()
		$this->resolveComposer($callback)->compose($view);
	}

	protected function resolveComposer($class) {
		if (is_object($class)) {
			return $class;
		}

		if (!class_exists($class)) {
			throw new \InvalidArgumentException("BladeOne: composer class [{$class}] không tồn tại.");
		}

		return method_exists($class, 'instance') ? $class::instance() : new $class();
	}

	protected function viewMatches($view, $pattern) {
		if ($pattern === $view || $pattern === '*') {
			return true;
		}

		if (!str_contains($pattern, '*')) {
			return false;
		}

		$regex = '#^' . str_replace('\\*', '.*', preg_quote($pattern, '#')) . '$#u';

		return (bool)preg_match($regex, $view);
	}

	/*
	 * ---------------------------------------------------------------
	 * Defaults
	 * ---------------------------------------------------------------
	 */

	protected function getViewPaths() {
		if (empty($this->viewPaths)) {
			$this->viewPaths = [rtrim($this->mainPath, '/\\') . '/resources/views'];
		}
		return $this->viewPaths;
	}

	protected function getComponentNamespaces() {
		$namespaces = [];

		if ($this->rootNamespace) {
			$namespaces[] = trim($this->rootNamespace, '\\') . '\\App\\View\\Components';
		}

		return array_unique(array_merge($namespaces, $this->componentNamespaces));
	}

	protected function getCachePath() {
		if (!$this->cachePath) {
			$this->cachePath = rtrim($this->mainPath, '/\\') . '/storage/framework/views';
		}
		return $this->cachePath;
	}

	protected function getMode() {
		if ($this->mode !== null) return $this->mode;

		return (defined('WP_DEBUG') && WP_DEBUG)
			? BladeOneEngine::MODE_DEBUG
			: BladeOneEngine::MODE_AUTO;
	}

	protected function ensureDirectory($path) {
		if (is_dir($path)) return;

		if (function_exists('wp_mkdir_p')) {
			wp_mkdir_p($path);
		}
		else {
			@mkdir($path, 0755, true);
		}
	}

}