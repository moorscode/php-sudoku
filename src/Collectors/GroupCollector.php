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
	public function get( Board $board, Coords $coords ) {
		$boardSize = $board->getSize();
		$groups    = sqrt( $boardSize );

		$groupSize = $boardSize / $groups;

		$startX = floor( $coords->x() / $groupSize ) * $groupSize;
		$startY = floor( $coords->y() / $groupSize ) * $groupSize;

		$endX = $startX + $groupSize;
		$endY = $startY + $groupSize;

		$cells = [];
		foreach ( range( $startX, $endX - 1 ) as $x ) {
			foreach ( range( $startY, $endY - 1 ) as $y ) {
				$cells[] = $board->get( new Coords( $x, $y ) );
			}
		}

		return $cells;
	}
}