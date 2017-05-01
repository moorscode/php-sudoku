<?php
/**
 * Created by PhpStorm.
 * User: jip
 * Date: 30/04/2017
 * Time: 14:49
 */

namespace Sudoku\Validators;

use Sudoku\BoardInterface;
use Sudoku\Collectors\RowCollector;
use Sudoku\Coords;

class RowsValidator implements ValidatorInterface {
	public function validate( BoardInterface $board ) {
		$collector = new RowCollector();
		$boardSize = $board->getSize();

		$expected = range( 1, $boardSize );

		$valid = true;
		foreach ( $expected as $row ) {
			$cells = $collector->collect( $board, new Coords( 0, $row - 1 ) );

			// valid if all numbers occur only once.
			$numbers = array_map( function ( $cell ) {
				return $cell->get();
			}, $cells );

			$numbers = array_unique( array_filter( $numbers ) );
			$valid   = $valid && array_intersect( $expected, $numbers ) === $expected;
		}

		return $valid;
	}
}
