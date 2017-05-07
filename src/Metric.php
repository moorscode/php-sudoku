<?php

namespace Sudoku;

class Metric {
	/** @var int Value */
	protected $value;
	/** @var string Format */
	protected $format;

	/**
	 * Metric constructor.
	 *
	 * @param     $format
	 * @param int $defaultValue
	 */
	public function __construct( $format, $defaultValue = 0, callable $displayCallback = null ) {
		$this->format = $format;
		$this->value = $defaultValue;
		$this->display = $displayCallback ?: [ $this, 'get' ];
	}

	/**
	 * @param $value
	 */
	public function set( $value ) {
		$this->value = $value;
	}

	/**
	 *
	 */
	public function increase() {
		$this->value++;
	}

	/**
	 * @return int
	 */
	public function get() {
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return sprintf( $this->format, call_user_func( $this->display, $this->value ) );
	}
}
