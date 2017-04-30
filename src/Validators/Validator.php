<?php

namespace Sudoku\Validators;

use Sudoku\Board;

class Validator implements ValidatorInterface {
	public function validate( Board $board ) {
		$validators = [
			new RowsValidator(),
			new ColumnsValidator(),
			new GroupsValidator()
		];

		$valid = true;
		foreach( $validators as $validator ) {
			$valid = $valid && $validator->validate( $board );
		}

		return $valid;
	}
}
