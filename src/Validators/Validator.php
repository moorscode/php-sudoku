<?php

namespace Sudoku\Validators;

use Sudoku\BoardInterface;

class Validator implements ValidatorInterface {
	/**
	 * @param BoardInterface $board
	 *
	 * @return bool
	 */
	public function validate( BoardInterface $board ) {
		if ( ! $board->done() ) {
			return false;
		}

		$validators = [
			new RowsValidator(),
			new ColumnsValidator(),
			new GroupsValidator()
		];

		$valid = true;
		foreach ( $validators as $validator ) {
			$valid = $valid && $validator->validate( $board );
		}

		return $valid;
	}
}
