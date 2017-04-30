<?php
/**
 * Created by PhpStorm.
 * User: jip
 * Date: 16/04/2017
 * Time: 14:12
 */

namespace Sudoku\Collectors;

use Sudoku\Board;
use Sudoku\Cell;
use Sudoku\Coords;

class GroupCollector implements CollectorInterface {
	/**
	 * GroupCollector constructor.
	 *
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Cell[]
	 */
	public function collect( Board $board, Coords $coords ) {
		return array_map( [ $board, 'get' ], $this->getCoords( $board, $coords ) );
	}

	/**
	 * @param Board  $board
	 * @param Coords $coords
	 *
	 * @return Coords[] Coords of the cells.
	 */
	public function getCoords( Board $board, Coords $coords ) {
		$boardSize = $board->getSize();

		$groups    = sqrt( $boardSize );
		$groupSize = $boardSize / $groups;

		$startX = floor( $coords->x() / $groupSize ) * $groupSize;
		$startY = floor( $coords->y() / $groupSize ) * $groupSize;

		$endX = $startX + $groupSize - 1;
		$endY = $startY + $groupSize - 1;

		$cells = [];
		foreach ( range( $startX, $endX ) as $x ) {
			foreach ( range( $startY, $endY ) as $y ) {
				$cells[] = new Coords( $x, $y );
			}
		}

		return $cells;
	}
}
