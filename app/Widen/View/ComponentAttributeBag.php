<?php

namespace WPSPLITE\App\Widen\View;

/**
 * Các thuộc tính HTML truyền vào component mà constructor không nhận,
 * mô phỏng Illuminate\View\ComponentAttributeBag.
 *
 *   <div {{ $attributes->merge(['class' => 'postbox']) }}>
 *   {{ $attributes->get('data-id') }}
 */
class ComponentAttributeBag implements \ArrayAccess, \IteratorAggregate, \Stringable {

	protected $attributes = [];

	public function __construct(array $attributes = []) {
		$this->attributes = $attributes;
	}

	public function all() {
		return $this->attributes;
	}

	public function getAttributes() {
		return $this->attributes;
	}

	public function get($key, $default = null) {
		return $this->attributes[$key] ?? $default;
	}

	public function has($key) {
		foreach ((array)$key as $k) {
			if (!array_key_exists($k, $this->attributes)) return false;
		}
		return true;
	}

	public function isEmpty() {
		return empty($this->attributes);
	}

	public function isNotEmpty() {
		return !$this->isEmpty();
	}

	public function only($keys) {
		return new static(array_intersect_key($this->attributes, array_flip((array)$keys)));
	}

	public function except($keys) {
		return new static(array_diff_key($this->attributes, array_flip((array)$keys)));
	}

	public function filter(callable $callback) {
		return new static(array_filter($this->attributes, $callback, ARRAY_FILTER_USE_BOTH));
	}

	public function whereStartsWith($prefix) {
		return $this->filter(fn($v, $k) => str_starts_with($k, $prefix));
	}

	/**
	 * Gộp giá trị mặc định. "class" và "style" được nối thêm, các thuộc tính khác
	 * truyền từ ngoài vào sẽ ghi đè mặc định — giống Laravel.
	 */
	public function merge(array $defaults = []) {
		$attributes = $defaults;

		foreach ($this->attributes as $key => $value) {
			if (in_array($key, ['class', 'style'], true) && isset($defaults[$key]) && $value !== true) {
				$glue             = $key === 'style' ? '; ' : ' ';
				$attributes[$key] = trim(rtrim($defaults[$key], '; ') . $glue . $value);
			}
			else {
				$attributes[$key] = $value;
			}
		}

		return new static($attributes);
	}

	/**
	 * $attributes->class(['p-4', 'bg-red' => $hasError])
	 */
	public function class($classList) {
		$classes = [];

		foreach ((array)$classList as $class => $constraint) {
			if (is_numeric($class)) {
				$classes[] = $constraint;
			}
			elseif ($constraint) {
				$classes[] = $class;
			}
		}

		return $this->merge(['class' => implode(' ', $classes)]);
	}

	public function toHtml() {
		$parts = [];

		foreach ($this->attributes as $key => $value) {
			if ($value === false || $value === null) continue;

			if ($value === true) {
				$parts[] = $key === 'x-data' ? $key . '=""' : $key;
				continue;
			}

			$parts[] = $key . '="' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8', false) . '"';
		}

		return implode(' ', $parts);
	}

	public function __toString(): string {
		return $this->toHtml();
	}

	public function offsetExists($offset): bool {
		return isset($this->attributes[$offset]);
	}

	public function offsetGet($offset): mixed {
		return $this->get($offset);
	}

	public function offsetSet($offset, $value): void {
		$this->attributes[$offset] = $value;
	}

	public function offsetUnset($offset): void {
		unset($this->attributes[$offset]);
	}

	public function getIterator(): \ArrayIterator {
		return new \ArrayIterator($this->attributes);
	}

}