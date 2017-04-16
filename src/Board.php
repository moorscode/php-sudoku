<?php

namespace Sudoku;

class Board {
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

	protected function initialize() {
		foreach ( range( 0, $this->boardSize - 1 ) as $x ) {
			foreach ( range( 0, $this->boardSize - 1 ) as $y ) {
				$this->board[ $x ][ $y ] = new Cell( range( 1, $this->boardSize ) );
			}
		}
	}

	/**
	 * @return Coords
	 */
	public function unfilled() {
		/**
		 * @var int   $x
		 * @var array $_x
		 */
		foreach ( $this->board as $x => $_x ) {
			/**
			 * @var int  $y
			 * @var Cell $cell
			 */
			foreach ( $this->board[ $x ] as $y => $cell ) {
				if ( null === $cell->get() ) {
					yield new Coords( $x, $y );
				}
			}
		}

		return null;
	}

	public function getSize() {
		return $this->boardSize;
	}

	/**
	 * @param array $coords
	 *
	 * @return Coords
	 */
	protected function getCoords( array $coords ) {
		return new Coords( $coords[0], $coords[1] );
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
}