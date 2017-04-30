<?php
/**
 * Created by PhpStorm.
 * User: jip
 * Date: 30/04/2017
 * Time: 15:23
 */

namespace Sudoku\Validators;

use Sudoku\Board;
use Sudoku\Collectors\ColumnCollector;
use Sudoku\Coords;

class ColumnsValidator implements ValidatorInterface {

	/**
	 * @param Board $board
	 *
	 * @return bool
	 */
	public function validate( Board $board ) {
		$collector = new ColumnCollector();
		$boardSize = $board->getSize();

		$expected = range( 1, $boardSize );

		$valid = true;
		foreach ( $expected as $column ) {
			$cells = $collector->collect( $board, new Coords( $column - 1, 0 ) );

			// valid if all numbers occur only once.
			$numbers = array_map( function ( $cell ) {
				return $cell->get();
			}, $cells );

			$numbers = array_unique( array_filter( $numbers ) );
			$valid = $valid && array_intersect( $expected, $numbers ) === $expected;
		}

		return $valid;
	}
}
