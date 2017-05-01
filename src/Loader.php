<?php

namespace Sudoku;

class Loader {
	public function load( $file ) {
		$path = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $file . '.php';
		if ( ! is_file( $path ) ) {
			throw new \InvalidArgumentException( 'File supplied does not exist.' );
		}

		$data = include $path;

		if ( is_string( $data ) ) {
			if ( strpos( $data, ',' ) !== false ) {
			$data = explode( ',', $data );
			} else {
				$data = str_split( $data );
			}
		}

		if ( ! is_array( $data[0] ) ) {
			$size = sqrt( count( $data ) );
			$data = array_chunk( $data, $size );
		}

		return $data;
	}
}
