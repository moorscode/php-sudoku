<?php

namespace Sudoku;

class Board {
	use FlattenCollection;

	protected $boardSize = 9;
	protected $board = [ [] ];

	/**
	 * Board constructor.
	 *
	 * @param int   $boardSize
	 * @param array $known
	 */
	public function __construct( $boardSize, array $known = array() ) {
		$this->boardSize = $boardSize;

		$this->initialize();

		if ( $known ) {
			foreach ( $known as $y => $row ) {
				foreach ( $row as $x => $number ) {
					$coord = new Coords( $x, $y );
					$cell  = $this->get( $coord );
					$cell->set( $number );
					$this->set( $coord, $cell );
				}
			}
		}
	}

	/**
	 * @return bool
	 */
	public function done() {
		$cells = [];
		foreach ( $this->board as $x => $_x ) {
			foreach ( $_x as $y => $cell ) {
				$cells[] = $cell;
			}
		}

		return count( array_filter( $this->flatten( $cells ) ) ) === ( $this->boardSize * $this->boardSize );
	}

	/**
	 *
	 */
	protected function initialize() {
		foreach ( range( 0, $this->boardSize - 1 ) as $x ) {
			foreach ( range( 0, $this->boardSize - 1 ) as $y ) {
				$this->board[ $x ][ $y ] = new Cell( range( 1, $this->boardSize ) );
			}
		}
	}

	/**
	 * @return int
	 */
	public function getSize() {
		return $this->boardSize;
	}

	/**
	 * @param Coords $coords
	 * @param Cell   $cell
	 */
	public function set( Coords $coords, Cell $cell ) {
		$this->board[ $coords->x() ][ $coords->y() ] = $cell;
	}

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function get( Coords $coords ) {
		return $this->board[ $coords->x() ][ $coords->y() ];
	}

	/**
	 * @return array
	 */
	public function getBoard() {
		return $this->board;
	}

	/**
	 *
	 */
	public function __clone() {
		$this->board = unserialize( serialize( $this->board ) );
	}
}