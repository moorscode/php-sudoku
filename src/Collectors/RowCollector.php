<?php

namespace Sudoku\Collectors;

use Sudoku\BoardInterface;
use Sudoku\Coords;

class RowCollector implements CollectorInterface {
	use Collect;

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Coords[] Coords of the cells.
	 */
	public function getCoords( BoardInterface $board, Coords $coords ) {
		$boardSize = $board->getSize();

		// Row = Y
		$cells = [];

		foreach ( range( 1, $boardSize ) as $y ) {
			$cells[] = new Coords( $coords->x(), $y - 1 );
		}

		return $cells;
	}
}
