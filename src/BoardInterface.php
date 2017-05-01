<?php

namespace Sudoku;

interface BoardInterface {
	/**
	 * @return bool
	 */
	public function done();

	/**
	 * @return int
	 */
	public function getSize();

	/**
	 * @param Coords $coords
	 * @param Cell   $cell
	 */
	public function set( Coords $coords, Cell $cell );

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function get( Coords $coords );

	/**
	 * @return array
	 */
	public function getBoard();
}
