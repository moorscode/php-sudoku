<?php

namespace Sudoku\Collectors;

use Sudoku\BoardInterface;
use Sudoku\Coords;

class ColumnCollector implements CollectorInterface {
	use Collect;

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Coords[] Coords of the cells.
	 */
	public function getCoords( BoardInterface $board, Coords $coords ) {
		$boardSize = $board->getSize();

		$cells = [];
		foreach ( range( 1, $boardSize ) as $x ) {
			$cells[] = new Coords( $x - 1, $coords->y() );
		}

		return $cells;
	}
}