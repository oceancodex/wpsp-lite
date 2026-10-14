<?php

namespace WPSPLITE\App\Widen\View;

/**
 * Base class cho class component, mô phỏng Illuminate\View\Component (không cần Illuminate).
 *
 *   namespace WPSPLITE\App\View\Components\AdminPages;
 *
 *   class AdminPageMetaBox extends \WPSPLITE\App\Widen\View\Component {
 *       public function __construct(public string $id = '') {}
 *       public function render() { return 'components.admin-pages.admin-page-meta-box'; }
 *   }
 *
 *   <x-admin-pages.admin-page-meta-box id="submitdiv" />
 *
 * Dữ liệu đưa vào view:
 *   - Mọi public property         → $id, $isClosed, ...
 *   - Mọi public method            → $isSelected($value) (Closure)
 *   - $attributes                  → ComponentAttributeBag (thuộc tính constructor không nhận)
 *   - $slot và các named slot      → HtmlString
 *   - $componentName
 */
abstract class Component {

	/** @var ComponentAttributeBag|null */
	public $attributes = null;

	/** @var string|null */
	public $componentName = null;

	/**
	 * Method không được đưa vào view dưới dạng biến.
	 *
	 * @var string[]
	 */
	protected $except = [];

	/**
	 * Trả về: tên view (string), View object, Closure, hoặc chuỗi Blade inline.
	 *
	 * @return View|\Closure|string
	 */
	abstract public function render();

	/**
	 * Trả về false để không render component.
	 */
	public function shouldRender() {
		return true;
	}

	/**
	 * Helper giống Laravel: return $this->view('components.alert');
	 */
	public function view($view, $data = [], $mergeData = []) {
		return BladeOne::make($view, $data, $mergeData);
	}

	/**
	 * Dữ liệu từ public property và public method.
	 */
	public function data() {
		$this->attributes = $this->attributes ?: new ComponentAttributeBag();

		return array_merge(
			$this->extractPublicProperties(),
			$this->extractPublicMethods()
		);
	}

	public function withName($name) {
		$this->componentName = $name;
		return $this;
	}

	public function withAttributes(array $attributes) {
		$this->attributes = $this->attributes ?: new ComponentAttributeBag();
		$this->attributes = new ComponentAttributeBag(array_merge($this->attributes->all(), $attributes));
		return $this;
	}

	/*
	 *
	 */

	protected function extractPublicProperties() {
		$values = [];

		$reflection = new \ReflectionObject($this);

		foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			if ($property->isStatic()) continue;

			$name = $property->getName();

			if (!$property->isInitialized($this)) continue;

			$values[$name] = $property->getValue($this);
		}

		return $values;
	}

	protected function extractPublicMethods() {
		$values = [];

		$ignored = array_merge($this->ignoredMethods(), $this->except);

		$reflection = new \ReflectionObject($this);

		foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
			$name = $method->getName();

			if ($method->isStatic() || str_starts_with($name, '__') || in_array($name, $ignored, true)) {
				continue;
			}

			$values[$name] = \Closure::fromCallable([$this, $name]);
		}

		return $values;
	}

	protected function ignoredMethods() {
		return [
			'render', 'shouldRender', 'view', 'data',
			'withName', 'withAttributes',
			'extractPublicProperties', 'extractPublicMethods', 'ignoredMethods',
		];
	}

}