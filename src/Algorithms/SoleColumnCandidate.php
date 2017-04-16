<?php

namespace Sudoku\Algorithms;

use Sudoku\Cell;
use Sudoku\Collectors\ColumnCollector;
use Sudoku\Coords;
use Sudoku\DetermineSoleFromCollector;

class SoleColumnCandidate implements AlgorithmInterface {

	use AlgorithmBoard;
	use DetermineSoleFromCollector;

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Coords $coords ) {
		return $this->setSoleFromCollector( new ColumnCollector(), $this->board, $coords );
	}
}
