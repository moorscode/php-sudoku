<?php

namespace Sudoku\Collectors;

use Sudoku\BoardInterface;
use Sudoku\Cell;
use Sudoku\Coords;

class RowCollector implements CollectorInterface {

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Cell[]
	 */
	public function collect( BoardInterface $board, Coords $coords ) {
		return array_map( [ $board, 'get' ], $this->getCoords( $board, $coords ) );
	}

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
