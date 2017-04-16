<?php

namespace Sudoku\Algorithms;

use Sudoku\Board;
use Sudoku\Coords;
use Sudoku\Cell;

interface AlgorithmInterface {
	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Coords $coords );

	/**
	 * @param Board $board
	 *
	 * @return void
	 */
	public function setBoard( Board $board );
}
