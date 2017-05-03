<?php

namespace Sudoku;

class BoardHistory implements BoardInterface, BoardHistoryInterface {
	protected $board;
	protected $history = [];
	protected $historyIndex = 0;
	protected $boardLayout;

	/**
	 * BoardHistory constructor.
	 *
	 * @param BoardInterface $board
	 */
	public function __construct( BoardInterface $board ) {
		$this->board = $board;
	}

	public function __clone() {
		$this->board = clone $this->board;
	}

	public function done() {
		return $this->board->done();
	}

	public function getSize() {
		return $this->board->getSize();
	}

	public function set( Coords $coords, Cell $cell ) {
		$this->board->set( $coords, $cell );

		if ( $cell->get() ) {
			$this->addHistory( $coords, $cell );
		}
	}

	public function get( Coords $coords ) {
		return $this->board->get( $coords );
	}

	public function getBoard() {
		if ( $this->boardLayout ) {
			return $this->boardLayout;
		}

		return $this->board->getBoard();
	}

	/**
	 * @return array
	 */
	public function cellOptions() {
		return $this->board->cellOptions();
	}

	public function getHistorySteps() {
		return count( $this->history );
	}

	public function rewind() {
		$this->boardLayout = $this->board->getBoard();
		foreach ( $this->history as $step ) {
			$this->boardLayout[ $step->coords->y() ][ $step->coords->x() ] = new Cell();
		}
		$this->historyIndex = -1;
	}

	public function historyStep() {
		if ( ! isset( $this->history[ $this->historyIndex + 1] ) ) {
			return false;
		}

		$step = $this->history[ ++$this->historyIndex ];

		$this->boardLayout[ $step->coords->y() ][ $step->coords->x() ] = $step->cell;

		return true;
	}

	public function lastCell() {
		return $this->history[ $this->historyIndex ];
	}

	protected function addHistory( Coords $coords, Cell $cell ) {
		$this->history[] = (object) [ 'coords' => $coords, 'cell' => $cell ];
	}
}