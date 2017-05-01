<?php
/**
 * Created by PhpStorm.
 * User: jip
 * Date: 30/04/2017
 * Time: 15:25
 */

namespace Sudoku\Validators;

use Sudoku\BoardInterface;
use Sudoku\Collectors\GroupCollector;
use Sudoku\Coords;

class GroupsValidator implements ValidatorInterface {

	/**
	 * @param BoardInterface $board
	 *
	 * @return bool
	 */
	public function validate( BoardInterface $board ) {
		$collector = new GroupCollector();
		$boardSize = $board->getSize();

		$groups = sqrt( $boardSize );

		$expected = range( 1, $boardSize );

		$valid = true;
		foreach ( range( 1, $boardSize, $groups ) as $column ) {
			foreach ( range( 1, $boardSize, $groups ) as $row ) {
				$cells = $collector->collect( $board, new Coords( $column - 1, $row - 1 ) );

				// valid if all numbers occur only once.
				$numbers = array_map( function ( $cell ) {
					return $cell->get();
				}, $cells );

				$numbers = array_unique( array_filter( $numbers ) );
				$valid   = $valid && array_intersect( $expected, $numbers ) === $expected;
			}
		}

		return $valid;
	}
}
