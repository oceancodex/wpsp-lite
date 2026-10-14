<?php

namespace WPSPLITE\App\Widen\View;

use eftec\bladeone\BladeOne as BaseBladeOne;

/**
 * Engine BladeOne đã vá cho giống Laravel Blade hơn:
 *
 * 1. Stack có dấu "-" (vd: @stack('before-title-stack')):
 *    postRun() gốc dùng regex [A-Za-z0-9_:() ,*.@$]+ nên không nhận "-",
 *    placeholder "-#1Z#-#2B#...,#3R#-#4X#-" bị in ra frontend.
 *
 * 2. Component <x-...>:
 *    - Hỗ trợ named slot: <x-slot:title>...</x-slot:title> và <x-slot name="title">...</x-slot>
 *    - Parser thuộc tính mới: giá trị có dấu cách, nháy đơn/kép, thuộc tính boolean,
 *      :prop="$php", :$var, kebab-case → camelCase (giống Laravel).
 *    - $slot và named slot là HtmlString nên {{ $slot }} không bị escape (giống Laravel).
 */
class BladeOneEngine extends BaseBladeOne {

	/**
	 * Gọi qua static::e() để HtmlString không bị escape.
	 */
	protected string $echoFormat = 'static::e(%s??null)';

	/**
	 * fn(string $view, array $data): array — gộp biến share/composer cho mỗi view.
	 *
	 * @var \Closure|null
	 */
	protected ?\Closure $dataResolver = null;

	public function setDataResolver(?callable $resolver) {
		$this->dataResolver = $resolver ? \Closure::fromCallable($resolver) : null;
		return $this;
	}

	/**
	 * Namespace chứa class component, vd: WPSPLITE\App\View\Components
	 *
	 * @var string[]
	 */
	protected array $componentNamespaces = [];

	/**
	 * Alias → class, vd: ['alert' => AlertComponent::class]
	 *
	 * @var array<string, string>
	 */
	protected array $componentAliases = [];

	public function addComponentNamespace($namespace) {
		$namespace = trim($namespace, '\\');
		if (!in_array($namespace, $this->componentNamespaces, true)) {
			$this->componentNamespaces[] = $namespace;
		}
		return $this;
	}

	public function addComponentAlias($alias, $class) {
		$this->componentAliases[$alias] = $class;
		return $this;
	}

	/**
	 * Cho phép @include / @each nhận View object (từ BladeOne::make / view()).
	 * Nếu không, PHP ép View thành string → render view đó một mình (thiếu biến của view cha)
	 * rồi dùng HTML kết quả làm tên template → "Template not found".
	 */
	public function runChild($view, $variables = []): string {
		if ($view instanceof View) {
			$variables = array_merge($view->getData(), is_array($variables) ? $variables : []);
			$view      = $view->name();
		}

		return parent::runChild($view, $variables);
	}

	/**
	 * Mọi lần render (run, @include, @extends, component) đều đi qua đây.
	 */
	protected function runInternal(string $view, array $variables = [], bool $forced = false, bool $runFast = false): string {
		if ($this->dataResolver) {
			$variables = ($this->dataResolver)($view, $variables);
		}

		return parent::runInternal($view, $variables, $forced, $runFast);
	}

	/*
	 * ---------------------------------------------------------------
	 * Escape
	 * ---------------------------------------------------------------
	 */

	public static function e(mixed $value): string {
		if ($value instanceof HtmlString || $value instanceof ComponentAttributeBag) {
			return $value->toHtml();
		}

		if ($value === null) {
			return '';
		}

		if (is_array($value) || (is_object($value) && !$value instanceof \Stringable)) {
			$value = print_r($value, true);
		}

		// htmlspecialchars giống Laravel; htmlentities của BladeOne gốc
		// sẽ biến tiếng Việt có dấu thành entity (á → &aacute;).
		return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8', false);
	}

	/*
	 * ---------------------------------------------------------------
	 * Stack
	 * ---------------------------------------------------------------
	 */

	protected function postRun(?string $string) {
		if (!$string || !\str_contains($string, $this->escapeStack0)) {
			return $string;
		}

		$open  = preg_quote($this->escapeStack0, '/');
		$close = preg_quote($this->escapeStack1, '/');

		return preg_replace_callback(
			'/' . $open . '\s?(.*?)\s?' . $close . '/su',
			function($matches) {
				$item  = trim($matches[1]);
				$items = explode(',', $item, 2);
				$name  = trim(trim($items[0]), '\'"');
				$def   = isset($items[1]) ? trim(trim($items[1]), '\'"') : '';

				return $this->yieldPushContent($name, $def);
			},
			$string
		);
	}

	/*
	 * ---------------------------------------------------------------
	 * Class components (app/View/Components)
	 * ---------------------------------------------------------------
	 */

	/**
	 * <x-admin-pages.admin-page-meta-box> → nếu có class
	 * {namespace}\AdminPages\AdminPageMetaBox thì khởi tạo class (constructor nhận
	 * thuộc tính theo tên), gọi render() và đưa public property/method vào view.
	 * Không có class → anonymous component như BladeOne gốc.
	 */
	public function renderComponent(): string {
		$name  = end($this->componentStack);
		$class = is_string($name) ? $this->resolveComponentClass($name) : null;

		if (!$class) {
			return parent::renderComponent();
		}

		array_pop($this->componentStack);

		$index     = \count($this->componentStack);
		$slotNames = array_keys($this->slots[$index] ?? []);

		$this->anonymousComponent = false;
		try {
			$data = $this->componentData();
		}
		finally {
			$this->anonymousComponent = true;
		}

		$slots = ['slot' => $data['slot'] ?? new HtmlString('')];
		foreach ($slotNames as $slotName) {
			$slots[$slotName] = $data[$slotName];
		}

		$attributes = array_diff_key($data, $slots);

		$component = $this->makeComponent($class, $attributes, $slots, substr($name, strlen('components.')));

		if (!$component->shouldRender()) {
			return '';
		}

		$viewData = array_merge(
			$component->data(),
			['componentName' => $component->componentName, 'attributes' => $component->attributes],
			$slots
		);

		$result = $this->renderComponentView($component->render(), $viewData);

		foreach (array_keys($viewData) as $key) {
			unset($this->variables[$key]);
		}

		return $result;
	}

	protected function resolveComponentClass($name) {
		if (!str_starts_with($name, 'components.')) {
			return null;
		}

		$alias = substr($name, strlen('components.'));

		if (isset($this->componentAliases[$alias])) {
			return $this->componentAliases[$alias];
		}

		if (!$this->componentNamespaces) {
			return null;
		}

		$segments = array_map(fn($s) => str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $s))), explode('.', $alias));
		$relative = implode('\\', $segments);
		$last     = end($segments);

		foreach ($this->componentNamespaces as $namespace) {
			// <x-card> → Card, Card\Card, Card\Index (giống Laravel)
			foreach ([$relative, $relative . '\\' . $last, $relative . '\\Index'] as $candidate) {
				$class = $namespace . '\\' . $candidate;
				if (class_exists($class) && is_subclass_of($class, Component::class)) {
					return $class;
				}
			}
		}

		return null;
	}

	/**
	 * Khởi tạo component: tham số constructor lấy theo tên từ thuộc tính (hoặc slot),
	 * thuộc tính còn lại vào $attributes.
	 */
	protected function makeComponent($class, array $attributes, array $slots, $componentName = null) {
		$reflection  = new \ReflectionClass($class);
		$constructor = $reflection->getConstructor();
		$args        = [];
		$consumed    = [];

		if ($constructor) {
			foreach ($constructor->getParameters() as $param) {
				$name  = $param->getName();
				$kebab = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $name));
				$key   = array_key_exists($name, $attributes) ? $name : (array_key_exists($kebab, $attributes) ? $kebab : null);

				if ($key !== null) {
					$args[]     = $attributes[$key];
					$consumed[] = $key;
				}
				elseif (array_key_exists($name, $slots)) {
					$args[] = $slots[$name];
				}
				elseif ($param->isDefaultValueAvailable()) {
					$args[] = $param->getDefaultValue();
				}
				elseif ($param->allowsNull()) {
					$args[] = null;
				}
				else {
					throw new \InvalidArgumentException(
						"Component [{$class}]: thiếu tham số bắt buộc \${$name}."
					);
				}
			}
		}

		/** @var Component $component */
		$component = $reflection->newInstanceArgs($args);

		$component->withName($componentName);
		$component->withAttributes(array_diff_key($attributes, array_flip($consumed)));

		return $component;
	}

	/**
	 * render() có thể trả về: View object, tên view, Closure, hoặc Blade inline.
	 */
	protected function renderComponentView($view, array $data) {
		if ($view instanceof \Closure) {
			$view = $view($data);
		}

		if ($view instanceof View) {
			return $this->runChild($view, $data);
		}

		if ($view instanceof HtmlString) {
			return $view->toHtml();
		}

		$view = (string)$view;

		if ($view !== '' && !str_contains($view, '<') && $this->getTemplateFile($view) !== '') {
			return $this->runChild($view, $data);
		}

		// Blade inline
		return $this->runString($view, array_merge($this->variables, $data));
	}

	/*
	 * ---------------------------------------------------------------
	 * Components <x-...>
	 * ---------------------------------------------------------------
	 */

	protected function compileComponents($value) {
		$value = $this->compileSlotTags($value);

		return parent::compileComponents($value);
	}

	/**
	 * <x-slot:title>...</x-slot:title>       → @slot('title') ... @endslot
	 * <x-slot name="title">...</x-slot>      → @slot('title') ... @endslot
	 * Lặp đến khi hết, để xử lý slot lồng trong component con.
	 */
	protected function compileSlotTags($value) {
		if (!\str_contains($value, '<x-slot')) {
			return $value;
		}

		$patterns = [
			'/<x-slot:([\w.-]+)(?:\s[^>]*)?>(.*?)<\/x-slot:\1\s*>/s',
			'/<x-slot\s+name\s*=\s*["\']([\w.-]+)["\'][^>]*>(.*?)<\/x-slot\s*>/s',
		];

		do {
			$before = $value;

			foreach ($patterns as $pattern) {
				$value = preg_replace_callback($pattern, function($m) {
					$name = $this->toCamel($m[1]);

					return $this->compileSlot("('" . $name . "')") . $m[2] . $this->compileEndSlot();
				}, $value);
			}
		}
		while ($value !== $before && \str_contains($value, '<x-slot'));

		return $value;
	}

	/**
	 * Parse thuộc tính của component thành mảng PHP.
	 *
	 *   id="submitdiv"               → 'id' => 'submitdiv'
	 *   class="a b"                  → 'class' => 'a b'
	 *   :items="$list"               → 'items' => $list
	 *   :$user                       → 'user' => $user
	 *   admin-page="x"               → 'admin-page' => 'x' (anonymous component có thêm biến $adminPage)
	 *   disabled                     → 'disabled' => true
	 */
	protected function parseParams($params): string {
		$params = (string)$params;

		preg_match_all(
			'/(:?\$?[\w:.@-]+)(?:\s*=\s*(?:"([^"]*)"|\'([^\']*)\'))?/s',
			$params,
			$matches,
			PREG_SET_ORDER | PREG_UNMATCHED_AS_NULL
		);

		$compiled = [];

		foreach ($matches as $m) {
			$key   = $m[1];
			$value = $m[2] ?? $m[3];

			// :$user
			if (\str_starts_with($key, ':$')) {
				$var        = substr($key, 2);
				$compiled[] = var_export($var, true) . ' => $' . $var;
				continue;
			}

			// :prop="php expression"
			if (\str_starts_with($key, ':')) {
				$key        = substr($key, 1);
				$compiled[] = var_export($key, true) . ' => ' . ($value === null || $value === '' ? 'null' : $value);
				continue;
			}

			$compiled[] = var_export($key, true) . ' => ' . ($value === null ? 'true' : var_export($value, true));
		}

		return '[' . implode(', ', $compiled) . ']';
	}

	/**
	 * true khi đang render anonymous component (không có class).
	 */
	protected bool $anonymousComponent = true;

	/**
	 * - Bọc $slot và named slot bằng HtmlString.
	 * - Anonymous component: thêm $attributes và biến camelCase cho thuộc tính kebab-case
	 *   (data-id="1" → $attributes['data-id'] và $dataId).
	 */
	protected function componentData(): array {
		$index = \count($this->componentStack);
		$names = array_keys($this->slots[$index] ?? []);

		$data = parent::componentData();

		foreach (array_merge(['slot'], $names) as $name) {
			if (isset($data[$name]) && is_string($data[$name])) {
				$data[$name] = new HtmlString($data[$name]);
			}
		}

		if ($this->anonymousComponent) {
			$attributes = array_diff_key($data, array_flip(array_merge(['slot'], $names)));

			foreach ($attributes as $key => $value) {
				$camel = $this->toCamel($key);
				if ($camel !== $key && !array_key_exists($camel, $data)) {
					$data[$camel] = $value;
				}
			}

			if (!isset($data['attributes'])) {
				$data['attributes'] = new ComponentAttributeBag($attributes);
			}
		}

		return $data;
	}

	protected function toCamel($value) {
		if (!preg_match('/[-_]/', $value)) {
			return $value;
		}

		return lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value))));
	}

}