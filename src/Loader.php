<?php

namespace Sudoku;

class Loader {
	/**
	 * @param $data
	 *
	 * @return array|string|null
	 * @throws \Exception
	 */
	public function load( $data ) {
		$path = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $data . '.php';
		if ( is_file( $path ) ) {
			$data = include $path;
		}

		$data = $this->parseData( $data );

		if ( empty( $data ) ) {
			throw new \Exception( 'Game could not be found.' );
		}

		if ( ! is_array( $data[0] ) ) {
			$size = sqrt( count( $data ) );
			$data = array_chunk( $data, $size );
		}

		return $data;
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	protected function parseData( $data ) {
		if ( is_string( $data ) && strlen( $data ) > 80 ) {
			if ( strpos( $data, ',' ) !== false ) {
				$data = explode( ',', $data );
			} else {
				$data = str_split( $data );
			}

			return $data;
		}

		if ( is_array( $data ) ) {
			return $data;
		}

		return null;
	}
}
