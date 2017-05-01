<?php

namespace Sudoku;

use Sudoku\Collectors\CollectorInterface;

trait DeterminePairFromCollector {
	/**
	 * @param CollectorInterface $collector
	 * @param BoardInterface     $board
	 * @param Coords             $coords
	 *
	 * @return Cell
	 */
	protected function findPairCandidates( CollectorInterface $collector, BoardInterface $board, Coords $coords ) {
		$cell = $board->get( $coords );
		if ( null !== $cell->get() ) {
			return $cell;
		}

		// Determine the options of the other items in the row.
		$cells = $collector->collect( $board, $coords );
		$this->removePairCandidates( $cell, $cells );

		return $cell;
	}

	/**
	 * @param Cell   $cell
	 * @param Cell[] $cells
	 */
	protected function removePairCandidates( Cell $cell, array $cells ) {
		$options = $cell->getOptions();
		if ( count( $options ) !== 2 ) {
			return;
		}

		// Find paired cells; with two matching options.
		// Remove the options from the other cells in the group.
		$remove = [];

		foreach ( $cells as $index => $test ) {
			if ( $cell === $test ) {
				unset( $cells[ $index ] );
				continue;
			}

			$testOptions = $test->getOptions();
			if ( count( $testOptions ) === 2 && array_diff( $options, $testOptions ) === [] ) {
				$remove = $options;
				unset( $cells[ $index ] );
				continue;
			}
		}

		if ( [] !== $remove ) {
			foreach ( $cells as $_cell ) {
				array_map( [ $_cell, 'removeOption' ], $remove );
			}
		}
	}
}
