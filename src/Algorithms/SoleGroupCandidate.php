<?php

namespace Sudoku\Algorithms;

use Sudoku\BoardInterface;
use Sudoku\Cell;
use Sudoku\Collectors\GroupCollector;
use Sudoku\Coords;
use Sudoku\DetermineSoleFromCollector;

class SoleGroupCandidate implements AlgorithmInterface {

	use DetermineSoleFromCollector;

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Cell
	 */
	public function run( BoardInterface $board, Coords $coords ) {
		return $this->setSoleFromCollector( new GroupCollector(), $board, $coords );
	}
}
