<?php

namespace Sudoku\Algorithms;

use Sudoku\Cell;
use Sudoku\Coords;

class SoleCandidate implements AlgorithmInterface {

	use AlgorithmBoard;

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function run( Coords $coords ) {
		$cell = $this->board->get( $coords );
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
