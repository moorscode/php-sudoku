<?php

namespace Sudoku\Algorithms;

use Sudoku\Board;
use Sudoku\Cell;
use Sudoku\Collectors\RowCollector;
use Sudoku\Coords;
use Sudoku\DeterminePairFromCollector;

class PairRowCandidates implements AlgorithmInterface {
	use DeterminePairFromCollector;

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Board $board, Coords $coords ) {
		return $this->findPairCandidates( new RowCollector(), $board, $coords );
	}
}
