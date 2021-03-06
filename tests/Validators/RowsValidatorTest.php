<?php

namespace Sudoku\Validators;

use PHPUnit\Framework\TestCase;
use Sudoku\Board;

class RowsValidatorTest extends TestCase {
	public function testValidateEmptyBoard() {
		$board = new Board( [
			[ 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
			[ 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
			[ 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
			[ 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
			[ 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
			[ 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
			[ 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
			[ 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
			[ 0, 0, 0, 0, 0, 0, 0, 0, 0 ],
		] );

		$validator = new RowsValidator();
		$this->assertFalse( $validator->validate( $board ) );
	}

	public function testValidateInvalidRows() {
		$known = [
			[ 1, 1, 1, 1, 1, 1, 1, 1, 1 ],
			[ 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
			[ 3, 3, 3, 3, 3, 3, 3, 3, 3 ],
			[ 4, 4, 4, 4, 4, 4, 4, 4, 4 ],
			[ 5, 5, 5, 5, 5, 5, 5, 5, 5 ],
			[ 6, 6, 6, 6, 6, 6, 6, 6, 6 ],
			[ 7, 7, 7, 7, 7, 7, 7, 7, 7 ],
			[ 8, 8, 8, 8, 8, 8, 8, 8, 8 ],
			[ 1, 1, 1, 1, 1, 1, 1, 1, 1 ],

		];

		$board = new Board( $known );

		$validator = new RowsValidator();
		$this->assertFalse( $validator->validate( $board ) );
	}

	public function testValidateValidRows() {
		$known = [
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
			[ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
		];

		$board = new Board( $known );

		$validator = new RowsValidator();
		$this->assertTrue( $validator->validate( $board ) );
	}
}
