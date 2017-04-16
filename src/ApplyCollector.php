<?php

namespace Sudoku;

use Sudoku\Collectors\CollectorInterface;

trait ApplyCollector {
	use FlattenCollection;

	/**
	 * @param CollectorInterface $collector
	 * @param Board              $board
	 * @param Coords             $coords
	 *
	 * @return Cell
	 */
	protected function applyCollector( CollectorInterface $collector, Board $board, Coords $coords ) {
		$cell = $board->get( $coords );
		if ( null !== $cell->get() ) {
			return $cell;
		}

		// Determine options.
		$group = $collector->get( $board, $coords );

		$available = array_intersect( $this->getOptions(), $this->flatten( $group ) );
		array_map( [ $cell, 'removeOption' ], $available );

		return $cell;
	}
}