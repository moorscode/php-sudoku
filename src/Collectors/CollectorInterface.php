<?php

namespace Sudoku\Collectors;

use Sudoku\Board;
use Sudoku\Cell;
use Sudoku\Coords;

interface CollectorInterface {
	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell[] Cells
	 */
	public function collect( Board $board, Coords $coords );

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Coords[] Coords of the cells.
	 */
	public function getCoords( Board $board, Coords $coords );
}
