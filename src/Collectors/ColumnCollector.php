<?php

namespace Sudoku\Collectors;

use Sudoku\Board;
use Sudoku\Cell;
use Sudoku\Coords;

class ColumnCollector implements CollectorInterface {

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell[]
	 */
	public function get( Board $board, Coords $coords ) {
		$boardSize = $board->getSize();

		// Column = X
		$cells = [];

		foreach ( range( 0, $boardSize - 1 ) as $x ) {
			$cells[] = $board->get( new Coords( $x, $coords->y() ) );
		}

		return $cells;
	}
}