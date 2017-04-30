<?php

namespace Sudoku;

class BoardVariations {
	/**
	 * BoardVariation constructor.
	 *
	 * @param Board $board
	 */
	public function __construct( Board $board ) {
		$this->board = $board;
	}

	/**
	 *
	 * @return \Generator
	 */
	public function next() {
		$boardSize = $this->board->getSize();

		// Start with lowest number of options left.
		foreach ( range( 2, 9 ) as $optionCount ) {
			foreach ( range( 0, $boardSize - 1 ) as $x ) {
				foreach ( range( 0, $boardSize - 1 ) as $y ) {
					$coords = new Coords( $x, $y );

					$options = $this->board->get( $coords )->getOptions();
					if ( count( $options ) !== $optionCount ) {
						continue;
					}

					foreach ( $options as $option ) {
						$variation = clone $this->board;

						$cell = $variation->get( $coords )->set( $option );
						$variation->set( $coords, $cell );

						yield $variation;
					}
				}
			}
		}
	}
}