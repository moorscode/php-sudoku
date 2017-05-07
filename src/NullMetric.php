<?php

namespace Sudoku;

class NullMetric implements MetricInterface {
	/**
	 * @param $value
	 */
	public function set( $value ) {
	}

	/**
	 *
	 */
	public function increase() {
	}

	/**
	 * @param $value
	 */
	public function max( $value ) {
	}

	/**
	 * @return int
	 */
	public function get() {
	}
}
