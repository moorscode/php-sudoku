<?php

namespace Sudoku\Algorithms;

use Sudoku\Board;
use Sudoku\Cell;
use Sudoku\Collectors\GroupCollector;
use Sudoku\Coords;
use Sudoku\DeterminePairFromCollector;

class PairGroupCandidates implements AlgorithmInterface {

	use DeterminePairFromCollector;

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Board $board, Coords $coords ) {
		return $this->findPairCandidates( new GroupCollector(), $board, $coords );
	}
}
