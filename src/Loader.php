<?php

namespace Sudoku;

class Loader {
	public function load( $data ) {
		$path = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $data . '.php';
		if ( is_file( $path ) ) {
			$data = include $path;
		}

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
