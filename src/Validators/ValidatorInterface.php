<?php

namespace Sudoku\Validators;

use Sudoku\Board;

interface ValidatorInterface {
	public function validate( Board $board );
}
