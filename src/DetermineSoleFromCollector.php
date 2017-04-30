<?php

namespace Sudoku;

use Sudoku\Collectors\CollectorInterface;

trait DetermineSoleFromCollector {
	/**
	 * @param CollectorInterface $collector
	 * @param Board              $board
	 * @param Coords             $coords
	 *
	 * @return Cell
	 */
	protected function setSoleFromCollector( CollectorInterface $collector, Board $board, Coords $coords ) {
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

			$cellOptions = $_cell->getOptions();
			$options     = array_diff( $options, $cellOptions );
		}

		if ( count( $options ) === 1 ) {
			$cell->set( current( $options ) );
		}

		return $cell;
	}
}
