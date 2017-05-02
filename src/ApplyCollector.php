<?php

namespace Sudoku;

use Sudoku\Collectors\CollectorInterface;

trait ApplyCollector {
	use OptionRemover;

	/**
	 * @param CollectorInterface $collector
	 * @param BoardInterface     $board
	 * @param Coords             $coords
	 *
	 * @return Cell
	 */
	protected function applyCollector( CollectorInterface $collector, BoardInterface $board, Coords $coords ) {
		$cell = $board->get( $coords );

		// Determine options.
		$this->removeOptions( $collector->collect( $board, $coords ), $board->cellOptions() );

		return $cell;
	}
}
