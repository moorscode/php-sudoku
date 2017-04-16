<?php

namespace Sudoku;

class HTMLDecorator {
	public function decorate( Board $board, $showOptions = true ) {

		$cells = $this->flip( $board->getBoard() );

		echo '<table border="1">';
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

				echo '<td>' . $data . '</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
	}

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