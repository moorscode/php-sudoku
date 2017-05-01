<?php

namespace Sudoku\Validators;

use PHPUnit\Framework\TestCase;
use Sudoku\Board;

class ValidatorTest extends TestCase {
	public function testValidateValidBoard() {
		$known = [
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
			[ 4, 5, 6, 7, 8, 9, 1, 2, 3 ],
			[ 7, 8, 9, 1, 2, 3, 4, 5, 6 ],
			[ 2, 3, 4, 5, 6, 7, 8, 9, 1 ],
			[ 5, 6, 7, 8, 9, 1, 2, 3, 4 ],
			[ 8, 9, 1, 2, 3, 4, 5, 6, 7 ],
			[ 3, 4, 5, 6, 7, 8, 9, 1, 2 ],
			[ 6, 7, 8, 9, 1, 2, 3, 4, 5 ],
			[ 9, 1, 2, 3, 4, 5, 6, 7, 8 ],
		];

		$board = new Board( $known );

		$validator = new Validator();
		$this->assertTrue( $validator->validate( $board ) );
	}
}
