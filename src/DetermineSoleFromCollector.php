<?php

namespace Sudoku;

use Sudoku\Collectors\CollectorInterface;

trait DetermineSoleFromCollector {
	/**
	 * @param CollectorInterface $collector
	 * @param BoardInterface     $board
	 * @param Coords             $coords
	 *
	 * @return Cell
	 */
	protected function setSoleFromCollector( CollectorInterface $collector, BoardInterface $board, Coords $coords ) {
		$cell    = $board->get( $coords );
		$options = $cell->getOptions();

		if ( count( $options ) < 2 ) {
			return $cell;
		}

		// Determine the options of the other items in the row.
		$cells = $collector->collect( $board, $coords );

		foreach ( $cells as $_cell ) {
			if ( $_cell === $cell ) {
				continue;
			}

			$options = array_diff( $options, $_cell->getOptions() );
		}

		if ( count( $options ) === 1 ) {
			$cell->set( current( $options ) );
		}

		return $cell;
	}
}
