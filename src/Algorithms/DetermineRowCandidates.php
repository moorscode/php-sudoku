<?php

namespace Sudoku\Algorithms;

use Sudoku\ApplyCollector;
use Sudoku\Cell;
use Sudoku\Collectors\RowCollector;
use Sudoku\Coords;

class DetermineRowCandidates implements AlgorithmInterface {

	use AlgorithmBoard;
	use ApplyCollector;

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Coords $coords ) {
		return $this->applyCollector( new RowCollector(), $this->board, $coords );
	}
}
