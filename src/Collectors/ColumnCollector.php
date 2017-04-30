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
	public function collect( Board $board, Coords $coords ) {
		return array_map( [ $board, 'get' ], $this->getCoords( $board, $coords ) );
	}

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Coords[] Coords of the cells.
	 */
	public function getCoords( Board $board, Coords $coords ) {
		$boardSize = $board->getSize();

		$cells = [];
		foreach ( range( 1, $boardSize ) as $x ) {
			$cells[] = new Coords( $x - 1, $coords->y() );
		}

		return $cells;
	}
}