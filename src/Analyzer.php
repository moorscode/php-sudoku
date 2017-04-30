<?php

namespace Sudoku;

use Sudoku\Collectors\ColumnCollector;
use Sudoku\Collectors\RowCollector;

class Analyzer {
	use FlattenCollection;

	public function analyze( Board $board ) {
		$boardSize = $board->getSize();
//		$boardTiles = $board->getBoard();

		$rowCollector    = new RowCollector();
		$columnCollector = new ColumnCollector();

		$filled = new \StdClass();

		foreach ( range( 1, $boardSize ) as $step ) {
			$row = array_filter( $this->flatten( $rowCollector->collect( $board, new Coords( $step - 1, 0 ) ) ) );
			$filled->rows[] = count($row);

			$column = array_filter( $this->flatten( $columnCollector->collect( $board, new Coords( 0, $step - 1 ) ) ) );
			$filled->columns[] = count($column);
		}

		echo array_sum($filled->rows) / count($filled->rows);
		echo array_sum($filled->columns) / count($filled->columns);

		exit;
	}
}
