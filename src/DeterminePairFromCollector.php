<?php

namespace Sudoku;

use Sudoku\Collectors\CollectorInterface;

trait DeterminePairFromCollector {
	protected function findPairCandidates( CollectorInterface $collector, Board $board, Coords $coords ) {
		$cell = $board->get( $coords );
		if ( null !== $cell->get() ) {
			return $cell;
		}

		// Determine the options of the other items in the row.
		$cells = $collector->get( $board, $coords );
		$this->removePairCandidates( $cell, $cells );

		return $cell;
	}

	/**
	 * @param Cell  $cell
	 * @param array $cells
	 */
	protected function removePairCandidates( Cell $cell, array $cells ) {
		$options = $cell->getOptions();
		if ( count( $options ) !== 2 ) {
			return $cell;
		}

		// Find paired cells; with two matching options.
		// Remove the options from the other cells in the group.
		$remove = [];

		/** @var Cell $test */
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
			/** @var Cell $groupCell */
			foreach ( $cells as $groupCell ) {
				array_map( [ $groupCell, 'removeOption' ], $remove );
			}
		}

		return $cells;
	}
}
