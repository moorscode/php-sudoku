<?php

namespace Sudoku;

interface StatisticsInterface {
	public function register( $identifier, $displayFormat );

	public function increase( $identifier );

	public function set( $identifier, $value );

	public function display();
}