<?php

namespace Sudoku;

trait FlattenCollection {
	/**
	 * @param Cell[] $cells
	 *
	 * @return array
	 */
	protected function flatten( array $cells ) {
		return array_map( function ( $cell ) {
			return $cell->get();
		}, $cells );
	}
}