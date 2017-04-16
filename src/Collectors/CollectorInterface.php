<?php

namespace Sudoku\Collectors;

use Sudoku\Board;
use Sudoku\Coords;

interface CollectorInterface {
	public function get( Board $board, Coords $coords );
}
