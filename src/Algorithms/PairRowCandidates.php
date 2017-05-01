<?php

namespace Sudoku\Algorithms;

use Sudoku\BoardInterface;
use Sudoku\Cell;
use Sudoku\Collectors\RowCollector;
use Sudoku\Coords;
use Sudoku\DeterminePairFromCollector;

class PairRowCandidates implements AlgorithmInterface {
	use DeterminePairFromCollector;

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Cell
	 */
	public function run( BoardInterface $board, Coords $coords ) {
		return $this->findPairCandidates( new RowCollector(), $board, $coords );
	}
}
