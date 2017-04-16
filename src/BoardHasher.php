<?php

namespace Sudoku;

class BoardHasher {
	public static function hash( Board $board ) {
		$cells = $board->getBoard();

		$hash = [];
		foreach ( $cells as $x => $_x ) {
			foreach ( $_x as $y => $cell ) {
				$hash[] = [ $cell->get(), $cell->getOptions() ];
			}
		}

		return md5( serialize( $hash ) );
	}
}