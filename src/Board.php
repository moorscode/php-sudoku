<?php

namespace Sudoku;

class Board implements BoardInterface {
	use FlattenCollection;

	protected $boardSize;
	protected $board = [ [] ];

	/**
	 * Board constructor.
	 *
	 * @param array $known
	 */
	public function __construct( array $known ) {
		$this->boardSize = count( $known[0] );

		$this->initialize();

		if ( $known ) {
			foreach ( $known as $x => $row ) {
				foreach ( $row as $y => $number ) {
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
				$this->set( new Coords( $x, $y ), new Cell( $this->cellOptions() ) );
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
		$this->board[ $coords->y() ][ $coords->x() ] = $cell;
	}

	/**
	 * @param Coords $coords
	 *
	 * @return Cell
	 */
	public function get( Coords $coords ) {
		return $this->board[ $coords->y() ][ $coords->x() ];
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

	/**
	 * @return array
	 */
	public function cellOptions() {
		return range( 1, $this->boardSize );
	}
}