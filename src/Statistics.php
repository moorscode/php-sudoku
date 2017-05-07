<?php

namespace Sudoku;

class Statistics implements StatisticsInterface {
	protected $stats = [];

	/**
	 * @param               $identifier
	 * @param               $displayFormat
	 * @param int           $defaultValue
	 * @param callable|null $displayCallback
	 *
	 * @return MetricInterface
	 */
	public function register( $identifier, $displayFormat, $defaultValue = 0, callable $displayCallback = null ) {
		$this->stats[ $identifier ] = new Metric( $displayFormat, $defaultValue, $displayCallback );
		return $this->stats[ $identifier ];
	}

	/**
	 * @return void
	 */
	public function display() {
		echo implode( '<br/>', $this->stats );
	}
}
