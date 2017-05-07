<?php

namespace Sudoku;

class NullStatistics implements StatisticsInterface {
	public function register( $identifier, $displayFormat ) {
	}

	public function increase( $identifier ) {
	}

	public function set( $identifier, $value ) {
	}

	public function display() {
	}
}