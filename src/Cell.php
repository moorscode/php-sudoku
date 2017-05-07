<?php

namespace Sudoku;

use Sudoku\Exceptions\InvalidMoveException;

class Cell {
	protected $number;
	protected $options = [];

	/**
	 * Cell constructor.
	 *
	 * @param array $options
	 */
	public function __construct( array $options = array() ) {
		$this->options = array_flip( $options );
	}

	/**
	 * @param $number
	 *
	 * @return $this
	 * @throws InvalidMoveException
	 */
	public function set( $number ) {
		$number = (int) $number;
		$number = ( $number === 0 ) ? null : $number;

		if ( $number && ! in_array( $number, $this->getOptions(), true ) ) {
			throw new InvalidMoveException();
		}

		$this->number = $number;
		if ( $this->number !== null ) {
			$this->options = [];
		}

		return $this;
	}

	/**
	 * @param $option
	 *
	 * @return $this
	 * @throws InvalidMoveException
	 */
	public function removeOption( $option ) {
		unset( $this->options[ $option ] );

		// If only one option remains, set it.
		if ( count( $this->options ) === 1 ) {
			$this->set( $this->getOptions()[0] );
		}

		if ( empty( $this->options ) && empty( $this->number ) ) {
			throw new InvalidMoveException();
		}

		return $this;
	}

	/**
	 * @return array
	 */
	public function getOptions() {
		return array_keys( $this->options );
	}

	/**
	 * @return int
	 */
	public function get() {
		return $this->number;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return ( null === $this->get() ? '&nbsp;' : (string) $this->get() );
	}
}
