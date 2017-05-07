<?php

namespace Sudoku;

class Statistics implements StatisticsInterface {
	protected $stats = [];

	public function register( $identifier, $displayFormat ) {
		$this->stats[ $identifier ] = new Metric( $displayFormat );
	}

	public function increase( $identifier ) {
		$this->stats[ $identifier ]->increase();
	}

	public function set( $identifier, $value ) {
		$this->stats[ $identifier ]->set( $value );
	}

	public function display() {
		echo implode( '<br/>', $this->stats );
	}
}
