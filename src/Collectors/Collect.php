<?php

namespace Sudoku\Collectors;

use Sudoku\BoardInterface;
use Sudoku\Cell;
use Sudoku\Coords;

trait Collect {
	/**
	 * Collect method
	 *
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Cell[]
	 */
	public function collect( BoardInterface $board, Coords $coords ) {
		return array_map( [ $board, 'get' ], $this->getCoords( $board, $coords ) );
	}
}
