<?php

namespace Sudoku\Algorithms;

use Sudoku\Cell;
use Sudoku\Collectors\RowCollector;
use Sudoku\Coords;
use Sudoku\DetermineSoleFromCollector;

class SoleRowCandidate implements AlgorithmInterface {

	use AlgorithmBoard;
	use DetermineSoleFromCollector;

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Coords $coords ) {
		return $this->setSoleFromCollector( new RowCollector(), $this->board, $coords );
	}
}
