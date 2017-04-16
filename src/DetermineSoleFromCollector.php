<?php

namespace Sudoku;

use Sudoku\Collectors\CollectorInterface;

trait DetermineSoleFromCollector {
	protected function setSoleFromCollector( CollectorInterface $collector, Board $board, Coords $coords ) {
		$cell = $board->get( $coords );
		if ( null !== $cell->get() ) {
			return $cell;
		}

		$options = $cell->getOptions();

		if ( count( $options ) < 2 ) {
			return $cell;
		}

		// Determine the options of the other items in the row.
		$cells  = $collector->get( $board, $coords );

		foreach ( $cells as $rowCell ) {
			if ( $rowCell === $cell ) {
				continue;
			}
			$cellOptions = $rowCell->getOptions();
			$options      = array_diff( $options, $cellOptions );
		}

		if ( count( $options ) === 1 ) {
			$cell->set( $options[0] );
		}

		return $cell;
	}
}
