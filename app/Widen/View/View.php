<?php

namespace WPSPLITE\App\Widen\View;

/**
 * Đối tượng View trả về từ BladeOne::make(), mô phỏng Illuminate\View\View.
 * Chỉ render khi gọi render() hoặc ép kiểu sang string.
 */
class View implements \Stringable {

	/** @var BladeOne */
	protected $factory;

	/** @var string */
	protected $view;

	/** @var array */
	protected $data = [];

	public function __construct(BladeOne $factory, $view, $data = []) {
		$this->factory = $factory;
		$this->view    = $view;
		$this->data    = $data;
	}

	/**
	 * Thêm dữ liệu cho view.
	 *
	 * @param string|array $key
	 * @param mixed        $value
	 *
	 * @return $this
	 */
	public function with($key, $value = null) {
		if (is_array($key)) {
			$this->data = array_merge($this->data, $key);
		}
		else {
			$this->data[$key] = $value;
		}

		return $this;
	}

	/**
	 * Render view thành string.
	 *
	 * @throws \Exception
	 */
	public function render() {
		return $this->factory->render($this->view, $this->data);
	}

	public function name() {
		return $this->view;
	}

	public function getName() {
		return $this->view;
	}

	public function getData() {
		return $this->data;
	}

	/*
	 * Cho phép $view->title = '...' và $view['title'] giống Laravel.
	 */

	public function __set($key, $value) {
		$this->with($key, $value);
	}

	public function __get($key) {
		return $this->data[$key] ?? null;
	}

	public function __isset($key) {
		return isset($this->data[$key]);
	}

	public function __unset($key) {
		unset($this->data[$key]);
	}

	/**
	 * Hỗ trợ ->withTitle('...') giống Laravel.
	 */
	public function __call($method, $parameters) {
		if (str_starts_with($method, 'with') && strlen($method) > 4) {
			$key = lcfirst(substr($method, 4));
			return $this->with($key, $parameters[0] ?? null);
		}

		throw new \BadMethodCallException(sprintf(
			'Method %s::%s does not exist.', static::class, $method
		));
	}

	public function __toString(): string {
		try {
			return (string)$this->render();
		}
		catch (\Throwable $e) {
			// __toString không được phép ném exception ở PHP < 7.4.
			if (defined('WP_DEBUG') && WP_DEBUG) {
				return $e->getMessage();
			}
			return '';
		}
	}

}