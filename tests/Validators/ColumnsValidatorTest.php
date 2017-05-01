<?php

namespace Sudoku\Validators;

use PHPUnit\Framework\TestCase;
use Sudoku\Board;

class ColumnsValidatorTest extends TestCase {
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

		$validator = new ColumnsValidator();
		$this->assertFalse( $validator->validate( $board ) );
	}

	public function testValidateInvalidColumns() {
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

		$validator = new ColumnsValidator();
		$this->assertFalse( $validator->validate( $board ) );
	}

	public function testValidateValidColumns() {
		$known = [
			[ 1, 1, 1, 1, 1, 1, 1, 1, 1 ],
			[ 2, 2, 2, 2, 2, 2, 2, 2, 2 ],
			[ 3, 3, 3, 3, 3, 3, 3, 3, 3 ],
			[ 4, 4, 4, 4, 4, 4, 4, 4, 4 ],
			[ 5, 5, 5, 5, 5, 5, 5, 5, 5 ],
			[ 6, 6, 6, 6, 6, 6, 6, 6, 6 ],
			[ 7, 7, 7, 7, 7, 7, 7, 7, 7 ],
			[ 8, 8, 8, 8, 8, 8, 8, 8, 8 ],
			[ 9, 9, 9, 9, 9, 9, 9, 9, 9 ],
		];

		$board = new Board( $known );

		$validator = new ColumnsValidator();
		$this->assertTrue( $validator->validate( $board ) );
	}
}
