<?php
/**
 * Created by PhpStorm.
 * User: jip
 * Date: 01/05/2017
 * Time: 15:14
 */

namespace Sudoku;

class Result {

	/**
	 * Result constructor.
	 *
	 * @param BoardInterface $board
	 */
	public function __construct( BoardInterface $board ) {
		$this->startingBoard = $board;
	}

	/**
	 * @return BoardInterface|null
	 */
	public function load() {
		if ( ! is_file( $this->getFilename() ) ) {
			return null;
		}

		return unserialize( file_get_contents( $this->getFilename() ) );
	}

	/**
	 * @param BoardInterface $finalBoard
	 *
	 * @return bool|int
	 */
	public function save( BoardInterface $finalBoard ) {
		return file_put_contents( $this->getFilename(), serialize( $finalBoard ) );
	}

	/**
	 * @return string
	 */
	protected function getFilename() {
		return SUDOKU_ROOT . DIRECTORY_SEPARATOR . 'results' . DIRECTORY_SEPARATOR . BoardHasher::hash( $this->startingBoard ) . '.object';
	}
}
