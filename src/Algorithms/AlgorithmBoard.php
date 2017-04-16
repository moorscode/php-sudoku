<?php

namespace Sudoku\Algorithms;

use Sudoku\Board;

trait AlgorithmBoard {
	/** @var Board */
	protected $board;

	/**
	 * @param Board $board
	 *
	 * @return void
	 */
	public function setBoard( Board $board ) {
		$this->board = $board;
	}

	protected function getOptions() {
		return range( 1, $this->board->getSize() );
	}
}