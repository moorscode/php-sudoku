<?php

namespace Sudoku\Collectors;

use Sudoku\Board;
use Sudoku\Cell;
use Sudoku\Coords;

class RowCollector implements CollectorInterface {

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell[]
	 */
	public function get( Board $board, Coords $coords ) {
		$boardSize = $board->getSize();

		// Row = Y
		$cells = [];

		foreach ( range( 0, $boardSize - 1 ) as $y ) {
			$cells[] = $board->get( new Coords( $coords->x(), $y ) );
		}

		return $cells;
	}
}