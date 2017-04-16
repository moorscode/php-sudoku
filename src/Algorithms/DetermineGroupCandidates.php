<?php

namespace Sudoku\Algorithms;

use Sudoku\ApplyCollector;
use Sudoku\Cell;
use Sudoku\Collectors\GroupCollector;
use Sudoku\Coords;

class DetermineGroupCandidates implements AlgorithmInterface {

	use AlgorithmBoard;
	use ApplyCollector;

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Coords $coords ) {
		return $this->applyCollector( new GroupCollector(), $this->board, $coords );
	}
}
