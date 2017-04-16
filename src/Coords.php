<?php

namespace Sudoku;

class Coords {
	protected $x;
	protected $y;

	public function __construct( $x, $y ) {
		$this->x = $x;
		$this->y = $y;
	}

	public function x() {
		return $this->x;
	}

	public function y() {
		return $this->y;
	}
}
