<?php

namespace Sudoku;

class BoardHasher {
	/**
	 * @param BoardInterface $board
	 *
	 * @return string
	 */
	public static function hash( BoardInterface $board ) {
		$cells = $board->getBoard();

		$hash = [];

		foreach ( $cells as $x => $_x ) {
			/** @var Cell $cell */
			foreach ( $_x as $y => $cell ) {
				$hash[] = [ $cell->get(), $cell->getOptions() ];
			}
		}

		return md5( serialize( $hash ) );
	}
}
