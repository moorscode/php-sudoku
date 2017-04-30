<?php

namespace Sudoku\Algorithms;

use Sudoku\Board;
use Sudoku\Cell;
use Sudoku\Coords;

class SoleCandidate implements AlgorithmInterface {

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Board $board, Coords $coords ) {
		$cell = $board->get( $coords );
		if ( null !== $cell->get() ) {
			return $cell;
		}

		$options = $cell->getOptions();

		if ( count( $options ) === 1 ) {
			$cell->set( $options[0] );
		}

		return $cell;
	}
}
