<?php

namespace Sudoku\Algorithms;

use Sudoku\Board;
use Sudoku\Cell;
use Sudoku\Collectors\ColumnCollector;
use Sudoku\Coords;
use Sudoku\DetermineSoleFromCollector;

class SoleColumnCandidate implements AlgorithmInterface {

	use DetermineSoleFromCollector;

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Board $board, Coords $coords ) {
		return $this->setSoleFromCollector( new ColumnCollector(), $board, $coords );
	}
}
