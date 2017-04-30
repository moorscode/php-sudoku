<?php

namespace Sudoku;

class Loader {
	public function load( $file ) {
		$path = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $file . '.php';
		if ( ! is_file( $path ) ) {
			throw new \InvalidArgumentException( 'File supplied does not exist.' );
		}

		return include $path;
	}
}
