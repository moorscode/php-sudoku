<?php

namespace Sudoku\Collectors;

use Sudoku\BoardInterface;
use Sudoku\Cell;
use Sudoku\Coords;

interface CollectorInterface {
	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Cell[] Cells
	 */
	public function collect( BoardInterface $board, Coords $coords );

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Coords[] Coords of the cells.
	 */
	public function getCoords( BoardInterface $board, Coords $coords );
}
