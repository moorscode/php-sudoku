<?php

namespace Sudoku\Algorithms;

use Sudoku\BoardInterface;
use Sudoku\Cell;
use Sudoku\Coords;

class SoleCandidate implements AlgorithmInterface {

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 *
	 * @return Cell
	 */
	public function run( BoardInterface $board, Coords $coords ) {
		$cell    = $board->get( $coords );
		$options = $cell->getOptions();

		if ( count( $options ) === 1 ) {
			$cell->set( $options[0] );
		}

		return $cell;
	}
}
