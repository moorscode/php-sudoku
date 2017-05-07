<?php

namespace Sudoku;

class Loader {
	/**
	 * @param $game
	 *
	 * @return array|string|null
	 * @throws \Exception
	 */
	public function load( $game ) {
		$data = null;

		$path = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $game . '.php';
		if ( is_file( $path ) ) {
			$data = include $path;
		}

		if ( ! isset( $data ) && is_string( $game ) && strlen( $game ) > 81 ) {
			if ( strpos( $game, ',' ) !== false ) {
				$data = explode( ',', $game );
			} else {
				$data = str_split( $game );
			}
		}

		if ( ! isset($data ) ) {
			throw new \Exception( 'Game could not be found.' );
		}

		if ( ! is_array( $data[0] ) ) {
			$size = sqrt( count( $data ) );
			$data = array_chunk( $data, $size );
		}

		return $data;
	}
}
