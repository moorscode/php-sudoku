<?php

namespace Sudoku\Algorithms;

use Sudoku\ApplyCollector;
use Sudoku\Board;
use Sudoku\Cell;
use Sudoku\Collectors\GroupCollector;
use Sudoku\Coords;

class DetermineGroupCandidates implements AlgorithmInterface {

	use ApplyCollector;

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Board $board, Coords $coords ) {
		return $this->applyCollector( new GroupCollector(), $board, $coords );
	}
}
