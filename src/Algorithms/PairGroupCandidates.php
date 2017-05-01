<?php

namespace Sudoku\Algorithms;

use Sudoku\BoardInterface;
use Sudoku\Cell;
use Sudoku\Collectors\GroupCollector;
use Sudoku\Coords;
use Sudoku\DeterminePairFromCollector;

class PairGroupCandidates implements AlgorithmInterface {
	use DeterminePairFromCollector;

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Cell
	 */
	public function run( BoardInterface $board, Coords $coords ) {
		return $this->findPairCandidates( new GroupCollector(), $board, $coords );
	}
}
