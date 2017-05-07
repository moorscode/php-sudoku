<?php

namespace Sudoku;

interface MetricInterface {
	/**
	 * @param $value
	 */
	public function set( $value );

	/**
	 *
	 */
	public function increase();

	/**
	 * @param $value
	 */
	public function max( $value );

	/**
	 * @return int
	 */
	public function get();
}
