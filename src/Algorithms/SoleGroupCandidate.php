<?php

namespace Sudoku\Algorithms;

use Sudoku\Cell;
use Sudoku\Collectors\GroupCollector;
use Sudoku\Coords;
use Sudoku\DetermineSoleFromCollector;

class SoleGroupCandidate implements AlgorithmInterface {

	use AlgorithmBoard;
	use DetermineSoleFromCollector;

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Coords $coords ) {
		return $this->setSoleFromCollector( new GroupCollector(), $this->board, $coords );
	}
}
