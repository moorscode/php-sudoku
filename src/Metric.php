<?php

namespace Sudoku;

class Metric implements MetricInterface {
	/** @var number Value */
	protected $value;
	/** @var string Format */
	protected $format;
	/** @var callable Display formatter */
	protected $display;

	/**
	 * Metric constructor.
	 *
	 * @param               $format
	 * @param int           $defaultValue
	 * @param callable|null $displayCallback
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
	 * @param $value
	 */
	public function max( $value ) {
		$this->value = max( $this->value, $value );
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
