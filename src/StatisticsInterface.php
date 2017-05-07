<?php

namespace Sudoku;

interface StatisticsInterface {
	/**
	 * @param               $identifier
	 * @param               $displayFormat
	 * @param int           $defaultValue
	 * @param callable|null $displayCallback
	 *
	 * @return MetricInterface
	 */
	public function register( $identifier, $displayFormat, $defaultValue = 0, callable $displayCallback = null );

	/**
	 * @return mixed
	 */
	public function display();
}