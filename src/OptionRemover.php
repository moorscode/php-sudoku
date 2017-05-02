<?php

namespace Sudoku;

trait OptionRemover {
	use FlattenCollection;

	/**
	 * @param       $group
	 * @param array $possibleOptions
	 */
	protected function removeOptions( $group, array $possibleOptions ) {
		$unavailable = array_intersect( $possibleOptions, $this->flatten( $group ) );
		foreach ( $group as $item ) {
			array_map( [ $item, 'removeOption' ], $unavailable );
		}
	}
}
