<?php

namespace Sudoku;

interface StatisticsInterface {
	public function register( $identifier, $displayFormat, $defaultValue = 0, callable $displayCallback = null );

	public function increase( $identifier );

	public function set( $identifier, $value );

	public function max( $identifier, $value );

	public function display();
}