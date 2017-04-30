<?php

namespace Sudoku;

class Variations {
	/**
	 * @param Board $board
	 *
	 * @return \Generator
	 */
	public function variation( Board $board ) {
		$boardSize = $board->getSize();

		// Start with lowest number of options left.
		foreach ( range( 2, 9 ) as $optionCount ) {
			foreach ( range( 0, $boardSize - 1 ) as $x ) {
				foreach ( range( 0, $boardSize - 1 ) as $y ) {
					$coords = new Coords( $x, $y );

					$options = $board->get( $coords )->getOptions();
					if ( count( $options ) !== $optionCount ) {
						continue;
					}

					foreach ( $options as $option ) {
						$variation = clone $board;

						$cell = $variation->get( $coords )->set( $option );
						$variation->set( $coords, $cell );

						yield $variation;
					}
				}
			}
		}
	}
}
