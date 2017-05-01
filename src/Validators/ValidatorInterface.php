<?php

namespace Sudoku\Validators;

use Sudoku\BoardInterface;

interface ValidatorInterface {
	public function validate( BoardInterface $board );
}
