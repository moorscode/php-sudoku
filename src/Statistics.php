<?php

namespace Sudoku;

class Statistics implements StatisticsInterface {
	protected $stats = [];

	public function register( $identifier, $displayFormat, $defaultValue = 0, callable $displayCallback = null ) {
		$this->stats[ $identifier ] = new Metric( $displayFormat, $defaultValue, $displayCallback );
	}

	public function increase( $identifier ) {
		$this->stats[ $identifier ]->increase();
	}

	public function set( $identifier, $value ) {
		$this->stats[ $identifier ]->set( $value );
	}

	public function max( $identifier, $value ) {
		$value = max( $this->stats[ $identifier ]->get(), $value );
		$this->stats[ $identifier ]->set( $value );
	}

	public function display() {
		echo implode( '<br/>', $this->stats );
	}
}
