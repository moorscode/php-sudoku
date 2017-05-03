<?php

namespace Sudoku;

interface BoardHistoryInterface {
	/**
	 * @return array
	 */
	public function getHistorySteps();

	/**
	 * @return void
	 */
	public function rewind();

	/**
	 * @return bool
	 */
	public function historyStep();

	/**
	 * @return Cell
	 */
	public function lastCell();
}
