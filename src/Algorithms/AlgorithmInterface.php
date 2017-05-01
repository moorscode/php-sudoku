<?php

namespace Sudoku\Algorithms;

use Sudoku\BoardInterface;
use Sudoku\Coords;
use Sudoku\Cell;

interface AlgorithmInterface {
	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Cell
	 */
	public function run( BoardInterface $board, Coords $coords );
}
