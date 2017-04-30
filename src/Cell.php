<?php

namespace Sudoku;

class Cell {
	protected $number;
	protected $options = [];

	public function __construct( array $options = array() ) {
		$this->options = array_flip( $options );
	}

	public function set( $number ) {
		$number       = ( $number === 0 ) ? null : $number;
		$this->number = $number;

		if ( $this->number !== null ) {
			$this->options = [];
		}

		return $this;
	}

	public function addOption( $option ) {
		$this->options[ $option ] = true;

		return $this;
	}

	public function removeOption( $option ) {
		unset( $this->options[ $option ] );

		return $this;
	}

	public function getOptions() {
		return array_keys( $this->options );
	}

	public function get() {
		return $this->number;
	}

	public function __toString() {
		return ( null === $this->get() ? '' : (string) $this->get() );
	}
}
