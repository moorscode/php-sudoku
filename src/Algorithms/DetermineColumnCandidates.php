<?php

namespace Sudoku\Algorithms;

use Sudoku\ApplyCollector;
use Sudoku\Cell;
use Sudoku\Collectors\ColumnCollector;
use Sudoku\Coords;

class DetermineColumnCandidates implements AlgorithmInterface {

	use AlgorithmBoard;
	use ApplyCollector;

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Coords $coords ) {
		return $this->applyCollector( new ColumnCollector(), $this->board, $coords );
	}
}
