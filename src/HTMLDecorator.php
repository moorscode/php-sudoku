<?php

namespace Sudoku;

class HTMLDecorator {

	public function head() {
		echo <<<EO_HTML
<html>
<head>
<style>
html, body {
	padding: 0;
	margin: 0;
	font-size: 100%;
}
body {
	padding: 2em;
	font-family: Verdana;
	font-size: 1em;
}
</style>
</head>
<body>
EO_HTML;
	}

	public function toes() {
		echo <<<EO_HTML
</body>
</html>
EO_HTML;

	}

	/**
	 * @param BoardInterface $board
	 * @param bool           $showOptions
	 * @param array          $highlight
	 */
	public function decorate( BoardInterface $board, $showOptions = true, array $highlight = array() ) {

		$cells     = $this->flip( $board->getBoard() );
		$boardSize = $board->getSize();

		$groups    = sqrt( $boardSize );
		$groupSize = $boardSize / $groups;

		echo '<table style="border: 2px solid black; margin-bottom: 1em;" cellpadding="4" cellspacing="0">';
		foreach ( $cells as $x => $_x ) {
			echo '<tr>';
			/**
			 * @var Cell $cell
			 */
			foreach ( $_x as $y => $cell ) {
				$data = $cell->get();
				if ( ! $data && $showOptions ) {
					$options = $cell->getOptions();
					$data    = sprintf( '<em style="color: #aaa;">%s</em>', implode( ',', $options ) );
				}

				$border = 'border: 1px solid #ddd; min-width: 20px; text-align: center; min-height: 20px; vertical-align: middle;';

				if ( ( $x + 1 ) % $groupSize === 0 && $x + 1 < $boardSize ) {
					$border .= 'border-bottom: 2px solid black;';
				}
				if ( ( $y + 1 ) % $groupSize === 0 && $y + 1 < $boardSize ) {
					$border .= 'border-right: 2px solid black;';
				}

				if ( in_array( new Coords( $x, $y ), $highlight, false ) ) {
					$border .= 'font-weight: bold;';
				}

				printf( '<td style="%s">%s</td>', $border, $data );
			}
			echo '</tr>';
		}
		echo '</table>';
	}

	/**
	 * @param array $cells
	 *
	 * @return array
	 */
	protected function flip( array $cells ) {
		$output = [];
		foreach ( $cells as $x => $_x ) {
			foreach ( $_x as $y => $cell ) {
				$output[ $y ][ $x ] = $cell;
			}
		}

		return $output;
	}
}