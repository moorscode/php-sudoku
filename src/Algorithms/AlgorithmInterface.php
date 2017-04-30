<?php

namespace Sudoku\Algorithms;

use Sudoku\Board;
use Sudoku\Coords;
use Sudoku\Cell;

interface AlgorithmInterface {
	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Board $board, Coords $coords );
}
