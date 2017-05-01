<?php

namespace Sudoku\Validators;

use PHPUnit\Framework\TestCase;
use Sudoku\Board;

class GroupsValidatorTest extends TestCase {
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

		$validator = new GroupsValidator();
		$this->assertFalse( $validator->validate( $board ) );
	}

	public function testValidateInvalidGroups() {
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

		$validator = new GroupsValidator();
		$this->assertFalse( $validator->validate( $board ) );
	}

	public function testValidateValidGroups() {
		// Invalid board, but all valid groups.
		$known = [
			[ 1, 2, 3, 1, 2, 3, 1, 2, 3 ],
			[ 4, 5, 6, 4, 5, 6, 4, 5, 6 ],
			[ 7, 8, 9, 7, 8, 9, 7, 8, 9 ],
			[ 1, 2, 3, 1, 2, 3, 1, 2, 3 ],
			[ 4, 5, 6, 4, 5, 6, 4, 5, 6 ],
			[ 7, 8, 9, 7, 8, 9, 7, 8, 9 ],
			[ 1, 2, 3, 1, 2, 3, 1, 2, 3 ],
			[ 4, 5, 6, 4, 5, 6, 4, 5, 6 ],
			[ 7, 8, 9, 7, 8, 9, 7, 8, 9 ],
		];

		$board = new Board( $known );

		$validator = new GroupsValidator();
		$this->assertTrue( $validator->validate( $board ) );
	}
}
