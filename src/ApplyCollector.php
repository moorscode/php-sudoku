<?php

namespace Sudoku;

use Sudoku\Collectors\CollectorInterface;

trait ApplyCollector {
	use FlattenCollection;

	/**
	 * @param CollectorInterface $collector
	 * @param BoardInterface     $board
	 * @param Coords             $coords
	 *
	 * @return Cell
	 */
	protected function applyCollector( CollectorInterface $collector, BoardInterface $board, Coords $coords ) {
		$cell = $board->get( $coords );
		if ( $cell->get() ) {
			return $cell;
		}

		// Determine options.
		$group = $collector->collect( $board, $coords );

		$available = array_intersect( range( 1, $board->getSize() ), $this->flatten( $group ) );
		array_map( [ $cell, 'removeOption' ], $available );

		return $cell;
	}
}