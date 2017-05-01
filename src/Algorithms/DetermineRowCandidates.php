<?php

namespace Sudoku\Algorithms;

use Sudoku\ApplyCollector;
use Sudoku\BoardInterface;
use Sudoku\Cell;
use Sudoku\Collectors\RowCollector;
use Sudoku\Coords;

class DetermineRowCandidates implements AlgorithmInterface {

	use ApplyCollector;

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Cell
	 */
	public function run( BoardInterface $board, Coords $coords ) {
		return $this->applyCollector( new RowCollector(), $board, $coords );
	}
}
